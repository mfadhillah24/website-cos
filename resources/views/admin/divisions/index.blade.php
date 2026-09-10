@extends('layouts.admin')

@section('title', 'Manajemen Divisi')
@section('page_title', 'Manajemen Divisi')
@section('breadcrumb', 'Divisi / Daftar Divisi')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Divisi</h2>
        @can('manage_division')
        <a href="{{ route('admin.divisions.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Divisi
        </a>
        @endcan
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama Divisi</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Anggota</th>
                    <th>Status</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($divisions as $division)
                    <tr>
                        <td>
                            <div class="font-semibold">{{ $division->name }}</div>
                            <div class="text-xs text-muted">{{ $division->slug }}</div>
                        </td>
                        <td class="text-sm text-muted">{{ Str::limit($division->description, 60, '...') ?? '-' }}</td>
                        <td>
                            <span class="badge badge-blue">{{ $division->division_members_count }} anggota</span>
                        </td>
                        <td>
                            @if($division->is_active)
                                <span class="badge badge-green">Aktif</span>
                            @else
                                <span class="badge badge-gray">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.divisions.show', $division) }}" class="btn btn-secondary btn-sm">Detail</a>
                                @can('manage_division')
                                <a href="{{ route('admin.divisions.edit', $division) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.divisions.destroy', $division) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus divisi ini? Pastikan tidak ada data terkait.')">Hapus</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada divisi. Silakan tambahkan dari tombol di atas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
