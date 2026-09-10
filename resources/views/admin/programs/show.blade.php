@extends('layouts.admin')

@section('title', $program->title . ' — Detail Program')
@section('page_title', 'Detail Program Kerja')
@section('breadcrumb', 'Divisi / Program Kerja / ' . $program->title)

@section('content')
<div style="max-width: 680px;">
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">{{ $program->title }}</h2>
                <div class="text-xs text-muted">{{ $program->division->name }} · {{ $program->period->name ?? '-' }}</div>
            </div>
            <div class="flex gap-2">
                @can('manage_programs')
                <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-secondary btn-sm">Edit</a>
                @endcan
                <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
        <div class="card-body" style="display:flex; flex-direction:column; gap:20px;">

            {{-- Status --}}
            @php
                $statusColors = ['planning'=>'badge-gray','on_progress'=>'badge-blue','completed'=>'badge-green','cancelled'=>'badge-red'];
                $statusLabels = ['planning'=>'Perencanaan','on_progress'=>'Sedang Berjalan','completed'=>'Selesai','cancelled'=>'Dibatalkan'];
            @endphp
            <div>
                <div class="text-xs text-muted" style="margin-bottom:4px;">Status</div>
                <span class="badge {{ $statusColors[$program->status] ?? 'badge-gray' }}">
                    {{ $statusLabels[$program->status] ?? $program->status }}
                </span>
            </div>

            {{-- Description --}}
            @if($program->description)
            <div>
                <div class="text-xs text-muted" style="margin-bottom:4px;">Deskripsi</div>
                <p class="text-sm">{{ $program->description }}</p>
            </div>
            @endif

            {{-- Target --}}
            @if($program->target)
            <div>
                <div class="text-xs text-muted" style="margin-bottom:4px;">Target / Output</div>
                <p class="text-sm">{{ $program->target }}</p>
            </div>
            @endif

            {{-- PIC --}}
            <div>
                <div class="text-xs text-muted" style="margin-bottom:4px;">PIC (Penanggung Jawab)</div>
                <p class="text-sm font-semibold">{{ $program->pic->name ?? '-' }}</p>
            </div>

            {{-- Created by --}}
            <div>
                <div class="text-xs text-muted" style="margin-bottom:4px;">Dibuat oleh</div>
                <p class="text-sm">{{ $program->creator->name ?? '-' }} · {{ $program->created_at->format('d M Y') }}</p>
            </div>

        </div>
    </div>
</div>
@endsection
