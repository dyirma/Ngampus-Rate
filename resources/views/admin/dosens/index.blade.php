<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-blue-500">Manajemen Data</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dosen
                </h2>
            </div>
            <a href="{{ route('admin.dosen.create') }}" class="px-4 py-2 rounded-2xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                Tambah Dosen
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">NIP</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse ($dosens as $dosen)
                            <tr>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $dosen->nama }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $dosen->nip }}</td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.dosen.edit', $dosen) }}" class="px-3 py-1 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.dosen.destroy', $dosen) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus data dosen ini?')" class="px-3 py-1 rounded-2xl bg-rose-100 text-rose-600 hover:bg-rose-200 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-slate-500">Belum ada data dosen.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $dosens->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

