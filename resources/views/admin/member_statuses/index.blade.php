@extends('layouts.admin')

@section('title', 'Histori Status Keanggotaan')
@section('page_title', 'Histori Status Keanggotaan')
@section('breadcrumb', 'Anggota / Histori Status')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Log Perubahan Status Anggota</h2>
        <div class="flex gap-3">
            <form method="GET" class="flex items-center gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama anggota..."
                    class="form-control"
                    style="width: 220px;"
                >
                <select name="status" class="form-control" style="width: 180px;">
                    <option value="">Semua Status Tujuan</option>
                    @foreach ($statuses as $st)
                        <option value="{{ $st->id }}" {{ request('status') == $st->id ? 'selected' : '' }}>
                            {{ $st->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
                @if(request()->hasAny(['search','status']))
                    <a href="{{ route('admin.member-statuses.index') }}" class="btn btn-secondary">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Anggota</th>
                    <th>Status Sebelumnya</th>
                    <th>Status Baru</th>
                    <th>Diubah Oleh</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($histories as $history)
                    <tr>
                        <td class="text-muted text-sm" style="white-space:nowrap;">
                            {{ $history->created_at->format('d M Y H:i') }}
                        </td>
                        <td>
                            <div class="font-semibold">{{ $history->member->name ?? 'Anggota Tidak Ditemukan' }}</div>
                            <div class="text-muted text-xs mt-1">Angkatan {{ $history->member->angkatan ?? '-' }}</div>
                        </td>
                        <td>
                            @if ($history->fromStatus)
                                <span class="badge badge-gray">{{ $history->fromStatus->name }}</span>
                            @else
                                <span class="text-muted text-xs">— (Status Awal)</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-blue">{{ $history->toStatus->name }}</span>
                        </td>
                        <td class="text-muted text-sm">
                            {{ $history->changer->name ?? 'Sistem' }}
                        </td>
                        <td class="text-muted text-sm" style="max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="{{ $history->notes }}">
                            {{ $history->notes ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada riwayat perubahan status.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($histories->hasPages())
        <div class="card-footer">
            <div class="pagination">
                {{ $histories->links('pagination::simple-bootstrap-4') }}
            </div>
        </div>
    @endif
</div>
@endsection
