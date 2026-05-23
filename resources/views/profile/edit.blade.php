<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 w-full">
            {{-- Bagian Kiri: Logo & Teks LPM --}}
            <div class="flex items-center gap-4">
                <img src="{{ asset('logo_ush.png') }}" alt="Logo Kampus"
                    class="w-12 h-12 md:w-14 md:h-14 object-contain">
                <div class="border-l-2 border-slate-300 pl-4 py-1">
                    <p
                        class="text-[10px] md:text-xs font-bold text-slate-800 tracking-wide uppercase leading-tight mb-0.5">
                        Lembaga Penjamin Mutu
                    </p>
                    <h2
                        class="font-extrabold text-sm md:text-base text-[#1e3a8a] tracking-widest uppercase leading-tight">
                        Universitas Sugeng Hartono
                    </h2>
                </div>
            </div>

            {{-- Bagian Kanan: Navigasi Minimalis & Profil --}}
            <div class="flex items-center gap-6">
                <nav class="hidden md:flex items-center gap-6 text-[13px] font-semibold text-slate-600">
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
                        class="px-5 py-2 rounded-lg hover:bg-white/50 text-slate-600 hover:text-blue-600 transition font-bold shadow-sm border border-slate-200/50 backdrop-blur-md">
                        &larr; Kembali ke Dashboard
                    </a>
                </nav>

                {{-- Dropdown Profile --}}
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center justify-center w-10 h-10 md:w-11 md:h-11 rounded-full border-2 border-white shadow-md overflow-hidden bg-blue-100 text-blue-600 font-black focus:outline-none transition-transform hover:scale-105 cursor-pointer group">
                                @if(Auth::user()->foto_profil)
                                    <img src="{{ Storage::url(Auth::user()->foto_profil) }}" alt="Foto Profil"
                                        class="w-full h-full object-cover">
                                @else
                                    <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                @endif
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Identitas Pengguna di dalam menu --}}
                            <div class="px-5 py-4 flex items-center gap-4 border-b border-slate-100">
                                <div
                                    class="h-11 w-11 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-black text-xl shadow-inner border border-blue-200 overflow-hidden shrink-0">
                                    @if(Auth::user()->foto_profil)
                                        <img src="{{ Storage::url(Auth::user()->foto_profil) }}" alt="Foto Profil"
                                            class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div
                                    class="font-bold text-slate-800 text-[13px] tracking-wide uppercase break-words w-full">
                                    {{ Auth::user()->name }}</div>
                            </div>

                            {{-- Link Profil --}}
                            <x-dropdown-link :href="route('profile.edit')"
                                class="flex items-center gap-3 py-3 !text-slate-600 transition hover:!bg-slate-50 hover:!text-slate-900 border-b border-slate-100">
                                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-semibold text-sm">Profile</span>
                            </x-dropdown-link>

                            {{-- Logout Link --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center gap-3 py-3 !text-red-500 transition hover:!bg-red-50 mt-1">
                                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    <span class="font-bold text-sm">Logout</span>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Form Gabungan: Account + Password + Data Diri --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 lg:p-10 border border-slate-100 relative">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    @if (session('status') === 'profile-updated')
                        <div x-data="{ show: true }" x-show="show" x-transition
                            x-init="setTimeout(() => show = false, 3000)"
                            class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 text-sm font-bold flex items-center justify-between">
                            Daftar perubahan berhasil disimpan!
                            <button @click="show = false" type="button"
                                class="text-green-500 hover:text-green-700">&times;</button>
                        </div>
                    @endif

                    <div class="space-y-12">

                        {{-- Bagian 1: Data Akun Utama --}}
                        <section>
                            <div class="mb-6 border-b border-slate-100 pb-4">
                                <h3 class="text-xl font-black text-slate-800 tracking-tight">Informasi Akun</h3>
                                <p class="text-sm text-slate-500 mt-1">Perbarui nama tampilan dan alamat email Anda.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="col-span-1 md:col-span-2 mb-4">
                                    <x-input-label for="foto_profil" :value="__('Foto Profil (Opsional)')"
                                        class="text-xs tracking-widest font-bold text-slate-400 mb-2 ml-1" />
                                    <div class="flex items-center gap-6">
                                        <div
                                            class="h-20 w-20 rounded-full border-2 border-slate-200 overflow-hidden bg-slate-100 flex items-center justify-center shrink-0">
                                            @if(Auth::user()->foto_profil)
                                                <img src="{{ Storage::url(Auth::user()->foto_profil) }}" alt="Foto Profil"
                                                    class="h-full w-full object-cover">
                                            @else
                                                <span
                                                    class="text-3xl font-black text-slate-400">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                            @endif
                                        </div>
                                        <input type="file" id="foto_profil" name="foto_profil" accept="image/*"
                                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('foto_profil')" />
                                </div>

                                <div>
                                    <x-input-label for="name" :value="__('Nama Lengkap')"
                                        class="text-xs  tracking-widest font-bold text-slate-400 mb-2 ml-1" />
                                    <x-text-input id="name" name="name" type="text"
                                        class="mt-1 block w-full rounded-xl bg-slate-50 border-slate-200 focus:ring-blue-500"
                                        :value="old('name', Auth::user()->name)" required autocomplete="name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>
                                <div>
                                    <x-input-label for="email" :value="__('Alamat Email')"
                                        class="text-xs  tracking-widest font-bold text-slate-400 mb-2 ml-1" />
                                    <x-text-input id="email" name="email" type="email"
                                        class="mt-1 block w-full rounded-xl bg-slate-50 border-slate-200 focus:ring-blue-500"
                                        :value="old('email', Auth::user()->email)" required autocomplete="username" />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>
                            </div>
                        </section>

                        {{-- Bagian 2: Data Kepegawaian --}}
                        <section>
                            <div class="mb-6 border-b border-slate-100 pb-4">
                                <h3 class="text-xl font-black text-slate-800 tracking-tight">Data Kepegawaian</h3>
                                <p class="text-sm text-slate-500 mt-1">Lengkapi data pokok kepegawaian Anda dengan
                                    cermat.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="nip" :value="__('NUPTK')"
                                        class="text-xs  tracking-widest font-bold text-slate-400 mb-2 ml-1" />
                                    <x-text-input id="nip" name="nip" type="text"
                                        class="mt-1 block w-full rounded-xl bg-slate-50 border-slate-200 focus:ring-blue-500"
                                        :value="old('nip', Auth::user()->nip)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('nip')" />
                                </div>
                                <div>
                                    <x-input-label for="tipe_pegawai" :value="__('Status Kepegawaian')"
                                        class="text-xs  tracking-widest font-bold text-slate-400 mb-2 ml-1" />
                                    <select id="tipe_pegawai" name="tipe_pegawai"
                                        class="mt-1 block w-full rounded-xl bg-slate-50 border-slate-200 focus:ring-blue-500 focus:border-blue-500 text-sm ">
                                        <option value="dosen" {{ old('tipe_pegawai', Auth::user()->tipe_pegawai) === 'dosen' ? 'selected' : '' }}>Dosen</option>
                                        <option value="tendik" {{ old('tipe_pegawai', Auth::user()->tipe_pegawai) === 'tendik' ? 'selected' : '' }}>Tendik</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('tipe_pegawai')" />
                                </div>
                                <div>
                                    <x-input-label for="jabatan" :value="__('Jabatan')"
                                        class="text-xs  tracking-widest font-bold text-slate-400 mb-2 ml-1" />
                                    <x-text-input id="jabatan" name="jabatan" type="text"
                                        class="mt-1 block w-full rounded-xl bg-slate-50 border-slate-200 focus:ring-blue-500"
                                        :value="old('jabatan', Auth::user()->jabatan)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('jabatan')" />
                                </div>
                                <div>
                                    <x-input-label for="unit_kerja" :value="__('Unit Kerja / Fakultas')"
                                        class="text-xs  tracking-widest font-bold text-slate-400 mb-2 ml-1" />
                                    <x-text-input id="unit_kerja" name="unit_kerja" type="text"
                                        class="mt-1 block w-full rounded-xl bg-slate-50 border-slate-200 focus:ring-blue-500"
                                        :value="old('unit_kerja', Auth::user()->unit_kerja)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('unit_kerja')" />
                                </div>
                            </div>
                        </section>

                        {{-- Bagian 3: Ganti Password --}}
                        <section>
                            <div class="mb-6 border-b border-slate-100 pb-4 mt-8">
                                <h3 class="text-xl font-black text-slate-800 tracking-tight">Ganti Password (Opsional)
                                </h3>
                                <p class="text-sm text-slate-500 mt-1">Kosongkan bagian ini jika Anda tidak ingin
                                    mengubah password saat ini.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="col-span-1 md:col-span-2">
                                    <x-input-label for="current_password" :value="__('Password Saat Ini')"
                                        class="text-xs  tracking-widest font-bold text-slate-400 mb-2 ml-1" />
                                    <x-text-input id="current_password" name="current_password" type="password"
                                        class="mt-1 block w-full rounded-xl bg-slate-50 border-slate-200 focus:ring-blue-500"
                                        autocomplete="current-password" />
                                    <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
                                </div>
                                <div>
                                    <x-input-label for="password" :value="__('Password Baru')"
                                        class="text-xs  tracking-widest font-bold text-slate-400 mb-2 ml-1" />
                                    <x-text-input id="password" name="password" type="password"
                                        class="mt-1 block w-full rounded-xl bg-slate-50 border-slate-200 focus:ring-blue-500"
                                        autocomplete="new-password" />
                                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                                </div>
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')"
                                        class="text-xs  tracking-widest font-bold text-slate-400 mb-2 ml-1" />
                                    <x-text-input id="password_confirmation" name="password_confirmation"
                                        type="password"
                                        class="mt-1 block w-full rounded-xl bg-slate-50 border-slate-200 focus:ring-blue-500"
                                        autocomplete="new-password" />
                                    <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                                </div>
                            </div>
                        </section>

                        {{-- Tombol Utama --}}
                        <div class="pt-8 flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-xl font-black text-xs  tracking-widest shadow-xl shadow-blue-200 transition-all active:scale-95 w-full md:w-auto">
                                Simpan Semua Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Bagian Hapus Akun (Terpisah) --}}
            <div class="p-8 bg-red-50 shadow-sm rounded-2xl border border-red-100 mt-6">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>