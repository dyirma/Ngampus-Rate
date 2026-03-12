@php
    $subCategoryCount = $subCategories->count(); 
    $totalSteps = $subCategoryCount + 3; 
    $reviewStep = $totalSteps - 1;
    $currentSub = $subCategories->values()->get($step - 2);

    $jurusanList = ['S1 Teknik Informatika', 'S1 Bisnis Digital', 'S1 Hukum Bisnis', 'S1 Manajemen Bisnis Internasional', 'S1 Teknologi Pangan', 'S1 Gizi'];
    $angkatanList = range(date('Y'), date('Y') - 5);
@endphp

{{-- Container Utama dengan efek Glassmorphism --}}
<div class="min-h-screen py-12 px-4 flex items-center justify-center">

    <style>
        /* Styling scrollbar untuk bagian review */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>

    <div class="w-full @if($step <= 1) max-w-2xl @else max-w-4xl @endif transition-all duration-500">
        
        {{-- Card Utama dengan Border Tipis dan Blur --}}
        <div class="bg-white/90 backdrop-blur-xl rounded-[3rem] shadow-2xl border border-white/20 overflow-hidden animate-in fade-in zoom-in duration-500">
            
            {{-- Header Progress Bar yang Lebih Modern --}}
            <div class="bg-white/50 px-10 py-8 border-b border-slate-100">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex flex-col">
                        <p class="text-[10px] uppercase tracking-[0.3em] text-blue-600 font-black">Langkah {{ $step }} dari {{ $totalSteps - 1 }}</p>
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Kategori: {{ $kategori }}</h2>
                    </div>
                    <div class="h-10 w-10 bg-blue-50 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-black text-sm">{{ round((($totalSteps - 1) > 0) ? ($step / ($totalSteps - 1)) * 100 : 0) }}%</span>
                    </div>
                </div>
                <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden p-0.5">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-full rounded-full transition-all duration-1000 ease-out shadow-sm" 
                         style="width: {{ (($totalSteps - 1) > 0) ? ($step / ($totalSteps - 1)) * 100 : 0 }}%"></div>
                </div>
            </div>

            <div class="p-10">
                @if ($step === 0)
                    {{-- Halaman Landing dengan Ilustrasi Tipis --}}
                    <div class="text-center py-8">
                        <h3 class="text-4xl font-black text-slate-800 mb-6 tracking-tight">Siap untuk memulai?</h3>
                        <p class="text-slate-500 text-lg mb-10 max-w-md mx-auto leading-relaxed">Suara Anda sangat berharga untuk masa depan kampus yang lebih baik. Mari berikan penilaian yang jujur.</p>
                        
                        <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                            <button type="button" onclick="window.history.back()" class="w-full sm:w-auto px-8 py-4 bg-white border border-slate-200 text-slate-500 rounded-2xl text-xs font-bold uppercase tracking-widest hover:bg-slate-50 transition-all active:scale-95">
                                KEMBALI
                            </button>
                            <button type="button" wire:click="startKuisioner" class="w-full sm:w-auto px-10 py-5 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-blue-200 hover:shadow-blue-300 transition-all active:scale-95">
                                Mulai Sekarang
                            </button>
                        </div>
                    </div>

                @elseif ($step === 1)
                    {{-- Bagian Data Diri yang Lebih Bersih --}}
                    <div class="animate-in slide-in-from-right-10 duration-500">
                        <div class="text-center mb-10">
                            <div class="flex items-center justify-center gap-3">
                                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <h3 class="text-2xl font-black text-slate-800 tracking-tight">Data Diri Responden</h3>
                            </div>
                            <div class="h-1 w-12 bg-blue-600 mx-auto mt-2 rounded-full"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @php $fields = [
                                ['label' => 'Nama Lengkap', 'val' => Auth::user()->name, 'icon' => 'user'],
                                ['label' => 'Jenis Kelamin', 'val' => Auth::user()->gender ?? '-', 'icon' => 'gender'],
                                ['label' => 'Status', 'val' => Auth::user()->status_responden ?? '-', 'icon' => 'status'],
                                ['label' => 'Program Studi', 'val' => Auth::user()->program_studi ?? '-', 'icon' => 'prodi'],
                            ]; @endphp

                            @foreach($fields as $f)
                                <div class="group p-5 bg-slate-50/50 rounded-[2rem] border border-slate-100 hover:border-blue-200 transition-colors">
                                    <div class="flex items-center gap-2 mb-2">
                                        {{-- Icon indikator data terkunci dari database --}}
                                        <svg class="w-3 h-3 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $f['label'] }}</p>
                                    </div>
                                    <p class="font-bold text-slate-700">{{ $f['val'] }}</p>
                                </div>
                            @endforeach

                            @if($kategori === 'dosen' && isset($listDosen))
                                <div class="md:col-span-2 p-1 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-[2rem]">
                                    <div class="bg-white rounded-[1.9rem] p-6">
                                        <label class="block text-[10px] font-black text-blue-600 uppercase tracking-widest mb-3 text-left">PILIH DOSEN YANG AKAN DINILAI</label>
                                        <select wire:model="selectedDosen" class="w-full p-4 bg-slate-50 border-none rounded-xl font-bold text-slate-700 focus:ring-2 focus:ring-blue-500 transition-all appearance-none cursor-pointer">
                                            <option value="">-- Cari Nama Dosen --</option>
                                            @foreach($listDosen as $dosen)
                                                <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('selectedDosen') <p class="text-[10px] text-red-500 italic font-bold mt-2 ml-1">⚠️ Wajib memilih dosen</p> @enderror
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="flex gap-4 mt-12">
                            <button type="button" onclick="window.history.back()" class="flex-1 px-8 py-4 bg-white border-2 border-slate-100 text-slate-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-50 transition-all active:scale-95">BERANDA</button>
                            <button type="button" wire:click="goToNextStep" wire:loading.attr="disabled" class="flex-1 px-8 py-4 bg-blue-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all active:scale-95">
                                <span wire:loading.remove>LANJUT</span>
                                <span wire:loading>...</span>
                            </button>
                        </div>
                    </div>

                @elseif ($step > 1 && $step < $reviewStep && $currentSub)
                    {{-- Pertanyaan dengan Hover Effect dan Animasi --}}
                    <div class="space-y-10 animate-in fade-in slide-in-from-bottom-8 duration-500">
                        <div class="text-center">
                            <span class="px-4 py-1.5 bg-blue-50 text-blue-600 rounded-full text-[10px] font-black uppercase tracking-widest">Bagian {{ $step - 1 }}</span>
                            <h3 class="text-3xl font-black text-slate-800 mt-4 leading-tight uppercase">{{ $currentSub->nama_sub }}</h3>
                        </div>

                        <div class="space-y-8 text-left">
                            @foreach($currentSub->questions as $question)
                                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm hover:shadow-md transition-shadow duration-300">
                                    <div class="flex gap-4 mb-8">
                                        <span class="flex-shrink-0 w-10 h-10 bg-slate-800 text-white rounded-2xl flex items-center justify-center font-black text-sm">{{ $loop->iteration }}</span>
                                        <h4 class="text-xl font-bold text-slate-700 leading-snug">{{ $question->teks_pertanyaan }}</h4>
                                    </div>
                                    
                                    @if ($question->tipe_jawaban === 'likert')
                                        <div class="grid grid-cols-1 sm:grid-cols-5 gap-3">
                                            @foreach ($likertLabels as $nilai => $label)
                                                @php
                                                    // Menentukan warna utama dan bayangan (glow) berdasarkan angka
                                                    $statusWarna = match((int)$nilai) {
                                                        1 => [
                                                            'bg' => 'bg-red-500', 
                                                            'shadow' => 'shadow-red-200', 
                                                            'text' => 'text-red-500',
                                                            'border' => 'border-red-500'
                                                        ],
                                                        2 => [
                                                            'bg' => 'bg-orange-500', 
                                                            'shadow' => 'shadow-orange-200', 
                                                            'text' => 'text-orange-500',
                                                            'border' => 'border-orange-500'
                                                        ],
                                                        3 => [
                                                            'bg' => 'bg-amber-400', 
                                                            'shadow' => 'shadow-amber-100', 
                                                            'text' => 'text-amber-500',
                                                            'border' => 'border-amber-400'
                                                        ],
                                                        4 => [
                                                            'bg' => 'bg-lime-500', 
                                                            'shadow' => 'shadow-lime-200', 
                                                            'text' => 'text-lime-500',
                                                            'border' => 'border-lime-500'
                                                        ],
                                                        5 => [
                                                            'bg' => 'bg-emerald-500', 
                                                            'shadow' => 'shadow-emerald-200', 
                                                            'text' => 'text-emerald-500',
                                                            'border' => 'border-emerald-500'
                                                        ],
                                                        default => [
                                                            'bg' => 'bg-blue-600', 
                                                            'shadow' => 'shadow-blue-200', 
                                                            'text' => 'text-blue-600',
                                                            'border' => 'border-blue-600'
                                                        ],
                                                    };
                                                @endphp

                                                <label wire:key="q-{{ $question->id }}-{{ $nilai }}" class="flex flex-col items-center gap-3 cursor-pointer group">
                                                    <input type="radio" name="question-{{ $question->id }}" value="{{ $nilai }}" wire:model.live="answers.{{ $question->id }}.nilai" class="sr-only">
                                                    
                                                    {{-- Box Angka dengan Efek Glow --}}
                                                    <div class="w-full rounded-[1.5rem] border-2 py-5 text-center transition-all duration-500 ease-out
                                                        @if(data_get($answers, $question->id . '.nilai') == $nilai) 
                                                            {{ $statusWarna['bg'] }} {{ $statusWarna['shadow'] }} {{ $statusWarna['border'] }} text-white shadow-[0_10px_30px_-5px_rgba(0,0,0,0.1)] shadow-xl scale-110 font-black
                                                        @else 
                                                            bg-slate-50 border-transparent text-slate-400 group-hover:bg-white group-hover:border-slate-200 group-hover:shadow-lg group-hover:scale-105
                                                        @endif">
                                                        {{ $nilai }}
                                                    </div>
                                                    
                                                    {{-- Label Keterangan --}}
                                                    <span class="text-[9px] uppercase font-black text-center tracking-tighter transition-all duration-300 
                                                        @if(data_get($answers, $question->id . '.nilai') == $nilai) 
                                                            {{ $statusWarna['text'] }} scale-110
                                                        @else 
                                                            text-slate-300 group-hover:text-slate-400
                                                        @endif">
                                                        {{ $label }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                        @error("answers.{$question->id}.nilai") <p class="text-[10px] text-red-500 mt-4 italic font-bold">⚠️ Mohon pilih respon anda</p> @enderror
                                    @else
                                        <div class="relative">
                                            <textarea wire:model.live="answers.{{ $question->id }}.teks" class="w-full rounded-[1.5rem] border-slate-100 bg-slate-50 p-6 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-200 transition-all outline-none text-slate-700 font-medium" rows="4" placeholder="Ketik saran atau kritik anda di sini..."></textarea>
                                        </div>
                                        @error("answers.{$question->id}.teks") <p class="text-[10px] text-red-500 mt-2 italic font-bold">⚠️ Tanggapan belum diisi</p> @enderror
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="flex gap-4 pt-10 border-t border-slate-50">
                            <button wire:click="goToPreviousStep" class="px-8 py-5 rounded-2xl border-2 border-slate-100 text-slate-400 font-black text-[10px] uppercase tracking-widest hover:bg-slate-50 transition active:scale-95">KEMBALI</button>
                            <button wire:click="goToNextStep" class="flex-1 px-8 py-5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-black text-[10px] uppercase tracking-widest shadow-xl shadow-blue-200 active:scale-95">BERIKUTNYA</button>
                        </div>
                    </div>

                @elseif ($step === $reviewStep)
                    {{-- Halaman Review yang Cantik --}}
                    <div class="space-y-10 animate-in zoom-in-95 duration-500 text-left">
                        <div class="text-center">
                            <h3 class="text-4xl font-black text-slate-800 tracking-tight">Cek Terakhir</h3>
                            <p class="text-slate-400 text-xs mt-2 uppercase tracking-[0.2em] font-bold">Pastikan semua data sudah sesuai</p>
                        </div>

                        <div class="bg-gradient-to-br from-blue-600 to-indigo-800 rounded-[2.5rem] p-8 text-white shadow-2xl">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <div><p class="text-[8px] font-black opacity-60 uppercase mb-1">Nama</p><p class="font-bold truncate text-xs">{{ Auth::user()->name }}</p></div>
                                <div><p class="text-[8px] font-black opacity-60 uppercase mb-1">Gender</p><p class="font-bold text-xs">{{ Auth::user()->gender ?? '-' }}</p></div>
                                <div><p class="text-[8px] font-black opacity-60 uppercase mb-1">Program Studi</p><p class="font-bold text-xs">{{ Auth::user()->program_studi ?? '-' }}</p></div>
                                <div><p class="text-[8px] font-black opacity-60 uppercase mb-1">Angkatan</p><p class="font-bold text-xs">{{ Auth::user()->angkatan ?? '-' }}</p></div>
                                @if($kategori === 'dosen')
                                    <div class="border-x border-white/20 px-2">
                                        <p class="text-[7px] font-black opacity-60 uppercase mb-1">Dosen Dinilai</p>
                                        <p class="font-bold text-xs truncate text-yellow-300">
                                            @if(isset($listDosen) && $selectedDosen)
                                                {{ $listDosen->firstWhere('id', $selectedDosen)->nama ?? 'Dosen tidak ditemukan' }}
                                            @else
                                                - Belum Dipilih -
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-4 max-h-[450px] overflow-y-auto pr-3 custom-scrollbar">
                            @foreach ($this->summaryData as $subNama => $questions)
                                <div class="bg-slate-50/80 rounded-[2rem] p-6 border border-slate-100">
                                    <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-4 flex items-center gap-2">
                                        <span class="w-1.5 h-4 bg-blue-600 rounded-full"></span> {{ $subNama }}
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach ($questions as $item)
                                            <div class="bg-white rounded-xl p-4 shadow-sm flex justify-between items-center border border-slate-50">
                                                <p class="text-xs text-slate-600 font-medium max-w-[80%]">{{ $item['pertanyaan'] }}</p>
                                                <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg font-black text-xs">{{ $item['jawaban'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 pt-10 border-t border-slate-100">
                            <button type="button" wire:click="goToPreviousStep" class="px-8 py-5 rounded-2xl border-2 border-slate-100 text-slate-400 font-black text-[10px] uppercase tracking-widest hover:bg-slate-50 transition active:scale-95">PERBAIKI</button>
                            <button type="button" wire:click="submit" wire:loading.attr="disabled" class="flex-1 px-8 py-5 rounded-2xl bg-green-500 text-white font-black text-[10px] uppercase tracking-widest shadow-xl shadow-green-100 hover:bg-green-600 transition active:scale-95">
                                <span wire:loading.remove>KIRIM KUESIONER SEKARANG</span>
                                <span wire:loading>MENGIRIM...</span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

