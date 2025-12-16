<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.4em] text-blue-500">Area Admin</p>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard Analitik
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                    <p class="text-sm text-slate-500">Total Kuisioner Terisi</p>
                    <p class="text-3xl font-semibold text-slate-800">{{ $totalResponses }}</p>
                </div>
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                    <p class="text-sm text-slate-500">Jumlah Dosen</p>
                    <p class="text-3xl font-semibold text-slate-800">{{ $totalDosen }}</p>
                </div>
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                    <p class="text-sm text-slate-500">Jumlah Pengguna</p>
                    <p class="text-3xl font-semibold text-slate-800">{{ $totalUsers }}</p>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm uppercase tracking-[0.4em] text-blue-500">Rata-rata Skor</p>
                        <h3 class="text-xl font-semibold text-slate-800">Per Kategori Kuisioner</h3>
                    </div>
                </div>
                <canvas id="avgChart" height="120"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const avgCtx = document.getElementById('avgChart').getContext('2d');
            const avgChart = new Chart(avgCtx, {
                type: 'bar',
                data: {
                    labels: {!! $averagePerKuisioner->pluck('nama_kuisioner')->toJson() !!},
                    datasets: [{
                        label: 'Skor Rata-rata',
                        data: {!! $averagePerKuisioner->pluck('rata_rata')->map(fn ($v) => round($v, 2))->toJson() !!},
                        backgroundColor: 'rgba(37, 99, 235, 0.8)',
                        borderRadius: 12,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                    },
                    scales: {
                        y: { beginAtZero: true, max: 5 }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>

