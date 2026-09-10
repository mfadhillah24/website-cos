@extends('layouts.admin')

@section('title', 'Notulen Rapat')
@section('page_title', 'Notulen Rapat')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Notulen Rapat</h2>
        <a href="{{ route('admin.minutes.create') }}" class="btn btn-primary">Tambah Baru</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Rapat</th>
                    <th>Pemimpin</th>
                    <th>Notulis</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($minutes as $minute)
                    <tr>
                        <td>{{ $minute->meeting->title ?? '-' }}</td>
                        <td>{{ $minute->leader }}</td>
                        <td>{{ $minute->notulist }}</td>
                        
                        <td style="text-align:right">
                            <a href="{{ route('admin.minutes.show', $minute) }}" class="btn btn-secondary btn-sm">Lihat</a>
                            <a href="{{ route('admin.minutes.edit', $minute) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.minutes.destroy', $minute) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align:center; padding:20px;">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection