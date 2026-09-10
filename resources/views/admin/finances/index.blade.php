@extends('layouts.admin')

@section('title', 'Transaksi Keuangan')

@section('content')

{{-- Page Header --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--text-primary);">Transaksi Keuangan</h1>
        <p style="color:var(--text-secondary);font-size:13px;margin-top:4px;">
            @if($activePeriod)
                Periode aktif: <strong>{{ $activePeriod->name }}</strong>
            @else
                <span style="color:#EF4444;">Tidak ada periode aktif.</span>
            @endif
        </p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        {{-- Export PDF menyertakan filter bulan & tahun yang sedang aktif --}}
        <a href="{{ route('admin.finances.export-pdf', array_filter(['month' => $filterMonth, 'year' => $filterYear])) }}"
           class="btn btn-secondary" target="_blank">
            <x-lucide-download class="w-5 h-5" />
            Export PDF
        </a>
        @can('manage_finance')
        @if($activePeriod)
        <a href="{{ route('admin.finances.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:currentColor;stroke-width:2;fill:none;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Transaksi
        </a>
        @endif
        @endcan
    </div>
</div>

{{-- Flash Messages --}}
@if(session('success'))
<div class="alert alert-success">
    <x-lucide-check-circle class="w-5 h-5" />
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-error">
    <x-lucide-circle class="w-5 h-5" />
    {{ session('error') }}
</div>
@endif

{{-- ── FILTER BULAN & TAHUN ─────────────────────────────── --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="padding:16px 24px;">
        <form method="GET" action="{{ route('admin.finances.index') }}" style="display:flex;align-items:flex-end;gap:12px;flex-wrap:wrap;">
            {{-- Label Periode Laporan --}}
            <div style="flex:1;min-width:180px;">
                <div style="font-size:11px;font-weight:600;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;">Periode Laporan</div>
                <div style="font-size:14px;font-weight:700;color:var(--text-primary);">
                    @if($periodLabel !== 'Semua Periode')
                        <span style="color:#2563EB;">{{ $periodLabel }}</span>
                    @else
                        <span style="color:var(--text-secondary);">Semua Periode</span>
                    @endif
                </div>
            </div>

            {{-- Dropdown Bulan --}}
            <div style="display:flex;flex-direction:column;gap:4px;">
                <label for="filter-month" style="font-size:12px;font-weight:600;color:var(--text-secondary);">Bulan</label>
                <select id="filter-month" name="month"
                    style="padding:7px 10px;border:1px solid var(--border-color,#e2e8f0);border-radius:6px;font-size:13px;background:var(--bg-card,#fff);color:var(--text-primary);min-width:140px;cursor:pointer;">
                    <option value="">Semua Bulan</option>
                    @foreach([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $num => $nama)
                        <option value="{{ $num }}" {{ $filterMonth == $num ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Input Tahun --}}
            <div style="display:flex;flex-direction:column;gap:4px;">
                <label for="filter-year" style="font-size:12px;font-weight:600;color:var(--text-secondary);">Tahun</label>
                <input id="filter-year" type="number" name="year"
                    value="{{ $filterYear ?? date('Y') }}"
                    min="2000" max="2099" placeholder="Tahun"
                    style="padding:7px 10px;border:1px solid var(--border-color,#e2e8f0);border-radius:6px;font-size:13px;background:var(--bg-card,#fff);color:var(--text-primary);width:90px;text-align:center;">
            </div>

            {{-- Tombol Filter & Reset --}}
            <div style="display:flex;gap:8px;align-items:flex-end;">
                <button type="submit" class="btn btn-primary" style="padding:7px 16px;font-size:13px;">
                    <svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:currentColor;stroke-width:2;fill:none;display:inline;vertical-align:middle;margin-right:4px;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Filter
                </button>
                <a href="{{ route('admin.finances.index') }}" class="btn btn-secondary" style="padding:7px 16px;font-size:13px;">
                    <svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:currentColor;stroke-width:2;fill:none;display:inline;vertical-align:middle;margin-right:4px;"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.85"/></svg>
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

{{-- RAB Statistics (visible to users with view_rab permission) --}}
@can('view_rab')
<div class="card" style="margin-bottom:20px;">
    <div class="card-header" style="padding:16px 24px;">
        <span class="card-title" style="font-size:14px;">
            <x-lucide-file-text class="w-4 h-4" style="display:inline;vertical-align:middle;margin-right:6px;" />
            RAB Periode Ini
        </span>
        <a href="{{ route('admin.rabs.index') }}" style="font-size:12px;color:#2563EB;text-decoration:none;">Lihat Semua →</a>
    </div>
    <div class="card-body" style="padding:16px 24px;">
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
            <div style="text-align:center;">
                <div style="font-size:24px;font-weight:700;color:var(--text-primary);">{{ $rabCount }}</div>
                <div style="font-size:12px;color:var(--text-secondary);">Total RAB</div>
            </div>
            <div style="text-align:center;">
                <div style="font-size:24px;font-weight:700;color:#D97706;">{{ $rabDraftCount }}</div>
                <div style="font-size:12px;color:var(--text-secondary);">Draft</div>
            </div>
            <div style="text-align:center;">
                <div style="font-size:24px;font-weight:700;color:#059669;">{{ $rabFinalCount }}</div>
                <div style="font-size:12px;color:var(--text-secondary);">Final</div>
            </div>
            <div style="text-align:center;">
                <div style="font-size:18px;font-weight:700;color:#1D4ED8;">Rp {{ number_format($rabTotalBudget, 0, ',', '.') }}</div>
                <div style="font-size:12px;color:var(--text-secondary);">Total Anggaran</div>
            </div>
        </div>
    </div>
</div>
@endcan

{{-- Dashboard Summary Cards (mengikuti filter aktif) --}}
<div class="grid-3" style="margin-bottom:24px;">
    {{-- Total Pemasukan --}}
    <div class="stat-card" style="border-left:4px solid #10B981;">
        <div class="stat-icon" style="background:#ECFDF5;border-color:#D1FAE5;">
            <x-lucide-dollar-sign class="w-5 h-5" />
        </div>
        <div>
            <div class="stat-value" style="color:#065F46;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            <div class="stat-label">Total Pemasukan</div>
        </div>
    </div>
    {{-- Total Pengeluaran --}}
    <div class="stat-card" style="border-left:4px solid #EF4444;">
        <div class="stat-icon" style="background:#FEF2F2;border-color:#FECACA;">
            <x-lucide-dollar-sign class="w-5 h-5" />
        </div>
        <div>
            <div class="stat-value" style="color:#991B1B;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
            <div class="stat-label">Total Pengeluaran</div>
        </div>
    </div>
    {{-- Saldo --}}
    <div class="stat-card" style="border-left:4px solid {{ $balance >= 0 ? '#2563EB' : '#EF4444' }};">
        <div class="stat-icon" style="background:#EFF6FF;border-color:#BFDBFE;">
            <x-lucide-credit-card class="w-5 h-5" />
        </div>
        <div>
            <div class="stat-value" style="color:{{ $balance >= 0 ? '#1D4ED8' : '#991B1B' }};">
                Rp {{ number_format(abs($balance), 0, ',', '.') }}
            </div>
            <div class="stat-label">Saldo {{ $balance < 0 ? '(Defisit)' : '' }}</div>
        </div>
    </div>
</div>

{{-- Transaction Table --}}
<div class="card">
    <div class="card-header">
        <span class="card-title">
            Daftar Transaksi
            @if($periodLabel !== 'Semua Periode')
                <span style="font-size:12px;font-weight:500;color:#2563EB;margin-left:8px;background:#EFF6FF;padding:2px 8px;border-radius:10px;">{{ $periodLabel }}</span>
            @endif
        </span>
        <span style="font-size:13px;color:var(--text-secondary);">{{ $finances->count() }} transaksi</span>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Kategori</th>
                    <th>Tipe</th>
                    <th style="text-align:right;">Jumlah</th>
                    <th>Bukti</th>
                    @can('manage_finance')
                    <th style="text-align:right;">Aksi</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @forelse($finances as $finance)
                <tr>
                    <td style="white-space:nowrap;color:var(--text-secondary);">{{ $finance->date->format('d M Y') }}</td>
                    <td style="font-weight:500;">{{ $finance->description }}</td>
                    <td style="color:var(--text-secondary);">{{ $finance->category->name ?? '-' }}</td>
                    <td>
                        @if($finance->type === 'income')
                            <span class="badge badge-green">Pemasukan</span>
                        @else
                            <span class="badge badge-red">Pengeluaran</span>
                        @endif
                    </td>
                    <td style="text-align:right;font-weight:600;white-space:nowrap;color:{{ $finance->type === 'income' ? '#065F46' : '#991B1B' }};">
                        {{ $finance->type === 'income' ? '+' : '-' }} Rp {{ number_format($finance->amount, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($finance->receipt_path)
                            <a href="{{ route('file.serve', $finance->receipt_path) }}" target="_blank" class="btn btn-sm btn-secondary" style="font-size:11px;">
                                Lihat
                            </a>
                        @else
                            <span style="color:var(--gray-400);font-size:12px;">-</span>
                        @endif
                    </td>
                    @can('manage_finance')
                    <td style="text-align:right;">
                        <div style="display:flex;gap:8px;justify-content:flex-end;">
                            <a href="{{ route('admin.finances.edit', $finance) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form method="POST" action="{{ route('admin.finances.destroy', $finance) }}" onsubmit="return confirm('Hapus transaksi ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                    @endcan
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:48px;color:var(--text-secondary);">
                        @if($periodLabel !== 'Semua Periode')
                            Tidak ada transaksi untuk periode <strong>{{ $periodLabel }}</strong>.
                        @else
                            Belum ada transaksi untuk periode ini.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
