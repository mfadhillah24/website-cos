@extends('layouts.admin')

@section('title', 'Galeri Foto')
@section('page_title', 'Galeri Foto')
@section('breadcrumb', 'Galeri / Daftar Foto')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Koleksi Galeri</h2>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Upload Foto
        </a>
    </div>

    <div class="card-body">
        <div class="gallery-grid">
            @forelse($photos as $photo)
                <div class="gallery-card">
                    {{-- Clickable image area --}}
                    <a
                        href="{{ asset('images/' . $photo->path) }}"
                        class="gallery-thumb"
                        data-caption="{{ $photo->caption ?? ($photo->activity ? $photo->activity->title : '') }}"
                        aria-label="Lihat foto besar"
                    >
                        <img
                            src="{{ asset('images/' . $photo->path) }}"
                            alt="{{ $photo->caption ?? 'Foto galeri' }}"
                            loading="lazy"
                        >
                        <div class="gallery-zoom-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                <line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/>
                            </svg>
                        </div>
                    </a>

                    {{-- Info footer --}}
                    <div class="gallery-info">
                        <div class="gallery-meta">
                            @if($photo->caption)
                                <span class="gallery-caption">{{ Str::limit($photo->caption, 35) }}</span>
                            @endif
                            @if($photo->activity)
                                <span class="gallery-tag">📅 {{ Str::limit($photo->activity->title, 28) }}</span>
                            @endif
                            @if($photo->division)
                                <span class="gallery-tag">🏢 {{ $photo->division->name }}</span>
                            @endif
                            <span class="gallery-uploader">👤 {{ $photo->uploader->name ?? 'Sistem' }}</span>
                        </div>

                        @if(Auth::id() === $photo->uploaded_by || Auth::user()->can('manage_gallery'))
                        <form action="{{ route('admin.gallery.destroy', $photo) }}" method="POST"
                            class="gallery-delete-form"
                            onsubmit="return confirm('Hapus foto ini dari galeri?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="gallery-delete-btn" title="Hapus foto">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    width="15" height="15">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14H6L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                    <path d="M9 6V4h6v2"/>
                                </svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="gallery-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" width="48" height="48">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                    <p>Belum ada foto di galeri.</p>
                        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary" style="margin-top:12px;">Upload Foto Pertama</a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
/* ── Gallery Grid ── */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 18px;
}

/* ── Card ── */
.gallery-card {
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid var(--border-color, #E2E8F0);
    background: var(--card-bg, #fff);
    display: flex;
    flex-direction: column;
    transition: box-shadow 0.2s ease, transform 0.2s ease;
}
.gallery-card:hover {
    box-shadow: 0 6px 24px rgba(0,0,0,0.10);
    transform: translateY(-2px);
}

/* ── Thumbnail / clickable area ── */
.gallery-thumb {
    position: relative;
    display: block;
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    background: #f1f5f9;
    cursor: zoom-in;
    text-decoration: none;
}
.gallery-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}
.gallery-card:hover .gallery-thumb img {
    transform: scale(1.05);
}

/* ── Zoom icon overlay ── */
.gallery-zoom-icon {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.35);
    opacity: 0;
    transition: opacity 0.25s ease;
    color: #fff;
}
.gallery-zoom-icon svg {
    width: 36px;
    height: 36px;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
}
.gallery-thumb:hover .gallery-zoom-icon {
    opacity: 1;
}

/* ── Info footer ── */
.gallery-info {
    padding: 10px 12px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 8px;
    flex: 1;
}
.gallery-meta {
    display: flex;
    flex-direction: column;
    gap: 3px;
    flex: 1;
    min-width: 0;
}
.gallery-caption {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-primary, #111827);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.gallery-tag {
    font-size: 11px;
    color: var(--text-secondary, #64748B);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.gallery-uploader {
    font-size: 11px;
    color: var(--text-secondary, #94A3B8);
}

/* ── Delete button ── */
.gallery-delete-form { flex-shrink: 0; }
.gallery-delete-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border: none;
    border-radius: 6px;
    background: #FEE2E2;
    color: #DC2626;
    cursor: pointer;
    transition: background 0.2s;
    padding: 0;
}
.gallery-delete-btn:hover {
    background: #DC2626;
    color: #fff;
}

/* ── Empty state ── */
.gallery-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    color: var(--text-secondary, #94A3B8);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}
.gallery-empty p { font-size: 14px; }
</style>
@endsection
