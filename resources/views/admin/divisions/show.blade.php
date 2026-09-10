@extends('layouts.admin')

@section('title', $division->name . ' — Detail Divisi')
@section('page_title', 'Detail Divisi')
@section('breadcrumb', 'Divisi / ' . $division->name)

@section('content')
<div class="flex gap-4" style="flex-direction: column;">

    {{-- Division Info Card --}}
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">{{ $division->name }}</h2>
                <div class="text-xs text-muted">Slug: {{ $division->slug }}</div>
            </div>
            <div class="flex gap-2">
                @can('manage_division')
                <a href="{{ route('admin.divisions.edit', $division) }}" class="btn btn-secondary btn-sm">Edit Divisi</a>
                @endcan
                <a href="{{ route('admin.divisions.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <p class="text-sm text-muted">{{ $division->description ?? 'Belum ada deskripsi.' }}</p>
            <div style="margin-top:12px;">
                @if($division->is_active)
                    <span class="badge badge-green">Aktif</span>
                @else
                    <span class="badge badge-gray">Nonaktif</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Programs --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Program Kerja Divisi Ini</h2>
            @can('manage_programs')
            <a href="{{ route('admin.programs.create') }}?division_id={{ $division->id }}" class="btn btn-primary btn-sm">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Program
            </a>
            @endcan
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Program Kerja</th>
                        <th>Status</th>
                        <th>PIC</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($division->programs as $program)
                        <tr>
                            <td>
                                <div class="font-semibold">{{ $program->title }}</div>
                                <div class="text-xs text-muted">{{ Str::limit($program->description, 60) }}</div>
                            </td>
                            <td>
                                @php $statusColors = ['planning'=>'badge-gray','on_progress'=>'badge-blue','completed'=>'badge-green','cancelled'=>'badge-red']; @endphp
                                <span class="badge {{ $statusColors[$program->status] ?? 'badge-gray' }}">{{ ucfirst(str_replace('_', ' ', $program->status)) }}</span>
                            </td>
                            <td class="text-sm text-muted">{{ $program->pic->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-muted" style="text-align:center; padding:24px;">Belum ada program kerja.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Members --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Anggota Divisi</h2>
            <div class="text-xs text-muted">Periode Aktif: {{ $activePeriod ? $activePeriod->name : 'Tidak ada' }}</div>
        </div>
        
        @if($activePeriod)
        <div class="card-body border-b border-gray-200 bg-gray-50">
            <form action="{{ route('admin.divisions.members.store', $division) }}" method="POST" class="flex gap-4 items-end">
                @csrf
                <div class="flex-1">
                    <label class="form-label" for="member_id">Pilih Anggota Tetap</label>
                    <select name="member_id" id="member_id" class="form-control" required>
                        <option value="">-- Pilih Anggota Tetap --</option>
                        @foreach($availableMembers as $member)
                            <option value="{{ $member->id }}">{{ $member->name }} {!! $member->nta ? '('.$member->nta.')' : '' !!}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="role_in_division">Peran (Opsional)</label>
                    <input type="text" name="role_in_division" id="role_in_division" class="form-control" placeholder="Contoh: Staff Khusus">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" {{ $availableMembers->isEmpty() ? 'disabled' : '' }}>
                        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah
                    </button>
                </div>
            </form>
            @if($availableMembers->isEmpty())
                <div class="text-xs text-muted mt-2 text-red-500">Semua Anggota Tetap sudah masuk ke divisi ini, atau belum ada data Anggota Tetap di sistem.</div>
            @endif
        </div>
        @endif

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama Anggota</th>
                        <th>Peran</th>
                        <th>Mulai Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($division->divisionMembers as $dm)
                        <tr>
                            <td>
                                <div class="font-semibold">{{ $dm->member->name }}</div>
                                <div class="text-xs text-muted">{{ $dm->period->name ?? '-' }}</div>
                            </td>
                            <td>
                                <span class="badge {{ $dm->role_in_division === 'kabid' ? 'badge-blue' : 'badge-gray' }}">
                                    {{ ucfirst($dm->role_in_division) }}
                                </span>
                            </td>
                            <td class="text-sm text-muted">{{ $dm->joined_at?->format('d M Y') ?? '-' }}</td>
                            <td>
                                <form action="{{ route('admin.divisions.members.destroy', [$division, $dm->id]) }}" method="POST" onsubmit="return confirm('Hapus anggota ini dari divisi?');" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Anggota">
                                        <x-lucide-trash-2 class="w-5 h-5" />
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-muted" style="text-align:center; padding:24px;">Belum ada anggota yang ditetapkan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
