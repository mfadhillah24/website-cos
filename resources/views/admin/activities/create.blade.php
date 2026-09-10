@extends('layouts.admin')

@section('title', 'Tambah Kegiatan')
@section('page_title', 'Tambah Kegiatan')
@section('breadcrumb', 'Divisi / Kegiatan / Tambah')

@section('content')
<div style="max-width: 800px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Kegiatan Baru</h2>
            <a href="{{ route('admin.activities.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.activities.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label class="form-label" for="division_id">Divisi</label>
                        <select id="division_id" name="division_id" class="form-control {{ $errors->has('division_id') ? 'is-invalid' : '' }}">
                            @if(request()->attributes->get('scoped_division_id') == null)
                                <option value="">-- Lintas Divisi / Umum --</option>
                            @endif
                            @foreach($divisions as $division)
                                <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('division_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="program_id">Program Kerja Terkait (Opsional)</label>
                        <select id="program_id" name="program_id" class="form-control {{ $errors->has('program_id') ? 'is-invalid' : '' }}">
                            <option value="">-- Tidak ada --</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                    {{ $program->title }} ({{ $program->division->name ?? 'Lintas' }})
                                </option>
                            @endforeach
                        </select>
                        @error('program_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="title">Judul Kegiatan <span style="color:#EF4444;">*</span></label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}"
                        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi Singkat</label>
                    <textarea id="description" name="description" rows="2"
                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="content">Konten / Detail Lengkap</label>
                    <textarea id="content" name="content" rows="6"
                        class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}">{{ old('content') }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label class="form-label" for="start_date">Tanggal Mulai</label>
                        <input id="start_date" type="date" name="start_date" value="{{ old('start_date') }}"
                            class="form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }}">
                        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="end_date">Tanggal Selesai (Opsional)</label>
                        <input id="end_date" type="date" name="end_date" value="{{ old('end_date') }}"
                            class="form-control {{ $errors->has('end_date') ? 'is-invalid' : '' }}">
                        @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="location">Tempat / Lokasi</label>
                    <input id="location" type="text" name="location" value="{{ old('location') }}"
                        class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}">
                    @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="thumbnail">Thumbnail (Gambar Utama)</label>
                    <input id="thumbnail" type="file" name="thumbnail" accept="image/*"
                        class="form-control {{ $errors->has('thumbnail') ? 'is-invalid' : '' }}">
                    @error('thumbnail')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="photos">Galeri Foto Tambahan (Bisa pilih lebih dari satu)</label>
                    <input id="photos" type="file" name="photos[]" accept="image/*" multiple
                        class="form-control {{ $errors->has('photos.*') ? 'is-invalid' : '' }}">
                    @error('photos.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="status">Status <span style="color:#EF4444;">*</span></label>
                    <select id="status" name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" required>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Dipublikasi</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan Kegiatan</button>
                    <a href="{{ route('admin.activities.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
