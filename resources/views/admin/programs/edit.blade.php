@extends('layouts.admin')

@section('title', 'Edit Program Kerja')
@section('page_title', 'Edit Program Kerja')
@section('breadcrumb', 'Divisi / Program Kerja / Edit')

@section('content')
<div style="max-width: 680px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Edit Program Kerja</h2>
            <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.programs.update', $program) }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="division_id">Divisi <span style="color:#EF4444;">*</span></label>
                    <select id="division_id" name="division_id" class="form-control {{ $errors->has('division_id') ? 'is-invalid' : '' }}" required>
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}" {{ old('division_id', $program->division_id) == $division->id ? 'selected' : '' }}>
                                {{ $division->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('division_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="title">Nama Program Kerja <span style="color:#EF4444;">*</span></label>
                    <input id="title" type="text" name="title" value="{{ old('title', $program->title) }}"
                        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description', $program->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="target">Target / Output</label>
                    <textarea id="target" name="target" rows="2"
                        class="form-control {{ $errors->has('target') ? 'is-invalid' : '' }}">{{ old('target', $program->target) }}</textarea>
                    @error('target')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="status">Status <span style="color:#EF4444;">*</span></label>
                    <select id="status" name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" required>
                        @foreach(['planning' => 'Perencanaan', 'on_progress' => 'Sedang Berjalan', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $label)
                            <option value="{{ $val }}" {{ old('status', $program->status) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
