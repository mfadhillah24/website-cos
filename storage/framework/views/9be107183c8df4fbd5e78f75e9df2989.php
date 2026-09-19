

<?php $__env->startSection('title', 'Tentang Kami'); ?>
<?php $__env->startSection('description', 'Profil, visi, dan misi UKM-IT Cyber Open Source.'); ?>

<?php $__env->startSection('content'); ?>


<section class="about-hero bg-white border-b border-gray-200">

    <div class="section-container">

        <div class="reveal fade-up max-w-3xl">

            <span class="about-eyebrow text-secondary-blue">
                Profil Organisasi
            </span>

            <h1 class="about-title">
                Tentang UKM-IT COS
            </h1>

            <p class="about-description">
                Kenali lebih dekat visi, misi, sejarah, serta identitas
                Unit Kegiatan Mahasiswa Teknologi Informasi Cyber Open Source
                di UNITAMA.
            </p>

        </div>

    </div>

</section>



<section class="about-overview-section">

    <div class="section-container">

        <div class="about-content-grid">

            
            <div class="about-main-column">

                
                <div class="reveal fade-up about-info-card">

                    <div class="about-card-heading">

                        <div class="about-icon about-icon-navy">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-circle'); ?>
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

                        <div>

                            <span class="about-card-label">
                                Tentang Organisasi
                            </span>

                            <h2>
                                Profil Singkat
                            </h2>

                        </div>

                    </div>

                    <div class="about-card-content">

                        <?php echo nl2br(e(
                            \App\Models\Setting::get('org_description')
                        )); ?>


                    </div>

                </div>


                
                <?php if(\App\Models\Setting::get('org_history')): ?>

                    <div class="reveal fade-up delay-150 about-info-card">

                        <div class="about-card-heading">

                            <div class="about-icon about-icon-blue">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-history'); ?>
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

                            <div>

                                <span class="about-card-label">
                                    Perjalanan Organisasi
                                </span>

                                <h2>
                                    Sejarah
                                </h2>

                            </div>

                        </div>

                        <div class="about-card-content">

                            <?php echo nl2br(e(
                                \App\Models\Setting::get('org_history')
                            )); ?>


                        </div>

                    </div>

                <?php endif; ?>

            </div>


            
            <div class="about-side-column">

                
                <div class="reveal fade-up delay-100 about-vision-card">

                    <div class="about-vision-decoration"></div>

                    <div class="about-side-heading">

                        <div class="about-side-icon">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-eye'); ?>
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

                        <div>

                            <span>
                                Arah Organisasi
                            </span>

                            <h2>
                                Visi
                            </h2>

                        </div>

                    </div>

                    <div class="about-vision-text">

                        <?php echo e(\App\Models\Setting::get(
                            'org_vision',
                            'Belum ada data visi yang diatur.'
                        )); ?>


                    </div>

                </div>


                
                <div class="reveal fade-up delay-200 about-mission-card">

                    <div class="about-side-heading">

                        <div class="about-mission-icon">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-target'); ?>
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

                        <div>

                            <span>
                                Langkah Organisasi
                            </span>

                            <h2>
                                Misi
                            </h2>

                        </div>

                    </div>

                    <div class="about-mission-text">

                        <?php echo nl2br(e(
                            \App\Models\Setting::get(
                                'org_mission',
                                'Belum ada data misi yang diatur.'
                            )
                        )); ?>


                    </div>

                </div>

            </div>

        </div>

    </div>

</section>




<section class="philosophy-section">

    <div class="section-container">

        
        <div class="reveal fade-up philosophy-header">

            <span class="philosophy-eyebrow">
                Identitas & Filosofi
            </span>

            <h2 class="philosophy-heading">
                Filosofi Logo
            </h2>

            <p class="philosophy-description">
                Setiap elemen dalam lambang Cyber Open Source memiliki makna
                yang merepresentasikan identitas, keilmuan, Linux,
                dan semangat Open Source.
            </p>

            <p class="philosophy-description-small">
                Logo bukan sekadar identitas visual. Setiap warna, bentuk,
                dan elemen di dalamnya merepresentasikan bagian dari sejarah
                dan identitas organisasi.
            </p>

        </div>


        
        <?php

            $orgLogoVal = \App\Models\Setting::get('org_logo');

            $logoSrc = $orgLogoVal
                ? asset('images/' . $orgLogoVal)
                : asset('images/logo.png');

        ?>


        
        <div class="hidden lg:block philosophy-diagram">


            
            <div class="philosophy-penguin">

                <div class="penguin-philosophy-card flex flex-col items-center">

                    <div class="mb-2">
                        <img src="<?php echo e(asset('images/tux.png')); ?>" alt="Tux Linux Penguin" style="width: 32px; height: 32px;" class="object-contain">
                    </div>

                    <span class="text-[13px] font-semibold tracking-wide text-gray-500 uppercase mb-1">
                        PENGUIN
                    </span>

                    <h3 class="text-[18px] font-bold text-primary-navy mb-1.5 leading-snug">
                        Linux & Open Source
                    </h3>

                    <p class="text-[14px] text-gray-500 leading-relaxed max-w-[320px] m-0">
                        Melambangkan Linux dan semangat teknologi free/open source.
                    </p>

                </div>

            </div>


            
            <div class="philosophy-stage">


                
                <div class="philosophy-card-position philosophy-left-green">

                    <div class="philosophy-card philosophy-card-left">

                        <div class="philosophy-card-title-row">

                            <span class="philosophy-title philosophy-green">
                                Sistem Informasi
                            </span>

                            <span class="philosophy-dot philosophy-dot-green"></span>

                        </div>

                        <p>
                            Gir hijau
                        </p>

                    </div>

                </div>


                
                <div class="philosophy-card-position philosophy-left-red">

                    <div class="philosophy-card philosophy-card-left">

                        <div class="philosophy-card-title-row">

                            <span class="philosophy-title philosophy-red">
                                Teknik Komputer
                            </span>

                            <span class="philosophy-dot philosophy-dot-red"></span>

                        </div>

                        <p>
                            Gir merah
                        </p>

                    </div>

                </div>


                
                <div class="philosophy-card-position philosophy-left-yellow">

                    <div class="philosophy-card philosophy-card-left">

                        <div class="philosophy-card-title-row">

                            <span class="philosophy-title philosophy-yellow">
                                Komputerisasi Akuntansi
                            </span>

                            <span class="philosophy-dot philosophy-dot-yellow"></span>

                        </div>

                        <p>
                            Gir kuning
                        </p>

                    </div>

                </div>


                
                <div class="philosophy-card-position philosophy-left-cyan">

                    <div class="philosophy-card philosophy-card-left">

                        <div class="philosophy-card-title-row">

                            <span class="philosophy-title philosophy-cyan">
                                Teknik Informatika
                            </span>

                            <span class="philosophy-dot philosophy-dot-cyan"></span>

                        </div>

                        <p>
                            Gir biru muda
                        </p>

                    </div>

                </div>


                
                <div class="philosophy-card-position philosophy-right-gray">

                    <div class="philosophy-card philosophy-card-right">

                        <div class="philosophy-card-title-row philosophy-right-title">

                            <span class="philosophy-dot philosophy-dot-gray"></span>

                            <span class="philosophy-title philosophy-gray">
                                Persatuan COS UNITAMA
                            </span>

                        </div>

                        <p>
                            Warna abu-abu
                        </p>

                    </div>

                </div>


                
                <div class="philosophy-card-position philosophy-right-blue">

                    <div class="philosophy-card philosophy-card-right">

                        <div class="philosophy-card-title-row philosophy-right-title">

                            <span class="philosophy-dot philosophy-dot-blue"></span>

                            <span class="philosophy-title philosophy-blue">
                                Manajemen Informatika
                            </span>

                        </div>

                        <p>
                            Gir biru tua
                        </p>

                    </div>

                </div>



                
                <div class="philosophy-logo-wrapper">

                    <div class="philosophy-logo">

                        <img
                            src="<?php echo e($logoSrc); ?>"
                            alt="Logo UKM-IT Cyber Open Source"
                            class="philosophy-logo-image"
                            loading="lazy"
                        >

                    </div>

                </div>

            </div>


            
            <div class="reveal fade-up historical-context">

                <div class="history-context-card">

                    <div class="history-context-icon">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-history'); ?>
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

                    <div>

                        <span class="history-context-label">
                            Konteks Sejarah
                        </span>

                        <p>
                            Lima warna pada gir merepresentasikan program
                            studi/jurusan yang ada pada masa logo tersebut
                            dibuat dan ditetapkan pada tahun 2009. Representasi tersebut
                            merupakan bagian dari sejarah identitas visual
                            COS UNITAMA pada masanya.

                            Struktur dan nama program studi dapat berkembang
                            seiring waktu, sehingga makna warna pada logo
                            dipahami dalam konteks sejarah tersebut.
                        </p>

                    </div>

                </div>

            </div>

        </div>



        
        <div class="lg:hidden mobile-philosophy">


            
            <div class="reveal scale-in mobile-logo-container">

                <div class="mobile-logo">

                    <img
                        src="<?php echo e($logoSrc); ?>"
                        alt="Logo UKM-IT Cyber Open Source"
                        class="mobile-logo-image"
                        loading="lazy"
                    >

                </div>

            </div>


            
            <div class="mobile-timeline">

                <div class="mobile-timeline-line"></div>


                
                <div class="reveal fade-up mobile-timeline-item">

                    
                    <span class="timeline-dot bg-gray-300"></span>

                    <div class="mobile-philosophy-card flex flex-col items-center text-center !p-5 w-full">

                        <div class="mb-2">
                            <img src="<?php echo e(asset('images/tux.png')); ?>" alt="Tux Linux Penguin" style="width: 28px; height: 28px;" class="object-contain">
                        </div>

                        <span class="text-[13px] font-semibold tracking-wide text-gray-500 uppercase mb-1">
                            PENGUIN
                        </span>

                        <h4 class="!text-[18px] !font-bold text-primary-navy !mb-1.5 !mt-0">
                            Linux & Open Source
                        </h4>

                        <p class="!text-[14px] text-gray-500 !leading-relaxed !m-0">
                            Melambangkan Linux dan semangat teknologi free/open source.
                        </p>

                    </div>

                </div>


                
                <?php

                    $mobileColors = [

                        [
                            'label' => 'Hijau',
                            'name' => 'Sistem Informasi',
                            'dot' => 'bg-green-500',
                            'text' => 'text-green-600'
                        ],

                        [
                            'label' => 'Merah',
                            'name' => 'Teknik Komputer',
                            'dot' => 'bg-red-500',
                            'text' => 'text-red-600'
                        ],

                        [
                            'label' => 'Kuning',
                            'name' => 'Komputerisasi Akuntansi',
                            'dot' => 'bg-yellow-400',
                            'text' => 'text-yellow-600'
                        ],

                        [
                            'label' => 'Biru Muda',
                            'name' => 'Teknik Informatika',
                            'dot' => 'bg-cyan-400',
                            'text' => 'text-cyan-600'
                        ],

                        [
                            'label' => 'Biru Tua',
                            'name' => 'Manajemen Informatika',
                            'dot' => 'bg-blue-600',
                            'text' => 'text-blue-700'
                        ],

                        [
                            'label' => 'Abu-abu',
                            'name' => 'Persatuan COS UNITAMA',
                            'dot' => 'bg-gray-400',
                            'text' => 'text-gray-600'
                        ],

                    ];

                ?>


                <?php $__currentLoopData = $mobileColors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="reveal fade-up mobile-timeline-item">

                        <span class="timeline-dot <?php echo e($item['dot']); ?>"></span>

                        <div class="mobile-philosophy-card">

                            <div class="mobile-card-heading">

                                <span
                                    class="mobile-color-dot <?php echo e($item['dot']); ?>">
                                </span>

                                <span class="<?php echo e($item['text']); ?>">
                                    <?php echo e($item['label']); ?>

                                </span>

                            </div>

                            <h4>
                                <?php echo e($item['name']); ?>

                            </h4>

                        </div>

                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>


            
            <div class="reveal fade-up mobile-history">

                <div class="history-context-card">

                    <div class="history-context-icon">

                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-history'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
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

                    <div>

                        <span class="history-context-label">
                            Konteks Sejarah
                        </span>

                        <p>
                            Lima warna pada gir merepresentasikan program
                            studi/jurusan yang ada pada masa logo tersebut
                            dibuat dan ditetapkan. Representasi tersebut
                            merupakan bagian dari sejarah identitas visual
                            COS UNITAMA pada masanya.
                        </p>

                    </div>

                </div>

            </div>

        </div>



        
        <div class="max-w-5xl mx-auto logo-anatomy-section">

            <div class="reveal fade-up anatomy-wrapper">

                <div class="anatomy-header">

                    <span>
                        Anatomi Lambang
                    </span>

                    <h3>
                        Makna
                        <strong>C</strong>
                        <i>•</i>
                        <strong>O</strong>
                        <i>•</i>
                        <strong>S</strong>
                    </h3>

                </div>


                <div class="anatomy-grid">

                    
                    <div class="anatomy-card">

                        <div class="anatomy-letter">
                            C
                        </div>

                        <h4>
                            C
                        </h4>

                        <p>
                            Setengah lingkaran bergir.
                        </p>

                    </div>


                    
                    <div class="anatomy-card">

                        <div class="anatomy-letter">
                            O
                        </div>

                        <h4>
                            O
                        </h4>

                        <p>
                            Gabungan antara setengah lingkaran
                            dengan label nama CYBER OPEN SOURCE.
                        </p>

                    </div>


                    
                    <div class="anatomy-card">

                        <div class="anatomy-letter">
                            S
                        </div>

                        <h4>
                            S
                        </h4>

                        <p>
                            Berasal dari bentuk bibir seekor penguin
                            dan tampak seperti rokok tepat di bawah
                            bibirnya.
                        </p>

                    </div>

                </div>

            </div>


            
            <div class="reveal fade-up motto-section">

                <span>
                    Motto
                </span>

                <h3>
                    &ldquo;Open Your Mind for The Future With Open Source&rdquo;
                </h3>

            </div>

        </div>

    </div>

