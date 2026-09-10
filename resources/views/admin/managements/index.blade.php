@extends('layouts.admin')

@section('title', 'Struktur Kepengurusan')
@section('page_title', 'Struktur Kepengurusan')
@section('breadcrumb', 'Kepengurusan / Struktur Pengurus')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <h2 class="card-title" style="margin: 0;">Pengurus {{ $activePeriod && $activePeriod->is_active ? 'Aktif' : '' }} (Periode: {{ $activePeriod->name ?? 'Belum ada periode' }})</h2>
        
        <div style="display: flex; align-items: center; gap: 1rem;">
            @if(isset($periods) && $periods->count() > 0)
                <select onchange="window.location.href = '{{ route('admin.managements.index') }}?period_id=' + this.value" 
                        class="form-control" 
                        style="width: auto; min-width: 180px; padding: 0.375rem 0.75rem; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    <option value="">-- Pilih Periode --</option>
                    @foreach($periods as $p)
                        <option value="{{ $p->id }}" {{ $activePeriod && $activePeriod->id == $p->id ? 'selected' : '' }}>
                            {{ $p->name }}{{ $p->is_active ? ' (Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
            @endif

            @can('manage_management')
                @if($activePeriod)
                <a href="{{ route('admin.managements.create') }}" class="btn btn-primary">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Pengurus
                </a>
                @else
                <span class="text-muted text-sm">Buat periode terlebih dahulu.</span>
                @endif
            @endcan
        </div>
    </div>
    
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Anggota</th>
                    <th>Jabatan</th>
                    <th>Mulai Menjabat</th>
                    <th>Status Akun</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($managements as $management)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div style="width:36px; height:36px; border-radius:18px; background:var(--gray-100); display:flex; align-items:center; justify-content:center; color:var(--gray-600); font-weight:600; font-size:12px;">
                                    {{ strtoupper(substr($management->member->name, 0, 2)) }}
                                </div>
                                <div class="flex-col">
                                    <div class="font-semibold">{{ $management->member->name }}</div>
                                    <div class="text-xs text-muted">{{ $management->member->nim ?? '-' }}</div>
                                    @if($management->member->email)
                                        <div class="text-xs text-muted mt-1" style="color:var(--blue-600);"><x-lucide-mail class="w-5 h-5" /> {{ $management->member->email }}</div>
                                    @else
                                        <div class="text-xs text-muted mt-1"><x-lucide-mail class="w-5 h-5" /> <em>Tidak ada email</em></div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="font-semibold">{{ $management->position->name }}</div>
                            @if($management->notes)
                            <div class="text-xs text-muted">{{ $management->notes }}</div>
                            @endif
                        </td>
                        <td class="text-muted text-sm">{{ $management->started_at->format('d M Y') }}</td>
                        <td>
                            @if($management->user_id)
                                <span class="badge badge-blue">Terhubung</span>
                            @else
                                <span class="badge badge-gray">Belum Terhubung</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.managements.edit', $management) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.managements.destroy', $management) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus pengurus ini dari jabatan tersebut?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada pengurus di periode aktif ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
