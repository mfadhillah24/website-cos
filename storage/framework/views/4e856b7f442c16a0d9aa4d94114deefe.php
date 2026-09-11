

<?php $__env->startSection('title', 'Beranda'); ?>

<?php $__env->startSection(
    'description',
    'UKM-IT Cyber Open Source — Wadah mahasiswa untuk belajar, berkembang, dan berkolaborasi dalam bidang teknologi informasi dan open source.'
); ?>

<?php $__env->startSection('content'); ?>


<section class="bg-gray-200 relative overflow-hidden min-h-[88vh] flex items-center">

    
    <div
        class="absolute top-0 right-0 w-[600px] h-[600px]
               bg-secondary-blue/10 rounded-full blur-[120px]
               -translate-y-1/2 translate-x-1/3 pointer-events-none">
    </div>

    <div
        class="absolute bottom-0 left-0 w-[400px] h-[400px]
               bg-secondary-blue/5 rounded-full blur-[100px]
               translate-y-1/2 -translate-x-1/4 pointer-events-none">
    </div>

    
    <div
        class="absolute inset-0 opacity-[0.04]"
        style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 28px 28px;">
    </div>

    <div class="section-container relative z-10 w-full py-20 md:py-28">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            
            <div>

                
                <span
                    class="reveal fade-up inline-flex items-center gap-2
                           py-1.5 px-4 mb-8 rounded-full
                           bg-white/5 border border-white/10
                           text-gray-700 text-xs font-medium
                           tracking-widest uppercase">

                    <span class="w-2.5 h-2.5 rounded-full bg-secondary-blue"></span>

                    #BRAVOCOS
                </span>

                
                <h1
                    class="reveal fade-up delay-75
                           text-4xl md:text-5xl lg:text-6xl
                           tracking-tight leading-[1.15] mb-6">

                    <span class="block mb-1 font-medium text-gray-700">
                        UKM-IT
                    </span>

                    <span class="block font-bold text-primary-navy">
                        Cyber Open Source
                    </span>
                </h1>

                
                <p
                    class="reveal fade-up delay-150
                           mb-4 text-lg font-medium
                           tracking-wide text-primary-navy">

                    <i>"Open Your Mind for The Future With Open Source"</i>
                </p>

                
                <p
                    class="reveal fade-up delay-200
                           max-w-lg mb-10
                           text-base font-normal
                           leading-relaxed text-gray-900">

                    Wadah bagi mahasiswa untuk belajar teknologi, mengembangkan kreativitas,
                    membangun kolaborasi, dan menciptakan solusi digital melalui semangat Open Source.
                </p>

                
                <div
                    class="reveal fade-up delay-300
                           flex flex-wrap items-center gap-4">

                    <a
                        href="<?php echo e(route('public.tentang')); ?>"
                        class="btn-primary !px-7 !py-3 !text-sm
                               !bg-gray-500 !text-white !border-gray-800
                               hover:!bg-gray-900 hover:!border-gray-900">

                        Kenal Lebih Dekat
                    </a>

                    <a
                        href="<?php echo e(route('register')); ?>"
                        class="btn-primary !px-7 !py-3 !text-sm
                               !bg-gray-500 !text-white !border-gray-800
                               hover:!bg-gray-900 hover:!border-gray-900">

                        Bergabung Bersama Kami
                    </a>

                </div>
            </div>

            
            <div
                class="reveal fade-in delay-400
                       hidden lg:flex
                       relative items-center justify-center">

                <div
                    class="absolute w-80 h-80
                           bg-secondary rounded-full blur-3xl">
                </div>

                <?php if(\App\Models\Setting::get('org_logo')): ?>

                    <img
                        src="<?php echo e(asset('images/' . \App\Models\Setting::get('org_logo'))); ?>"
                        alt="Logo UKM-IT Cyber Open Source"
                        class="relative z-10 w-72 h-auto
                               object-contain drop-shadow-2xl
                               transition-transform duration-500
                               hover:scale-105">

                <?php else: ?>

                    <div
                        class="relative z-10
                               w-72 h-72
                               bg-white/5
                               border border-white/10
                               rounded-3xl
                               flex flex-col items-center justify-center gap-4
                               shadow-2xl">

                        <div
                            class="w-24 h-24
                                   bg-secondary-blue/20
                                   rounded-2xl
                                   flex items-center justify-center">

                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-layers'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-secondary-blue']); ?>
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

                        <span class="text-white font-bold text-xl tracking-tight">
                            UKM-IT COS
                        </span>

                        <span class="text-gray-400 text-sm">
                            UNITAMA
                        </span>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>
