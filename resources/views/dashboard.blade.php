<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Dashboard</h2>
    </x-slot>

    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-bold">Total Uang Terkumpul</h3>
            <p class="text-2xl mt-2 text-green-600">Rp {{ number_format($totalSetoran, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-bold">Total Donasi</h3>
            <p class="text-2xl mt-2 text-blue-600">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-bold">Jumlah Penabung</h3>
            <p class="text-2xl mt-2 text-gray-700">{{ $jumlahPenabung }} orang</p>
        </div>

    </div>
    <div class="p-6">
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold mb-4">Grafik Setoran per Bulan</h3>
            <canvas id="chartSetoran"><     /canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartSetoran').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Donasi', 'Sisa Tabungan'],
                datasets: [{
                    data: [{{ $totalDonasi }}, {{ $totalSetoran - $totalDonasi }}],
                    backgroundColor: ['#3B82F6', '#10B981']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
