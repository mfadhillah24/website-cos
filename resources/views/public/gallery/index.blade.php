@extends('layouts.public')

@section('title', 'Galeri Kegiatan')
@section('description', 'Momen-momen berharga dan dokumentasi kegiatan UKM-IT Cyber Open Source.')

@section('content')

{{-- PAGE HEADER --}}
<section class="bg-white border-b border-gray-200 py-12 md:py-20">
    <div class="section-container">
        <div class="max-w-3xl">
            <span class="text-secondary-blue font-semibold tracking-wider uppercase text-sm mb-2 block">Dokumentasi</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Galeri COS</h1>
            <p class="text-lg text-gray-600 leading-relaxed">
                Kumpulan momen, kegiatan, dan dokumentasi kebersamaan dari seluruh anggota UKM-IT COS.
            </p>
        </div>
    </div>
</section>

<section class="section-spacing">
    <div class="section-container">
        
        @if($photos->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($photos as $photo)
                <div class="ui-card overflow-hidden group cursor-pointer border-none shadow-none bg-transparent" onclick="openModal('{{ asset('images/' . $photo->path) }}', '{{ $photo->caption ?? 'Galeri COS' }}')">
                    <div class="aspect-[4/3] bg-gray-100 rounded-xl overflow-hidden relative border border-gray-200">
                        <img src="{{ asset('images/' . $photo->path) }}" alt="{{ $photo->caption ?? 'Galeri' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        
                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                            @if($photo->activity)
                                <span class="text-xs font-semibold text-secondary-blue uppercase mb-1">{{ $photo->activity->title }}</span>
                            @elseif($photo->division)
                                <span class="text-xs font-semibold text-secondary-blue uppercase mb-1">Divisi {{ $photo->division->name }}</span>
                            @endif
                            <p class="text-white font-medium text-sm line-clamp-2">{{ $photo->caption ?? 'Tanpa Keterangan' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-12 flex justify-center">
                {{ $photos->links() }}
            </div>
        @else
            <div class="ui-card p-12 text-center max-w-2xl mx-auto">
                <x-lucide-image class="w-5 h-5 mx-auto text-gray-300 mb-4" />
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Foto</h3>
                <p class="text-gray-500">Belum ada foto dokumentasi yang dipublikasikan di galeri.</p>
            </div>
        @endif

    </div>
</section>

{{-- Image Modal --}}
<div id="imageModal" class="hidden fixed inset-0 z-[100] bg-gray-900/95 flex items-center justify-center p-4 backdrop-blur-sm">
    <button onclick="closeModal()" class="absolute top-6 right-6 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 rounded-full p-2 transition-colors">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
    </button>
    <div class="max-w-5xl w-full flex flex-col gap-4">
        <img id="modalImg" src="" alt="" class="max-w-full max-h-[80vh] object-contain mx-auto rounded-lg shadow-2xl">
        <p id="modalCaption" class="text-white/90 text-center font-medium"></p>
    </div>
</div>

@push('scripts')
<script>
    function openModal(src, caption) {
        document.getElementById('modalImg').src = src;
        document.getElementById('modalCaption').innerText = caption;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = '';
    }
</script>
@endpush
@endsection
