@extends('layouts.admin')

@section('title', 'Buat Laporan Kegiatan')
@section('page_title', 'Buat Laporan Kegiatan')
@section('breadcrumb', 'Laporan Kegiatan / Buat')

@section('content')
<div style="max-width: 800px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Laporan Kegiatan Bidang Baru</h2>
            <a href="{{ route('admin.division-reports.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.division-reports.store') }}">
                @csrf

                {{-- Row 1: Divisi & Periode --}}
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="division_id">Bidang / Divisi <span style="color:#EF4444;">*</span></label>
                        <select id="division_id" name="division_id" class="form-control {{ $errors->has('division_id') ? 'is-invalid' : '' }}" required>
                            <option value="">-- Pilih Divisi --</option>
                            @foreach($divisions as $div)
                                <option value="{{ $div->id }}" {{ old('division_id') == $div->id ? 'selected' : '' }}>{{ $div->name }}</option>
                            @endforeach
                        </select>
                        @error('division_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="period_id">Periode <span style="color:#EF4444;">*</span></label>
                        <select id="period_id" name="period_id" class="form-control {{ $errors->has('period_id') ? 'is-invalid' : '' }}" required>
                            <option value="">-- Pilih Periode --</option>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}" {{ old('period_id') == $period->id ? 'selected' : '' }}>
                                    {{ $period->name }} {{ $period->is_active ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('period_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Row 2: Tanggal & Jenis Kegiatan --}}
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="activity_date">Tanggal Kegiatan <span style="color:#EF4444;">*</span></label>
                        <input id="activity_date" type="date" name="activity_date" value="{{ old('activity_date', now()->format('Y-m-d')) }}"
                            class="form-control {{ $errors->has('activity_date') ? 'is-invalid' : '' }}" required>
                        @error('activity_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="activity_type">Jenis Kegiatan <span style="color:#EF4444;">*</span></label>
                        <select id="activity_type" name="activity_type" class="form-control {{ $errors->has('activity_type') ? 'is-invalid' : '' }}" required>
                            <option value="pembelajaran"  {{ old('activity_type') == 'pembelajaran'  ? 'selected' : '' }}>📚 Kegiatan Pembelajaran</option>
                            <option value="program_kerja" {{ old('activity_type') == 'program_kerja' ? 'selected' : '' }}>⚙️ Program Kerja</option>
                            <option value="rapat"         {{ old('activity_type') == 'rapat'         ? 'selected' : '' }}>🗣️ Rapat</option>
                            <option value="lainnya"       {{ old('activity_type') == 'lainnya'       ? 'selected' : '' }}>📝 Lainnya</option>
                        </select>
                        @error('activity_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Judul --}}
                <div class="form-group">
                    <label class="form-label" for="title">Judul Laporan <span style="color:#EF4444;">*</span></label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}"
                        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                        placeholder="Contoh: Pelatihan Git & GitHub – Sesi 1" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Deskripsi --}}
                <div class="form-group">
                    <label class="form-label" for="content">Deskripsi Kegiatan <span style="color:#EF4444;">*</span></label>
                    <textarea id="content" name="content" rows="10"
                        class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}"
                        placeholder="Tuliskan ringkasan kegiatan, materi yang disampaikan, peserta yang hadir, dan catatan penting lainnya..." required>{{ old('content') }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan sebagai Draft</button>
                    <a href="{{ route('admin.division-reports.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Info step --}}
    <div class="card" style="background: var(--gray-50); border: 1px dashed var(--gray-300);">
        <div class="card-body" style="padding: 20px;">
            <div class="font-semibold text-sm" style="margin-bottom: 8px;">💡 Cara Mengajukan Laporan</div>
            <ol style="font-size: 13px; color: var(--gray-600); padding-left: 20px; line-height: 2;">
                <li>Simpan laporan ini sebagai <strong>Draft</strong>.</li>
                <li>Di halaman berikutnya, <strong>unggah foto dokumentasi</strong> kegiatan.</li>
                <li>Setelah foto lengkap, klik tombol <strong>"Ajukan ke Ketua"</strong> — laporan Anda akan langsung masuk ke Ketua Umum untuk direview.</li>
            </ol>
        </div>
    </div>
</div>
@endsection
