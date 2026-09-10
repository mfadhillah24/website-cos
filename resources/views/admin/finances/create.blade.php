@extends('layouts.admin')

@section('title', 'Tambah Transaksi Keuangan')

@section('content')
<div style="max-width:700px;">
    <div style="margin-bottom:24px;">
        <a href="{{ route('admin.finances.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--text-secondary);font-size:13px;text-decoration:none;margin-bottom:12px;">
            <x-lucide-chevron-left class="w-5 h-5" />
            Kembali ke Daftar Transaksi
        </a>
        <h1 style="font-size:22px;font-weight:700;color:var(--text-primary);">Tambah Transaksi Keuangan</h1>
        <p style="color:var(--text-secondary);font-size:13px;margin-top:4px;">Periode Aktif: <strong>{{ $activePeriod->name }}</strong></p>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.finances.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Type Selection --}}
                <div class="form-group">
                    <label class="form-label">Tipe Transaksi <span style="color:#EF4444;">*</span></label>
                    <div style="display:flex;gap:12px;">
                        <label style="flex:1;cursor:pointer;">
                            <input type="radio" name="type" value="income" {{ old('type', 'income') === 'income' ? 'checked' : '' }}
                                style="display:none;" class="type-radio">
                            <div class="type-option" data-value="income"
                                style="border:2px solid {{ old('type', 'income') === 'income' ? '#10B981' : 'var(--gray-200)' }};
                                       background:{{ old('type', 'income') === 'income' ? '#ECFDF5' : 'var(--white)' }};
                                       border-radius:10px;padding:16px;text-align:center;transition:all 0.2s;">
                                <div style="font-size:20px;">💰</div>
                                <div style="font-weight:600;font-size:13px;color:{{ old('type', 'income') === 'income' ? '#065F46' : 'var(--gray-700)' }};margin-top:4px;">Pemasukan</div>
                            </div>
                        </label>
                        <label style="flex:1;cursor:pointer;">
                            <input type="radio" name="type" value="expense" {{ old('type') === 'expense' ? 'checked' : '' }}
                                style="display:none;" class="type-radio">
                            <div class="type-option" data-value="expense"
                                style="border:2px solid {{ old('type') === 'expense' ? '#EF4444' : 'var(--gray-200)' }};
                                       background:{{ old('type') === 'expense' ? '#FEF2F2' : 'var(--white)' }};
                                       border-radius:10px;padding:16px;text-align:center;transition:all 0.2s;">
                                <div style="font-size:20px;">🧾</div>
                                <div style="font-weight:600;font-size:13px;color:{{ old('type') === 'expense' ? '#991B1B' : 'var(--gray-700)' }};margin-top:4px;">Pengeluaran</div>
                            </div>
                        </label>
                    </div>
                    @error('type')<div class="invalid-feedback" style="display:block;">{{ $message }}</div>@enderror
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Tanggal <span style="color:#EF4444;">*</span></label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                            value="{{ old('date', date('Y-m-d')) }}" required>
                        @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah (Rp) <span style="color:#EF4444;">*</span></label>
                        <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                            value="{{ old('amount') }}" placeholder="cth. 500000" min="1" required>
                        @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori <span style="color:#EF4444;">*</span></label>
                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories->groupBy('type') as $type => $group)
                            <optgroup label="{{ $type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}">
                                @foreach($group as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi / Keterangan <span style="color:#EF4444;">*</span></label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                        rows="3" placeholder="cth. Iuran anggota bulan Agustus..." required>{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Bukti Transaksi (opsional)</label>
                    <input type="file" name="receipt" class="form-control @error('receipt') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.pdf">
                    <div class="form-text">Format: JPG, PNG, PDF. Maks. 2MB.</div>
                    @error('receipt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    <a href="{{ route('admin.finances.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.type-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.type-option').forEach(opt => {
                opt.style.borderColor = 'var(--gray-200)';
                opt.style.background = 'var(--white)';
                opt.querySelector('div:last-child').style.color = 'var(--gray-700)';
            });
            const selected = this.closest('label').querySelector('.type-option');
            if (this.value === 'income') {
                selected.style.borderColor = '#10B981';
                selected.style.background = '#ECFDF5';
                selected.querySelector('div:last-child').style.color = '#065F46';
            } else {
                selected.style.borderColor = '#EF4444';
                selected.style.background = '#FEF2F2';
                selected.querySelector('div:last-child').style.color = '#991B1B';
            }
        });
    });
</script>
@endpush
@endsection
