@extends('layouts.admin')

@section('title', 'Tambah Periode')
@section('page_title', 'Tambah Periode')
@section('breadcrumb', 'Kepengurusan / Periode / Tambah')

@section('content')
<div style="max-width: 680px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Periode Baru</h2>
            <a href="{{ route('admin.periods.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.periods.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Nama Periode <span style="color:#EF4444;">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        placeholder="Contoh: 2026/2027" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="start_date">Tanggal Mulai <span style="color:#EF4444;">*</span></label>
                        <input id="start_date" type="date" name="start_date" value="{{ old('start_date') }}"
                            class="form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }}" required>
                        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="end_date">Tanggal Selesai <span style="color:#EF4444;">*</span></label>
                        <input id="end_date" type="date" name="end_date" value="{{ old('end_date') }}"
                            class="form-control {{ $errors->has('end_date') ? 'is-invalid' : '' }}" required>
                        @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                            style="accent-color: var(--blue-600); width:16px; height:16px;">
                        <span class="form-label" style="margin-bottom:0;">Jadikan sebagai Periode Aktif</span>
                    </label>
                    <div class="form-text">Jika diaktifkan, periode lain yang aktif akan secara otomatis dinonaktifkan.</div>
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan Periode</button>
                    <a href="{{ route('admin.periods.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
