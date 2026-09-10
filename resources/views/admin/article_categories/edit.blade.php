@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page_title', 'Edit Kategori Artikel')
@section('breadcrumb', 'Publikasi / Kategori / Edit')

@section('content')
<div style="max-width: 600px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Edit Kategori</h2>
            <a href="{{ route('admin.article-categories.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.article-categories.update', $articleCategory) }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="name">Nama Kategori <span style="color:#EF4444;">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name', $articleCategory->name) }}"
                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description', $articleCategory->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.article-categories.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
