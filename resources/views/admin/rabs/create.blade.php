@extends('layouts.admin')

@section('title', 'Buat RAB')
@section('page_title', 'Buat RAB')
@section('breadcrumb', 'Rencana Anggaran Biaya / Buat')

@push('styles')
<style>
/* Hide number input spinners */
input[type=number].rab-input::-webkit-inner-spin-button,
input[type=number].rab-input::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
input[type=number].rab-input { -moz-appearance: textfield; }
/* Input focus ring */
.rab-input:focus { border-color: #1E88E5 !important; box-shadow: 0 0 0 3px rgba(30,136,229,.1); }
/* Row hover */
#items-body tr:hover { background: #fafbfd; }
</style>
@endpush


@section('content')

<form method="POST" action="{{ route('admin.rabs.store') }}" id="rab-form">
@csrf

<div class="grid-2" style="align-items:start;gap:24px;">
    {{-- LEFT: Informasi RAB --}}
    <div class="card">
        <div class="card-header"><span class="card-title">Informasi RAB</span></div>
        <div class="card-body">

            <div class="form-group">
                <label class="form-label">Nama Kegiatan <span style="color:#EF4444;">*</span></label>
                <input type="text" name="activity_name" class="form-control @error('activity_name') is-invalid @enderror" value="{{ old('activity_name') }}" placeholder="Contoh: Diklat IT XV" required>
                @error('activity_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Periode <span style="color:#EF4444;">*</span></label>
                <select name="period_id" class="form-control @error('period_id') is-invalid @enderror" required>
                    <option value="">— Pilih Periode —</option>
                    @foreach($periods as $period)
                    <option value="{{ $period->id }}" {{ old('period_id') == $period->id ? 'selected' : '' }}>{{ $period->name }}</option>
                    @endforeach
                </select>
                @error('period_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Tanggal <span style="color:#EF4444;">*</span></label>
                <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', date('Y-m-d')) }}" required>
                @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Penanggung Jawab <span style="color:#EF4444;">*</span></label>
                <input type="text" name="pic_name" class="form-control @error('pic_name') is-invalid @enderror" value="{{ old('pic_name') }}" placeholder="Masukkan nama penanggung jawab" required>
                @error('pic_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Jabatan Penanggung Jawab <span style="color:#EF4444;">*</span></label>
                <input type="text" name="pic_position" class="form-control @error('pic_position') is-invalid @enderror" value="{{ old('pic_position') }}" placeholder="Contoh: Ketua Panitia" required>
                @error('pic_position')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Keterangan</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Keterangan tambahan...">{{ old('description') }}</textarea>
            </div>

        </div>
    </div>

    {{-- RIGHT: Rincian Anggaran --}}
    <div class="card">
        <div class="card-header" style="padding:16px 24px;">
            <span class="card-title">Rincian Anggaran</span>
            <button type="button" onclick="addRow()" class="btn btn-sm btn-secondary">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Item
            </button>
        </div>
        <div class="card-body" style="padding:0;">
            <div style="overflow-x:auto;">
                <table id="items-table" style="width:100%;border-collapse:collapse;table-layout:fixed;min-width:680px;">
                    <colgroup>
                        <col style="width:4%;">
                        <col style="width:30%;">
                        <col style="width:9%;">
                        <col style="width:10%;">
                        <col style="width:20%;">
                        <col style="width:21%;">
                        <col style="width:6%;">
                    </colgroup>
                    <thead>
                        <tr style="background:var(--gray-50);">
                            <th style="padding:10px 8px;font-size:11px;font-weight:600;color:var(--gray-500);text-align:center;border-bottom:1px solid var(--border-color);">#</th>
                            <th style="padding:10px 12px;font-size:11px;font-weight:600;color:var(--gray-500);border-bottom:1px solid var(--border-color);">Uraian</th>
                            <th style="padding:10px 8px;font-size:11px;font-weight:600;color:var(--gray-500);text-align:center;border-bottom:1px solid var(--border-color);">Volume</th>
                            <th style="padding:10px 8px;font-size:11px;font-weight:600;color:var(--gray-500);text-align:center;border-bottom:1px solid var(--border-color);">Satuan</th>
                            <th style="padding:10px 12px;font-size:11px;font-weight:600;color:var(--gray-500);text-align:right;border-bottom:1px solid var(--border-color);">Harga Satuan (Rp)</th>
                            <th style="padding:10px 12px;font-size:11px;font-weight:600;color:var(--gray-500);text-align:right;border-bottom:1px solid var(--border-color);">Subtotal</th>
                            <th style="padding:10px 8px;border-bottom:1px solid var(--border-color);"></th>
                        </tr>
                    </thead>
                    <tbody id="items-body">
                        {{-- JS will populate rows --}}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer" style="display:flex;justify-content:space-between;align-items:center;padding:14px 24px;">
            <span style="font-size:13px;color:var(--text-secondary);font-weight:500;">Total Anggaran</span>
            <span id="grand-total" style="font-size:20px;font-weight:700;color:var(--navy-900);">Rp 0</span>
        </div>
    </div>
</div>

@if($errors->has('items') || $errors->has('items.*'))
<div class="alert alert-error">
    <x-lucide-circle class="w-5 h-5" />
    Pastikan semua item telah diisi dengan benar dan minimal terdapat 1 item.
</div>
@endif

<div style="display:flex;gap:12px;justify-content:flex-end;margin-top:8px;">
    <a href="{{ route('admin.rabs.index') }}" class="btn btn-secondary">Batal</a>
    <button type="submit" class="btn btn-primary">Simpan RAB</button>
</div>

</form>

@push('scripts')
<script>
let rowIndex = 0;

function formatRupiah(number) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
}

function updateSubtotal(row) {
    const qty = parseFloat(row.querySelector('.qty').value) || 0;
    const price = parseFloat(row.querySelector('.price').value) || 0;
    const subtotal = qty * price;
    row.querySelector('.subtotal-display').textContent = formatRupiah(subtotal);
    row.querySelector('.subtotal-input').value = subtotal;
    updateGrandTotal();
}

function updateGrandTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal-input').forEach(function(el) {
        total += parseFloat(el.value) || 0;
    });
    document.getElementById('grand-total').textContent = formatRupiah(total);
}

