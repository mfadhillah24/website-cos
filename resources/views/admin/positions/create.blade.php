@extends('layouts.admin')

@section('title', 'Tambah Jabatan')
@section('page_title', 'Tambah Jabatan')
@section('breadcrumb', 'Kepengurusan / Jabatan / Tambah')

@section('content')
<div style="max-width: 680px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Jabatan Baru</h2>
            <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.positions.store') }}">
                @csrf

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="name">Nama Jabatan <span style="color:#EF4444;">*</span></label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            placeholder="Contoh: Ketua" required autocomplete="off">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="slug">Slug <span style="color:#EF4444;">*</span></label>
                        <input id="slug" type="text" name="slug" value="{{ old('slug') }}"
                            class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}"
                            placeholder="Contoh: ketua" required autocomplete="off">
                        <div class="form-text">Huruf kecil, tanpa spasi. Digunakan sebagai identifier unik.</div>
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="order">Urutan Tampil</label>
                    <input id="order" type="number" name="order" value="{{ old('order', 0) }}"
                        class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}"
                        min="0" style="max-width: 140px;">
                    <div class="form-text">Urutan lebih kecil ditampilkan lebih dahulu.</div>
                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                        placeholder="Deskripsi singkat tentang jabatan ini...">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan Jabatan</button>
                    <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
        const nameVal = this.value;
        const slugVal = nameVal.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        document.getElementById('slug').value = slugVal;
    });
</script>
@endpush
@endsection
