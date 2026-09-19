<?php $__env->startSection('title', 'Pendaftaran Anggota'); ?>
<?php $__env->startSection('description', 'Formulir pendaftaran anggota baru UKM-IT Cyber Open Source.'); ?>

<?php $__env->startSection('content'); ?>
<section class="bg-white border-b border-gray-200 py-12 md:py-20">
    <div class="section-container text-center">
        <div class="max-w-2xl mx-auto">
            <span class="text-secondary-blue font-semibold tracking-wider uppercase text-sm mb-2 block">Bergabung Bersama Kami</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Pendaftaran Anggota</h1>
            <p class="text-lg text-gray-600 leading-relaxed">
                Isi formulir di bawah ini dengan data yang valid untuk mendaftar sebagai calon anggota UKM-IT COS.
            </p>
        </div>
    </div>
</section>

<section class="section-spacing">
    <div class="section-container">
        <div class="max-w-4xl mx-auto">
            <div class="ui-card p-6 md:p-10 shadow-md border-t-4 border-t-primary-navy">
                <form action="<?php echo e(route('register.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
                    <?php echo csrf_field(); ?>
                    
                    
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Informasi Dasar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="ui-label">Nama Lengkap *</label>
                                <input type="text" name="name" id="name" class="ui-input" placeholder="Masukkan nama lengkap Anda" value="<?php echo e(old('name')); ?>" required>
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
                                <label for="nim" class="ui-label">NIM (Nomor Induk Mahasiswa) *</label>
                                <input type="text" name="nim" id="nim" class="ui-input" placeholder="Misal: 202100123" value="<?php echo e(old('nim')); ?>" required>
                                <?php $__errorArgs = ['nim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ui-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label for="email" class="ui-label">Alamat Email *</label>
                                <input type="email" name="email" id="email" class="ui-input" placeholder="contoh@email.com" value="<?php echo e(old('email')); ?>" required>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ui-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label for="phone" class="ui-label">Nomor WhatsApp *</label>
                                <input type="text" name="phone" id="phone" class="ui-input" placeholder="Misal: 08123456789" value="<?php echo e(old('phone')); ?>" required>
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ui-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label for="birth_place" class="ui-label">Tempat Lahir *</label>
                                <input type="text" name="birth_place" id="birth_place" class="ui-input" placeholder="Tempat Lahir" value="<?php echo e(old('birth_place')); ?>" required>
                                <?php $__errorArgs = ['birth_place'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ui-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label for="birth_date" class="ui-label">Tanggal Lahir *</label>
                                <input type="date" name="birth_date" id="birth_date" class="ui-input" value="<?php echo e(old('birth_date')); ?>" required>
                                <?php $__errorArgs = ['birth_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ui-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="md:col-span-2">
                                <label for="address" class="ui-label">Alamat Lengkap *</label>
                                <textarea name="address" id="address" rows="3" class="ui-input resize-y" placeholder="Alamat domisili saat ini" required><?php echo e(old('address')); ?></textarea>
                                <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ui-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Data Akademik & Pilihan Divisi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="study_program" class="ui-label">Program Studi *</label>
                                <input type="text" name="study_program" id="study_program" class="ui-input" placeholder="Misal: Teknik Informatika" value="<?php echo e(old('study_program')); ?>" required>
                                <?php $__errorArgs = ['study_program'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ui-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label for="batch_year" class="ui-label">Tahun Angkatan *</label>
                                <input type="number" name="batch_year" id="batch_year" class="ui-input" placeholder="Misal: 2023" value="<?php echo e(old('batch_year')); ?>" required min="2000" max="<?php echo e(date('Y')); ?>">
                                <?php $__errorArgs = ['batch_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ui-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label for="division_id" class="ui-label">Pilih Divisi *</label>
                                <select name="division_id" id="division_id" class="ui-input" required>
                                    <option value="">-- Pilih Divisi --</option>
                                    <?php $__currentLoopData = $divisions ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $div): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($div->id); ?>" <?php echo e(old('division_id') == $div->id ? 'selected' : ''); ?>><?php echo e($div->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['division_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ui-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="md:col-span-2">
                                <label for="reason" class="ui-label">Alasan Bergabung *</label>
                                <textarea name="reason" id="reason" rows="3" class="ui-input resize-y" placeholder="Ceritakan singkat alasan Anda ingin bergabung dengan UKM-IT COS" required><?php echo e(old('reason')); ?></textarea>
                                <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ui-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 text-right">
                        <button type="submit" class="btn-primary px-8 py-3 text-base w-full sm:w-auto">
                            Kirim Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/public/register.blade.php ENDPATH**/ ?>