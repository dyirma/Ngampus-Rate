<div class="min-h-screen">
    {{-- Custom Header Dalam Livewire --}}
    <div class="w-full sticky top-0 z-50 bg-white/80 shadow-sm border-b border-white/50 mb-12 backdrop-blur-sm transition-all">
        <div class="w-full mx-auto py-5 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
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

            {{-- Bagian Kanan: Navigasi Horizontal --}}
            <div class="flex items-center gap-6">
                <nav class="hidden md:flex items-center gap-6 text-[13px] font-semibold text-slate-600">
                    <a href="{{ route('dashboard') }}" class="transition hover:text-blue-600">Dashboard</a>
                    <button wire:click="switchTab('pengguna')" class="transition {{ $activeTab === 'pengguna' ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }}">Data Pengguna</button>
                    <button wire:click="switchTab('pertanyaan')" class="transition {{ $activeTab === 'pertanyaan' ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }}">Kelola Pertanyaan</button>
                    <button wire:click="switchTab('hasil')" class="transition {{ $activeTab === 'hasil' ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }}">Hasil Kuesioner</button>
                </nav>

                {{-- Input Periode Aktif --}}
                <div class="hidden lg:flex items-center gap-2 border-l border-slate-200 pl-4">
                    <div class="flex flex-col">
                        <label class="text-[10px] font-bold text-slate-400 tracking-wide mb-0.5">Periode Aktif</label>
                        <div class="flex items-center gap-1.5">
                            <input type="text" wire:model="global_periode" placeholder="Contoh: 2026" class="w-24 py-1 px-3 text-xs font-bold border border-slate-200 rounded-xl text-slate-700 bg-slate-50 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                            <button wire:click="saveGlobalPeriode" class="px-3 py-1 bg-blue-600 text-white text-[10px] font-bold rounded-xl hover:bg-blue-700 transition-all active:scale-95 shadow-sm shadow-blue-200">Set</button>
                        </div>
                    </div>
                </div>

                {{-- Dropdown Profile --}}
                <div class="hidden sm:flex sm:items-center">
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
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-3 py-3 !text-slate-600 transition hover:!bg-slate-50 hover:!text-slate-900 border-b border-slate-100">
                                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span class="font-semibold text-sm">Profile</span>
                            </x-dropdown-link>

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
        </div>
    </div>

    {{-- KONTEN BAWAH --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-12">

        {{-- STATS CARDS (Hanya tampil di tab Hasil) --}}
        @if($activeTab === 'hasil')
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
                <p class="text-sm text-blue-500 font-bold tracking-wide">{{ $stats['right_label'] }}</p>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight mt-1">{{ $stats['right_value'] }}</h3>
                
                {{-- Dekorasi visual kecil jika itu adalah nilai rata-rata --}}
                @if($selectedKategori || $activeTab === 'detail_jawaban')
                    <div class="absolute -right-4 -bottom-4 opacity-5">
                        <svg class="w-24 h-24 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                @endif
            </div>
        </div>
        @endif



    {{-- CONTENT AREA --}}
    <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-100 overflow-hidden min-h-[400px]">
        
        @if ($activeTab === 'pengguna')
            <div class="p-8">
                <div class="flex justify-between items-center mb-8 text-left">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-800">Daftar Pegawai (Responden)</h3>
                        <p class="text-slate-500 text-sm">Daftar dosen dan tenaga kependidikan yang terdaftar pada sistem.</p>
                    </div>
                    <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
                        <div class="relative w-full md:w-64">
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau NIK..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500">
                            <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <button wire:click="openModal('import_csv')" class="px-5 py-2.5 bg-emerald-50 text-emerald-600 border border-emerald-200 hover:bg-emerald-600 hover:text-white transition rounded-2xl text-xs font-bold w-full md:w-auto shadow-sm whitespace-nowrap">
                            <svg class="w-4 h-4 inline-block mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg> Import Excel
                        </button>
                        <button wire:click="openModal('pengguna')" class="px-5 py-2.5 bg-transparent text-blue-600 border border-blue-200 hover:bg-blue-600 hover:text-white transition rounded-2xl text-xs font-bold shadow-sm w-full md:w-auto whitespace-nowrap"><span>+</span> Tambah Pegawai</button>
                    </div>
                </div>
                <div class="bg-white rounded-[2rem] border border-slate-100 overflow-hidden shadow-sm">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-500 font-bold">
                            <tr>
                                <th class="px-8 py-5">Nama / NIK</th>
                                <th class="px-8 py-5">Status / Unit Kerja</th>
                                <th class="px-8 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($usersList as $user)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-8 py-5 text-left">
                                        <div class="font-bold text-slate-900">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-500 font-bold tracking-widest mt-1">NIK: {{ $user->nip ?? '-' }}</div>
                                    </td>
                                    <td class="px-8 py-5 text-left">
                                        <div class="font-bold text-blue-600 text-xs">{{ $user->tipe_pegawai ?? '-' }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5 tracking-widest font-bold">{{ $user->unit_kerja ?? '-' }} - {{ $user->jabatan ?? '-' }}</div>
                                    </td>
                                    <td class="px-8 py-5 text-right flex justify-end items-center gap-2">
                                        <button wire:click="openModal('pengguna', {{ $user->id }})" class="p-2 bg-amber-50 text-amber-600 rounded-lg border border-amber-100 hover:bg-amber-600 hover:text-white transition shadow-sm z-20 text-xs font-bold">Edit</button>
                                        <button type="button" 
                                                onclick="confirmDelete('pengguna', '{{ $user->id }}', '{{ $user->name }}')"
                                                class="text-red-500 text-xs font-bold border border-red-100 px-4 py-2 rounded-xl hover:bg-red-50 transition">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-8 py-12 text-center text-slate-400 italic">Belum ada pengguna.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="p-4">
                        {{ $usersList->links() }}
                    </div>
                </div>
            </div>

        @elseif ($activeTab === 'hasil')
            <div class="p-8 space-y-8">
                @if(!$selectedKategori)
                    <div class="mb-8 text-left">
                        <h3 class="text-2xl font-bold text-slate-800">Hasil Kuesioner (Anonim)</h3>
                        <p class="text-slate-500 text-sm">Pilih kategori untuk melihat agregasi hasil kuesioner.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl">
                        @foreach($main_cards as $cat)
                            <button wire:click="$set('selectedKategori', {{ $cat->id }})" class="group w-full p-8 rounded-[32px] border border-slate-100 hover:border-blue-200 hover:shadow-xl transition-all text-left bg-white min-h-[160px] relative overflow-hidden">
                                <div class="relative z-10">
                                    <h4 class="text-xl font-bold mb-2 group-hover:text-blue-600 transition">{{ $cat->nama_kategori }}</h4>
                                    <p class="text-slate-500 text-sm leading-relaxed">{{ $cat->deskripsi }}</p>
                                </div>
                            </button>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 text-left">
                        <div class="flex flex-col gap-2">
                            <button wire:click="$set('selectedKategori', null)" class="w-fit text-slate-400 font-bold text-xs tracking-[3px] hover:text-blue-600 transition flex items-center gap-1">
                                <span>←</span> Kembali ke Daftar
                            </button>
                            <div>
                                <h3 class="text-2xl font-bold text-slate-800">{{ $activeCategory->nama_kategori }}</h3>
                                <p class="text-xs text-slate-400 tracking-widest font-semibold mt-1">Laporan Hasil Kuesioner</p>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row items-center gap-2 bg-slate-50 p-2 rounded-3xl border border-slate-100">
                            <input type="text" wire:model.live="selectedPeriode" placeholder="Filter Periode (Cth: 2026)" class="w-full md:w-36 py-2 px-4 rounded-2xl border-slate-200 text-xs font-bold text-slate-700 bg-white focus:ring-2 focus:ring-emerald-500">
                            <a href="{{ route('admin.export.hasil', ['category' => $selectedKategori, 'periode' => $selectedPeriode]) }}" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-2xl shadow transition flex items-center justify-center gap-2 w-full md:w-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                UNDUH HASIL
                            </a>
                        </div>
                    </div>

                    {{-- TABS: Ringkasan Grafis vs Detail Responden --}}
                    <div class="flex gap-4 border-b border-slate-200 mb-8">
                        <button wire:click="$set('hasilTab', 'ringkasan')" class="px-6 py-3 font-bold text-sm border-b-2 transition-all {{ $hasilTab === 'ringkasan' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-400 hover:text-slate-600' }}">Ringkasan Grafis</button>
                        <button wire:click="$set('hasilTab', 'detail')" class="px-6 py-3 font-bold text-sm border-b-2 transition-all {{ $hasilTab === 'detail' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-400 hover:text-slate-600' }}">Detail Responden</button>
                    </div>

                    @if($hasilTab === 'ringkasan')
                        @forelse($detailHasil as $namaKategori => $groupJawaban)
                            <div class="bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden shadow-sm text-left mb-6">
                                <div class="bg-slate-50/50 px-10 py-5 border-b border-slate-100">
                                    <span class="text-xs font-bold text-blue-600 tracking-[4px]">{{ ucwords(strtolower($namaKategori)) }}</span>
                                </div>
                                <table class="w-full text-sm">
                                    <tbody class="divide-y divide-slate-50">
                                        @foreach($groupJawaban as $j)
                                            <tr class="hover:bg-slate-50/30 transition">
                                                <td class="px-10 py-6 text-slate-600 w-2/3 text-left">
                                                    <p class="font-bold text-slate-800 leading-relaxed">{{ $j['pertanyaan'] }}</p>
                                                </td>
                                                <td class="px-10 py-6 text-right w-1/3">
                                                    @if($j['tipe'] === 'likert')
                                                        <div class="flex flex-col lg:flex-row items-end lg:items-center gap-6 justify-end">
                                                            <div class="w-40 h-24 relative" wire:ignore x-data="{
                                                                initChart() {
                                                                    const ctx = this.$refs.canvas.getContext('2d');
                                                                    new Chart(ctx, {
                                                                        type: 'bar',
                                                                        data: {
                                                                            labels: ['1', '2', '3', '4', '5'],
                                                                            datasets: [{
                                                                                label: 'Jawaban',
                                                                                data: {{ json_encode($j['distribusi'] ?? []) }},
                                                                                backgroundColor: 'rgba(37, 99, 235, 0.8)',
                                                                                borderRadius: 4
                                                                            }]
                                                                        },
                                                                        options: {
                                                                            responsive: true,
                                                                            maintainAspectRatio: false,
                                                                            plugins: { legend: { display: false } },
                                                                            scales: {
                                                                                y: { display: false, beginAtZero: true },
                                                                                x: { grid: { display: false } }
                                                                            }
                                                                        }
                                                                    });
                                                                }
                                                            }" x-init="initChart()">
                                                                <canvas x-ref="canvas"></canvas>
                                                            </div>
                                                            <div class="inline-flex flex-col items-center">
                                                                <span class="text-xl font-black text-blue-600 block w-12 text-center bg-blue-50 py-1 rounded-lg">{{ $j['hasil'] }}</span>
                                                                <span class="text-xs font-bold text-slate-400 tracking-tighter mt-1">Rata-rata</span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-left max-w-sm ml-auto text-xs max-h-40 overflow-y-auto">
                                                            @if(empty($j['hasil']))
                                                                <p class="text-slate-400 italic">Belum ada saran/masukan.</p>
                                                            @else
                                                                <ul class="list-disc pl-4 space-y-2">
                                                                    @foreach($j['hasil'] as $komen)
                                                                        <li>{{ $komen }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
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

                    @elseif($hasilTab === 'detail')
                        <div class="bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden shadow-sm text-left mb-6">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm whitespace-nowrap">
                                    <thead class="bg-slate-50 border-b border-slate-100 text-xs text-slate-500 uppercase tracking-wider font-bold">
                                        <tr>
                                            <th class="px-6 py-4 text-left">Responden</th>
                                            <th class="px-6 py-4 text-left">Waktu Submit</th>
                                            @foreach($activeCategory->subCategories as $sub)
                                                @foreach($sub->questions as $q)
                                                    <th class="px-6 py-4 text-left" title="{{ $q->teks_pertanyaan }}">
                                                        Q_{{ $loop->parent->iteration }}_{{ $loop->iteration }}
                                                    </th>
                                                @endforeach
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        @forelse($rawData as $row)
                                            <tr class="hover:bg-slate-50/50 transition">
                                                <td class="px-6 py-4 font-bold text-slate-700">{{ $row['responden'] }}</td>
                                                <td class="px-6 py-4 text-slate-500">{{ $row['waktu'] }}</td>
                                                @foreach($activeCategory->subCategories as $sub)
                                                    @foreach($sub->questions as $q)
                                                        <td class="px-6 py-4 text-slate-600">
                                                            @if($q->tipe_jawaban == 'likert')
                                                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded font-bold">{{ $row['jawaban'][$q->id] ?? '-' }}</span>
                                                            @else
                                                                <span class="truncate inline-block max-w-[200px]" title="{{ $row['jawaban'][$q->id] ?? '-' }}">
                                                                    {{ $row['jawaban'][$q->id] ?? '-' }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%" class="px-6 py-10 text-center text-slate-400 italic">Belum ada data respons.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                @endif
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
                        <button wire:click="openModal('kategori')" class="px-6 py-2 bg-blue-600 text-white text-xs font-bold rounded-2xl"><span>+</span> Kategori Utama</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl">
                        @foreach($main_cards as $cat)
                            <div class="relative group" wire:key="cat-card-{{ $cat->id }}">
                                <div class="absolute top-4 right-4 flex gap-2">
                                    <button wire:click="openModal('kategori', {{ $cat->id }})" class="p-2 bg-amber-50 text-amber-600 rounded-lg border border-amber-100 hover:bg-amber-600 hover:text-white transition shadow-sm z-20 text-xs font-bold">Edit</button>
                                    <button type="button" 
                                        onclick="confirmDelete('kategori', '{{ $cat->id }}', '{{ $cat->nama_kategori }}')" 
                                        class="p-2 bg-red-50 text-red-600 rounded-lg border border-red-100 hover:bg-red-600 hover:text-white transition shadow-sm z-20 text-xs font-bold">
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
                            <button wire:click="$set('selectedKategori', null)" class="text-slate-400 font-bold text-xs tracking-[3px] hover:text-blue-600 transition flex items-center gap-1">
                                <span>←</span> Kembali ke Daftar
                            </button>
                            <button wire:click="openModal('sub')" class="px-6 py-2 rounded-2xl bg-blue-600 text-white font-semibold shadow-lg shadow-blue-200 hover:bg-blue-700 transition">
                                + Tambah Sub-Pertanyaan
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100 flex justify-between items-center">
                                <span class="text-xs font-bold text-blue-600 tracking-widest">Sub-Pertanyaan</span>
                                <span class="text-xl font-black text-blue-700">{{ $activeCategory->subCategories->count() }}</span>
                            </div>
                            <div class="bg-indigo-50/50 p-4 rounded-2xl border border-indigo-100 flex justify-between items-center">
                                <span class="text-xs font-bold text-indigo-600 tracking-widest">Total Butir Soal</span>
                                <span class="text-xl font-black text-indigo-700">{{ $activeCategory->subCategories->flatMap->questions->count() }}</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 tracking-tight mb-8">{{ $activeCategory->nama_kategori }}</h3>
                        @foreach($activeCategory->subCategories as $sub)
                            <div wire:key="sub-box-{{ $sub->id }}" class="bg-white border-2 border-slate-100 rounded-[32px] overflow-hidden shadow-sm mb-10 text-left">
                                <div class="bg-slate-50/50 px-8 py-6 border-b border-slate-100 flex justify-between items-center">
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm flex items-center gap-3">
                                            {{ $sub->nama_sub }}
                                            <div class="flex gap-2">
                                                <button wire:click="openModal('sub', {{ $sub->id }})" class="text-blue-500 text-xs font-bold hover:underline">Edit</button>
                                                <button type="button" onclick="confirmDelete('sub', '{{ $sub->id }}', '{{ $sub->nama_sub }}')" class="text-red-500 text-xs font-bold hover:underline">Hapus</button>
                                            </div>
                                        </h4>
                                        <p class="text-xs text-slate-400 mt-1 italic">{{ $sub->deskripsi_sub }}</p>
                                    </div>
                                    <button wire:click="openModal('pertanyaan', null, {{ $sub->id }})" class="px-5 py-2 bg-blue-600 text-white text-xs font-bold rounded-xl">+ Tambah Soal</button>
                                </div>
                                <table class="w-full text-left text-sm text-slate-600">
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($sub->questions as $index => $q)
                                            <tr wire:key="q-row-{{ $q->id }}" class="hover:bg-slate-50 transition">
                                                <td class="px-8 py-4 w-12 text-slate-300 font-mono text-xs">{{ $index + 1 }}</td>
                                                <td class="px-4 py-4">
                                                    <div class="font-medium text-slate-700 leading-relaxed">{{ $q->teks_pertanyaan }}</div>
                                                    <div class="text-xs font-bold text-blue-400 mt-1 tracking-widest">Tipe: {{ ucwords(strtolower($q->tipe_jawaban)) }}</div>
                                                </td>
                                                <td class="px-8 py-4 text-right w-48">
                                                    <div class="flex justify-end gap-2">
                                                        <button wire:click="openModal('pertanyaan', {{ $q->id }})" class="px-3 py-1.5 bg-amber-50 text-amber-600 rounded-lg text-xs font-bold transition hover:bg-amber-600 hover:text-white">Edit</button>
                                                        <button type="button" onclick="confirmDelete('pertanyaan', '{{ $q->id }}', 'Butir soal nomor {{ $index + 1 }}')" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-bold transition hover:bg-red-600 hover:text-white">Hapus</button>
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
    <div class="fixed inset-0 z-[999] flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 md:p-6 transition-all">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-100 animate-in zoom-in duration-200">
            <div class="bg-slate-50/50 px-6 md:px-8 py-5 border-b border-slate-100 flex justify-between items-center text-left">
                <div class="space-y-1">
                    <h3 class="font-bold text-xl text-slate-800 tracking-tight">
                        {{ $isEdit ? 'Edit' : 'Tambah' }} 
                        @if($modalType == 'kategori') Kategori 
                        @elseif($modalType == 'sub') Sub-Pertanyaan 
                        @elseif($modalType == 'pengguna') Pegawai / Responden
                        @elseif($modalType == 'import_csv') Import Excel Pegawai
                        @else Pertanyaan @endif
                    </h3>
                    <p class="text-xs text-slate-400 tracking-[3px] font-bold">Struktur Tabel Terpisah</p>
                </div>
                <button wire:click="closeModal" class="text-slate-300 hover:text-red-500 text-3xl leading-none">&times;</button>
            </div>
            
            <div class="p-6 md:p-8 space-y-6 text-left max-h-[70vh] overflow-y-auto">
                @if($modalType == 'pengguna')
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 tracking-widest mb-2 ml-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="pengguna_name" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 py-3 px-4 text-sm">
                                @error('pengguna_name') <span class="text-red-500 text-xs font-bold ml-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 tracking-widest mb-2 ml-1">Alamat Email <span class="text-slate-300 font-medium text-xs">(Opsional)</span></label>
                                <input type="email" wire:model="pengguna_email" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 py-3 px-4 text-sm" placeholder="Otomatis jika dikosongkan">
                                @error('pengguna_email') <span class="text-red-500 text-xs font-bold ml-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 tracking-widest mb-2 ml-1">NIK <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="pengguna_nip" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 py-3 px-4 text-sm">
                                @error('pengguna_nip') <span class="text-red-500 text-xs font-bold ml-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 tracking-widest mb-2 ml-1">Password <span class="text-red-500">*</span></label>
                                <input type="password" wire:model="pengguna_password" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 py-3 px-4 text-sm" placeholder="{{ $isEdit ? 'Biarkan kosong bila tidak ada perubahan' : 'Minimal 8 Karakter' }}">
                                @error('pengguna_password') <span class="text-red-500 text-xs font-bold ml-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 tracking-widest mb-2 ml-1">Status <span class="text-red-500">*</span></label>
                                <select wire:model="pengguna_tipe" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 py-3 px-4 text-sm">
                                    <option value="">-- Pilih --</option>
                                    <option value="dosen">Dosen</option>
                                    <option value="tendik">Tendik</option>
                                </select>
                                @error('pengguna_tipe') <span class="text-red-500 text-xs font-bold ml-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 tracking-widest mb-2 ml-1">Jabatan <span class="text-slate-300 font-medium">(Opsional)</span></label>
                                <input type="text" wire:model="pengguna_jabatan" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 py-3 px-4 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 tracking-widest mb-2 ml-1">Fakultas/Unit <span class="text-slate-300 font-medium">(Opsional)</span></label>
                                <input type="text" wire:model="pengguna_unit" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 py-3 px-4 text-sm">
                            </div>
                        </div>
                    </div>
                @elseif($modalType == 'kategori' || $modalType == 'sub')
                    <div class="space-y-4">
                        @if($modalType == 'kategori')
                        <div>
                            <label class="block text-xs font-bold text-slate-400 tracking-widest mb-2 ml-1">Target Responden</label>
                            <select wire:model="target_role" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 py-3 px-4 text-sm">
                                <option value="semua">Semua (Dosen & Tendik)</option>
                                <option value="dosen">Khusus Dosen</option>
                                <option value="tendik">Khusus Tendik</option>
                            </select>
                        </div>
                        @endif
                        <div>
                            <label class="block text-xs font-bold text-slate-400 tracking-widest mb-2 ml-1">{{ $modalType == 'kategori' ? 'Nama Kategori Utama' : 'Nama Sub-Pertanyaan' }}</label>
                            <input type="text" wire:model="nama_kategori" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 py-3 px-4 text-sm" placeholder="Masukkan nama...">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 tracking-widest mb-2 ml-1">Deskripsi Informasi</label>
                            <textarea wire:model="deskripsi" rows="3" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 py-3 px-4 text-sm leading-relaxed" placeholder="Berikan penjelasan..."></textarea>
                        </div>
                    </div>
                @elseif($modalType == 'pertanyaan')
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 tracking-widest mb-2 ml-1">ID Sub-Kategori</label>
                                <input type="text" wire:model="sub_category_id" disabled class="w-full rounded-2xl border-slate-200 bg-slate-100/50 py-3 px-4 text-sm cursor-not-allowed font-bold opacity-70">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 tracking-widest mb-2 ml-1">Tipe Penilaian</label>
                                <select wire:model="tipe_jawaban" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 py-3 px-4 text-sm">
                                    <option value="likert">Skala Likert (1-5)</option>
                                    <option value="text">Teks Bebas (Saran)</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 tracking-widest mb-2 ml-1 group-focus-within:text-blue-500 transition-colors">Teks Pertanyaan</label>
                            <textarea wire:model="teks_pertanyaan" rows="4" class="w-full rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 py-3 px-4 text-sm leading-relaxed" placeholder="Tuliskan isi soal..."></textarea>
                        </div>
                    </div>
                @elseif($modalType == 'import_csv')
                    <div class="space-y-6">
                        <div class="bg-blue-50 text-blue-800 p-5 rounded-2xl border border-blue-100 text-sm leading-relaxed">
                            <h4 class="font-bold mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Petunjuk Format Excel
                            </h4>
                            <p class="mb-2">File Excel (*.xlsx atau *.xls) harus memiliki minimal 3 atau maksimal 4 kolom berurutan:</p>
                            <ol class="list-decimal pl-5 font-mono text-xs space-y-1 bg-white p-3 rounded-xl border border-blue-100/50 mb-3">
                                <li>NIK (contoh: 12345678)</li>
                                <li>Nama Lengkap (contoh: Budi Santoso)</li>
                                <li>Status/Tipe (contoh: dosen atau tendik)</li>
                                <li>Jabatan <span class="opacity-70">(Opsional, contoh: Lektor Kepala)</span></li>
                            </ol>
                            <p class="mt-3 text-xs opacity-80 italic">* Anda bisa langsung mengunggah file bawaan Microsoft Excel Anda ke sini.</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 tracking-widest mb-2 ml-1">Upload File Excel (.xlsx / .xls)</label>
                            <input type="file" wire:model="csv_file" accept=".xlsx,.xls,.csv" class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition border border-slate-200 rounded-2xl bg-slate-50 cursor-pointer">
                            @error('csv_file') <span class="text-red-500 text-xs font-bold ml-1 mt-1 block">{{ $message }}</span> @enderror
                            
                            <div wire:loading wire:target="csv_file" class="mt-2 text-xs font-bold text-amber-500 ml-1">Mengunggah file...</div>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="bg-slate-50/50 px-6 md:px-8 py-5 border-t border-slate-100 flex justify-end gap-4 rounded-b-3xl">
                <button wire:click="closeModal" class="px-6 py-2.5 text-slate-500 text-xs font-bold tracking-[2px] hover:text-slate-800 transition-all rounded-2xl hover:bg-slate-200/50">Batal</button>
                @if($modalType == 'import_csv')
                    <button wire:click="importExcel" class="px-8 py-2.5 rounded-2xl bg-emerald-600 text-white text-xs font-bold tracking-[2px] shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 transition-all active:scale-95" wire:loading.attr="disabled" wire:target="importExcel, csv_file">
                        <span wire:loading.remove wire:target="importExcel">Mulai Import</span>
                        <span wire:loading wire:target="importExcel">Memproses...</span>
                    </button>
                @else
                    <button wire:click="save" class="px-8 py-2.5 rounded-2xl bg-blue-600 text-white text-xs font-bold tracking-[2px] shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all active:scale-95">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Selesaikan & Simpan' }}
                    </button>
                @endif
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
                if (type === 'pengguna') {
                    @this.call('deletePengguna', id);
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