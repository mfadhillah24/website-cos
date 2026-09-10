@extends('layouts.admin')
@section('title', 'Tambah Surat Keluar')
@section('page_title', 'Tambah Surat Keluar')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Surat Keluar</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.letters.outgoing.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid-2">
                <div class="form-group"><label class="form-label">Nomor Surat</label><input type="text" name="letter_number" class="form-control" value="{{ old('letter_number', $letterNumber ?? '') }}" required>
            </div>
                <div class="form-group"><label class="form-label">Tanggal Surat</label><input type="date" name="letter_date" class="form-control" value="{{ old('letter_date') }}" required></div>
                <div class="form-group"><label class="form-label">Kepada (Tujuan)</label><input type="text" name="receiver" class="form-control" value="{{ old('receiver') }}" required></div>
                <div class="form-group"><label class="form-label">Perihal (Subject)</label><input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required></div>
                <div class="form-group"><label class="form-label">Jenis Surat</label><input type="text" name="letter_type" class="form-control" value="{{ old('letter_type') }}"></div>
                <div class="form-group"><label class="form-label">Penandatangan</label><input type="text" name="signer" class="form-control" value="{{ old('signer') }}"></div>
                <div class="form-group"><label class="form-label">Jabatan Penandatangan</label><input type="text" name="signer_position" class="form-control" value="{{ old('signer_position') }}"></div>
                <div class="form-group"><label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="draft">Draft</option>
                        <option value="menunggu_persetujuan">Menunggu Persetujuan</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="diarsipkan">Diarsipkan</option>
                    </select>
                </div>
            </div>
            <div class="form-group"><label class="form-label">Ringkasan / Isi Singkat</label><textarea name="summary" class="form-control" rows="3">{{ old('summary') }}</textarea></div>
            <div class="form-group"><label class="form-label">Catatan</label><textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea></div>
            <div class="form-group"><label class="form-label">Upload PDF (Opsional)</label><input type="file" name="file" class="form-control" accept=".pdf"></div>
            
            <div style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.letters.outgoing.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection