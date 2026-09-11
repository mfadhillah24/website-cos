<?php $__env->startSection('title', 'Arsip Surat Masuk'); ?>
<?php $__env->startSection('page_title', 'Arsip Surat Masuk'); ?>
<?php $__env->startSection('breadcrumb', 'Administrasi / Surat Masuk / Arsip'); ?>

<?php $__env->startSection('content'); ?>


<div style="background: linear-gradient(135deg, #7c3aed, #5b21b6); border-radius:12px; padding:24px 28px; margin-bottom:24px; color:#fff; display:flex; align-items:center; gap:16px;">
    <div style="background:rgba(255,255,255,0.2); border-radius:10px; padding:12px; display:flex; align-items:center; justify-content:center;">
        <svg viewBox="0 0 24 24" style="width:28px;height:28px;stroke:#fff;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;"><path d="M21 8v13H3V8"/><path d="M1 3h22v5H1z"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
    </div>
    <div>
        <h2 style="font-size:18px;font-weight:700;margin:0 0 4px 0;">Arsip Surat Masuk</h2>
        <p style="font-size:13px;margin:0;opacity:0.85;">Lemari arsip digital — menampilkan seluruh surat masuk yang telah diarsipkan (<?php echo e($letters->total()); ?> surat)</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Surat Diarsipkan</h3>
        <a href="<?php echo e(route('admin.letters.incoming.index')); ?>" class="btn btn-secondary" style="display:flex;align-items:center;gap:6px;">
            <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali ke Surat Masuk
        </a>
    </div>
    <div class="card-body">

        
        <?php if(session('success')): ?>
            <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:16px;">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:16px;">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        
        <form method="GET" style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nomor, pengirim, perihal..."
                   value="<?php echo e(request('search')); ?>" style="width:260px;">

            <select name="year" class="form-control" style="width:130px;">
                <option value="">Semua Tahun</option>
                <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($y); ?>" <?php if(request('year') == $y): echo 'selected'; endif; ?>><?php echo e($y); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <?php if($letterTypes->isNotEmpty()): ?>
            <select name="letter_type" class="form-control" style="width:160px;">
                <option value="">Semua Jenis</option>
                <?php $__currentLoopData = $letterTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($lt); ?>" <?php if(request('letter_type') == $lt): echo 'selected'; endif; ?>><?php echo e($lt); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php endif; ?>

            <button type="submit" class="btn btn-secondary">Filter</button>
            <?php if(request()->anyFilled(['search', 'year', 'letter_type'])): ?>
                <a href="<?php echo e(route('admin.letters.incoming.archive.index')); ?>" class="btn btn-secondary">Reset</a>
            <?php endif; ?>
        </form>

        
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No. Agenda</th>
                        <th>No. Surat</th>
                        <th>Pengirim</th>
                        <th>Perihal</th>
                        <th>Jenis</th>
                        <th>Tgl Terima</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $letters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($letter->agenda_number ?? '-'); ?></td>
                        <td style="font-weight:500;"><?php echo e($letter->letter_number); ?></td>
                        <td><?php echo e($letter->sender); ?></td>
                        <td><?php echo e($letter->subject); ?></td>
                        <td><?php echo e($letter->letter_type ?? '-'); ?></td>
                        <td><?php echo e($letter->received_date->format('d/m/Y')); ?></td>
                        <td>
                            <span style="background:#f3e8ff;color:#7c3aed;border:1px solid #c4b5fd;font-size:11px;padding:3px 8px;border-radius:20px;font-weight:600;display:inline-block;">
                                📁 Diarsipkan
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                                
                                <a href="<?php echo e(route('admin.letters.incoming.show', $letter)); ?>" class="btn btn-secondary btn-sm">Detail</a>

                                
                                <?php if($letter->file_path): ?>
                                    <a href="<?php echo e(route('file.serve', $letter->file_path)); ?>" target="_blank" class="btn btn-sm" style="background:#eff6ff;color:#1d4ed8;border:1px solid #93c5fd;">
                                        📎 Lampiran
                                    </a>
                                <?php endif; ?>

                                
                                <form action="<?php echo e(route('admin.letters.incoming.unarchive', $letter)); ?>" method="POST" class="form-unarchive-archive">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="btn btn-sm" style="background:#ecfdf5;color:#065f46;border:1px solid #6ee7b7;" title="Kembalikan dari arsip">
                                        ↩ Kembalikan
                                    </button>
                                </form>

                                
                                <form action="<?php echo e(route('admin.letters.incoming.destroy', $letter)); ?>" method="POST" class="form-delete-archive">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus surat ini">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center" style="padding:40px; color:#64748b;">
                            <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                                <svg viewBox="0 0 24 24" style="width:40px;height:40px;stroke:#94a3b8;fill:none;stroke-width:1.5;"><path d="M21 8v13H3V8"/><path d="M1 3h22v5H1z"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                                <span>Tidak ada surat yang diarsipkan.</span>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div style="margin-top:20px;"><?php echo e($letters->links()); ?></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Konfirmasi Kembalikan dari halaman arsip
    document.querySelectorAll('.form-unarchive-archive').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (confirm('Kembalikan surat ini dari arsip?\n\nStatus surat akan dikembalikan ke kondisi sebelum diarsipkan dan surat tidak akan muncul lagi di halaman Arsip Surat.')) {
                form.submit();
            }
        });
    });

    // Konfirmasi Hapus dari halaman arsip
    document.querySelectorAll('.form-delete-archive').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin menghapus surat ini?\n\nData yang dihapus tidak dapat ditampilkan kembali, termasuk dari halaman Arsip Surat.')) {
                form.submit();
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/admin/letters/incoming/archive_list.blade.php ENDPATH**/ ?>