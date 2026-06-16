<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LPM USH</title>
    <link rel="icon" href="{{ asset('logo_ush.png') }}" type="image/x-icon" />

    {{-- Google Fonts - Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- SweetAlert Cukup Sekali di Sini --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @livewireStyles
</head>

<body class="font-sans antialiased">
    {{-- Latar Belakang Gambar Terpisah --}}
    <div class="fixed inset-0 bg-cover bg-center bg-no-repeat z-[-2]"
        style="background-image: url('{{ asset('images/1.png') }}');"></div>

    {{-- Efek Blur Terpisah --}}
    <div class="fixed inset-0 bg-white/40 backdrop-blur-[2px] z-[-1]"></div>

    {{-- Wadah Utama Konten --}}
    <div class="min-h-screen relative z-0 flex flex-col">

        {{-- Navigasi default Breeze sudah dinonaktifkan secara global --}}

        @isset($header)
            <header
                class="w-full sticky top-0 z-50 bg-white/80 shadow-sm border-b border-white/50 backdrop-blur-sm transition-all">
                <div class="w-full mx-auto py-5 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-grow">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts

    {{-- Logika Notifikasi Gabungan (Lebih Rapi) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toastConfig = {
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3500,
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-100'
                }
            };

            @if (session('success') || session('update_profil_sukses'))
                Swal.fire({
                    ...toastConfig,
                    icon: 'success',
                    title: "{{ session('success') ?? session('update_profil_sukses') }}"
                });
            @endif
            });

        // Listener untuk Livewire Dispatch (Versi v3 yang lebih stabil)
        window.addEventListener('show-toast', event => {
            const data = Array.isArray(event.detail) ? event.detail[0] : event.detail;

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: data.icon || 'success', // Mengambil icon dari kiriman controller
                title: data.message || 'Proses Berhasil', // Mengambil pesan dari controller
                showConfirmButton: false,
                timer: 3000,
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-100'
                }
            });
        });
    </script>
</body>

</html>