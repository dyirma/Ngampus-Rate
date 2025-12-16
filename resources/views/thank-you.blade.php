<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-6 py-16 bg-slate-50">
        <div class="max-w-3xl w-full bg-white rounded-3xl shadow-xl ring-1 ring-slate-100 p-10 text-center space-y-6">
            <div class="mx-auto h-16 w-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl">
                ✓
            </div>
            <h1 class="text-3xl font-semibold text-slate-800">Terima Kasih, Kuisioner Anda Telah Dikirim</h1>
            <p class="text-slate-500 leading-relaxed">
                Terima kasih telah berpartisipasi dalam kuisioner ini. Masukan Anda sangat berarti bagi pengembangan
                dan peningkatan kualitas layanan kampus. Data yang Anda berikan akan kami gunakan untuk membuat kampus
                menjadi tempat yang lebih baik untuk belajar dan berkembang.
            </p>
            <div class="flex justify-center">
                <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>

