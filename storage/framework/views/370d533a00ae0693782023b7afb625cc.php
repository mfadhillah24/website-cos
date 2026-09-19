

<?php $__env->startSection('title', 'Kegiatan'); ?>
<?php $__env->startSection('description', 'Daftar kegiatan, workshop, dan seminar yang diselenggarakan oleh UKM-IT Cyber Open Source.'); ?>

<?php $__env->startSection('content'); ?>


<section class="bg-white border-b border-gray-200 py-12 md:py-20">
    <div class="section-container">
        <div class="max-w-3xl">
            <span class="text-secondary-blue font-semibold tracking-wider uppercase text-sm mb-2 block">Program & Agenda</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Kegiatan UKM-IT COS</h1>
            <p class="text-lg text-gray-600 leading-relaxed">
                Jelajahi berbagai kegiatan, workshop, bootcamp, dan seminar yang diselenggarakan untuk meningkatkan keahlian di bidang teknologi.
            </p>
        </div>
    </div>
</section>

<section class="section-spacing">
    <div class="section-container">
        
        <?php if($activities->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('public.kegiatan.show', $activity->slug)); ?>" class="ui-card flex flex-col overflow-hidden ui-card-hover group">
                    <div class="aspect-[4/3] bg-gray-100 relative overflow-hidden">
                        <?php if($activity->thumbnail): ?>
                            <img src="<?php echo e(asset('images/' . $activity->thumbnail)); ?>" alt="<?php echo e($activity->title); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-calendar-days'); ?>
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
                        <?php if($activity->start_date): ?>
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur text-primary-navy font-bold px-3 py-1.5 rounded-lg shadow-sm text-center min-w-[60px]">
                                <span class="block text-xl leading-none"><?php echo e($activity->start_date->format('d')); ?></span>
                                <span class="block text-xs uppercase"><?php echo e($activity->start_date->format('M')); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <?php if($activity->division): ?>
                            <span class="text-secondary-blue text-xs font-semibold uppercase tracking-wider mb-2 block"><?php echo e($activity->division->name); ?></span>
                        <?php endif; ?>
                        <h2 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-secondary-blue transition-colors"><?php echo e($activity->title); ?></h2>
                        <p class="text-gray-500 text-sm line-clamp-3 flex-grow mb-4"><?php echo e($activity->description); ?></p>
                        
                        <div class="flex items-center justify-between text-xs text-gray-500 font-medium mt-auto">
                            <?php if($activity->location): ?>
                            <div class="flex items-center gap-1.5 line-clamp-1">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <?php echo e(Str::limit($activity->location, 20)); ?>

                            </div>
                            <?php endif; ?>
                            <span class="text-secondary-blue font-semibold flex items-center gap-1 ml-auto">
                                Lihat Detail
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
                            </span>
                        </div>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <div class="mt-12 flex justify-center">
                <?php echo e($activities->links()); ?>

            </div>
        <?php else: ?>
            <div class="ui-card p-12 text-center max-w-2xl mx-auto">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-calendar-days'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 mx-auto text-gray-300 mb-4']); ?>
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
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Kegiatan</h3>
                <p class="text-gray-500">Saat ini belum ada kegiatan yang dipublikasikan.</p>
            </div>
        <?php endif; ?>

    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/public/activities/index.blade.php ENDPATH**/ ?>