@extends('layouts.public')

@section('title', 'Beranda')

@section(
    'description',
    'UKM-IT Cyber Open Source — Wadah mahasiswa untuk belajar, berkembang, dan berkolaborasi dalam bidang teknologi informasi dan open source.'
)

@section('content')

{{-- ============================================================
    HERO — BACKGROUND SLIDESHOW + INTERACTIVE TERMINAL
============================================================ --}}
<style>
    /* ── Hero Slideshow ── */
    #hero-section {
        min-height: 90vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    /* Fallback gradient when no photos in heroheader folder */
    #hero-section.hero-fallback {
        background: linear-gradient(-45deg, #FFFFFF 0%, #EAF3FF 20%, #FFFFFF 40%, rgba(30,136,229,0.03) 50%, #DCEBFF 60%, #FFFFFF 80%, rgba(7,26,82,0.015) 90%, #FFFFFF 100%);
        background-size: 400% 400%;
        animation: soft-gradient-flow 25s ease-in-out infinite;
    }
    @keyframes soft-gradient-flow {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Slides */
    .hero-slide {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        opacity: 0;
        transition: opacity 1.8s ease-in-out;
        z-index: 0;
        will-change: opacity;
    }
    .hero-slide.active {
        opacity: 0.3;
    }

    /* Reduced motion: disable crossfade animation */
    @media (prefers-reduced-motion: reduce) {
        .hero-slide {
            transition: none !important;
        }
        #hero-section.hero-fallback {
            animation: none !important;
            background-position: 0% 50% !important;
        }
    }
</style>

<section id="hero-section" class="{{ empty($heroSlideshowPhotos) ? 'hero-fallback' : '' }}" aria-label="Hero Section">

    @if(!empty($heroSlideshowPhotos))
        {{-- ── z-0: Background Slideshow ── --}}
        <div id="hero-slideshow" class="absolute inset-0 z-0 overflow-hidden bg-white" aria-hidden="true">
            @foreach($heroSlideshowPhotos as $index => $photoUrl)
                <div class="hero-slide {{ $index === 0 ? 'active' : '' }}"
                     style="background-image: url('{{ $photoUrl }}');"
                     data-src="{{ $photoUrl }}">
                </div>
            @endforeach
        </div>

        {{-- ── z-[1]: White Transparent Overlay ── --}}
        {{-- Mobile: solid white ~50%  |  Desktop: gradient white 70%→50%→30% --}}
        <div class="absolute inset-0 z-[1] pointer-events-none
                    bg-white/50
                    sm:bg-white/45
                    lg:bg-gradient-to-r
                    lg:from-white/70
                    lg:via-white/50
                    lg:to-white/30"
             aria-hidden="true">
        </div>

        {{-- ── z-[2]: Subtle bottom-fade for smooth section blending ── --}}
        <div class="absolute bottom-0 left-0 right-0 h-24 z-[2] pointer-events-none
                    bg-gradient-to-b from-transparent to-white/5"
             aria-hidden="true">
        </div>
    @endif




    <div class="section-container relative z-10 w-full py-20 md:py-24 lg:py-28">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 xl:gap-16 items-center">

            {{-- ── LEFT: Identity + CTA ── --}}
            <div class="order-1">

                {{-- Eyebrow Badge --}}
                <div class="reveal fade-up inline-flex items-center gap-2 mb-8
                            py-1.5 px-4 rounded-full
                            bg-white/80 border border-primary-navy/10
                            backdrop-blur-sm shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-secondary-blue animate-pulse"></span>
                    <span class="text-xs font-semibold text-primary-navy tracking-widest uppercase">
                        #BRAVOCOS
                    </span>
                </div>

                {{-- Heading --}}
                <h1 class="reveal fade-up delay-75 tracking-tight leading-[1.12] mb-6">

                    <span class="block text-4xl md:text-5xl lg:text-[3.4rem] font-extrabold text-primary-navy">
                        UKM-IT<br>
                        <span class="text-secondary-blue">Cyber Open Source</span>
                    </span>

                    <br>

                    <span class="block text-lg md:text-xl font-semibold text-gray-700 mb-1">
                        <i>Open Your Mind For The Future With Open Source</i>
                    </span>

                </h1>

                {{-- Description --}}
                <p class="reveal fade-up delay-150 max-w-lg mb-10 text-base leading-relaxed text-gray-700">
                    Wadah bagi mahasiswa untuk belajar teknologi, mengembangkan kreativitas,
                    membangun kolaborasi, dan menciptakan solusi digital melalui semangat Open Source.
                </p>

                {{-- CTA Buttons --}}
                <div class="reveal fade-up delay-200 flex flex-wrap items-center gap-3">

                    <a href="{{ route('public.kegiatan') }}" class="btn-hero-primary">

                        <svg width="16" height="16" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>

                        Lihat Kegiatan

                    </a>

                    <a href="{{ route('register') }}" class="btn-hero-secondary">

                        Daftar Sekarang

                        <svg width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <polyline points="9 18 15 12 9 6"/>
                        </svg>

                    </a>

                </div>

                {{-- Instagram Link --}}
                @php
                    $instagram = \App\Models\Setting::get('social_instagram') ?: 'https://instagram.com/cyberopensource';
                    $igUsername = '@' . trim(parse_url($instagram, PHP_URL_PATH), '/');
                @endphp
                <div class="reveal fade-up delay-300 mt-8">
                    <div class="flex items-center gap-3">
                        <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" 
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/40 border border-gray-300 shadow-sm text-sm font-medium text-gray-700 hover:text-primary-navy hover:bg-white/80 hover:border-primary-navy/40 hover:shadow-md transition-all duration-300 group focus:outline-none focus:ring-2 focus:ring-primary-navy/50 backdrop-blur-md">
                            <x-lucide-instagram class="w-4 h-4 group-hover:scale-110 transition-transform duration-300" />
                            <span>{{ $igUsername }}</span>
                        </a>
                    </div>
                </div>

            </div>


            {{-- ── RIGHT: Interactive Linux Terminal ── --}}
            <div class="order-2 relative hidden lg:flex items-center justify-center"
                 id="terminal-parallax-wrap">

                {{-- Terminal --}}
                <div class="cos-terminal w-full max-w-[460px]"
                     id="cos-terminal"
                     aria-label="Terminal interaktif COS"
                     aria-live="polite">

                    {{-- Title Bar --}}
                    <div class="cos-terminal-titlebar">

                        <span class="dot dot-red" aria-hidden="true"></span>
                        <span class="dot dot-yellow" aria-hidden="true"></span>
                        <span class="dot dot-green" aria-hidden="true"></span>

                        <span class="title-text">
                            cos@unitama — bash
                        </span>

                    </div>


                    {{-- COS Logo inside terminal --}}
                    <div class="cos-terminal-logo">

                        @if(\App\Models\Setting::get('org_logo'))

                            <img
                                src="{{ asset('images/' . \App\Models\Setting::get('org_logo')) }}"
                                alt="Logo Cyber Open Source"
                                class="cos-terminal-logo-img"
                                style="width:64px;height:auto;object-fit:contain;filter:drop-shadow(0 0 12px rgba(30,136,229,0.5));opacity:0.9;"
                            >

                        @else

                            <img
                                src="{{ asset('images/logo.png') }}"
                                alt="Logo Cyber Open Source"
                                style="width:64px;height:auto;object-fit:contain;filter:drop-shadow(0 0 12px rgba(30,136,229,0.5));opacity:0.9;"
                            >

                        @endif

                    </div>


                    {{-- Terminal Body --}}
                    <div
                        class="cos-terminal-body"
                        id="terminal-body"
                        aria-label="Output terminal">
                        <!-- TerminalEngine will populate this -->
                    </div>

                </div>

            </div>

        </div>
    </div>

