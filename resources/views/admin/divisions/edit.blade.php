@extends('layouts.admin')

@section('title', 'Edit Divisi')
@section('page_title', 'Edit Divisi')
@section('breadcrumb', 'Divisi / ' . $division->name . ' / Edit')

@section('content')
<div style="max-width: 600px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Edit Divisi: {{ $division->name }}</h2>
            <a href="{{ route('admin.divisions.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.divisions.update', $division) }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="name">Nama Divisi <span style="color:#EF4444;">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name', $division->name) }}"
                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description', $division->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="focus_areas">Fokus Divisi</label>
                    <input id="focus_areas" type="text" name="focus_areas" 
                           value="{{ old('focus_areas', $division->focus_areas ? implode(', ', $division->focus_areas) : '') }}"
                           class="form-control {{ $errors->has('focus_areas') ? 'is-invalid' : '' }}" 
                           placeholder="Contoh: Networking, Linux, Cyber Security (Pisahkan dengan koma)">
                    <small class="text-muted">Pisahkan setiap fokus dengan tanda koma.</small>
                    @error('focus_areas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="logo">Logo Divisi (Opsional)</label>
                    @if($division->logo)
                        <div class="mb-2">
                            <img src="{{ asset('images/' . $division->logo) }}" alt="Logo" class="img-thumbnail" style="height: 100px;">
                        </div>
                    @endif
                    <input id="logo" type="file" name="logo" class="form-control {{ $errors->has('logo') ? 'is-invalid' : '' }}" accept="image/*">
                    @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="cover_image">Cover Divisi (Opsional)</label>
                    @if($division->cover_image)
                        <div class="mb-2">
                            <img src="{{ asset('images/' . $division->cover_image) }}" alt="Cover" class="img-thumbnail" style="height: 150px; width: 100%; object-fit: cover;">
                        </div>
                    @endif
                    <input id="cover_image" type="file" name="cover_image" class="form-control {{ $errors->has('cover_image') ? 'is-invalid' : '' }}" accept="image/*">
                    @error('cover_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mt-4">
                    <label class="form-label" style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $division->is_active) ? 'checked' : '' }}>
                        Divisi Aktif
                    </label>
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.divisions.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
