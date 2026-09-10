@extends('layouts.admin')
@section('title', 'Detail Surat Masuk')
@section('page_title', 'Detail Surat Masuk')

@section('content')
<div class="flex gap-4 mb-4">
    <a href="{{ route('admin.letters.incoming.index') }}" class="btn btn-secondary">Kembali</a>
    <a href="{{ route('admin.letters.incoming.edit', $letter) }}" class="btn btn-primary">Edit</a>
    <form action="{{ route('admin.letters.incoming.destroy', $letter) }}" method="POST" onsubmit="return confirm('Hapus surat ini?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus</button>
    </form>
</div>
<div class="grid-2">
    <div class="card">
        <div class="card-header"><h3 class="card-title">Informasi Surat</h3></div>
        <div class="card-body">
            <p><strong>No. Agenda:</strong> {{ $letter->agenda_number }}</p>
            <p><strong>No. Surat:</strong> {{ $letter->letter_number }}</p>
            <p><strong>Pengirim:</strong> {{ $letter->sender }}</p>
            <p><strong>Perihal:</strong> {{ $letter->subject }}</p>
            <p><strong>Status:</strong> {{ ucfirst($letter->status) }}</p>
            @if($letter->file_path)
            <p class="mt-3"><a href="{{ route('file.serve', $letter->file_path) }}" target="_blank" class="btn btn-secondary btn-sm">Lihat Lampiran</a></p>
            @endif
        </div>
    </div>
    
    </div>
</div>
@endsection