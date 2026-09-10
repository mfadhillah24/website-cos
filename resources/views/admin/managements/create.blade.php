@extends('layouts.admin')

@section('title', 'Tambah Pengurus')
@section('page_title', 'Tambah Pengurus')
@section('breadcrumb', 'Kepengurusan / Struktur Pengurus / Tambah')

@section('content')
<div style="max-width: 680px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Assign Jabatan Baru</h2>
            <a href="{{ route('admin.managements.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.managements.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="member_id">Anggota <span style="color:#EF4444;">*</span></label>
                    <select id="member_id" name="member_id" class="form-control {{ $errors->has('member_id') ? 'is-invalid' : '' }}" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
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
                                <option value="{{ $period->id }}" {{ old('period_id', $periods->where('is_active', true)->first()->id ?? '') == $period->id ? 'selected' : '' }}>
                                    {{ $period->name }} {{ $period->is_active ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('period_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="position_id">Jabatan <span style="color:#EF4444;">*</span></label>
                        <select id="position_id" name="position_id" class="form-control {{ $errors->has('position_id') ? 'is-invalid' : '' }}" required>
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('position_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="started_at">Tanggal Mulai <span style="color:#EF4444;">*</span></label>
                    <input id="started_at" type="date" name="started_at" value="{{ old('started_at', now()->format('Y-m-d')) }}"
                        class="form-control {{ $errors->has('started_at') ? 'is-invalid' : '' }}" required>
                    @error('started_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group" style="padding: 16px; background: var(--gray-50); border: 1px solid var(--gray-200); border-radius: 8px; margin-bottom: 20px;">
                    <label class="form-label" for="email">Email Kontak Pengurus (Opsional)</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="contoh@gmail.com">
                    <div class="form-text">Mengisi ini akan otomatis mengupdate data Email Kontak di profil anggota tersebut. Kosongkan jika sudah ada atau tidak ingin diubah.</div>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="notes">Catatan Tambahan (Opsional)</label>
                    <textarea id="notes" name="notes" rows="2"
                        class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}">{{ old('notes') }}</textarea>
                    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-3" style="margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Simpan Pengurus</button>
                    <a href="{{ route('admin.managements.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
