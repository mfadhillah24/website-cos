@extends('layouts.admin')

@section('title', $activity->title)
@section('page_title', 'Detail Kegiatan')
@section('breadcrumb', 'Divisi / Kegiatan / ' . $activity->title)

@section('content')
<div class="flex gap-4" style="flex-direction: column;">
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">{{ $activity->title }}</h2>
                <div class="text-xs text-muted">
                    {{ $activity->start_date ? $activity->start_date->format('d M Y') : 'Waktu TBD' }} 
                    @if($activity->location) · {{ $activity->location }} @endif
                </div>
            </div>
            <div class="flex gap-2">
                @can('manage_activities')
                <a href="{{ route('admin.activities.edit', $activity) }}" class="btn btn-secondary btn-sm">Edit</a>
                @endcan
                <a href="{{ route('admin.activities.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
        <div class="card-body" style="display:flex; gap: 24px;">
            @if($activity->thumbnail)
                <div style="flex: 0 0 300px;">
                    <img src="{{ asset('images/' . $activity->thumbnail) }}" alt="Thumbnail" style="width: 100%; border-radius: 8px;">
                </div>
            @endif
            <div style="flex: 1; display:flex; flex-direction:column; gap:16px;">
                <div>
                    <span class="badge badge-blue">{{ $activity->division->name ?? 'Lintas Divisi' }}</span>
                    @if($activity->program)
                        <span class="badge badge-gray">{{ $activity->program->title }}</span>
                    @endif
                </div>

                <div>
                    <div class="font-semibold" style="margin-bottom:8px;">Deskripsi Singkat</div>
                    <p class="text-sm">{{ $activity->description ?? '-' }}</p>
                </div>

                <div>
                    <div class="font-semibold" style="margin-bottom:8px;">Detail Kegiatan</div>
                    <div class="text-sm" style="white-space: pre-wrap;">{{ $activity->content ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    @if($activity->photos->count() > 0)
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Galeri Dokumentasi</h2>
        </div>
        <div class="card-body">
            <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
                @foreach($activity->photos as $photo)
                    <div style="border-radius:8px; overflow:hidden; border:1px solid var(--border-color);">
                        <img src="{{ asset('images/' . $photo->path) }}" style="width: 100%; aspect-ratio:4/3; object-fit:cover; display:block;">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
