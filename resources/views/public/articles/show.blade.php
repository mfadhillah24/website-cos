@extends('layouts.public')

@section('title', $article->title)
@section('description', Str::limit(strip_tags($article->excerpt ?? $article->content), 150))
@section('og_image', $article->thumbnail ? asset('images/' . $article->thumbnail) : asset('images/og-default.png'))

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<style>
    /* Styling for inline images inserted via TinyMCE */
    .prose img {
        border-radius: 0.5rem;
        margin: 2rem auto;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
</style>
@endpush

@section('content')

{{-- PAGE HEADER / BREADCRUMB --}}
<section class="bg-white border-b border-gray-200 py-12">
    <div class="section-container">
        <nav class="flex text-gray-500 text-sm font-medium mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('public.berita') }}" class="hover:text-primary-navy transition-colors">Berita</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                        <span class="text-gray-900 ml-1 md:ml-2 line-clamp-1 max-w-[200px] sm:max-w-[300px]">{{ $article->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="max-w-4xl">
            @if($article->category)
                <span class="inline-block px-3 py-1 bg-secondary-blue/10 text-secondary-blue text-xs font-semibold rounded-md mb-4">{{ $article->category->name }}</span>
            @endif
            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-6 leading-tight">{{ $article->title }}</h1>
            
            <div class="flex flex-wrap items-center gap-6 text-sm text-gray-500 font-medium">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-primary-navy shrink-0 border border-gray-200">
                        <x-lucide-user class="w-5 h-5" />
                    </div>
                    <span>{{ $article->author?->name ?? 'Admin' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <x-lucide-calendar-days class="w-5 h-5" />
                    <span>{{ $article->published_at?->translatedFormat('d F Y') ?? '—' }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-spacing">
    <div class="section-container">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {{-- MAIN ARTICLE --}}
            <div class="lg:col-span-8">
                <div class="ui-card overflow-hidden mb-8">
                    @if($article->thumbnail)
                        <img src="{{ asset('images/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-auto max-h-[500px] object-cover border-b border-gray-200">
                    @endif
                    <div class="p-6 md:p-10">
                        <div class="prose prose-gray prose-lg max-w-none prose-headings:text-gray-900 prose-a:text-secondary-blue">
                            {!! $article->content !!}
                        </div>
                    </div>
                </div>

                {{-- GALLERY SECTION --}}
                @if(isset($article->images) && $article->images->count() > 0)
                    <div class="ui-card p-6 md:p-10">
                        <h3 class="font-bold text-gray-900 text-2xl mb-6">Galeri Dokumentasi</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($article->images as $img)
                                <a href="{{ asset('images/' . $img->image_path) }}" class="glightbox block relative rounded-lg overflow-hidden group aspect-[4/3] bg-gray-100" data-gallery="article-gallery" data-description="{{ $img->caption ?? $article->title }}">
                                    <img src="{{ asset('images/' . $img->image_path) }}" alt="{{ $img->caption ?? $article->title }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                    @if($img->caption)
                                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <p class="text-white text-sm line-clamp-2">{{ $img->caption }}</p>
                                        </div>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- SIDEBAR: RELATED ARTICLES --}}
            <div class="lg:col-span-4 space-y-6">
                <h3 class="font-bold text-gray-900 text-xl mb-4 border-b border-gray-200 pb-2">Artikel Terkait</h3>
                
                @if($related->count() > 0)
                    <div class="space-y-4">
                        @foreach($related as $rel)
                        <a href="{{ route('public.berita.show', $rel->slug) }}" class="ui-card p-4 flex gap-4 ui-card-hover group">
                            <div class="w-24 h-24 bg-gray-100 rounded-lg shrink-0 overflow-hidden">
                                @if($rel->thumbnail)
                                    <img src="{{ asset('images/' . $rel->thumbnail) }}" alt="{{ $rel->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-col justify-center">
                                <h4 class="font-bold text-gray-900 text-sm line-clamp-2 mb-1 group-hover:text-secondary-blue transition-colors">{{ $rel->title }}</h4>
                                <p class="text-xs text-gray-500">{{ $rel->published_at?->translatedFormat('d M Y') }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @else
                    <div class="ui-card p-6 text-center text-gray-500 text-sm">
                        Belum ada artikel terkait.
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            autoplayVideos: true,
            openEffect: 'fade',
            closeEffect: 'fade',
            zoomable: true
        });
    });
</script>
@endpush
