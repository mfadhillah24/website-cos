@extends('layouts.admin')

@section('title', 'Edit Role')
@section('page_title', 'Edit Role')
@section('breadcrumb', 'Role / Edit')

@section('content')
<div style="max-width: 760px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Edit: {{ $role->name }}</h2>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            @if($role->name === 'Super Admin')
                <div class="alert alert-success" style="background:#EFF6FF; border:1px solid #BFDBFE; color:var(--blue-700);">
                    <x-lucide-circle class="w-5 h-5" />
                    Role <strong>Super Admin</strong> otomatis mendapatkan semua permission dan tidak dapat diubah namanya.
                </div>
            @endif

            <form method="POST" action="{{ route('admin.roles.update', $role) }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="name">Nama Role <span class="text-sm" style="color: #EF4444;">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name', $role->name) }}"
                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        {{ $role->name === 'Super Admin' ? 'disabled' : '' }} required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group" style="margin-top: 32px;">
                    <label class="form-label">Permissions</label>
                    @php $selected = old('permissions', $rolePermissions); @endphp
                    @foreach ($permissions as $group => $groupPerms)
                        <div style="margin-bottom: 24px; padding: 16px; background: var(--gray-50); border: 1px solid var(--border-color); border-radius: 8px;">
                            <div class="font-semibold text-sm" style="color: var(--navy-700); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">
                                {{ ucfirst($group) }}
                            </div>
                            <div class="flex" style="flex-wrap: wrap; gap: 10px;">
                                @foreach ($groupPerms as $perm)
                                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;
                                        padding: 8px 12px;
                                        background: {{ in_array($perm->name, $selected) ? '#EFF6FF' : 'var(--white)' }};
                                        border: 1px solid {{ in_array($perm->name, $selected) ? 'var(--blue-600)' : 'var(--gray-200)' }};
                                        border-radius: 6px; font-size:13px; color: var(--gray-800); transition: all 0.2s;">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                            {{ in_array($perm->name, $selected) ? 'checked' : '' }}
                                            {{ $role->name === 'Super Admin' ? 'disabled checked' : '' }}
                                            style="accent-color: var(--blue-600); width: 14px; height: 14px;" class="perm-checkbox">
                                        {{ $perm->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex gap-3" style="margin-top: 32px;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.perm-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if(this.checked) {
                this.parentElement.style.borderColor = 'var(--blue-600)';
                this.parentElement.style.background = '#EFF6FF';
            } else {
                this.parentElement.style.borderColor = 'var(--gray-200)';
                this.parentElement.style.background = 'var(--white)';
            }
        });
    });
</script>
@endsection