</section>




<?php $__env->startPush('styles'); ?>

<style>

/* ============================================================
   GLOBAL ABOUT HEADER
   ============================================================ */

.about-hero {
    padding-top: 3.25rem;
    padding-bottom: 3.25rem;
}

.about-eyebrow {
    display: block;
    margin-bottom: .65rem;

    font-size: .78rem;
    font-weight: 700;

    letter-spacing: .16em;
    text-transform: uppercase;
}

.about-title {
    margin: 0 0 1.15rem;

    color: #111827;

    font-size: clamp(2.2rem, 4vw, 3.4rem);
    line-height: 1.05;

    font-weight: 800;

    letter-spacing: -.035em;
}

.about-description {
    max-width: 760px;
    margin: 0;

    color: #6b7280;

    font-size: 1.05rem;
    line-height: 1.8;
}


/* ============================================================
   ABOUT OVERVIEW
   ============================================================ */

.about-overview-section {
    padding-top: 3.5rem;
    padding-bottom: 4.25rem;

    background: #ffffff;
}

.about-content-grid {
    display: grid;

    grid-template-columns:
        minmax(0, 1.65fr)
        minmax(320px, .85fr);

    gap: 2.5rem;

    align-items: start;
}

.about-main-column,
.about-side-column {
    display: flex;

    flex-direction: column;

    gap: 1.75rem;
}


/* ============================================================
   ABOUT CARD
   ============================================================ */

.about-info-card {
    position: relative;

    padding: 1.8rem 2rem;

    background: #ffffff;

    border: 1px solid #e5e7eb;
    border-radius: 20px;

    box-shadow:
        0 8px 30px rgba(7, 26, 82, .045);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;
}

.about-info-card:hover {
    transform: translateY(-2px);

    border-color: rgba(7, 26, 82, .12);

    box-shadow:
        0 14px 35px rgba(7, 26, 82, .075);
}

.about-card-heading {
    display: flex;

    align-items: center;

    gap: .9rem;

    margin-bottom: 1.35rem;
}

.about-icon {
    width: 44px;
    height: 44px;

    flex-shrink: 0;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 12px;
}

.about-icon-navy {
    color: #071a52;
    background: rgba(7, 26, 82, .07);
}

.about-icon-blue {
    color: #1e88e5;
    background: rgba(30, 136, 229, .08);
}

.about-card-label {
    display: block;

    margin-bottom: .15rem;

    color: #9ca3af;

    font-size: .68rem;
    font-weight: 700;

    letter-spacing: .14em;
    text-transform: uppercase;
}

.about-card-heading h2 {
    margin: 0;

    color: #111827;

    font-size: 1.35rem;
    line-height: 1.3;

    font-weight: 800;
}

.about-card-content {
    color: #6b7280;

    font-size: .95rem;
    line-height: 1.85;
}


/* ============================================================
   VISI
   ============================================================ */

.about-vision-card {
    position: relative;

    overflow: hidden;

    min-height: 220px;

    padding: 1.8rem;

    color: #ffffff;

    background:
        linear-gradient(
            145deg,
            #071a52 0%,
            #0b246d 100%
        );

    border-radius: 20px;

    box-shadow:
        0 14px 35px rgba(7, 26, 82, .14);
}

.about-vision-decoration {
    position: absolute;

    width: 150px;
    height: 150px;

    right: -60px;
    top: -65px;

    border-radius: 9999px;

    background: rgba(255, 255, 255, .08);
}

.about-vision-decoration::after {
    content: "";

    position: absolute;

    width: 80px;
    height: 80px;

    right: 65px;
    top: 75px;

    border-radius: 9999px;

    background: rgba(255, 255, 255, .05);
}

.about-side-heading {
    position: relative;

    display: flex;

    align-items: center;

    gap: .85rem;

    margin-bottom: 1.25rem;
}

.about-side-heading > div:last-child {
    min-width: 0;
}

.about-side-heading > div:last-child span {
    display: block;

    margin-bottom: .1rem;

    color: rgba(255, 255, 255, .58);

    font-size: .67rem;
    font-weight: 700;

    letter-spacing: .14em;
    text-transform: uppercase;
}

.about-side-heading h2 {
    margin: 0;

    color: #ffffff;

    font-size: 1.4rem;

    line-height: 1.2;

    font-weight: 800;
}

.about-side-icon {
    width: 43px;
    height: 43px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    color: #ffffff;

    background: rgba(255, 255, 255, .1);

    border: 1px solid rgba(255, 255, 255, .12);

    border-radius: 12px;
}

.about-vision-text {
    position: relative;

    color: rgba(255, 255, 255, .84);

    font-size: .91rem;
    line-height: 1.85;
}


/* ============================================================
   MISI
   ============================================================ */

.about-mission-card {
    position: relative;

    padding: 1.8rem;

    background: #ffffff;

    border: 1px solid #e5e7eb;

    border-top: 4px solid #1e88e5;

    border-radius: 20px;

    box-shadow:
        0 8px 30px rgba(7, 26, 82, .045);
}

.about-mission-card .about-side-heading {
    margin-bottom: 1.2rem;
}

.about-mission-card .about-side-heading > div:last-child span {
    color: #9ca3af;
}

.about-mission-card .about-side-heading h2 {
    color: #111827;
}

.about-mission-icon {
    width: 43px;
    height: 43px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 12px;

    color: #1e88e5;

    background: rgba(30, 136, 229, .08);
}

.about-mission-text {
    color: #6b7280;

    font-size: .9rem;
    line-height: 1.85;
}


/* ============================================================
   PHILOSOPHY SECTION
   ============================================================ */

.philosophy-section {
    position: relative;
    z-index: 0;
    isolation: isolate;

    padding-top: 4rem;
    padding-bottom: 4.75rem;

    /* Background benar-benar solid agar konten filosofi tidak
       terlihat/transparan ketika berada di bawah navbar. */
    background: #f9fafb;

    border-top: 1px solid #f0f1f3;

    overflow: hidden;
}

.philosophy-header {
    max-width: 800px;

    margin: 0 auto 2.5rem;

    text-align: center;
}

