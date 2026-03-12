<x-guest-layout>
    {{-- Background Hero (Sama dengan Register) --}}
    <div class="fixed inset-0 bg-cover bg-center bg-no-repeat" 
         style="background-image: url('{{ asset('/images/1.png') }}');">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px]"></div>
    </div>

    <div class="relative min-h-screen w-screen flex items-center justify-center px-6 py-16">
        {{-- Card Login Transparan (Glassmorphism) --}}
        <div class="w-full max-w-md bg-white/70 backdrop-blur-l rounded-[40px] shadow-2xl border border-white/20 overflow-hidden animate-in fade-in zoom-in duration-500 -mt-10 mb-10">
            
            <div class="p-10 md:p-12 text-center">
                {{-- Logo USH dengan Drop Shadow --}}
                <img src="{{ asset('logo_ush.png') }}" alt="Logo USH" class="h-24 mx-auto mb-6 drop-shadow-xl">
                
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight drop-shadow-sm">Selamat <span class="text-blue-600">Datang</span></h2>
                <p class="text-slate-500 text-[16px] mt-2 font-medium">Silakan masuk untuk melanjutkan kuesioner</p>

                <x-auth-session-status class="mb-4 mt-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-10 space-y-6 text-left">
                    @csrf

                    {{-- Input Email --}}
                    <div>
                        <x-input-label for="email" :value="__('Alamat Email')" class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1 mb-2" />
                        <x-text-input id="email" class="block w-full px-5 py-3.5 rounded-2xl border-white/20 bg-white/50 text-slate-900 text-sm focus:ring-4 focus:ring-blue-500/20 transition-all" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-200 text-xs" />
                    </div>

                    {{-- Input Password --}}
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <x-input-label for="password" :value="__('Password')" class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1" />
                            @if (Route::has('password.request'))
                                <a class="text-[13px] text-slate-500 hover:text-slate-700 underline decoration-slate-300" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <x-text-input id="password" class="block w-full px-5 py-3.5 rounded-2xl border-white/20 bg-white/50 text-slate-900 text-sm focus:ring-4 focus:ring-blue-500/20 transition-all" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-200 text-xs" />
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center ml-1">
                        <input id="remember_me" type="checkbox" class="rounded-lg border-white/20 bg-white/30 text-blue-600 shadow-sm focus:ring-blue-500/50" name="remember">
                        <span class="ms-2 text-xs text-slate-500 font-medium">Ingat saya di perangkat ini</span>
                    </div>

                    {{-- Tombol Login --}}
                    <div class="pt-2">
                        <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black text-sm shadow-xl shadow-blue-500/30 transition-all active:scale-[0.97] uppercase tracking-[3px]">
                            Sign-In / Login
                        </button>
                    </div>

                    {{-- Link ke Register --}}
                    <div class="text-center pt-4 border-t border-white/10">
                        <p class="text-[11px] text-slate-500 font-medium">
                            Belum memiliki akun? 
                            <a href="{{ route('register') }}" class="text-slate-500 font-black underline underline-offset-4 decoration-2">DAFTAR SEKARANG</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>