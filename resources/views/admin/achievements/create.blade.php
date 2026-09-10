@extends('layouts.admin')

@section('title', 'Tambah Pencapaian')
@section('page_title', 'Tambah Pencapaian')
@section('breadcrumb', 'Pencapaian / Tambah')

@section('content')
<div style="max-width: 800px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Tambah Pencapaian Baru</h2>
            <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.achievements.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label class="form-label" for="title">Judul Pencapaian <span class="text-danger">*</span></label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}"
                        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-row mb-3 d-flex gap-3">
                    <div class="form-group flex-fill">
                        <label class="form-label" for="year">Tahun <span class="text-danger">*</span></label>
                        <input id="year" type="number" name="year" value="{{ old('year', date('Y')) }}"
                            class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" required min="2000">
                        @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group flex-fill w-100">
                        <label class="form-label" for="event_name">Nama Event / Kompetisi</label>
                        <input id="event_name" type="text" name="event_name" value="{{ old('event_name') }}"
                            class="form-control {{ $errors->has('event_name') ? 'is-invalid' : '' }}">
                        @error('event_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="4"
                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="photo">Foto (Opsional)</label>
                    <input id="photo" type="file" name="photo" class="form-control {{ $errors->has('photo') ? 'is-invalid' : '' }}" accept="image/*">
                    <small class="text-muted">Maksimal 2MB. Format JPG, JPEG, PNG, WEBP.</small>
                    @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan Pencapaian</button>
                    <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
