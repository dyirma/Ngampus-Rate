<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Edit Data Diri Responden') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-[2rem] p-12 border border-slate-100 relative">
                
                {{-- Form Start --}}
                <form action="{{ route('user.data-diri.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    {{-- Header: Avatar & Nama (Bisa Edit Username) --}}
                    <div class="flex flex-col items-center mb-16 text-center">
                        <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-4xl font-black mb-6 shadow-xl shadow-blue-100 transform rotate-3">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        
                        <div class="w-full max-w-xs space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[3px]">Username / Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                                class="w-full text-center text-2xl font-black text-slate-800 tracking-tight border-none focus:ring-0 bg-slate-50 rounded-xl p-2" required>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-[4px]">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    {{-- Grid Informasi --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                        
                        {{-- Jenis Kelamin --}}
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[3px] block ml-1">Jenis Kelamin</label>
                            <div class="flex items-center gap-4 p-2 bg-slate-50 rounded-[2rem] border border-slate-100 focus-within:border-blue-400 transition-all">
                                <select name="gender" class="w-full border-none bg-transparent font-bold text-slate-700 text-sm focus:ring-0 cursor-pointer">
                                    <option value="Laki-laki" {{ Auth::user()->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ Auth::user()->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        {{-- Status Responden --}}
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[3px] block ml-1">Status Responden</label>
                            <div class="flex items-center gap-4 p-2 bg-slate-50 rounded-[2rem] border border-slate-100 focus-within:border-blue-400 transition-all">
                                <select name="status_responden" class="w-full border-none bg-transparent font-bold text-slate-700 text-sm focus:ring-0 cursor-pointer uppercase">
                                    <option value="mahasiswa" {{ Auth::user()->status_responden == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                    <option value="staf" {{ Auth::user()->status_responden == 'staf' ? 'selected' : '' }}>Staf</option>
                                </select>
                            </div>
                        </div>

                        {{-- Program Studi --}}
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[3px] block ml-1">Program Studi</label>
                            <div class="flex items-center gap-4 p-2 bg-slate-50 rounded-[2rem] border border-slate-100 focus-within:border-blue-400 transition-all">
                                <select name="program_studi" class="w-full border-none bg-transparent font-bold text-slate-700 text-sm focus:ring-0 cursor-pointer">
                                    <option value="S1 Teknik Informatika" {{ Auth::user()->program_studi == 'S1 Teknik Informatika' ? 'selected' : '' }}>S1 Teknik Informatika</option>
                                    <option value="S1 Sistem Informasi" {{ Auth::user()->program_studi == 'S1 Sistem Informasi' ? 'selected' : '' }}>S1 Sistem Informasi</option>
                                    <option value="S1 Akuntansi" {{ Auth::user()->program_studi == 'S1 Akuntansi' ? 'selected' : '' }}>S1 Akuntansi</option>
                                </select>
                            </div>
                        </div>

                        {{-- Angkatan --}}
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[3px] block ml-1">Angkatan</label>
                            <div class="flex items-center gap-4 p-2 bg-slate-50 rounded-[2rem] border border-slate-100 focus-within:border-blue-400 transition-all">
                                <select name="angkatan" class="w-full border-none bg-transparent font-bold text-slate-700 text-sm focus:ring-0 cursor-pointer">
                                    @for ($year = date('Y'); $year >= 2018; $year--)
                                        <option value="{{ $year }}" {{ Auth::user()->angkatan == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="mt-12 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-blue-200 transition-all active:scale-95">
                            Simpan Perubahan
                        </button>
                    </div>

                    {{-- Info Box --}}
                    <div class="mt-10 p-8 bg-blue-50/50 rounded-[2.5rem] border border-blue-100 flex gap-6 items-center">
                        <div class="bg-blue-600 text-white px-4 py-2 rounded-xl text-[10px] font-black tracking-widest">INFO</div>
                        <p class="text-[11px] text-blue-800 leading-relaxed font-bold uppercase tracking-tight">
                            Pastikan data yang Anda masukkan sudah benar sebelum menekan tombol simpan agar identitas kuesioner Anda akurat.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>