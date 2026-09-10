@extends('layouts.admin')

@section('title', 'Role & Permission')
@section('page_title', 'Role & Permission')
@section('breadcrumb', 'Sistem / Role')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Role</h2>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Role
        </a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Role</th>
                    <th>Jumlah Permission</th>
                    <th>Pengguna</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $i => $role)
                    <tr>
                        <td class="text-muted">{{ $i + 1 }}</td>
                        <td>
                            <span class="font-semibold">{{ $role->name }}</span>
                            @if($role->name === 'Super Admin')
                                <span class="badge badge-blue" style="margin-left:8px;">System</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-gray">{{ $role->permissions->count() }} permission</span>
                        </td>
                        <td class="text-muted text-sm">{{ $role->users_count }} pengguna</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-secondary btn-sm">Edit</a>
                                @if($role->name !== 'Super Admin')
                                    <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus role {{ $role->name }}?')">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px;" class="text-muted">Belum ada role.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
