<?php $__env->startSection('title', 'Surat Keluar'); ?>
<?php $__env->startSection('page_title', 'Surat Keluar'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Surat Keluar</h3>
        <a href="<?php echo e(route('admin.letters.outgoing.create')); ?>" class="btn btn-primary">+ Tambah Surat</a>
    </div>
    <div class="card-body">
        <div class="table-wrap">
            <table>
                <thead><tr><th>No. Surat</th><th>Kepada</th><th>Perihal</th><th>Tanggal</th><th>Status</th><th style="text-align:right">Aksi</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $letters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($letter->letter_number); ?></td>
                        <td><?php echo e($letter->receiver); ?></td>
                        <td><?php echo e($letter->subject); ?></td>
                        <td><?php echo e($letter->letter_date->format('d/m/Y')); ?></td>
                        <td><?php echo e(ucfirst(str_replace('_', ' ', $letter->status))); ?></td>
                        <td style="text-align:right">
                            <a href="<?php echo e(route('admin.letters.outgoing.show', $letter)); ?>" class="btn btn-secondary btn-sm">Detail</a>
                            <a href="<?php echo e(route('admin.letters.outgoing.edit', $letter)); ?>" class="btn btn-secondary btn-sm">Edit</a>
                            <form method="POST" action="<?php echo e(route('admin.letters.outgoing.destroy', $letter)); ?>" style="display:inline;">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="text-center" style="padding:20px;">Belum ada data.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if($letters->hasPages()): ?>
        <div style="margin-top:20px;">
            <?php echo e($letters->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/admin/letters/outgoing/index.blade.php ENDPATH**/ ?>