@extends('layouts.admin')

@section('title', 'Edit Laporan Kegiatan')
@section('page_title', 'Edit Laporan Kegiatan')
@section('breadcrumb', 'Laporan Kegiatan / Edit')

@section('content')
<div style="max-width: 800px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Edit Laporan Kegiatan</h2>
            <a href="{{ route('admin.division-reports.show', $divisionReport) }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.division-reports.update', $divisionReport) }}">
                @csrf @method('PUT')

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="division_id">Bidang / Divisi <span style="color:#EF4444;">*</span></label>
                        <select id="division_id" name="division_id" class="form-control" required>
                            @foreach($divisions as $div)
                                <option value="{{ $div->id }}" {{ old('division_id', $divisionReport->division_id) == $div->id ? 'selected' : '' }}>{{ $div->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="period_id">Periode <span style="color:#EF4444;">*</span></label>
                        <select id="period_id" name="period_id" class="form-control" required>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}" {{ old('period_id', $divisionReport->period_id) == $period->id ? 'selected' : '' }}>
                                    {{ $period->name }} {{ $period->is_active ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="activity_date">Tanggal Kegiatan <span style="color:#EF4444;">*</span></label>
                        <input id="activity_date" type="date" name="activity_date"
                            value="{{ old('activity_date', $divisionReport->activity_date?->format('Y-m-d')) }}"
                            class="form-control {{ $errors->has('activity_date') ? 'is-invalid' : '' }}" required>
                        @error('activity_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="activity_type">Jenis Kegiatan <span style="color:#EF4444;">*</span></label>
                        <select id="activity_type" name="activity_type" class="form-control" required>
                            <option value="pembelajaran"  {{ old('activity_type', $divisionReport->activity_type) == 'pembelajaran'  ? 'selected' : '' }}>📚 Kegiatan Pembelajaran</option>
                            <option value="program_kerja" {{ old('activity_type', $divisionReport->activity_type) == 'program_kerja' ? 'selected' : '' }}>⚙️ Program Kerja</option>
                            <option value="rapat"         {{ old('activity_type', $divisionReport->activity_type) == 'rapat'         ? 'selected' : '' }}>🗣️ Rapat</option>
                            <option value="lainnya"       {{ old('activity_type', $divisionReport->activity_type) == 'lainnya'       ? 'selected' : '' }}>📝 Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="title">Judul Laporan <span style="color:#EF4444;">*</span></label>
                    <input id="title" type="text" name="title" value="{{ old('title', $divisionReport->title) }}"
                        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="content">Deskripsi Kegiatan <span style="color:#EF4444;">*</span></label>
                    <textarea id="content" name="content" rows="12" class="form-control" required>{{ old('content', $divisionReport->content) }}</textarea>
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.division-reports.show', $divisionReport) }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
