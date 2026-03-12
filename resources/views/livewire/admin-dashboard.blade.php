<div class="py-12 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        {{-- HEADER --}}
        <div class="flex justify-between items-center text-left">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Admin Dashboard</h2>
                <p class="text-slate-500 text-sm">Manajemen Kuisioner</p>
            </div>
            <div class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                Administrator Mode
            </div>
        </div>

        {{-- STATS CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Kotak Kiri (Dinamis sesuai kategori) --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 text-left">
                <p class="text-sm text-slate-500 font-medium tracking-wide">
                    {{ $selectedKategori ? 'Responden Kategori Ini' : 'Total Seluruh Responden' }}
                </p>
                <h3 class="text-3xl font-bold text-slate-800 tracking-tight">{{ $stats['total_responden'] }}</h3>
            </div>

            {{-- KOTAK KANAN (Dinamis: Kategori -> Rata-rata Kategori -> Rata-rata Detail) --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-blue-100/50 text-left relative overflow-hidden">
                <p class="text-sm text-blue-500 font-bold tracking-wide uppercase">{{ $stats['right_label'] }}</p>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight mt-1">{{ $stats['right_value'] }}</h3>
                
                {{-- Dekorasi visual kecil jika itu adalah nilai rata-rata --}}
                @if($selectedKategori || $activeTab === 'detail_jawaban')
                    <div class="absolute -right-4 -bottom-4 opacity-5">
                        <svg class="w-24 h-24 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                @endif
            </div>
        </div>

        {{-- TABS NAVIGATION --}}
        <div class="flex space-x-1 bg-slate-200/50 p-1 rounded-xl w-fit">
            <button wire:click="switchTab('responden')" class="px-5 py-2.5 rounded-lg text-sm font-medium transition-all {{ in_array($activeTab, ['responden', 'detail_jawaban']) ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">Data Responden</button>
            <button wire:click="switchTab('pertanyaan')" class="px-5 py-2.5 rounded-lg text-sm font-medium transition-all {{ $activeTab === 'pertanyaan' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">Kelola Pertanyaan</button>
        </div>

    {{-- CONTENT AREA --}}
    <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-100 overflow-hidden min-h-[400px]">
        
        @if ($activeTab === 'responden')
            <div class="p-8">
                @if(!$selectedKategori)
                    <div class="mb-8 text-left">
                        <h3 class="text-2xl font-bold text-slate-800">Pilih Kategori Responden</h3>
                        <p class="text-slate-500 text-sm">Pilih kategori untuk melihat daftar mahasiswa yang sudah mengisi.</p>
                    </div>

                    {{-- CARD GRID LAYOUT --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl">
                        @foreach($main_cards as $cat)
                            <button wire:click="$set('selectedKategori', {{ $cat->id }})" class="group w-full p-8 rounded-[32px] border border-slate-100 hover:border-blue-200 hover:shadow-xl transition-all text-left bg-white min-h-[160px] relative overflow-hidden">
                                <div class="relative z-10">
                                    <h4 class="text-xl font-bold mb-2 group-hover:text-blue-600 transition">{{ $cat->nama_kategori }}</h4>
                                    <p class="text-slate-500 text-sm leading-relaxed">{{ $cat->deskripsi }}</p>
                                    
                                    <div class="mt-4 inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                                        {{ $cat->total_responden ?? 0 }} Responden
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                @else
                    {{-- DATA TABLE RESPONDENT --}}
                    <div class="space-y-6">
                        <div class="flex justify-between items-center mb-6">
                            <button wire:click="$set('selectedKategori', null)" class="px-6 py-2 rounded-2xl bg-slate-100 text-slate-600 font-semibold hover:bg-slate-200 transition">← Kembali ke Pilihan</button>
                            <h3 class="text-lg font-bold text-slate-800 uppercase tracking-widest text-[10px]">Kategori: {{ $activeCategory->nama_kategori }}</h3>
                        </div>

                        {{-- DROPDOWN FILTER DOSEN --}}
                        @if($activeCategory && $activeCategory->slug === 'dosen')
                            <div class="mb-6 max-w-sm text-left">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Filter Berdasarkan Dosen</label>
                                <select wire:model.live="filterDosen" class="w-full rounded-2xl border-slate-100 bg-white p-4 text-sm focus:ring-4 focus:ring-blue-500/10 transition-all shadow-sm">
                                    <option value="">Semua Dosen</option>
                                    @foreach($listDosens as $dsn)
                                        <option value="{{ $dsn->id }}">{{ $dsn->nama }} ({{ $dsn->nip }})</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="bg-white rounded-[2rem] border border-slate-100 overflow-hidden shadow-sm">
                            <table class="w-full text-left text-sm text-slate-600">
                                <thead class="bg-slate-50 text-xs uppercase text-slate-500 font-bold">
                                    <tr>
                                        <th class="px-8 py-5">Nama Responden</th>
                                        @if($activeCategory && $activeCategory->slug === 'dosen')
                                            <th class="px-8 py-5">Dosen yang Dinilai</th>
                                        @endif
                                        <th class="px-8 py-5 text-right font-bold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($respondents as $user)
                                        <tr wire:key="session-{{ $user->user_id }}-{{ $user->created_at->timestamp }}" class="hover:bg-slate-50 transition">
                                            <td class="px-8 py-5 text-left">
                                                <div class="font-bold text-slate-900">{{ $user->name }}</div>
                                                <div class="text-[9px] text-blue-500 font-bold uppercase tracking-widest mt-1">
                                                    {{ $user->status_responden }} - {{ $user->program_studi }}
                                                </div>
                                                <div class="flex items-center gap-1.5 mt-1.5">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></div>
                                                    <div class="text-[8px] text-slate-500 font-semibold uppercase tracking-tight">
                                                        {{ $user->created_at->translatedFormat('d M Y') }} • 
                                                        {{ $user->created_at->format('H:i') }} WIB 
                                                        <span class="text-slate-400 font-medium lowercase">
                                                            ({{ $user->created_at->diffForHumans() }})
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            @if($activeCategory && $activeCategory->slug === 'dosen')
                                                <td class="px-8 py-5 text-left">
                                                    <div class="font-bold text-blue-600 text-xs">{{ $user->nama_dosen ?? '-' }}</div>
                                                    <div class="text-[9px] text-slate-400 mt-0.5 uppercase tracking-widest font-bold">NIP: {{ $user->nip_dosen ?? '-' }}</div>
                                                </td>
                                            @endif
                                            <td class="px-8 py-5 text-right flex justify-end items-center gap-6">
                                                {{-- NILAI RATA-RATA DI SEBELAH KIRI TOMBOL --}}
                                                <div class="flex flex-col items-end">
                                                    <span class="text-lg font-black text-blue-600 leading-none">
                                                        {{ number_format($user->rata_rata_nilai ?? 0, 1) }}
                                                    </span>
                                                    <span class="text-[7px] font-bold text-slate-400 uppercase tracking-tighter mt-1">RATA-RATA</span>
                                                </div>

                                                {{-- TOMBOL AKSI YANG SUDAH ADA --}}
                                                <div class="flex gap-2">
                                                    <button wire:click="viewDetailJawaban({{ $user->user_id }}, {{ $user->category_id }}, '{{ $user->created_at }}')" 
                                                            class="text-blue-500 text-[10px] font-bold border border-blue-100 px-4 py-2 rounded-xl hover:bg-blue-50 transition uppercase">
                                                        Lihat Detail
                                                    </button>
                                                    <button type="button" 
                                                            onclick="confirmDelete('responden', '{{ $user->user_id }}', '{{ $user->name }}', '{{ $user->category_id }}', '{{ $user->created_at }}')"
                                                            class="text-red-500 text-[10px] font-bold border border-red-100 px-4 py-2 rounded-xl hover:bg-red-50 transition uppercase">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="{{ $activeCategory && $activeCategory->slug === 'dosen' ? 3 : 2 }}" class="px-8 py-12 text-center text-slate-400 italic">Belum ada responden.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

        @elseif ($activeTab === 'detail_jawaban')
            {{-- DETAIL JAWABAN SECTION --}}
            <div class="p-8 space-y-8">
                <div class="flex justify-between items-center text-left">
                    <button wire:click="$set('activeTab', 'responden')" class="text-slate-400 font-bold text-[10px] uppercase tracking-[3px] hover:text-blue-600 transition">
                        ← KEMBALI KE DAFTAR
                    </button>
                    <div class="text-right text-left">
                        <h3 class="text-2xl font-bold text-slate-800">{{ $userTerpilih->name ?? 'Administrator' }}</h3>
                        <p class="text-xs text-slate-400 uppercase tracking-widest font-semibold mt-1">DETAIL JAWABAN KUESIONER</p>
                    </div>
                </div>

                @php 
                    $firstGroup = !empty($detailJawaban) ? collect($detailJawaban)->first() : null;
                    $firstEntry = $firstGroup ? collect($firstGroup)->first() : null;
                @endphp

                @if($firstEntry)
                    <div class="bg-blue-50/50 rounded-3xl p-8 border border-blue-100/50">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left items-start">
                            
                            {{-- KOLOM 1: Nama & Jenis Kelamin --}}
                            <div class="space-y-6">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nama Responden</p>
                                    <p class="font-bold text-slate-700 text-sm">{{ $userTerpilih->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Jenis Kelamin</p>
                                    <p class="font-bold text-slate-700 text-sm">{{ $firstEntry->gender ?? '-' }}</p>
                                </div>
                            </div>

                            {{-- KOLOM 2: Jurusan & Angkatan --}}
                            <div class="space-y-6">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Status / Jurusan</p>
                                    <p class="font-bold text-slate-700 text-sm capitalize">{{ $firstEntry->status_responden ?? '-' }} - {{ $firstEntry->program_studi ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Angkatan</p>
                                    <p class="font-bold text-slate-700 text-sm">{{ $firstEntry->angkatan ?? '-' }}</p>
                                </div>
                            </div>

                            {{-- KOLOM 3: NILAI RATA-RATA (SEBELAH KANAN SENDIRI) --}}
                            <div class="bg-white p-6 rounded-2xl border border-blue-100 shadow-sm flex flex-col items-center justify-center text-center">
                                <p class="text-[10px] font-bold text-blue-500 uppercase tracking-[3px] mb-2">Rata-Rata Skor</p>
                                
                                <h4 class="text-4xl font-black text-blue-600 tracking-tighter">
                                    {{ $averageScore }}
                                </h4>

                                @php
                                    $keterangan = match(true) {
                                        $averageScore >= 4.5 => 'Sangat Memuaskan',
                                        $averageScore >= 3.5 => 'Memuaskan',
                                        $averageScore >= 2.5 => 'Cukup',
                                        default => 'Perlu Evaluasi'
                                    };
                                @endphp
                                <div class="mt-2 px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-[9px] font-bold uppercase tracking-widest">
                                    {{ $keterangan }}
                                </div>
                            </div>
                        </div>

                        {{-- INFO DOSEN --}}
                        @if($activeCategory && $activeCategory->slug === 'dosen')
                            <div class="mt-8 pt-6 border-t border-blue-100/50">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 text-blue-500 text-left">Dosen Yang Dinilai</p>
                                <div class="flex items-center gap-2">
                                    <p class="font-bold text-slate-700 text-sm">
                                        {{ $firstEntry->nama_dosen ?? ($firstEntry->dosen->nama ?? 'Data Dosen Tidak Ditemukan') }}
                                    </p>
                                    <span class="text-slate-300">|</span>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">
                                        NIP: {{ $firstEntry->nip_dosen ?? ($firstEntry->dosen->nip ?? '-') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                @forelse($detailJawaban as $namaKategori => $groupJawaban)
                    <div class="bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden shadow-sm text-left">
                        <div class="bg-slate-50/50 px-10 py-5 border-b border-slate-100">
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-[4px]">{{ $namaKategori }}</span>
                        </div>
                        <table class="w-full text-sm">
                            <tbody class="divide-y divide-slate-50">
                                @foreach($groupJawaban as $j)
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-10 py-6 text-slate-600 w-2/3 text-left">
                                            <p class="font-bold text-slate-800 leading-relaxed">{{ $j->question->teks_pertanyaan }}</p>
                                            <p class="text-[9px] text-slate-400 mt-1 uppercase font-bold tracking-widest">{{ $j->question->subCategory->nama_sub }}</p>
                                        </td>
                                        <td class="px-10 py-6 text-right">
                                            @if($j->nilai_jawaban)
                                                <div class="inline-flex flex-col items-center">
                                                    <span class="text-xl font-black text-blue-600">{{ $j->nilai_jawaban }}</span>
                                                    <span class="text-[8px] uppercase font-bold text-slate-400 tracking-tighter">SKALA LIKERT</span>
                                                </div>
                                            @else
                                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-left max-w-xs ml-auto">
                                                    <p class="text-slate-600 italic text-xs leading-relaxed">"{{ $j->teks_jawaban }}"</p>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <div class="text-center py-20 bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200">
                        <p class="text-slate-400 italic font-medium">Data jawaban tidak ditemukan untuk kategori ini.</p>
                    </div>
                @endforelse
            </div>

        @elseif ($activeTab === 'pertanyaan')
            {{-- MANAGE QUESTIONS SECTION --}}
            <div class="p-8">
                @if(!$selectedKategori)
                    <div class="flex justify-between items-center mb-8 text-left">
                        <div>
                            <h3 class="text-2xl font-bold text-slate-800">Pilih Kategori Utama</h3>
                            <p class="text-slate-500 text-sm">Kelola kategori kuesioner Anda di sini.</p>
                        </div>
                        <button wire:click="openModal('kategori')" class="px-6 py-2 bg-blue-600 text-white text-[10px] font-bold rounded-2xl uppercase"><span>+</span> Kategori Utama</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl">
                        @foreach($main_cards as $cat)
                            <div class="relative group" wire:key="cat-card-{{ $cat->id }}">
                                <div class="absolute top-4 right-4 flex gap-2">
                                    <button wire:click="openModal('kategori', {{ $cat->id }})" class="p-2 bg-amber-50 text-amber-600 rounded-lg border border-amber-100 hover:bg-amber-600 hover:text-white transition shadow-sm z-20 text-[10px] font-bold uppercase">Edit</button>
                                    <button type="button" 
                                        onclick="confirmDelete('kategori', '{{ $cat->id }}', '{{ $cat->nama_kategori }}')" 
                                        class="p-2 bg-red-50 text-red-600 rounded-lg border border-red-100 hover:bg-red-600 hover:text-white transition shadow-sm z-20 text-[10px] font-bold uppercase">
                                        Hapus
                                    </button>
                                </div>
                                <button wire:click="$set('selectedKategori', {{ $cat->id }})" class="w-full p-8 rounded-[32px] border border-slate-100 hover:border-blue-200 hover:shadow-xl transition-all text-left bg-white min-h-[160px]">
                                    <h4 class="text-xl font-bold mb-2 group-hover:text-blue-600 transition">{{ $cat->nama_kategori }}</h4>
                                    <p class="text-slate-500 text-sm leading-relaxed">{{ $cat->deskripsi }}</p>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- SUB CATEGORIES & QUESTIONS LIST --}}
                    <div class="space-y-6 text-left">
                        <div class="flex justify-between items-center mb-6">
                            <button wire:click="$set('selectedKategori', null)" class="px-6 py-2 rounded-2xl bg-slate-100 text-slate-600 font-semibold hover:bg-slate-200 transition">← Kembali</button>
                            <button wire:click="openModal('sub')" class="px-6 py-2 rounded-2xl bg-blue-600 text-white font-semibold shadow-lg shadow-blue-200 hover:bg-blue-700 transition">+ Tambah Sub-Pertanyaan</button>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100 flex justify-between items-center">
                                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Sub-Pertanyaan</span>
                                <span class="text-xl font-black text-blue-700">{{ $activeCategory->subCategories->count() }}</span>
                            </div>
                            <div class="bg-indigo-50/50 p-4 rounded-2xl border border-indigo-100 flex justify-between items-center">
                                <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">Total Butir Soal</span>
                                <span class="text-xl font-black text-indigo-700">{{ $activeCategory->subCategories->flatMap->questions->count() }}</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 uppercase tracking-tight mb-8">{{ $activeCategory->nama_kategori }}</h3>
                        @foreach($activeCategory->subCategories as $sub)
                            <div wire:key="sub-box-{{ $sub->id }}" class="bg-white border-2 border-slate-100 rounded-[32px] overflow-hidden shadow-sm mb-10 text-left">
                                <div class="bg-slate-50/50 px-8 py-6 border-b border-slate-100 flex justify-between items-center">
                                    <div>
                                        <h4 class="font-bold text-slate-800 uppercase text-sm flex items-center gap-3">
                                            {{ $sub->nama_sub }}
                                            <div class="flex gap-2">
                                                <button wire:click="openModal('sub', {{ $sub->id }})" class="text-blue-500 text-[10px] font-bold uppercase hover:underline">Edit</button>
                                                <button type="button" onclick="confirmDelete('sub', '{{ $sub->id }}', '{{ $sub->nama_sub }}')" class="text-red-500 text-[10px] font-bold uppercase hover:underline">Hapus</button>
                                            </div>
                                        </h4>
                                        <p class="text-[10px] text-slate-400 mt-1 italic">{{ $sub->deskripsi_sub }}</p>
                                    </div>
                                    <button wire:click="openModal('pertanyaan', null, {{ $sub->id }})" class="px-5 py-2 bg-blue-600 text-white text-[10px] font-bold rounded-xl uppercase">+ Tambah Soal</button>
                                </div>
                                <table class="w-full text-left text-sm text-slate-600">
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($sub->questions as $index => $q)
                                            <tr wire:key="q-row-{{ $q->id }}" class="hover:bg-slate-50 transition">
                                                <td class="px-8 py-4 w-12 text-slate-300 font-mono text-xs">{{ $index + 1 }}</td>
                                                <td class="px-4 py-4">
                                                    <div class="font-medium text-slate-700 leading-relaxed">{{ $q->teks_pertanyaan }}</div>
                                                    <div class="text-[9px] font-bold text-blue-400 uppercase mt-1 tracking-widest uppercase">TIPE: {{ $q->tipe_jawaban }}</div>
                                                </td>
                                                <td class="px-8 py-4 text-right w-48">
                                                    <div class="flex justify-end gap-2">
                                                        <button wire:click="openModal('pertanyaan', {{ $q->id }})" class="px-3 py-1.5 bg-amber-50 text-amber-600 rounded-lg text-[10px] font-bold uppercase transition hover:bg-amber-600 hover:text-white">Edit</button>
                                                        <button type="button" onclick="confirmDelete('pertanyaan', '{{ $q->id }}', 'Butir soal nomor {{ $index + 1 }}')" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-[10px] font-bold uppercase transition hover:bg-red-600 hover:text-white">Hapus</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

{{-- MODAL FORMULIR --}}
@if($showModal)
    <div class="fixed inset-0 z-[999] flex items-center justify-center bg-black/40 backdrop-blur-sm p-6 transition-all">
        <div class="bg-white rounded-[40px] shadow-2xl w-full max-w-4xl overflow-hidden border border-slate-100 animate-in zoom-in duration-200">
            <div class="bg-slate-50/50 px-12 py-8 border-b border-slate-100 flex justify-between items-center text-left">
                <div class="space-y-1">
                    <h3 class="font-bold text-2xl text-slate-800 tracking-tight">
                        {{ $isEdit ? 'Edit' : 'Tambah' }} 
                        @if($modalType == 'kategori') Kategori 
                        @elseif($modalType == 'sub') Sub-Pertanyaan 
                        @else Pertanyaan @endif
                    </h3>
                    <p class="text-[10px] text-slate-400 uppercase tracking-[3px] font-bold">Struktur Tabel Terpisah</p>
                </div>
                <button wire:click="closeModal" class="text-slate-300 hover:text-red-500 text-4xl leading-none">&times;</button>
            </div>
            
            <div class="p-12 space-y-8 text-left">
                @if($modalType == 'kategori' || $modalType == 'sub')
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">{{ $modalType == 'kategori' ? 'Nama Kategori Utama' : 'Nama Sub-Pertanyaan' }}</label>
                            <input type="text" wire:model="nama_kategori" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 py-4 px-6 text-[15px]" placeholder="Masukkan nama...">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Deskripsi Informasi</label>
                            <textarea wire:model="deskripsi" rows="4" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 py-4 px-6 text-[15px] leading-relaxed" placeholder="Berikan penjelasan..."></textarea>
                        </div>
                    </div>
                @else
                    <div class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">ID Sub-Kategori (Otomatis)</label>
                                <input type="text" wire:model="sub_category_id" disabled class="w-full rounded-2xl border-slate-200 bg-slate-100/50 py-4 px-6 text-[14px] cursor-not-allowed font-bold opacity-70">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Tipe Penilaian</label>
                                <select wire:model="tipe_jawaban" class="w-full rounded-2xl border-slate-200 bg-slate-50 py-4 px-6 text-[14px]">
                                    <option value="likert">Skala Likert (1-5)</option>
                                    <option value="text">Teks Bebas (Saran)</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1 group-focus-within:text-blue-500 transition-colors">Teks Pertanyaan</label>
                            <textarea wire:model="teks_pertanyaan" rows="5" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 py-5 px-6 text-[15px] leading-relaxed" placeholder="Tuliskan isi soal..."></textarea>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="bg-slate-50/50 px-12 py-10 flex justify-end gap-6 border-t border-slate-100">
                <button wire:click="closeModal" class="px-8 py-3 text-slate-400 text-xs font-bold uppercase tracking-[3px] hover:text-slate-700 transition-all">Batal</button>
                <button wire:click="save" class="px-12 py-4 rounded-2xl bg-blue-600 text-white text-xs font-bold uppercase tracking-[3px] shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all active:scale-95">
                    {{ $isEdit ? 'SIMPAN PERUBAHAN' : 'SELESAIKAN & SIMPAN' }}
                </button>
            </div>
        </div>
    </div>
@endif
 </div> {{-- Penutup Area Konten --}}
</div> {{-- Penutup Container Utama --}}

<script>
    function confirmDelete(type, id, name, categoryId = null, createdAt = null) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus " + name + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-[2rem]'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Memanggil fungsi di Controller AdminDashboard.php
                if (type === 'responden') {
                    @this.call('deleteResponden', id, categoryId, createdAt);
                } else if (type === 'kategori') {
                    @this.call('deleteKategori', id);
                } else if (type === 'sub') {
                    @this.call('deleteSub', id);
                } else if (type === 'pertanyaan') {
                    @this.call('deletePertanyaan', id);
                }
            }
        });
    }
</script>