@extends('layouts.admin')

@section('title', 'Pengguna')
@section('page_title', 'Manajemen Pengguna')
@section('breadcrumb', 'Sistem / Pengguna')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Pengguna</h2>
        <div class="flex items-center gap-3">
            <form method="GET" class="flex items-center gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama / email..."
                    class="form-control"
                    style="width: 220px;"
                >
                <select name="role" class="form-control" style="width: 140px;">
                    <option value="">Semua Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
                @if(request()->hasAny(['search','role','is_active']))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Reset</a>
                @endif
            </form>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Pengguna
            </a>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $i => $user)
                    <tr>
                        <td class="text-muted">{{ $users->firstItem() + $i }}</td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="user-avatar-sm">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <span class="font-semibold">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                                <span class="badge badge-blue">{{ $role->name }}</span>
                            @endforeach
                            @if ($user->roles->isEmpty())
                                <span class="badge badge-gray">Tanpa Role</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->is_active)
                                <span class="badge badge-green">Aktif</span>
                            @else
                                <span class="badge badge-red">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary btn-sm">Edit</a>

                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-danger' : 'btn-secondary' }}"
                                            onclick="return confirm('{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} pengguna ini?')">
                                            {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus pengguna ini secara permanen?')">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px;" class="text-muted">
                            Tidak ada pengguna ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div class="card-footer">
            <div class="pagination">
                {{ $users->links('pagination::simple-bootstrap-4') }}
            </div>
        </div>
    @endif
</div>
@endsection
