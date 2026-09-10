@extends('layouts.admin')
@section('title', 'Detail Surat Keluar')
@section('page_title', 'Detail Surat Keluar')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Surat Keluar</h3>
    </div>
    <div class="card-body">
        <table class="table-wrap" style="width: 100%;">
            <tr><th style="width: 200px;">Nomor Surat</th><td>{{ $letter->letter_number }}</td></tr>
            <tr><th>Tanggal Surat</th><td>{{ $letter->letter_date->format('d/m/Y') }}</td></tr>
            <tr><th>Kepada (Tujuan)</th><td>{{ $letter->receiver }}</td></tr>
            <tr><th>Perihal (Subject)</th><td>{{ $letter->subject }}</td></tr>
            <tr><th>Jenis Surat</th><td>{{ $letter->letter_type ?? '-' }}</td></tr>
            <tr><th>Penandatangan</th><td>{{ $letter->signer ?? '-' }} ({{ $letter->signer_position ?? '-' }})</td></tr>
            <tr><th>Status</th><td>{{ ucfirst(str_replace('_', ' ', $letter->status)) }}</td></tr>
            <tr><th>Ringkasan / Isi</th><td>{{ $letter->summary ?? '-' }}</td></tr>
            <tr><th>Catatan</th><td>{{ $letter->notes ?? '-' }}</td></tr>
            <tr><th>File Dokumen (PDF)</th><td>
                @if($letter->file_path)
                    <a href="{{ route('file.serve', $letter->file_path) }}" target="_blank" class="btn btn-primary btn-sm">Buka PDF</a>
                @else
                    <span class="text-muted">Tidak ada file PDF terlampir.</span>
                @endif
            </td></tr>
        </table>
        
        <div style="margin-top:20px;">
            <a href="{{ route('admin.letters.outgoing.edit', $letter) }}" class="btn btn-primary">Edit Surat</a>
            <a href="{{ route('admin.letters.outgoing.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection