@extends('layouts.admin')

@section('title', 'Edit Anggota')
@section('page_title', 'Edit Anggota')
@section('breadcrumb', 'Anggota / Edit')

@section('content')
<div style="max-width: 800px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Edit: {{ $member->name }}</h2>
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.members.update', $member) }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="division_id">Bidang COS (Divisi) <span class="text-sm" style="color: #EF4444;" id="division_asterisk">*</span></label>
                        <select name="division_id" id="division_id" class="form-control {{ $errors->has('division_id') ? 'is-invalid' : '' }}">
                            <option value="">-- Pilih Bidang --</option>
                            @foreach ($divisions as $div)
                                <option value="{{ $div->id }}" {{ old('division_id', $currentDivision) == $div->id ? 'selected' : '' }}>{{ $div->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Wajib diisi jika Status Keanggotaan adalah <strong>Anggota Muda</strong>.</div>
                        @error('division_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="angkatan">Tahun Angkatan</label>
                        <input id="angkatan" type="text" name="angkatan" value="{{ old('angkatan', $member->angkatan) }}"
                            class="form-control {{ $errors->has('angkatan') ? 'is-invalid' : '' }}">
                        @error('angkatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="nta">Nomor Induk Anggota (NTA)</label>
                        <input id="nta" type="text" name="nta" value="{{ old('nta', $member->nta) }}"
                            class="form-control {{ $errors->has('nta') ? 'is-invalid' : '' }}"
                            placeholder="Contoh: COS.UNITAMA.VII.001.2024-2025"
                            style="font-family: monospace;">
                        <div class="form-text">Hanya diisi untuk <strong>Anggota Tetap</strong>. Kosongkan jika Anggota Muda.</div>
                        @error('nta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="generation">Angkatan UKM (Generasi ke-)</label>
                        <input id="generation" type="number" name="generation" value="{{ old('generation', $member->generation) }}"
                            class="form-control {{ $errors->has('generation') ? 'is-invalid' : '' }}" placeholder="Contoh: 7" min="1">
                        <div class="form-text">Generasi ke-berapa di UKM. Informasi tambahan pada data anggota.</div>
                        @error('generation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap <span class="text-sm" style="color: #EF4444;">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name', $member->name) }}"
                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="email">Email Kontak</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $member->email) }}"
                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">Nomor HP</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone', $member->phone) }}"
                            class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group" style="padding: 16px; background: var(--gray-50); border: 1px solid var(--gray-200); border-radius: 10px; margin-top: 10px; margin-bottom: 24px;">
                    <label class="form-label" for="status_id">Status Keanggotaan <span class="text-sm" style="color: #EF4444;">*</span></label>
                    <select name="status_id" id="status_id" class="form-control {{ $errors->has('status_id') ? 'is-invalid' : '' }}" required>
                        @foreach ($statuses as $st)
                            <option value="{{ $st->id }}" {{ old('status_id', $member->status_id) == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                        @endforeach
                    </select>
                    @error('status_id')<div class="invalid-feedback">{{ $message }}</div>@enderror

                    <div style="margin-top: 16px;">
                        <label class="form-label" for="status_change_notes" style="font-weight:400; font-size:12px; color: var(--gray-500);">Catatan Perubahan Status (Opsional, diisi jika status diubah)</label>
                        <input type="text" name="status_change_notes" id="status_change_notes" value="{{ old('status_change_notes') }}" 
                            class="form-control" placeholder="Alasan perubahan...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="user_id">Tautkan ke Akun Login (Opsional)</label>
                    <select name="user_id" id="user_id" class="form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}">
                        <option value="">-- Tidak Ditautkan --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $member->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group" style="margin-top: 16px;">
                    <label style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                        <input type="checkbox" name="is_founder" value="1" {{ old('is_founder', $member->is_founder) ? 'checked' : '' }} style="accent-color: var(--blue-600); width:16px; height:16px;">
                        <span class="form-label" style="margin-bottom:0;">Tandai sebagai Pendiri (Founder)</span>
                    </label>
                </div>

                <hr style="border:0; border-top:1px solid var(--border-color); margin:32px 0;">

                <div class="form-group">
                    <label class="form-label" for="photo">Foto Profil (Biarkan kosong jika tidak diubah)</label>
                    @if($member->photo)
                        <div style="margin-bottom:12px;">
                            <img src="{{ asset('images/' . $member->photo) }}" alt="Foto" style="width:80px; height:80px; object-fit:cover; border-radius:10px; border: 1px solid var(--gray-200);">
                        </div>
                    @endif
                    <input id="photo" type="file" name="photo" accept="image/*" class="form-control {{ $errors->has('photo') ? 'is-invalid' : '' }}" style="padding: 6px 12px;">
                    @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="bio">Biografi Singkat</label>
                    <textarea id="bio" name="bio" rows="3" class="form-control {{ $errors->has('bio') ? 'is-invalid' : '' }}">{{ old('bio', $member->bio) }}</textarea>
                    @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
