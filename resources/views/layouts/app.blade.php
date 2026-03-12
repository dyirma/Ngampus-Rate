<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Ngampus Rate') }}</title>
        <link rel="icon" href="{{ asset('logo_ush.png') }}" type="image/x-icon" />

        {{-- Font dari Bunny Fonts --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        {{-- SweetAlert Cukup Sekali di Sini --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-cover bg-center bg-no-repeat bg-fixed relative" 
            style="background-image: url('{{ asset('images/1.png') }}');">
            
            <div class="min-h-screen bg-white/40 backdrop-blur-[2px]">
                
                <nav class="sticky top-0 z-50 bg-white/60 backdrop-blur-md shadow-sm border-b border-white/20">
                    @include('layouts.navigation')
                </nav>

                @isset($header)
                    <header class="bg-white/40 shadow-sm">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main>
                    {{ $slot }}
                </main>
            </div>
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