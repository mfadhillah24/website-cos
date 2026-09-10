@extends('layouts.admin')

@section('title', $divisionReport->title)
@section('page_title', 'Detail Rekap Laporan')
@section('breadcrumb', 'Laporan Organisasi / Rekap Laporan / Detail')

@section('content')
<div style="max-width: 900px; display: flex; flex-direction: column; gap: 24px;">

    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">{{ $divisionReport->title }}</h2>
                <div class="text-xs text-muted" style="margin-top:4px;">
                    {{ $divisionReport->division->name }} &middot; {{ $divisionReport->period->name ?? '-' }} &middot; Oleh: {{ $divisionReport->author->name }}
                </div>
            </div>
            <div class="flex gap-2">
                <span class="badge badge-green">Disetujui {{ $divisionReport->approved_at ? $divisionReport->approved_at->format('d M Y') : '' }}</span>
                <a href="{{ route('admin.organization-reports.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <div style="white-space: pre-wrap; line-height: 1.8;">{{ $divisionReport->content }}</div>
        </div>
    </div>

    @if($divisionReport->photos->isNotEmpty())
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Foto Dokumentasi ({{ $divisionReport->photos->count() }} foto)</h2>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
                @foreach($divisionReport->photos as $photo)
                    <div style="border-radius: 8px; overflow: hidden; border: 1px solid var(--border-color);">
                        <img src="{{ asset('images/' . $photo->photo_path) }}" style="width: 100%; aspect-ratio: 4/3; object-fit: cover;">
                        @if($photo->caption)
                        <div style="padding: 8px;"><div class="text-xs text-muted">{{ $photo->caption }}</div></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
