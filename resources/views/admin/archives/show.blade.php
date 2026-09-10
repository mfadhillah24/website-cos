@extends('layouts.admin')

@section('title', 'Detail Arsip')
@section('page_title', 'Detail Arsip')
@section('breadcrumb', 'Arsip / Detail')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.archives.index', $archive->trashed() ? ['trashed'=>1] : []) }}" class="btn btn-secondary">
        &larr; Kembali ke Daftar
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2">
        <div class="card mb-6">
            <div class="card-header flex justify-between items-center">
                <h3 class="font-bold text-lg">Informasi Dokumen</h3>
                <div>
                    @if($archive->status == 'active')
                        <span class="badge badge-green">Aktif</span>
                    @else
                        <span class="badge badge-gray">Diarsipkan</span>
                    @endif
                    @if($archive->trashed())
                        <span class="badge badge-red ml-2">Di Tempat Sampah</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <table class="table-auto w-full text-left border-collapse">
                    <tbody>
                        <tr class="border-b border-gray-100">
                            <th class="py-3 text-muted w-1/3">Nama Dokumen</th>
                            <td class="py-3 font-semibold text-lg">{{ $archive->name }}</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <th class="py-3 text-muted">Nomor Dokumen</th>
                            <td class="py-3">{{ $archive->document_number ?: '-' }}</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <th class="py-3 text-muted">Tanggal Dokumen</th>
                            <td class="py-3">{{ $archive->document_date ? $archive->document_date->format('d F Y') : '-' }}</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <th class="py-3 text-muted">Kategori</th>
                            <td class="py-3"><span class="badge badge-gray">{{ $archive->category }}</span></td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <th class="py-3 text-muted">Visibilitas</th>
                            <td class="py-3">
                                @if($archive->visibility == 'public')
                                    <span class="badge badge-blue">Public (Terbuka)</span>
                                @elseif($archive->visibility == 'internal')
                                    <span class="badge badge-yellow">Internal (Semua Pengurus)</span>
                                @else
                                    <span class="badge badge-red">Restricted (Hanya Admin & Inti)</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="py-3 text-muted align-top">Deskripsi</th>
                            <td class="py-3 whitespace-pre-wrap">{{ $archive->description ?: '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="font-bold text-lg">Relasi Sistem</h3>
            </div>
            <div class="card-body">
                <table class="table-auto w-full text-left border-collapse">
                    <tbody>
                        <tr class="border-b border-gray-100">
                            <th class="py-3 text-muted w-1/3">Periode Kepengurusan</th>
                            <td class="py-3">
                                @if($archive->period)
                                    <span class="font-medium">{{ $archive->period->name }}</span>
                                    @if($archive->period->is_active)
                                        <span class="badge badge-green ml-2">Aktif</span>
                                    @else
                                        <span class="badge badge-gray ml-2">Ditutup</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="py-3 text-muted">Kegiatan Terkait</th>
                            <td class="py-3">
                                @if($archive->activity)
                                    <a href="#" class="text-blue-600 hover:underline font-medium">{{ $archive->activity->title }}</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <div class="card mb-6">
            <div class="card-header">
                <h3 class="font-bold text-lg">File Dokumen</h3>
            </div>
            <div class="card-body text-center p-6">
                @php
                    $ext = pathinfo($archive->file_path, PATHINFO_EXTENSION);
                    $icon = '📄';
                    if(in_array(strtolower($ext), ['pdf'])) $icon = '📕';
                    elseif(in_array(strtolower($ext), ['doc','docx'])) $icon = '📘';
                    elseif(in_array(strtolower($ext), ['xls','xlsx'])) $icon = '📗';
                    elseif(in_array(strtolower($ext), ['jpg','jpeg','png'])) $icon = '🖼️';
                @endphp
                <div class="text-6xl mb-4">{{ $icon }}</div>
                <div class="text-sm text-muted mb-6 uppercase tracking-wider font-bold">{{ $ext }} File</div>
                
                <a href="{{ route('admin.archives.download', $archive->id) }}" class="btn btn-primary w-full justify-center mb-2">
                    Unduh File
                </a>
            </div>
        </div>

        <div class="card mb-6">
            <div class="card-header">
                <h3 class="font-bold text-lg">Riwayat</h3>
            </div>
            <div class="card-body text-sm">
                <div class="mb-4">
                    <div class="text-muted mb-1">Diunggah Oleh</div>
                    <div class="font-medium flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                            {{ substr($archive->uploader ? $archive->uploader->name : 'S', 0, 1) }}
                        </div>
                        {{ $archive->uploader ? $archive->uploader->name : 'Sistem' }}
                    </div>
                </div>
                <div class="mb-4">
                    <div class="text-muted mb-1">Waktu Upload</div>
                    <div class="font-medium">{{ $archive->created_at->format('d M Y, H:i:s') }}</div>
                </div>
                <div>
                    <div class="text-muted mb-1">Terakhir Diubah</div>
                    <div class="font-medium">{{ $archive->updated_at->format('d M Y, H:i:s') }}</div>
                </div>
            </div>
        </div>

        @if(!$archive->trashed())
            <div class="card border-red-200">
                <div class="card-header bg-red-50 text-red-700 border-b border-red-100">
                    <h3 class="font-bold text-lg">Aksi</h3>
                </div>
                <div class="card-body">
                    @can('update', $archive)
                    <a href="{{ route('admin.archives.edit', $archive->id) }}" class="btn btn-secondary w-full justify-center mb-3">
                        Edit Metadata
                    </a>
                    @endcan

                    @can('delete', $archive)
                    <form action="{{ route('admin.archives.destroy', $archive->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger w-full justify-center" onclick="return confirm('Pindahkan arsip ini ke tempat sampah?')">
                            Hapus Arsip
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        @else
            <div class="card border-orange-200">
                <div class="card-header bg-orange-50 text-orange-700 border-b border-orange-100">
                    <h3 class="font-bold text-lg">Aksi Tempat Sampah</h3>
                </div>
                <div class="card-body">
                    @can('restore', $archive)
                    <form action="{{ route('admin.archives.restore', $archive->id) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-green w-full justify-center" onclick="return confirm('Pulihkan arsip ini?')">
                            Pulihkan (Restore)
                        </button>
                    </form>
                    @endcan

                    @can('forceDelete', $archive)
                    <form action="{{ route('admin.archives.forceDelete', $archive->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger w-full justify-center" onclick="return confirm('Hapus PERMANEN arsip ini beserta filenya? Tindakan ini tidak dapat dibatalkan.')">
                            Hapus Permanen
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        @endif
    </div>
</div>
@endsection