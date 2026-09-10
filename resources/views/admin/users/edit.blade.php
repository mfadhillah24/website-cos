@extends('layouts.admin')

@section('title', 'Edit Pengguna')
@section('page_title', 'Edit Pengguna')
@section('breadcrumb', 'Pengguna / Edit')

@section('content')
<div style="max-width: 640px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Edit: {{ $user->name }}</h2>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap <span class="text-sm" style="color: #EF4444;">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email <span class="text-sm" style="color: #EF4444;">*</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password Baru <span class="text-xs text-muted">(kosongkan jika tidak diubah)</span></label>
                    <input id="password" type="password" name="password"
                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        placeholder="Min. 8 karakter">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Role <span class="text-sm" style="color: #EF4444;">*</span></label>
                    <div class="flex" style="flex-wrap: wrap; gap: 12px; margin-top: 8px;">
                        @php $userRoles = old('roles', $user->roles->pluck('name')->toArray()); @endphp
                        @foreach ($roles as $role)
                            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;
                                padding: 8px 16px;
                                background: var(--gray-50);
                                border: 1px solid {{ in_array($role->name, $userRoles) ? 'var(--blue-600)' : 'var(--gray-300)' }};
                                border-radius: 8px; font-size:13px; color: var(--gray-800); transition: all 0.2s;">
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                    {{ in_array($role->name, $userRoles) ? 'checked' : '' }}
                                    style="accent-color: var(--blue-600); width: 16px; height: 16px;">
                                {{ $role->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('roles')<div class="invalid-feedback" style="display:block;">{{ $message }}</div>@enderror
                </div>

                {{-- Dynamic Kabid Bidang Info --}}
                <div id="kabid-division-info" style="display:none; margin-top:4px;">
                    <div style="background: rgba(59,130,246,.06); border: 1px solid rgba(59,130,246,.3);
                        border-radius: 10px; padding: 14px 18px;">
                        <div style="font-size:13px;font-weight:600;color:var(--blue-600);margin-bottom:4px;">
                            🏢 Bidang yang akan ditetapkan:
                        </div>
                        <div id="kabid-division-name" style="font-size:15px;font-weight:700;color:var(--navy-800);"></div>
                        <div style="font-size:12px;color:var(--gray-500);margin-top:4px;">
                            Bidang ditentukan otomatis dari role Kabid yang dipilih.
                        </div>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border-color);">
                    <label style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                            style="accent-color: var(--blue-600); width:16px; height:16px;">
                        <span class="form-label" style="margin-bottom:0;">Akun aktif</span>
                    </label>
                </div>

                <div class="flex gap-3" style="margin-top: 32px;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const kabidMap = {
    'Kabid Networking':               'Networking',
    'Kabid Programming':              'Programming',
    'Kabid Desain Komunikasi Visual': 'Desain Komunikasi Visual',
};

function updateKabidInfo() {
    const checkboxes = document.querySelectorAll('input[name="roles[]"]');
    let kabidDivision = null;

    checkboxes.forEach(cb => {
        if (cb.checked && kabidMap[cb.value]) {
            kabidDivision = kabidMap[cb.value];
        }
        const lbl = cb.closest('label');
        if (lbl) {
            lbl.style.borderColor = cb.checked ? 'var(--blue-600)' : 'var(--gray-300)';
        }
    });

    const infoBox = document.getElementById('kabid-division-info');
    const divName = document.getElementById('kabid-division-name');
    if (kabidDivision) {
        divName.textContent = kabidDivision;
        infoBox.style.display = 'block';
    } else {
        infoBox.style.display = 'none';
    }
}

document.querySelectorAll('input[name="roles[]"]').forEach(cb => {
    cb.addEventListener('change', updateKabidInfo);
});

updateKabidInfo(); // run on load to init existing state
</script>
@endsection
