<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.4em] text-blue-500">Pertanyaan</p>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Pertanyaan {{ $kuisioner->nama_kuisioner }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 space-y-6">
                <form action="{{ route('admin.kuisioner.pertanyaan.update', [$kuisioner, $pertanyaan]) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Teks Pertanyaan</label>
                        <textarea name="teks_pertanyaan" rows="4" class="w-full rounded-2xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">{{ old('teks_pertanyaan', $pertanyaan->teks_pertanyaan) }}</textarea>
                        @error('teks_pertanyaan') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Tipe Jawaban</label>
                        <select name="tipe_jawaban" class="w-full rounded-2xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                            <option value="likert" @selected(old('tipe_jawaban', $pertanyaan->tipe_jawaban) === 'likert')>Skala Likert</option>
                            <option value="text" @selected(old('tipe_jawaban', $pertanyaan->tipe_jawaban) === 'text')>Isian Teks</option>
                            <option value="dropdown" @selected(old('tipe_jawaban', $pertanyaan->tipe_jawaban) === 'dropdown')>Dropdown</option>
                        </select>
                        @error('tipe_jawaban') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Opsi Dropdown (opsional)</label>
                        <textarea name="opsi_dropdown[]" rows="3" class="w-full rounded-2xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">{{ old('opsi_dropdown.0', $pertanyaan->opsi_dropdown ? implode(', ', $pertanyaan->opsi_dropdown) : '') }}</textarea>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.kuisioner.pertanyaan.index', $kuisioner) }}" class="px-4 py-2 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 rounded-2xl bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">
                            Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

