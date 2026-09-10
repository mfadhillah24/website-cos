@extends('layouts.admin')

@section('title', 'Program Kerja')
@section('page_title', 'Program Kerja')
@section('breadcrumb', 'Divisi / Program Kerja')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            Program Kerja
            @if($activePeriod)
                <span class="text-sm text-muted" style="font-weight:400;">(Periode: {{ $activePeriod->name }})</span>
            @endif
        </h2>
        @can('manage_programs')
        <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
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
                    <th>Divisi</th>
                    <th>Status</th>
                    <th>PIC</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($programs as $program)
                    <tr>
                        <td>
                            <div class="font-semibold">{{ $program->title }}</div>
                            <div class="text-xs text-muted">{{ Str::limit($program->description, 60, '...') }}</div>
                        </td>
                        <td>
                            <span class="badge badge-gray">{{ $program->division->name ?? '-' }}</span>
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'planning'    => 'badge-gray',
                                    'on_progress' => 'badge-blue',
                                    'completed'   => 'badge-green',
                                    'cancelled'   => 'badge-red',
                                ];
                                $statusLabels = [
                                    'planning'    => 'Perencanaan',
                                    'on_progress' => 'Berjalan',
                                    'completed'   => 'Selesai',
                                    'cancelled'   => 'Dibatalkan',
                                ];
                            @endphp
                            <span class="badge {{ $statusColors[$program->status] ?? 'badge-gray' }}">
                                {{ $statusLabels[$program->status] ?? $program->status }}
                            </span>
                        </td>
                        <td class="text-sm text-muted">{{ $program->pic->name ?? '-' }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.programs.show', $program) }}" class="btn btn-secondary btn-sm">Detail</a>
                                @can('manage_programs')
                                <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.programs.destroy', $program) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus program kerja ini?')">Hapus</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada program kerja.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
