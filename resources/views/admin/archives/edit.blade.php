@extends('layouts.admin')

@section('title', 'Edit Arsip')
@section('page_title', 'Edit Arsip')
@section('breadcrumb', 'Arsip / Edit')

@section('content')
<div class="card max-w-3xl">
    <div class="card-body">
        <form action="{{ route('admin.archives.update', $archive->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="form-label required">Nama Dokumen</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $archive->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label required">Kategori Dokumen</label>
                    <select name="category" class="form-control @error('category') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(['Surat Masuk', 'Surat Keluar', 'Surat Keputusan', 'Surat Tugas', 'Surat Undangan', 'Proposal', 'LPJ', 'RAB', 'TOR', 'Dokumen Kegiatan', 'Dokumen Kepengurusan', 'Lainnya'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $archive->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="form-label">Nomor Dokumen / Surat</label>
                    <input type="text" name="document_number" class="form-control @error('document_number') is-invalid @enderror" value="{{ old('document_number', $archive->document_number) }}" placeholder="Opsional">
                    @error('document_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label">Tanggal Dokumen</label>
                    <input type="date" name="document_date" class="form-control @error('document_date') is-invalid @enderror" value="{{ old('document_date', $archive->document_date ? $archive->document_date->format('Y-m-d') : '') }}">
                    @error('document_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 p-4 bg-gray-50 rounded-lg border border-gray-100">
                <div>
                    <label class="form-label">Periode</label>
                    <select name="period_id" class="form-control @error('period_id') is-invalid @enderror">
                        <option value="">-- Tanpa Periode --</option>
                        @foreach($periods as $p)
                            <option value="{{ $p->id }}" {{ old('period_id', $archive->period_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}{{ $p->is_active ? ' (Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('period_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label">Kegiatan Terkait</label>
                    <select name="activity_id" class="form-control @error('activity_id') is-invalid @enderror">
                        <option value="">-- Tidak Terkait Kegiatan --</option>
                        @foreach($activities as $act)
                            <option value="{{ $act->id }}" {{ old('activity_id', $archive->activity_id) == $act->id ? 'selected' : '' }}>{{ $act->title }}</option>
                        @endforeach
                    </select>
                    @error('activity_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label required">Visibilitas / Hak Akses</label>
                    <select name="visibility" class="form-control @error('visibility') is-invalid @enderror" required>
                        <option value="internal" {{ old('visibility', $archive->visibility) == 'internal' ? 'selected' : '' }}>Internal (Semua Pengurus)</option>
                        <option value="restricted" {{ old('visibility', $archive->visibility) == 'restricted' ? 'selected' : '' }}>Restricted (Hanya Inti & Admin)</option>
                        <option value="public" {{ old('visibility', $archive->visibility) == 'public' ? 'selected' : '' }}>Public (Terbuka)</option>
                    </select>
                    @error('visibility')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="md:col-span-2">
                    <label class="form-label">Deskripsi / Keterangan Singkat</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $archive->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label required">Status Arsip</label>
                <select name="status" class="form-control w-1/3 @error('status') is-invalid @enderror" required>
                    <option value="active" {{ old('status', $archive->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="archived" {{ old('status', $archive->status) == 'archived' ? 'selected' : '' }}>Diarsipkan (Read-Only)</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-6 p-4 border border-dashed border-gray-300 rounded-lg">
                <label class="form-label">Ganti File Dokumen (Opsional)</label>
                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png">
                <div class="form-text mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah file. Format didukung: PDF, DOC/X, XLS/X, PPT/X, JPG, PNG. Maksimal 10MB.</div>
                @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                
                <div class="mt-3 text-sm text-gray-600">
                    File saat ini: <a href="{{ route('admin.archives.download', $archive->id) }}" class="text-blue-600 hover:underline">Unduh File</a>
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.archives.show', $archive->id) }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update Arsip</button>
            </div>
        </form>
    </div>
</div>
@endsection