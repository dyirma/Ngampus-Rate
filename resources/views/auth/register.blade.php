<x-guest-layout>
    <div class="fixed inset-0 bg-cover bg-center bg-no-repeat" 
         style="background-image: url('{{ asset('/images/1.png') }}');">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px]"></div>
    </div>

    <div class="relative h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-3xl bg-white/70 backdrop-blur-l rounded-[40px] shadow-2xl border border-white/20 overflow-hidden animate-in fade-in zoom-in duration-500 -mt-10 mb-10">
            
            <div class="p-6 text-center">
                <img src="{{ asset('logo_ush.png') }}" alt="Logo USH" class="h-20 mx-auto mb-3 drop-shadow-md">
                
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Registrasi <span class="text-blue-600">Responden</span></h2>
                <p class="text-slate-500 text-[16px] mt-2 font-medium">Lengkapi data diri Anda untuk memulai kuesioner</p>

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6 text-left">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        
                        <div class="md:col-span-2">
                            <label class="text-[13px] font-bold text-blue-500 uppercase tracking-widest ml-1 mb-1 block">Informasi Utama</label>
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-[9px] font-bold text-slate-600 uppercase ml-1 mb-1" />
                            <x-text-input id="name" class="block w-full px-4 py-2.5 rounded-xl border-slate-200 text-sm focus:ring-2 focus:ring-blue-500/10" type="text" name="name" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>
                        
                        <div>
                            <x-input-label for="email" :value="__('Alamat Email')" class="text-[9px] font-bold text-slate-600 uppercase ml-1 mb-1" />
                            <x-text-input id="email" class="block w-full px-4 py-2.5 rounded-xl border-slate-200 text-sm focus:ring-2 focus:ring-blue-500/10" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password')" class="text-[9px] font-bold text-slate-600 uppercase ml-1 mb-1" />
                            <x-text-input id="password" class="block w-full px-4 py-2.5 rounded-xl border-slate-200 text-sm focus:ring-2 focus:ring-blue-500/10" type="password" name="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi')" class="text-[9px] font-bold text-slate-600 uppercase ml-1 mb-1" />
                            <x-text-input id="password_confirmation" class="block w-full px-4 py-2.5 rounded-xl border-slate-200 text-sm focus:ring-2 focus:ring-blue-500/10" type="password" name="password_confirmation" required />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2 pt-2">
                            <label class="text-[13px] font-bold text-blue-500 uppercase tracking-widest ml-1 mb-1 block">Detail Profil</label>
                        </div>

                        <div>
                            <x-input-label for="gender" :value="__('Jenis Kelamin')" class="text-[9px] font-bold text-slate-600 uppercase ml-1 mb-1" />
                            <select id="gender" name="gender" class="block w-full px-4 py-2.5 rounded-xl border-slate-200 bg-white text-sm focus:ring-4 focus:ring-blue-500/10 transition-all">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status_responden" :value="__('Status')" class="text-[9px] font-bold text-slate-600 uppercase ml-1 mb-1" />
                            <select id="status_responden" name="status_responden" class="block w-full px-4 py-2.5 rounded-xl border-slate-200 bg-white text-sm focus:ring-4 focus:ring-blue-500/10 transition-all">
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="staf">Staf/Karyawan</option>
                            </select>
                            <x-input-error :messages="$errors->get('status_responden')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="program_studi" :value="__('Program Studi')" class="text-[9px] font-bold text-slate-600 uppercase ml-1 mb-1" />
                            <select id="program_studi" name="program_studi" class="block w-full px-4 py-2.5 rounded-xl border-slate-200 bg-white text-sm focus:ring-4 focus:ring-blue-500/10" required>
                                <option value="" disabled selected>Pilih Prodi</option>
                                <option value="S1 Teknik Informatika">Informatika</option>
                                <option value="S1 Sistem Informasi">Sist. Informasi</option>
                                <option value="S1 Desain Komunikasi Visual">DKV</option>
                                <option value="S1 Akuntansi">Akuntansi</option>
                                <option value="S1 Manajemen">Manajemen</option>
                            </select>
                            <x-input-error :messages="$errors->get('program_studi')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="angkatan" :value="__('Angkatan')" class="text-[9px] font-bold text-slate-600 uppercase ml-1 mb-1" />
                            <select id="angkatan" name="angkatan" class="block w-full px-4 py-2.5 rounded-xl border-slate-200 bg-white text-sm focus:ring-4 focus:ring-blue-500/10" required>
                                @php $currentYear = date('Y'); @endphp
                                @for ($year = $currentYear; $year >= $currentYear - 5; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-4 pt-3">
                        <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold text-sm shadow-xl shadow-blue-500/20 transition-all active:scale-[0.98] uppercase tracking-widest">
                            Selesaikan Registrasi
                        </button>
                        
                        <a class="text-[14px] text-slate-500 font-medium hover:text-blue-600 transition" href="{{ route('login') }}">
                            Sudah punya akun? <span class="font-bold underline">Login di sini</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>