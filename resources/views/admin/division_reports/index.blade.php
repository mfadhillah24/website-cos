@extends('layouts.admin')

@section('title', 'Laporan Kegiatan Bidang')
@section('page_title', 'Laporan Kegiatan Bidang')
@section('breadcrumb', 'Laporan Kegiatan')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Laporan Kegiatan</h2>
        @canany(['manage_reports', 'submit_reports'])
        <a href="{{ route('admin.division-reports.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Buat Laporan
        </a>
        @endcanany
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Kegiatan</th>
                    <th>Jenis</th>
                    <th>Tanggal</th>
                    <th>Bidang</th>
                    <th>Dibuat Oleh</th>
                    <th>Status</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                    <tr>
                        <td>
                            <div class="font-semibold">{{ $report->title }}</div>
                            <div class="text-xs text-muted">{{ Str::limit($report->content, 60) }}</div>
                        </td>
                        <td>
                            @php
                                $typeColors = [
                                    'pembelajaran'  => 'badge-blue',
                                    'program_kerja' => 'badge-green',
                                    'rapat'         => 'badge-yellow',
                                    'lainnya'       => 'badge-gray',
                                ];
                            @endphp
                            <span class="badge {{ $typeColors[$report->activity_type] ?? 'badge-gray' }}">
                                {{ $report->activityTypeLabel() }}
                            </span>
                        </td>
                        <td class="text-muted text-sm">
                            {{ $report->activity_date ? $report->activity_date->format('d M Y') : '-' }}
                        </td>
                        <td class="text-sm">{{ $report->division->name }}</td>
                        <td class="text-sm text-muted">{{ $report->author->name }}</td>
                        <td>
                            <span class="badge {{ $report->statusBadge() }}">{{ $report->statusLabel() }}</span>
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.division-reports.show', $report) }}" class="btn btn-secondary btn-sm">Lihat</a>
                                <form action="{{ route('admin.division-reports.destroy', $report) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada laporan kegiatan yang dibuat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
