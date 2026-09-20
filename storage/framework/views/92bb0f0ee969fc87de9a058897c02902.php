

<?php $__env->startSection('title', 'Berita & Artikel'); ?>
<?php $__env->startSection('description', 'Kumpulan berita, artikel, dan informasi terbaru dari UKM-IT Cyber Open Source.'); ?>

<?php $__env->startSection('content'); ?>


<section class="bg-white border-b border-gray-200 py-12 md:py-20">
    <div class="section-container">
        <div class="max-w-3xl">
            <span class="text-secondary-blue font-semibold tracking-wider uppercase text-sm mb-2 block">Publikasi</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Berita & Artikel</h1>
            <p class="text-lg text-gray-600 leading-relaxed">
                Kumpulan tulisan, informasi terbaru, dan update kegiatan seputar UKM-IT COS.
            </p>
        </div>
    </div>
</section>

<section class="section-spacing">
    <div class="section-container">
        
        
        <?php if($categories->count() > 0): ?>
        <div class="mb-10 flex flex-wrap gap-2">
            <a href="<?php echo e(route('public.berita')); ?>" class="px-4 py-2 rounded-lg font-medium text-sm transition-colors border bg-primary-navy border-primary-navy text-white shadow-sm">
                Semua
            </a>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($cat->articles_count > 0): ?>
                <span class="px-4 py-2 rounded-lg font-medium text-sm border bg-white border-gray-200 text-gray-600 cursor-default">
                    <?php echo e($cat->name); ?> (<?php echo e($cat->articles_count); ?>)
                </span>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <?php if($articles->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('public.berita.show', $article->slug)); ?>" class="ui-card overflow-hidden ui-card-hover flex flex-col group">
                    <div class="aspect-video bg-gray-100 overflow-hidden relative">
                        <?php if($article->thumbnail): ?>
                            <img src="<?php echo e(asset('images/' . $article->thumbnail)); ?>" alt="<?php echo e($article->title); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
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
                            <span class="absolute top-4 left-4 bg-white/90 backdrop-blur text-primary-navy text-xs font-semibold px-2.5 py-1 rounded-md shadow-sm">
                                <?php echo e($article->category->name); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <p class="text-xs text-gray-400 mb-2 flex items-center gap-2">
                            <span><?php echo e($article->published_at?->translatedFormat('d M Y') ?? 'Draft'); ?></span>
                            <span>•</span>
                            <span><?php echo e($article->author?->name ?? 'Admin'); ?></span>
                        </p>
                        <h2 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-secondary-blue transition-colors"><?php echo e($article->title); ?></h2>
                        <p class="text-gray-500 text-sm line-clamp-3 flex-grow mb-0"><?php echo e($article->excerpt); ?></p>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="mt-12 flex justify-center">
                <?php echo e($articles->links()); ?>

            </div>
        <?php else: ?>
            <div class="ui-card p-12 text-center max-w-2xl mx-auto">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-image'); ?>
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
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Artikel</h3>
                <p class="text-gray-500">Belum ada berita atau artikel yang dipublikasikan saat ini.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/public/articles/index.blade.php ENDPATH**/ ?>