<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[10px] uppercase tracking-[0.4em] text-blue-600 font-bold mb-1">Beranda Utama</p>
                <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tight">
                    Ngampus<span class="text-blue-600">Rate.</span>
                </h2>
            </div>
            <div class="hidden md:block">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest bg-white/50 px-4 py-2 rounded-full backdrop-blur-md border border-white/50">
                    {{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
        </div>
    </x-slot>

    {{-- Container utama --}}
    <div class="py-12 min-h-screen">
        <div class="max-w-5xl mx-auto space-y-10 px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-16 animate-in fade-in slide-in-from-top-4 duration-1000">
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tighter">
                    Suaramu, <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Masa Depan Kampus.</span>
                </h1>
                <p class="text-slate-600 font-medium max-w-xl mx-auto leading-relaxed">
                    Bantu Universitas Sugeng Hartono menjadi lebih baik dengan memberikan penilaian yang objektif dan jujur.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8">
                @forelse($listCategories as $cat)
                @php
                    $totalQuestions = $cat->subCategories->flatMap->questions->count();
                @endphp
                
                <div class="group relative bg-white/70 backdrop-blur-xl rounded-[3rem] shadow-2xl shadow-blue-900/5 border border-white/80 overflow-hidden transition-all duration-500 hover:shadow-blue-500/10 hover:-translate-y-1">
                    
                    {{-- Dekorasi Aksen Warna --}}
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-150 duration-700"></div>

                    <div class="p-8 md:p-12 relative z-10">
                        {{-- 1. HEADER KARTU (PUSAT) --}}
                        <div class="flex flex-col items-center text-center mb-10 gap-4">
                            <span class="px-4 py-1.5 bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-blue-200">
                                {{ $cat->nama_kategori }}
                            </span>
                            <div class="flex items-center gap-4">
                                <span class="text-slate-300 font-black text-4xl italic opacity-50 group-hover:opacity-100 transition-opacity">0{{ $loop->iteration }}</span>
                                <p class="text-slate-400 text-[10px] uppercase tracking-[0.3em] font-bold border-l border-slate-200 pl-4">Langkah 0 dari {{ $totalQuestions + 2 }}</p>
                            </div>
                        </div>

                        {{-- 2. BODY KARTU (PUSAT) --}}
                        <div class="flex flex-col items-center text-center">
                            {{-- Visual Icon Placeholder --}}
                            {{-- <div class="mb-8 w-24 h-24 bg-blue-50 rounded-[2rem] flex items-center justify-center border border-white shadow-inner group-hover:rotate-12 transition-transform duration-500">
                                <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div> --}}

                            <div class="max-w-2xl">
                                <h3 class="text-4xl font-black text-slate-800 mb-4 tracking-tight">
                                    {{ str_contains(strtolower($cat->nama_kategori), 'dosen') ? 'Evaluasi Kinerja Dosen' : 'Layanan ' . $cat->nama_kategori }}
                                </h3>
                                <p class="text-slate-500 leading-relaxed mb-10 font-medium">
                                    {{ $cat->deskripsi ?? 'Berikan masukan objektif Anda untuk membantu meningkatkan kualitas layanan kampus.' }}
                                </p>
                                
                                <div class="flex justify-center">
                                    <a href="{{ route('kuisioner.index', ['kategori' => $cat->slug]) }}" 
                                       class="group/btn relative px-12 py-5 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest overflow-hidden transition-all hover:pr-16 active:scale-95 shadow-xl shadow-slate-200">
                                        <span class="relative z-10">Mulai Kuisioner Sekarang</span>
                                        <span class="absolute right-6 top-1/2 -translate-y-1/2 opacity-0 group-hover/btn:opacity-100 transition-all duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="bg-white/50 backdrop-blur-md rounded-[3rem] p-20 text-center border-2 border-dashed border-slate-200">
                        <p class="text-slate-400 font-bold uppercase tracking-widest">Belum ada kuesioner aktif.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>