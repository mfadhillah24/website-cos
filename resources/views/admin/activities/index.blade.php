@extends('layouts.admin')

@section('title', 'Kegiatan')
@section('page_title', 'Kegiatan')
@section('breadcrumb', 'Divisi / Kegiatan')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Kegiatan</h2>
        @can('manage_activities')
        <a href="{{ route('admin.activities.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Kegiatan
        </a>
        @endcan
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Kegiatan</th>
                    <th>Waktu & Tempat</th>
                    <th>Divisi & Program</th>
                    <th>Status</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($activities as $activity)
                    <tr>
                        <td>
                            <div class="font-semibold">{{ $activity->title }}</div>
                            <div class="text-xs text-muted">{{ Str::limit($activity->description, 60, '...') }}</div>
                        </td>
                        <td>
                            <div class="text-sm">
                                @if($activity->start_date)
                                    {{ $activity->start_date->format('d M Y') }}
                                    @if($activity->end_date && $activity->end_date != $activity->start_date)
                                        - {{ $activity->end_date->format('d M Y') }}
                                    @endif
                                @else
                                    <span class="text-muted">Waktu TBD</span>
                                @endif
                            </div>
                            <div class="text-xs text-muted">{{ $activity->location ?? '-' }}</div>
                        </td>
                        <td>
                            <div class="text-sm">{{ $activity->division->name ?? 'Lintas Divisi' }}</div>
                            @if($activity->program)
                                <div class="text-xs text-muted">{{ $activity->program->title }}</div>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'draft' => 'badge-gray',
                                    'published' => 'badge-blue',
                                    'completed' => 'badge-green',
                                ];
                                $statusLabels = [
                                    'draft' => 'Draft',
                                    'published' => 'Dipublikasi',
                                    'completed' => 'Selesai',
                                ];
                            @endphp
                            <span class="badge {{ $statusColors[$activity->status] ?? 'badge-gray' }}">
                                {{ $statusLabels[$activity->status] ?? $activity->status }}
                            </span>
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.activities.show', $activity) }}" class="btn btn-secondary btn-sm">Detail</a>
                                @can('manage_activities')
                                <a href="{{ route('admin.activities.edit', $activity) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.activities.destroy', $activity) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus kegiatan ini beserta foto-fotonya?')">Hapus</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada kegiatan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
