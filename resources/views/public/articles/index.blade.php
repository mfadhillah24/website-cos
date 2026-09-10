@extends('layouts.public')

@section('title', 'Berita & Artikel')
@section('description', 'Kumpulan berita, artikel, dan informasi terbaru dari UKM-IT Cyber Open Source.')

@section('content')

{{-- PAGE HEADER --}}
<section class="bg-white border-b border-gray-200 py-12 md:py-20">
    <div class="section-container">
        <div class="max-w-3xl">
            <span class="text-secondary-blue font-semibold tracking-wider uppercase text-sm mb-2 block">Publikasi</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Berita & Artikel</h1>
            <p class="text-lg text-gray-600 leading-relaxed">
                Kumpulan tulisan, informasi terbaru, dan update kegiatan seputar UKM-IT COS.
            </p>
        </div>
    </div>
</section>

<section class="section-spacing">
    <div class="section-container">
        
        {{-- Categories Filter --}}
        @if($categories->count() > 0)
        <div class="mb-10 flex flex-wrap gap-2">
            <a href="{{ route('public.berita') }}" class="px-4 py-2 rounded-lg font-medium text-sm transition-colors border bg-primary-navy border-primary-navy text-white shadow-sm">
                Semua
            </a>
            @foreach($categories as $cat)
                @if($cat->articles_count > 0)
                <span class="px-4 py-2 rounded-lg font-medium text-sm border bg-white border-gray-200 text-gray-600 cursor-default">
                    {{ $cat->name }} ({{ $cat->articles_count }})
                </span>
                @endif
            @endforeach
        </div>
        @endif

        @if($articles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $article)
                <a href="{{ route('public.berita.show', $article->slug) }}" class="ui-card overflow-hidden ui-card-hover flex flex-col group">
                    <div class="aspect-video bg-gray-100 overflow-hidden relative">
                        @if($article->thumbnail)
                            <img src="{{ asset('images/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <x-lucide-image class="w-5 h-5" />
                            </div>
                        @endif
                        @if($article->category)
                            <span class="absolute top-4 left-4 bg-white/90 backdrop-blur text-primary-navy text-xs font-semibold px-2.5 py-1 rounded-md shadow-sm">
                                {{ $article->category->name }}
                            </span>
                        @endif
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <p class="text-xs text-gray-400 mb-2 flex items-center gap-2">
                            <span>{{ $article->published_at?->translatedFormat('d M Y') ?? 'Draft' }}</span>
                            <span>•</span>
                            <span>{{ $article->author?->name ?? 'Admin' }}</span>
                        </p>
                        <h2 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-secondary-blue transition-colors">{{ $article->title }}</h2>
                        <p class="text-gray-500 text-sm line-clamp-3 flex-grow mb-0">{{ $article->excerpt }}</p>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="mt-12 flex justify-center">
                {{ $articles->links() }}
            </div>
        @else
            <div class="ui-card p-12 text-center max-w-2xl mx-auto">
                <x-lucide-image class="w-5 h-5 mx-auto text-gray-300 mb-4" />
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Artikel</h3>
                <p class="text-gray-500">Belum ada berita atau artikel yang dipublikasikan saat ini.</p>
            </div>
        @endif
    </div>
</section>
@endsection
