<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login &mdash; UKM-IT COS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased text-gray-600 bg-bg-page min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                @if(\App\Models\Setting::get('org_logo'))
                    <img src="{{ asset('images/' . \App\Models\Setting::get('org_logo')) }}" alt="Logo" class="h-10 w-auto object-contain">
                @else
                    <div class="w-10 h-10 bg-primary-navy rounded-xl flex items-center justify-center">
                        <x-lucide-layers class="w-5 h-5" />
                    </div>
                @endif
                <span class="text-xl font-bold text-gray-900 tracking-tight">{{ \App\Models\Setting::get('org_name', 'UKM-IT COS') }}</span>
            </a>
        </div>

        {{-- Login Card --}}
        <div class="ui-card p-8 shadow-md">
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang Kembali</h1>
                <p class="text-sm text-gray-500">Silakan login menggunakan kredensial Anda.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="ui-label">Email / NTA</label>
                    <input type="text" name="email" id="email" class="ui-input" placeholder="Masukkan email atau NTA" value="{{ old('email') }}" required autofocus>
                    @error('email') <p class="ui-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="ui-label">Password</label>
                    <input type="password" name="password" id="password" class="ui-input" placeholder="••••••••" required>
                    @error('password') <p class="ui-error">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-between mt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-secondary-blue focus:ring-secondary-blue/20 bg-white">
                        <span class="text-sm text-gray-600">Ingat Saya</span>
                    </label>
                    {{-- <a href="#" class="text-sm font-medium text-secondary-blue hover:underline">Lupa Password?</a> --}}
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn-primary w-full py-2.5">
                        <x-lucide-log-out class="w-5 h-5" />
                        Masuk ke Dashboard
                    </button>
                </div>
            </form>
        </div>

    </div>

</body>
</html>
