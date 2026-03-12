<x-guest-layout>
    {{-- Background Hero (Sesuai dengan Login & Register) --}}
    <div class="fixed inset-0 bg-cover bg-center bg-no-repeat" 
         style="background-image: url('{{ asset('/images/1.png') }}');">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px]"></div>
    </div>

    <div class="relative min-h-screen w-screen flex items-center justify-center px-6 py-16">
        {{-- Card Glassmorphism Transparan 70% --}}
        <div class="w-full max-w-md bg-white/70 backdrop-blur-l rounded-[40px] shadow-2xl border border-white/20 overflow-hidden animate-in fade-in zoom-in duration-500 -mt-10 mb-10">
            
            <div class="p-10 text-center">
                {{-- Logo USH --}}
                <img src="{{ asset('logo_ush.png') }}" alt="Logo USH" class="h-20 mx-auto mb-6 drop-shadow-xl">
                
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight drop-shadow-sm">Reset <span class="text-blue-600">Password</span></h2>
                
                <div class="mt-4 mb-8 text-[15px] text-slate-600 leading-relaxed font-medium">
                    {{ __('Lupa password? Jangan khawatir. Masukkan alamat email Anda dan kami akan mengirimkan tautan pemulihan untuk membuat password baru.') }}
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="text-left space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Alamat Email')" class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1 mb-2" />
                        <x-text-input id="email" class="block w-full px-5 py-3.5 rounded-2xl border-white/20 bg-white/50 text-slate-900 text-sm focus:ring-4 focus:ring-blue-500/20 transition-all" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-200 text-xs" />
                    </div>

                    <div class="flex flex-col gap-4 pt-2">
                        <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black text-sm shadow-xl shadow-blue-500/30 transition-all active:scale-[0.97] uppercase tracking-[2px]">
                            {{ __('Kirim Link Reset') }}
                        </button>

                        <a href="{{ route('login') }}" class="text-center text-xs text-slate-500 font-bold hover:text-slate-700 transition uppercase tracking-widest">
                            ← Kembali ke Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>