@extends('layouts.admin')

@section('title', 'Review Laporan')
@section('page_title', 'Review Laporan Divisi')
@section('breadcrumb', 'Laporan Organisasi / Review Laporan')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Laporan Masuk untuk Review</h2>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Judul Laporan</th>
                    <th>Divisi</th>
                    <th>Pembuat</th>
                    <th>Status</th>
                    <th>Diajukan Pada</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                    <tr>
                        <td class="font-semibold">{{ Str::limit($report->title, 50) }}</td>
                        <td>{{ $report->division->name }}</td>
                        <td class="text-sm">{{ $report->author->name }}</td>
                        <td><span class="badge {{ $report->statusBadge() }}">{{ $report->statusLabel() }}</span></td>
                        <td class="text-sm text-muted">{{ $report->submitted_at ? $report->submitted_at->format('d M Y') : '-' }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.report-reviews.show', $report) }}" class="btn btn-primary btn-sm">
                                    {{ in_array($report->status, ['submitted', 'reviewing']) ? 'Review' : 'Lihat' }}
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada laporan yang diajukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
