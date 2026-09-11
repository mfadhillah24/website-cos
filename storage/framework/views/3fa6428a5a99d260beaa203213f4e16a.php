

<?php $__env->startSection('title', 'Struktur Kepengurusan'); ?>
<?php $__env->startSection('page_title', 'Struktur Kepengurusan'); ?>
<?php $__env->startSection('breadcrumb', 'Kepengurusan / Struktur Pengurus'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <h2 class="card-title" style="margin: 0;">Pengurus <?php echo e($activePeriod && $activePeriod->is_active ? 'Aktif' : ''); ?> (Periode: <?php echo e($activePeriod->name ?? 'Belum ada periode'); ?>)</h2>
        
        <div style="display: flex; align-items: center; gap: 1rem;">
            <?php if(isset($periods) && $periods->count() > 0): ?>
                <select onchange="window.location.href = '<?php echo e(route('admin.managements.index')); ?>?period_id=' + this.value" 
                        class="form-control" 
                        style="width: auto; min-width: 180px; padding: 0.375rem 0.75rem; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    <option value="">-- Pilih Periode --</option>
                    <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p->id); ?>" <?php echo e($activePeriod && $activePeriod->id == $p->id ? 'selected' : ''); ?>>
                            <?php echo e($p->name); ?><?php echo e($p->is_active ? ' (Aktif)' : ''); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_management')): ?>
                <?php if($activePeriod): ?>
                <a href="<?php echo e(route('admin.managements.create')); ?>" class="btn btn-primary">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Pengurus
                </a>
                <?php else: ?>
                <span class="text-muted text-sm">Buat periode terlebih dahulu.</span>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Anggota</th>
                    <th>Jabatan</th>
                    <th>Mulai Menjabat</th>
                    <th>Status Akun</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $managements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $management): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div style="width:36px; height:36px; border-radius:18px; background:var(--gray-100); display:flex; align-items:center; justify-content:center; color:var(--gray-600); font-weight:600; font-size:12px;">
                                    <?php echo e(strtoupper(substr($management->member->name, 0, 2))); ?>

                                </div>
                                <div class="flex-col">
                                    <div class="font-semibold"><?php echo e($management->member->name); ?></div>
                                    <div class="text-xs text-muted"><?php echo e($management->member->nim ?? '-'); ?></div>
                                    <?php if($management->member->email): ?>
                                        <div class="text-xs text-muted mt-1" style="color:var(--blue-600);"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
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
<?php endif; ?> <?php echo e($management->member->email); ?></div>
                                    <?php else: ?>
                                        <div class="text-xs text-muted mt-1"><?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
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
<?php endif; ?> <em>Tidak ada email</em></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="font-semibold"><?php echo e($management->position->name); ?></div>
                            <?php if($management->notes): ?>
                            <div class="text-xs text-muted"><?php echo e($management->notes); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="text-muted text-sm"><?php echo e($management->started_at->format('d M Y')); ?></td>
                        <td>
                            <?php if($management->user_id): ?>
                                <span class="badge badge-blue">Terhubung</span>
                            <?php else: ?>
                                <span class="badge badge-gray">Belum Terhubung</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="<?php echo e(route('admin.managements.edit', $management)); ?>" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="<?php echo e(route('admin.managements.destroy', $management)); ?>" style="display:inline;">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus pengurus ini dari jabatan tersebut?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada pengurus di periode aktif ini.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/admin/managements/index.blade.php ENDPATH**/ ?>