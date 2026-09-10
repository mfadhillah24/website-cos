@extends('layouts.admin')

@section('title', 'Edit Agenda Organisasi')
@section('page_title', 'Edit Agenda Organisasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Edit Agenda Organisasi</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.agendas.update', $agenda) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Judul <span style="color:red">*</span></label>
                <input type="text" name="title" value="{{ old('title', $agenda->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Tipe</label>
                <input type="text" name="type" value="{{ old('type', $agenda->type) }}" class="form-control" placeholder="Contoh: Rapat, Kegiatan, Pelatihan">
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label class="form-label">Tanggal Mulai <span style="color:red">*</span></label>
                    <input type="date" name="agenda_date" id="agenda_date" value="{{ old('agenda_date', $agenda->agenda_date->format('Y-m-d')) }}" class="form-control @error('agenda_date') is-invalid @enderror" required>
                    @error('agenda_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Selesai <small style="color:var(--text-secondary)">(isi jika lebih dari 1 hari)</small></label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $agenda->end_date?->format('Y-m-d')) }}" class="form-control @error('end_date') is-invalid @enderror">
                    @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Jam hanya tampil jika 1 hari --}}
            <div id="time-fields" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label class="form-label">Waktu Mulai</label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $agenda->start_time) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Waktu Selesai</label>
                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $agenda->end_time) }}" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Lokasi</label>
                <input type="text" name="location" value="{{ old('location', $agenda->location) }}" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">Penanggung Jawab (PIC)</label>
                <input type="text" name="pic" value="{{ old('pic', $agenda->pic) }}" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">Peserta</label>
                <input type="text" name="participants" value="{{ old('participants', $agenda->participants) }}" class="form-control" placeholder="Contoh: Semua Pengurus">
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $agenda->description) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    @foreach(['terjadwal','berlangsung','selesai','dibatalkan'] as $s)
                    <option value="{{ $s }}" {{ old('status', $agenda->status) == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.agendas.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    const startDate = document.getElementById('agenda_date');
    const endDate   = document.getElementById('end_date');
    const timeBox   = document.getElementById('time-fields');

    function toggle() {
        const s = startDate.value;
        const e = endDate.value;
        const isMulti = e && e !== s && e > s;
        timeBox.style.display = isMulti ? 'none' : 'grid';
        if (isMulti) {
            document.getElementById('start_time').value = '';
            document.getElementById('end_time').value   = '';
        }
        if (s) endDate.min = s;
    }

    startDate.addEventListener('change', toggle);
    endDate.addEventListener('change', toggle);
    toggle(); // init
})();
</script>
@endsection