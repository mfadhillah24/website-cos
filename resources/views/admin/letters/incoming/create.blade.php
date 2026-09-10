@extends('layouts.admin')
@section('title', 'Tambah Surat Masuk')
@section('page_title', 'Tambah Surat Masuk')

@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title">Form Surat Masuk</h3></div>
    <div class="card-body">
        <form action="{{ route('admin.letters.incoming.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Nomor Agenda</label>
                    <input type="text" name="agenda_number" class="form-control" value="{{ old('agenda_number') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor Surat *</label>
                    <input type="text" name="letter_number" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Surat *</label>
                    <input type="date" name="letter_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Terima *</label>
                    <input type="date" name="received_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Pengirim *</label>
                    <input type="text" name="sender" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Perihal *</label>
                    <input type="text" name="subject" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Sifat Surat</label>
                    <select name="priority" class="form-control">
                        <option value="Biasa">Biasa</option>
                        <option value="Penting">Penting</option>
                        <option value="Segera">Segera</option>
                        <option value="Rahasia">Rahasia</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">File Scan (PDF/IMG)</label>
                    <input type="file" name="file" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Simpan Data</button>
        </form>
    </div>
</div>
@endsection