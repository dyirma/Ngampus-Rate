<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-blue-500">Laporan</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Rata-rata Skor Penilaian Dosen
                </h2>
            </div>
            <a href="{{ route('admin.laporan.export') }}" class="px-4 py-2 rounded-2xl bg-emerald-600 text-white text-sm font-semibold shadow hover:bg-emerald-700 transition">
                Export Excel
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="overflow-auto bg-white rounded-3xl shadow-sm border border-slate-100">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Dosen</th>
                            @foreach ($kuisioners as $kuisioner)
                                <th class="px-4 py-3 text-center font-semibold text-slate-600">{{ $kuisioner->nama_kuisioner }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($dosens as $dosen)
                            <tr>
                                <td class="px-4 py-4">
                                    <p class="font-semibold text-slate-800">{{ $dosen->nama }}</p>
                                    <p class="text-slate-500 text-xs">{{ $dosen->nip }}</p>
                                </td>
                                @foreach ($kuisioners as $kuisioner)
                                    <td class="px-4 py-4 text-center">
                                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-medium {{ isset($report[$dosen->id][$kuisioner->id]) ? 'bg-blue-50 text-blue-600' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $report[$dosen->id][$kuisioner->id] ?? '-' }}
                                        </span>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

