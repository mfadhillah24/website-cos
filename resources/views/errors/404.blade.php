@extends('layouts.public')
@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center py-20">
    <div class="section-container text-center">
        <div class="max-w-xl mx-auto ui-card p-12 relative overflow-hidden">
            <div class="absolute -top-20 -right-20 w-48 h-48 bg-gray-50 rounded-full"></div>
            
            <div class="relative z-10">
                <h1 class="text-7xl font-extrabold text-primary-navy mb-4 opacity-20">404</h1>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Halaman Tidak Ditemukan</h2>
                <p class="text-gray-500 mb-8 leading-relaxed">
                    Maaf, halaman yang Anda cari mungkin telah dipindahkan, dihapus, atau memang tidak pernah ada.
                </p>
                <a href="{{ route('home') }}" class="btn-primary">
                    <x-lucide-arrow-left class="w-5 h-5" />
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
