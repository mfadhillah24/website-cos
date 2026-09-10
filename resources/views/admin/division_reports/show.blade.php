@extends('layouts.admin')

@section('title', 'Detail Laporan Kegiatan')
@section('page_title', 'Detail Laporan Kegiatan')
@section('breadcrumb', 'Laporan Kegiatan / Detail')

@section('content')
<div style="max-width: 900px; display: flex; flex-direction: column; gap: 24px;">

    {{-- Main Report Card --}}
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">{{ $divisionReport->title }}</h2>
                <div class="text-xs text-muted" style="margin-top: 6px; display: flex; gap: 12px; flex-wrap: wrap;">
                    <span>
                        <x-lucide-users class="w-5 h-5" />
                        {{ $divisionReport->author->name }}
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24" width="13" height="13" stroke="currentColor" stroke-width="2" fill="none" style="display:inline; vertical-align:text-bottom;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        {{ $divisionReport->activity_date ? $divisionReport->activity_date->format('d M Y') : '-' }}
                    </span>
                    <span>
                        <x-lucide-circle class="w-5 h-5" />
                        {{ $divisionReport->activityTypeLabel() }}
                    </span>
                    <span>
                        <x-lucide-layout-dashboard class="w-5 h-5" />
                        {{ $divisionReport->division->name }} &middot; {{ $divisionReport->period->name ?? '-' }}
                    </span>
                </div>
            </div>
            <div class="flex gap-2" style="flex-wrap: wrap;">
                <span class="badge {{ $divisionReport->statusBadge() }}">{{ $divisionReport->statusLabel() }}</span>

                @if($divisionReport->isEditable())
                    @canany(['submit_reports', 'manage_reports'])
                    <a href="{{ route('admin.division-reports.edit', $divisionReport) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.division-reports.submit', $divisionReport) }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm"
                            onclick="return confirm('Ajukan laporan ini ke Ketua Umum? Setelah diajukan, laporan tidak bisa diedit.')">
                            ✉️ Ajukan ke Ketua
                        </button>
                    </form>
                    @endcanany
                @endif

                <a href="{{ route('admin.division-reports.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <div style="white-space: pre-wrap; line-height: 1.9; font-size: 14px;">{{ $divisionReport->content }}</div>
        </div>
    </div>

    {{-- Photo Upload + Gallery --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">📷 Foto Dokumentasi ({{ $divisionReport->photos->count() }} foto)</h2>
        </div>

        @if($divisionReport->isEditable())
        @canany(['submit_reports', 'manage_reports'])
        <div class="card-body" style="border-bottom: 1px solid var(--border-color);">
            <form method="POST" action="{{ route('admin.division-reports.photos.upload', $divisionReport) }}" enctype="multipart/form-data">
                @csrf
                <div class="grid-2" style="align-items: end;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Pilih Foto (bisa banyak sekaligus)</label>
                        <input type="file" name="photos[]" id="photo-upload" accept="image/*" multiple class="form-control" required
                            onchange="updatePhotoPreview(this)">
                        <div class="text-xs text-muted" style="margin-top: 4px;">Format: JPG, PNG, WebP · Maks. 3MB per foto</div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Caption (Opsional)</label>
                        <input type="text" name="captions[]" class="form-control" placeholder="Contoh: Sesi presentasi materi">
                    </div>
                </div>
                <div id="photo-preview" style="display:none; margin-top: 12px; display: flex; gap: 8px; flex-wrap: wrap;"></div>
                <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 16px;">
                    <x-lucide-download class="w-5 h-5" />
                    Unggah Foto
                </button>
            </form>
        </div>
        @endcanany
        @endif

        <div class="card-body">
            @if($divisionReport->photos->isEmpty())
                <div class="text-center text-muted" style="padding: 32px 0;">
                    <x-lucide-image class="w-5 h-5" />
                    Belum ada foto yang diunggah.
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px;">
                    @foreach($divisionReport->photos as $photo)
                        <div style="border-radius: 10px; overflow: hidden; border: 1px solid var(--border-color); background: var(--gray-50);">
                            <img src="{{ asset('images/' . $photo->photo_path) }}"
                                 style="width: 100%; aspect-ratio: 4/3; object-fit: cover; display: block; cursor: pointer;"
                                 onclick="openLightbox('{{ asset('images/' . $photo->photo_path) }}')">
                            <div style="padding: 8px;">
                                <div class="text-xs text-muted">{{ $photo->caption ?: 'Tanpa caption' }}</div>
                                @canany(['submit_reports', 'manage_reports'])
                                @if($divisionReport->isEditable())
                                <form method="POST" action="{{ route('admin.division-reports.photos.destroy', $photo) }}" style="margin-top: 6px;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="width: 100%; font-size: 11px;"
                                        onclick="return confirm('Hapus foto ini?')">Hapus</button>
                                </form>
                                @endif
                                @endcanany
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Review History --}}
    @if($divisionReport->reviews->isNotEmpty())
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Riwayat Review Ketua</h2>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 16px;">
                @foreach($divisionReport->reviews->sortByDesc('created_at') as $review)
                    <div style="padding: 16px; background: var(--bg-color); border-radius: 8px; border-left: 4px solid {{ $review->action === 'approved' ? '#10b981' : '#f59e0b' }};">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span class="font-semibold text-sm">{{ $review->reviewer->name }}</span>
                            <span class="text-xs text-muted">{{ $review->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div style="margin-bottom: 8px;">
                            @if($review->action === 'approved')
                                <span class="badge badge-green">✅ Disetujui</span>
                            @else
                                <span class="badge badge-yellow">⚠️ Perlu Revisi</span>
                            @endif
                        </div>
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
function updatePhotoPreview(input) {
    const preview = document.getElementById('photo-preview');
    preview.innerHTML = '';
    if (!input.files.length) return;
    preview.style.display = 'flex';
    Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:80px;height:60px;object-fit:cover;border-radius:6px;border:2px solid var(--gray-200);';
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}

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