.philosophy-eyebrow {
    display: block;

    margin-bottom: .65rem;

    color: #1e88e5;

    font-size: .75rem;

    font-weight: 700;

    letter-spacing: .18em;

    text-transform: uppercase;
}

.philosophy-heading {
    margin: 0 0 1rem;

    color: #111827;

    font-size: clamp(2rem, 4vw, 3rem);

    line-height: 1.1;

    font-weight: 800;

    letter-spacing: -.035em;
}

.philosophy-description {
    margin: 0;

    color: #6b7280;

    font-size: 1rem;
    line-height: 1.8;
}

.philosophy-description-small {
    margin: .7rem 0 0;

    color: #9ca3af;

    font-size: .88rem;
    line-height: 1.7;
}


/* ============================================================
   MAIN DESKTOP DIAGRAM
   ============================================================ */

.philosophy-diagram {
    position: relative;
    isolation: isolate;

    /*
     * Ukuran utama diagram.
     * Semua connector dan logo mengikuti ukuran ini.
     */
    --logo-width: 280px;
    --logo-height: 340px;
    --card-width: 380px;
    --connector-size: 12px;

    width: 100%;

    max-width: 1450px;

    margin: 0 auto;
}


/* ============================================================
   PENGUIN PHILOSOPHY
   ============================================================ */

.philosophy-penguin {
    position: relative;
    width: 100%;
    height: auto;
    min-height: 140px;
    display: flex;
    flex-direction: column;
    align-items: center;
    z-index: 70;
}


/* CARD PENGUIN */

.penguin-philosophy-card {
    width: 430px;
    height: auto;
    min-height: 130px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 20px;
    text-align: center;
    background: rgba(255, 255, 255, .98);
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    box-shadow: 0 10px 28px rgba(7, 26, 82, .07);
}

/* (Tailwind is used for the inner hierarchy of penguin-philosophy-card now) */


/* ============================================================
   STAGE
   ============================================================ */

.philosophy-stage {
    position: relative;

    width: 100%;

    height: 620px;

    margin: 0 auto;

    overflow: visible;
}


/* ============================================================
   CENTER LOGO
   ============================================================ */

.philosophy-logo-wrapper {
    position: absolute;

    left: 50%;
    top: 50%;

    width: var(--logo-width);
    height: var(--logo-height);

    transform: translate(-50%, -50%);

    display: flex;

    align-items: center;
    justify-content: center;

    z-index: 8;

    pointer-events: none;
}

.philosophy-logo {
    width: 100%;
    height: 100%;

    display: flex;

    align-items: center;
    justify-content: center;
}

.philosophy-logo-image {
    display: block;

    width: 100%;
    height: 100%;

    object-fit: contain;

    object-position: center;

    background: transparent;
}


/* ============================================================
   PHILOSOPHY CARDS
   ============================================================ */

.philosophy-card-position {
    position: absolute;

    width: var(--card-width);

    z-index: 12;
}

.philosophy-card {
    width: 100%;

    min-height: 100px;

    display: flex;

    flex-direction: column;

    justify-content: center;

    padding: 17px 21px;

    background: rgba(255, 255, 255, .98);

    border: 1px solid #e5e7eb;

    border-radius: 16px;

    box-shadow:
        0 8px 24px rgba(7, 26, 82, .055);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;
}

.philosophy-card:hover {
    transform: translateY(-3px);

    border-color: rgba(7, 26, 82, .12);

    box-shadow:
        0 14px 35px rgba(7, 26, 82, .1);
}


/* KIRI */

.philosophy-card-left {
    text-align: right;
}


/* KANAN */

.philosophy-card-right {
    text-align: left;
}


/* ============================================================
   TITLE ROW
   ============================================================ */

.philosophy-card-title-row {
    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 12px;
}

.philosophy-right-title {
    justify-content: flex-start;
}

.philosophy-title {
    display: inline-block;

    font-size: 15px;

    line-height: 1.25;

    letter-spacing: .08em;

    font-weight: 800;
}

.philosophy-card p {
    margin: .3rem 0 0;

    color: #6b7280;

    font-size: 14px;

    line-height: 1.35;
}


/* ============================================================
   COLOR DOTS
   ============================================================ */

.philosophy-dot {
    width: 14px;
    height: 14px;

    flex-shrink: 0;

    border-radius: 9999px;
}


/* GREEN */

.philosophy-green {
    color: #16a34a;
}

.philosophy-dot-green {
    background: #22c55e;
}


/* RED */

.philosophy-red {
    color: #dc2626;
}

.philosophy-dot-red {
    background: #ef4444;
}


/* YELLOW */

.philosophy-yellow {
    color: #ca8a04;
}

.philosophy-dot-yellow {
    background: #facc15;
}


/* CYAN */

.philosophy-cyan {
    color: #0891b2;
}

.philosophy-dot-cyan {
    background: #22d3ee;
}


/* BLUE */

.philosophy-blue {
    color: #1d4ed8;
}

.philosophy-dot-blue {
    background: #2563eb;
}


/* GRAY */

.philosophy-gray {
    color: #4b5563;
}

