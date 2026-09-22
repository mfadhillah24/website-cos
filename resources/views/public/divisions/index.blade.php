@extends('layouts.public')

@section('title', 'Divisi')
@section('description', 'Daftar divisi yang ada di UKM-IT Cyber Open Source.')

@section('content')

{{-- PAGE HEADER --}}
<section class="bg-white border-b border-gray-200 py-12 md:py-20">
    <div class="section-container">
        <div class="max-w-3xl">
            <span class="text-secondary-blue font-semibold tracking-wider uppercase text-sm mb-2 block">Struktur</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Divisi UKM-IT COS</h1>
            <p class="text-lg text-gray-600 leading-relaxed">
                Menjadi wadah pengembangan minat dan bakat anggota melalui berbagai divisi yang berfokus pada bidang teknologi informasi yang berbeda-beda.
            </p>
        </div>
    </div>
</section>

<section class="section-spacing">
    <div class="section-container">
        
        @if($divisions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($divisions as $div)
                <a href="{{ route('public.divisi.show', $div->slug) }}" class="ui-card p-6 ui-card-hover block group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 bg-gray-50 border border-gray-200 rounded-xl flex items-center justify-center group-hover:bg-primary-navy group-hover:text-white transition-colors text-primary-navy shrink-0">
                            @php
                                $divName = strtolower($div->name);
                            @endphp
                            @if(str_contains($divName, 'programming'))
                                <x-lucide-terminal class="w-5 h-5" />
                            @elseif(str_contains($divName, 'network'))
                                <x-lucide-network class="w-5 h-5" />
                            @elseif(str_contains($divName, 'dkv') || str_contains($divName, 'multimedia') || str_contains($divName, 'desain'))
                                <x-lucide-palette class="w-5 h-5" />
                            @else
                                <x-lucide-layers class="w-5 h-5" />
                            @endif
                        </div>
                        <span class="text-xs font-semibold px-2 py-1 bg-gray-100 text-gray-500 rounded-md">
                            {{ $div->programs_count ?? 0 }} Program
                        </span>
                    </div>
                    
                    <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-secondary-blue transition-colors">{{ $div->name }}</h2>
                    <p class="text-gray-500 text-sm line-clamp-3 mb-6">{{ $div->description }}</p>
                    
                    <div class="pt-4 border-t border-gray-100 text-secondary-blue text-sm font-medium flex items-center gap-2">
                        Lihat Detail Divisi
                        <x-lucide-arrow-right class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                    </div>
                </a>
                @endforeach
            </div>
        @else
            <div class="ui-card p-12 text-center max-w-2xl mx-auto">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="mx-auto text-gray-300 mb-4"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Divisi</h3>
                <p class="text-gray-500">Data divisi belum ditambahkan oleh pengurus.</p>
            </div>
        @endif

    </div>
</section>
@endsection
