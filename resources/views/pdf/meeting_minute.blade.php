
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Notulen Rapat - {{ $meeting?->title ?? 'Notulen' }}</title>

    <style>
        /* ─── Reset & Base ─── */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10pt;
            color: #1e293b;
            line-height: 1.5;
            background: #fff;
        }

        /* ─── Page Layout ─── */
        .page {
            padding: 20mm 20mm 20mm 20mm;
        }

        /* ─── Header ─── */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .header-logo-cell {
            width: 75px;
            vertical-align: middle;
            padding-right: 12px;
        }

        .header-logo-cell img {
            width: 65px;
            height: auto;
        }

        .header-text-cell {
            vertical-align: middle;
        }

        .header-org {
            font-size: 13pt;
            font-weight: bold;
            color: #071A52;
            letter-spacing: 0.02em;
            line-height: 1.2;
        }

        .header-univ {
            font-size: 9pt;
            color: #334155;
            margin-top: 2px;
            letter-spacing: 0.01em;
        }

        .header-tagline {
            font-size: 8pt;
            color: #64748b;
            margin-top: 2px;
            font-style: italic;
        }

        .header-divider {
            width: 100%;
            border: none;
            border-top: 2px solid #071A52;
            margin: 8px 0 0 0;
        }

        .header-divider-thin {
            width: 100%;
            border: none;
            border-top: 1px solid #cbd5e1;
            margin: 2px 0 0 0;
        }

        /* ─── Document Title ─── */
        .doc-title-wrap {
            text-align: center;
            margin: 15px 0 15px 0;
        }

        .doc-title {
            font-size: 13pt;
            font-weight: bold;
            color: #071A52;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .doc-title-underbar {
            width: 40px;
            height: 2px;
            background: #071A52;
            margin: 4px auto 0 auto;
        }

        /* ─── Section ─── */
        .section {
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .section-header {
            display: table;
            width: 100%;
            margin-bottom: 4px;
        }

        .section-bullet {
            display: inline-block;
            width: 6px;
            height: 6px;
            background: #071A52;
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 6px;
            position: relative;
            top: -1px;
        }

        .section-title {
            font-size: 10pt;
            font-weight: bold;
            color: #071A52;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            vertical-align: middle;
        }

        .section-divider {
            width: 100%;
            border: none;
            border-top: 1px solid #cbd5e1;
            margin: 3px 0 5px 0;
        }

        /* ─── Info Table ─── */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 8.5pt;
            line-height: 1.25;
        }

        .info-table tr td {
            padding: 2px 5px;
            vertical-align: top;
            color: #1e293b;
            font-size: 8.5pt;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-table tr:last-child td {
            border-bottom: none;
        }

        .info-table tr td.label {
            width: 27%;
            color: #475569;
            font-weight: normal;
            padding-right: 8px;
        }

        .info-table tr td.colon {
            width: 10px;
            color: #94a3b8;
            padding: 2px 3px;
            text-align: center;
        }

        .info-table tr td.value {
            color: #1e293b;
            font-weight: normal;
        }

        /* ─── Content Block ─── */
        .content-block {
            font-size: 10pt;
            color: #1e293b;
            line-height: 1.6;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        /* ─── Footer ─── */
        .footer {
            position: fixed;
            bottom: 12mm;
            left: 20mm;
            right: 20mm;
            border-top: 1px solid #cbd5e1;
            padding-top: 4px;
            font-size: 8pt;
            color: #94a3b8;
        }

        .footer-left {
            float: left;
        }

        .footer-right {
            float: right;
        }

        .footer-clear {
            clear: both;
        }

        /* ─── Page Break ─── */
        .page-break {
            page-break-after: always;
        }

        .section-title-wrap {
            page-break-after: avoid;
        }
    </style>
</head>

<body>

    {{-- FOOTER (fixed, muncul di setiap halaman) --}}
    <div class="footer">
        <span class="footer-left">UKM-IT Cyber Open Source</span>
        <span class="footer-right" id="page-number"></span>
        <div class="footer-clear"></div>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script(function($PAGE_NUM, $PAGE_COUNT, $canvas, $fontMetrics) {
                $font = $fontMetrics->getFont('DejaVu Sans', 'normal');
                $canvas->text(
                    490,
                    $canvas->get_height() - 35,
                    'Halaman ' . $PAGE_NUM . ' dari ' . $PAGE_COUNT,
                    $font,
                    8,
                    [0.58, 0.64, 0.71]
                );
            });
        }
    </script>

    <div class="page">

        {{-- ────── HEADER ────── --}}
        <table class="header-table">
            <tr>
                <td class="header-logo-cell">
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
                        <img src="{{ $logoDataUri }}" alt="Logo UKM-IT COS">
                    @endif
                </td>

                <td class="header-text-cell">
                    <div class="header-org">
                        UKM-IT CYBER OPEN SOURCE
                    </div>

                    <div class="header-univ">
                        UNIVERSITAS TEKNOLOGI AKBA MAKASSAR
                    </div>

                    <div class="header-tagline">
                        Open Your Mind for The Future With Open Source
                    </div>
                </td>
            </tr>
        </table>

        <hr class="header-divider">
        <hr class="header-divider-thin">


        {{-- ────── INFORMASI RAPAT ────── --}}
        <div class="section">

            <div class="section-title-wrap">
                <span class="section-bullet"></span>
                <span class="section-title">Informasi Rapat</span>
                <hr class="section-divider">
            </div>

            <table class="info-table">

                @if ($meeting?->title)
                    <tr>
                        <td class="label">Topik</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $meeting->title }}</td>
                    </tr>
                @endif

                <tr>
                    <td class="label">Tanggal</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $tanggalFmt }}</td>
                </tr>

                <tr>
                    <td class="label">Waktu</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $waktuFmt }}</td>
                </tr>

                @if ($meeting?->location)
                    <tr>
                        <td class="label">Lokasi</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $meeting->location }}</td>
                    </tr>
                @endif

                @if ($meeting?->attendance_count !== null)
                    <tr>
                        <td class="label">Jumlah Peserta Hadir</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $meeting->attendance_count }} orang</td>
                    </tr>
                @endif

                @if ($minute->leader)
                    <tr>
                        <td class="label">Pemimpin Rapat</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $minute->leader }}</td>
                    </tr>
                @endif

                @if ($minute->notulist)
                    <tr>
                        <td class="label">Notulis</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $minute->notulist }}</td>
                    </tr>
                @endif

            </table>
        </div>


        {{-- ────── AGENDA RAPAT ────── --}}
        @if ($meeting?->agenda)
            <div class="section">

                <div class="section-title-wrap">
                    <span class="section-bullet"></span>
                    <span class="section-title">Agenda Rapat</span>
                    <hr class="section-divider">
                </div>

                <div class="content-block">
                    {{ $meeting->agenda }}
                </div>

            </div>
        @endif


        {{-- ────── HASIL PEMBAHASAN ────── --}}
        <div class="section">

            <div class="section-title-wrap">
                <span class="section-bullet"></span>
                <span class="section-title">Hasil Pembahasan</span>
                <hr class="section-divider">
            </div>

            <div class="content-block">
                {{ $minute->discussion_results }}
            </div>

        </div>


        {{-- ────── KEPUTUSAN ────── --}}
        @if ($minute->decisions)
            <div class="section">

                <div class="section-title-wrap">
                    <span class="section-bullet"></span>
                    <span class="section-title">Keputusan</span>
                    <hr class="section-divider">
                </div>

                <div class="content-block">
                    {{ $minute->decisions }}
                </div>

            </div>
        @endif

    </div>

</body>
</html>