</section>



<?php if($ketuaUmum): ?>

    <?php
        $member = $ketuaUmum->member;
        $sambutan = \App\Models\Setting::get('ketua_sambutan', '');
    ?>

    <section class="relative overflow-hidden bg-[#F8FAFC] py-16 md:py-24">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            
            <div class="mb-12 text-center">

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

                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-message-circle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 text-blue-600']); ?>
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


            
            <div
                class="flex flex-col lg:flex-row
                       items-center justify-center
                       gap-8 lg:gap-12">

                
                <div class="relative w-full max-w-[320px] shrink-0">

                    
                    <div
                        class="absolute -bottom-6 -left-6
                               w-44 h-44
                               rounded-full
                               bg-slate-200/60
                               pointer-events-none -z-10">
                    </div>

                    <div
                        class="absolute -top-6 -right-6
                               w-44 h-44
                               rounded-full
                               bg-slate-200/60
                               pointer-events-none -z-10">
                    </div>

                    
                    <div
                        class="relative z-10 w-full
                               rounded-3xl
                               bg-white
                               p-6
                               text-center
                               shadow-xl
                               shadow-slate-200/80">

                        
                        <div class="relative flex w-full justify-center">

                            <?php if($member && $member->photo): ?>

                                <div
                                    class="relative w-full h-[300px]
                                           overflow-hidden
                                           rounded-2xl
                                           bg-slate-100">

                                    <img
    src="<?php echo e(asset('images/' . $member->photo)); ?>"
    alt="<?php echo e($member->name); ?>"
    class="w-full h-full
           object-cover
           object-center">	

                                    
                                    <div
                                        class="absolute inset-0
                                               bg-gradient-to-t
                                               from-black/10
                                               via-transparent
                                               to-transparent
                                               pointer-events-none">
                                    </div>

                                    
                                    <div
                                        class="absolute top-3 right-3
                                               flex h-11 w-11
                                               items-center justify-center
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

                            <?php else: ?>

                                <div
                                    class="flex w-full h-[300px]
                                           items-center justify-center
                                           rounded-2xl
                                           bg-slate-100">

                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-20 h-20 text-slate-300']); ?>
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

                        </div>


                        
                        <div class="px-4 pt-7 pb-5 text-center">

                            <h3
                                class="mb-3
                                       text-xl md:text-2xl
                                       font-extrabold
                                       leading-tight
                                       tracking-tight
                                       text-[#0F2B5B]">

                                <?php echo e($member->name ?? 'Kasfillah'); ?>


                            </h3>

                            <p
                                class="text-sm
                                       font-semibold
                                       leading-normal
                                       text-slate-600">

                                <?php echo e($ketuaUmum->position->name ?? 'Ketua Umum'); ?>


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


                
                <div class="w-full flex-1">

                    <div
                        class="flex min-h-[280px]
                               flex-col justify-center
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

                            <?php if($sambutan): ?>

                                <?php $__currentLoopData = explode("\n", $sambutan); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paragraph): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php if(trim($paragraph) !== ''): ?>

                                        <p>
                                            <?php echo e(trim($paragraph)); ?>

                                        </p>

                                    <?php endif; ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php else: ?>

                                <p class="italic text-slate-400">

                                    Sambutan Ketua Umum belum tersedia.
                                    Silakan isi melalui menu Settings pada panel admin.

                                </p>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

<?php endif; ?>



