@extends('layouts.admin')

@section('title', 'Pengumuman')
@section('page_title', 'Pengumuman')
@section('breadcrumb', 'Sistem / Pengumuman')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Pengumuman</h2>
        @can('manage_announcements')
        <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Buat Pengumuman
        </a>
        @endcan
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Judul & Isi Singkat</th>
                    <th>Status / Periode</th>
                    <th>Pembuat</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($announcements as $announcement)
                    <tr>
                        <td>
                            <div class="font-semibold">{{ $announcement->title }}</div>
                            <div class="text-xs text-muted">{{ Str::limit($announcement->content, 60) }}</div>
                        </td>
                        <td>
                            <div>
                                @if($announcement->is_active)
                                    <span class="badge badge-green">Aktif</span>
                                @else
                                    <span class="badge badge-gray">Tidak Aktif</span>
                                @endif
                            </div>
                            <div class="text-xs text-muted" style="margin-top:4px;">
                                @if($announcement->starts_at || $announcement->ends_at)
                                    {{ $announcement->starts_at ? $announcement->starts_at->format('d M') : '...' }} - 
                                    {{ $announcement->ends_at ? $announcement->ends_at->format('d M Y') : '...' }}
                                @else
                                    Tanpa batas waktu
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="text-sm">{{ $announcement->creator->name ?? 'Sistem' }}</div>
                            <div class="text-xs text-muted">{{ $announcement->created_at->format('d M Y') }}</div>
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                @can('manage_announcements')
                                <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus pengumuman ini?')">Hapus</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada pengumuman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
