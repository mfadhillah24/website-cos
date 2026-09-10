@extends('layouts.admin')

@section('title', 'Kategori Keuangan')

@section('content')
<div class="page-header" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--text-primary);">Kategori Keuangan</h1>
        <p style="color:var(--text-secondary);font-size:13px;margin-top:4px;">Kelola kategori pemasukan dan pengeluaran organisasi.</p>
    </div>
    <a href="{{ route('admin.finance-categories.create') }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:currentColor;stroke-width:2;fill:none;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Kategori
    </a>
</div>

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

<div class="card">
    <div class="card-body" style="padding:0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Tipe</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Transaksi</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td style="font-weight:500;">{{ $category->name }}</td>
                    <td>
                        @if($category->type === 'income')
                            <span class="badge badge-green">Pemasukan</span>
                        @else
                            <span class="badge badge-red">Pengeluaran</span>
                        @endif
                    </td>
                    <td style="color:var(--text-secondary);">{{ $category->description ?? '-' }}</td>
                    <td>{{ $category->finances_count }} transaksi</td>
                    <td style="text-align:right;">
                        <div style="display:flex;gap:8px;justify-content:flex-end;">
                            <a href="{{ route('admin.finance-categories.edit', $category) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form method="POST" action="{{ route('admin.finance-categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:48px;color:var(--text-secondary);">
                        Belum ada kategori keuangan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