</section>


@push('scripts')
<script>
// Typewriter script removed in favor of TerminalEngine
</script>
@endpush



{{-- ============================================================
    KEGIATAN MENDATANG — COMPACT COUNTDOWN CARD
============================================================ --}}
<section class="relative py-12 md:py-14 overflow-hidden bg-[#F8FAFC]"
         id="upcoming-section"
         aria-labelledby="upcoming-heading">

    {{-- Subtle dot-grid background --}}
    <div
        class="absolute inset-0 pointer-events-none"
        style="background-image: radial-gradient(circle, rgba(30,136,229,0.12) 1px, transparent 1px);
               background-size: 26px 26px;
               opacity: 0.55;">
    </div>


    {{-- Soft blue radial glow --}}
    <div
        class="absolute top-1/2 left-1/2
               -translate-x-1/2 -translate-y-1/2
               w-[520px] h-[260px]
               pointer-events-none"
        style="background: radial-gradient(ellipse, rgba(30,136,229,0.10) 0%, transparent 68%);
               filter: blur(36px);">
    </div>


    <div
        class="section-container
               relative z-10
               flex flex-col
               items-center
               text-center">


        {{-- ── Badge ── --}}
        <div
            class="inline-flex items-center gap-1.5
                   px-3.5 py-1
                   rounded-full
                   bg-secondary-blue/8
                   border border-secondary-blue/20
                   text-secondary-blue
                   text-[11px]
                   font-bold
                   tracking-[0.12em]
                   uppercase
                   mb-4">

            <svg
                width="12"
                height="12"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true">

                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>

            </svg>

            Kegiatan Terdekat

        </div>


        {{-- ── Section Heading ── --}}
        <h2
            id="upcoming-heading"
            class="text-2xl md:text-[1.75rem]
                   font-bold
                   text-primary-navy
                   tracking-tight
                   mb-6">

            Agenda COS Selanjutnya

        </h2>


        @if($upcomingActivity)

            @php

                // Build ISO 8601 target datetime
                $targetDt =
                    \Illuminate\Support\Carbon::parse(
                        $upcomingActivity->start_date
                    )
                    ->startOfDay()
                    ->toIso8601String();


                $endDt = null;

                if ($upcomingActivity->end_date) {

                    $endDt =
                        \Illuminate\Support\Carbon::parse(
                            $upcomingActivity->end_date
                        )
                        ->endOfDay()
                        ->toIso8601String();

                }


                // Server-side status
                $startCarbon =
                    \Illuminate\Support\Carbon::parse(
                        $upcomingActivity->start_date
                    )
                    ->startOfDay();


                $endCarbon =
                    $upcomingActivity->end_date
                        ? \Illuminate\Support\Carbon::parse(
                            $upcomingActivity->end_date
                          )->endOfDay()
                        : null;


                $serverStatus = 'upcoming';


                if ($now->greaterThanOrEqualTo($startCarbon)) {

                    if (
                        $endCarbon &&
                        $now->lessThanOrEqualTo($endCarbon)
                    ) {

                        $serverStatus = 'ongoing';

                    } elseif (!$endCarbon) {

                        $serverStatus =
                            $now->isSameDay($startCarbon)
                                ? 'ongoing'
                                : 'done';

                    } else {

                        $serverStatus = 'done';

                    }

                }


                // Format date range
                $dateRange =
                    $upcomingActivity->start_date
                    ->translatedFormat('d F Y');


                if (
                    $upcomingActivity->end_date &&
                    !$upcomingActivity->start_date
                        ->isSameDay(
                            $upcomingActivity->end_date
                        )
                ) {

                    $dateRange .=
                        ' — ' .
                        $upcomingActivity->end_date
                            ->translatedFormat('d F Y');

                }

            @endphp


            {{-- ── Activity Info ── --}}
            <div class="mb-5 max-w-lg">

                {{-- Activity Title --}}
                <h3
                    class="text-xl md:text-2xl
                           font-extrabold
                           text-primary-navy
                           tracking-tight
                           mb-2
                           uppercase">

                    {{ $upcomingActivity->title }}

                </h3>


                {{-- Date --}}
                <p
                    class="text-sm md:text-base
                           font-bold
                           text-secondary-blue
                           uppercase
                           tracking-[0.08em]
                           mb-2">

                    {{ $dateRange }}

                </p>


                {{-- Location --}}
                @if($upcomingActivity->location)

                    <p
                        class="inline-flex items-center justify-center
                               gap-2
                               text-sm md:text-base
                               font-semibold
                               text-slate-600
                               leading-relaxed">

                        <svg
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="shrink-0 text-secondary-blue"
                            aria-hidden="true">

                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>

                        </svg>

                        <span>
                            {{ $upcomingActivity->location }}
                        </span>

                    </p>

                @endif

            </div>


            @if($serverStatus === 'ongoing')

                {{-- ── ONGOING STATE ── --}}
                <div
                    class="inline-flex items-center gap-2.5
                           px-5 py-2.5
                           rounded-full
                           bg-emerald-50
                           border border-emerald-200">

                    <span
                        class="w-2 h-2
                               rounded-full
                               bg-emerald-500
                               animate-pulse">
                    </span>

                    <span
                        class="text-emerald-700
                               font-semibold
                               text-sm
                               tracking-wide">

                        Kegiatan Sedang Berlangsung

                    </span>

                </div>


            @elseif($serverStatus === 'upcoming')

                {{-- ── COUNTDOWN CARD ── --}}
                <div
                    id="countdown-wrap"
                    class="mt-2
                           w-full max-w-[520px]
                           bg-white
                           border border-[#E2E8F0]
                           rounded-2xl
                           shadow-sm shadow-slate-100
                           px-6 py-5
                           mb-5">

                    {{-- Numbers row --}}
                    <div
                        class="flex items-start
                               justify-center
                               gap-0">

                        @foreach([
                            [
                                'id' => 'cd-days',
                                'label' => 'Hari'
                            ],
                            [
                                'id' => 'cd-hours',
                                'label' => 'Jam'
                            ],
                            [
                                'id' => 'cd-minutes',
                                'label' => 'Menit'
                            ],
                            [
                                'id' => 'cd-seconds',
                                'label' => 'Detik'
                            ],
                        ] as $unit)

                            <div
                                class="flex flex-col
                                       items-center
                                       px-3 sm:px-4 md:px-5">

                                <span
                                    id="{{ $unit['id'] }}"
                                    class="text-[2.25rem]
                                           sm:text-[2.6rem]
                                           md:text-[3rem]
                                           font-extrabold
                                           text-primary-navy
                                           tabular-nums
                                           leading-none"
                                    aria-live="polite"
                                    aria-atomic="true">

                                    --

                                </span>

                                <span
                                    class="mt-1.5
                                           text-[10px]
                                           font-bold
                                           uppercase
                                           tracking-[0.14em]
                                           text-slate-400">

                                    {{ $unit['label'] }}

                                </span>

                            </div>


                            @if(!$loop->last)

                                <span
                                    class="text-[2rem]
                                           font-light
                                           text-slate-200
                                           mt-0.5
                                           leading-none
                                           select-none"
                                    aria-hidden="true">

                                    :

                                </span>

                            @endif

                        @endforeach

                    </div>

                </div>


                {{-- ── CTA ── --}}
               <a href="{{ route('public.kegiatan.show', $upcomingActivity->slug) }}"
   class="inline-flex items-center gap-1.5
          px-5 py-2.5 rounded-xl
          border border-secondary-blue/30 bg-white
          text-secondary-blue text-sm font-semibold
          hover:bg-secondary-blue hover:text-white hover:border-secondary-blue
          transition-all duration-200 shadow-sm">
    Lihat Detail Kegiatan
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="2.5"
         stroke-linecap="round" stroke-linejoin="round"
         aria-hidden="true">
        <polyline points="9 18 15 12 9 6"/>
    </svg>
</a>



                {{-- Client-side countdown + Scroll Morph --}}
                @push('scripts')
                <script>
                (function () {
                    'use strict';

                    // ═══════════════════════════════════════════════
                    // SHARED COUNTDOWN STATE — single timer, one source
                    // ═══════════════════════════════════════════════

                    var TARGET_ISO = @json($targetDt);
                    var END_ISO    = @json($endDt);

                    var targetMs = new Date(TARGET_ISO).getTime();
                    var endMs    = END_ISO ? new Date(END_ISO).getTime() : null;

                    // Expose shared state so navbar (and any other subscriber)
                    // can read and react without running a second timer.
                    window.COS_COUNTDOWN = {
                        eventName : @json($upcomingActivity->title),
                        targetMs  : targetMs,
                        endMs     : endMs,
                        d: 0, h: 0, m: 0, s: 0,
                        cdStr     : '',        // formatted for navbar compact display
                        isOngoing : false,
                        _subs     : [],
                        subscribe : function (fn) {
                            this._subs.push(fn);
                            // Immediately notify with current state if already ticking
                            if (this.cdStr) fn(this);
                        },
                        _notify   : function () {
                            var self = this;
                            this._subs.forEach(function (fn) { fn(self); });
                        }
                    };

                    // ── DOM refs ──
                    var elDays    = document.getElementById('cd-days');
                    var elHours   = document.getElementById('cd-hours');
                    var elMinutes = document.getElementById('cd-minutes');
                    var elSeconds = document.getElementById('cd-seconds');
                    var wrap      = document.getElementById('countdown-wrap');


                    function pad(n) {
                        return n < 10 ? '0' + n : String(n);
                    }


                    // Compact format for navbar (e.g. "12d 08h 43m 12s" or "43m 21s")
                    function formatNavCd(d, h, m, s) {
                        if (d > 0) return d + 'd ' + pad(h) + 'h ' + pad(m) + 'm ' + pad(s) + 's';
                        if (h > 0) return pad(h) + 'h ' + pad(m) + 'm ' + pad(s) + 's';
                        return pad(m) + 'm ' + pad(s) + 's';
                    }


                    function showOngoing() {

                        if (!wrap) return;

                        wrap.innerHTML =
                            '<div class="inline-flex items-center gap-2.5 px-5 py-2.5 rounded-full' +
                            ' bg-emerald-50 border border-emerald-200">' +

                            '<span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>' +

                            '<span class="text-emerald-700 font-semibold text-sm tracking-wide">' +

                            'Kegiatan Sedang Berlangsung' +

                            '</span>' +

                            '</div>';

                    }


                    function tick() {

                        var now  = Date.now();
                        var diff = targetMs - now;


                        if (diff <= 0) {

                            if (endMs && now < endMs) {
                                showOngoing();
                                // Notify navbar that event is ongoing
                                window.COS_COUNTDOWN.isOngoing = true;
                                window.COS_COUNTDOWN.cdStr     = 'Berlangsung';
                                window.COS_COUNTDOWN._notify();
                            }

                            return;
                        }


                        var totalSec = Math.floor(diff / 1000);
                        var days     = Math.floor(totalSec / 86400);
                        var hours    = Math.floor((totalSec % 86400) / 3600);
                        var minutes  = Math.floor((totalSec % 3600) / 60);
                        var seconds  = totalSec % 60;


                        // ── Update section countdown elements ──
                        if (elDays)    elDays.textContent    = pad(days);
                        if (elHours)   elHours.textContent   = pad(hours);
                        if (elMinutes) elMinutes.textContent = pad(minutes);
                        if (elSeconds) elSeconds.textContent = pad(seconds);


                        // ── Update shared countdown state ──
                        window.COS_COUNTDOWN.d     = days;
                        window.COS_COUNTDOWN.h     = hours;
                        window.COS_COUNTDOWN.m     = minutes;
                        window.COS_COUNTDOWN.s     = seconds;
                        window.COS_COUNTDOWN.cdStr = formatNavCd(days, hours, minutes, seconds);
                        window.COS_COUNTDOWN._notify();


                        setTimeout(tick, 1000);

                    }


                    // Start timer
                    tick();


                    // ── Connect to navbar preview ──
                    // window.initNavbarCountdown is defined in layouts/public.blade.php.
                    // It subscribes to window.COS_COUNTDOWN without running a second timer.
                    if (typeof window.initNavbarCountdown === 'function') {
                        window.initNavbarCountdown(window.COS_COUNTDOWN);
                    }


                    // ═══════════════════════════════════════════════
                    // SCROLL MORPH — countdown section → navbar preview
                    // ═══════════════════════════════════════════════

                    var section    = document.getElementById('upcoming-section');
                    var cdWrap     = document.getElementById('countdown-wrap');
                    var navPreview = document.getElementById('navbar-event-preview');

                    if (!section || !cdWrap || !navPreview) return;

                    var prefersRM = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                    var ticking   = false;


                    // Quadratic ease-out: fast start, smooth stop
                    function easeOut(t) {
                        return 1 - (1 - t) * (1 - t);
                    }


                    function getScrollProgress() {
                        var rect    = section.getBoundingClientRect();
                        var viewH   = window.innerHeight;
                        var navH    = 68;

                        // ── Morph zones ──
                        // Zone start: section.bottom at 62% of viewport (section still mostly in view)
                        // Zone end:   section.bottom just clears the navbar (section gone)
                        var morphStart = viewH * 0.62;
                        var morphEnd   = navH + 16;

                        if (morphStart <= morphEnd) return 0;

                        var raw = 1 - (rect.bottom - morphEnd) / (morphStart - morphEnd);
                        return Math.max(0, Math.min(1, raw));
                    }


                    function applyMorph(progress) {

                        if (prefersRM) {
                            // Reduced motion: binary crossfade at 50% threshold
                            var past = progress >= 0.5;
                            // navPreview.style.opacity = past ? '1' : '0';
                            cdWrap.style.opacity     = past ? '0' : '1';
                            cdWrap.style.transform   = '';
                            // navPreview.style.transform = '';
                            return;
                        }

                        var isMobile  = window.innerWidth < 768;

                        // ── Countdown card (section): fade + translateY + subtle scale ──
                        // Starts fading at 30% progress, fully gone at 100%
                        var cdOpacity = progress < 0.30 ? 1 : Math.max(0, 1 - (progress - 0.30) / 0.70);
                        var cdScale   = 1 - progress * 0.04;                   // max 4% shrink
                        var cdTransY  = isMobile ? -progress * 6 : -progress * 12;  // moves up

                        cdWrap.style.opacity   = cdOpacity.toFixed(3);
                        cdWrap.style.transform =
                            'translateY(' + cdTransY.toFixed(1) + 'px)' +
                            ' scale(' + cdScale.toFixed(3) + ')';

                        // ── Navbar preview: selalu tampil dari awal ──
                        // Kode di bawah dikomentari agar countdown di navbar selalu muncul tanpa perlu scroll
                        /*
                        var navRaw  = progress < 0.45 ? 0 : (progress - 0.45) / 0.55;
                        var navProg = Math.min(1, navRaw);
                        var easedP  = easeOut(navProg);

                        // Mobile: subtler translate (4px vs 8px)
                        var maxTransY = isMobile ? 4 : 8;
                        var navTransY = (1 - easedP) * -maxTransY;

                        navPreview.style.opacity   = easedP.toFixed(3);
                        navPreview.style.transform =
                            'translateY(' + navTransY.toFixed(1) + 'px)';
                        */
                        
                        // Set tampilan navbar agar tetap penuh
                        navPreview.style.opacity = '1';
                        navPreview.style.transform = 'translateY(0)';
                    }


                    function onScroll() {
                        if (ticking) return;
                        ticking = true;
                        requestAnimationFrame(function () {
                            ticking = false;
                            applyMorph(getScrollProgress());
                        });
                    }


                    window.addEventListener('scroll', onScroll, { passive: true });

                    // Initial render (handles page load at mid-scroll on refresh)
                    applyMorph(getScrollProgress());

                }());
                </script>
                @endpush



            @else

                {{-- Done state --}}
                <p class="text-sm text-gray-400">
                    Kegiatan telah selesai dilaksanakan.
                </p>

            @endif


        @else

            {{-- ── EMPTY STATE ── --}}
            <div
                class="flex flex-col
                       items-center
                       gap-3
                       py-4">

                <div
                    class="inline-flex items-center
                           justify-center
                           w-12 h-12
                           rounded-full
                           bg-secondary-blue/8
                           border border-secondary-blue/15">

                    <svg
                        width="20"
                        height="20"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="text-secondary-blue/50"
                        aria-hidden="true">

                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>

                    </svg>

                </div>

                <p class="text-sm font-medium text-gray-400">
                    Belum ada kegiatan mendatang.
                </p>

                <a
                    href="{{ route('public.kegiatan') }}"
                    class="inline-flex items-center gap-1
                           text-xs font-semibold
                           text-secondary-blue
                           hover:underline
                           underline-offset-2
                           transition-colors">

                    Lihat semua kegiatan

                    <svg
                        width="11"
                        height="11"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true">

                        <polyline points="9 18 15 12 9 6"/>

                    </svg>

                </a>

            </div>

        @endif

    </div>
</section>



{{-- ============================================================
    SAMBUTAN KETUA UMUM
============================================================ --}}
@if($ketuaUmum)

    @php

        $member = $ketuaUmum->member;

        $sambutan =
            \App\Models\Setting::get(
                'ketua_sambutan',
                ''
            );

    @endphp


   <section class="relative overflow-hidden bg-[#F8FAFC] pt-0 pb-14 md:pb-16">

        <div
            class="max-w-6xl mx-auto
                   px-4 sm:px-6 lg:px-8">


            {{-- Header --}}
            <div class="mb-10 text-center">

                <span
                    class="inline-flex items-center gap-2
                           px-4 py-1.5 mb-4
                           rounded-full
                           border border-slate-200
                           bg-white
                           text-slate-800
                           text-xs font-bold
                           tracking-wider uppercase
                           shadow-sm">

                    <x-lucide-message-circle
                        class="w-4 h-4 text-blue-600"
                    />

                    Sambutan Ketua Umum

                </span>


                <h2
                    class="text-3xl md:text-4xl
                           font-extrabold
                           tracking-tight
                           text-[#0F2B5B]">

                    Selamat Datang di UKM-IT COS

                </h2>

            </div>


            {{-- Main Layout --}}
            <div
                class="flex flex-col
                       lg:flex-row
                       items-center
                       justify-center
                       gap-8 lg:gap-12">


                {{-- Profile Card --}}
                <div
                    class="relative
                           w-full
                           max-w-[320px]
                           shrink-0">


                    {{-- Decorative Shapes --}}
                    <div
                        class="absolute
                               -bottom-6 -left-6
                               w-44 h-44
                               rounded-full
                               bg-slate-200/60
                               pointer-events-none
                               -z-10">
                    </div>


                    <div
                        class="absolute
                               -top-6 -right-6
                               w-44 h-44
                               rounded-full
                               bg-slate-200/60
                               pointer-events-none
                               -z-10">
                    </div>


                    {{-- Card --}}
                    <div
                        class="relative z-10
                               w-full
                               rounded-3xl
                               bg-white
                               p-6
                               text-center
                               shadow-xl
                               shadow-slate-200/80">


                        {{-- Photo --}}
                        <div
                            class="relative flex
                                   w-full
                                   justify-center">

                            @if($member && $member->photo)

                                <div
                                    class="relative
                                           w-full
                                           h-[300px]
                                           overflow-hidden
                                           rounded-2xl
                                           bg-slate-100">

                                    <img
                                        src="{{ asset('images/' . $member->photo) }}"
                                        alt="{{ $member->name }}"
                                        class="w-full h-full
                                               object-cover
                                               object-center"
                                    >


                                    {{-- Photo Overlay --}}
                                    <div
                                        class="absolute inset-0
                                               bg-gradient-to-t
                                               from-black/10
                                               via-transparent
                                               to-transparent
                                               pointer-events-none">
                                    </div>


                                    {{-- Quote Badge --}}
                                    <div
                                        class="absolute
                                               top-3 right-3
                                               flex
                                               h-11 w-11
                                               items-center
                                               justify-center
                                               rounded-full
                                               border-2 border-white
                                               bg-[#0F2B5B]
                                               text-white
                                               shadow-lg">

                                        <svg
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="currentColor">

                                            <path
                                                d="M7.17 17H4.5A2.5 2.5 0 0 1 2 14.5V9A5 5 0 0 1 7 4h.5v3H7a2 2 0 0 0-2 2v1h2.17A2.83 2.83 0 0 1 10 12.83v1.34A2.83 2.83 0 0 1 7.17 17Zm10 0H14.5a2.5 2.5 0 0 1-2.5-2.5V9a5 5 0 0 1 5-5h.5v3H17a2 2 0 0 0-2 2v1h2.17A2.83 2.83 0 0 1 20 12.83v1.34A2.83 2.83 0 0 1 17.17 17Z">
                                            </path>

                                        </svg>

                                    </div>

                                </div>

                            @else

                                <div
                                    class="flex
                                           w-full
                                           h-[300px]
                                           items-center
                                           justify-center
                                           rounded-2xl
                                           bg-slate-100">

                                    <x-lucide-user
                                        class="w-20 h-20
                                               text-slate-300"
                                    />

                                </div>

                            @endif

                        </div>


                        {{-- Identity --}}
                        <div
                            class="px-4
                                   pt-7
                                   pb-5
                                   text-center">

                            <h3
                                class="mb-3
                                       text-xl md:text-2xl
                                       font-extrabold
                                       leading-tight
                                       tracking-tight
                                       text-[#0F2B5B]">

                                {{ $member->name ?? 'Kasfillah' }}

                            </h3>


                            <p
                                class="text-sm
                                       font-semibold
                                       leading-normal
                                       text-slate-600">

                                {{ $ketuaUmum->position->name ?? 'Ketua Umum' }}

                            </p>


                            <p
                                class="mt-2
                                       text-xs
                                       font-medium
                                       leading-relaxed
                                       text-slate-400">

                                UKM-IT Cyber Open Source

                            </p>

                        </div>

                    </div>

                </div>


                {{-- Speech Card --}}
                <div
                    class="w-full
                           flex-1">

                    <div
                        class="flex
                               min-h-[280px]
                               flex-col
                               justify-center
                               rounded-3xl
                               border-[2.5px]
                               border-[#0F2B5B]
                               bg-white
                               p-6 sm:p-8 md:p-10
                               shadow-sm">

                        <div
                            class="space-y-4
                                   text-justify
                                   text-sm md:text-base
                                   leading-relaxed
                                   text-slate-600">

                            @if($sambutan)

                                @foreach(
                                    explode("\n", $sambutan)
                                    as $paragraph
                                )

                                    @if(trim($paragraph) !== '')

                                        <p>
                                            {{ trim($paragraph) }}
                                        </p>

                                    @endif

                                @endforeach

                            @else

                                <p class="italic text-slate-400">

                                    Sambutan Ketua Umum belum tersedia.
                                    Silakan isi melalui menu Settings pada panel admin.

                                </p>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endif



{{-- ============================================================
    STATISTIK
============================================================ --}}
<section class="bg-bg-page py-12 md:py-16">

    <div class="section-container">

        {{-- Header --}}
        <div
            class="reveal fade-up
                   mb-8
                   text-center
                   md:mb-10">

            <h2
                class="mt-2
                       text-3xl md:text-4xl
                       font-bold
                       text-primary-navy">

                Statistik

            </h2>

            <p
                class="mx-auto mt-2
                       max-w-xl
                       text-sm
                       text-gray-500">

                Gambaran singkat perkembangan dan aktivitas UKM-IT Cyber Open Source.

            </p>

        </div>


        @php

            $statsData = [

                [
                    'value' => $stats['members'] ?? 0,
                    'label' => 'Total Anggota',
                    'description' => 'Anggota terdaftar',
                    'color' => 'text-secondary-blue',
                    'bg' => 'bg-blue-50',
                    'border' => 'border-blue-100',
                    'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
                ],

                [
                    'value' => $stats['divisions'] ?? 0,
                    'label' => 'Divisi Aktif',
                    'description' => 'Bidang dalam organisasi',
                    'color' => 'text-indigo-600',
                    'bg' => 'bg-indigo-50',
                    'border' => 'border-indigo-100',
                    'icon' => '<polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>',
                ],

                [
                    'value' => $stats['activities'] ?? 0,
                    'label' => 'Kegiatan',
                    'description' => 'Program & kegiatan',
                    'color' => 'text-orange-500',
                    'bg' => 'bg-orange-50',
                    'border' => 'border-orange-100',
                    'icon' => '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
                ],

                [
                    'value' => $stats['articles'] ?? 0,
                    'label' => 'Artikel Terbit',
                    'description' => 'Publikasi & informasi',
                    'color' => 'text-purple-600',
                    'bg' => 'bg-purple-50',
                    'border' => 'border-purple-100',
                    'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>',
                ],

            ];

        @endphp


        {{-- Cards --}}
        <div
            class="grid grid-cols-2
                   gap-4
                   lg:grid-cols-4
                   md:gap-6">

            @foreach($statsData as $i => $stat)

                <div
                    class="reveal fade-up
                           delay-{{ $i * 75 }}
                           group
                           relative
                           overflow-hidden
                           rounded-2xl
                           border border-gray-100
                           bg-white
                           p-5 md:p-6
                           shadow-sm
                           transition-all duration-300
                           hover:-translate-y-1
                           hover:shadow-xl">


                    {{-- Icon --}}
                    <div
                        class="relative z-10
                               mb-5
                               flex
                               h-11 w-11
                               md:h-12 md:w-12
                               items-center
                               justify-center
                               rounded-xl
                               border
                               {{ $stat['bg'] }}
                               {{ $stat['border'] }}
                               {{ $stat['color'] }}
                               transition-transform duration-300
                               group-hover:scale-105">

                        <svg
                            width="22"
                            height="22"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round">

                            {!! $stat['icon'] !!}

                        </svg>

                    </div>


                    {{-- Content --}}
                    <div class="relative z-10">

                        <div
                            class="text-3xl md:text-4xl
                                   font-extrabold
                                   leading-none
                                   tracking-tight
                                   text-primary-navy">

                            {{ $stat['value'] }}

                        </div>


                        <div
                            class="mt-2
                                   text-sm md:text-base
                                   font-bold
                                   text-gray-800">

                            {{ $stat['label'] }}

                        </div>


                        <div
                            class="mt-1
                                   text-[11px] md:text-xs
                                   text-gray-400">

                            {{ $stat['description'] }}

                        </div>

                    </div>


                    {{-- Bottom Accent --}}
                    <div
                        class="absolute
                               bottom-0
                               left-0
                               right-0
                               h-1
                               {{ $stat['bg'] }}
                               transition-all duration-300
                               group-hover:h-1.5">
                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>



{{-- ============================================================
    TENTANG KAMI
============================================================ --}}
<section class="section-spacing">

    <div class="section-container">

        <div
            class="grid
                   grid-cols-1
                   lg:grid-cols-2
                   gap-16
                   items-center">


            {{-- Content --}}
            <div class="reveal fade-up">

                <span
                    class="mb-3 block
                           text-xs font-semibold
                           uppercase tracking-widest
                           text-secondary-blue">

                    Tentang Kami

                </span>


                <h2
                    class="mb-6
                           text-3xl md:text-4xl
                           font-bold
                           leading-tight
                           text-gray-900">

                    Wadah Mahasiswa untuk Belajar, Berkarya, dan Berinovasi

                </h2>


                <div
                    class="mb-8
                           space-y-4
                           text-sm md:text-base
                           leading-relaxed
                           text-gray-500">

                    <p>

                        {{ \App\Models\Setting::get(
                            'org_description',
                            'UKM-IT Cyber Open Source adalah Unit Kegiatan Mahasiswa yang berfokus pada pengembangan kemampuan di bidang teknologi informasi.'
                        ) }}

                    </p>

                </div>


                <a
                    href="{{ route('public.tentang') }}"
                    class="btn-primary
                           !px-6 !py-3
                           !text-sm
                           shadow-sm">

                    Baca Profil Lengkap

                    <x-lucide-arrow-right
                        class="w-5 h-5"
                    />

                </a>

            </div>


            {{-- Features --}}
            <div
                class="grid
                       grid-cols-2
                       gap-5">

                @php

                    $features = [

                        [
                            'title' => 'Open Source',
                            'desc' => 'Mendukung dan mengembangkan kultur open source di lingkungan kampus.',
                            'icon' => '<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>',
                            'color' => 'text-secondary-blue',
                            'bg' => 'bg-blue-50',
                            'offset' => false,
                        ],

                        [
                            'title' => 'Kolaborasi',
                            'desc' => 'Bekerjasama membangun proyek inovatif bersama anggota lintas divisi.',
                            'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
                            'color' => 'text-primary-navy',
                            'bg' => 'bg-indigo-50',
                            'offset' => false,
                        ],

                        [
                            'title' => 'Inovasi',
                            'desc' => 'Mendorong kreativitas dan solusi digital yang berdampak nyata bagi masyarakat.',
                            'icon' => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
                            'color' => 'text-orange-500',
                            'bg' => 'bg-orange-50',
                            'offset' => false,
                        ],

                        [
                            'title' => 'Komunitas',
                            'desc' => 'Membangun jaringan mahasiswa yang saling mendukung dan menginspirasi.',
                            'icon' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
                            'color' => 'text-emerald-600',
                            'bg' => 'bg-emerald-50',
                            'offset' => false,
                        ],

                    ];

                @endphp


                @foreach($features as $i => $feature)

                    <div
                        class="reveal fade-up
                               delay-{{ $i * 75 }}
                               ui-card
                               flex flex-col
                               items-start
                               gap-3
                               p-5
                               text-left
                               transition-shadow duration-200
                               hover:shadow-md
                               {{ $feature['offset'] ? 'mt-6' : '' }}">

                        <div
                            class="flex
                                   h-11 w-11
                                   shrink-0
                                   items-center
                                   justify-center
                                   rounded-xl
                                   {{ $feature['bg'] }}
                                   {{ $feature['color'] }}">

                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round">

                                {!! $feature['icon'] !!}

                            </svg>

                        </div>


                        <div>

                            <h3
                                class="mb-1
                                       text-sm
                                       font-bold
                                       text-gray-900">

                                {{ $feature['title'] }}

                            </h3>


                            <p
                                class="text-xs
                                       leading-relaxed
                                       text-gray-500">

                                {{ $feature['desc'] }}

                            </p>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</section>



{{-- ============================================================
    DIVISI
============================================================ --}}
@if($divisions->count() > 0)

    <section
        class="section-spacing
               border-y border-gray-100
               bg-white">

        <div class="section-container">


            {{-- Header --}}
            <div
                class="reveal fade-up
                       mx-auto
                       mb-14
                       max-w-2xl
                       text-center">

                <span
                    class="mb-3 block
                           text-xs font-semibold
                           uppercase tracking-widest
                           text-secondary-blue">

                    Bidang Fokus

                </span>


                <h2
                    class="mb-4
                           text-3xl md:text-4xl
                           font-bold
                           text-gray-900">

                    Divisi UKM-IT COS

                </h2>


                <p
                    class="text-sm md:text-base
                           leading-relaxed
                           text-gray-500">

                    Setiap divisi memiliki peran penting dalam pengembangan skill
                    anggota di bidang yang lebih spesifik.

                </p>

            </div>


            {{-- Division Cards --}}
            <div
                class="grid
                       grid-cols-1
                       gap-6
                       md:grid-cols-2
                       lg:grid-cols-3">

                @foreach($divisions as $i => $division)

                    <a
                        href="{{ route('public.divisi.show', $division->slug) }}"
                        class="reveal fade-up
                               delay-{{ ($i % 3) * 75 }}
                               ui-card
                               group
                               block
                               border-gray-100
                               p-6
                               transition-all duration-200
                               hover:border-secondary-blue/30
                               hover:shadow-md">


                        {{-- Icon --}}
                        <div
                            class="mb-5
                                   flex
                                   h-12 w-12
                                   items-center
                                   justify-center
                                   rounded-xl
                                   border border-gray-200
                                   bg-gray-50
                                   text-gray-400
                                   transition-all duration-200
                                   group-hover:border-primary-navy
                                   group-hover:bg-primary-navy
                                   group-hover:text-white">

                            @php
                                $divName = strtolower($division->name);
                            @endphp
                            @if(str_contains($divName, 'programming'))
                                <x-lucide-terminal class="w-5 h-5" />
                            @elseif(str_contains($divName, 'network'))
                                <x-lucide-network class="w-5 h-5" />
                            @elseif(str_contains($divName, 'dkv') || str_contains($divName, 'multimedia') || str_contains($divName, 'desain'))
                                <x-lucide-palette class="w-5 h-5" />
                            @else
                                <x-lucide-layers class="w-5 h-5" />
                            @endif
                        </div>

                        {{-- Title --}}
                        <h3
                            class="mb-2
                                   text-base
                                   font-bold
                                   text-gray-900
                                   transition-colors duration-200
                                   group-hover:text-secondary-blue">

                            {{ $division->name }}

                        </h3>


                        {{-- Description --}}
                        <p
                            class="mb-5
                                   line-clamp-2
                                   text-sm
                                   leading-relaxed
                                   text-gray-400">

                            {{ $division->description }}

                        </p>


                        {{-- Link --}}
                        <div
                            class="flex
                                   items-center
                                   gap-1.5
                                   text-xs
                                   font-semibold
                                   text-secondary-blue
                                   transition-all duration-200
                                   group-hover:gap-3">

                            Pelajari lebih lanjut

                            <x-lucide-arrow-right
                                class="w-5 h-5"
                            />

                        </div>

                    </a>

                @endforeach

            </div>

        </div>

    </section>

@endif



{{-- ============================================================
    ARTIKEL / BERITA
============================================================ --}}
@if($latestArticles->count() > 0)

    <section class="section-spacing">

        <div class="section-container">


            {{-- Header --}}
            <div
                class="reveal fade-up
                       mb-12
                       flex flex-col
                       items-start
                       justify-between
                       gap-4
                       sm:flex-row
                       sm:items-end">

                <div>

                    <span
                        class="mb-3 block
                               text-xs font-semibold
                               uppercase tracking-widest
                               text-secondary-blue">

                        Publikasi

                    </span>


                    <h2
                        class="text-3xl md:text-4xl
                               font-bold
                               text-gray-900">

                        Berita Terbaru

                    </h2>

                </div>


                <a
                    href="{{ route('public.berita') }}"
                    class="btn-secondary
                           !text-sm
                           flex-shrink-0">

                    Lihat Semua Berita

                    <x-lucide-arrow-right
                        class="w-5 h-5"
                    />

                </a>

            </div>


            {{-- Article Cards --}}
            <div
                class="grid
                       grid-cols-1
                       gap-7
                       md:grid-cols-2
                       lg:grid-cols-3">

                @foreach($latestArticles as $i => $article)

                    <a
                        href="{{ route('public.berita.show', $article->slug) }}"
                        class="reveal fade-up
                               delay-{{ ($i % 3) * 75 }}
                               ui-card
                               group
                               flex flex-col
                               overflow-hidden
                               transition-all duration-200
                               hover:shadow-md">


                        {{-- Thumbnail --}}
                        <div
                            class="relative
                                   aspect-video
                                   overflow-hidden
                                   bg-gray-100">

                            @if($article->thumbnail)

                                <img
                                    src="{{ asset('images/' . $article->thumbnail) }}"
                                    alt="{{ $article->title }}"
                                    class="w-full h-full
                                           object-cover
                                           transition-transform duration-500
                                           group-hover:scale-105"
                                >

                            @else

                                <div
                                    class="flex
                                           w-full h-full
                                           items-center
                                           justify-center
                                           bg-gradient-to-br
                                           from-gray-100
                                           to-gray-200
                                           text-gray-300">

                                    <x-lucide-image
                                        class="w-5 h-5"
                                    />

                                </div>

                            @endif


                            {{-- Category --}}
                            @if($article->category)

                                <span
                                    class="absolute
                                           top-3 left-3
                                           rounded-lg
                                           bg-white/95
                                           px-2.5 py-1
                                           text-xs font-bold
                                           text-primary-navy
                                           shadow-sm
                                           backdrop-blur">

                                    {{ $article->category->name }}

                                </span>

                            @endif

                        </div>


                        {{-- Article Content --}}
                        <div
                            class="flex
                                   flex-grow
                                   flex-col
                                   p-5">


                            {{-- Meta --}}
                            <p
                                class="mb-3
                                       flex items-center
                                       gap-2
                                       text-xs
                                       text-gray-400">

                                <span>
                                    {{ $article->published_at?->translatedFormat('d M Y') ?? 'Draft' }}
                                </span>

                                <span
                                    class="inline-block
                                           h-1 w-1
                                           rounded-full
                                           bg-gray-300">
                                </span>

                                <span>
                                    {{ $article->author?->name ?? 'Admin' }}
                                </span>

                            </p>


                            {{-- Title --}}
                            <h3
                                class="mb-2
                                       line-clamp-2
                                       text-base
                                       font-bold
                                       leading-snug
                                       text-gray-900
                                       transition-colors duration-200
                                       group-hover:text-secondary-blue">

                                {{ $article->title }}

                            </h3>


                            {{-- Excerpt --}}
                            <p
                                class="flex-grow
                                       line-clamp-3
                                       text-sm
                                       leading-relaxed
                                       text-gray-400">

                                {{ $article->excerpt }}

                            </p>


                            {{-- Read More --}}
                            <div
                                class="mt-4
                                       flex
                                       items-center
                                       gap-1.5
                                       border-t
                                       border-gray-50
                                       pt-4
                                       text-xs
                                       font-semibold
                                       text-secondary-blue
                                       transition-all duration-200
                                       group-hover:gap-3">

                                Baca Selengkapnya

                                <x-lucide-arrow-right
                                    class="w-5 h-5"
                                />

                            </div>

                        </div>

                    </a>

                @endforeach

            </div>

        </div>

    </section>

@endif



{{-- ============================================================
    CTA BANNER
============================================================ --}}
<section
    class="relative
           overflow-hidden
           bg-primary-navy
           py-16 md:py-20">


    {{-- Dot Grid --}}
    <div
        class="absolute inset-0
               opacity-[0.05]"
        style="background-image: radial-gradient(circle, #fff 1px, transparent 1px);
               background-size: 24px 24px;">
    </div>


    {{-- Glow --}}
    <div
        class="absolute
               top-0 right-0
               w-96 h-96
               translate-x-1/2
               -translate-y-1/2
               rounded-full
               bg-secondary-blue/20
               blur-3xl
               pointer-events-none">
    </div>


    <div
        class="reveal fade-up
               section-container
               relative z-10
               text-center">


        <span
            class="mb-4 block
                   text-xs font-semibold
                   uppercase tracking-widest
                   text-secondary-blue">

            Bergabung Sekarang

        </span>


        <h2
            class="mb-4
                   text-3xl md:text-4xl
                   font-bold
                   leading-tight
                   text-white">

            Siap Jadi Bagian dari<br>
            Komunitas Kami?

        </h2>


        <p
            class="mx-auto
                   mb-8
                   max-w-lg
                   text-sm md:text-base
                   leading-relaxed
                   text-gray-400">

            Daftarkan dirimu dan mulailah perjalanan bersama mahasiswa-mahasiswa
            penggiat teknologi di UKM-IT COS.

        </p>


        {{-- CTA Buttons --}}
        <div
            class="flex flex-wrap
                   items-center
                   justify-center
                   gap-4">

            <a
                href="{{ route('register') }}"
                class="btn-primary
                       !px-8 !py-3
                       !text-sm
                       bg-secondary-blue
                       shadow-lg
                       shadow-secondary-blue/30
                       hover:bg-blue-600">

                Daftar Sekarang

            </a>


            <a
                href="{{ route('public.kontak') }}"
                class="btn-secondary
                       !px-8 !py-3
                       !text-sm
                       !border-white/20
                       !bg-white/5
                       !text-white
                       hover:!bg-white/10">

                Hubungi Kami

            </a>

        </div>

    </div>

</section>



{{-- ============================================================
    PENGUMUMAN POPUP (MODAL)
============================================================ --}}
@if(isset($announcement) && $announcement)

    <div
        id="announcement-modal"
        class="fixed inset-0
               z-[100]
               hidden
               items-center
               justify-center
               p-4">


        {{-- Backdrop --}}
        <div
            class="absolute inset-0
                   bg-gray-900/40
                   backdrop-blur-sm
                   transition-opacity
                   opacity-0"
            id="announcement-backdrop">
        </div>


        {{-- Modal Content --}}
        <div
            class="relative
                   w-full
                   max-w-lg
                   scale-95
                   opacity-0
                   transition-all duration-300
                   bg-white
                   rounded-2xl
                   shadow-2xl
                   overflow-hidden
                   border border-gray-100"
            id="announcement-card">


            {{-- Header/Banner --}}
            <div
                class="bg-gradient-to-r
                       from-primary-navy
                       to-secondary-blue
                       px-6 py-4
                       flex
                       items-center
                       justify-between">

                <div
                    class="flex
                           items-center
                           gap-2
                           text-white">

                    <svg
                        class="w-5 h-5 text-white/90"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                        </path>

                    </svg>


                    <h3
                        class="font-bold
                               text-lg
                               tracking-wide">

                        Pengumuman

                    </h3>

                </div>


                <button
                    id="close-announcement"
                    class="text-white/70
                           hover:text-white
                           transition-colors
                           bg-white/10
                           hover:bg-white/20
                           p-1.5
                           rounded-full"
                    aria-label="Tutup">

                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12">
                        </path>

                    </svg>

                </button>

            </div>


            {{-- Body --}}
            <div
                class="p-6 md:p-8
                       text-center
                       sm:text-left">

                <h4
                    class="text-xl md:text-2xl
                           font-bold
                           text-gray-900
                           mb-3">

                    {{ $announcement->title }}

                </h4>


                <div
                    class="text-sm
                           text-gray-500
                           mb-6
                           leading-relaxed
                           whitespace-pre-line
                           text-justify">

                    {{ $announcement->content }}

                </div>


                <div class="flex justify-end">

                    <button
                        id="btn-mengerti"
                        class="w-full
                               sm:w-auto
                               btn-primary
                               !px-6 !py-2.5
                               !text-sm
                               bg-primary-navy
                               hover:bg-gray-800
                               shadow-md">

                        Saya Mengerti

                    </button>

                </div>

            </div>

        </div>

    </div>


    @push('scripts')
    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {

                const announcementId =
                    'announcement_{{ $announcement->id }}';


                // Periksa apakah user sudah pernah
                // menutup pengumuman ini
                if (!sessionStorage.getItem(announcementId)) {

                    const modal =
                        document.getElementById(
                            'announcement-modal'
                        );

                    const backdrop =
                        document.getElementById(
                            'announcement-backdrop'
                        );

                    const card =
                        document.getElementById(
                            'announcement-card'
                        );

                    const closeBtn =
                        document.getElementById(
                            'close-announcement'
                        );

                    const mengertiBtn =
                        document.getElementById(
                            'btn-mengerti'
                        );


                    const closeModal = () => {

                        backdrop.classList.remove(
                            'opacity-100'
                        );

                        backdrop.classList.add(
                            'opacity-0'
                        );


                        card.classList.remove(
                            'scale-100',
                            'opacity-100'
                        );

                        card.classList.add(
                            'scale-95',
                            'opacity-0'
                        );


                        setTimeout(() => {

                            modal.classList.remove(
                                'flex'
                            );

                            modal.classList.add(
                                'hidden'
                            );

                        }, 300);


                        // Simpan status
                        // pada session
                        sessionStorage.setItem(
                            announcementId,
                            'true'
                        );

                    };


                    // Tampilkan modal
                    // dengan sedikit delay
                    setTimeout(() => {

                        modal.classList.remove(
                            'hidden'
                        );

                        modal.classList.add(
                            'flex'
                        );


                        // Trigger reflow
                        void modal.offsetWidth;


                        backdrop.classList.remove(
                            'opacity-0'
                        );

                        backdrop.classList.add(
                            'opacity-100'
                        );


                        card.classList.remove(
                            'scale-95',
                            'opacity-0'
                        );

                        card.classList.add(
                            'scale-100',
                            'opacity-100'
                        );

                    }, 500);


                    closeBtn.addEventListener(
                        'click',
                        closeModal
                    );


                    mengertiBtn.addEventListener(
                        'click',
                        closeModal
                    );


                    // Tutup jika klik di luar modal
                    modal.addEventListener(
                        'click',
                        function(e) {

                            if (
                                e.target === modal ||
                                e.target === backdrop
                            ) {

                                closeModal();

                            }

                        }
                    );

                }

            }
        );
    </script>
    @endpush

@endif

@push('scripts')
<script>
(function () {
    'use strict';

    const DISPLAY_MS   = 6000; // how long each slide is shown
    const FADE_MS      = 1800; // must match CSS transition duration (1.8s)
    const VALID_EXT    = /\.(jpg|jpeg|png|webp)$/i;

    const container    = document.getElementById('hero-slideshow');
    if (!container) return;

    const slides = Array.from(container.querySelectorAll('.hero-slide'));
    if (slides.length === 0) return;

    /* ── Reduced Motion: show only first slide, no animation ── */
    const mq = window.matchMedia('(prefers-reduced-motion: reduce)');
    if (mq.matches) {
        slides[0].classList.add('active');
        return;
    }

    /* ── Single image: no slideshow needed ── */
    if (slides.length === 1) return;

    let currentIndex = 0;
    let timer        = null;
    let isTransitioning = false;

    /* Preload image helper */
    const preload = (index) => {
        const slide = slides[index];
        if (!slide) return;
        const src = slide.dataset.src;
        if (src && !slide.style.backgroundImage.includes(src)) {
            slide.style.backgroundImage = `url('${src}')`;
        }
    };

    /* All images are already set in inline style from Blade; just ensure next is loaded */
    preload(1);

    const goNext = () => {
        if (isTransitioning || mq.matches) return;
        isTransitioning = true;

        // Fade out current
        slides[currentIndex].classList.remove('active');

        // Advance index
        currentIndex = (currentIndex + 1) % slides.length;

        // Preload next-next
        preload((currentIndex + 1) % slides.length);

        // Fade in next
        slides[currentIndex].classList.add('active');

        setTimeout(() => { isTransitioning = false; }, FADE_MS);
    };

    /* Start interval after first DISPLAY_MS */
    timer = setInterval(goNext, DISPLAY_MS);

    /* Pause on visibility change to avoid drift */
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            clearInterval(timer);
        } else {
            timer = setInterval(goNext, DISPLAY_MS);
        }
    });
})();
</script>
@endpush

@endsection