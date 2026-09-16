@extends('layouts.admin')

@section('title', 'Data Pendaftar')
@section('page_title', 'Data Pendaftar Anggota Baru')
@section('breadcrumb', 'Layanan Publik / Pendaftaran')

@section('content')
<div class="card">
    <div class="card-header" style="flex-direction: column; align-items: stretch; gap: 16px;">
        <div style="display:flex; justify-content: space-between; align-items:center;">
            <h2 class="card-title">Daftar Formulir Pendaftaran</h2>
            @can('view_registration')
            <a href="{{ route('admin.registrations.export-pdf', array_filter([
                    'search'      => request('search'),
                    'division_id' => request('division_id'),
                    'batch_year'  => request('batch_year'),
                ])) }}"
               class="btn btn-primary"
               style="display:inline-flex; align-items:center; gap:6px; white-space:nowrap;"
               title="Export daftar peserta yang sedang ditampilkan ke PDF">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Export PDF
            </a>
            @endcan
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
                                @can('view_registration')
                                <a href="{{ route('admin.registrations.export-single-pdf', $reg) }}" class="btn btn-primary btn-sm" title="Export PDF">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                        <polyline points="7 10 12 15 17 10"/>
                                        <line x1="12" y1="15" x2="12" y2="3"/>
                                    </svg>
                                </a>
                                @endcan
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
