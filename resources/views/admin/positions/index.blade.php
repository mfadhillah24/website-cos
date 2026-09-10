@extends('layouts.admin')

@section('title', 'Jabatan')
@section('page_title', 'Jabatan')
@section('breadcrumb', 'Kepengurusan / Jabatan')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Jabatan</h2>
        @can('manage_positions')
        <a href="{{ route('admin.positions.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Jabatan
        </a>
        @endcan
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Urutan</th>
                    <th>Nama Jabatan</th>
                    <th>Slug</th>
                    <th>Deskripsi</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($positions as $position)
                    <tr>
                        <td class="text-muted text-sm">{{ $position->order }}</td>
                        <td class="font-semibold">{{ $position->name }}</td>
                        <td>
                            <code style="background:var(--gray-100); padding:2px 8px; border-radius:4px; font-size:12px; color:var(--gray-600);">{{ $position->slug }}</code>
                        </td>
                        <td class="text-muted text-sm" style="max-width:240px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $position->description }}">
                            {{ $position->description ?: '—' }}
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.positions.edit', $position) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.positions.destroy', $position) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus jabatan {{ $position->name }}?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada data jabatan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
