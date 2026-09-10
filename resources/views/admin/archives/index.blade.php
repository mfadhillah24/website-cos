@extends('layouts.admin')

@section('title', 'Manajemen Arsip')
@section('page_title', request()->has('trashed') ? 'Tempat Sampah Arsip' : 'Manajemen Arsip')
@section('breadcrumb')
    Arsip / {{ request()->has('trashed') ? 'Tempat Sampah' : 'Daftar Arsip' }}
@endsection

@section('content')
<div class="mb-6 flex flex-wrap gap-4 justify-between items-center">
    <div class="flex gap-2">
        <a href="{{ route('admin.archives.index') }}" class="btn {{ !request()->has('trashed') ? 'btn-primary' : 'btn-secondary' }}">Arsip Aktif</a>
        @can('manage_archives')
        <a href="{{ route('admin.archives.index', ['trashed' => 1]) }}" class="btn {{ request()->has('trashed') ? 'btn-primary' : 'btn-secondary' }}">Tempat Sampah</a>
        @endcan
    </div>
    @can('create', App\Models\Archive::class)
    <a href="{{ route('admin.archives.create') }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Upload Arsip Baru
    </a>
    @endcan
</div>

<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.archives.index') }}" class="flex flex-wrap gap-4 items-end">
            @if(request()->has('trashed'))
                <input type="hidden" name="trashed" value="1">
            @endif
            
            <div style="flex: 1; min-width: 200px;">
                <label class="form-label">Cari Dokumen</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Judul atau Nomor Dokumen...">
            </div>
            
            <div style="width: 150px;">
                <label class="form-label">Kategori</label>
                <select name="category" class="form-control">
                    <option value="">Semua</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            
            <div style="width: 150px;">
                <label class="form-label">Periode</label>
                <select name="period_id" class="form-control">
                    <option value="">Semua</option>
                    @foreach($periods as $p)
                        <option value="{{ $p->id }}" {{ request('period_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="width: 120px;">
                <label class="form-label">Tahun</label>
                <select name="year" class="form-control">
                    <option value="">Semua</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.archives.index', request()->has('trashed') ? ['trashed'=>1] : []) }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Dokumen</th>
                    <th>Metadata</th>
                    <th>Status / Visibilitas</th>
                    <th>Uploader</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($archives as $archive)
                    <tr>
                        <td>
                            <div class="font-semibold text-primary">{{ $archive->name }}</div>
                            @if($archive->document_number)
                                <div class="text-xs text-muted">{{ $archive->document_number }}</div>
                            @endif
                            <div class="text-xs text-muted mt-1 flex items-center gap-1">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $archive->document_date ? $archive->document_date->format('d M Y') : '-' }}
                            </div>
                        </td>
                        <td>
                            <div><span class="badge badge-gray">{{ $archive->category }}</span></div>
                            <div class="text-xs mt-1">Periode: <strong>{{ $archive->period ? $archive->period->name : '-' }}</strong></div>
                            @if($archive->activity)
                                <div class="text-xs text-blue-600 mt-1 truncate max-w-[200px]" title="{{ $archive->activity->title }}">
                                    Kegiatan: {{ $archive->activity->title }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div>
                                @if($archive->status == 'active')
                                    <span class="badge badge-green">Aktif</span>
                                @else
                                    <span class="badge badge-gray">Diarsipkan</span>
                                @endif
                            </div>
                            <div class="mt-1">
                                @if($archive->visibility == 'public')
                                    <span class="badge badge-blue">Public</span>
                                @elseif($archive->visibility == 'internal')
                                    <span class="badge badge-yellow">Internal</span>
                                @else
                                    <span class="badge badge-red">Restricted</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="text-sm">{{ $archive->uploader ? $archive->uploader->name : 'Sistem' }}</div>
                            <div class="text-xs text-muted">{{ $archive->created_at->format('d M Y, H:i') }}</div>
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                @if(request()->has('trashed'))
                                    @can('restore', $archive)
                                    <form action="{{ route('admin.archives.restore', $archive->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-green" onclick="return confirm('Pulihkan arsip ini?')">Restore</button>
                                    </form>
                                    @endcan
                                    @can('forceDelete', $archive)
                                    <form action="{{ route('admin.archives.forceDelete', $archive->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus PERMANEN arsip ini beserta filenya? Tindakan ini tidak dapat dibatalkan.')">Delete</button>
                                    </form>
                                    @endcan
                                @else
                                    @can('view', $archive)
                                    <a href="{{ route('admin.archives.show', $archive->id) }}" class="btn btn-sm btn-secondary">Detail</a>
                                    <a href="{{ route('admin.archives.download', $archive->id) }}" class="btn btn-sm btn-primary">Unduh</a>
                                    @endcan
                                    
                                    @can('update', $archive)
                                    <a href="{{ route('admin.archives.edit', $archive->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                                    @endcan

                                    @can('delete', $archive)
                                    <form action="{{ route('admin.archives.destroy', $archive->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Pindahkan arsip ini ke tempat sampah?')">Hapus</button>
                                    </form>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-muted">
                            @if(request()->has('trashed'))
                                Tempat sampah kosong.
                            @else
                                Tidak ada arsip yang ditemukan.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($archives->hasPages())
        <div class="card-footer">
            {{ $archives->links() }}
        </div>
    @endif
</div>
@endsection