@extends('layouts.admin')

@section('title', 'Data Pendaftar')
@section('page_title', 'Data Pendaftar Anggota Baru')
@section('breadcrumb', 'Layanan Publik / Pendaftaran')

@section('content')
<div class="card">
    <div class="card-header" style="flex-direction: column; align-items: stretch; gap: 16px;">
        <div style="display:flex; justify-content: space-between; align-items:center;">
            <h2 class="card-title">Daftar Formulir Pendaftaran</h2>
        </div>
        
        <form method="GET" action="{{ route('admin.registrations.index') }}" style="display:flex; gap:12px; flex-wrap:wrap;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIM..." class="form-control" style="max-width: 250px;">
            <select name="division_id" class="form-control" style="max-width: 200px;">
                <option value="">Semua Divisi</option>
                @foreach($divisions as $div)
                    <option value="{{ $div->id }}" {{ request('division_id') == $div->id ? 'selected' : '' }}>
                        {{ $div->name }}
                    </option>
                @endforeach
            </select>
            <select name="batch_year" class="form-control" style="max-width: 150px;">
                <option value="">Semua Angkatan</option>
                @for($y = date('Y'); $y >= 2010; $y--)
                    <option value="{{ $y }}" {{ request('batch_year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Waktu Daftar</th>
                    <th>Nama & NIM</th>
                    <th>Prodi & Angkatan</th>
                    <th>Divisi Diminati</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($registrations as $reg)
                    <tr>
                        <td class="text-sm">{{ $reg->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <div class="font-semibold">{{ $reg->name }}</div>
                            <div class="text-xs text-muted">{{ $reg->nim }}</div>
                        </td>
                        <td>
                            <div class="text-sm">{{ $reg->study_program }}</div>
                            <div class="text-xs text-muted">Angkatan {{ $reg->batch_year }}</div>
                        </td>
                        <td>
                            <span class="badge badge-blue">{{ $reg->division->name ?? 'Belum ada' }}</span>
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.registrations.show', $reg) }}" class="btn btn-secondary btn-sm">Detail</a>
                                @can('manage_registration')
                                <form method="POST" action="{{ route('admin.registrations.destroy', $reg) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus data pendaftaran ini?')">Hapus</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada data pendaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($registrations->hasPages())
    <div class="card-body">
        {{ $registrations->links() }}
    </div>
    @endif
</div>
@endsection
