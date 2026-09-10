@extends('layouts.admin')

@section('title', 'Rekap Laporan Organisasi')
@section('page_title', 'Rekap Laporan Organisasi')
@section('breadcrumb', 'Laporan Organisasi / Rekap Laporan')

@section('content')
<div class="card" style="margin-bottom: 24px;">
    <div class="card-header">
        <h2 class="card-title">Ringkasan Laporan per Divisi</h2>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; padding: 24px;">
        @foreach($divisions as $div)
            <div style="padding: 16px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--card-bg);">
                <div class="font-semibold" style="margin-bottom: 8px;">{{ $div->name }}</div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 24px; font-weight: 700; color: var(--primary-color);">{{ $div->approved_reports_count }}</span>
                    <span class="text-xs text-muted">laporan disetujui</span>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Laporan Disetujui</h2>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Judul Laporan</th>
                    <th>Divisi</th>
                    <th>Periode</th>
                    <th>Pembuat</th>
                    <th>Disetujui Pada</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                    <tr>
                        <td class="font-semibold">{{ Str::limit($report->title, 50) }}</td>
                        <td>{{ $report->division->name }}</td>
                        <td class="text-sm text-muted">{{ $report->period->name ?? '-' }}</td>
                        <td class="text-sm">{{ $report->author->name }}</td>
                        <td class="text-sm text-muted">{{ $report->approved_at ? $report->approved_at->format('d M Y') : '-' }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.organization-reports.show', $report) }}" class="btn btn-secondary btn-sm">Lihat</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada laporan yang disetujui.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
