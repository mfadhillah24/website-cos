<?php $__env->startSection('title', 'Pengaturan Website'); ?>
<?php $__env->startSection('page_title', 'Pengaturan Website'); ?>
<?php $__env->startSection('breadcrumb', 'Sistem / Pengaturan Website'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width: 900px;">

    <?php if(session('success')): ?>
        <div class="alert alert-success" style="margin-bottom:16px;"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        
        <div style="display:flex; gap:0; margin-bottom:20px; border-bottom:2px solid #e2e8f0;">
            <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $groupSettings): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button type="button"
                onclick="switchTab('<?php echo e($group); ?>')"
                id="tab-btn-<?php echo e($group); ?>"
                style="padding:10px 20px; border:none; background:none; font-size:13px; font-weight:600; cursor:pointer;
                       border-bottom:3px solid <?php echo e($loop->first ? '#1E88E5' : 'transparent'); ?>;
                       color:<?php echo e($loop->first ? '#1E88E5' : '#64748B'); ?>;
                       margin-bottom:-2px; transition:all 0.2s;">
                <?php if($group === 'general'): ?> ⚙️ Umum
                <?php elseif($group === 'about'): ?> 🏫 Tentang UKM
                <?php elseif($group === 'social'): ?> 📱 Media Sosial
                <?php elseif($group === 'contact'): ?> 📞 Kontak
                <?php else: ?> <?php echo e(ucfirst($group)); ?>

                <?php endif; ?>
            </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $groupSettings): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div id="tab-<?php echo e($group); ?>" style="<?php echo e($loop->first ? '' : 'display:none;'); ?>">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <?php if($group === 'general'): ?> Pengaturan Umum
                        <?php elseif($group === 'about'): ?> Profil & Tentang UKM
                        <?php elseif($group === 'social'): ?> Media Sosial
                        <?php elseif($group === 'contact'): ?> Informasi Kontak
                        <?php else: ?> <?php echo e(ucfirst($group)); ?>

                        <?php endif; ?>
                    </h2>
                    <p style="font-size:13px; color:#64748B; margin-top:4px;">
                        <?php if($group === 'about'): ?> Data ini akan tampil di halaman <strong>Tentang UKM</strong> pada website publik (visi, misi, sejarah).
                        <?php elseif($group === 'general'): ?> Pengaturan dasar tampilan website.
                        <?php elseif($group === 'social'): ?> Link media sosial di footer dan halaman kontak.
                        <?php elseif($group === 'contact'): ?> Informasi kontak untuk halaman kontak publik.
                        <?php endif; ?>
                    </p>
                </div>
                <div class="card-body">
                    <?php $__currentLoopData = $groupSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group">
                            <label class="form-label" for="setting_<?php echo e($setting->key); ?>"><?php echo e($setting->label); ?></label>

                            <?php if($setting->type == 'textarea'): ?>
                                <textarea
                                    id="setting_<?php echo e($setting->key); ?>"
                                    name="<?php echo e($setting->key); ?>"
                                    rows="<?php echo e(in_array($setting->key, ['org_vision','org_mission','org_history']) ? 7 : 3); ?>"
                                    class="form-control"
                                    placeholder="Belum diisi..."
                                ><?php echo e(old($setting->key, $setting->value)); ?></textarea>
                                <?php if(in_array($setting->key, ['org_vision','org_mission'])): ?>
                                    <small style="color:#94A3B8; font-size:12px; margin-top:4px; display:block;">
                                        💡 Untuk misi: pisahkan setiap poin dengan baris baru (Enter). Setiap baris akan tampil sebagai item terpisah.
                                    </small>
                                <?php endif; ?>

                            <?php elseif($setting->type == 'image'): ?>
                                <?php if($setting->value): ?>
                                    <div style="margin-bottom:10px;">
                                        <img src="<?php echo e(asset('images/' . $setting->value)); ?>" alt="<?php echo e($setting->label); ?>"
                                             style="max-height:80px; border-radius:8px; border:1px solid #e2e8f0; padding:4px;">
                                    </div>
                                <?php endif; ?>
                                <input id="setting_<?php echo e($setting->key); ?>" type="file"
                                       name="<?php echo e($setting->key); ?>" accept="image/*"
                                       class="form-control" style="padding-top:6px;">

                            <?php else: ?>
                                <input id="setting_<?php echo e($setting->key); ?>"
                                       type="<?php echo e($setting->type == 'url' ? 'url' : 'text'); ?>"
                                       name="<?php echo e($setting->key); ?>"
                                       value="<?php echo e(old($setting->key, $setting->value)); ?>"
                                       class="form-control"
                                       placeholder="Belum diisi...">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="flex gap-3" style="margin-top:24px;">
            <button type="submit" class="btn btn-primary">Simpan Semua Pengaturan</button>
        </div>
    </form>
</div>

<script>
function switchTab(group) {
    document.querySelectorAll('[id^="tab-"]:not([id^="tab-btn-"])').forEach(el => el.style.display = 'none');
    document.querySelectorAll('[id^="tab-btn-"]').forEach(btn => {
        btn.style.borderBottomColor = 'transparent';
        btn.style.color = '#64748B';
    });
    document.getElementById('tab-' + group).style.display = '';
    const btn = document.getElementById('tab-btn-' + group);
    btn.style.borderBottomColor = '#1E88E5';
    btn.style.color = '#1E88E5';
}
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>