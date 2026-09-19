

<?php $__env->startSection('title', 'Kontak'); ?>
<?php $__env->startSection('description', 'Hubungi UKM-IT Cyber Open Source untuk informasi lebih lanjut atau kerjasama.'); ?>

<?php $__env->startSection('content'); ?>


<section class="bg-white border-b border-gray-200 py-12 md:py-20">
    <div class="section-container">
        <div class="max-w-3xl">
            <span class="text-secondary-blue font-semibold tracking-wider uppercase text-sm mb-2 block">Hubungi Kami</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Pusat Informasi & Bantuan</h1>
            <p class="text-lg text-gray-600 leading-relaxed">
                Punya pertanyaan tentang UKM-IT COS? Ingin berkolaborasi? Jangan ragu untuk mengirimkan pesan kepada kami melalui form di bawah ini.
            </p>
        </div>
    </div>
</section>

<section class="section-spacing">
    <div class="section-container">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            
            <div class="lg:col-span-8">
                <div class="ui-card p-6 md:p-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan Baru</h2>
                    
                    <?php if(session('success')): ?>
                        <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 flex items-start gap-3">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-check-circle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 mt-0.5']); ?>
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
                            <div>
                                <h4 class="font-semibold">Pesan Berhasil Terkirim!</h4>
                                <p class="text-sm mt-1">Terima kasih telah menghubungi kami. Tim kami akan segera menindaklanjuti pesan Anda.</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('public.kontak.store')); ?>" method="POST" class="space-y-6">
                        <?php echo csrf_field(); ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="ui-label">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="ui-input" placeholder="Masukkan nama Anda" value="<?php echo e(old('name')); ?>" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ui-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label for="email" class="ui-label">Email / No. WA</label>
                                <input type="text" name="email" id="email" class="ui-input" placeholder="contoh@email.com atau 0812..." value="<?php echo e(old('email')); ?>" required>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ui-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div>
                            <label for="subject" class="ui-label">Subjek Pesan</label>
                            <input type="text" name="subject" id="subject" class="ui-input" placeholder="Topik atau alasan menghubungi kami" value="<?php echo e(old('subject')); ?>" required>
                            <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ui-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="message" class="ui-label">Isi Pesan</label>
                            <textarea name="message" id="message" rows="5" class="ui-input resize-y" placeholder="Tuliskan pesan atau pertanyaan Anda di sini..." required><?php echo e(old('message')); ?></textarea>
                            <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ui-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="btn-primary w-full md:w-auto px-8">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                Kirim Pesan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="lg:col-span-4">
                <div class="ui-card flex flex-col overflow-hidden">
                    <div class="p-6 md:p-8 pb-4 border-b border-gray-100 bg-gray-50/30">
                        <h3 class="font-bold text-gray-900 text-lg">Informasi Kontak</h3>
                    </div>
                    
                    <?php
                        $email = \App\Models\Setting::get('social_email');
                        $instagram = \App\Models\Setting::get('social_instagram');
                        $whatsapp = \App\Models\Setting::get('contact_whatsapp') ?? \App\Models\Setting::get('social_whatsapp');
                    ?>

                    <ul class="flex flex-col">
                        
                        
                        <li class="flex items-start gap-4 px-6 md:px-8 py-4 border-b border-gray-100 last:border-0 hover:bg-gray-50/50 transition-colors group">
                            <div class="w-9 h-9 bg-white border border-gray-200 group-hover:border-primary-navy/30 group-hover:bg-primary-navy/5 rounded-lg flex items-center justify-center text-gray-500 group-hover:text-primary-navy shrink-0 transition-colors shadow-sm">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-map-pin'); ?>
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
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] tracking-widest text-gray-700 mb-1">Sekretariat</p>
                                <p class="text-sm font-bold text-gray-900 leading-snug">Universitas Teknologi Akba Makassar</p>
                                <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">Jl. Perintis Kemerdekaan, Tamalanrea, Kec. Tamalanrea, Kota Makassar, Sulawesi Selatan 90245</p>
                            </div>
                        </li>

                        
                        <li class="flex items-start gap-4 px-6 md:px-8 py-4 border-b border-gray-100 last:border-0 hover:bg-gray-50/50 transition-colors group">
                            <div class="w-9 h-9 bg-white border border-gray-200 group-hover:border-primary-navy/30 group-hover:bg-primary-navy/5 rounded-lg flex items-center justify-center text-gray-500 group-hover:text-primary-navy shrink-0 transition-colors shadow-sm">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-phone'); ?>
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
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] tracking-widest text-gray-700 mb-1">WhatsApp</p>
                                <?php if($whatsapp): ?>
                                    <?php 
                                        $waLink = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsapp);
                                        if(strpos($waLink, 'https://wa.me/0') === 0) {
                                            $waLink = 'https://wa.me/62' . substr(preg_replace('/[^0-9]/', '', $whatsapp), 1);
                                        }
                                    ?>
                                    <a href="<?php echo e($waLink); ?>" target="_blank" rel="noopener noreferrer" class="text-sm font-bold text-gray-900 hover:text-primary-navy transition-colors truncate block focus:outline-none focus:underline">
                                        <?php echo e($whatsapp); ?>

                                    </a>
                                <?php else: ?>
                                    <a href="https://wa.me/6281346712939" target="_blank" rel="noopener noreferrer" class="text-sm font-bold text-gray-900 hover:text-primary-navy transition-colors truncate block focus:outline-none focus:underline">
                                        6281346712939
                                    </a>
                                <?php endif; ?>
                            </div>
                        </li>

                        
                        <li class="flex items-start gap-4 px-6 md:px-8 py-4 border-b border-gray-100 last:border-0 hover:bg-gray-50/50 transition-colors group">
                            <div class="w-9 h-9 bg-white border border-gray-200 group-hover:border-primary-navy/30 group-hover:bg-primary-navy/5 rounded-lg flex items-center justify-center text-gray-500 group-hover:text-primary-navy shrink-0 transition-colors shadow-sm">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-instagram'); ?>
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
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] tracking-widest text-gray-700  mb-1">Instagram</p>
                                <?php if($instagram): ?>
                                    <a href="<?php echo e($instagram); ?>" target="_blank" rel="noopener noreferrer" class="text-sm font-bold text-gray-900 hover:text-primary-navy transition-colors truncate block focus:outline-none focus:underline">
                                        <?php echo e('@' . trim(parse_url($instagram, PHP_URL_PATH), '/')); ?>

                                    </a>
                                <?php else: ?>
                                    <a href="https://instagram.com/cyberopensource" target="_blank" rel="noopener noreferrer" class="text-sm font-bold text-gray-900 hover:text-primary-navy transition-colors truncate block focus:outline-none focus:underline">
                                        @cyberopensource
                                    </a>
                                <?php endif; ?>
                            </div>
                        </li>

                        
                        <li class="flex items-start gap-4 px-6 md:px-8 py-4 border-b border-gray-100 last:border-0 hover:bg-gray-50/50 transition-colors group">
                            <div class="w-9 h-9 bg-white border border-gray-200 group-hover:border-primary-navy/30 group-hover:bg-primary-navy/5 rounded-lg flex items-center justify-center text-gray-500 group-hover:text-primary-navy shrink-0 transition-colors shadow-sm">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-mail'); ?>
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
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] tracking-widest text-gray-700 mb-1">Email</p>
                                <?php if($email): ?>
                                    <a href="mailto:<?php echo e($email); ?>" class="text-sm font-bold text-gray-900 hover:text-primary-navy transition-colors truncate block focus:outline-none focus:underline">
                                        <?php echo e($email); ?>

                                    </a>
                                <?php else: ?>
                                    <a href="mailto:ukmcosunitama@gmail.com" class="text-sm font-bold text-gray-900 hover:text-primary-navy transition-colors truncate block focus:outline-none focus:underline">
                                        ukmcosunitama@gmail.com
                                    </a>
                                <?php endif; ?>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/public/contact.blade.php ENDPATH**/ ?>