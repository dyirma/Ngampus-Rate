<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kuisioner Kampus Universitas Sugeng Hartono</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50">
    <div class="absolute inset-0 bg-gradient-to-b from-slate-100 via-white to-slate-50"></div>
    <div class="relative min-h-screen flex items-center justify-center px-6 py-16">
        <div class="w-full max-w-3xl px-1">
            <div class="bg-white/90 rounded-3xl shadow-xl ring-1 ring-slate-100 p-10 flex flex-col gap-6">
                <div class="mx-auto h-20 w-20 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-2xl font-semibold tracking-wide">
                    USH
                </div>
                <div class="text-center space-y-2">
                    <p class="text-sm uppercase tracking-[0.3em] text-blue-500">Kuisioner Kampus</p>
                    <h1 class="text-2xl font-semibold text-slate-800">Universitas Sugeng Hartono</h1>
                </div>
                <p class="text-slate-600 leading-relaxed">
                    Terima kasih telah meluangkan waktu untuk mengisi kuisioner ini. Masukan Anda sangat berharga
                    untuk membantu kami meningkatkan kualitas layanan dan fasilitas kampus. Kuisioner ini akan memakan
                    waktu sekitar 5-10 menit untuk diselesaikan.
                </p>
                <div class="space-y-4">
                    <div class="space-y-2">
                        <a href="{{ route('login') }}" class="block w-full text-center rounded-2xl bg-blue-600 text-white font-semibold py-3 shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition">
                            Sign-In / Login
                        </a>
                        <p class="text-center text-sm text-slate-500">
                            Belum punya akun? <span class="font-medium text-slate-700">Daftarkan diri Anda terlebih dahulu.</span>
                        </p>
                    </div>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block w-full text-center rounded-2xl border border-blue-200 text-blue-700 font-semibold py-3 hover:bg-blue-50 transition">
                            Registrasi
                        </a>
                    @endif
                </div>
                <div class="text-sm text-slate-500 bg-slate-100 rounded-2xl p-4 space-y-2">
                    <p class="font-semibold text-slate-700">Catatan Penting</p>
                    <ul class="space-y-1">
                        <li>• Akun terverifikasi diperlukan untuk memasuki halaman Data Diri Responden.</li>
                        <li>• Jika belum memiliki akun, lakukan registrasi terlebih dahulu.</li>
                        <li>• Setelah login berhasil, Anda dapat memulai pengisian kuisioner multi-step.</li>
                    </ul>
                </div>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-center text-sm font-medium text-blue-600 hover:text-blue-800">
                        Lanjut ke Dashboard
                    </a>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>
