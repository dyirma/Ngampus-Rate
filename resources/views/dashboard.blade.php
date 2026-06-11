<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 w-full">
            {{-- Bagian Kiri: Logo & Universitas --}}
            <div class="flex items-center gap-4">
                <img src="{{ asset('logo_ush.png') }}" alt="Logo Kampus" class="w-12 h-12 md:w-14 md:h-14 object-contain">
                <div class="border-l-2 border-slate-300 pl-4 py-1">
                    <p class="text-[10px] md:text-xs font-bold text-slate-800 tracking-wide uppercase leading-tight mb-0.5">
                        Lembaga Penjaminan Mutu
                    </p>
                    <h2 class="font-extrabold text-sm md:text-base text-[#1e3a8a] tracking-widest uppercase leading-tight">
                        Universitas Sugeng Hartono
                    </h2>
                </div>
            </div>

            {{-- Bagian Kanan: Account Profile (Disejajarkan dengan LPM) --}}
            <div class="flex items-center gap-6">
                <div class="hidden md:block">
                    <p class="text-xs font-bold text-slate-500 tracking-widest bg-white/50 px-4 py-2 rounded-full backdrop-blur-md border border-white/50">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </p>
                </div>
                
                {{-- Dropdown Profile (Dipindah dari nav) --}}
                <x-dropdown align="right" width="64">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center justify-center w-10 h-10 md:w-11 md:h-11 rounded-full border-2 border-white shadow-md overflow-hidden bg-blue-100 text-blue-600 font-black focus:outline-none transition-transform hover:scale-105 cursor-pointer group">
                            @if(Auth::user()->foto_profil)
                                <img src="{{ Storage::url(Auth::user()->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                            @else
                                <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- Identitas Pengguna di dalam menu --}}
                        <div class="px-5 py-4 flex items-center gap-4 border-b border-slate-100">
                            <div class="h-11 w-11 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-black text-xl shadow-inner border border-blue-200 overflow-hidden shrink-0">
                                @if(Auth::user()->foto_profil)
                                    <img src="{{ Storage::url(Auth::user()->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="font-bold text-slate-800 text-[13px] tracking-wide uppercase break-words w-full">{{ Auth::user()->name }}</div>
                        </div>

                        {{-- Link Profil --}}
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-3 py-3 !text-slate-600 transition hover:!bg-slate-50 hover:!text-slate-900 {{ Auth::user()->role === 'admin' ? 'border-b border-slate-100' : '' }}">
                            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="font-semibold text-sm">Profile</span>
                        </x-dropdown-link>

                        {{-- Link Admin (Jika Admin) --}}
                        @if (Auth::user() && Auth::user()->role === 'admin')
                            <x-dropdown-link :href="route('admin.dashboard')" class="flex items-center gap-3 py-3 !text-slate-600 transition hover:!bg-slate-50 hover:!text-slate-900 border-b border-slate-100">
                                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span class="font-semibold text-sm">Admin Panel</span>
                            </x-dropdown-link>
                        @endif

                        {{-- Logout Link --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-3 py-3 !text-red-500 transition hover:!bg-red-50 mt-1">
                                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                <span class="font-bold text-sm">Logout</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </x-slot>

    {{-- Container utama --}}
    <div class="py-12 min-h-screen">
        <div class="max-w-5xl mx-auto space-y-10 px-4 sm:px-8 lg:px-12">

            <div class="text-center mb-16 animate-in fade-in slide-in-from-top-4 duration-1000">
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 mb-4 tracking-tighter">
                    Suaramu, <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Masa Depan
                        Kampus.</span>
                </h1>
                <p class="text-slate-600 font-medium max-w-xl mx-auto leading-relaxed">
                    Bantu Universitas Sugeng Hartono menjadi lebih baik dengan memberikan penilaian yang objektif dan
                    jujur.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8">
                @forelse($listCategories as $cat)
                    @php
                        $totalSteps = $cat->subCategories->count() + 1;
                    @endphp

                    <div
                        class="group relative bg-white/70 backdrop-blur-xl rounded-3xl shadow-2xl shadow-blue-900/5 border border-white/80 overflow-hidden transition-all duration-500 hover:shadow-blue-500/10 hover:-translate-y-1">

                        {{-- Dekorasi Aksen Warna --}}
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-150 duration-700">
                        </div>

                        <div class="p-6 md:p-8 relative z-10">
                            {{-- 1. HEADER KARTU (PUSAT) --}}
                            <div class="flex flex-col items-center text-center mb-10 gap-4">
                                <span
                                    class="px-4 py-1.5 bg-blue-600 text-white text-xs font-black tracking-widest rounded-xl shadow-lg shadow-blue-200">
                                    {{ ucwords(strtolower($cat->nama_kategori)) }}
                                </span>
                                <div class="flex items-center gap-4">
                                    <span
                                        class="text-slate-300 font-black text-2xl italic opacity-50 group-hover:opacity-100 transition-opacity">0{{ $loop->iteration }}</span>
                                    <p
                                        class="text-slate-400 text-xs tracking-[0.3em] font-bold border-l border-slate-200 pl-4">
                                        Langkah 0 dari {{ $totalSteps }}</p>
                                </div>
                            </div>

                            {{-- 2. BODY KARTU (PUSAT) --}}
                            <div class="flex flex-col items-center text-center">
                                {{-- Visual Icon Placeholder --}}
                                {{-- <div
                                    class="mb-8 w-24 h-24 bg-blue-50 rounded-[2rem] flex items-center justify-center border border-white shadow-inner group-hover:rotate-12 transition-transform duration-500">
                                    <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div> --}}

                                <div class="max-w-2xl">
                                     <h3 class="text-2xl md:text-3xl font-black text-slate-800 mb-4 tracking-tight">
                                        {{ $cat->nama_kategori }}
                                    </h3>
                                    <p class="text-slate-500 leading-relaxed mb-10 font-medium">
                                        {{ $cat->deskripsi ?? 'Berikan masukan objektif Anda untuk membantu meningkatkan kualitas layanan kampus.' }}
                                    </p>

                                    <div class="flex justify-center">
                                        <a href="{{ route('kuisioner.index', ['kategori' => $cat->slug]) }}"
                                            class="group/btn relative px-8 py-4 bg-slate-900 text-white rounded-2xl font-black text-sm tracking-widest overflow-hidden transition-all hover:pr-16 active:scale-95 shadow-xl shadow-slate-200">
                                            <span class="relative z-10">Mulai Kuesioner Sekarang</span>
                                            <span
                                                class="absolute right-6 top-1/2 -translate-y-1/2 opacity-0 group-hover/btn:opacity-100 transition-all duration-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="bg-white/50 backdrop-blur-md rounded-3xl p-10 md:p-12 text-center border-2 border-dashed border-slate-200">
                        <p class="text-slate-400 font-bold tracking-widest">Belum ada kuesioner aktif.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>