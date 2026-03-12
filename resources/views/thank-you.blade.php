<x-app-layout>
    {{-- Container utama --}}
    <div class="min-h-screen flex items-center justify-center px-6 py-16">
        
        {{-- Card Glassmorphism --}}
        <div class="max-w-3xl w-full bg-white/90 backdrop-blur-xl rounded-[3rem] shadow-2xl border border-white/20 p-12 text-center space-y-8 animate-in fade-in zoom-in duration-700">
            
            {{-- 1. Logo Kampus dengan Animasi Bounce --}}
            <div class="flex justify-center mb-4">
                <img src="{{ asset('logo_ush.png') }}" 
                     alt="Logo Kampus" 
                     style="width: 150px; height: auto;" 
                     class="object-contain animate-bounce transition-transform duration-300">
            </div>

            {{-- Teks Ucapan Terima Kasih --}}
            <div class="space-y-4">
                <h1 class="text-4xl font-black text-slate-800 tracking-tight">
                    Terima Kasih, Kuisioner Anda Telah Dikirim
                </h1>
                <p class="text-slate-500 text-lg leading-relaxed max-w-2xl mx-auto">
                    Terima kasih telah berpartisipasi dalam kuisioner ini. Masukan Anda sangat berarti bagi pengembangan
                    dan peningkatan kualitas layanan kampus. Data yang Anda berikan akan kami gunakan untuk membuat kampus
                    menjadi tempat yang lebih baik untuk belajar dan berkembang.
                </p>
            </div>

            {{-- Tombol Kembali --}}
            <div class="flex justify-center pt-4">
                <a href="{{ route('dashboard') }}" 
                   class="px-10 py-5 rounded-[2rem] bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-blue-200 hover:shadow-blue-400 hover:-translate-y-1 transition-all duration-300 active:scale-95">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</x-app-layout>