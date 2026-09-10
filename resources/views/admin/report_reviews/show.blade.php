@extends('layouts.admin')

@section('title', 'Review: ' . $divisionReport->title)
@section('page_title', 'Review Laporan')
@section('breadcrumb', 'Laporan Organisasi / Review Laporan / Detail')

@section('content')
<div style="max-width: 900px; display: flex; flex-direction: column; gap: 24px;">

    {{-- Report Content --}}
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">{{ $divisionReport->title }}</h2>
                <div class="text-xs text-muted" style="margin-top:4px;">
                    {{ $divisionReport->division->name }} &middot; {{ $divisionReport->period->name ?? '-' }} &middot; Oleh: {{ $divisionReport->author->name }}
                    &middot; Diajukan: {{ $divisionReport->submitted_at ? $divisionReport->submitted_at->format('d M Y, H:i') : '-' }}
                </div>
            </div>
            <div class="flex gap-2">
                <span class="badge {{ $divisionReport->statusBadge() }}">{{ $divisionReport->statusLabel() }}</span>
                <a href="{{ route('admin.report-reviews.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <div style="white-space: pre-wrap; line-height: 1.8;">{{ $divisionReport->content }}</div>
        </div>
    </div>

    {{-- Photos --}}
    @if($divisionReport->photos->isNotEmpty())
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Foto Laporan ({{ $divisionReport->photos->count() }} foto)</h2>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px;">
                @foreach($divisionReport->photos as $photo)
                    <div style="border-radius: 8px; overflow: hidden; border: 1px solid var(--border-color);">
                        <img src="{{ asset('images/' . $photo->photo_path) }}" 
                             style="width: 100%; aspect-ratio: 4/3; object-fit: cover; display: block; cursor: pointer;"
                             onclick="openLightbox('{{ asset('images/' . $photo->photo_path) }}')">
                        @if($photo->caption)
                        <div style="padding: 6px 8px;"><div class="text-xs text-muted">{{ $photo->caption }}</div></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Review Form --}}
    @if(in_array($divisionReport->status, ['submitted', 'reviewing']))
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Berikan Keputusan Review</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.report-reviews.store', $divisionReport) }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Keputusan Review <span style="color:#EF4444;">*</span></label>
                    <div style="display: flex; gap: 16px;">
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                            <input type="radio" name="action" value="approved" required>
                            <span class="badge badge-green">Setujui Laporan</span>
                        </label>
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                            <input type="radio" name="action" value="revision" required>
                            <span class="badge badge-orange">Minta Revisi</span>
                        </label>
                    </div>
                    @error('action')<div class="invalid-feedback" style="display:block;">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="notes">Catatan Review <span style="color:#EF4444;">*</span></label>
                    <textarea id="notes" name="notes" rows="4" class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}"
                        placeholder="Tuliskan catatan keputusan review, alasan persetujuan, atau poin-poin yang perlu direvisi..." required>{{ old('notes') }}</textarea>
                    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-3" style="margin-top:24px;">
                    <button type="submit" class="btn btn-primary">Kirim Keputusan Review</button>
                    <a href="{{ route('admin.report-reviews.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Review History --}}
    @if($divisionReport->reviews->isNotEmpty())
    <div class="card">
        <div class="card-header"><h2 class="card-title">Riwayat Review</h2></div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @foreach($divisionReport->reviews->sortByDesc('created_at') as $review)
                    <div style="padding: 16px; background: var(--bg-color); border-radius: 8px; border-left: 4px solid {{ $review->action === 'approved' ? '#10b981' : '#f59e0b' }};">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                            <span class="font-semibold text-sm">{{ $review->reviewer->name }}</span>
                            <span class="text-xs text-muted">{{ $review->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        @if($review->action === 'approved')
                            <span class="badge badge-green" style="margin-bottom: 8px; display:inline-block;">Disetujui</span>
                        @else
                            <span class="badge badge-orange" style="margin-bottom: 8px; display:inline-block;">Perlu Revisi</span>
                        @endif
                        <div class="text-sm">{{ $review->notes }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Lightbox Modal --}}
    <div id="image-lightbox" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 9999; justify-content: center; align-items: center; padding: 20px;">
        <span onclick="closeLightbox()" style="position: absolute; top: 20px; right: 30px; color: white; font-size: 40px; font-weight: bold; cursor: pointer;">&times;</span>
        <img id="lightbox-img" src="" style="max-width: 90%; max-height: 90vh; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.5); object-fit: contain;">
    </div>

</div>

@push('scripts')
<script>
function openLightbox(src) {
    const lightbox = document.getElementById('image-lightbox');
    const img = document.getElementById('lightbox-img');
    img.src = src;
    lightbox.style.display = 'flex';
}

function closeLightbox() {
    document.getElementById('image-lightbox').style.display = 'none';
}

// Close lightbox on escape key press
document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") {
        closeLightbox();
    }
});
</script>
@endpush
@endsection
