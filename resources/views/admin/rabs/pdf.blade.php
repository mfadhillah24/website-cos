<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RAB — {{ $rab->activity_name }}</title>

    <style>
        /*
        |--------------------------------------------------------------------------
        | RESET & BASE
        |--------------------------------------------------------------------------
        */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        @page {
            size: A4 portrait;
            margin: 18mm 20mm 18mm 20mm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 8pt;
            color: #172033;
            background: #ffffff;
            line-height: 1.35;
        }

        /*
        |--------------------------------------------------------------------------
        | PAGE CONTENT
        |--------------------------------------------------------------------------
        */

        .page {
            width: 100%;
            margin: 0 auto;
        }

        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        .header {
            width: 100%;
            text-align: center;

            padding-top: 8px;
            padding-bottom: 8px;

            margin-bottom: 0;

            border-bottom: 1px solid #071A52;
        }

        .header-logo {
    height: 50px;
    width: auto;

    display: block;
    margin: 2px auto 6px auto;
}

        .organization-name {
            font-size: 11pt;
            font-weight: 700;
            color: #071A52;

            line-height: 1.2;

            margin-bottom: 2px;

            letter-spacing: 0.15px;
        }

        .organization-address {
            font-size: 7.5pt;
            font-weight: 400;
            color: #64748B;

            line-height: 1.2;
        }

        /*
        |--------------------------------------------------------------------------
        | DOCUMENT TITLE
        |--------------------------------------------------------------------------
        */

        .document-title {
            text-align: center;

            margin-top: 10px;
            margin-bottom: 12px;

            font-size: 12pt;
            line-height: 1.2;

            font-weight: 700;
            color: #071A52;

            letter-spacing: 0.35px;
        }

        /*
        |--------------------------------------------------------------------------
        | CONTENT WRAPPER
        |--------------------------------------------------------------------------
        */

        .content-wrapper {
            width: 90%;
            margin: 0 auto;
        }

        /*
        |--------------------------------------------------------------------------
        | RAB INFORMATION
        |--------------------------------------------------------------------------
        */

        .info-container {
            width: 100%;

            margin-bottom: 12px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .info-table td {
            padding-top: 3px;
            padding-bottom: 3px;

            font-size: 7.7pt;
            line-height: 1.25;

            vertical-align: top;
        }

        /*
        | Label
        */

        .info-table .col-label {
            width: 105px;

            color: #64748B;
            font-weight: 400;

            white-space: nowrap;
        }

        /*
        | Separator
        */

        .info-table .col-separator {
            width: 12px;

            color: #94A3B8;

            text-align: center;
        }

        /*
        | Value
        */

        .info-table .col-value {
            width: 175px;

            color: #172033;
            font-weight: 600;

            padding-right: 12px;
        }

        /*
        |--------------------------------------------------------------------------
        | ITEMS TABLE
        |--------------------------------------------------------------------------
        */

        .items-table {
            width: 100%;

            border-collapse: collapse;
            border-spacing: 0;

            margin: 0 auto 0 auto;

            table-layout: fixed;
        }

        /*
        | Table Header
        */

        .items-table th {
            background: #071A52;
            color: #ffffff;

            border: 1px solid #071A52;

            padding: 7px 8px;

            font-size: 7.5pt;
            font-weight: 700;

            line-height: 1.2;

            vertical-align: middle;
        }

        /*
        | Table Body
        */

        .items-table td {
            padding: 6px 8px;

            font-size: 7.7pt;

            color: #172033;

            border: 1px solid #CBD5E1;

            line-height: 1.25;

            vertical-align: middle;
        }

        /*
        | Alternating Row
        */

        .items-table tbody tr:nth-child(even) {
            background: #F8FAFC;
        }

        /*
        |--------------------------------------------------------------------------
        | TABLE ALIGNMENT
        |--------------------------------------------------------------------------
        */

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /*
        |--------------------------------------------------------------------------
        | TABLE COLUMN WIDTH
        |--------------------------------------------------------------------------
        */

        .col-no {
            width: 6%;
        }

        .col-description {
            width: 34%;
        }

        .col-volume {
            width: 9%;
        }

        .col-unit {
            width: 11%;
        }

        .col-price {
            width: 20%;
        }

        .col-subtotal {
            width: 20%;
        }

        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        .items-table tfoot td {
            background: #F1F5F9;

            border: 1px solid #CBD5E1;

            padding: 7px 8px;

            font-weight: 700;

            line-height: 1.2;
        }

        .total-label {
            font-size: 8.5pt;

            color: #172033;
        }

        .total-amount {
            font-size: 9pt;

            color: #071A52;

            white-space: nowrap;
        }

        /*
        |--------------------------------------------------------------------------
        | BOTTOM SECTION
        |--------------------------------------------------------------------------
        */

        .bottom-section {
            width: 100%;

            margin-top: 12px;
        }

        /*
        |--------------------------------------------------------------------------
        | KETERANGAN
        |--------------------------------------------------------------------------
        */

        .notes-section {
            margin-bottom: 12px;
        }

        .notes-label {
            font-size: 7.5pt;

            font-weight: 700;

            color: #475569;

            margin-bottom: 3px;
        }

        .notes-value {
            font-size: 7.5pt;

            font-weight: 400;

            color: #334155;

            line-height: 1.3;
        }

        /*
        |--------------------------------------------------------------------------
        | DATE
        |--------------------------------------------------------------------------
        */

        .date-section {
            font-size: 7.7pt;

            color: #334155;

            text-align: right;

            margin-top: 10px;
        }

        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        .doc-footer {
            width: 90%;

            margin: 18px auto 0 auto;

            padding-top: 7px;

            border-top: 1px solid #E2E8F0;

            text-align: center;

            font-size: 7.5pt;

            color: #020f20ff;

            line-height: 1.2;

            font-style:italic;
        }

        /*
        |--------------------------------------------------------------------------
        | PRINT / PDF SAFETY
        |--------------------------------------------------------------------------
        */

        .items-table thead {
            display: table-header-group;
        }

        .items-table tr {
            page-break-inside: avoid;
        }

        .info-container,
        .bottom-section {
            page-break-inside: avoid;
        }

    </style>
</head>

<body>

    <div class="page">

        {{-- ============================================================
             HEADER ORGANISASI
        ============================================================= --}}

        <div class="header">

            @php
                $orgLogo = \App\Models\Setting::get('org_logo');
                $logoBase64 = null;
                if ($orgLogo) {
                    $path = public_path('images/' . $orgLogo);
                    if (file_exists($path)) {
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    }
                }
            @endphp

            @if($logoBase64)
                <img
                    src="{{ $logoBase64 }}"
                    alt="Logo"
                    class="header-logo"
                >
            @endif

            <div class="organization-name">
                {{ \App\Models\Setting::get('org_name', 'UKM-IT CYBER OPEN SOURCE') }}
            </div>

            <div class="organization-address">
                {{ \App\Models\Setting::get('org_address', 'Univeristas Teknologi Akba Makassar') }}
            </div>

        </div>


        {{-- ============================================================
             JUDUL DOKUMEN
        ============================================================= --}}

        <div class="document-title">
            RENCANA ANGGARAN BIAYA
        </div>


        {{-- ============================================================
             CONTENT
        ============================================================= --}}

        <div class="content-wrapper">


            {{-- ========================================================
                 INFORMASI RAB
            ========================================================= --}}

            <div class="info-container">

                <table class="info-table">

                    <tr>

                        {{-- Kiri --}}
                        <td class="col-label">
                            Kode RAB
                        </td>

                        <td class="col-separator">
                            :
                        </td>

                        <td class="col-value">
                            {{ $rab->code }}
                        </td>


                        {{-- Kanan --}}
                        <td class="col-label">
                            Penanggung Jawab
                        </td>

                        <td class="col-separator">
                            :
                        </td>

                        <td class="col-value">
                            {{ $rab->pic_name }}
                        </td>

                    </tr>


                    <tr>

                        {{-- Kiri --}}
                        <td class="col-label">
                            Nama Kegiatan
                        </td>

                        <td class="col-separator">
                            :
                        </td>

                        <td class="col-value">
                            {{ $rab->activity_name }}
                        </td>


                        {{-- Kanan --}}
                        <td class="col-label">
                            Jabatan
                        </td>

                        <td class="col-separator">
                            :
                        </td>

                        <td class="col-value">
                            {{ $rab->pic_position }}
                        </td>

                    </tr>


                    <tr>

                        {{-- Kiri --}}
                        <td class="col-label">
                            Periode
                        </td>

                        <td class="col-separator">
                            :
                        </td>

                        <td class="col-value">
                            {{ $rab->period->name ?? '-' }}
                        </td>


                        {{-- Kanan --}}
                        <td class="col-label">
                            Status
                        </td>

                        <td class="col-separator">
                            :
                        </td>

                        <td class="col-value">
                            {{ strtoupper($rab->status) }}
                        </td>

                    </tr>


                    <tr>

                        {{-- Kiri --}}
                        <td class="col-label">
                            Tanggal
                        </td>

                        <td class="col-separator">
                            :
                        </td>

                        <td class="col-value">
                            {{ $rab->date?->format('d F Y') }}
                        </td>

                        {{-- Kolom kanan dikosongkan --}}
                        <td colspan="3"></td>

                    </tr>

                </table>

            </div>


            {{-- ========================================================
                 TABEL RINCIAN ANGGARAN
            ========================================================= --}}

            <table class="items-table">

                <thead>

                    <tr>

                        <th
                            class="text-center col-no"
                        >
                            No
                        </th>

                        <th
                            class="text-left col-description"
                        >
                            Uraian
                        </th>

                        <th
                            class="text-center col-volume"
                        >
                            Vol.
                        </th>

                        <th
                            class="text-center col-unit"
                        >
                            Satuan
                        </th>

                        <th
                            class="text-right col-price"
                        >
                            Harga Satuan
                        </th>

                        <th
                            class="text-right col-subtotal"
                        >
                            Subtotal
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($rab->items as $i => $item)

                        <tr>

                            <td class="text-center">
                                {{ $i + 1 }}
                            </td>

                            <td class="text-left">
                                {{ $item->description }}
                            </td>

                            <td class="text-center">
                                {{ number_format($item->quantity, 0, ',', '.') }}
                            </td>

                            <td class="text-center">
                                {{ $item->unit }}
                            </td>

                            <td class="text-right">
                                Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                            </td>

                            <td class="text-right">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center"
                            >
                                Tidak ada item.
                            </td>

                        </tr>

                    @endforelse

                </tbody>


                {{-- ====================================================
                     TOTAL
                ===================================================== --}}

                <tfoot>

                    <tr>

                        <td
                            colspan="5"
                            class="text-right total-label"
                        >
                            TOTAL ANGGARAN
                        </td>

                        <td
                            class="text-right total-amount"
                        >
                            Rp {{ number_format($rab->total, 0, ',', '.') }}
                        </td>

                    </tr>

                </tfoot>

            </table>


            {{-- ========================================================
                 KETERANGAN & TANGGAL
            ========================================================= --}}

            <div class="bottom-section">

                @if($rab->description)

                    <div class="notes-section">

                        <div class="notes-label">
                            Keterangan:
                        </div>

                        <div class="notes-value">
                            {{ $rab->description }}
                        </div>

                    </div>

                @endif


                <div class="date-section">

                    Makassar,
                    {{ $rab->date?->format('d F Y') }}

                </div>

            </div>

        </div>


        {{-- ============================================================
             FOOTER
        ============================================================= --}}
        
        <div class="doc-footer">

            Open Your Mind for The Future With Open Source
           

        </div>

    </div>

</body>
</html>