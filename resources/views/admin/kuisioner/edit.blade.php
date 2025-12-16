<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.4em] text-blue-500">Manajemen Kuisioner</p>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Kuisioner</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 space-y-6">
                <form action="{{ route('admin.kuisioner.update', $kuisioner) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Nama Kuisioner</label>
                        <input type="text" name="nama_kuisioner" value="{{ old('nama_kuisioner', $kuisioner->nama_kuisioner) }}" class="w-full rounded-2xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                        @error('nama_kuisioner') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="4" class="w-full rounded-2xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi', $kuisioner->deskripsi) }}</textarea>
                        @error('deskripsi') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.kuisioner.index') }}" class="px-4 py-2 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
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

