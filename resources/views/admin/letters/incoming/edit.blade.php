@extends('layouts.admin')
@section('title', 'Edit Surat Masuk')
@section('page_title', 'Edit Surat Masuk')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.letters.incoming.update', $letter) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="baru" @selected($letter->status=='baru')>Baru</option>
                        <option value="diproses" @selected($letter->status=='diproses')>Diproses</option>
                        <option value="didisposisikan" @selected($letter->status=='didisposisikan')>Didisposisikan</option>
                        <option value="selesai" @selected($letter->status=='selesai')>Selesai</option>
                        <option value="diarsipkan" @selected($letter->status=='diarsipkan')>Diarsipkan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor Agenda</label>
                    <input type="text" name="agenda_number" class="form-control" value="{{ $letter->agenda_number }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor Surat *</label>
                    <input type="text" name="letter_number" class="form-control" value="{{ $letter->letter_number }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Surat *</label>
                    <input type="date" name="letter_date" class="form-control" value="{{ $letter->letter_date->format('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Terima *</label>
                    <input type="date" name="received_date" class="form-control" value="{{ $letter->received_date->format('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Pengirim *</label>
                    <input type="text" name="sender" class="form-control" value="{{ $letter->sender }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Perihal *</label>
                    <input type="text" name="subject" class="form-control" value="{{ $letter->subject }}" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update Data</button>
        </form>
    </div>
</div>
@endsection