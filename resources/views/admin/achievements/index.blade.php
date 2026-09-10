@extends('layouts.admin')

@section('title', 'Pencapaian Divisi')
@section('page_title', 'Pencapaian Divisi')
@section('breadcrumb', 'Divisi Saya / Pencapaian')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">Kelola Pencapaian Divisi</h2>
        <a href="{{ route('admin.achievements.create') }}" class="btn btn-primary btn-sm">Tambah Pencapaian</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="100">Tahun</th>
                        <th>Judul Pencapaian</th>
                        <th>Event / Kompetisi</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($achievements as $achievement)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $achievement->year }}</td>
                            <td>{{ $achievement->title }}</td>
                            <td>{{ $achievement->event_name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.achievements.edit', $achievement) }}" class="btn btn-sm btn-info text-white">Edit</a>
                                <form action="{{ route('admin.achievements.destroy', $achievement) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pencapaian ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data pencapaian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
