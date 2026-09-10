@extends('layouts.admin')

@section('title', 'Detail Anggota — ' . $member->name)
@section('page_title', 'Detail Anggota')
@section('breadcrumb', 'Anggota Bidang / Detail')

@section('content')

{{-- Tombol Kembali --}}
<div style="margin-bottom:20px;">
    <a href="{{ route('admin.kabid.members.index') }}" class="btn btn-secondary btn-sm"
        id="kabid-back-to-list"
        style="display:inline-flex;align-items:center;gap:6px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Anggota Bidang
        @if($division)
            <span style="color:var(--gray-400);font-weight:400;">— {{ $division->name }}</span>
        @endif
    </a>
</div>

{{-- Layout 2 Kolom --}}
<div style="max-width:960px;display:grid;grid-template-columns:280px 1fr;gap:24px;align-items:start;">

    {{-- ── Kolom Kiri: Profile Card ── --}}
    <div class="card">
        <div class="card-body" style="text-align:center;padding:32px 20px;">

            {{-- Foto Avatar --}}
            <div style="width:110px;height:110px;border-radius:50%;overflow:hidden;
                margin:0 auto 16px;border:4px solid var(--gray-100);
                box-shadow:0 4px 12px rgba(0,0,0,0.08);">
                @if($member->photo)
                    <img src="{{ asset('images/' . $member->photo) }}" alt="{{ $member->name }}"
                        style="width:100%;height:100%;object-fit:cover;">
                @else
                    <div style="width:100%;height:100%;
                        background:linear-gradient(135deg,var(--navy-800),var(--blue-600));
                        display:flex;align-items:center;justify-content:center;
                        color:white;font-size:36px;font-weight:700;">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            {{-- Nama & Bidang --}}
            <h3 style="color:var(--gray-900);font-size:18px;font-weight:700;margin-bottom:4px;">
                {{ $member->name }}
            </h3>
            <div style="color:var(--gray-500);font-size:13px;margin-bottom:12px;">
                {{ $member->primaryDivision?->division?->name ?? 'Tanpa Bidang COS' }}
            </div>

            {{-- Status Badge --}}
            <div style="margin-bottom:12px;">
                <span class="badge badge-gray" style="padding:4px 14px;font-size:12px;">
                    {{ $member->status?->name ?? '—' }}
                </span>
            </div>

            {{-- Founder Badge --}}
            @if($member->is_founder)
            <div style="margin-bottom:12px;">
                <span class="badge badge-yellow" style="font-size:11px;">🏆 Pendiri (Founder)</span>
            </div>
            @endif

            {{-- NTA --}}
            @if($member->nta)
            <div style="margin-bottom:12px;padding:10px 12px;
                background:var(--gray-50);border:1px solid var(--gray-200);
                border-radius:8px;text-align:left;">
                <div style="font-size:10px;color:var(--gray-500);font-weight:600;
                    text-transform:uppercase;letter-spacing:0.05em;margin-bottom:4px;">
                    Nomor Induk Anggota (NTA)
                </div>
                <div style="font-family:monospace;font-size:12px;font-weight:700;
                    color:var(--navy-800);letter-spacing:0.03em;">
                    {{ $member->nta }}
                </div>
            </div>
            @endif

            {{-- Status Akun User --}}
            <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--border-color);">
                <div style="font-size:11px;color:var(--gray-500);margin-bottom:8px;text-transform:uppercase;
                    font-weight:600;letter-spacing:0.05em;">Status Akun Sistem</div>
                @if($member->user)
                    <span class="badge badge-{{ $member->user->is_active ? 'green' : 'gray' }}"
                        style="font-size:12px;">
                        {{ $member->user->is_active ? '✓ Aktif' : '✗ Nonaktif' }}
                    </span>
                @else
                    <span class="text-xs text-muted">Tidak Tertaut</span>
                @endif
            </div>

            {{-- Info Read-Only --}}
            <div style="margin-top:16px;padding:10px 12px;
                background:rgba(234,179,8,.08);border:1px solid rgba(234,179,8,.3);
                border-radius:8px;font-size:11px;color:#92400e;line-height:1.5;">
                ⓘ Tampilan baca saja. Untuk mengubah data, hubungi Admin atau Ketua Umum.
            </div>

        </div>
    </div>

    {{-- ── Kolom Kanan ── --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Informasi Dasar --}}
        <div class="card" style="margin-bottom:0;">
            <div class="card-header">
                <h3 class="card-title">Informasi Anggota</h3>
            </div>
            <div class="card-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

                    <div>
                        <div style="font-size:11px;color:var(--gray-500);font-weight:600;
                            text-transform:uppercase;letter-spacing:0.05em;margin-bottom:4px;">
                            Tahun Angkatan
                        </div>
                        <div style="font-size:14px;font-weight:500;color:var(--gray-800);">
                            {{ $member->angkatan ?? '—' }}
                        </div>
                    </div>

                    <div>
                        <div style="font-size:11px;color:var(--gray-500);font-weight:600;
                            text-transform:uppercase;letter-spacing:0.05em;margin-bottom:4px;">
                            Angkatan UKM (Generasi)
                        </div>
                        <div style="font-size:14px;font-weight:500;color:var(--gray-800);">
                            {{ $member->generation ? 'Generasi ke-' . $member->generation : '—' }}
                        </div>
                    </div>

                    <div>
                        <div style="font-size:11px;color:var(--gray-500);font-weight:600;
                            text-transform:uppercase;letter-spacing:0.05em;margin-bottom:4px;">
                            Email Kontak
                        </div>
                        <div style="font-size:14px;font-weight:500;color:var(--gray-800);">
                            @if($member->email)
                                <a href="mailto:{{ $member->email }}"
                                    style="color:var(--blue-600);text-decoration:none;">
                                    {{ $member->email }}
                                </a>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div>
                        <div style="font-size:11px;color:var(--gray-500);font-weight:600;
                            text-transform:uppercase;letter-spacing:0.05em;margin-bottom:4px;">
                            Nomor HP
                        </div>
                        <div style="font-size:14px;font-weight:500;color:var(--gray-800);">
                            {{ $member->phone ?? '—' }}
                        </div>
                    </div>

                    <div>
                        <div style="font-size:11px;color:var(--gray-500);font-weight:600;
                            text-transform:uppercase;letter-spacing:0.05em;margin-bottom:4px;">
                            Bidang COS
                        </div>
                        <div style="font-size:14px;font-weight:500;color:var(--gray-800);">
                            {{ $member->primaryDivision?->division?->name ?? '—' }}
                        </div>
                    </div>

                    @if($member->linkedin || $member->github)
                    <div>
                        <div style="font-size:11px;color:var(--gray-500);font-weight:600;
                            text-transform:uppercase;letter-spacing:0.05em;margin-bottom:4px;">
                            Profil Publik
                        </div>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;">
                            @if($member->linkedin)
                                <a href="{{ $member->linkedin }}" target="_blank" rel="noopener"
                                    style="font-size:12px;color:var(--blue-600);text-decoration:none;">
                                    LinkedIn ↗
                                </a>
                            @endif
                            @if($member->github)
                                <a href="{{ $member->github }}" target="_blank" rel="noopener"
                                    style="font-size:12px;color:var(--gray-700);text-decoration:none;">
                                    GitHub ↗
                                </a>
                            @endif
                        </div>
                    </div>
                    @endif

                </div>

                {{-- Bio --}}
                <div style="margin-top:20px;">
                    <div style="font-size:11px;color:var(--gray-500);font-weight:600;
                        text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">
                        Biografi Singkat
                    </div>
                    <div style="font-size:14px;line-height:1.7;background:var(--gray-50);
                        padding:16px;border-radius:10px;border:1px solid var(--border-color);
                        color:var(--gray-700);">
                        {{ $member->bio ?: 'Belum ada biografi.' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Riwayat Status Keanggotaan --}}
        <div class="card" style="margin-bottom:0;">
            <div class="card-header">
                <h3 class="card-title">Riwayat Status Keanggotaan</h3>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Status Baru</th>
                            <th>Diubah Oleh</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($member->statusHistories as $history)
                        <tr>
                            <td class="text-muted" style="font-size:13px;">
                                {{ $history->created_at->format('d M Y, H:i') }}
                            </td>
                            <td>
                                <span class="badge badge-gray">
                                    {{ $history->toStatus?->name ?? '—' }}
                                </span>
                            </td>
                            <td class="text-muted" style="font-size:13px;">
                                {{ $history->changer?->name ?? 'Sistem' }}
                            </td>
                            <td class="text-muted" style="font-size:13px;">
                                {{ $history->notes ?? '—' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-muted" style="text-align:center;padding:24px;">
                                Belum ada riwayat perubahan status.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection
