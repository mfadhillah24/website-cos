<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan — {{ $periodLabel }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            background: #fff;
        }

        /* ── HEADER ─────────────────────────────── */
        .header {
            padding: 18px 24px 14px;
            text-align: center;
        }
        .header img {
            display: block;
            margin: 0 auto 6px auto;
            height: 50px;
            width: auto;
        }
        .org-name {
            font-size: 18px;
            font-weight: 700;
            color: #0B1728;
            letter-spacing: 0.5px;
        }
        .org-sub {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }
        .report-title {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 8px;
        }
        .report-meta {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }

        /* ── DIVIDER ─────────────────────────────── */
        .divider {
            border: none;
            border-top: 2px solid #0B1728;
            margin: 0;
        }

        /* ── SUMMARY SECTION ─────────────────────── */
        .summary-section {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 24px;
        }
        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
        }
        .summary-cell {
            width: 33.33%;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 14px;
            vertical-align: top;
        }
        .summary-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 5px;
        }
        .summary-value {
            font-size: 15px;
            font-weight: 700;
        }
        .color-income  { color: #065F46; }
        .color-expense { color: #991B1B; }
        .color-balance { color: #1D4ED8; }
        .color-deficit { color: #991B1B; }

        /* ── TABLE ───────────────────────────────── */
        .table-wrapper {
            padding: 0 24px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table thead tr {
            background: #0B1728;
            color: #fff;
        }
        .data-table thead th {
            padding: 9px 12px;
            text-align: left;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .data-table thead th.text-right { text-align: right; }
        .data-table tbody tr.even { background: #f8fafc; }
        .data-table tbody td {
            padding: 9px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            vertical-align: middle;
        }
        .data-table tbody td.text-right { text-align: right; }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
        }
        .badge-income  { background: #D1FAE5; color: #065F46; }
        .badge-expense { background: #FECACA; color: #991B1B; }
        .amount-income  { color: #065F46; font-weight: 700; }
        .amount-expense { color: #991B1B; font-weight: 700; }
        .no-data {
            text-align: center;
            padding: 28px;
            color: #64748b;
        }

        /* ── SIGNATURE ───────────────────────────── */
.signature-section {
    padding: 22px 24px 0;
}

.signature-table {
    width: 100%;
    border-collapse: collapse;
}

.sig-cell {
    width: 50%;
    text-align: center;
    padding: 0 40px;
    vertical-align: bottom;
}

.sig-label {
    font-size: 10px;
    color: #64748b;
    margin-bottom: 42px;
}

.sig-line {
    border-top: 1px solid #334155;
    padding-top: 4px;
    font-size: 11px;
    font-weight: 700;
    color: #0B1728;
    width: 180px;
    margin: 0 auto;
}

.sig-nta {
    font-size: 9px;
    color: #64748b;
    margin-top: 2px;
}

        /* ── FOOTER ──────────────────────────────── */
        .footer {
            padding: 14px 24px;
            border-top: 1px solid #e2e8f0;
            margin-top: 24px;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-left {
            font-size: 9px;
            color: #94a3b8;
            text-align: left;
        }
        .footer-right {
            font-size: 9px;
            color: #94a3b8;
            text-align: right;
        }
    </style>
</head>
<body>

{{-- ── HEADER ──────────────────────────────────── --}}
<div class="header">
    <img src="{{ public_path('images/logo-cos.png') }}" alt="Logo COS">
    <div class="org-name">UKM-IT Cyber Open Source</div>
    <div class="org-sub">Open your Mind for The Future With Open Source</div>
    <div class="report-title">Laporan Keuangan</div>
    <div class="report-title" style="font-size:12px;margin-top:2px;letter-spacing:1px;">
        PERIODE {{ strtoupper($periodLabel) }}
    </div>
    @if($activePeriod)
    <div class="report-meta">Kepengurusan: {{ $activePeriod->name }}</div>
    @endif
    <div class="report-meta">Dicetak: {{ now()->translatedFormat('d F Y') }}</div>
</div>

<hr class="divider">

{{-- ── SUMMARY CARDS ────────────────────────────── --}}
<div class="summary-section">
    <table class="summary-table">
        <tr>
            <td class="summary-cell">
                <div class="summary-label">Total Pemasukan</div>
                <div class="summary-value color-income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            </td>
            <td class="summary-cell">
                <div class="summary-label">Total Pengeluaran</div>
                <div class="summary-value color-expense">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
            </td>
            <td class="summary-cell">
                <div class="summary-label">Saldo Akhir</div>
                <div class="summary-value {{ $balance < 0 ? 'color-deficit' : 'color-balance' }}">
                    Rp {{ number_format(abs($balance), 0, ',', '.') }}
                    @if($balance < 0)<span style="font-size:11px;"> (Defisit)</span>@endif
                </div>
            </td>
        </tr>
    </table>
</div>

{{-- ── TRANSACTION TABLE ────────────────────────── --}}
<div class="table-wrapper">
<table class="data-table">
    <thead>
        <tr>
            <th style="width:28px;">#</th>
            <th>Tanggal</th>
            <th>Deskripsi</th>
            <th>Kategori</th>
            <th>Tipe</th>
            <th class="text-right">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @forelse($finances as $i => $finance)
        <tr class="{{ $i % 2 !== 0 ? 'even' : '' }}">
            <td>{{ $i + 1 }}</td>
            <td>{{ $finance->date->format('d M Y') }}</td>
            <td>{{ $finance->description }}</td>
            <td>{{ $finance->category->name ?? '-' }}</td>
            <td>
                <span class="badge {{ $finance->type === 'income' ? 'badge-income' : 'badge-expense' }}">
                    {{ $finance->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                </span>
            </td>
            <td class="text-right {{ $finance->type === 'income' ? 'amount-income' : 'amount-expense' }}">
                {{ $finance->type === 'income' ? '+' : '-' }} Rp {{ number_format($finance->amount, 0, ',', '.') }}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="no-data">Tidak ada transaksi.</td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>

{{-- ── SIGNATURE ────────────────────────────────── --}}
<div class="signature-section">
    @php
        $bNama = optional(optional($bendaharaUmum)->member)->name;
        $bNta  = optional(optional($bendaharaUmum)->member)->nta;
        $kNama = optional(optional($ketuaUmum)->member)->name;
        $kNta  = optional(optional($ketuaUmum)->member)->nta;
    @endphp
    <table class="signature-table">
        <tr>
            {{-- Kiri: Mengetahui Ketua Umum --}}
            <td class="sig-cell">
                <div class="sig-label">Mengetahui, Ketua Umum</div>
                <div class="sig-line">{{ $kNama ?? '____________________' }}</div>
                <div class="sig-nta">{{ $kNta ? 'NTA: ' . $kNta : '' }}</div>
            </td>
            {{-- Kanan: Bendahara --}}
            <td class="sig-cell">
                <div class="sig-label">Bendahara</div>
                <div class="sig-line">{{ $bNama ?? '____________________' }}</div>
                <div class="sig-nta">{{ $bNta ? 'NTA: ' . $bNta : '' }}</div>
            </td>
        </tr>
    </table>
</div>

{{-- ── FOOTER ───────────────────────────────────── --}}
<div class="footer">
    <table class="footer-table">
        <tr>
            <td class="footer-left">BRAVOCOS</td>
            <td class="footer-right">{{ now()->format('d/m/Y H:i') }}</td>
        </tr>
    </table>
</div>

</body>
</html>
