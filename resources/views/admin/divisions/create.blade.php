@extends('layouts.admin')

@section('title', 'Tambah Divisi')
@section('page_title', 'Tambah Divisi')
@section('breadcrumb', 'Divisi / Tambah')

@section('content')
<div style="max-width: 600px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Tambah Divisi Baru</h2>
            <a href="{{ route('admin.divisions.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.divisions.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Nama Divisi <span style="color:#EF4444;">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        placeholder="Contoh: Networking, Programming, DKV" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                        placeholder="Deskripsikan tujuan dan fokus divisi ini...">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                        Divisi Aktif
                    </label>
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan Divisi</button>
                    <a href="{{ route('admin.divisions.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