<section class="bg-bg-page py-12 md:py-16">

    <div class="section-container">

        
        <div class="reveal fade-up mb-8 text-center md:mb-10">

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


        <?php
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
        ?>


        
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4 md:gap-6">

            <?php $__currentLoopData = $statsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div
                    class="reveal fade-up
                           delay-<?php echo e($i * 75); ?>

                           group relative overflow-hidden
                           rounded-2xl
                           border border-gray-100
                           bg-white
                           p-5 md:p-6
                           shadow-sm
                           transition-all duration-300
                           hover:-translate-y-1
                           hover:shadow-xl">

                    
                    <div
                        class="relative z-10
                               mb-5
                               flex h-11 w-11 md:h-12 md:w-12
                               items-center justify-center
                               rounded-xl
                               border
                               <?php echo e($stat['bg']); ?>

                               <?php echo e($stat['border']); ?>

                               <?php echo e($stat['color']); ?>

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

                            <?php echo $stat['icon']; ?>


                        </svg>

                    </div>


                    
                    <div class="relative z-10">

                        <div
                            class="text-3xl md:text-4xl
                                   font-extrabold
                                   leading-none
                                   tracking-tight
                                   text-primary-navy">

                            <?php echo e($stat['value']); ?>


                        </div>

                        <div
                            class="mt-2
                                   text-sm md:text-base
                                   font-bold
                                   text-gray-800">

                            <?php echo e($stat['label']); ?>


                        </div>

                        <div
                            class="mt-1
                                   text-[11px] md:text-xs
                                   text-gray-400">

                            <?php echo e($stat['description']); ?>


                        </div>

                    </div>


                    
                    <div
                        class="absolute bottom-0 left-0 right-0 h-1
                               <?php echo e($stat['bg']); ?>

                               transition-all duration-300
                               group-hover:h-1.5">
                    </div>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    </div>
</section>



<section class="section-spacing">

    <div class="section-container">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            
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

                        <?php echo e(\App\Models\Setting::get(
                            'org_description',
                            'UKM-IT Cyber Open Source adalah Unit Kegiatan Mahasiswa yang berfokus pada pengembangan kemampuan di bidang teknologi informasi.'
                        )); ?>


                    </p>

                </div>

                <a
                    href="<?php echo e(route('public.tentang')); ?>"
                    class="btn-primary
                           !px-6 !py-3 !text-sm
                           shadow-sm">

                    Baca Profil Lengkap

                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-arrow-right'); ?>
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

            </div>


            
            <div class="grid grid-cols-2 gap-5">

                <?php
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
                            'offset' => true,
                        ],
                        [
                            'title' => 'Inovasi',
                            'desc' => 'Mendorong kreativitas dan solusi digital yang berdampak nyata bagi masyarakat.',
                            'icon' => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
                            'color' => 'text-orange-500',
                            'bg' => 'bg-orange-50',
                            'offset' => true,
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
                ?>


                <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div
                        class="reveal fade-up
                               delay-<?php echo e($i * 75); ?>

                               ui-card
                               flex flex-col items-start gap-3
                               p-5
                               text-left
                               transition-shadow duration-200
                               hover:shadow-md
                               <?php echo e($feature['offset'] ? 'mt-6' : ''); ?>">

                        <div
                            class="flex h-11 w-11 shrink-0
                                   items-center justify-center
                                   rounded-xl
                                   <?php echo e($feature['bg']); ?>

                                   <?php echo e($feature['color']); ?>">

                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round">

                                <?php echo $feature['icon']; ?>


                            </svg>

                        </div>

                        <div>

                            <h3
                                class="mb-1
                                       text-sm
                                       font-bold
                                       text-gray-900">

                                <?php echo e($feature['title']); ?>


                            </h3>

                            <p
                                class="text-xs
                                       leading-relaxed
                                       text-gray-500">

                                <?php echo e($feature['desc']); ?>


                            </p>

                        </div>

                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

        </div>

    </div>
</section>



<?php if($divisions->count() > 0): ?>

    <section
        class="section-spacing
               border-y border-gray-100
               bg-white">

        <div class="section-container">

            
            <div
                class="reveal fade-up
                       mx-auto mb-14
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


            
            <div
                class="grid grid-cols-1
                       gap-6
                       md:grid-cols-2
                       lg:grid-cols-3">

                <?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $division): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <a
                        href="<?php echo e(route('public.divisi.show', $division->slug)); ?>"
                        class="reveal fade-up
                               delay-<?php echo e(($i % 3) * 75); ?>

                               ui-card group block
                               border-gray-100
                               p-6
                               transition-all duration-200
                               hover:border-secondary-blue/30
                               hover:shadow-md">

                        
                        <div
                            class="mb-5
                                   flex h-12 w-12
                                   items-center justify-center
                                   rounded-xl
                                   border border-gray-200
                                   bg-gray-50
                                   text-gray-400
                                   transition-all duration-200
                                   group-hover:border-primary-navy
                                   group-hover:bg-primary-navy
                                   group-hover:text-white">

                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-network'); ?>
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

                        
                        <h3
                            class="mb-2
                                   text-base font-bold
                                   text-gray-900
                                   transition-colors duration-200
                                   group-hover:text-secondary-blue">

                            <?php echo e($division->name); ?>


                        </h3>

                        
                        <p
                            class="mb-5
                                   line-clamp-2
                                   text-sm
                                   leading-relaxed
                                   text-gray-400">

                            <?php echo e($division->description); ?>


                        </p>

                        
                        <div
                            class="flex items-center gap-1.5
                                   text-xs font-semibold
                                   text-secondary-blue
                                   transition-all duration-200
                                   group-hover:gap-3">

                            Pelajari lebih lanjut

                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-arrow-right'); ?>
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

                    </a>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

        </div>
    </section>

