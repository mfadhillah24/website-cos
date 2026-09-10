@extends('layouts.admin')

@section('title', 'Upload Foto Galeri')
@section('page_title', 'Upload Foto Galeri')
@section('breadcrumb', 'Galeri / Upload')

@section('content')
<div style="max-width: 600px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Upload Foto Baru</h2>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="photos">Pilih Foto (Bisa lebih dari satu) <span style="color:#EF4444;">*</span></label>
                    <input id="photos" type="file" name="photos[]" accept="image/*" multiple
                        class="form-control {{ $errors->has('photos.*') ? 'is-invalid' : '' }}" required>
                    @error('photos.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="text-xs text-muted" style="margin-top:4px;">Maksimal 3MB per foto.</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="caption">Caption (Opsional)</label>
                    <input id="caption" type="text" name="caption" value="{{ old('caption') }}"
                        class="form-control {{ $errors->has('caption') ? 'is-invalid' : '' }}"
                        placeholder="Deskripsi singkat untuk semua foto yang diupload...">
                    @error('caption')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="division_id">Tag Divisi (Opsional)</label>
                    <select id="division_id" name="division_id" class="form-control {{ $errors->has('division_id') ? 'is-invalid' : '' }}">
                        <option value="">-- Lintas Divisi / Umum --</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                {{ $division->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('division_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="activity_id">Tag Kegiatan Terkait (Opsional)</label>
                    <select id="activity_id" name="activity_id" class="form-control {{ $errors->has('activity_id') ? 'is-invalid' : '' }}">
                        <option value="">-- Tidak ada --</option>
                        @foreach($activities as $activity)
                            <option value="{{ $activity->id }}" {{ old('activity_id') == $activity->id ? 'selected' : '' }}>
                                {{ Str::limit($activity->title, 50) }}
                            </option>
                        @endforeach
                    </select>
                    @error('activity_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Upload ke Galeri</button>
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
