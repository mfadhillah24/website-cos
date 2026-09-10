@extends('layouts.admin')

@section('title', 'Dashboard ' . $user->kabidLabel())
@section('page_title', 'Dashboard ' . $user->kabidLabel())
@section('breadcrumb', 'Dashboard')

@section('content')

{{-- Welcome Banner --}}
<div style="background: var(--navy-900);;
    border-radius: 16px; padding: 32px 36px; margin-bottom: 28px; color: white; position:relative; overflow:hidden;">
    <div style="position:absolute;top:-20px;right:-20px;width:180px;height:180px;
        background:rgba(255,255,255,0.05);border-radius:50%;"></div>
    <div style="position:absolute;bottom:-40px;right:60px;width:100px;height:100px;
        background:rgba(33, 21, 195, 0.04);border-radius:50%;"></div>
    <p style="font-size:13px;opacity:.65;margin-bottom:6px;letter-spacing:.5px;text-transform:uppercase;">Selamat Datang</p>
    <h2 style="font-size:26px;font-weight:700;margin-bottom:4px;">{{ $user->name }}</h2>
    <p style="font-size:15px;opacity:.8;margin-bottom:12px;">
        {{ $user->kabidLabel() }} &mdash;
        <strong>{{ $division?->name ?? 'Bidang belum ditentukan' }}</strong>
    </p>
    @if(!$division)
        <div style="background:rgba(234,179,8,.15);border:1px solid rgba(234,179,8,.4);
            border-radius:8px;padding:10px 16px;font-size:13px;color:#fde047;display:inline-block;">
            ⚠️ Bidang Anda belum dikonfigurasi. Hubungi Super Admin untuk mengatur <code>division_id</code> akun Anda.
        </div>
    @endif
</div>

{{-- Stats Row --}}
<div class="stats-grid" style="margin-bottom:28px;">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(59,130,246,.12); color: var(--blue-600);">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $totalPrograms }}</div>
            <div class="stat-label">Program Kerja</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(16,185,129,.12); color: #10b981;">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $totalActivities }}</div>
            <div class="stat-label">Kegiatan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(245,158,11,.12); color: #f59e0b;">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $totalMembers }}</div>
            <div class="stat-label">Anggota Bidang</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(139,92,246,.12); color: #8b5cf6;">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $division?->name ?? '-' }}</div>
            <div class="stat-label">Bidang Saya</div>
        </div>
    </div>
</div>

{{-- Two Column: Program Kerja + Kegiatan Terbaru --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">

    {{-- Program Kerja Terbaru --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Program Kerja Terbaru</h3>
            <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding:0;">
            @forelse($programs as $prog)
            <div style="padding:14px 20px;border-bottom:1px solid var(--border-color);display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <div style="font-weight:600;font-size:14px;color:var(--gray-800);">{{ $prog->name }}</div>
                    <div style="font-size:12px;color:var(--gray-400);">PJ: {{ $prog->pic?->name ?? '-' }}</div>
                </div>
                <span class="badge badge-{{ $prog->status === 'selesai' ? 'green' : ($prog->status === 'berjalan' ? 'blue' : 'gray') }}">
                    {{ ucfirst($prog->status ?? 'draft') }}
                </span>
            </div>
            @empty
            <div style="padding:32px;text-align:center;color:var(--gray-400);">Belum ada program kerja.</div>
            @endforelse
        </div>
        @if($division)
        <div style="padding:16px 20px;">
            <a href="{{ route('admin.programs.create') }}" class="btn btn-primary btn-sm">+ Tambah Program Kerja</a>
        </div>
        @endif
    </div>

    {{-- Kegiatan Terbaru --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Kegiatan Terbaru</h3>
            <a href="{{ route('admin.activities.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding:0;">
            @forelse($activities as $act)
            <div style="padding:14px 20px;border-bottom:1px solid var(--border-color);">
                <div style="font-weight:600;font-size:14px;color:var(--gray-800);">{{ $act->title }}</div>
                <div style="font-size:12px;color:var(--gray-400);">
                    {{ $act->start_date ? $act->start_date->format('d M Y') : '-' }}
                </div>
            </div>
            @empty
            <div style="padding:32px;text-align:center;color:var(--gray-400);">Belum ada kegiatan.</div>
            @endforelse
        </div>
        @if($division)
        <div style="padding:16px 20px;">
            <a href="{{ route('admin.activities.create') }}" class="btn btn-primary btn-sm">+ Tambah Kegiatan</a>
        </div>
        @endif
    </div>

</div>

@endsection
