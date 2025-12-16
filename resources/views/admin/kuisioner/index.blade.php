<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-blue-500">Manajemen Kuisioner</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kategori &amp; Deskripsi</h2>
            </div>
            <a href="{{ route('admin.kuisioner.create') }}" class="px-4 py-2 rounded-2xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                Tambah Kuisioner
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @foreach ($kuisioners as $kuisioner)
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 space-y-3">
                    <div class="flex flex-wrap justify-between gap-3">
                        <div>
                            <p class="text-sm uppercase tracking-[0.4em] text-blue-500">Kategori</p>
                            <h3 class="text-xl font-semibold text-slate-800">{{ $kuisioner->nama_kuisioner }}</h3>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.kuisioner.pertanyaan.index', $kuisioner) }}" class="px-4 py-2 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition text-sm">
                                Pertanyaan ({{ $kuisioner->pertanyaan_count }})
                            </a>
                            <a href="{{ route('admin.kuisioner.edit', $kuisioner) }}" class="px-4 py-2 rounded-2xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition text-sm">
                                Edit
                            </a>
                            <form action="{{ route('admin.kuisioner.destroy', $kuisioner) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus kuisioner ini?')" class="px-4 py-2 rounded-2xl bg-rose-100 text-rose-600 hover:bg-rose-200 transition text-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    <p class="text-slate-500 text-sm">{{ $kuisioner->deskripsi }}</p>
                </div>
            @endforeach
            {{ $kuisioners->links() }}
        </div>
    </div>
</x-app-layout>

