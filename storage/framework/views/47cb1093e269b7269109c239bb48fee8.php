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
    ?>

    <nav class="pub-navbar" id="pub-navbar">
        <div class="section-container h-full flex items-center justify-between">
            
            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-3 no-underline">
                <?php if($orgLogo): ?>
                    <img src="<?php echo e(asset('images/' . $orgLogo)); ?>" alt="<?php echo e($orgName); ?>" class="h-8 w-auto object-contain">
                <?php else: ?>
                    <div class="w-8 h-8 bg-white rounded flex items-center justify-center">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-layers'); ?>
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
                    </div>
                <?php endif; ?>
                <span class="text-base font-bold text-white tracking-tight"><?php echo e($orgName); ?></span>
            </a>

            
            <div id="pub-nav-links" class="hidden lg:flex items-center gap-1">
                <?php
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
                ?>

                <?php $__currentLoopData = $navLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $isActive = request()->routeIs($link['route']) || (isset($link['route_prefix']) && request()->routeIs($link['route_prefix'].'.*')); ?>
                    <a href="<?php echo e($link['href']); ?>" class="nav-link-pub <?php echo e($isActive ? 'active' : ''); ?>">
                        <?php echo e($link['label']); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <div class="ml-4 flex items-center gap-3">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn-secondary !py-1.5 !text-sm">
                            Dashboard
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
                            Login
                        </a>
                        <a href="<?php echo e(route('register')); ?>" class="btn-secondary !py-1.5 !text-sm">
                            Daftar
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            
            <button id="mobile-menu-btn" class="lg:hidden p-2 text-white" aria-label="Menu">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-menu'); ?>
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
            </button>
        </div>

        
        <div id="mobile-menu" class="hidden border-t border-white/10 bg-primary-navy shadow-lg">
            <div class="section-container py-4 flex flex-col gap-2">
                <?php $__currentLoopData = $navLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($link['href']); ?>" class="px-3 py-2 text-sm font-medium text-gray-300 hover:text-white rounded-md">
                        <?php echo e($link['label']); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="mt-4 flex gap-3 flex-wrap">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn-secondary flex-1 text-center">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn-primary border border-white/20 flex-1 text-center">Login</a>
                        <a href="<?php echo e(route('register')); ?>" class="btn-secondary flex-1 text-center">Daftar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    
    <main class="flex-grow pt-[72px]">
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
                            <div class="w-8 h-8 bg-primary-navy rounded flex items-center justify-center">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-layers'); ?>
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
                            </div>
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

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/layouts/public.blade.php ENDPATH**/ ?>