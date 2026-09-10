@extends('layouts.admin')

@section('title', 'Detail Rapat Organisasi')
@section('page_title', 'Detail Rapat Organisasi')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <h2 class="card-title">Detail Rapat Organisasi</h2>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('admin.meetings.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            <a href="{{ route('admin.meetings.edit', $meeting) }}" class="btn btn-primary btn-sm">Edit</a>
            @if ($meeting->minute)
                <a href="{{ route('admin.minutes.show', $meeting->minute) }}" class="btn btn-secondary btn-sm">Lihat Notulen</a>
            @else
                <a href="{{ route('admin.minutes.create', ['meeting_id' => $meeting->id]) }}" class="btn btn-primary btn-sm">Tambah Notulen</a>
            @endif
        </div>
    </div>
    <div class="card-body">

        @if (session('success'))
            <div style="margin-bottom:16px; padding:12px; border-radius:6px; background:#dcfce7; border:1px solid #86efac; color:#166534;">
                {{ session('success') }}
            </div>
        @endif

        <table style="width: 100%;" class="table-wrap">
            <tr>
                <th style="width:220px; padding:10px 8px; vertical-align:top;">Topik</th>
                <td style="padding:10px 8px;">{{ $meeting->title }}</td>
            </tr>
            <tr>
                <th style="padding:10px 8px; vertical-align:top;">Tanggal</th>
                <td style="padding:10px 8px;">
                    @php
                        $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        $tgl = $meeting->meeting_date;
                        echo $tgl->day . ' ' . $bulan[$tgl->month] . ' ' . $tgl->year;
                    @endphp
                </td>
            </tr>
            <tr>
                <th style="padding:10px 8px; vertical-align:top;">Waktu</th>
                <td style="padding:10px 8px;">
                    @if ($meeting->start_time && $meeting->end_time)
                        {{ \Carbon\Carbon::parse($meeting->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($meeting->end_time)->format('H:i') }} WITA
                    @elseif ($meeting->start_time)
                        {{ \Carbon\Carbon::parse($meeting->start_time)->format('H:i') }} WITA
                    @else
                        <span style="color:#94a3b8;">—</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th style="padding:10px 8px; vertical-align:top;">Lokasi</th>
                <td style="padding:10px 8px;">{{ $meeting->location ?: '—' }}</td>
            </tr>
            <tr>
                <th style="padding:10px 8px; vertical-align:top;">Jumlah Peserta Hadir</th>
                <td style="padding:10px 8px;">
                    @if ($meeting->attendance_count !== null)
                        {{ $meeting->attendance_count }} orang
                    @else
                        <span style="color:#94a3b8;">—</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th style="padding:10px 8px; vertical-align:top;">Agenda Rapat</th>
                <td style="padding:10px 8px; white-space:pre-wrap;">{{ $meeting->agenda ?: '—' }}</td>
            </tr>
        </table>

        @if ($meeting->minute)
            <div style="margin-top:24px; padding:16px; background:#f1f5f9; border-radius:8px; border:1px solid #e2e8f0;">
                <p style="font-weight:600; margin-bottom:4px; color:#334155;">📄 Notulen Tersedia</p>
                <p style="color:#64748b; font-size:13px; margin-bottom:12px;">
                    Pemimpin: {{ $meeting->minute->leader ?? '—' }} &nbsp;|&nbsp;
                    Notulis: {{ $meeting->minute->notulist ?? '—' }}
                </p>
                <div style="display:flex; gap:10px;">
                    <a href="{{ route('admin.minutes.show', $meeting->minute) }}" class="btn btn-secondary btn-sm">Lihat Notulen</a>
                    <a href="{{ route('admin.minutes.pdf', $meeting->minute) }}" class="btn btn-primary btn-sm" target="_blank">🖨️ Cetak PDF Notulen</a>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection