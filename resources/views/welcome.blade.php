<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kuisioner Kampus Universitas Sugeng Hartono</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" href="{{ asset('logo_ush.png') }}" type="image/x-icon" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-screen overflow-hidden antialiased selection:bg-blue-500 selection:text-white">
    <div class="fixed inset-0 bg-cover bg-center bg-no-repeat" 
         style="background-image: url('{{ asset('images/1.png') }}');">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px]"></div>
    </div>

    <div class="relative h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-2xl animate-in fade-in zoom-in duration-700"> 
            
            <div class="bg-white/70 backdrop-blur-l rounded-[50px] shadow-2xl border border-white/20 p-20 flex flex-col gap-3">
                
                <div class="flex justify-center mb-1">
                    <img src="{{ asset('logo_ush.png') }}" 
                    alt="Logo Kampus" 
                    class="h-16 w-auto object-contain drop-shadow-xl">
                </div>

                <div class="text-center space-y-1">
                    <p class="text-[9px] font-black text-blue-600 uppercase tracking-[0.4em]">Kuisioner Kampus</p>
                    <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        Universitas <span class="text-blue-600">Sugeng Hartono</span>
                    </h1>
                </div>

                <p class="text-slate-500 text-[16px] mt-2 font-medium text-center">
                    Terima kasih telah meluangkan waktu untuk mengisi kuisioner ini. Masukan Anda sangat berharga
                    untuk meningkatkan kualitas layanan dan fasilitas kampus.
                </p>

                <div class="space-y-3">
                    <div class="space-y-2">
                        <a href="{{ route('login') }}" class="block w-full text-center rounded-2xl bg-blue-600 text-white font-bold py-3.5 shadow-xl shadow-blue-600/20 hover:bg-blue-700 transition-all active:scale-95">
                            Sign-In / Login
                        </a>
                        <p class="text-center text-[14px] text-slate-500 font-medium">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:underline">Daftar sekarang.</a>
                        </p>
                    </div>

                    @if (Route::has('register'))
                        <div class="relative py-1">
                            <div class="absolute inset-0 flex items-center"><span class="w-full border-t border-slate-100"></span></div>
                            <div class="relative flex justify-center text-[8px] uppercase"><span class="bg-white px-3 text-slate-500 font-bold tracking-widest">Atau</span></div>
                        </div>

                        <a href="{{ route('register') }}" class="block w-full text-center rounded-2xl border-2 border-slate-50 text-slate-600 font-bold py-3 hover:bg-slate-50 transition-all text-sm">
                            Registrasi Mahasiswa
                        </a>
                    @endif
                </div>

                <div class="bg-blue-50/50 rounded-[20px] p-4 border border-blue-100/50 mt-2">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                        <p class="text-[15px] font-black text-blue-600 uppercase tracking-widest">Info</p>
                    </div>
                    <p class="text-[13px] text-slate-500 leading-tight">
                       <ul class="space-y-2 text-[14px] text-slate-500 font-medium">
                            <li class="flex gap-2"><span>•</span> Akun terverifikasi diperlukan untuk Data Diri Responden</li>
                            <li class="flex gap-2"><span>•</span> Jika belum memiliki akun, lakukan registrasi terlebih dahulu</li>
                            <li class="flex gap-2"><span>•</span> Setelah login berhasil, Anda dapat memulai kuesioner multi-step</li>
                        </ul>
                    </p>
                </div>
            </div>

            <p class="mt-4 text-center text-slate-400 text-[9px] font-bold uppercase tracking-[3px]">
                © 2026 NgampusRate.id • Sukoharjo
            </p>
        </div>
    </div>
</body>