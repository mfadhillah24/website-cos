<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'UKM-IT COS') — UKM-IT Cyber Open Source</title>
    <meta name="description" content="@yield('description', 'UKM-IT Cyber Open Source — Wadah mahasiswa untuk belajar, berkembang, dan berkolaborasi dalam bidang teknologi informasi dan open source.')">
    <meta name="robots" content="index, follow">

    {{-- FAVICON --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', 'UKM-IT COS') — UKM-IT Cyber Open Source">
    <meta property="og:description" content="@yield('description', 'Wadah mahasiswa untuk belajar, berkembang, dan berkolaborasi dalam bidang teknologi informasi dan open source.')">
    <meta property="og:type" content="website">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.png'))">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased text-gray-600 bg-bg-page flex flex-col min-h-screen page-transition-wrap"
      @if(isset($isHomePage) && $isHomePage) data-page="home" @endif>

    {{-- ============================================================
         NAVBAR
    ============================================================ --}}
    @php
        $orgLogo   = \App\Models\Setting::get('org_logo');
        $orgName   = \App\Models\Setting::get('org_name', 'UKM-IT COS');
        $instagram = \App\Models\Setting::get('social_instagram');
        $github    = \App\Models\Setting::get('social_github');
        $email     = \App\Models\Setting::get('social_email');
        $isTentangActive   = request()->routeIs('public.tentang') || request()->routeIs('public.organisasi') || request()->routeIs('public.divisi') || request()->routeIs('public.divisi.show');
        $isAktivitasActive = request()->routeIs('public.kegiatan') || request()->routeIs('public.kegiatan.show') || request()->routeIs('public.berita') || request()->routeIs('public.berita.show') || request()->routeIs('public.galeri');

        // ── Global countdown data (used by navbar preview on every page) ──
        $isHomePage = request()->routeIs('home');
        $globalUpcoming = \App\Models\Activity::where('status', 'published')
            ->where('start_date', '>=', \Illuminate\Support\Carbon::today()->toDateString())
            ->orderBy('start_date', 'asc')
            ->first();
        $globalTargetDt = null;
        $globalEndDt    = null;
        if ($globalUpcoming) {
            $globalTargetDt = \Illuminate\Support\Carbon::parse($globalUpcoming->start_date)->startOfDay()->toIso8601String();
            $globalEndDt    = $globalUpcoming->end_date
                ? \Illuminate\Support\Carbon::parse($globalUpcoming->end_date)->endOfDay()->toIso8601String()
                : null;
        }
    @endphp

    <nav class="pub-navbar" id="pub-navbar" role="navigation" aria-label="Navigasi utama"
         style="background:rgba(255,255,255,0.95)!important;backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);">
        <div class="section-container h-full flex items-center justify-between gap-4">

            {{-- Brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 no-underline shrink-0" aria-label="Beranda {{ $orgName }}">
                @if($orgLogo)
                    <img src="{{ asset('images/' . $orgLogo) }}" alt="Logo {{ $orgName }}" class="h-8 w-auto object-contain">
                @else
                    <img src="{{ asset('images/logo.png') }}" alt="Logo COS" class="h-8 w-auto object-contain">
                @endif
                <span class="text-xs sm:text-sm font-bold text-primary-navy tracking-tight leading-tight max-w-[140px] sm:max-w-none">{{ $orgName }}</span>
            </a>

            {{-- Navbar Event Preview (Countdown Morph) --}}
            {{-- Populated by JS from home.blade.php via window.COS_COUNTDOWN --}}
            <div id="navbar-event-preview"
                 class="navbar-event-preview"
                 aria-hidden="true"
                 aria-label="Kegiatan terdekat">

                {{-- Name: hidden on mobile, flex row on tablet, col line-1 on desktop --}}
                <span class="nep-name" id="nep-name"></span>

                {{-- Mid separator · — only tablet 768–1023px --}}
                <span class="nep-sep" aria-hidden="true">·</span>

                {{-- Sub-row: label (desktop only) + countdown (all) --}}
                <span class="nep-sub">
                    <span class="nep-label">Kegiatan Terdekat</span>
                    <span class="nep-label-sep" aria-hidden="true">·</span>
                    <span class="nep-cd" id="nep-cd"></span>
                </span>

            </div>

            {{-- Desktop Nav Links --}}
            <div class="hidden lg:flex items-center gap-0.5">

                <a href="{{ route('home') }}" class="nav-link-pub {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>

                {{-- Dropdown: Tentang --}}
                <div class="nav-dropdown-wrap" id="dropdown-tentang-wrap">
                    <button id="dropdown-tentang-btn"
                            class="nav-dropdown-trigger {{ $isTentangActive ? 'active' : '' }}"
                            aria-expanded="false" aria-haspopup="true" aria-controls="dropdown-tentang-panel" type="button">
                        Tentang
                        <svg class="chevron" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="4 6 8 10 12 6"/></svg>
                    </button>
                    <div id="dropdown-tentang-panel" class="nav-dropdown-panel" role="menu" aria-labelledby="dropdown-tentang-btn">
                        <a href="{{ route('public.tentang') }}" role="menuitem" class="nav-dropdown-item {{ request()->routeIs('public.tentang') ? 'active' : '' }}">
                            @if($orgLogo)
                                <img src="{{ asset('images/' . $orgLogo) }}" alt="Logo" class="nav-dropdown-logo">
                            @else
                                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="nav-dropdown-logo">
                            @endif
                            Tentang COS
                        </a>
                        <a href="{{ route('public.organisasi') }}" role="menuitem" class="nav-dropdown-item {{ request()->routeIs('public.organisasi') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Organisasi
                        </a>
                        <a href="{{ route('public.divisi') }}" role="menuitem" class="nav-dropdown-item {{ request()->routeIs('public.divisi') || request()->routeIs('public.divisi.show') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
                            Divisi
                        </a>
                    </div>
                </div>

                {{-- Dropdown: Aktivitas --}}
                <div class="nav-dropdown-wrap" id="dropdown-aktivitas-wrap">
                    <button id="dropdown-aktivitas-btn"
                            class="nav-dropdown-trigger {{ $isAktivitasActive ? 'active' : '' }}"
                            aria-expanded="false" aria-haspopup="true" aria-controls="dropdown-aktivitas-panel" type="button">
                        Aktivitas
                        <svg class="chevron" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="4 6 8 10 12 6"/></svg>
                    </button>
                    <div id="dropdown-aktivitas-panel" class="nav-dropdown-panel" role="menu" aria-labelledby="dropdown-aktivitas-btn">
                        <a href="{{ route('public.kegiatan') }}" role="menuitem" class="nav-dropdown-item {{ request()->routeIs('public.kegiatan') || request()->routeIs('public.kegiatan.show') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Kegiatan
                        </a>
                        <a href="{{ route('public.berita') }}" role="menuitem" class="nav-dropdown-item {{ request()->routeIs('public.berita') || request()->routeIs('public.berita.show') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            Berita
                        </a>
                        <a href="{{ route('public.galeri') }}" role="menuitem" class="nav-dropdown-item {{ request()->routeIs('public.galeri') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            Galeri
                        </a>
                    </div>
                </div>

                <a href="{{ route('public.kontak') }}" class="nav-link-pub {{ request()->routeIs('public.kontak') ? 'active' : '' }}">Kontak</a>

                <div class="ml-3 flex items-center gap-2">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn-secondary !py-1.5 !text-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link-pub">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary !py-1.5 !text-sm !rounded-lg">Daftar</a>
                    @endauth
                </div>
            </div>

            {{-- Mobile Hamburger --}}
            <button id="mobile-menu-btn"
                    class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-navy/20"
                    aria-label="Buka atau tutup menu navigasi"
                    aria-expanded="false"
                    aria-controls="mobile-menu-panel"
                    type="button">
                <div class="hamburger-icon" id="hamburger-icon" aria-hidden="true">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div>

        {{-- Mobile Navigation Panel --}}
        <div id="mobile-menu-panel" class="mobile-nav-panel lg:hidden">
            <div class="section-container py-3 pb-5 flex flex-col gap-1">

                <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>

                {{-- Accordion: Tentang --}}
                <div>
                    <button class="mobile-accordion-trigger"
                            id="mob-acc-tentang-btn"
                            aria-expanded="{{ $isTentangActive ? 'true' : 'false' }}"
                            aria-controls="mob-acc-tentang" type="button">
                        <span>Tentang</span>
                        <svg class="acc-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div id="mob-acc-tentang" class="mobile-accordion-content {{ $isTentangActive ? 'open' : '' }}">
                        <a href="{{ route('public.tentang') }}" class="mobile-accordion-item {{ request()->routeIs('public.tentang') ? 'active' : '' }} flex items-center gap-2">
                            @if($orgLogo)
                                <img src="{{ asset('images/' . $orgLogo) }}" alt="Logo" class="nav-dropdown-logo">
                            @else
                                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="nav-dropdown-logo">
                            @endif
                            Tentang COS
                        </a>
                        <a href="{{ route('public.organisasi') }}" class="mobile-accordion-item {{ request()->routeIs('public.organisasi') ? 'active' : '' }} flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Organisasi
                        </a>
                        <a href="{{ route('public.divisi') }}" class="mobile-accordion-item {{ request()->routeIs('public.divisi') || request()->routeIs('public.divisi.show') ? 'active' : '' }} flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
                            Divisi
                        </a>
                    </div>
                </div>

                {{-- Accordion: Aktivitas --}}
                <div>
                    <button class="mobile-accordion-trigger"
                            id="mob-acc-aktivitas-btn"
                            aria-expanded="{{ $isAktivitasActive ? 'true' : 'false' }}"
                            aria-controls="mob-acc-aktivitas" type="button">
                        <span>Aktivitas</span>
                        <svg class="acc-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div id="mob-acc-aktivitas" class="mobile-accordion-content {{ $isAktivitasActive ? 'open' : '' }}">
                        <a href="{{ route('public.kegiatan') }}" class="mobile-accordion-item {{ request()->routeIs('public.kegiatan') || request()->routeIs('public.kegiatan.show') ? 'active' : '' }} flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Kegiatan
                        </a>
                        <a href="{{ route('public.berita') }}" class="mobile-accordion-item {{ request()->routeIs('public.berita') || request()->routeIs('public.berita.show') ? 'active' : '' }} flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            Berita
                        </a>
                        <a href="{{ route('public.galeri') }}" class="mobile-accordion-item {{ request()->routeIs('public.galeri') ? 'active' : '' }} flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            Galeri
                        </a>
                    </div>
                </div>

                <a href="{{ route('public.kontak') }}" class="mobile-nav-link {{ request()->routeIs('public.kontak') ? 'active' : '' }}">Kontak</a>

                <div class="h-px bg-gray-100 my-2 mx-1"></div>

                <div class="flex gap-2 flex-wrap px-1 pb-1">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn-secondary flex-1 text-center !text-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary flex-1 text-center !text-sm">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary flex-1 text-center !text-sm">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="flex-grow pt-[68px]">
        @yield('content')
    </main>

    {{-- ============================================================
         FOOTER
    ============================================================ --}}
    <footer class="bg-white border-t border-gray-200 py-16 mt-20">
        <div class="section-container">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                {{-- Brand + Desc --}}
                <div class="lg:col-span-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 no-underline mb-4">
                        @if($orgLogo)
                            <img src="{{ asset('images/' . $orgLogo) }}" alt="{{ $orgName }}" class="h-8 object-contain">
                        @else
                            <img src="{{ asset('images/logo.png') }}" alt="Logo COS" class="h-8 object-contain">
                        @endif
                        <span class="font-bold text-gray-900">{{ $orgName }}</span>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-sm mb-6">
                        {{ \App\Models\Setting::get('org_description', 'Wadah mahasiswa untuk belajar, berkembang, dan berkolaborasi dalam bidang teknologi informasi dan open source.') }}
                    </p>
                    <div class="flex gap-3">
                        @if($instagram)
                        <a href="{{ $instagram }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:text-secondary-blue hover:border-secondary-blue hover:bg-secondary-blue/5 transition-all">
                            <x-lucide-instagram class="w-5 h-5" />
                        </a>
                        @endif
                        @if($github)
                        <a href="{{ $github }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:text-gray-900 hover:border-gray-900 hover:bg-gray-50 transition-all">
                            <x-lucide-github class="w-5 h-5" />
                        </a>
                        @endif
                        @if($email)
                        <a href="mailto:{{ $email }}" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:text-red-500 hover:border-red-500 hover:bg-red-50 transition-all">
                            <x-lucide-mail class="w-5 h-5" />
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Nav Links --}}
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Navigasi</h4>
                    <ul class="space-y-3">
                        @foreach([['label'=>'Tentang','href'=>route('public.tentang')],['label'=>'Organisasi','href'=>route('public.organisasi')],['label'=>'Divisi','href'=>route('public.divisi')],['label'=>'Kegiatan','href'=>route('public.kegiatan')],['label'=>'Berita','href'=>route('public.berita')],['label'=>'Galeri','href'=>route('public.galeri')],['label'=>'Kontak','href'=>route('public.kontak')]] as $fl)
                        <li><a href="{{ $fl['href'] }}" class="text-gray-500 hover:text-secondary-blue text-sm transition-colors">{{ $fl['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>

                {{-- Gabung --}}
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Bergabung</h4>
                    <p class="text-gray-500 text-sm mb-4">Tertarik bergabung bersama kami?</p>
                    <a href="{{ route('register') }}" class="btn-primary !py-2">Daftar Sekarang</a>
                </div>
            </div>

            {{-- Copyright --}}
            <div class="pt-8 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} {{ $orgName }}. All rights reserved.</p>
                <p class="text-gray-400 text-sm">Open Your Mind For The Future With Open Source</p>
            </div>
        </div>
    </footer>

    {{-- MINI TERMINAL (Floating) --}}
    <div id="cos-mini-terminal" class="cos-mini-terminal closed" aria-label="Mini Terminal" @if(request()->routeIs('home')) style="display: none;" @endif>
        <button class="cos-mini-terminal-toggle" id="mini-terminal-toggle" aria-label="Buka Terminal">
            <span class="icon">>_</span>
            <span class="text">COS</span>
        </button>
        <div class="cos-mini-terminal-window">
            <div class="cos-terminal-titlebar">
                <div class="dots">
                    <span class="dot dot-red"></span>
                    <span class="dot dot-yellow"></span>
                    <span class="dot dot-green"></span>
                </div>
                <span class="title-text">COS Terminal</span>
                <button class="close-btn" id="mini-terminal-close">&times;</button>
            </div>
            <div class="cos-terminal-body" id="mini-terminal-body">
                <!-- Engine will populate this -->
            </div>
        </div>
    </div>

    <script>
    (function () {
        'use strict';

        // ── Navbar scroll effect ──
        var navbar  = document.getElementById('pub-navbar');
        var ticking = false;
        function updateNav() {
            navbar.classList.toggle('scrolled', window.scrollY > 12);
            ticking = false;
        }
        window.addEventListener('scroll', function () {
            if (!ticking) { requestAnimationFrame(updateNav); ticking = true; }
        }, { passive: true });

        // ── Desktop dropdowns ──
        var dropPairs = [
            { btn: 'dropdown-tentang-btn',   panel: 'dropdown-aktivitas-panel' },
            { btn: 'dropdown-tentang-btn',   panel: 'dropdown-tentang-panel' },
            { btn: 'dropdown-aktivitas-btn', panel: 'dropdown-aktivitas-panel' }
        ];

        function closeAllDropdowns() {
            ['dropdown-tentang-btn','dropdown-aktivitas-btn'].forEach(function (id) {
                var b = document.getElementById(id);
                if (b) b.setAttribute('aria-expanded', 'false');
            });
            ['dropdown-tentang-panel','dropdown-aktivitas-panel'].forEach(function (id) {
                var p = document.getElementById(id);
                if (p) p.classList.remove('open');
            });
        }

        ['tentang','aktivitas'].forEach(function (key) {
            var btn   = document.getElementById('dropdown-' + key + '-btn');
            var panel = document.getElementById('dropdown-' + key + '-panel');
            if (!btn || !panel) return;
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                var wasOpen = panel.classList.contains('open');
                closeAllDropdowns();
                if (!wasOpen) {
                    btn.setAttribute('aria-expanded', 'true');
                    panel.classList.add('open');
                }
            });
        });

        document.addEventListener('click', closeAllDropdowns);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeAllDropdowns();
        });

        // ── Mobile menu ──
        var mobileBtn   = document.getElementById('mobile-menu-btn');
        var mobilePanel = document.getElementById('mobile-menu-panel');
        var hamIcon     = document.getElementById('hamburger-icon');

        mobileBtn.addEventListener('click', function () {
            var open = mobilePanel.classList.contains('open');
            mobilePanel.classList.toggle('open', !open);
            hamIcon.classList.toggle('open', !open);
            mobileBtn.setAttribute('aria-expanded', String(!open));
        });

        // ── Mobile accordion ──
        ['tentang','aktivitas'].forEach(function (key) {
            var btn = document.getElementById('mob-acc-' + key + '-btn');
            var con = document.getElementById('mob-acc-' + key);
            if (!btn || !con) return;
            btn.addEventListener('click', function () {
                var open = con.classList.contains('open');
                con.classList.toggle('open', !open);
                btn.setAttribute('aria-expanded', String(!open));
            });
        });

        // ── Navbar countdown preview init ──
        // Called by home.blade.php (or the global script below) after window.COS_COUNTDOWN is ready.
        window.initNavbarCountdown = function (countdown) {
            var navPreview = document.getElementById('navbar-event-preview');
            var nepName    = document.getElementById('nep-name');
            var nepCd      = document.getElementById('nep-cd');

            if (!navPreview || !nepCd) return;

            // Set event name once
            if (nepName && countdown.eventName) {
                nepName.textContent = countdown.eventName;
            }

            // Subscribe to countdown ticks — updates nep-cd on every second
            countdown.subscribe(function (state) {
                if (nepCd) {
                    nepCd.textContent = state.cdStr || '—';
                }
            });

            // Mark ready so scroll-morph JS can detect initialization
            navPreview.setAttribute('data-ready', 'true');
        };

        // ── Global navbar countdown (non-home pages) ──
        // On the home page, home.blade.php initialises COS_COUNTDOWN itself.
        // On every other page we initialise it here so the navbar preview ticks.
        @if(!$isHomePage && $globalUpcoming)
        (function () {
            var TARGET_ISO = @json($globalTargetDt);
            var END_ISO    = @json($globalEndDt);
            var EVENT_NAME = @json($globalUpcoming->title);
            var EVENT_SLUG = @json($globalUpcoming->slug);

            var targetMs = new Date(TARGET_ISO).getTime();
            var endMs    = END_ISO ? new Date(END_ISO).getTime() : null;

            function pad(n) { return n < 10 ? '0' + n : String(n); }
            function fmtCd(d, h, m, s) {
                if (d > 0) return d + 'd ' + pad(h) + 'h ' + pad(m) + 'm ' + pad(s) + 's';
                if (h > 0) return pad(h) + 'h ' + pad(m) + 'm ' + pad(s) + 's';
                return pad(m) + 'm ' + pad(s) + 's';
            }

            window.COS_COUNTDOWN = {
                eventName : EVENT_NAME,
                eventSlug : EVENT_SLUG,
                targetMs  : targetMs,
                endMs     : endMs,
                d: 0, h: 0, m: 0, s: 0,
                cdStr     : '',
                isOngoing : false,
                _subs     : [],
                subscribe : function (fn) {
                    this._subs.push(fn);
                    if (this.cdStr) fn(this);
                },
                _notify : function () {
                    var self = this;
                    this._subs.forEach(function (fn) { fn(self); });
                }
            };

            function tick() {
                var now  = Date.now();
                var diff = targetMs - now;

                if (diff <= 0) {
                    if (endMs && now < endMs) {
                        window.COS_COUNTDOWN.isOngoing = true;
                        window.COS_COUNTDOWN.cdStr     = 'Berlangsung';
                        window.COS_COUNTDOWN._notify();
                    }
                    return;
                }

                var total   = Math.floor(diff / 1000);
                var days    = Math.floor(total / 86400);
                var hours   = Math.floor((total % 86400) / 3600);
                var minutes = Math.floor((total % 3600) / 60);
                var seconds = total % 60;

                window.COS_COUNTDOWN.d     = days;
                window.COS_COUNTDOWN.h     = hours;
                window.COS_COUNTDOWN.m     = minutes;
                window.COS_COUNTDOWN.s     = seconds;
                window.COS_COUNTDOWN.cdStr = fmtCd(days, hours, minutes, seconds);
                window.COS_COUNTDOWN._notify();

                setTimeout(tick, 1000);
            }

            tick();

            // Connect to navbar preview
            if (typeof window.initNavbarCountdown === 'function') {
                window.initNavbarCountdown(window.COS_COUNTDOWN);
            }
        }());
        @endif

    }());
    </script>

    @stack('scripts')
</body>
</html>