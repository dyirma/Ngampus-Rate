@php
    $questionCount = $kuisioners->count();
    $reviewStep = $questionCount + 2;
    $totalSteps = $questionCount + 3; // termasuk step 0
    $jurusanList = [
        'S1 Teknik Informatika',
        'S1 Bisnis Digital',
        'S1 Hukum Bisnis',
        'S1 Manajemen Bisnis Internasional',
        'S1 Teknologi Pangan',
        'S1 Gizi',
    ];
    $angkatanList = range(date('Y'), date('Y') - 10);
    $currentKuisioner = $this->currentKuisioner;
@endphp

<div class="bg-white rounded-3xl shadow-xl ring-1 ring-slate-100 overflow-hidden">
    {{-- Header Progress Bar --}}
    <div class="border-b border-slate-100 bg-slate-50/70 px-6 py-5 flex flex-wrap items-center gap-4">
        <div>
            <p class="text-xs uppercase tracking-[0.4em] text-blue-500">Kuisioner Multi-Step</p>
            <p class="text-lg font-semibold text-slate-800">Langkah {{ $step }} dari {{ $totalSteps - 1 }}</p>
        </div>
        <div class="flex-1">
            <div class="w-full bg-white/70 rounded-full h-2">
                <div class="h-2 rounded-full bg-gradient-to-r from-blue-600 to-sky-500 transition-all duration-500" style="width: {{ min(100, ($step / ($totalSteps - 1)) * 100) }}%"></div>
            </div>
        </div>
        <div class="text-sm text-slate-500">
            Dosen terpilih:
            <span class="font-medium text-slate-800">
                {{ optional($dosens->firstWhere('id', $dataDiri['dosen_id']))->nama ?? 'Belum dipilih' }}
            </span>
        </div>
    </div>

    <div class="p-8 space-y-8">
    {{-- STEP 0: LANDING --}}
    @if ($step === 0)
        <div class="space-y-6 text-center">
            <h3 class="text-2xl font-semibold text-slate-800">Siap untuk memulai?</h3>
            <p class="text-slate-500 leading-relaxed max-w-2xl mx-auto">
                Pastikan Anda dalam kondisi nyaman untuk mengisi kuisioner selama 5-10 menit. Klik tombol di bawah
                untuk masuk ke data diri responden, kemudian lanjutkan ke setiap kategori pertanyaan.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                    Kembali
                </a>
                <button wire:click="goToNextStep" class="px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition">
                    Mulai Kuisioner
                </button>
            </div>
        </div>

    {{-- STEP 1: DATA DIRI --}}
    @elseif ($step === 1)
        <div class="space-y-6">
            <div>
                <p class="text-sm uppercase tracking-[0.4em] text-blue-500">Step 1</p>
                <h3 class="text-2xl font-semibold text-slate-800">Data Diri Responden</h3>
                <p class="text-slate-500 mt-2">Mohon isi data diri Anda untuk melanjutkan kuisioner.</p>
            </div>
            <div class="grid md:grid-cols-2 gap-6" wire:key="step-1-form">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">Nama Lengkap</label>
                    <input type="text" wire:model.defer="dataDiri.name" class="w-full rounded-2xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                    @error('dataDiri.name') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">Jenis Kelamin</label>
                    <select wire:model.defer="dataDiri.gender" class="w-full rounded-2xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih salah satu</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    @error('dataDiri.gender') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">Status</label>
                    <select wire:model.defer="dataDiri.status_responden" class="w-full rounded-2xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih status</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="dosen">Dosen</option>
                        <option value="staf">Staf</option>
                    </select>
                    @error('dataDiri.status_responden') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">Fakultas / Jurusan</label>
                    <select wire:model.defer="dataDiri.program_studi" class="w-full rounded-2xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih program studi</option>
                        @foreach ($jurusanList as $jurusan)
                            <option value="{{ $jurusan }}">{{ $jurusan }}</option>
                        @endforeach
                    </select>
                    @error('dataDiri.program_studi') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">Angkatan</label>
                    <select wire:model.defer="dataDiri.angkatan" class="w-full rounded-2xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih tahun angkatan</option>
                        @foreach ($angkatanList as $angkatan)
                            <option value="{{ $angkatan }}">{{ $angkatan }}</option>
                        @endforeach
                    </select>
                    @error('dataDiri.angkatan') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">Pilih Dosen yang Dinilai</label>
                    <select wire:model.defer="dataDiri.dosen_id" class="w-full rounded-2xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Cari nama dosen...</option>
                        @foreach ($dosens as $dosen)
                            <option value="{{ $dosen->id }}">{{ $dosen->nama }} ({{ $dosen->nip }})</option>
                        @endforeach
                    </select>
                    @error('dataDiri.dosen_id') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="flex flex-wrap gap-4 pt-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                    Kembali
                </a>
                <button wire:click="goToNextStep" class="px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition">
                    Lanjut ke Pertanyaan
                </button>
            </div>
        </div>

    {{-- STEP 2 dst: PERTANYAAN DINAMIS --}}
    @elseif ($step > 1 && $step <= $questionCount + 1 && $currentKuisioner)
        <div class="space-y-6">
            <div>
                <p class="text-sm uppercase tracking-[0.4em] text-blue-500">Step {{ $step }}</p>
                <h3 class="text-2xl font-semibold text-slate-800">{{ $currentKuisioner->nama_kuisioner }}</h3>
                <p class="text-slate-500 mt-2">{{ $currentKuisioner->deskripsi }}</p>
            </div>
            <div class="space-y-4">
                @foreach ($currentKuisioner->pertanyaan as $pertanyaan)
                    <div wire:key="pertanyaan-{{ $pertanyaan->id }}" 
                         x-data="{ localRating: {{ data_get($answers, $pertanyaan->id.'.nilai') ?? 'null' }} }"
                         class="border border-slate-100 rounded-3xl p-6 shadow-sm">
                         
                        <p class="font-medium text-slate-800">{{ $pertanyaan->teks_pertanyaan }}</p>
                        
                        @if ($pertanyaan->tipe_jawaban === 'likert')
                            <div class="mt-4 grid grid-cols-5 gap-3">
                                @foreach ($likertLabels as $nilai => $label)
                                    <label @click="localRating = {{ $nilai }}" class="flex flex-col items-center gap-2 text-sm text-slate-500 cursor-pointer group">
                                        <input type="radio" class="sr-only" value="{{ $nilai }}" wire:model.defer="answers.{{ $pertanyaan->id }}.nilai">
                                        
                                        <div class="w-full rounded-2xl border py-3 text-center transition-all"
                                             :class="localRating == {{ $nilai }} 
                                                ? 'bg-blue-600 text-white border-blue-600 shadow-md font-semibold' 
                                                : 'bg-white border-slate-200 text-slate-600 hover:border-blue-400 group-hover:bg-blue-50'">
                                            {{ $nilai }}
                                        </div>
                                        <span class="text-xs text-center">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error("answers.{$pertanyaan->id}.nilai") <span class="text-xs text-red-500 mt-2 block">Wajib diisi</span> @enderror
                        @else
                            <textarea wire:key="text-{{ $pertanyaan->id }}" wire:model.defer="answers.{{ $pertanyaan->id }}.teks" class="mt-4 w-full rounded-2xl border-slate-200 focus:ring-blue-500 focus:border-blue-500" rows="3" placeholder="Tuliskan tanggapan Anda..."></textarea>
                            @error("answers.{$pertanyaan->id}.teks") <span class="text-xs text-red-500 mt-2 block">Wajib diisi</span> @enderror
                        @endif
                    </div>
                @endforeach
            </div>
            
            <div class="flex flex-wrap gap-4 pt-4 mt-6 border-t border-slate-50">
                <button type="button" 
                        wire:click.prevent="goToPreviousStep" 
                        wire:loading.attr="disabled"
                        class="px-6 py-3 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove target="goToPreviousStep">Sebelumnya</span>
                    <span wire:loading target="goToPreviousStep">Memuat...</span>
                </button>

                <button type="button" 
                        wire:click.prevent="goToNextStep"
                        wire:loading.attr="disabled" 
                        class="px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove target="goToNextStep">Lanjut</span>
                    <span wire:loading target="goToNextStep">Memproses...</span>
                </button>
            </div>
        </div>

    {{-- STEP TERAKHIR: REVIEW --}}
    @elseif ($step === $reviewStep)
        <div class="space-y-6">
            <div>
                <p class="text-sm uppercase tracking-[0.4em] text-blue-500">Step {{ $step }}</p>
                <h3 class="text-2xl font-semibold text-slate-800">Periksa Jawaban Anda</h3>
                <p class="text-slate-500 mt-2">Pastikan semua jawaban sudah benar sebelum mengirim kuisioner.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div class="border border-slate-100 rounded-3xl p-5">
                    <p class="text-sm uppercase tracking-[0.4em] text-blue-500 mb-3">Data Diri</p>
                    <dl class="space-y-2 text-sm text-slate-600">
                        <div>
                            <dt class="font-medium text-slate-800">Nama Lengkap</dt>
                            <dd>{{ $dataDiri['name'] }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-800">Jenis Kelamin</dt>
                            <dd>{{ $dataDiri['gender'] }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-800">Status</dt>
                            <dd>{{ ucfirst($dataDiri['status_responden']) }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-800">Program Studi</dt>
                            <dd>{{ $dataDiri['program_studi'] }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-800">Angkatan</dt>
                            <dd>{{ $dataDiri['angkatan'] }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-800">Dosen Dinilai</dt>
                            <dd>{{ optional($dosens->firstWhere('id', $dataDiri['dosen_id']))->nama }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="space-y-4 max-h-[460px] overflow-y-auto pr-2">
                @foreach ($this->summaryData as $kategori => $items)
                    <div class="border border-slate-100 rounded-3xl p-5">
                        <p class="font-semibold text-slate-800">{{ $kategori }}</p>
                        <div class="mt-3 space-y-3 text-sm text-slate-600">
                            @foreach ($items as $item)
                                <div>
                                    <p class="font-medium text-slate-700">{{ $item['pertanyaan'] }}</p>
                                    <p class="text-blue-600">{{ $item['jawaban'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex flex-wrap gap-4 pt-4">
                <button type="button" wire:click="goToPreviousStep" class="px-6 py-3 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                    Kembali &amp; Edit
                </button>
                <button type="button" wire:click="submit" class="px-6 py-3 rounded-2xl bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition">
                    Konfirmasi &amp; Kirim
                </button>
            </div>
        </div>
    @endif
</div>