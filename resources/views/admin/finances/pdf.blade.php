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
    <img src="data:image/png;base64,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" alt="Logo COS">
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