<?php endif; ?>



<?php if($latestArticles->count() > 0): ?>

    <section class="section-spacing">

        <div class="section-container">

            
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
                    href="<?php echo e(route('public.berita')); ?>"
                    class="btn-secondary
                           !text-sm
                           flex-shrink-0">

                    Lihat Semua Berita

                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-arrow-right'); ?>
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

            </div>


            
            <div
                class="grid grid-cols-1
                       gap-7
                       md:grid-cols-2
                       lg:grid-cols-3">

                <?php $__currentLoopData = $latestArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <a
                        href="<?php echo e(route('public.berita.show', $article->slug)); ?>"
                        class="reveal fade-up
                               delay-<?php echo e(($i % 3) * 75); ?>

                               ui-card group
                               flex flex-col
                               overflow-hidden
                               transition-all duration-200
                               hover:shadow-md">

                        
                        <div
                            class="relative aspect-video
                                   overflow-hidden
                                   bg-gray-100">

                            <?php if($article->thumbnail): ?>

                                <img
                                    src="<?php echo e(asset('images/' . $article->thumbnail)); ?>"
                                    alt="<?php echo e($article->title); ?>"
                                    class="w-full h-full
                                           object-cover
                                           transition-transform duration-500
                                           group-hover:scale-105">

                            <?php else: ?>

                                <div
                                    class="flex w-full h-full
                                           items-center justify-center
                                           bg-gradient-to-br
                                           from-gray-100 to-gray-200
                                           text-gray-300">

                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-image'); ?>
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


                            
                            <?php if($article->category): ?>

                                <span
                                    class="absolute top-3 left-3
                                           rounded-lg
                                           bg-white/95
                                           px-2.5 py-1
                                           text-xs font-bold
                                           text-primary-navy
                                           shadow-sm
                                           backdrop-blur">

                                    <?php echo e($article->category->name); ?>


                                </span>

                            <?php endif; ?>

                        </div>


                        
                        <div class="flex flex-grow flex-col p-5">

                            
                            <p
                                class="mb-3
                                       flex items-center gap-2
                                       text-xs text-gray-400">

                                <span>
                                    <?php echo e($article->published_at?->translatedFormat('d M Y') ?? 'Draft'); ?>

                                </span>

                                <span
                                    class="inline-block h-1 w-1
                                           rounded-full
                                           bg-gray-300">
                                </span>

                                <span>
                                    <?php echo e($article->author?->name ?? 'Admin'); ?>

                                </span>

                            </p>


                            
                            <h3
                                class="mb-2
                                       line-clamp-2
                                       text-base font-bold
                                       leading-snug
                                       text-gray-900
                                       transition-colors duration-200
                                       group-hover:text-secondary-blue">

                                <?php echo e($article->title); ?>


                            </h3>


                            
                            <p
                                class="flex-grow
                                       line-clamp-3
                                       text-sm
                                       leading-relaxed
                                       text-gray-400">

                                <?php echo e($article->excerpt); ?>


                            </p>


                            
                            <div
                                class="mt-4
                                       flex items-center gap-1.5
                                       border-t border-gray-50
                                       pt-4
                                       text-xs font-semibold
                                       text-secondary-blue
                                       transition-all duration-200
                                       group-hover:gap-3">

                                Baca Selengkapnya

                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-arrow-right'); ?>
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

                        </div>

                    </a>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

        </div>
    </section>

<?php endif; ?>