.philosophy-dot-gray {
    background: #9ca3af;
}


/* ============================================================
   CARD POSITIONS
   ============================================================ */

.philosophy-left-green {
    left: 0;
    top: 35px;
}

.philosophy-left-red {
    left: 0;
    top: 175px;
}

.philosophy-left-yellow {
    left: 0;
    top: 315px;
}

.philosophy-left-cyan {
    left: 0;
    top: 455px;
}


/* RIGHT */

.philosophy-right-gray {
    right: 0;
    top: 175px;
}

.philosophy-right-blue {
    right: 0;
    top: 455px;
}


/* ============================================================
   LOGO EDGE PROTECTION
   ============================================================ */

.philosophy-logo-wrapper {
    overflow: visible;
}

.philosophy-logo-image {
    background: transparent;
    mix-blend-mode: normal;
}

/* ============================================================
   HISTORY CONTEXT
   ============================================================ */

.historical-context {
    margin-top: 2.5rem;
}

.history-context-card {
    display: flex;

    align-items: flex-start;

    gap: 1rem;

    padding: 1.25rem 1.5rem;

    background: #ffffff;

    border: 1px solid rgba(7, 26, 82, .1);

    border-radius: 17px;

    box-shadow:
        0 7px 24px rgba(7, 26, 82, .045);
}

.history-context-icon {
    width: 42px;
    height: 42px;

    flex-shrink: 0;

    display: flex;

    align-items: center;
    justify-content: center;

    color: #071a52;

    background: rgba(7, 26, 82, .055);

    border-radius: 11px;
}

.history-context-label {
    display: block;

    margin-bottom: .4rem;

    color: #111827;

    font-size: .72rem;

    font-weight: 800;

    letter-spacing: .14em;

    text-transform: uppercase;
}

.history-context-card p {
    margin: 0;

    color: #6b7280;

    font-size: .84rem;

    line-height: 1.75;
}


/* ============================================================
   ANATOMY
   ============================================================ */

.logo-anatomy-section {
    margin-top: 3rem;
}

.anatomy-wrapper {
    padding: 2.25rem;

    background: #ffffff;

    border: 1px solid #e5e7eb;

    border-radius: 20px;

    box-shadow:
        0 8px 30px rgba(7, 26, 82, .045);
}

.anatomy-header {
    margin-bottom: 2rem;

    text-align: center;
}

.anatomy-header > span {
    color: #1e88e5;

    font-size: .7rem;

    font-weight: 800;

    letter-spacing: .18em;

    text-transform: uppercase;
}

.anatomy-header h3 {
    margin: .45rem 0 0;

    color: #111827;

    font-size: 1.8rem;

    font-weight: 800;
}

.anatomy-header strong {
    color: #071a52;
}

.anatomy-header i {
    margin: 0 .35rem;

    color: #d1d5db;

    font-style: normal;
}

.anatomy-grid {
    display: grid;

    grid-template-columns: repeat(3, 1fr);

    gap: 1.25rem;
}

.anatomy-card {
    padding: 1.5rem;

    text-align: center;

    background: #f9fafb;

    border: 1px solid #f0f1f3;

    border-radius: 15px;

    transition:
        transform .25s ease,
        background .25s ease,
        box-shadow .25s ease;
}

.anatomy-card:hover {
    transform: translateY(-3px);

    background: #ffffff;

    box-shadow:
        0 10px 25px rgba(7, 26, 82, .07);
}

.anatomy-letter {
    width: 56px;
    height: 56px;

    margin: 0 auto;

    display: flex;

    align-items: center;
    justify-content: center;

    color: #071a52;

    background: #ffffff;

    border: 1px solid #e5e7eb;

    border-radius: 13px;

    font-size: 1.55rem;

    font-weight: 900;

    box-shadow:
        0 4px 12px rgba(7, 26, 82, .04);
}

.anatomy-card h4 {
    margin: 1rem 0 .4rem;

    color: #111827;

    font-size: 1rem;

    font-weight: 800;
}

.anatomy-card p {
    margin: 0;

    color: #6b7280;

    font-size: .83rem;

    line-height: 1.7;
}


/* ============================================================
   MOTTO
   ============================================================ */

.motto-section {
    margin-top: 2.75rem;

    text-align: center;
}

.motto-section > span {
    display: block;

    margin-bottom: .65rem;

    color: #9ca3af;

    font-size: .68rem;

    font-weight: 700;

    letter-spacing: .22em;

    text-transform: uppercase;
}

.motto-section h3 {
    margin: 0;

    color: #071a52;

    font-size: clamp(1.1rem, 2.5vw, 1.65rem);

    line-height: 1.5;

    font-weight: 800;

    font-style: italic;
}


/* ============================================================
   MOBILE PHILOSOPHY
   ============================================================ */

.mobile-philosophy {
    max-width: 620px;

    margin: 0 auto;
}

.mobile-logo-container {
    display: flex;

    align-items: center;
    justify-content: center;

    margin-bottom: 2rem;
}

.mobile-logo {
    width: 200px;
    height: 200px;

    display: flex;

    align-items: center;
    justify-content: center;
}

