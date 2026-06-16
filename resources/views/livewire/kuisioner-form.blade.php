@php
    $subCategoryCount = $subCategories->count(); 
    $totalSteps = $subCategoryCount + 2; 
    $reviewStep = $totalSteps - 1;
    $currentSub = ($step >= 1 && $step <= $subCategoryCount) ? $subCategories->values()->get($step - 1) : null;

    $jurusanList = ['S1 Teknik Informatika', 'S1 Bisnis Digital', 'S1 Hukum Bisnis', 'S1 Manajemen Bisnis Internasional', 'S1 Teknologi Pangan', 'S1 Gizi'];
    $angkatanList = range(date('Y'), date('Y') - 5);
@endphp

{{-- Container Utama dengan efek Glassmorphism --}}
<div class="min-h-screen py-6 md:py-8 px-4 flex items-center justify-center">

    <style>
        /* Styling scrollbar untuk bagian review */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>

    <div class="w-full @if($step === 0) max-w-xl @else max-w-3xl @endif transition-all duration-500">
        
        {{-- Card Utama dengan Border Tipis dan Blur --}}
        <div class="bg-white/90 backdrop-blur-xl rounded-[2rem] shadow-2xl border border-white/20 overflow-hidden animate-in fade-in zoom-in duration-500">
            
            {{-- Header Progress Bar yang Lebih Modern --}}
            @if (!$hasAnswered)
            <div class="bg-white/50 px-6 py-5 md:px-8 border-b border-slate-100">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex flex-col">
                        <p class="text-xs tracking-[0.3em] text-blue-600 font-black">Langkah {{ $step }} dari {{ $totalSteps - 1 }}</p>
                        <h2 class="text-xs font-bold text-slate-400 tracking-widest mt-1">Kategori: {{ $kategori }}</h2>
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
            @endif

            <div class="p-6 md:p-8">
                @if ($hasAnswered)
                    <div class="text-center py-8 md:py-12">
                        <div class="w-20 h-20 md:w-24 md:h-24 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 border border-green-100 shadow-sm animate-in zoom-in duration-500">
                            <svg class="w-10 h-10 md:w-12 md:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-black text-slate-800 mb-3 tracking-tight">Kuesioner Selesai!</h3>
                        <p class="text-slate-500 text-sm md:text-base max-w-sm mx-auto leading-relaxed">Terima kasih telah berpartisipasi dalam evaluasi tahun {{ date('Y') }}. Masukan Anda sangat berarti bagi kemajuan kampus.</p>
                        <div class="mt-8">
                            <a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 bg-white border-2 border-slate-100 text-slate-500 rounded-xl text-xs font-bold tracking-widest hover:bg-slate-50 transition-all active:scale-95 shadow-sm">Kembali ke Beranda</a>
                        </div>
                    </div>
                @elseif ($step === 0)
                    {{-- Halaman Landing dengan Ilustrasi Tipis --}}
                    <div class="text-center py-4">
                        <h3 class="text-xl md:text-2xl font-black text-slate-800 mb-4 tracking-tight">Siap untuk memulai?</h3>
                        <p class="text-slate-500 text-sm md:text-base mb-6 max-w-md mx-auto leading-relaxed">Suara Anda sangat berharga untuk masa depan kampus yang lebih baik. Mari berikan penilaian yang jujur.</p>
                        
                        <div class="bg-blue-50/70 border border-blue-100 rounded-2xl p-5 mb-8 text-left inline-block max-w-lg mx-auto shadow-sm">
                            <p class="text-xs text-blue-700 font-bold leading-relaxed">
                                <strong class="font-black tracking-widest text-blue-800 block mb-2">🔒 KEBIJAKAN ANONIM:</strong> 
                                Identitas log-in Anda hanya digunakan untuk memverifikasi entri agar tidak ada pengisian ganda. Jawaban kuesioner akan direkam 100% secara anonim pada sistem dan dienkripsi dari pihak manapun, sehingga objektivitas Anda terlindungi walau Anda memberikan kritik tajam.
                            </p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row justify-center items-center gap-3">
                            <button type="button" onclick="window.history.back()" class="w-full sm:w-auto px-6 py-3 bg-white border border-slate-200 text-slate-500 rounded-xl text-xs font-bold tracking-widest hover:bg-slate-50 transition-all active:scale-95">
                                Kembali
                            </button>
                            <button type="button" wire:click="startKuisioner" class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl font-black text-xs tracking-widest shadow-xl shadow-blue-200 hover:shadow-blue-300 transition-all active:scale-95">
                                Mulai Sekarang
                            </button>
                        </div>
                    </div>

                @elseif ($step >= 1 && $step < $reviewStep && $currentSub)
                    {{-- Pertanyaan dengan Hover Effect dan Animasi --}}
                    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-8 duration-500">
                        <div class="text-center">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-black tracking-widest uppercase">Bagian {{ $step }}</span>
                            <h3 class="text-xl md:text-2xl font-black text-slate-800 mt-2 leading-tight capitalize">{{ strtolower($currentSub->nama_sub) }}</h3>
                        </div>

                        <div class="space-y-4 text-left">
                            @foreach($currentSub->questions as $question)
                                <div class="bg-white rounded-2xl p-5 md:p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow duration-300">
                                    <div class="flex gap-3 mb-5">
                                        <span class="flex-shrink-0 w-8 h-8 bg-slate-800 text-white rounded-xl flex items-center justify-center font-black text-xs">{{ $loop->iteration }}</span>
                                        <h4 class="text-base md:text-lg font-bold text-slate-700 leading-snug">{{ $question->teks_pertanyaan }}</h4>
                                    </div>
                                    
                                    @if ($question->tipe_jawaban === 'likert')
                                        <div class="grid grid-cols-1 sm:grid-cols-5 gap-3" x-data="{ selected: @entangle('answers.'.$question->id.'.nilai') }">
                                            @foreach ($likertLabels as $nilai => $label)
                                                @php
                                                    $statusWarna = match((int)$nilai) {
                                                        1 => [ 'bg' => 'bg-red-500', 'shadow' => 'shadow-red-200', 'text' => 'text-red-500', 'border' => 'border-red-500' ],
                                                        2 => [ 'bg' => 'bg-orange-500', 'shadow' => 'shadow-orange-200', 'text' => 'text-orange-500', 'border' => 'border-orange-500' ],
                                                        3 => [ 'bg' => 'bg-amber-400', 'shadow' => 'shadow-amber-100', 'text' => 'text-amber-500', 'border' => 'border-amber-400' ],
                                                        4 => [ 'bg' => 'bg-lime-500', 'shadow' => 'shadow-lime-200', 'text' => 'text-lime-500', 'border' => 'border-lime-500' ],
                                                        5 => [ 'bg' => 'bg-emerald-500', 'shadow' => 'shadow-emerald-200', 'text' => 'text-emerald-500', 'border' => 'border-emerald-500' ],
                                                        default => [ 'bg' => 'bg-blue-600', 'shadow' => 'shadow-blue-200', 'text' => 'text-blue-600', 'border' => 'border-blue-600' ],
                                                    };
                                                @endphp

                                                <label wire:key="q-{{ $question->id }}-{{ $nilai }}" class="flex flex-col items-center gap-2 cursor-pointer group">
                                                    <input type="radio" name="question-{{ $question->id }}" value="{{ $nilai }}" x-model="selected" class="sr-only">
                                                    
                                                    {{-- Box Angka dengan Efek Glow (Alpine Reactive) --}}
                                                    <div class="w-full rounded-xl border-2 py-3 md:py-2.5 text-center transition-all duration-300 ease-out text-sm md:text-base font-black"
                                                        :class="selected == {{ $nilai }} 
                                                            ? '{{ $statusWarna['bg'] }} {{ $statusWarna['shadow'] }} {{ $statusWarna['border'] }} text-white shadow-lg scale-105' 
                                                            : 'bg-slate-50 border-transparent text-slate-400 group-hover:bg-white group-hover:border-slate-200 group-hover:shadow-md group-hover:scale-105'">
                                                        {{ $nilai }}
                                                    </div>
                                                    
                                                    {{-- Label Keterangan (Alpine Reactive) --}}
                                                    <span class="text-[10px] md:text-xs font-black text-center tracking-tighter transition-all duration-300"
                                                        :class="selected == {{ $nilai }} 
                                                            ? '{{ $statusWarna['text'] }} scale-105' 
                                                            : 'text-slate-300 group-hover:text-slate-400'">
                                                        {{ ucwords(strtolower($label)) }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                        @error("answers.{$question->id}.nilai") <p class="text-[10px] text-red-500 mt-2 italic font-bold">⚠️ Mohon pilih respon Anda.</p> @enderror
                                    @else
                                        <div class="relative">
                                            <textarea wire:model="answers.{{ $question->id }}.teks" class="w-full rounded-xl border-slate-100 bg-slate-50 p-4 focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-200 transition-all outline-none text-slate-700 text-sm font-medium" rows="3" placeholder="Ketik saran atau kritik Anda di sini..."></textarea>
                                        </div>
                                        @error("answers.{$question->id}.teks") <p class="text-[10px] text-red-500 mt-2 italic font-bold">⚠️ Tanggapan belum diisi.</p> @enderror
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="flex gap-3 pt-6 border-t border-slate-50">
                            <button wire:click="goToPreviousStep" class="px-6 py-3 rounded-xl border-2 border-slate-100 text-slate-400 font-black text-xs tracking-widest hover:bg-slate-50 transition active:scale-95">Kembali</button>
                            <button wire:click="goToNextStep" class="flex-1 px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-black text-xs tracking-widest shadow-md shadow-blue-200 active:scale-95">Berikutnya</button>
                        </div>
                    </div>

                @elseif ($step === $reviewStep)
                    {{-- Halaman Review yang Cantik --}}
                    <div class="space-y-6 animate-in zoom-in-95 duration-500 text-left">
                        <div class="text-center">
                            <h3 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight">Cek Terakhir</h3>
                            <p class="text-slate-400 text-xs mt-1 tracking-[0.2em] font-bold">Pastikan semua jawaban Anda sudah sesuai sebelum diserahkan.</p>
                        </div>

                        <div class="space-y-3 max-h-[50vh] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach ($this->summaryData as $subNama => $questions)
                                <div class="bg-slate-50/80 rounded-xl p-4 border border-slate-100">
                                    <h4 class="text-xs font-black text-blue-600 tracking-widest mb-3 flex items-center gap-2">
                                        <span class="w-1.5 h-3 bg-blue-600 rounded-full"></span> {{ ucwords(strtolower($subNama)) }}
                                    </h4>
                                    <div class="space-y-2">
                                        @foreach ($questions as $item)
                                            <div class="bg-white rounded-lg p-3 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-2 border border-slate-50 text-xs">
                                                <p class="text-slate-600 font-medium w-full">{{ $item['pertanyaan'] }}</p>
                                                <span class="bg-blue-50 text-blue-700 px-2.5 py-1 rounded-md font-black shrink-0">{{ $item['jawaban'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-slate-100">
                            <button type="button" wire:click="goToPreviousStep" class="px-6 py-3 rounded-xl border-2 border-slate-100 text-slate-400 font-black text-xs tracking-widest hover:bg-slate-50 transition active:scale-95">Perbaiki</button>
                            <button type="button" wire:click="submit" wire:loading.attr="disabled" class="flex-1 px-6 py-3 rounded-xl bg-green-500 text-white font-black text-xs tracking-widest shadow-md shadow-green-100 hover:bg-green-600 transition active:scale-95">
                                <span wire:loading.remove>Kirim Kuesioner</span>
                                <span wire:loading>Mengirim...</span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

