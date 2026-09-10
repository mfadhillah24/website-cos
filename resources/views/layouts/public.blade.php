<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'UKM-IT COS') — UKM-IT Cyber Open Source</title>
    <meta name="description" content="@yield('description', 'UKM-IT Cyber Open Source — Wadah mahasiswa untuk belajar, berkembang, dan berkolaborasi dalam bidang teknologi informasi dan open source.')">
    <meta name="robots" content="index, follow">

    {{-- ============================================================
         FAVICON
    ============================================================ --}}
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
<body class="font-sans antialiased text-gray-600 bg-bg-page flex flex-col min-h-screen page-transition-wrap">

    {{-- NAVBAR --}}
    @php
        $orgLogo   = \App\Models\Setting::get('org_logo');
        $orgName   = \App\Models\Setting::get('org_name', 'UKM-IT COS');
        $instagram = \App\Models\Setting::get('social_instagram');
        $github    = \App\Models\Setting::get('social_github');
        $email     = \App\Models\Setting::get('social_email');
    @endphp

    <nav class="pub-navbar" id="pub-navbar">
        <div class="section-container h-full flex items-center justify-between">
            {{-- Brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 no-underline">
                @if($orgLogo)
                    <img src="{{ asset('images/' . $orgLogo) }}" alt="{{ $orgName }}" class="h-8 w-auto object-contain">
                @else
                    <div class="w-8 h-8 bg-white rounded flex items-center justify-center">
                        <x-lucide-layers class="w-5 h-5" />
                    </div>
                @endif
                <span class="text-base font-bold text-white tracking-tight">{{ $orgName }}</span>
            </a>

            {{-- Desktop Links --}}
            <div id="pub-nav-links" class="hidden lg:flex items-center gap-1">
                @php
                    $navLinks = [
                        ['href' => route('home'),              'label' => 'Beranda',   'route' => 'home'],
                        ['href' => route('public.tentang'),    'label' => 'Tentang',   'route' => 'public.tentang'],
                        ['href' => route('public.organisasi'), 'label' => 'Organisasi','route' => 'public.organisasi'],
                        ['href' => route('public.divisi'),     'label' => 'Divisi',    'route' => 'public.divisi'],
                        ['href' => route('public.kegiatan'),   'label' => 'Kegiatan',  'route' => 'public.kegiatan'],
                        ['href' => route('public.berita'),     'label' => 'Berita',    'route' => 'public.berita'],
                        ['href' => route('public.galeri'),     'label' => 'Galeri',    'route' => 'public.galeri'],
                        ['href' => route('public.kontak'),     'label' => 'Kontak',    'route' => 'public.kontak'],
                    ];
                @endphp

                @foreach($navLinks as $link)
                    @php $isActive = request()->routeIs($link['route']) || (isset($link['route_prefix']) && request()->routeIs($link['route_prefix'].'.*')); @endphp
                    <a href="{{ $link['href'] }}" class="nav-link-pub {{ $isActive ? 'active' : '' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach

                {{-- CTAs --}}
                <div class="ml-4 flex items-center gap-3">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn-secondary !py-1.5 !text-sm">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn-secondary !py-1.5 !text-sm">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Mobile Toggle --}}
            <button id="mobile-menu-btn" class="lg:hidden p-2 text-white" aria-label="Menu">
                <x-lucide-menu class="w-5 h-5" />
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden border-t border-white/10 bg-primary-navy shadow-lg">
            <div class="section-container py-4 flex flex-col gap-2">
                @foreach($navLinks as $link)
                    <a href="{{ $link['href'] }}" class="px-3 py-2 text-sm font-medium text-gray-300 hover:text-white rounded-md">
                        {{ $link['label'] }}
                    </a>
                @endforeach
                <div class="mt-4 flex gap-3 flex-wrap">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn-secondary flex-1 text-center">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary border border-white/20 flex-1 text-center">Login</a>
                        <a href="{{ route('register') }}" class="btn-secondary flex-1 text-center">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="flex-grow pt-[72px]">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-white border-t border-gray-200 py-16 mt-20">
        <div class="section-container">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                {{-- Brand + Desc --}}
                <div class="lg:col-span-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 no-underline mb-4">
                        @if($orgLogo)
                            <img src="{{ asset('images/' . $orgLogo) }}" alt="{{ $orgName }}" class="h-8 object-contain">
                        @else
                            <div class="w-8 h-8 bg-primary-navy rounded flex items-center justify-center">
                                <x-lucide-layers class="w-5 h-5" />
                            </div>
                        @endif
                        <span class="font-bold text-gray-900">{{ $orgName }}</span>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-sm mb-6">
                        {{ \App\Models\Setting::get('org_description', 'Wadah mahasiswa untuk belajar, berkembang, dan berkolaborasi dalam bidang teknologi informasi dan open source.') }}
                    </p>
                    {{-- Social Media --}}
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

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('pub-navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>
