<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page_title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid-4" style="margin-bottom: 24px;">
    <div class="stat-card">
        <div class="stat-icon">
            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-users'); ?>
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
            <div class="stat-value"><?php echo e($stats['total_members'] ?? 0); ?></div>
            <div class="stat-label">Total Anggota</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
        </div>
        <div>
            <div class="stat-value"><?php echo e($stats['total_users']); ?></div>
            <div class="stat-label">Akun Sistem</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <div>
            <div class="stat-value"><?php echo e($stats['active_users']); ?></div>
            <div class="stat-label">Akun Aktif</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <div>
            <div class="stat-value"><?php echo e($stats['total_roles']); ?></div>
            <div class="stat-label">Role Akses</div>
        </div>
    </div>
</div>


<div style="display:grid;grid-template-columns:1fr 1.4fr;gap:20px;align-items:start;">

    
    <div class="card">
        <div class="card-body" style="padding: 40px; text-align: center;">
            <h2 style="font-size: 20px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                Selamat Datang di Sistem Manajemen UKM-IT COS
            </h2>
            <p class="text-muted" style="max-width: 600px; margin: 0 auto; line-height: 1.6;">
                Anda login sebagai <span class="font-semibold text-primary" style="color: var(--blue-600);"><?php echo e(auth()->user()->getRoleNames()->first() ?? 'Pengguna'); ?></span>.
                Gunakan menu di sidebar untuk mengelola data keanggotaan, kepengurusan, dan konten portal organisasi.
            </p>
            <div class="flex justify-center gap-4" style="margin-top: 32px;">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_members')): ?>
                <a href="<?php echo e(route('admin.members.index')); ?>" class="btn btn-primary">Lihat Data Anggota</a>
                <?php endif; ?>
                <a href="<?php echo e(url('/')); ?>" target="_blank" class="btn btn-secondary">Lihat Web Publik</a>
            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;">
            <h3 class="card-title" style="display:flex;align-items:center;gap:8px;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Jadwal Organisasi
            </h3>
            <?php if (\Illuminate\Support\Facades\Blade::check('role', 'Sekretaris')): ?>
            <a href="<?php echo e(route('admin.agendas.create')); ?>" class="btn btn-primary btn-sm" style="font-size:12px;">
                + Tambah Agenda
            </a>
            <?php endif; ?>
        </div>
        <div class="card-body" style="padding: 0;">
            <?php $__empty_1 = true; $__currentLoopData = $upcomingAgendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div style="display:flex;align-items:flex-start;gap:14px;padding:14px 20px;border-bottom:1px solid var(--gray-100);">

                
                <?php if($agenda->isMultiDay()): ?>
                    
                    <div style="min-width:90px;text-align:center;background:var(--blue-50,#eff6ff);border-radius:10px;padding:6px 8px;flex-shrink:0;">
                        <div style="font-size:11px;font-weight:700;color:var(--blue-600,#2563eb);line-height:1.4;white-space:nowrap;">
                            <?php echo e($agenda->agenda_date->translatedFormat('d M Y')); ?>

                        </div>
                        <div style="font-size:10px;color:var(--blue-400,#60a5fa);margin:2px 0;">s/d</div>
                        <div style="font-size:11px;font-weight:700;color:var(--blue-600,#2563eb);line-height:1.4;white-space:nowrap;">
                            <?php echo e($agenda->end_date->translatedFormat('d M Y')); ?>

                        </div>
                        <div style="font-size:9px;color:var(--blue-400,#60a5fa);margin-top:2px;">
                            (<?php echo e($agenda->agenda_date->diffInDays($agenda->end_date) + 1); ?> hari)
                        </div>
                    </div>
                <?php else: ?>
                    
                    <div style="min-width:46px;text-align:center;background:var(--blue-50,#eff6ff);border-radius:10px;padding:6px 4px;flex-shrink:0;">
                        <div style="font-size:18px;font-weight:700;color:var(--blue-600,#2563eb);line-height:1;"><?php echo e($agenda->agenda_date->format('d')); ?></div>
                        <div style="font-size:10px;font-weight:600;color:var(--blue-400,#60a5fa);text-transform:uppercase;letter-spacing:.5px;"><?php echo e($agenda->agenda_date->translatedFormat('M')); ?></div>
                        <div style="font-size:9px;color:var(--blue-400,#60a5fa);margin-top:2px;"><?php echo e($agenda->agenda_date->format('Y')); ?></div>
                    </div>
                <?php endif; ?>
                

                
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:600;font-size:14px;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?php echo e($agenda->title); ?></div>
                    <div style="display:flex;gap:12px;margin-top:4px;flex-wrap:wrap;">
                        <?php if($agenda->start_time): ?>
                        <span style="font-size:12px;color:var(--text-secondary);display:flex;align-items:center;gap:4px;">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <?php echo e(\Carbon\Carbon::parse($agenda->start_time)->format('H:i')); ?>

                            <?php if($agenda->end_time): ?> &ndash; <?php echo e(\Carbon\Carbon::parse($agenda->end_time)->format('H:i')); ?> <?php endif; ?>
                        </span>
                        <?php endif; ?>
                        <?php if($agenda->location): ?>
                        <span style="font-size:12px;color:var(--text-secondary);display:flex;align-items:center;gap:4px;">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <?php echo e($agenda->location); ?>

                        </span>
                        <?php endif; ?>
                    </div>
                    <?php if($agenda->type): ?>
                    <span style="display:inline-block;margin-top:5px;font-size:11px;padding:1px 8px;border-radius:20px;background:var(--gray-100);color:var(--text-secondary);"><?php echo e($agenda->type); ?></span>
                    <?php endif; ?>
                </div>

                
                <?php if (\Illuminate\Support\Facades\Blade::check('role', 'Sekretaris')): ?>
                <a href="<?php echo e(route('admin.agendas.edit', $agenda)); ?>" style="flex-shrink:0;padding:4px 10px;font-size:11px;border-radius:6px;border:1px solid var(--gray-300);color:var(--text-secondary);text-decoration:none;white-space:nowrap;align-self:center;" title="Edit Agenda">
                    Edit
                </a>
                <?php endif; ?>

            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div style="padding:40px 20px;text-align:center;color:var(--text-secondary);">
                <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 12px;display:block;opacity:.4;">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <p style="font-size:14px;">Tidak ada agenda mendatang</p>
                <?php if (\Illuminate\Support\Facades\Blade::check('role', 'Sekretaris')): ?>
                <a href="<?php echo e(route('admin.agendas.create')); ?>" class="btn btn-primary btn-sm" style="margin-top:10px;font-size:12px;">Tambah Agenda</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if($upcomingAgendas->count() > 0): ?>
            <div style="padding:12px 20px;text-align:right;border-top:1px solid var(--gray-100);">
                <a href="<?php echo e(route('admin.agendas.index')); ?>" style="font-size:13px;color:var(--blue-600,#2563eb);text-decoration:none;font-weight:500;">
                    Lihat Semua Agenda &rarr;
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>