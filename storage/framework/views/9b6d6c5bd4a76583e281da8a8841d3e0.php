<?php $__env->startSection('title', 'Surat Masuk'); ?>
<?php $__env->startSection('page_title', 'Surat Masuk'); ?>
<?php $__env->startSection('breadcrumb', 'Administrasi / Surat Masuk'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header" style="flex-wrap: wrap; gap: 8px;">
        <h3 class="card-title">Daftar Surat Masuk</h3>
        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            <a href="<?php echo e(route('admin.letters.incoming.archive.index')); ?>" class="btn btn-secondary" style="display:flex;align-items:center;gap:6px;">
                <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;"><path d="M21 8v13H3V8"/><path d="M1 3h22v5H1z"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                Arsip Surat
            </a>
            <a href="<?php echo e(route('admin.letters.incoming.create')); ?>" class="btn btn-primary">+ Tambah Surat</a>
        </div>
    </div>
    <div class="card-body">
        
        <?php if(session('success')): ?>
            <div class="alert alert-success" style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:16px;">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger" style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:16px;">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <form method="GET" class="flex gap-3" style="margin-bottom:20px; flex-wrap:wrap;">
            <input type="text" name="search" class="form-control" placeholder="Cari nomor, pengirim, perihal..." value="<?php echo e(request('search')); ?>" style="width:250px;">
            <select name="status" class="form-control" style="width:160px;">
                <option value="">Semua Status</option>
                <option value="baru" <?php if(request('status')=='baru'): echo 'selected'; endif; ?>>Baru</option>
                <option value="diproses" <?php if(request('status')=='diproses'): echo 'selected'; endif; ?>>Diproses</option>
                <option value="didisposisikan" <?php if(request('status')=='didisposisikan'): echo 'selected'; endif; ?>>Didisposisikan</option>
                <option value="selesai" <?php if(request('status')=='selesai'): echo 'selected'; endif; ?>>Selesai</option>
                <option value="diarsipkan" <?php if(request('status')=='diarsipkan'): echo 'selected'; endif; ?>>Diarsipkan</option>
            </select>
            <button type="submit" class="btn btn-secondary">Filter</button>
            <?php if(request()->anyFilled(['search','status'])): ?>
                <a href="<?php echo e(route('admin.letters.incoming.index')); ?>" class="btn btn-secondary">Reset</a>
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
                        <th>Tgl Terima</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $letters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($letter->agenda_number ?? '-'); ?></td>
                        <td><?php echo e($letter->letter_number); ?></td>
                        <td><?php echo e($letter->sender); ?></td>
                        <td><?php echo e($letter->subject); ?></td>
                        <td><?php echo e($letter->received_date->format('d/m/Y')); ?></td>
                        <td>
                            <?php if($letter->status === 'diarsipkan'): ?>
                                <span class="badge" style="background:#f3e8ff;color:#7c3aed;border:1px solid #c4b5fd;font-size:11px;padding:3px 8px;border-radius:20px;font-weight:600;">
                                     Diarsipkan
                                </span>
                            <?php elseif($letter->status === 'baru'): ?>
                                <span class="badge badge-blue">Baru</span>
                            <?php elseif($letter->status === 'diproses'): ?>
                                <span class="badge" style="background:#fef3c7;color:#92400e;border:1px solid #fcd34d;font-size:11px;padding:3px 8px;border-radius:20px;">Diproses</span>
                            <?php elseif($letter->status === 'didisposisikan'): ?>
                                <span class="badge" style="background:#dbeafe;color:#1e40af;border:1px solid #93c5fd;font-size:11px;padding:3px 8px;border-radius:20px;">Didisposisikan</span>
                            <?php elseif($letter->status === 'selesai'): ?>
                                <span class="badge" style="background:#d1fae5;color:#065f46;border:1px solid #6ee7b7;font-size:11px;padding:3px 8px;border-radius:20px;">Selesai</span>
                            <?php else: ?>
                                <span class="badge badge-blue"><?php echo e(ucfirst($letter->status)); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                                <a href="<?php echo e(route('admin.letters.incoming.show', $letter)); ?>" class="btn btn-secondary btn-sm">Detail</a>

                                
                                <?php if($letter->status !== 'diarsipkan'): ?>
                                    <form action="<?php echo e(route('admin.letters.incoming.archive', $letter)); ?>" method="POST" class="form-archive">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-sm" style="background:#ede9fe;color:#5b21b6;border:1px solid #c4b5fd;" title="Arsipkan surat ini">
                                            📁 Arsipkan
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form action="<?php echo e(route('admin.letters.incoming.unarchive', $letter)); ?>" method="POST" class="form-unarchive">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-sm" style="background:#ecfdf5;color:#065f46;border:1px solid #6ee7b7;" title="Kembalikan dari arsip">
                                            ↩ Kembalikan
                                        </button>
                                    </form>
                                <?php endif; ?>

                                
                                <form action="<?php echo e(route('admin.letters.incoming.destroy', $letter)); ?>" method="POST" class="form-delete">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus surat ini">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7" class="text-center">Belum ada data surat masuk.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div style="margin-top:20px;"><?php echo e($letters->links()); ?></div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Konfirmasi Arsipkan
    document.querySelectorAll('.form-archive').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin mengarsipkan surat ini?\n\nSurat akan tetap ada di daftar surat masuk dengan status "Diarsipkan" dan akan muncul di halaman Arsip Surat.')) {
                form.submit();
            }
        });
    });

    // Konfirmasi Kembalikan
    document.querySelectorAll('.form-unarchive').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (confirm('Kembalikan surat ini dari arsip?\n\nStatus surat akan dikembalikan ke kondisi sebelum diarsipkan.')) {
                form.submit();
            }
        });
    });

    // Konfirmasi Hapus
    document.querySelectorAll('.form-delete').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin menghapus surat ini?\n\nData yang dihapus tidak dapat ditampilkan kembali.')) {
                form.submit();
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/admin/letters/incoming/index.blade.php ENDPATH**/ ?>