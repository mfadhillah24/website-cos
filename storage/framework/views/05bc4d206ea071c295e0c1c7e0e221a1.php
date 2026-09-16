<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Peserta Registrasi Online — COS UNITAMA</title>
    <style>
        /* ── Reset & Base ─────────────────────────────────── */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #1a1a2e;
            line-height: 1.4;
        }

        /* ── Header Dokumen ────────────────────────────────── */
        .doc-header {
            width: 100%;
            border-bottom: 3px solid #071A52;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }

        .header-inner {
            width: 100%;
            border-collapse: collapse;
        }

        .header-logo {
            width: 70px;
            vertical-align: middle;
            text-align: left;
        }

        .header-logo img {
            width: 60px;
            height: auto;
        }

        .header-text {
            vertical-align: middle;
            text-align: center;
            padding: 0 10px;
        }

        .header-org {
            font-size: 16px;
            font-weight: bold;
            color: #071A52;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .header-tagline {
            font-size: 9px;
            color: #555;
        }

        .header-inst {
            font-size: 9px;
            color: #444;
            margin-top: 2px;
            font-style: italic;
        }

        .header-spacer {
            width: 70px;
        }

        /* ── Judul Laporan ─────────────────────────────────── */
        .report-title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: underline;
            color: #071A52;
            margin-bottom: 8px;
        }

        /* ── Info Meta ─────────────────────────────────────── */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 9.5px;
        }

        .meta-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .meta-label {
            width: 130px;
            color: #444;
            font-weight: bold;
        }

        .meta-sep {
            width: 10px;
            color: #444;
        }

        .meta-value {
            color: #1a1a2e;
        }

        /* ── Tabel Data ────────────────────────────────────── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .data-table thead tr {
            background-color: #071A52;
            color: #ffffff;
        }

        .data-table thead th {
            padding: 7px 6px;
            text-align: left;
            font-size: 9.5px;
            font-weight: bold;
            letter-spacing: 0.3px;
            border: 1px solid #071A52;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f0f4ff;
        }

        .data-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .data-table tbody td {
            padding: 5px 6px;
            border: 1px solid #c8d0e0;
            font-size: 9.5px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .col-no      { width: 3%; text-align: center; }
        .col-regid   { width: 12%; }
        .col-nim     { width: 12%; }
        .col-name    { width: 24%; }
        .col-prodi   { width: 20%; }
        .col-divisi  { width: 15%; }
        .col-year    { width: 8%;  text-align: center; }

        .td-center  { text-align: center; }
        .text-muted { color: #888; font-style: italic; }

        /* ── Empty State ───────────────────────────────────── */
        .empty-row td {
            text-align: center;
            padding: 30px;
            color: #888;
            font-style: italic;
        }

        /* ── Footer ────────────────────────────────────────── */
        .doc-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 1px solid #c8d0e0;
            padding-top: 5px;
            font-size: 8px;
            color: #888;
            text-align: center;
        }

        /* ── Page number (Dompdf native) ───────────────────── */
        .page-number:before {
            content: "Halaman " counter(page) " dari " counter(pages);
        }

        /* Pastikan body punya padding agar footer tidak menimpa konten */
        body { padding-bottom: 28px; }
    </style>
</head>
<body>

    
    <div class="doc-header">
        <table class="header-inner">
            <tr>
                <td class="header-logo">
                    <?php
                        $logoPath = public_path('images/logo.png');
                        $logoBase64 = '';
                        if (file_exists($logoPath)) {
                            $logoData = file_get_contents($logoPath);
                            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
                        }
                    ?>
                    <?php if($logoBase64): ?>
                        <img src="<?php echo e($logoBase64); ?>" alt="Logo COS">
                    <?php endif; ?>
                </td>
                <td class="header-text">
                    <div class="header-org">UKM-IT Cyber Open Source</div>
                    <div class="header-tagline">Open Your Mind for The Future With Open Source</div>
                    <div class="header-inst">Universitas Teknologi Akba Makassar (UNITAMA)</div>
                </td>
                <td class="header-spacer"></td>
            </tr>
        </table>
    </div>

    
    <div class="report-title">Daftar Peserta Registrasi Online</div>

    
    <table class="meta-table">
        <tr>
            <td class="meta-label">Tanggal Export</td>
            <td class="meta-sep">:</td>
            <td class="meta-value"><?php echo e(now()->translatedFormat('l, d F Y')); ?> pukul <?php echo e(now()->format('H:i')); ?> WITA</td>
        </tr>
        <tr>
            <td class="meta-label">Filter Aktif</td>
            <td class="meta-sep">:</td>
            <td class="meta-value"><?php echo e($filterLabel); ?></td>
        </tr>
        <tr>
            <td class="meta-label">Jumlah Peserta</td>
            <td class="meta-sep">:</td>
            <td class="meta-value"><?php echo e($registrations->count()); ?> orang</td>
        </tr>
    </table>

    
    <table class="data-table">
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-regid">Registration ID</th>
                <th class="col-nim">NIM</th>
                <th class="col-name">Nama Lengkap</th>
                <th class="col-prodi">Program Studi</th>
                <th class="col-divisi">Divisi Pilihan</th>
                <th class="col-year">Angkatan</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    
                    <td class="col-no td-center"><?php echo e($index + 1); ?></td>

                    
                    <td class="col-regid">
                        REG-<?php echo e(str_pad($reg->id, 4, '0', STR_PAD_LEFT)); ?>-<?php echo e(date('Y')); ?>

                    </td>

                    <td class="col-nim"><?php echo e($reg->nim ?? '-'); ?></td>

                    <td class="col-name"><?php echo e($reg->name ?? '-'); ?></td>

                    <td class="col-prodi"><?php echo e($reg->study_program ?? '-'); ?></td>

                    <td class="col-divisi"><?php echo e($reg->division?->name ?? '-'); ?></td>

                    <td class="col-year td-center"><?php echo e($reg->batch_year ?? '-'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr class="empty-row">
                    <td colspan="7">
                        Tidak ada data peserta yang sesuai dengan filter yang dipilih.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    
    <div class="doc-footer">
        Dicetak otomatis dari Sistem Informasi UKM-IT COS — UNITAMA &nbsp;|&nbsp;
        <?php echo e(now()->format('d/m/Y H:i:s')); ?> &nbsp;|&nbsp;
        <span class="page-number"></span>
    </div>

</body>
</html>
<?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/pdf/registration_list.blade.php ENDPATH**/ ?>