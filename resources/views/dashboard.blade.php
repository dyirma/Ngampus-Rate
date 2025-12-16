<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-blue-500">Step 0 — Pre-Check</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Mulai Kuisioner Kampus Universitas Sugeng Hartono
                </h2>
            </div>
            <div class="text-sm text-gray-500">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto space-y-6 px-4 sm:px-6 lg:px-8">
            

            <livewire:kuisioner-form />
        </div>
    </div>
</x-app-layout>
