@extends('layouts.admin')

@section('title', 'Periode Kepengurusan')
@section('page_title', 'Periode Kepengurusan')
@section('breadcrumb', 'Kepengurusan / Periode')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Periode</h2>
        @can('manage_periods')
        <a href="{{ route('admin.periods.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Periode
        </a>
        @endcan
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Periode</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Status</th>
                    <th>Ditutup Oleh</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($periods as $i => $period)
                    <tr>
                        <td class="text-muted">{{ ($periods->currentPage() - 1) * $periods->perPage() + $i + 1 }}</td>
                        <td class="font-semibold">{{ $period->name }}</td>
                        <td class="text-muted text-sm">{{ $period->start_date->format('d M Y') }}</td>
                        <td class="text-muted text-sm">{{ $period->end_date->format('d M Y') }}</td>
                        <td>
                            @if($period->is_active)
                                <span class="badge badge-blue">Aktif</span>
                            @else
                                <span class="badge badge-gray">Demisioner</span>
                            @endif
                        </td>
                        <td class="text-muted text-sm">
                            @if($period->closed_at)
                                <div>{{ $period->closedBy->name ?? '—' }}</div>
                                <div class="text-xs">{{ $period->closed_at->format('d M Y') }}</div>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.periods.edit', $period) }}" class="btn btn-secondary btn-sm">Edit</a>
                                @if($period->is_active)
                                    <form method="POST" action="{{ route('admin.periods.close', $period) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-warning btn-sm"
                                            onclick="return confirm('Tutup periode {{ $period->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                            Tutup
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.periods.destroy', $period) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus periode {{ $period->name }}?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada data periode kepengurusan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($periods->hasPages())
        <div class="card-footer">
            <div class="pagination">
                {{ $periods->links('pagination::simple-bootstrap-4') }}
            </div>
        </div>
    @endif
</div>
@endsection
