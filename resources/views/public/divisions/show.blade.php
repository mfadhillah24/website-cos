@extends('layouts.public')

@section('title', 'Divisi ' . $division->name)
@section('description', Str::limit($division->description, 150))

@section('content')

{{-- BREADCRUMB & HERO --}}
<section class="relative bg-white overflow-hidden pb-16 pt-8 border-b border-gray-100">
    <div class="absolute inset-0 z-0">
        @if($division->cover_image)
            <img src="{{ asset('images/' . $division->cover_image) }}" alt="Cover {{ $division->name }}" class="w-full h-full object-cover opacity-10">
        @else
            <div class="w-full h-full bg-gradient-to-br from-gray-50 to-gray-100"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-white via-white/80 to-transparent"></div>
    </div>
    
    <div class="section-container relative z-10">
        <nav class="flex text-gray-500 text-sm font-medium mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('public.divisi') }}" class="hover:text-[#1A73E8] transition-colors">Divisi</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                        <span class="text-[#071A52] font-semibold ml-1 md:ml-2">{{ $division->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="flex flex-col md:flex-row md:items-center gap-8">
            <div class="w-24 h-24 bg-white rounded-2xl flex items-center justify-center shrink-0 border border-gray-200 shadow-md">
                @if($division->logo)
                    <img src="{{ asset('images/' . $division->logo) }}" alt="Logo {{ $division->name }}" class="w-16 h-16 object-contain">
                @else
                    <x-lucide-network class="w-5 h-5 text-[#1A73E8]" />
                @endif
            </div>
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4 text-[#071A52]">{{ $division->name }}</h1>
                <p class="text-gray-600 max-w-3xl leading-relaxed text-lg mb-6">{{ $division->description }}</p>
                <div class="flex flex-wrap gap-4 text-sm">
                    <div class="flex items-center gap-2 bg-white text-[#071A52] px-4 py-2 rounded-full border border-gray-200 shadow-sm hover:border-[#1A73E8] transition-colors">
                        <x-lucide-file-text class="w-5 h-5" />
                        <span class="font-bold">{{ $division->programs->count() }} <span class="font-normal text-gray-500">Program</span></span>
                    </div>
                    <div class="flex items-center gap-2 bg-white text-[#071A52] px-4 py-2 rounded-full border border-gray-200 shadow-sm hover:border-[#1A73E8] transition-colors">
                        <x-lucide-calendar-days class="w-5 h-5" />
                        <span class="font-bold">{{ $activities->total() }} <span class="font-normal text-gray-500">Kegiatan</span></span>
                    </div>
                    <div class="flex items-center gap-2 bg-white text-[#071A52] px-4 py-2 rounded-full border border-gray-200 shadow-sm hover:border-[#1A73E8] transition-colors">
                        <x-lucide-users class="w-5 h-5" />
                        <span class="font-bold">{{ $members->count() + ($kabid ? 1 : 0) }} <span class="font-normal text-gray-500">Anggota</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FOKUS DIVISI --}}
@if($division->focus_areas && count($division->focus_areas) > 0)
<section class="py-12 bg-gray-50 border-b border-gray-200">
    <div class="section-container">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <h2 class="text-xl font-bold text-[#071A52] shrink-0">Fokus Divisi:</h2>
            <div class="flex flex-wrap gap-3">
                @foreach($division->focus_areas as $focus)
                    <span class="px-4 py-2 bg-white text-gray-700 rounded-full shadow-sm border border-gray-100 text-sm font-medium hover:shadow-md hover:border-[#1A73E8] hover:text-[#1A73E8] transition-all cursor-default">
                        {{ $focus }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<section class="section-spacing bg-gray-50">
    <div class="section-container">
        
        {{-- PROGRAM KERJA --}}
        <div class="mb-20">
            <h2 class="text-3xl font-bold text-[#071A52] mb-8 flex items-center gap-3">
                <span class="w-1.5 h-8 bg-[#1A73E8] rounded-full inline-block"></span>
                Program Kerja
            </h2>
            
            @if($division->programs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($division->programs as $program)
                    <div class="group ui-card border border-gray-200 p-6 hover:shadow-xl hover:border-[#1A73E8]/30 transition-all duration-300 relative overflow-hidden bg-white">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#1A73E8]/5 to-[#1A73E8]/15 rounded-bl-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="flex justify-between items-start gap-4 mb-4">
                                <h3 class="font-bold text-[#071A52] text-xl">{{ $program->title }}</h3>
                                @if($program->status == 'on_progress')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">Berlangsung</span>
                                @elseif($program->status == 'completed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">Selesai</span>
                                @elseif($program->status == 'planning')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-700 border border-yellow-200">Perencanaan</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-700 border border-gray-200">{{ ucfirst($program->status) }}</span>
                                @endif
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed mb-6">{{ Str::limit($program->description, 120) }}</p>
                            <div class="flex items-center justify-between text-sm text-gray-500 border-t border-gray-200 pt-4">
                                <div class="flex items-center gap-2">
                                    <x-lucide-file-text class="w-5 h-5" />
                                    Target: {{ Str::limit($program->target ?? '-', 20) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-12 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                    <p>Belum ada program kerja yang dipublikasikan.</p>
                </div>
            @endif
        </div>

        {{-- KEGIATAN MENDATANG --}}
        @if($upcomingActivities->count() > 0)
        <div class="mb-20">
            <h2 class="text-3xl font-bold text-[#071A52] mb-8 flex items-center gap-3">
                <span class="w-1.5 h-8 bg-amber-500 rounded-full inline-block"></span>
                Kegiatan Mendatang
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($upcomingActivities as $activity)
                    <a href="{{ route('public.kegiatan.show', $activity->slug) }}" class="group ui-card flex flex-col h-full overflow-hidden hover:shadow-xl transition-all">
                        <div class="aspect-video w-full overflow-hidden bg-gray-100 relative">
                            @if($activity->thumbnail)
                                <img src="{{ asset('images/' . $activity->thumbnail) }}" alt="{{ $activity->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 right-4 bg-amber-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                Segera
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-bold text-gray-900 text-lg mb-2 group-hover:text-[#1A73E8] transition-colors line-clamp-2">{{ $activity->title }}</h3>
                            <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                                <x-lucide-calendar-days class="w-5 h-5" />
                                {{ $activity->start_date ? $activity->start_date->translatedFormat('d F Y') : '-' }}
                            </div>
                            <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $activity->description }}</p>
                            <div class="mt-auto pt-4 border-t border-gray-100 text-[#1A73E8] font-medium text-sm flex items-center gap-2">
                                Lihat Detail <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- KEGIATAN DIVISI --}}
        <div class="mb-20">
            <h2 class="text-3xl font-bold text-[#071A52] mb-8 flex items-center gap-3">
                <span class="w-1.5 h-8 bg-green-500 rounded-full inline-block"></span>
                Kegiatan Divisi
            </h2>
            
            @if($activities->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($activities as $activity)
                        <a href="{{ route('public.kegiatan.show', $activity->slug) }}" class="group ui-card flex flex-col h-full overflow-hidden hover:shadow-lg transition-all border border-gray-200 bg-white">
                            <div class="aspect-video w-full overflow-hidden bg-gray-100">
                                @if($activity->thumbnail)
                                    <img src="{{ asset('images/' . $activity->thumbnail) }}" alt="{{ $activity->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6 flex flex-col flex-grow">
                                <h3 class="font-bold text-gray-900 text-lg mb-2 group-hover:text-[#1A73E8] transition-colors line-clamp-2">{{ $activity->title }}</h3>
                                <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                                    <x-lucide-calendar-days class="w-5 h-5" />
                                    {{ $activity->start_date ? $activity->start_date->translatedFormat('d F Y') : '-' }}
                                </div>
                                <p class="text-gray-600 text-sm line-clamp-2">{{ $activity->description }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-8 flex justify-center">
                    {{ $activities->links() }}
                </div>
            @else
                <div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-12 text-center text-gray-500">
                    <p>Belum ada kegiatan yang dipublikasikan.</p>
                </div>
            @endif
        </div>

        {{-- PENGURUS & ANGGOTA --}}
        <div class="mb-20">
            <h2 class="text-3xl font-bold text-[#071A52] mb-8 flex items-center gap-3">
                <span class="w-1.5 h-8 bg-[#071A52] rounded-full inline-block"></span>
                Pengurus Divisi
            </h2>

            <div class="rounded-2xl p-8 md:p-12 shadow-2xl text-white relative overflow-hidden mb-12" style="background: linear-gradient(135deg, #071A52 0%, #0A2679 100%)">
                <!-- Decorative elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 opacity-20 rounded-full blur-2xl -ml-10 -mb-10" style="background-color: #1A73E8"></div>
                
                @if($kabid)
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-8 md:gap-12">
                    <div class="w-40 h-40 md:w-48 md:h-48 rounded-full overflow-hidden border-4 border-white/20 shadow-xl shrink-0 bg-white">
                        @if($kabid->photo)
                            <img src="{{ asset('images/' . $kabid->photo) }}" alt="{{ $kabid->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                                <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                        @endif
                    </div>
                    <div class="text-center md:text-left">
                        <div class="inline-block px-4 py-1.5 text-white text-xs font-bold rounded-full mb-4 shadow-md uppercase tracking-wider" style="background-color: #1A73E8">
                            {{ $kabid->position_name }}
                        </div>
                        <h3 class="text-3xl font-bold mb-2 drop-shadow-sm">{{ $kabid->name }}</h3>
                        <div class="text-gray-300 flex flex-col gap-1 text-sm md:text-base">
                            <p><span class="opacity-70">NIA:</span> {{ $kabid->nta ?? $kabid->nim ?? '-' }}</p>
                            <p><span class="opacity-70">Periode:</span> {{ $kabid->period_name }}</p>
                            <p><span class="opacity-70">Divisi:</span> {{ $division->name }}</p>
                        </div>
                    </div>
                </div>
                @else
                <div class="relative z-10 text-center py-8">
                    <p class="text-gray-300">Belum ada Kepala Divisi yang ditetapkan untuk periode aktif.</p>
                </div>
                @endif
            </div>

            @if($members->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($members as $member)
                <div class="ui-card flex flex-col items-center p-6 text-center hover:shadow-md transition-shadow">
                    <div class="w-24 h-24 rounded-full overflow-hidden mb-4 bg-gray-100 border-2 border-gray-200">
                        @if($member->photo)
                            <img src="{{ asset('images/' . $member->photo) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                        @endif
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1 line-clamp-2">{{ $member->name }}</h4>
                    <p class="text-xs text-gray-500">{{ $member->role_in_division ?? 'Anggota' }}</p>
                </div>
                @endforeach
            </div>
            @endif
        </div>


    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-gradient-to-r from-[#071A52] to-[#1A73E8] text-white text-center">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Tertarik berkembang bersama divisi ini?</h2>
        <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">Mari bergabung dan tingkatkan skill Anda bersama kami di Divisi {{ $division->name }}.</p>
        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-[#071A52] bg-white rounded-full hover:bg-gray-100 hover:scale-105 transition-all shadow-xl">
            Daftar Menjadi Anggota
        </a>
    </div>
</section>

@endsection
