<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran - {{ $registration->nim }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #071A52;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #071A52;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            text-decoration: underline;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table th, .info-table td {
            padding: 5px 8px;
            border: 1px solid #ddd;
        }
        .info-table th {
            width: 30%;
            background-color: #f9f9f9;
            text-align: left;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .photo-box {
            width: 120px;
            height: 160px;
            border: 1px solid #999;
            margin: 0 auto 20px;
            text-align: center;
            line-height: 160px;
            color: #999;
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>

    <table style="width: 100%; border-bottom: 2px solid #071A52; margin-bottom: 20px; padding-bottom: 10px;">
        <tr>
            <td style="width: 20%; text-align: left;">
                @php
                    $resolvedLogoPath = isset($logoPath) && file_exists($logoPath)
                        ? $logoPath
                        : public_path('images/logo.png');
                    $logoDataUri = null;
                    if (file_exists($resolvedLogoPath)) {
                        $type = pathinfo($resolvedLogoPath, PATHINFO_EXTENSION);
                        $data = file_get_contents($resolvedLogoPath);
                        $logoDataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    }
                @endphp
                @if($logoDataUri)
                    <img src="{{ $logoDataUri }}" style="width: 70px; height: auto;" alt="Logo">
                @endif

            </td>
            <td style="width: 60%; text-align: center;">
                <h1 style="color: #071A52; margin: 0; font-size: 24px;">UKM-IT Cyber Open Source</h1>
                <p style="margin: 5px 0 0 0; color: #666;">Open Your Mind for The Future With Open Source</p>
            </td>
            <td style="width: 20%;"></td>
        </tr>
    </table>

    <div class="title">
        Formulir Pendaftaran
    </div>

    <table class="info-table">
        <tr>
            <th>Nomor Pendaftaran</th>
            <td>REG-{{ str_pad($registration->id, 4, '0', STR_PAD_LEFT) }}-{{ date('Y') }}</td>
        </tr>
        <tr>
            <th>Tanggal Daftar</th>
            <td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <th>Nama Lengkap</th>
            <td>{{ $registration->name }}</td>
        </tr>
        <tr>
            <th>NIM</th>
            <td>{{ $registration->nim }}</td>
        </tr>
        <tr>
            <th>Program Studi</th>
            <td>{{ $registration->study_program }}</td>
        </tr>
        <tr>
            <th>Tahun Angkatan</th>
            <td>{{ $registration->batch_year }}</td>
        </tr>
        <tr>
            <th>Divisi Pilihan</th>
            <td>{{ $registration->division->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $registration->email }}</td>
        </tr>
        <tr>
            <th>No. WhatsApp</th>
            <td>{{ $registration->phone }}</td>
        </tr>
        <tr>
            <th>Tempat, Tgl Lahir</th>
            <td>{{ $registration->birth_place ?? '-' }}, {{ $registration->birth_date ? \Carbon\Carbon::parse($registration->birth_date)->format('d/m/Y') : '-' }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $registration->address ?? '-' }}</td>
        </tr>
        <tr>
            <th>Alasan Bergabung</th>
            <td>{{ $registration->reason }}</td>
        </tr>
    </table>

    <div style="page-break-inside: avoid;">
        <p style="text-align: justify; font-size: 12px; margin-top: 10px; margin-bottom: 5px;">
            Dengan ini saya menyatakan bahwa data yang saya isikan adalah benar. Saya bersedia mengikuti seluruh peraturan dan tahapan seleksi calon anggota baru UKM-IT Cyber Open Source.
        </p>

        <table style="width: 100%; margin-top: 15px; text-align: center; page-break-inside: avoid;">
            <tr>
                <td style="width: 50%;"></td>
                <td style="width: 50%;">
                    <p>Makassar, {{ date('d F Y') }}</p>
                    <br><br><br><br>
                    <p><strong>( {{ $registration->name }} )</strong></p>
                    <p>Calon Anggota</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
       Open Your Mind for The Future With Open Source
    </div>

</body>
</html>
