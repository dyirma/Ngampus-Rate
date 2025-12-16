<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Admin Dashboard</h2>
            <p class="text-slate-500 text-sm">Panel Kontrol Kuisioner UDH</p>
        </div>
        <div class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
            Administrator Mode
        </div>
    </div>

    {{-- FLASH MESSAGE --}}
    @if (session()->has('message'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Card 1 --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Total Responden</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total_responden'] }}</h3>
                </div>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                    <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Total Pertanyaan</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total_pertanyaan'] }}</h3>
                </div>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                    <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Total Jawaban Masuk</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total_jawaban_masuk'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- TABS NAVIGATION --}}
    <div class="flex space-x-1 bg-slate-200/50 p-1 rounded-xl w-fit">
        <button wire:click="switchTab('responden')" 
            class="px-5 py-2.5 rounded-lg text-sm font-medium transition-all {{ $activeTab === 'responden' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            Data Responden
        </button>
        <button wire:click="switchTab('pertanyaan')" 
            class="px-5 py-2.5 rounded-lg text-sm font-medium transition-all {{ $activeTab === 'pertanyaan' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            Kelola Pertanyaan
        </button>
    </div>

    {{-- CONTENT AREA --}}
    <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-100 overflow-hidden">
        
        {{-- TAB 1: DATA RESPONDEN --}}
        @if ($activeTab === 'responden')
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Daftar Mahasiswa yang Mengisi</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Nama Mahasiswa</th>
                                <th class="px-6 py-4 font-semibold">Prodi & Angkatan</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($respondents as $user)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-900">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-400">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>{{ $user->program_studi ?? '-' }}</div>
                                        <div class="text-xs text-slate-400">Angkatan {{ $user->angkatan ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button wire:click="confirmDeleteResponden({{ $user->id }})" 
                                                class="text-red-500 hover:text-red-700 font-medium text-xs border border-red-200 hover:bg-red-50 px-3 py-1.5 rounded-lg transition">
                                            Hapus Jawaban
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                        Belum ada responden yang mengisi kuisioner.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $respondents->links() }}
                </div>
            </div>
        
        {{-- TAB 2: KELOLA PERTANYAAN --}}
        @elseif ($activeTab === 'pertanyaan')
            <div class="p-6">
                <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
                    <h3 class="text-lg font-bold text-slate-800">Daftar Pertanyaan per Kategori</h3>
                    
                    <div class="flex gap-3">
                        <button wire:click="openModal('kategori')" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl hover:bg-slate-50 transition flex items-center gap-2">
                            <span class="text-lg">+</span> Kategori
                        </button>
                        <button wire:click="openModal('pertanyaan')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition shadow-md flex items-center gap-2">
                            <span class="text-lg">+</span> Pertanyaan
                        </button>
                    </div>
                </div>

                <div class="space-y-8">
                    @foreach ($grouped_questions as $kategori)
                        <div class="border border-slate-200 rounded-2xl overflow-hidden">
                            <div class="bg-slate-50 px-6 py-3 border-b border-slate-200 flex justify-between items-center group/head">
                                <div>
                                    <h4 class="font-bold text-slate-800 flex items-center gap-2">
                                        {{ $kategori->nama_kuisioner }}
                                        <button wire:click="openModal('kategori', {{ $kategori->id }})" class="opacity-0 group-hover/head:opacity-100 text-blue-500 hover:text-blue-700 transition">
                                            <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </button>
                                    </h4>
                                    <p class="text-xs text-slate-500">{{ $kategori->deskripsi }}</p>
                                </div>
                                <span class="bg-white border border-slate-200 text-slate-600 text-xs px-2 py-1 rounded font-medium">
                                    {{ $kategori->pertanyaan->count() }} Soal
                                </span>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm text-slate-600">
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach ($kategori->pertanyaan as $index => $q)
                                            <tr class="hover:bg-slate-50 transition group">
                                                <td class="px-6 py-3 w-10 text-slate-400 text-xs">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="px-6 py-3 font-medium text-slate-700">
                                                    {{ $q->teks_pertanyaan }}
                                                </td>
                                                <td class="px-6 py-3 text-right w-32">
                                                    <div class="flex justify-end gap-3 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                                        <button wire:click="openModal('pertanyaan', {{ $q->id }})" class="text-blue-500 hover:text-blue-700 text-xs font-medium">Edit</button>
                                                        
                                                        <button wire:click="confirmDeletePertanyaan({{ $q->id }})" 
                                                                class="text-red-500 hover:text-red-700 text-xs font-medium">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if($kategori->pertanyaan->isEmpty())
                                            <tr>
                                                <td colspan="3" class="px-6 py-4 text-center text-slate-400 text-xs italic">
                                                    Belum ada pertanyaan di kategori ini.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

{{-- MODAL FORMULIR (Overlay) --}}
@if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-all"
         x-data x-transition>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-bold text-lg text-slate-800">
                    {{ $isEdit ? 'Edit' : 'Tambah' }} 
                    {{ $modalType == 'kategori' ? 'Kategori' : 'Pertanyaan' }}
                </h3>
                <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>
            
            <div class="p-6 space-y-4">
                @if($modalType == 'kategori')
                    {{-- FORM KATEGORI --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori</label>
                        <input type="text" wire:model="nama_kuisioner" class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Fasilitas Kampus">
                        @error('nama_kuisioner') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Singkat</label>
                        <textarea wire:model="deskripsi_kuisioner" rows="3" class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Jelaskan kategori ini..."></textarea>
                        @error('deskripsi_kuisioner') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                @else
                    {{-- FORM PERTANYAAN --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                        <select wire:model="pertanyaan_kategori_id" class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($all_categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nama_kuisioner }}</option>
                            @endforeach
                        </select>
                        @error('pertanyaan_kategori_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Teks Pertanyaan</label>
                        <textarea wire:model="pertanyaan_text" rows="3" class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Tulis pertanyaan di sini..."></textarea>
                        @error('pertanyaan_text') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tipe Jawaban</label>
                        <select wire:model="pertanyaan_tipe" class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="likert">Skala 1-5 (Likert)</option>
                            <option value="text">Isian Teks (Esai)</option>
                        </select>
                    </div>
                @endif
            </div>

            <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3">
                <button wire:click="closeModal" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 text-sm font-medium">Batal</button>
                <button wire:click="{{ $modalType == 'kategori' ? 'saveKategori' : 'savePertanyaan' }}" class="px-4 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700 text-sm font-medium shadow-lg shadow-blue-600/20">
                    {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Baru' }}
                </button>
            </div>
        </div>
    </div>
@endif

{{-- SCRIPT SWEETALERT --}}
<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('show-delete-confirmation', (event) => {
            let data = Array.isArray(event) ? event[0] : event; 
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true 
            }).then((result) => {
                if (result.isConfirmed) {
                    if(data.type === 'responden') {
                        @this.dispatch('delete-responden-confirmed', { id: data.id });
                    } else if (data.type === 'pertanyaan') {
                        @this.dispatch('delete-pertanyaan-confirmed', { id: data.id });
                    }
                }
            })
        });

        @this.on('show-toast', (event) => {
            let data = Array.isArray(event) ? event[0] : event;
            const Toast = Swal.mixin({
                toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({ icon: data.icon, title: data.message })
        });
    });
</script>
</div>