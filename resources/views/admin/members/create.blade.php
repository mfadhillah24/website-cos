@extends('layouts.admin')

@section('title', 'Tambah Anggota')
@section('page_title', 'Tambah Anggota')
@section('breadcrumb', 'Anggota / Tambah Baru')

@section('content')
<div style="max-width: 800px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Formulir Anggota Baru</h2>
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.members.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="division_id">Bidang COS (Divisi) <span class="text-sm" style="color: #EF4444;" id="division_asterisk">*</span></label>
                        <select name="division_id" id="division_id" class="form-control {{ $errors->has('division_id') ? 'is-invalid' : '' }}">
                            <option value="">-- Pilih Bidang --</option>
                            @foreach ($divisions as $div)
                                <option value="{{ $div->id }}" {{ old('division_id') == $div->id ? 'selected' : '' }}>{{ $div->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Wajib diisi jika Status Keanggotaan adalah <strong>Anggota Muda</strong>.</div>
                        @error('division_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="angkatan">Tahun Angkatan</label>
                        <input id="angkatan" type="text" name="angkatan" value="{{ old('angkatan') }}"
                            class="form-control {{ $errors->has('angkatan') ? 'is-invalid' : '' }}" placeholder="Contoh: 2023">
                        @error('angkatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="nta">Nomor Induk Anggota (NTA)</label>
                    <input id="nta" type="text" name="nta" value="{{ old('nta') }}"
                        class="form-control {{ $errors->has('nta') ? 'is-invalid' : '' }}"
                        placeholder="Contoh: COS.UNITAMA.VII.001.2024-2025"
                        style="font-family: monospace;">
                    <div class="form-text">Hanya diisi untuk <strong>Anggota Tetap</strong>. Format: COS.UNITAMA.(Angkatan Romawi).(Nomor Urut).(Periode). Kosongkan jika Anggota Muda.</div>
                    @error('nta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="generation">Angkatan UKM (Generasi ke-)</label>
                    <input id="generation" type="number" name="generation" value="{{ old('generation') }}"
                        class="form-control {{ $errors->has('generation') ? 'is-invalid' : '' }}" placeholder="Contoh: 7" min="1">
                    <div class="form-text">Contoh: 7 → generasi ke-7 UKM-IT COS.</div>
                    @error('generation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap <span class="text-sm" style="color: #EF4444;">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="email">Email Kontak</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">Nomor HP</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                            class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="status_id">Status Keanggotaan <span class="text-sm" style="color: #EF4444;">*</span></label>
                    <select name="status_id" id="status_id" class="form-control {{ $errors->has('status_id') ? 'is-invalid' : '' }}" required>
                        <option value="">-- Pilih Status --</option>
                        @foreach ($statuses as $st)
                            <option value="{{ $st->id }}" {{ old('status_id') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                        @endforeach
                    </select>
                    @error('status_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="user_id">Tautkan ke Akun Login (Opsional)</label>
                    <select name="user_id" id="user_id" class="form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}">
                        <option value="">-- Tidak Ditautkan --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    <div class="form-text">Pilih akun jika anggota ini juga diberikan hak akses login ke sistem.</div>
                    @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group" style="margin-top: 16px;">
                    <label style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                        <input type="checkbox" name="is_founder" value="1" {{ old('is_founder') ? 'checked' : '' }} style="accent-color: var(--blue-600); width:16px; height:16px;">
                        <span class="form-label" style="margin-bottom:0;">Tandai sebagai Pendiri (Founder)</span>
                    </label>
                </div>

                <hr style="border:0; border-top:1px solid var(--border-color); margin:32px 0;">

                <div class="form-group">
                    <label class="form-label" for="photo">Foto Profil</label>
                    <input id="photo" type="file" name="photo" accept="image/*" class="form-control {{ $errors->has('photo') ? 'is-invalid' : '' }}" style="padding: 6px 12px;">
                    @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="bio">Biografi Singkat</label>
                    <textarea id="bio" name="bio" rows="3" class="form-control {{ $errors->has('bio') ? 'is-invalid' : '' }}">{{ old('bio') }}</textarea>
                    @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan Anggota</button>
                    <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status_id');
        const asterisk = document.getElementById('division_asterisk');

        function updateAsterisk() {
            if (statusSelect.value === '1') {
                asterisk.style.display = 'inline';
            } else {
                asterisk.style.display = 'none';
            }
        }

        statusSelect.addEventListener('change', updateAsterisk);
        updateAsterisk(); // initial check
    });
</script>
@endsection
