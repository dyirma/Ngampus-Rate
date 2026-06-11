<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LPM USH</title>
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('logo_ush.png') }}" type="image/x-icon" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen overflow-y-auto antialiased selection:bg-blue-500 selection:text-white">
    <div class="fixed inset-0 bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ asset('images/1.png') }}');">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px]"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-2xl animate-in fade-in zoom-in duration-700">

            <div
                class="bg-white/70 backdrop-blur-l rounded-[30px] shadow-2xl border border-white/20 p-8 md:p-12 flex flex-col gap-3">

                <div class="flex justify-center mb-1">
                    <img src="{{ asset('logo_ush.png') }}" alt="Logo Kampus"
                        class="h-16 w-auto object-contain drop-shadow-xl">
                </div>

                <div class="text-center space-y-1">
                    <p class="text-xs font-black text-blue-600 tracking-[0.4em]">Lembaga Penjaminan Mutu</p>
                    <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        Universitas <span class="text-blue-600">Sugeng Hartono</span>
                    </h1>
                </div>

                <p class="text-slate-500 text-sm md:text-base mt-2 font-medium text-center">
                    Terima kasih telah meluangkan waktu untuk mengisi kuesioner ini. Masukan Anda sangat berharga
                    untuk meningkatkan kualitas layanan dan fasilitas kampus.
                </p>

                <div class="space-y-2 mt-6">
                    <a href="{{ route('login') }}"
                        class="block w-full text-center rounded-2xl bg-blue-600 text-white font-bold py-3.5 shadow-xl shadow-blue-600/20 hover:bg-blue-700 transition-all active:scale-95">
                        Log In
                    </a>
                </div>

                <div class="bg-blue-50/50 rounded-[20px] p-4 border border-blue-100/50 mt-2">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                        <p class="text-sm md:text-base font-black text-blue-600 tracking-widest">Info</p>
                    </div>
                    <div class="text-xs md:text-sm text-slate-500 leading-tight">
                        <ul class="space-y-2 text-xs md:text-sm text-slate-500 font-medium">
                            <li class="flex gap-2"><span>•</span> Autentikasi diperlukan untuk melihat dan mengisi
                                kuesioner Anda.</li>
                            <li class="flex gap-2"><span>•</span> Data akun pengguna disediakan resmi oleh admin
                                instansi.</li>
                            <li class="flex gap-2"><span>•</span> Segera login untuk memastikan data evaluasi tercatat
                                ke dalam sistem.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <p class="mt-4 text-center text-slate-400 text-xs font-bold tracking-[3px]">
                © 2026 NgampusRate.id • Sukoharjo
            </p>
        </div>
    </div>
</body>

</html>