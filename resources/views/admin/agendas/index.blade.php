@extends('layouts.admin')

@section('title', 'Agenda Organisasi')
@section('page_title', 'Agenda Organisasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Agenda Organisasi</h2>
        <a href="{{ route('admin.agendas.create') }}" class="btn btn-primary">Tambah Baru</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Tipe</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($agendas as $agenda)
                    <tr>
                        <td>{{ $agenda->title }}</td>
                        <td>{{ $agenda->type }}</td>
                        <td>{{ $agenda->agenda_date }}</td>
                        <td>{{ $agenda->start_time }}</td>
                        <td>{{ $agenda->status }}</td>
                        
                        <td style="text-align:right">
                            <a href="{{ route('admin.agendas.show', $agenda) }}" class="btn btn-secondary btn-sm">Lihat</a>
                            <a href="{{ route('admin.agendas.edit', $agenda) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.agendas.destroy', $agenda) }}" style="display:inline;">
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