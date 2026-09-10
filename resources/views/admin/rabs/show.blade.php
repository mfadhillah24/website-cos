@extends('layouts.admin')

@section('title', 'Detail RAB — ' . $rab->activity_name)
@section('page_title', 'Detail RAB')
@section('breadcrumb', 'RAB / Detail')

@section('content')

@if(session('success'))
<div class="alert alert-success"><x-lucide-check-circle class="w-5 h-5" />{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-error"><x-lucide-circle class="w-5 h-5" />{{ session('error') }}</div>
@endif

{{-- Header Aksi --}}
<div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;margin-bottom:24px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--text-primary);">{{ $rab->activity_name }}</h1>
        <div style="display:flex;align-items:center;gap:10px;margin-top:6px;">
            <span style="font-family:monospace;font-size:12px;color:var(--gray-400);">{{ $rab->code }}</span>
            @if($rab->status === 'final')
                <span class="badge badge-green">Final</span>
            @else
                <span class="badge badge-yellow">Draft</span>
            @endif
        </div>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <a href="{{ route('admin.rabs.index') }}" class="btn btn-secondary">← Kembali</a>
        @can('view_rab')
        <a href="{{ route('admin.rabs.pdf', $rab) }}" class="btn btn-secondary" target="_blank">
            <x-lucide-download class="w-4 h-4" />
            Ekspor PDF
        </a>
        @endcan
        @can('manage_rab')
        <a href="{{ route('admin.rabs.edit', $rab) }}" class="btn btn-secondary">Edit</a>
        @if($rab->status !== 'final')
        <form method="POST" action="{{ route('admin.rabs.finalize', $rab) }}" onsubmit="return confirm('Finalisasi RAB ini? Status tidak dapat dikembalikan ke Draft.')">
            @csrf
            <button class="btn btn-accent">Finalisasi</button>
        </form>
        @endif
        @endcan
    </div>
</div>

<div class="grid-2" style="align-items:start;gap:24px;">
    {{-- Informasi Umum --}}
    <div class="card">
        <div class="card-header"><span class="card-title">Informasi Kegiatan</span></div>
        <div class="card-body">
            <table style="width:100%;border-collapse:collapse;">
                <tr><td style="padding:8px 0;color:var(--text-secondary);width:40%;font-size:13px;">Nama Kegiatan</td><td style="padding:8px 0;font-weight:500;font-size:13px;">{{ $rab->activity_name }}</td></tr>
                <tr><td style="padding:8px 0;color:var(--text-secondary);font-size:13px;">Periode</td><td style="padding:8px 0;font-size:13px;">{{ $rab->period->name ?? '-' }}</td></tr>
                <tr><td style="padding:8px 0;color:var(--text-secondary);font-size:13px;">Tanggal</td><td style="padding:8px 0;font-size:13px;">{{ $rab->date?->format('d F Y') }}</td></tr>
                <tr style="border-top:1px solid var(--border-color);">
                    <td style="padding:10px 0 8px;color:var(--text-secondary);font-size:13px;">Penanggung Jawab</td>
                    <td style="padding:10px 0 8px;font-size:13px;"><strong>{{ $rab->pic_name ?: '—' }}</strong></td>
                </tr>
                <tr>
                    <td style="padding:8px 0;color:var(--text-secondary);font-size:13px;">Jabatan</td>
                    <td style="padding:8px 0;font-size:13px;">{{ $rab->pic_position ?: '—' }}</td>
                </tr>
                @if($rab->description)
                <tr style="border-top:1px solid var(--border-color);">
                    <td colspan="2" style="padding:10px 0 0;">
                        <div style="font-size:12px;color:var(--text-secondary);margin-bottom:4px;">Keterangan</div>
                        <div style="font-size:13px;">{{ $rab->description }}</div>
                    </td>
                </tr>
                @endif
                <tr style="border-top:1px solid var(--border-color);">
                    <td style="padding:10px 0 8px;color:var(--text-secondary);font-size:13px;">Dibuat oleh</td>
                    <td style="padding:10px 0 8px;font-size:13px;">{{ $rab->creator->name ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Total Anggaran --}}
    <div class="stat-card" style="flex-direction:column;align-items:flex-start;">
        <div style="font-size:13px;color:var(--text-secondary);">Total Anggaran</div>
        <div style="font-size:32px;font-weight:700;color:var(--navy-900);margin:4px 0;">Rp {{ number_format($rab->total, 0, ',', '.') }}</div>
        <div style="font-size:13px;color:var(--text-secondary);">{{ $rab->items->count() }} item anggaran</div>
    </div>
</div>

{{-- Rincian Item --}}
<div class="card">
    <div class="card-header"><span class="card-title">Rincian Anggaran</span></div>
    <div class="card-body" style="padding:0;">
        <table class="table">
            <thead>
                <tr>
                    <th style="width:40px;">No</th>
                    <th>Uraian</th>
                    <th style="width:80px;">Volume</th>
                    <th style="width:80px;">Satuan</th>
                    <th style="width:140px;text-align:right;">Harga Satuan</th>
                    <th style="width:140px;text-align:right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rab->items as $i => $item)
                <tr>
                    <td style="color:var(--text-secondary);">{{ $i + 1 }}</td>
                    <td style="font-weight:500;">{{ $item->description }}</td>
                    <td>{{ number_format($item->quantity, 0, ',', '.') }}</td>
                    <td style="color:var(--text-secondary);">{{ $item->unit }}</td>
                    <td style="text-align:right;white-space:nowrap;">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td style="text-align:right;font-weight:600;white-space:nowrap;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:32px;color:var(--text-secondary);">Belum ada item.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background:var(--gray-50);">
                    <td colspan="5" style="padding:16px 24px;text-align:right;font-weight:600;color:var(--text-primary);">Total Anggaran</td>
                    <td style="padding:16px 24px;text-align:right;font-weight:700;font-size:16px;color:var(--navy-900);white-space:nowrap;">Rp {{ number_format($rab->total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection
