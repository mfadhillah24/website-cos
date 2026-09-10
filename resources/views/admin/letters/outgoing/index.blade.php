@extends('layouts.admin')
@section('title', 'Surat Keluar')
@section('page_title', 'Surat Keluar')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Surat Keluar</h3>
        <a href="{{ route('admin.letters.outgoing.create') }}" class="btn btn-primary">+ Tambah Surat</a>
    </div>
    <div class="card-body">
        <div class="table-wrap">
            <table>
                <thead><tr><th>No. Surat</th><th>Kepada</th><th>Perihal</th><th>Tanggal</th><th>Status</th><th style="text-align:right">Aksi</th></tr></thead>
                <tbody>
                    @forelse($letters as $letter)
                    <tr>
                        <td>{{ $letter->letter_number }}</td>
                        <td>{{ $letter->receiver }}</td>
                        <td>{{ $letter->subject }}</td>
                        <td>{{ $letter->letter_date->format('d/m/Y') }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $letter->status)) }}</td>
                        <td style="text-align:right">
                            <a href="{{ route('admin.letters.outgoing.show', $letter) }}" class="btn btn-secondary btn-sm">Detail</a>
                            <a href="{{ route('admin.letters.outgoing.edit', $letter) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.letters.outgoing.destroy', $letter) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center" style="padding:20px;">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($letters->hasPages())
        <div style="margin-top:20px;">
            {{ $letters->links() }}
        </div>
        @endif
    </div>
</div>
@endsection