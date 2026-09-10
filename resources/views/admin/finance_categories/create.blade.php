@extends('layouts.admin')

@section('title', 'Tambah Kategori Keuangan')

@section('content')
<div style="max-width:600px;">
    <div class="page-header" style="margin-bottom:24px;">
        <a href="{{ route('admin.finance-categories.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--text-secondary);font-size:13px;text-decoration:none;margin-bottom:12px;">
            <x-lucide-chevron-left class="w-5 h-5" />
            Kembali ke Daftar Kategori
        </a>
        <h1 style="font-size:22px;font-weight:700;color:var(--text-primary);">Tambah Kategori Keuangan</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.finance-categories.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nama Kategori <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" placeholder="cth. Iuran Anggota, Dana Kegiatan..." required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tipe <span style="color:#EF4444;">*</span></label>
                    <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                        rows="3" placeholder="Keterangan tambahan (opsional)...">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                    <a href="{{ route('admin.finance-categories.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