<section
    class="relative overflow-hidden
           bg-primary-navy
           py-16 md:py-20">

    
    <div
        class="absolute inset-0 opacity-[0.05]"
        style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 24px 24px;">
    </div>

    
    <div
        class="absolute top-0 right-0
               w-96 h-96
               translate-x-1/2 -translate-y-1/2
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
            class="mx-auto mb-8
                   max-w-lg
                   text-sm md:text-base
                   leading-relaxed
                   text-gray-400">

            Daftarkan dirimu dan mulailah perjalanan bersama mahasiswa-mahasiswa
            penggiat teknologi di UKM-IT COS.

        </p>


        
        <div
            class="flex flex-wrap
                   items-center
                   justify-center
                   gap-4">

            <a
                href="<?php echo e(route('register')); ?>"
                class="btn-primary
                       !px-8 !py-3 !text-sm
                       bg-secondary-blue
                       shadow-lg
                       shadow-secondary-blue/30
                       hover:bg-blue-600">

                Daftar Sekarang

            </a>

            <a
                href="<?php echo e(route('public.kontak')); ?>"
                class="btn-secondary
                       !px-8 !py-3 !text-sm
                       !border-white/20
                       !bg-white/5
                       !text-white
                       hover:!bg-white/10">

                Hubungi Kami

            </a>

        </div>

    </div>
</section>


<?php if(isset($announcement) && $announcement): ?>
    <div id="announcement-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity opacity-0" id="announcement-backdrop"></div>
        
        
        <div class="relative w-full max-w-lg scale-95 opacity-0 transition-all duration-300 bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100" id="announcement-card">
            
            <div class="bg-gradient-to-r from-primary-navy to-secondary-blue px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2 text-white">
                    <svg class="w-5 h-5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    <h3 class="font-bold text-lg tracking-wide">Pengumuman</h3>
                </div>
                <button id="close-announcement" class="text-white/70 hover:text-white transition-colors bg-white/10 hover:bg-white/20 p-1.5 rounded-full" aria-label="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            
            <div class="p-6 md:p-8 text-center sm:text-left">
                <h4 class="text-xl md:text-2xl font-bold text-gray-900 mb-3"><?php echo e($announcement->title); ?></h4>
                <div class="text-sm text-gray-500 mb-6 leading-relaxed whitespace-pre-line text-justify"><?php echo e($announcement->content); ?></div>
                
                <div class="flex justify-end">
                    <button id="btn-mengerti" class="w-full sm:w-auto btn-primary !px-6 !py-2.5 !text-sm bg-primary-navy hover:bg-gray-800 shadow-md">Saya Mengerti</button>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const announcementId = 'announcement_<?php echo e($announcement->id); ?>';
            
            // Periksa apakah user sudah pernah menutup pengumuman ini
            if (!sessionStorage.getItem(announcementId)) {
                const modal = document.getElementById('announcement-modal');
                const backdrop = document.getElementById('announcement-backdrop');
                const card = document.getElementById('announcement-card');
                const closeBtn = document.getElementById('close-announcement');
                const mengertiBtn = document.getElementById('btn-mengerti');

                const closeModal = () => {
                    backdrop.classList.remove('opacity-100');
                    backdrop.classList.add('opacity-0');
                    card.classList.remove('scale-100', 'opacity-100');
                    card.classList.add('scale-95', 'opacity-0');
                    
                    setTimeout(() => {
                        modal.classList.remove('flex');
                        modal.classList.add('hidden');
                    }, 300);

                    // Simpan status agar tidak muncul lagi di session ini
                    sessionStorage.setItem(announcementId, 'true');
                };

                // Tampilkan modal dengan sedikit delay agar animasi masuk lebih mulus
                setTimeout(() => {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    
                    // Trigger reflow
                    void modal.offsetWidth;
                    
                    backdrop.classList.remove('opacity-0');
                    backdrop.classList.add('opacity-100');
                    
                    card.classList.remove('scale-95', 'opacity-0');
                    card.classList.add('scale-100', 'opacity-100');
                }, 500);

                closeBtn.addEventListener('click', closeModal);
                mengertiBtn.addEventListener('click', closeModal);
                
                // Tutup jika klik di luar modal (backdrop)
                modal.addEventListener('click', function(e) {
                    if (e.target === modal || e.target === backdrop) {
                        closeModal();
                    }
                });
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/public/home.blade.php ENDPATH**/ ?>