.mobile-logo-image {
    width: 100%;
    height: 100%;

    display: block;

    object-fit: contain;
}


/* ============================================================
   MOBILE TIMELINE
   ============================================================ */

.mobile-timeline {
    position: relative;

    display: flex;

    flex-direction: column;

    gap: 1rem;

    padding-left: 1.3rem;

    overflow: visible !important;
}

.mobile-timeline-line {
    position: absolute;

    left: 7px;

    top: 10px;
    bottom: 10px;

    width: 1px;

    background: #e5e7eb;
}

.mobile-timeline-item {
    position: relative;

    padding-left: 1rem;

    overflow: visible !important;
}

.timeline-dot {
    position: absolute;

    left: -1px;
    top: 18px;

    width: 15px;
    height: 15px;

    border: 4px solid #f9fafb;

    border-radius: 9999px;

    z-index: 20 !important;
}

.timeline-dot-navy {
    background: #071a52;
}

.mobile-philosophy-card {
    padding: 1rem;

    background: #ffffff;

    border: 1px solid #e5e7eb;

    border-radius: 15px;

    box-shadow:
        0 6px 20px rgba(7, 26, 82, .045);
}

.mobile-card-heading {
    display: flex;

    align-items: center;

    gap: .45rem;

    margin-bottom: .35rem;

    font-size: .68rem;

    font-weight: 800;

    letter-spacing: .1em;

    text-transform: uppercase;
}

.mobile-color-dot {
    width: 10px;
    height: 10px;

    flex-shrink: 0;

    border-radius: 9999px;
}

.bg-navy {
    background: #071a52;
}

.mobile-philosophy-card h4 {
    margin: 0;

    color: #111827;

    font-size: .9rem;

    font-weight: 700;
}

.mobile-philosophy-card p {
    margin: .35rem 0 0;

    color: #6b7280;

    font-size: .75rem;

    line-height: 1.65;
}

.mobile-history {
    margin-top: 1.75rem;
}


/* ============================================================
   ANIMATION
   ============================================================ */

.scale-in {
    animation:
        cosScaleIn
        .7s
        cubic-bezier(.22, 1, .36, 1)
        both;
}

@keyframes cosScaleIn {

    from {
        opacity: 0;

        transform: scale(.94);
    }

    to {
        opacity: 1;

        transform: scale(1);
    }

}


/* ============================================================
   TABLET
   ============================================================ */

@media (min-width: 1024px) and (max-width: 1279px) {

    .about-content-grid {
        grid-template-columns:
            minmax(0, 1.5fr)
            minmax(280px, .85fr);

        gap: 1.75rem;
    }


    /* PENGUIN */

    .philosophy-penguin {
        height: 115px;
    }

    .penguin-philosophy-card {
        width: 300px;
        min-height: 74px;

        padding: 10px 16px;
    }

    .penguin-philosophy-card h3 {
        font-size: .8rem;
    }

    .penguin-philosophy-card p {
        font-size: .64rem;
    }


    /* DIAGRAM */

    .philosophy-diagram {
        --logo-width: 220px;
        --logo-height: 267px;
        --card-width: 250px;
    }

    .philosophy-stage {
        height: 480px;
    }


    /* CARDS */

    .philosophy-card {
        min-height: 72px;

        padding: 13px 15px;
    }

    .philosophy-title {
        font-size: 12px;
    }

    .philosophy-card p {
        font-size: 11px;
    }

    .philosophy-dot {
        width: 11px;
        height: 11px;
    }


    /* POSITIONS */

    .philosophy-left-green {
        top: 30px;
    }

    .philosophy-left-red {
        top: 145px;
    }

    .philosophy-left-yellow {
        top: 260px;
    }

    .philosophy-left-cyan {
        top: 375px;
    }

    .philosophy-right-gray {
        top: 145px;
    }

    .philosophy-right-blue {
        top: 375px;
    }


}


/* ============================================================
   MOBILE
   ============================================================ */

@media (max-width: 1023px) {

    .about-hero {
        padding-top: 2.75rem;
        padding-bottom: 2.75rem;
    }

    .about-overview-section {
        padding-top: 2.5rem;
        padding-bottom: 3rem;
    }

    .about-content-grid {
        grid-template-columns: 1fr;

        gap: 1.5rem;
    }

    .about-main-column,
    .about-side-column {
        gap: 1.25rem;
    }

    .philosophy-section {
        padding-top: 3rem;
        padding-bottom: 3.5rem;
    }

    .philosophy-header {
        margin-bottom: 2.25rem;
    }

    .anatomy-grid {
        grid-template-columns: 1fr;
    }

}


/* ============================================================
   SMALL MOBILE
   ============================================================ */

