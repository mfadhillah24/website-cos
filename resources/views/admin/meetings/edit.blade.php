@extends('layouts.admin')

@section('title', 'Edit Rapat Organisasi')
@section('page_title', 'Edit Rapat Organisasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Edit Rapat Organisasi</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.meetings.update', $meeting) }}" method="POST">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="alert alert-danger" style="margin-bottom:16px; padding:12px; border-radius:6px; background:#fee2e2; border:1px solid #fca5a5; color:#b91c1c;">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label>Topik <span style="color:red">*</span></label>
                <input type="text" name="title" value="{{ old('title', $meeting->title) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Tanggal <span style="color:red">*</span></label>
                <input type="date" name="meeting_date" value="{{ old('meeting_date', $meeting->meeting_date->format('Y-m-d')) }}" class="form-control" required>
            </div>

            <div style="display:flex; gap:16px;">
                <div class="form-group" style="flex:1">
                    <label>Waktu Mulai</label>
                    <input type="time" name="start_time" value="{{ old('start_time', $meeting->start_time) }}" class="form-control">
                    <small style="color:#64748b;">Format 24 jam (HH:mm) — WITA</small>
                </div>
                <div class="form-group" style="flex:1">
                    <label>Waktu Selesai</label>
                    <input type="time" name="end_time" value="{{ old('end_time', $meeting->end_time) }}" class="form-control">
                    <small style="color:#64748b;">Format 24 jam (HH:mm) — WITA</small>
                </div>
            </div>

            <div class="form-group">
                <label>Lokasi</label>
                <input type="text" name="location" value="{{ old('location', $meeting->location) }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Agenda Rapat</label>
                <textarea name="agenda" class="form-control" rows="4">{{ old('agenda', $meeting->agenda) }}</textarea>
            </div>

            <div class="form-group">
                <label>Jumlah Peserta Hadir</label>
                <input type="number" name="attendance_count"
                       value="{{ old('attendance_count', $meeting->attendance_count) }}"
                       class="form-control" min="0" max="10000" placeholder="Contoh: 15">
                <small style="color:#64748b;">Total peserta yang hadir dalam rapat</small>
            </div>

            <div style="margin-top:24px; display:flex; gap:12px;">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.meetings.show', $meeting) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection