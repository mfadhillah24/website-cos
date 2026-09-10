@extends('layouts.admin')

@section('title', 'Edit Pengumuman')
@section('page_title', 'Edit Pengumuman')
@section('breadcrumb', 'Sistem / Pengumuman / Edit')

@section('content')
<div style="max-width: 600px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Edit Pengumuman</h2>
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="title">Judul Pengumuman <span style="color:#EF4444;">*</span></label>
                    <input id="title" type="text" name="title" value="{{ old('title', $announcement->title) }}"
                        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="content">Isi Pengumuman <span style="color:#EF4444;">*</span></label>
                    <textarea id="content" name="content" rows="4"
                        class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" required>{{ old('content', $announcement->content) }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label class="form-label" for="starts_at">Mulai Tayang (Opsional)</label>
                        <input id="starts_at" type="datetime-local" name="starts_at" value="{{ old('starts_at', $announcement->starts_at ? $announcement->starts_at->format('Y-m-d\TH:i') : '') }}"
                            class="form-control {{ $errors->has('starts_at') ? 'is-invalid' : '' }}">
                        @error('starts_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="ends_at">Selesai Tayang (Opsional)</label>
                        <input id="ends_at" type="datetime-local" name="ends_at" value="{{ old('ends_at', $announcement->ends_at ? $announcement->ends_at->format('Y-m-d\TH:i') : '') }}"
                            class="form-control {{ $errors->has('ends_at') ? 'is-invalid' : '' }}">
                        @error('ends_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group" style="display:flex; align-items:center; gap:8px;">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $announcement->is_active) ? 'checked' : '' }} style="width:16px; height:16px;">
                    <label for="is_active" style="margin:0; cursor:pointer;">Status Aktif (Tampilkan)</label>
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
