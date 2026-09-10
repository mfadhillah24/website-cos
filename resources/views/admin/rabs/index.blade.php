@extends('layouts.admin')

@section('title', 'Daftar RAB')
@section('page_title', 'RAB')
@section('breadcrumb', 'Rencana Anggaran Biaya')

@section('content')

<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--text-primary);">Rencana Anggaran Biaya</h1>
        <p style="color:var(--text-secondary);font-size:13px;margin-top:4px;">Kelola anggaran kegiatan UKM-IT Cyber Open Source</p>
    </div>
    @can('manage_rab')
    <a href="{{ route('admin.rabs.create') }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Buat RAB
    </a>
    @endcan
</div>

@if(session('success'))
<div class="alert alert-success"><x-lucide-check-circle class="w-5 h-5" />{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-error"><x-lucide-circle class="w-5 h-5" />{{ session('error') }}</div>
@endif

{{-- Filter --}}
<form method="GET" style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kegiatan / PJ..." class="form-control" style="max-width:280px;">
    <select name="status" class="form-control" style="max-width:160px;">
        <option value="">Semua Status</option>
        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
        <option value="final" {{ request('status') === 'final' ? 'selected' : '' }}>Final</option>
    </select>
    <button type="submit" class="btn btn-secondary">Filter</button>
    @if(request()->hasAny(['search','status']))
    <a href="{{ route('admin.rabs.index') }}" class="btn btn-secondary">Reset</a>
    @endif
</form>

<div class="card">
    <div class="card-header">
        <span class="card-title">Daftar RAB</span>
        <span style="font-size:13px;color:var(--text-secondary);">{{ $rabs->total() }} RAB</span>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Kegiatan</th>
                    <th>Periode</th>
                    <th>Penanggung Jawab</th>
                    <th style="text-align:right;">Total Anggaran</th>
                    <th>Status</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rabs as $index => $rab)
                <tr>
                    <td style="color:var(--text-secondary);">{{ $rabs->firstItem() + $index }}</td>
                    <td><span style="font-family:monospace;font-size:12px;color:var(--gray-500);">{{ $rab->code }}</span></td>
                    <td style="font-weight:500;">{{ $rab->activity_name }}</td>
                    <td style="color:var(--text-secondary);">{{ $rab->period->name ?? '-' }}</td>
                    <td>
                        <div style="font-weight:500;">{{ $rab->pic_name }}</div>
                        <div style="font-size:12px;color:var(--text-secondary);">{{ $rab->pic_position }}</div>
                    </td>
                    <td style="text-align:right;font-weight:600;white-space:nowrap;">Rp {{ number_format($rab->total, 0, ',', '.') }}</td>
                    <td>
                        @if($rab->status === 'final')
                            <span class="badge badge-green">Final</span>
                        @else
                            <span class="badge badge-yellow">Draft</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        <div style="display:flex;gap:6px;justify-content:flex-end;">
                            <a href="{{ route('admin.rabs.show', $rab) }}" class="btn btn-sm btn-secondary">Lihat</a>
                            @can('manage_rab')
                            <a href="{{ route('admin.rabs.edit', $rab) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form method="POST" action="{{ route('admin.rabs.destroy', $rab) }}" onsubmit="return confirm('Hapus RAB ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:48px;color:var(--text-secondary);">
                        Belum ada RAB.
                        @can('manage_rab')
                        <a href="{{ route('admin.rabs.create') }}" style="color:#2563EB;">Buat RAB pertama</a>
                        @endcan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($rabs->hasPages())
    <div class="card-footer">{{ $rabs->links() }}</div>
    @endif
</div>

@endsection