@media (max-width: 640px) {

    .about-title {
        font-size: 2rem;
    }

    .about-description {
        font-size: .92rem;

        line-height: 1.7;
    }

    .about-info-card,
    .about-vision-card,
    .about-mission-card {
        padding: 1.35rem;
    }

    .about-card-heading {
        margin-bottom: 1rem;
    }

    .about-card-heading h2 {
        font-size: 1.15rem;
    }

    .about-card-content {
        font-size: .88rem;
    }

    .about-vision-text,
    .about-mission-text {
        font-size: .86rem;

        line-height: 1.8;
    }


    /* PHILOSOPHY */

    .philosophy-section {
        padding-top: 2.75rem;
        padding-bottom: 3.25rem;
    }

    .philosophy-heading {
        font-size: 2rem;
    }

    .philosophy-description {
        font-size: .9rem;
    }

    .philosophy-description-small {
        font-size: .8rem;
    }


    /* MOBILE LOGO */

    .mobile-logo {
        width: 185px;
        height: 185px;
    }

    .mobile-logo-container {
        margin-bottom: 1.5rem;
    }


    /* HISTORY */

    .history-context-card {
        padding: 1rem;
    }

    .history-context-card p {
        font-size: .76rem;
    }


    /* ANATOMY */

    .anatomy-wrapper {
        padding: 1.35rem;
    }

    .anatomy-header h3 {
        font-size: 1.5rem;
    }


    /* MOTTO */

    .motto-section {
        margin-top: 2rem;
    }

}


/* ============================================================
   NAVBAR PROTECTION
   ============================================================
   Navbar harus selalu berada di atas diagram filosofi. Dengan ini,
   ketika halaman discroll dan kartu/connector mencapai navbar,
   elemen filosofi tidak akan menembus atau terlihat transparan
   di atas navbar.
   ============================================================ */

header {
    z-index: 1000 !important;

    /* Navbar tetap solid/opaque ketika konten filosofi berada
       tepat di bawah atau melewati area navbar saat scroll. */
    background-color: #071a52 !important;
    opacity: 1 !important;
}

nav {
    z-index: 1000 !important;
}


/* ============================================================
   CONNECTOR PRECISION V3 — NATURAL GAP
   ============================================================
   Connector diberi sedikit jarak aman dari gir agar terlihat natural,
   tidak terlalu pas, dan tidak masuk ke area penguin/bagian tengah logo.
   ============================================================ */

.philosophy-connector {
    z-index: 9 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
}

.philosophy-connector span {
    width: 11px !important;
    height: 11px !important;
    box-shadow: 0 0 0 3px #f9fafb !important;
}

/* Hijau -> ujung gir hijau */
.connector-green {
    width: 205px !important;
    top: 85px !important;
    transform: rotate(18deg) !important;
}

/* Merah -> ujung gir merah */
.connector-red {
    width: 102px !important;
    top: 225px !important;
    transform: rotate(8deg) !important;
}

/* Kuning -> ujung gir kuning */
.connector-yellow {
    width: 100px !important;
    top: 365px !important;
    transform: rotate(-3deg) !important;
}

/* Cyan -> ujung gir biru muda */
.connector-cyan {
    width: 210px !important;
    top: 505px !important;
    transform: rotate(-13deg) !important;
}

/* Abu-abu -> sisi kanan gir/lingkar abu-abu */
.connector-gray {
    width: 142px !important;
    top: 225px !important;
    transform: rotate(-15deg) !important;
}

/* Biru tua -> ujung gir biru tua */
.connector-blue {
    width: 145px !important;
    top: 505px !important;
    transform: rotate(15deg) !important;
}

/* Jangan biarkan garis melewati badan penguin */
.philosophy-logo-wrapper {
    z-index: 8 !important;
    pointer-events: none !important;
}

.philosophy-logo-image {
    background: transparent !important;
    mix-blend-mode: normal !important;
}

/* Navbar benar-benar solid dan selalu memotong konten di bawahnya */
header {
    position: sticky !important;
    top: 0 !important;
    z-index: 10000 !important;
    background: #071a52 !important;
    opacity: 1 !important;
    isolation: isolate !important;
}

header::before,
header::after {
    opacity: 1 !important;
}

nav {
    position: sticky !important;
    top: 0 !important;
    z-index: 10001 !important;
    background: #071a52 !important;
    opacity: 1 !important;
}

/* ============================================================
   MOBILE TIMELINE COLORS FALLBACK
   ============================================================
   Mencegah dot dan teks berubah menjadi putih/hilang akibat 
   purge dari compiler Tailwind CSS.
   ============================================================ */

.bg-green-500 { background-color: #22c55e !important; }
.bg-red-500 { background-color: #ef4444 !important; }
.bg-yellow-400 { background-color: #facc15 !important; }
.bg-cyan-400 { background-color: #22d3ee !important; }
.bg-blue-600 { background-color: #2563eb !important; }
.bg-gray-400 { background-color: #9ca3af !important; }

.text-green-600 { color: #16a34a !important; }
.text-red-600 { color: #dc2626 !important; }
.text-yellow-600 { color: #ca8a04 !important; }
.text-cyan-600 { color: #0891b2 !important; }
.text-blue-700 { color: #1d4ed8 !important; }
.text-gray-600 { color: #4b5563 !important; }

/* ============================================================
   REDUCED MOTION
   ============================================================ */

@media (prefers-reduced-motion: reduce) {

    .scale-in {
        animation: none !important;

        opacity: 1 !important;

        transform: none !important;
    }

}

</style>

<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/public/about.blade.php ENDPATH**/ ?>