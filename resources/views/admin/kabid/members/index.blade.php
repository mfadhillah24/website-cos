@extends('layouts.admin')

@section('title', 'Anggota Bidang' . ($division ? ' — ' . $division->name : ''))
@section('page_title', 'Anggota Bidang')
@section('breadcrumb', 'Anggota Bidang')

@section('content')

{{-- ── Header Card ── --}}
<div style="background: linear-gradient(135deg, var(--navy-900) 0%, var(--navy-700) 100%);
    border-radius: 16px; padding: 28px 32px; margin-bottom: 24px; color: white;
    position: relative; overflow: hidden;">
    <div style="position:absolute;top:-30px;right:-30px;width:200px;height:200px;
        background:rgba(255,255,255,0.04);border-radius:50%;"></div>
    <div style="position:absolute;bottom:-50px;right:80px;width:120px;height:120px;
        background:rgba(255,255,255,0.03);border-radius:50%;"></div>

    <div style="position:relative;">
        <p style="font-size:12px;opacity:.6;margin-bottom:6px;letter-spacing:.8px;text-transform:uppercase;font-weight:600;">
            Modul KABID
        </p>
        <h2 style="font-size:24px;font-weight:700;margin-bottom:4px;">Anggota Bidang</h2>
        @if($division ?? false)
            <p style="font-size:15px;opacity:.85;margin-bottom:0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" style="vertical-align:middle;margin-right:5px;stroke-width:2;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Bidang <strong>{{ $division->name }}</strong>
            </p>
        @endif
    </div>
</div>

{{-- ── Kondisi: Bidang Belum Dikonfigurasi ── --}}
@if(isset($noDivision) && $noDivision)
<div class="card">
    <div class="card-body" style="padding:60px 32px;text-align:center;">
        <div style="width:72px;height:72px;border-radius:50%;background:rgba(234,179,8,.1);
            border:2px dashed rgba(234,179,8,.4);display:flex;align-items:center;justify-content:center;
            margin:0 auto 20px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24"
                stroke="#f59e0b" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h3 style="font-size:18px;font-weight:700;color:var(--gray-800);margin-bottom:8px;">
            Bidang Belum Dikonfigurasi
        </h3>
        <p style="color:var(--gray-500);font-size:14px;max-width:400px;margin:0 auto;">
            Belum ada bidang yang ditugaskan kepada Anda. Hubungi Super Admin untuk mengatur bidang pada akun Anda.
        </p>
    </div>
</div>

{{-- ── Konten Normal: Ada Division ── --}}
@else
<div class="card">

    {{-- Search Bar --}}
    <div class="card-header" style="flex-wrap:wrap;gap:12px;">
        <div>
            <h3 class="card-title">
                Daftar Anggota
                @if($division)
                    <span style="font-weight:400;color:var(--gray-500);font-size:13px;">— {{ $division->name }}</span>
                @endif
            </h3>
        </div>
        <form method="GET" style="display:flex;align-items:center;gap:8px;">
            <div style="position:relative;">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);
                    stroke-width:2;color:var(--gray-400);pointer-events:none;">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" value="{{ $search ?? '' }}"
                    placeholder="Cari nama / email / NTA..."
                    class="form-control"
                    style="padding-left:32px;width:240px;"
                    id="kabid-member-search">
            </div>
            <button type="submit" class="btn btn-secondary">Cari</button>
            @if($search ?? false)
                <a href="{{ route('admin.kabid.members.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>
    </div>

    {{-- Tabel Anggota --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama &amp; Bidang COS</th>
                    <th>NTA</th>
                    <th>Status Keanggotaan</th>
                    <th>Kontak</th>
                    <th>Status Akun</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                <tr>
                    {{-- Nama --}}
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            {{-- Avatar --}}
                            <div style="width:38px;height:38px;border-radius:50%;overflow:hidden;flex-shrink:0;
                                border:2px solid var(--gray-200);">
                                @if($member->photo)
                                    <img src="{{ asset('images/' . $member->photo) }}" alt="{{ $member->name }}"
                                        style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <div style="width:100%;height:100%;background:linear-gradient(135deg,var(--navy-800),var(--blue-600));
                                        display:flex;align-items:center;justify-content:center;
                                        color:white;font-size:14px;font-weight:700;">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <div class="font-semibold" style="font-size:14px;">{{ $member->name }}</div>
                                <div class="text-xs text-muted" style="margin-top:2px;">
                                    {{ $member->primaryDivision?->division?->name ?? 'Tanpa Bidang COS' }}
                                    @if($member->generation)
                                        &nbsp;·&nbsp;Generasi ke-{{ $member->generation }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- NTA --}}
                    <td>
                        @if($member->nta)
                            <span style="font-family:monospace;font-size:11px;font-weight:600;
                                color:var(--navy-800);background:var(--gray-50);
                                border:1px solid var(--gray-200);padding:3px 7px;
                                border-radius:6px;display:inline-block;">
                                {{ $member->nta }}
                            </span>
                        @else
                            <span class="text-xs text-muted">—</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td>
                        <span class="badge badge-gray">{{ $member->status?->name ?? '—' }}</span>
                    </td>

                    {{-- Kontak --}}
                    <td class="text-xs text-muted">
                        <div>{{ $member->email ?? '—' }}</div>
                        <div class="mt-1">{{ $member->phone ?? '—' }}</div>
                    </td>

                    {{-- Status Akun --}}
                    <td>
                        @if($member->user)
                            <span class="badge badge-{{ $member->user->is_active ? 'green' : 'gray' }}">
                                {{ $member->user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        @else
                            <span class="text-xs text-muted">Tidak Terkait</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.kabid.members.show', $member) }}"
                                class="btn btn-secondary btn-sm"
                                id="kabid-member-detail-{{ $member->id }}">
                                Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:60px 32px;">
                        <div style="display:flex;flex-direction:column;align-items:center;gap:12px;">
                            <div style="width:60px;height:60px;border-radius:50%;background:var(--gray-100);
                                display:flex;align-items:center;justify-content:center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"
                                    viewBox="0 0 24 24" stroke="var(--gray-400)" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            @if($search ?? false)
                                <p style="color:var(--gray-500);font-size:14px;margin:0;">
                                    Tidak ada anggota yang cocok dengan pencarian "<strong>{{ $search }}</strong>".
                                </p>
                                <a href="{{ route('admin.kabid.members.index') }}" class="btn btn-secondary btn-sm">
                                    Tampilkan Semua
                                </a>
                            @else
                                <p style="color:var(--gray-500);font-size:14px;margin:0;">
                                    Belum ada anggota pada bidang ini.
                                </p>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(isset($members) && $members instanceof \Illuminate\Pagination\LengthAwarePaginator && $members->hasPages())
    <div class="card-footer">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
            <div class="text-xs text-muted">
                Menampilkan {{ $members->firstItem() }}–{{ $members->lastItem() }} dari {{ $members->total() }} anggota
            </div>
            <div class="pagination">{{ $members->links('pagination::simple-bootstrap-4') }}</div>
        </div>
    </div>
    @endif

</div>
@endif

@endsection
