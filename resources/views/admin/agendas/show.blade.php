@extends('layouts.admin')

@section('title', 'Detail Agenda Organisasi')
@section('page_title', 'Detail Agenda Organisasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Detail Agenda Organisasi</h2>
    </div>
    <div class="card-body">
        <table style="width: 100%;" class="table-wrap">
            <tr><th style="width:200px;">Judul</th><td>{{ $agenda->title }}</td></tr>
            <tr><th>Tipe</th><td>{{ $agenda->type ?? '-' }}</td></tr>
            <tr>
                <th>Tanggal</th>
                <td>
                    @if($agenda->isMultiDay())
                        {{ $agenda->agenda_date->translatedFormat('d F Y') }}
                        &ndash;
                        {{ $agenda->end_date->translatedFormat('d F Y') }}
                        <span style="margin-left:8px;font-size:12px;color:var(--text-secondary);">
                            ({{ $agenda->agenda_date->diffInDays($agenda->end_date) + 1 }} hari)
                        </span>
                    @else
                        {{ $agenda->agenda_date->translatedFormat('d F Y') }}
                    @endif
                </td>
            </tr>
            @if(!$agenda->isMultiDay())
            <tr>
                <th>Waktu</th>
                <td>
                    @if($agenda->start_time)
                        {{ \Carbon\Carbon::parse($agenda->start_time)->format('H:i') }}
                        @if($agenda->end_time) – {{ \Carbon\Carbon::parse($agenda->end_time)->format('H:i') }} @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endif
            <tr><th>Lokasi</th><td>{{ $agenda->location ?? '-' }}</td></tr>
            <tr><th>PIC</th><td>{{ $agenda->pic ?? '-' }}</td></tr>
            <tr><th>Peserta</th><td>{{ $agenda->participants ?? '-' }}</td></tr>
            <tr><th>Deskripsi</th><td style="white-space:pre-line;">{{ $agenda->description ?? '-' }}</td></tr>
            <tr>
                <th>Status</th>
                <td>
                    @php
                        $colors = ['terjadwal'=>'#2563eb','berlangsung'=>'#d97706','selesai'=>'#16a34a','dibatalkan'=>'#dc2626'];
                        $c = $colors[$agenda->status] ?? '#6b7280';
                    @endphp
                    <span style="display:inline-block;padding:2px 12px;border-radius:20px;font-size:13px;font-weight:500;background:{{ $c }}18;color:{{ $c }};">
                        {{ ucfirst($agenda->status) }}
                    </span>
                </td>
            </tr>
        </table>
        <div style="margin-top:20px;">
            @role('Sekretaris')
            <a href="{{ route('admin.agendas.edit', $agenda) }}" class="btn btn-primary">Edit</a>
            @endrole
            <a href="{{ route('admin.agendas.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection