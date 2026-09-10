@extends('layouts.admin')

@section('title', 'Data Anggota')
@section('page_title', 'Data Anggota')
@section('breadcrumb', 'Anggota / Daftar')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Anggota</h2>
        <div class="flex items-center gap-3">
            <form method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..." class="form-control" style="width: 200px;">
                <select name="status" class="form-control" style="width: 160px;">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $st)
                        <option value="{{ $st->id }}" {{ request('status') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                    @endforeach
                </select>
                <select name="division" class="form-control" style="width: 160px;">
                    <option value="">Semua Bidang</option>
                    @foreach ($divisions as $div)
                        <option value="{{ $div->id }}" {{ request('division') == $div->id ? 'selected' : '' }}>{{ $div->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
                @if(request()->hasAny(['search','status','division']))
                    <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Reset</a>
                @endif
            </form>
            <a href="{{ route('admin.members.create') }}" class="btn btn-primary">Tambah Anggota</a>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama & Bidang COS</th>
                    <th>NTA</th>
                    <th>Status</th>
                    <th>Kontak</th>
                    <th>Akun User</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                    <tr>
                        <td>
                            <div class="font-semibold">{{ $member->name }}</div>
                            <div class="text-xs text-muted mt-1">{{ $member->primaryDivision->division->name ?? 'Tanpa Bidang COS' }} • Angkt. {{ $member->angkatan ?? '-' }}</div>
                            @if($member->is_founder)
                                <div class="mt-1"><span class="badge badge-yellow">Pendiri</span></div>
                            @endif
                        </td>
                        <td>
                            @if($member->nta)
                                <span style="font-family: monospace; font-size: 11px; font-weight: 600; color: var(--navy-800); background: var(--gray-50); border: 1px solid var(--gray-200); padding: 3px 7px; border-radius: 6px; display: inline-block;">{{ $member->nta }}</span>
                            @else
                                <span class="text-xs text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-gray">{{ $member->status->name }}</span>
                        </td>
                        <td class="text-xs text-muted">
                            <div>{{ $member->email ?? '-' }}</div>
                            <div class="mt-1">{{ $member->phone ?? '-' }}</div>
                        </td>
                        <td>
                            @if ($member->user)
                                <span class="badge badge-blue">Terkait</span>
                                <div class="text-xs text-muted mt-1">{{ $member->user->email }}</div>
                            @else
                                <span class="text-xs text-muted">Tidak Terkait</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.members.show', $member) }}" class="btn btn-secondary btn-sm">Detail</a>
                                <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.members.destroy', $member) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus anggota {{ $member->name }}?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:40px;" class="text-muted">Belum ada data anggota.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($members->hasPages())
        <div class="card-footer">
            <div class="pagination">{{ $members->links('pagination::simple-bootstrap-4') }}</div>
        </div>
    @endif
</div>
@endsection
