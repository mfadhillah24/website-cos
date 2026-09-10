@extends('layouts.admin')

@section('title', 'Tambah Role')
@section('page_title', 'Tambah Role')
@section('breadcrumb', 'Role / Tambah Baru')

@section('content')
<div style="max-width: 760px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Role Baru</h2>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Nama Role <span class="text-sm" style="color: #EF4444;">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        placeholder="Contoh: Editor" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group" style="margin-top: 32px;">
                    <label class="form-label">Permissions</label>
                    @foreach ($permissions as $group => $groupPerms)
                        <div style="margin-bottom: 24px; padding: 16px; background: var(--gray-50); border: 1px solid var(--border-color); border-radius: 8px;">
                            <div class="font-semibold text-sm" style="color: var(--navy-700); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">
                                {{ ucfirst($group) }}
                            </div>
                            <div class="flex" style="flex-wrap: wrap; gap: 10px;">
                                @foreach ($groupPerms as $perm)
                                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;
                                        padding: 8px 12px;
                                        background: var(--white);
                                        border: 1px solid var(--gray-200);
                                        border-radius: 6px; font-size:13px; color: var(--gray-800); transition: all 0.2s;">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                            {{ in_array($perm->name, old('permissions', [])) ? 'checked' : '' }}
                                            style="accent-color: var(--blue-600); width: 14px; height: 14px;" class="perm-checkbox">
                                        {{ $perm->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex gap-3" style="margin-top: 32px;">
                    <button type="submit" class="btn btn-primary">Simpan Role</button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.perm-checkbox').forEach(checkbox => {
        // Initial state
        if(checkbox.checked) {
            checkbox.parentElement.style.borderColor = 'var(--blue-600)';
            checkbox.parentElement.style.background = '#EFF6FF';
        }
        
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
