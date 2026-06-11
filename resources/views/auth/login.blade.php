<x-guest-layout>
    {{-- Background Hero (Sama dengan Register) --}}
    <div class="fixed inset-0 bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ asset('/images/1.png') }}');">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px]"></div>
    </div>

    <div class="relative min-h-screen w-screen flex items-center justify-center px-6 py-16">
        {{-- Card Login Transparan (Glassmorphism) --}}
        <div
            class="w-full max-w-md bg-white/70 backdrop-blur-l rounded-3xl shadow-2xl border border-white/20 overflow-hidden animate-in fade-in zoom-in duration-500 -mt-10 mb-10">

            <div class="p-8 md:p-10 text-center">
                {{-- Logo USH dengan Drop Shadow --}}
                <img src="{{ asset('logo_ush.png') }}" alt="Logo USH" class="h-20 md:h-24 mx-auto mb-6 drop-shadow-xl">

                <h2 class="text-2xl font-bold text-slate-800 tracking-tight drop-shadow-sm mb-2">Selamat <span
                        class="text-blue-600">Datang</span></h2>
                <p class="text-slate-500 text-sm font-medium">Silakan masuk menggunakan Email atau NIK</p>

                <x-auth-session-status class="mb-4 mt-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-4 text-center">
                    @csrf

                    {{-- Input Email --}}
                    <div class="relative">
                        <input id="login"
                            class="block w-full px-6 py-4 rounded-2xl border-0 bg-white/60 text-slate-900 text-sm md:text-base focus:ring-4 focus:ring-blue-500/20 transition-all font-semibold placeholder:text-slate-500 placeholder:font-bold shadow-inner"
                            type="text" name="login" :value="old('login')" required autofocus autocomplete="username"
                            placeholder="Email / NIK" />
                        <x-input-error :messages="$errors->get('login')" class="mt-2 text-red-500 text-xs font-bold" />
                    </div>

                    {{-- Input Password --}}
                    <div class="relative">
                        <input id="password"
                            class="block w-full px-6 py-4 rounded-2xl border-0 bg-white/60 text-slate-900 text-sm md:text-base focus:ring-4 focus:ring-blue-500/20 transition-all font-semibold placeholder:text-slate-500 placeholder:font-bold shadow-inner"
                            type="password" name="password" required autocomplete="current-password"
                            placeholder="Password" />
                        <x-input-error :messages="$errors->get('password')"
                            class="mt-2 text-red-500 text-xs font-bold" />
                    </div>

                    {{-- Forgot Password --}}
                    <div class="pt-2">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-slate-600 hover:text-slate-900 hover:underline decoration-slate-400 font-bold tracking-wide"
                                href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    {{-- Remember Me (Hidden by default, or very tiny) --}}
                    <div class="hidden">
                        <input id="remember_me" type="checkbox" name="remember" checked>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black text-sm md:text-base shadow-xl shadow-blue-500/20 transition-all active:scale-[0.97] tracking-[3px]">
                            Log In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>