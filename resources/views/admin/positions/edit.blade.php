@extends('layouts.admin')

@section('title', 'Edit Jabatan')
@section('page_title', 'Edit Jabatan')
@section('breadcrumb', 'Kepengurusan / Jabatan / Edit')

@section('content')
<div style="max-width: 680px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Edit: {{ $position->name }}</h2>
            <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.positions.update', $position) }}">
                @csrf @method('PUT')

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="name">Nama Jabatan <span style="color:#EF4444;">*</span></label>
                        <input id="name" type="text" name="name" value="{{ old('name', $position->name) }}"
                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="slug">Slug <span style="color:#EF4444;">*</span></label>
                        <input id="slug" type="text" name="slug" value="{{ old('slug', $position->slug) }}"
                            class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" required>
                        <div class="form-text">Huruf kecil, tanpa spasi. Identifier unik.</div>
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="order">Urutan Tampil</label>
                    <input id="order" type="number" name="order" value="{{ old('order', $position->order) }}"
                        class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}"
                        min="0" style="max-width: 140px;">
                    <div class="form-text">Urutan lebih kecil ditampilkan lebih dahulu.</div>
                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description', $position->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
