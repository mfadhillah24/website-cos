@extends('layouts.public')

@section('title', 'Pendaftaran Berhasil')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center py-20">
    <div class="section-container text-center">
        <div class="max-w-xl mx-auto ui-card p-10 md:p-14 relative overflow-hidden border-t-4 border-t-green-500 shadow-lg">
            <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <x-lucide-check-circle class="w-5 h-5" />
            </div>
            
            <h1 class="text-3xl font-extrabold text-gray-900 mb-4">Pendaftaran Berhasil!</h1>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Terima kasih telah mendaftar sebagai calon anggota UKM-IT Cyber Open Source. Data Anda telah kami terima dan akan segera direview oleh pengurus. Anda akan dihubungi lebih lanjut untuk tahap berikutnya.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                @if(isset($registrationId))
                <a href="{{ route('register.download', $registrationId) }}" class="btn-primary" target="_blank">
                    <x-lucide-download class="w-5 h-5 mr-2" />
                    Download Bukti Pendaftaran (PDF)
                </a>
                @endif
                <a href="{{ route('home') }}" class="btn-secondary">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
