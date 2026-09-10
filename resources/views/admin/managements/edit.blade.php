@extends('layouts.admin')

@section('title', 'Edit Pengurus')
@section('page_title', 'Edit Pengurus')
@section('breadcrumb', 'Kepengurusan / Struktur Pengurus / Edit')

@section('content')
<div style="max-width: 680px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Edit Jabatan Anggota</h2>
            <a href="{{ route('admin.managements.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            @if(!$management->is_active)
                <div class="alert alert-error" style="margin-bottom: 24px;">
                    <x-lucide-circle class="w-5 h-5" />
                    Data kepengurusan ini sudah tidak aktif (demisioner).
                </div>
            @endif

            <form method="POST" action="{{ route('admin.managements.update', $management) }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="member_id">Anggota <span style="color:#EF4444;">*</span></label>
                    <select id="member_id" name="member_id" class="form-control {{ $errors->has('member_id') ? 'is-invalid' : '' }}" required>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id', $management->member_id) == $member->id ? 'selected' : '' }}>
                                {{ $member->name }} {{ $member->nta ? '(' . $member->nta . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('member_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="period_id">Periode <span style="color:#EF4444;">*</span></label>
                        <select id="period_id" name="period_id" class="form-control {{ $errors->has('period_id') ? 'is-invalid' : '' }}" required>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}" {{ old('period_id', $management->period_id) == $period->id ? 'selected' : '' }}>
                                    {{ $period->name }} {{ $period->is_active ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('period_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="position_id">Jabatan <span style="color:#EF4444;">*</span></label>
                        <select id="position_id" name="position_id" class="form-control {{ $errors->has('position_id') ? 'is-invalid' : '' }}" required>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ old('position_id', $management->position_id) == $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('position_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="started_at">Tanggal Mulai <span style="color:#EF4444;">*</span></label>
                    <input id="started_at" type="date" name="started_at" value="{{ old('started_at', $management->started_at->format('Y-m-d')) }}"
                        class="form-control {{ $errors->has('started_at') ? 'is-invalid' : '' }}" required>
                    @error('started_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group" style="padding: 16px; background: var(--gray-50); border: 1px solid var(--gray-200); border-radius: 8px; margin-bottom: 20px;">
                    <label class="form-label" for="email">Email Kontak Pengurus (Opsional)</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $management->member->email) }}"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="contoh@gmail.com">
                    <div class="form-text">Bisa mengubah alamat email anggota dari sini. Memperbarui email ini akan otomatis mengubah data kontak di profilnya.</div>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="notes">Catatan Tambahan (Opsional)</label>
                    <textarea id="notes" name="notes" rows="2"
                        class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}">{{ old('notes', $management->notes) }}</textarea>
                    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.managements.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
