<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'UKM-IT COS'); ?> — UKM-IT Cyber Open Source</title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', 'UKM-IT Cyber Open Source — Wadah mahasiswa untuk belajar, berkembang, dan berkolaborasi dalam bidang teknologi informasi dan open source.'); ?>">
    <meta name="robots" content="index, follow">

    
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/logo.png')); ?>">

    
    <meta property="og:title" content="<?php echo $__env->yieldContent('title', 'UKM-IT COS'); ?> — UKM-IT Cyber Open Source">
    <meta property="og:description" content="<?php echo $__env->yieldContent('description', 'Wadah mahasiswa untuk belajar, berkembang, dan berkolaborasi dalam bidang teknologi informasi dan open source.'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?php echo $__env->yieldContent('og_image', asset('images/og-default.png')); ?>">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans antialiased text-gray-600 bg-bg-page flex flex-col min-h-screen page-transition-wrap">

    
    <?php
        $orgLogo   = \App\Models\Setting::get('org_logo');
        $orgName   = \App\Models\Setting::get('org_name', 'UKM-IT COS');
        $instagram = \App\Models\Setting::get('social_instagram');
        $github    = \App\Models\Setting::get('social_github');
        $email     = \App\Models\Setting::get('social_email');
        $isTentangActive   = request()->routeIs('public.tentang') || request()->routeIs('public.organisasi') || request()->routeIs('public.divisi') || request()->routeIs('public.divisi.show');
        $isAktivitasActive = request()->routeIs('public.kegiatan') || request()->routeIs('public.kegiatan.show') || request()->routeIs('public.berita') || request()->routeIs('public.berita.show') || request()->routeIs('public.galeri');
    ?>

    <nav class="pub-navbar" id="pub-navbar" role="navigation" aria-label="Navigasi utama"
         style="background:rgba(255,255,255,0.95)!important;backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);">
        <div class="section-container h-full flex items-center justify-between gap-4">

            
            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2.5 no-underline shrink-0" aria-label="Beranda <?php echo e($orgName); ?>">
                <?php if($orgLogo): ?>
                    <img src="<?php echo e(asset('images/' . $orgLogo)); ?>" alt="Logo <?php echo e($orgName); ?>" class="h-8 w-auto object-contain">
                <?php else: ?>
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo COS" class="h-8 w-auto object-contain">
                <?php endif; ?>
                <span class="text-xs sm:text-sm font-bold text-primary-navy tracking-tight leading-tight max-w-[140px] sm:max-w-none"><?php echo e($orgName); ?></span>
            </a>

            
            
            <div id="navbar-event-preview"
                 class="navbar-event-preview"
                 aria-hidden="true"
                 aria-label="Kegiatan terdekat">

                
                <span class="nep-name" id="nep-name"></span>

                
                <span class="nep-sep" aria-hidden="true">·</span>

                
                <span class="nep-sub">
                    <span class="nep-label">Kegiatan Terdekat</span>
                    <span class="nep-label-sep" aria-hidden="true">·</span>
                    <span class="nep-cd" id="nep-cd"></span>
                </span>

            </div>

            
            <div class="hidden lg:flex items-center gap-0.5">

                <a href="<?php echo e(route('home')); ?>" class="nav-link-pub <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Beranda</a>

                
                <div class="nav-dropdown-wrap" id="dropdown-tentang-wrap">
                    <button id="dropdown-tentang-btn"
                            class="nav-dropdown-trigger <?php echo e($isTentangActive ? 'active' : ''); ?>"
                            aria-expanded="false" aria-haspopup="true" aria-controls="dropdown-tentang-panel" type="button">
                        Tentang
                        <svg class="chevron" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="4 6 8 10 12 6"/></svg>
                    </button>
                    <div id="dropdown-tentang-panel" class="nav-dropdown-panel" role="menu" aria-labelledby="dropdown-tentang-btn">
                        <a href="<?php echo e(route('public.tentang')); ?>" role="menuitem" class="nav-dropdown-item <?php echo e(request()->routeIs('public.tentang') ? 'active' : ''); ?>">
                            <?php if($orgLogo): ?>
                                <img src="<?php echo e(asset('images/' . $orgLogo)); ?>" alt="Logo" class="nav-dropdown-logo">
                            <?php else: ?>
                                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" class="nav-dropdown-logo">
                            <?php endif; ?>
                            Tentang COS
                        </a>
                        <a href="<?php echo e(route('public.organisasi')); ?>" role="menuitem" class="nav-dropdown-item <?php echo e(request()->routeIs('public.organisasi') ? 'active' : ''); ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Organisasi
                        </a>
                        <a href="<?php echo e(route('public.divisi')); ?>" role="menuitem" class="nav-dropdown-item <?php echo e(request()->routeIs('public.divisi') || request()->routeIs('public.divisi.show') ? 'active' : ''); ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
                            Divisi
                        </a>
                    </div>
                </div>

                
                <div class="nav-dropdown-wrap" id="dropdown-aktivitas-wrap">
                    <button id="dropdown-aktivitas-btn"
                            class="nav-dropdown-trigger <?php echo e($isAktivitasActive ? 'active' : ''); ?>"
                            aria-expanded="false" aria-haspopup="true" aria-controls="dropdown-aktivitas-panel" type="button">
                        Aktivitas
                        <svg class="chevron" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="4 6 8 10 12 6"/></svg>
                    </button>
                    <div id="dropdown-aktivitas-panel" class="nav-dropdown-panel" role="menu" aria-labelledby="dropdown-aktivitas-btn">
                        <a href="<?php echo e(route('public.kegiatan')); ?>" role="menuitem" class="nav-dropdown-item <?php echo e(request()->routeIs('public.kegiatan') || request()->routeIs('public.kegiatan.show') ? 'active' : ''); ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Kegiatan
                        </a>
                        <a href="<?php echo e(route('public.berita')); ?>" role="menuitem" class="nav-dropdown-item <?php echo e(request()->routeIs('public.berita') || request()->routeIs('public.berita.show') ? 'active' : ''); ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            Berita
                        </a>
                        <a href="<?php echo e(route('public.galeri')); ?>" role="menuitem" class="nav-dropdown-item <?php echo e(request()->routeIs('public.galeri') ? 'active' : ''); ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            Galeri
                        </a>
                    </div>
                </div>

                <a href="<?php echo e(route('public.kontak')); ?>" class="nav-link-pub <?php echo e(request()->routeIs('public.kontak') ? 'active' : ''); ?>">Kontak</a>

                <div class="ml-3 flex items-center gap-2">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn-secondary !py-1.5 !text-sm">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="nav-link-pub">Login</a>
                        <a href="<?php echo e(route('register')); ?>" class="btn-primary !py-1.5 !text-sm !rounded-lg">Daftar</a>
                    <?php endif; ?>
                </div>
            </div>

            
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

        
        <div id="mobile-menu-panel" class="mobile-nav-panel lg:hidden">
            <div class="section-container py-3 pb-5 flex flex-col gap-1">

                <a href="<?php echo e(route('home')); ?>" class="mobile-nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Beranda</a>

                
                <div>
                    <button class="mobile-accordion-trigger"
                            id="mob-acc-tentang-btn"
                            aria-expanded="<?php echo e($isTentangActive ? 'true' : 'false'); ?>"
                            aria-controls="mob-acc-tentang" type="button">
                        <span>Tentang</span>
                        <svg class="acc-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div id="mob-acc-tentang" class="mobile-accordion-content <?php echo e($isTentangActive ? 'open' : ''); ?>">
                        <a href="<?php echo e(route('public.tentang')); ?>" class="mobile-accordion-item <?php echo e(request()->routeIs('public.tentang') ? 'active' : ''); ?> flex items-center gap-2">
                            <?php if($orgLogo): ?>
                                <img src="<?php echo e(asset('images/' . $orgLogo)); ?>" alt="Logo" class="nav-dropdown-logo">
                            <?php else: ?>
                                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" class="nav-dropdown-logo">
                            <?php endif; ?>
                            Tentang COS
                        </a>
                        <a href="<?php echo e(route('public.organisasi')); ?>" class="mobile-accordion-item <?php echo e(request()->routeIs('public.organisasi') ? 'active' : ''); ?> flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Organisasi
                        </a>
                        <a href="<?php echo e(route('public.divisi')); ?>" class="mobile-accordion-item <?php echo e(request()->routeIs('public.divisi') || request()->routeIs('public.divisi.show') ? 'active' : ''); ?> flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
                            Divisi
                        </a>
                    </div>
                </div>

                
                <div>
                    <button class="mobile-accordion-trigger"
                            id="mob-acc-aktivitas-btn"
                            aria-expanded="<?php echo e($isAktivitasActive ? 'true' : 'false'); ?>"
                            aria-controls="mob-acc-aktivitas" type="button">
                        <span>Aktivitas</span>
                        <svg class="acc-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div id="mob-acc-aktivitas" class="mobile-accordion-content <?php echo e($isAktivitasActive ? 'open' : ''); ?>">
                        <a href="<?php echo e(route('public.kegiatan')); ?>" class="mobile-accordion-item <?php echo e(request()->routeIs('public.kegiatan') || request()->routeIs('public.kegiatan.show') ? 'active' : ''); ?> flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Kegiatan
                        </a>
                        <a href="<?php echo e(route('public.berita')); ?>" class="mobile-accordion-item <?php echo e(request()->routeIs('public.berita') || request()->routeIs('public.berita.show') ? 'active' : ''); ?> flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            Berita
                        </a>
                        <a href="<?php echo e(route('public.galeri')); ?>" class="mobile-accordion-item <?php echo e(request()->routeIs('public.galeri') ? 'active' : ''); ?> flex items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            Galeri
                        </a>
                    </div>
                </div>

                <a href="<?php echo e(route('public.kontak')); ?>" class="mobile-nav-link <?php echo e(request()->routeIs('public.kontak') ? 'active' : ''); ?>">Kontak</a>

                <div class="h-px bg-gray-100 my-2 mx-1"></div>

                <div class="flex gap-2 flex-wrap px-1 pb-1">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn-secondary flex-1 text-center !text-sm">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn-secondary flex-1 text-center !text-sm">Login</a>
                        <a href="<?php echo e(route('register')); ?>" class="btn-primary flex-1 text-center !text-sm">Daftar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    
    <main class="flex-grow pt-[68px]">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <footer class="bg-white border-t border-gray-200 py-16 mt-20">
        <div class="section-container">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                
                <div class="lg:col-span-2">
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-3 no-underline mb-4">
                        <?php if($orgLogo): ?>
                            <img src="<?php echo e(asset('images/' . $orgLogo)); ?>" alt="<?php echo e($orgName); ?>" class="h-8 object-contain">
                        <?php else: ?>
                            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo COS" class="h-8 object-contain">
                        <?php endif; ?>
                        <span class="font-bold text-gray-900"><?php echo e($orgName); ?></span>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-sm mb-6">
                        <?php echo e(\App\Models\Setting::get('org_description', 'Wadah mahasiswa untuk belajar, berkembang, dan berkolaborasi dalam bidang teknologi informasi dan open source.')); ?>

                    </p>
                    <div class="flex gap-3">
                        <?php if($instagram): ?>
                        <a href="<?php echo e($instagram); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:text-secondary-blue hover:border-secondary-blue hover:bg-secondary-blue/5 transition-all">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-instagram'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                        </a>
                        <?php endif; ?>
                        <?php if($github): ?>
                        <a href="<?php echo e($github); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:text-gray-900 hover:border-gray-900 hover:bg-gray-50 transition-all">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-github'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                        </a>
                        <?php endif; ?>
                        <?php if($email): ?>
                        <a href="mailto:<?php echo e($email); ?>" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:text-red-500 hover:border-red-500 hover:bg-red-50 transition-all">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-mail'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Navigasi</h4>
                    <ul class="space-y-3">
                        <?php $__currentLoopData = [['label'=>'Tentang','href'=>route('public.tentang')],['label'=>'Organisasi','href'=>route('public.organisasi')],['label'=>'Divisi','href'=>route('public.divisi')],['label'=>'Kegiatan','href'=>route('public.kegiatan')],['label'=>'Berita','href'=>route('public.berita')],['label'=>'Galeri','href'=>route('public.galeri')],['label'=>'Kontak','href'=>route('public.kontak')]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e($fl['href']); ?>" class="text-gray-500 hover:text-secondary-blue text-sm transition-colors"><?php echo e($fl['label']); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Bergabung</h4>
                    <p class="text-gray-500 text-sm mb-4">Tertarik bergabung bersama kami?</p>
                    <a href="<?php echo e(route('register')); ?>" class="btn-primary !py-2">Daftar Sekarang</a>
                </div>
            </div>

            
            <div class="pt-8 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-sm">&copy; <?php echo e(date('Y')); ?> <?php echo e($orgName); ?>. All rights reserved.</p>
                <p class="text-gray-400 text-sm">Open Your Mind For The Future With Open Source</p>
            </div>
        </div>
    </footer>

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
        // Called by home.blade.php after window.COS_COUNTDOWN is ready.
        // No DB query here — data comes purely from the countdown state.
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

    }());
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/layouts/public.blade.php ENDPATH**/ ?>