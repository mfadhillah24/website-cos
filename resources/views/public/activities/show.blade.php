@extends('layouts.public')

@section('title', $activity->title)
@section('description', Str::limit($activity->description, 150))

@section('content')

{{-- PAGE HEADER --}}
<section class="bg-white border-b border-gray-200 py-12">
    <div class="section-container">
        <nav class="flex text-gray-500 text-sm font-medium mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('public.kegiatan') }}" class="hover:text-primary-navy transition-colors">Kegiatan</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                        <span class="text-gray-900 ml-1 line-clamp-1 max-w-[250px]">{{ $activity->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="max-w-4xl">
            @if($activity->division)
                <span class="inline-block px-3 py-1 bg-secondary-blue/10 text-secondary-blue text-xs font-semibold rounded-md mb-4">{{ $activity->division->name }}</span>
            @endif
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 leading-tight">{{ $activity->title }}</h1>

            <div class="flex flex-wrap items-center gap-6 text-sm text-gray-500 font-medium">
                @if($activity->start_date)
                <div class="flex items-center gap-2">
                    <x-lucide-calendar-days class="w-5 h-5" />
                    <span>
                        {{ $activity->start_date->translatedFormat('d F Y') }}
                        @if($activity->end_date && $activity->end_date->ne($activity->start_date))
                            &mdash; {{ $activity->end_date->translatedFormat('d F Y') }}
                        @endif
                    </span>
                </div>
                @endif
                @if($activity->location)
                <div class="flex items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span>{{ $activity->location }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="section-spacing">
    <div class="section-container">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            {{-- MAIN CONTENT --}}
            <div class="lg:col-span-8 space-y-8">

                {{-- Thumbnail utama --}}
                @if($activity->thumbnail && $activity->photos->count() === 0)
                <div class="ui-card overflow-hidden">
                    <img src="{{ asset('images/' . $activity->thumbnail) }}" alt="{{ $activity->title }}"
                         class="w-full h-auto max-h-[480px] object-cover">
                </div>
                @endif

                {{-- Deskripsi --}}
                @if($activity->description || $activity->content)
                <div class="ui-card p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <x-lucide-file-text class="w-5 h-5 text-secondary-blue" />
                        Tentang Kegiatan
                    </h2>
                    @if($activity->content)
                        <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">
                            {!! $activity->content !!}
                        </div>
                    @elseif($activity->description)
                        <p class="text-gray-600 leading-relaxed">{{ $activity->description }}</p>
                    @endif
                </div>
                @endif

                {{-- Galeri Multi-Foto --}}
                @if($activity->photos->count() > 0)
                <div class="ui-card p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <x-lucide-image class="w-5 h-5 text-secondary-blue" />
                        Dokumentasi Foto
                        <span class="text-xs font-normal text-gray-400 ml-1">({{ $activity->photos->count() }} foto)</span>
                    </h2>

                    {{-- Main Viewer --}}
                    <div class="mb-4 rounded-xl overflow-hidden bg-gray-100">
                        <img id="gallery-main"
                             src="{{ asset('images/' . $activity->photos->first()->path) }}"
                             alt="Foto kegiatan"
                             class="w-full object-cover max-h-[420px] transition-opacity duration-300 cursor-zoom-in"
                             onclick="openLightbox(this.src)">
                    </div>

                    {{-- Thumbnail Strip --}}
                    @if($activity->photos->count() > 1)
                    <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 gap-2">
                        @foreach($activity->photos as $i => $photo)
                        <button type="button"
                                onclick="switchPhoto('{{ asset('images/' . $photo->path) }}', this)"
                                class="photo-thumb aspect-square rounded-lg overflow-hidden border-2 transition-all duration-200 {{ $i === 0 ? 'border-secondary-blue ring-2 ring-secondary-blue/30' : 'border-transparent hover:border-gray-300' }}">
                            <img src="{{ asset('images/' . $photo->path) }}"
                                 alt="Foto {{ $i + 1 }}"
                                 class="w-full h-full object-cover">
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif

            </div>

            {{-- SIDEBAR --}}
            <div class="lg:col-span-4 space-y-6">

                <div class="ui-card p-6">
                    <h3 class="font-bold text-gray-900 text-base mb-4 border-b border-gray-100 pb-3">Informasi Kegiatan</h3>
                    <dl class="space-y-3 text-sm">
                        @if($activity->division)
                        <div class="flex gap-3">
                            <dt class="text-gray-400 w-24 flex-shrink-0">Bidang</dt>
                            <dd class="text-gray-700 font-medium">{{ $activity->division->name }}</dd>
                        </div>
                        @endif
                        @if($activity->start_date)
                        <div class="flex gap-3">
                            <dt class="text-gray-400 w-24 flex-shrink-0">Tanggal</dt>
                            <dd class="text-gray-700 font-medium">{{ $activity->start_date->translatedFormat('d M Y') }}</dd>
                        </div>
                        @endif
                        @if($activity->end_date && $activity->end_date->ne($activity->start_date))
                        <div class="flex gap-3">
                            <dt class="text-gray-400 w-24 flex-shrink-0">Selesai</dt>
                            <dd class="text-gray-700 font-medium">{{ $activity->end_date->translatedFormat('d M Y') }}</dd>
                        </div>
                        @endif
                        @if($activity->location)
                        <div class="flex gap-3">
                            <dt class="text-gray-400 w-24 flex-shrink-0">Lokasi</dt>
                            <dd class="text-gray-700 font-medium">{{ $activity->location }}</dd>
                        </div>
                        @endif
                        @if($activity->status)
                        <div class="flex gap-3">
                            <dt class="text-gray-400 w-24 flex-shrink-0">Status</dt>
                            <dd>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                    {{ $activity->status === 'completed' ? 'bg-green-100 text-green-700' : ($activity->status === 'ongoing' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                                    {{ ucfirst($activity->status) }}
                                </span>
                            </dd>
                        </div>
                        @endif
                        @if($activity->photos->count() > 0)
                        <div class="flex gap-3">
                            <dt class="text-gray-400 w-24 flex-shrink-0">Dokumentasi</dt>
                            <dd class="text-gray-700 font-medium">{{ $activity->photos->count() }} foto</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                @if($related->count() > 0)
                <div>
                    <h3 class="font-bold text-gray-900 text-xl mb-4 border-b border-gray-200 pb-2">Kegiatan Terkait</h3>
                    <div class="space-y-4">
                        @foreach($related as $rel)
                        <a href="{{ route('public.kegiatan.show', $rel->slug) }}" class="ui-card p-4 flex gap-4 hover:shadow-md transition-shadow group">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg shrink-0 overflow-hidden">
                                @if($rel->thumbnail)
                                    <img src="{{ asset('images/' . $rel->thumbnail) }}" alt="{{ $rel->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-col justify-center min-w-0">
                                <h4 class="font-bold text-gray-900 text-sm line-clamp-2 mb-1 group-hover:text-secondary-blue transition-colors">{{ $rel->title }}</h4>
                                @if($rel->start_date)
                                    <p class="text-xs text-gray-500">{{ $rel->start_date->translatedFormat('d M Y') }}</p>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <a href="{{ route('public.kegiatan') }}" class="btn-secondary w-full flex items-center justify-center gap-2 !py-3">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                    Kembali ke Daftar Kegiatan
                </a>
            </div>

        </div>
    </div>
</section>

{{-- Lightbox Overlay --}}
<div id="lightbox-overlay" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center p-4" onclick="closeLightbox()">
    <button class="absolute top-4 right-4 text-white/70 hover:text-white transition-colors" onclick="closeLightbox()">
        <x-lucide-x class="w-5 h-5" />
    </button>
    <img id="lightbox-img" src="" alt="Foto" class="max-h-[90vh] max-w-full object-contain rounded-lg shadow-2xl">
</div>

@endsection

@push('scripts')
<script>
function switchPhoto(src, btn) {
    const main = document.getElementById('gallery-main');
    main.style.opacity = '0';
    setTimeout(() => {
        main.src = src;
        main.style.opacity = '1';
    }, 150);
    document.querySelectorAll('.photo-thumb').forEach(el => {
        el.classList.remove('border-secondary-blue', 'ring-2', 'ring-secondary-blue/30');
        el.classList.add('border-transparent');
    });
    btn.classList.remove('border-transparent');
    btn.classList.add('border-secondary-blue', 'ring-2', 'ring-secondary-blue/30');
}

function openLightbox(src) {
    document.getElementById('lightbox-img').src = src;
    const overlay = document.getElementById('lightbox-overlay');
    overlay.classList.remove('hidden');
    overlay.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const overlay = document.getElementById('lightbox-overlay');
    overlay.classList.add('hidden');
    overlay.classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeLightbox();
});
</script>
@endpush
