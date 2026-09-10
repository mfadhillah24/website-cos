@extends('layouts.admin')

@section('title', 'Tambah Program Kerja')
@section('page_title', 'Tambah Program Kerja')
@section('breadcrumb', 'Divisi / Program Kerja / Tambah')

@section('content')
<div style="max-width: 680px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Program Kerja Baru</h2>
            <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.programs.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="division_id">Divisi <span style="color:#EF4444;">*</span></label>
                    <select id="division_id" name="division_id" class="form-control {{ $errors->has('division_id') ? 'is-invalid' : '' }}" required>
                        <option value="">-- Pilih Divisi --</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}" {{ old('division_id', request('division_id')) == $division->id ? 'selected' : '' }}>
                                {{ $division->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('division_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="title">Nama Program Kerja <span style="color:#EF4444;">*</span></label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}"
                        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                        placeholder="Contoh: Pelatihan Dasar Jaringan" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                        placeholder="Deskripsikan program kerja ini...">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="target">Target / Output</label>
                    <textarea id="target" name="target" rows="2"
                        class="form-control {{ $errors->has('target') ? 'is-invalid' : '' }}"
                        placeholder="Contoh: 30 peserta, modul pelatihan, sertifikat">{{ old('target') }}</textarea>
                    @error('target')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="status">Status <span style="color:#EF4444;">*</span></label>
                    <select id="status" name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" required>
                        <option value="planning" {{ old('status', 'planning') === 'planning' ? 'selected' : '' }}>Perencanaan</option>
                        <option value="on_progress" {{ old('status') === 'on_progress' ? 'selected' : '' }}>Sedang Berjalan</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan Program</button>
                    <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
