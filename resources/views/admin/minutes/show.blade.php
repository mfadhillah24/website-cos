@extends('layouts.admin')

@section('title', 'Detail Notulen Rapat')
@section('page_title', 'Detail Notulen Rapat')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <h2 class="card-title">Detail Notulen Rapat</h2>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('admin.minutes.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            <a href="{{ route('admin.minutes.edit', $minute) }}" class="btn btn-secondary btn-sm">Edit</a>
            <a href="{{ route('admin.minutes.pdf', $minute) }}" class="btn btn-primary btn-sm" target="_blank">🖨️ Cetak PDF</a>
        </div>
    </div>
    <div class="card-body">

        @if (session('success'))
            <div style="margin-bottom:16px; padding:12px; border-radius:6px; background:#dcfce7; border:1px solid #86efac; color:#166534;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Info Rapat --}}
        @if ($minute->meeting)
        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:16px; margin-bottom:20px;">
            <p style="font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#64748b; font-weight:600; margin-bottom:10px;">Informasi Rapat</p>
            @php
                $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                $mtg = $minute->meeting;
                $tgl = $mtg->meeting_date;
                $tanggalFmt = $tgl->day . ' ' . $bulan[$tgl->month] . ' ' . $tgl->year;
                $waktuFmt = '';
                if ($mtg->start_time && $mtg->end_time) {
                    $waktuFmt = \Carbon\Carbon::parse($mtg->start_time)->format('H:i')
                              . ' – '
                              . \Carbon\Carbon::parse($mtg->end_time)->format('H:i')
                              . ' WITA';
                } elseif ($mtg->start_time) {
                    $waktuFmt = \Carbon\Carbon::parse($mtg->start_time)->format('H:i') . ' WITA';
                }
            @endphp
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <th style="width:200px; text-align:left; padding:4px 8px; font-weight:500; color:#475569; vertical-align:top;">Topik</th>
                    <td style="padding:4px 8px; color:#1e293b;">{{ $mtg->title }}</td>
                </tr>
                <tr>
                    <th style="text-align:left; padding:4px 8px; font-weight:500; color:#475569;">Tanggal</th>
                    <td style="padding:4px 8px; color:#1e293b;">{{ $tanggalFmt }}</td>
                </tr>
                @if ($waktuFmt)
                <tr>
                    <th style="text-align:left; padding:4px 8px; font-weight:500; color:#475569;">Waktu</th>
                    <td style="padding:4px 8px; color:#1e293b;">{{ $waktuFmt }}</td>
                </tr>
                @endif
                @if ($mtg->location)
                <tr>
                    <th style="text-align:left; padding:4px 8px; font-weight:500; color:#475569;">Lokasi</th>
                    <td style="padding:4px 8px; color:#1e293b;">{{ $mtg->location }}</td>
                </tr>
                @endif
                @if ($mtg->attendance_count !== null)
                <tr>
                    <th style="text-align:left; padding:4px 8px; font-weight:500; color:#475569;">Jumlah Peserta Hadir</th>
                    <td style="padding:4px 8px; color:#1e293b;">{{ $mtg->attendance_count }} orang</td>
                </tr>
                @endif
            </table>
        </div>
        @endif

        {{-- Info Notulen --}}
        <table style="width: 100%;" class="table-wrap">
            <tr>
                <th style="width:200px; padding:10px 8px; vertical-align:top;">Pemimpin</th>
                <td style="padding:10px 8px;">{{ $minute->leader ?: '—' }}</td>
            </tr>
            <tr>
                <th style="padding:10px 8px; vertical-align:top;">Notulis</th>
                <td style="padding:10px 8px;">{{ $minute->notulist ?: '—' }}</td>
            </tr>
            <tr>
                <th style="padding:10px 8px; vertical-align:top;">Agenda Rapat</th>
                <td style="padding:10px 8px; white-space:pre-wrap;">{{ $minute->meeting->agenda ?? '—' }}</td>
            </tr>
            <tr>
                <th style="padding:10px 8px; vertical-align:top;">Hasil Pembahasan</th>
                <td style="padding:10px 8px; white-space:pre-wrap;">{{ $minute->discussion_results }}</td>
            </tr>
            <tr>
                <th style="padding:10px 8px; vertical-align:top;">Keputusan</th>
                <td style="padding:10px 8px; white-space:pre-wrap;">{{ $minute->decisions ?: '—' }}</td>
            </tr>
        </table>

    </div>
</div>
@endsection