function addRow(desc='', qty='', unit='', price='') {
    const tbody = document.getElementById('items-body');
    const tr = document.createElement('tr');
    tr.dataset.index = rowIndex;
    const inputStyle = 'width:100%;height:40px;padding:8px 10px;background:#fff;border:1px solid var(--gray-300);border-radius:6px;font-size:13px;font-family:Inter,sans-serif;outline:none;transition:border-color .2s;box-sizing:border-box;';
    const numInputStyle = inputStyle + 'text-align:right;-moz-appearance:textfield;';
    const centerInputStyle = inputStyle + 'text-align:center;';
    tr.innerHTML = `
        <td style="padding:10px 8px;text-align:center;color:var(--gray-400);font-size:12px;font-weight:600;vertical-align:middle;border-bottom:1px solid var(--border-color);">${tbody.children.length + 1}</td>
        <td style="padding:8px 12px;vertical-align:middle;border-bottom:1px solid var(--border-color);">
            <input type="text" name="items[${rowIndex}][description]" class="rab-input" style="${inputStyle}" placeholder="Uraian Barang..." value="${desc}" required>
        </td>
        <td style="padding:8px 6px;vertical-align:middle;border-bottom:1px solid var(--border-color);">
            <input type="number" name="items[${rowIndex}][quantity]" class="rab-input qty" style="${centerInputStyle}" placeholder="0" min="1" step="any" value="${qty}" required>
        </td>
        <td style="padding:8px 6px;vertical-align:middle;border-bottom:1px solid var(--border-color);">
            <input type="text" name="items[${rowIndex}][unit]" class="rab-input" style="${centerInputStyle}" placeholder="pcs" value="${unit}" required>
        </td>
        <td style="padding:8px 10px;vertical-align:middle;border-bottom:1px solid var(--border-color);">
            <input type="number" name="items[${rowIndex}][unit_price]" class="rab-input price" style="${numInputStyle}" placeholder="0" min="0" step="any" value="${price}" required>
        </td>
        <td style="padding:8px 12px;text-align:right;vertical-align:middle;border-bottom:1px solid var(--border-color);white-space:nowrap;">
            <span class="subtotal-display" style="font-size:13px;font-weight:600;color:var(--navy-900);">Rp 0</span>
            <input type="hidden" name="items[${rowIndex}][subtotal]" class="subtotal-input" value="0">
        </td>
        <td style="padding:8px;text-align:center;vertical-align:middle;border-bottom:1px solid var(--border-color);">
            <button type="button" onclick="removeRow(this)" title="Hapus item"
                style="background:none;border:1px solid transparent;border-radius:6px;cursor:pointer;color:var(--gray-400);width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;transition:all .2s;"
                onmouseenter="this.style.background='#FEF2F2';this.style.color='#DC2626';this.style.borderColor='#FECACA';"
                onmouseleave="this.style.background='none';this.style.color='var(--gray-400)';this.style.borderColor='transparent';">
                <svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:currentColor;stroke-width:2;fill:none;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
            </button>
        </td>`;
    tbody.appendChild(tr);
    rowIndex++;

    if (qty && price) updateSubtotal(tr);
    reNumberRows();
}

// Event delegation: satu listener di tbody menangani semua row
document.getElementById('items-body').addEventListener('input', function(e) {
    if (e.target.matches('.qty, .price')) {
        updateSubtotal(e.target.closest('tr'));
    }
});

function removeRow(btn) {
    btn.closest('tr').remove();
    reNumberRows();
    updateGrandTotal();
}

function reNumberRows() {
    const rows = document.querySelectorAll('#items-body tr');
    rows.forEach(function(row, i) {
        row.cells[0].textContent = i + 1;
    });
}

// Add initial empty row
addRow();

// Restore old values if validation failed
@if(old('items'))
document.getElementById('items-body').innerHTML = '';
rowIndex = 0;
@foreach(old('items') as $i => $item)
addRow('{{ $item["description"] ?? "" }}', '{{ $item["quantity"] ?? "" }}', '{{ $item["unit"] ?? "" }}', '{{ $item["unit_price"] ?? "" }}');
@endforeach
@endif
</script>
@endpush

@endsection
