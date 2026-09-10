@extends('layouts.admin')

@section('title', 'Detail Anggota')
@section('page_title', 'Detail Anggota')
@section('breadcrumb', 'Anggota / Detail')

@section('content')
<div style="max-width: 900px; display:grid; grid-template-columns:300px 1fr; gap:24px; align-items:start;">

    <!-- Left Column: Profile Card -->
    <div class="card">
        <div class="card-body" style="text-align:center; padding:32px 20px;">
            <div style="width:120px; height:120px; border-radius:60px; overflow:hidden; margin:0 auto 16px; border:4px solid var(--gray-50); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                @if($member->photo)
                    <img src="{{ asset('images/' . $member->photo) }}" alt="{{ $member->name }}" style="width:100%; height:100%; object-fit:cover;">
                @else
                    <div style="width:100%; height:100%; background:var(--gray-100); display:flex; align-items:center; justify-content:center; color:var(--gray-500); font-size:32px; font-weight:600;">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <h3 style="color:var(--gray-900); font-size:20px; font-weight: 600; margin-bottom:4px;">{{ $member->name }}</h3>
            <div style="color:var(--gray-500); font-size:14px; margin-bottom:12px;">{{ $member->primaryDivision->division->name ?? 'Tanpa Bidang COS' }}</div>

            <div style="margin-bottom:16px;">
                <span class="badge badge-gray" style="padding:4px 12px; font-size: 12px;">{{ $member->status->name }}</span>
            </div>
            
            @if($member->is_founder)
                <div style="margin-bottom:16px;">
                    <span class="badge badge-yellow" style="font-size:11px;">🏆 Pendiri (Founder)</span>
                </div>
            @endif

            @if($member->nta)
                <div style="margin-bottom:16px; padding: 10px 12px; background: var(--gray-50); border: 1px solid var(--gray-200); border-radius: 8px; text-align:left;">
                    <div style="font-size:10px; color:var(--gray-500); font-weight:600; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:4px;">Nomor Induk Anggota</div>
                    <div style="font-family: monospace; font-size: 12px; font-weight: 700; color: var(--navy-800);">{{ $member->nta }}</div>
                </div>
            @endif

            <div class="flex-col gap-2" style="margin-top:24px; padding-top:24px; border-top:1px solid var(--border-color);">
                <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-primary w-full" style="width: 100%;">Edit Data</a>
                <form method="POST" action="{{ route('admin.members.destroy', $member) }}" style="width: 100%;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger w-full" style="width: 100%;" onclick="return confirm('Hapus anggota {{ $member->name }}?')">Hapus Anggota</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Info & History -->
    <div class="flex-col gap-6">
        
        <!-- Biodata -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <h3 class="card-title">Informasi Dasar</h3>
            </div>
            <div class="card-body">
                <div class="grid-2" style="margin-bottom:24px;">
                    <div>
                        <div class="text-xs text-muted" style="margin-bottom:4px;">Tahun Angkatan</div>
                        <div class="font-medium text-sm">{{ $member->angkatan ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted" style="margin-bottom:4px;">Angkatan UKM (Generasi)</div>
                        <div class="font-medium text-sm">{{ $member->generation ? 'Generasi ke-' . $member->generation : '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted" style="margin-bottom:4px;">Email Kontak</div>
                        <div class="font-medium text-sm">{{ $member->email ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted" style="margin-bottom:4px;">Nomor HP</div>
                        <div class="font-medium text-sm">{{ $member->phone ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted" style="margin-bottom:4px;">Akun Login Sistem</div>
                        <div class="font-medium text-sm">
                            @if($member->user)
                                <span style="color:var(--blue-600);">{{ $member->user->email }}</span>
                            @else
                                <span class="text-muted">Tidak tertaut</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <div class="text-xs text-muted" style="margin-bottom:8px;">Biografi Singkat</div>
                    <div style="line-height:1.6; font-size:14px; background:var(--gray-50); padding:16px; border-radius:10px; border:1px solid var(--border-color);">
                        {{ $member->bio ?: 'Belum ada biografi.' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Histori Status -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <h3 class="card-title">Riwayat Perubahan Status</h3>
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
                        @forelse ($member->statusHistories as $history)
                            <tr>
                                <td class="text-muted" style="font-size:13px;">{{ $history->created_at->format('d M Y, H:i') }}</td>
                                <td><span class="badge badge-gray">{{ $history->toStatus->name }}</span></td>
                                <td class="text-muted" style="font-size:13px;">{{ $history->changer->name ?? 'Sistem' }}</td>
                                <td class="text-muted" style="font-size:13px;">{{ $history->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-muted" style="text-align:center; padding:20px;">Belum ada riwayat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
