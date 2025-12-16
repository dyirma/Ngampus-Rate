<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-blue-500">Pertanyaan</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $kuisioner->nama_kuisioner }}
                </h2>
                <p class="text-sm text-slate-500 max-w-2xl">{{ $kuisioner->deskripsi }}</p>
            </div>
            <a href="{{ route('admin.kuisioner.pertanyaan.create', $kuisioner) }}" class="px-4 py-2 rounded-2xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                Tambah Pertanyaan
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden divide-y divide-slate-100">
                @forelse ($pertanyaans as $pertanyaan)
                    <div class="p-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-medium text-slate-800">{{ $pertanyaan->teks_pertanyaan }}</p>
                            <p class="text-sm text-slate-500 capitalize">Tipe: {{ $pertanyaan->tipe_jawaban }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.kuisioner.pertanyaan.edit', [$kuisioner, $pertanyaan]) }}" class="px-4 py-2 rounded-2xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition text-sm">
                                Edit
                            </a>
                            <form action="{{ route('admin.kuisioner.pertanyaan.destroy', [$kuisioner, $pertanyaan]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus pertanyaan ini?')" class="px-4 py-2 rounded-2xl bg-rose-100 text-rose-600 hover:bg-rose-200 transition text-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-500">Belum ada pertanyaan.</div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $pertanyaans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

