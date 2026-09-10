@extends('layouts.admin')

@section('title', 'Detail Pendaftaran')
@section('page_title', 'Detail Pendaftar')
@section('breadcrumb', 'Layanan Publik / Pendaftaran / Detail')

@section('content')
<div style="max-width: 800px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Formulir: {{ $registration->name }}</h2>
            <div class="flex gap-2">
                @can('manage_registration')
                <form method="POST" action="{{ route('admin.registrations.destroy', $registration) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pendaftar ini?')">Hapus</button>
                </form>
                @endcan
                <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <div style="width: 100%;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                        <div>
                            <div class="text-xs text-muted" style="margin-bottom:4px;">Nama Lengkap</div>
                            <div class="font-semibold">{{ $registration->name }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-muted" style="margin-bottom:4px;">NIM</div>
                            <div class="font-semibold">{{ $registration->nim }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-muted" style="margin-bottom:4px;">Program Studi</div>
                            <div>{{ $registration->study_program }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-muted" style="margin-bottom:4px;">Angkatan</div>
                            <div>{{ $registration->batch_year }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-muted" style="margin-bottom:4px;">Email</div>
                            <div><a href="mailto:{{ $registration->email }}">{{ $registration->email }}</a></div>
                        </div>
                        <div>
                            <div class="text-xs text-muted" style="margin-bottom:4px;">Nomor HP / WhatsApp</div>
                            <div><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $registration->phone) }}">{{ $registration->phone }}</a></div>
                        </div>
                        <div>
                            <div class="text-xs text-muted" style="margin-bottom:4px;">Tempat, Tanggal Lahir</div>
                            <div>{{ $registration->birth_place ?? '-' }}, {{ $registration->birth_date ? $registration->birth_date->format('d M Y') : '-' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-muted" style="margin-bottom:4px;">Divisi Pilihan</div>
                            <div><span class="badge badge-blue">{{ $registration->division->name ?? '-' }}</span></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <div class="text-xs text-muted" style="margin-bottom:4px;">Alamat</div>
                        <div>{{ $registration->address ?? '-' }}</div>
                    </div>

                    <div>
                        <div class="text-xs text-muted" style="margin-bottom:4px;">Alasan Bergabung</div>
                        <div style="padding: 12px; background: var(--bg-color); border-radius: 8px; font-style: italic;">
                            {{ $registration->reason }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
