<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Dashboard</h2>
    </x-slot>

    <div class="p-6">
        <div class="bg-white p-6 rounded-xl shadow mb-6">
            <h3 class="text-lg font-semibold mb-4">Filter Grafik</h3>
            <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col md:flex-row items-center gap-4">
                <div>
                    <label for="bulan" class="block text-sm font-medium text-gray-700">Pilih Bulan</label>
                    <select id="bulan" name="bulan" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Bulan</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700">Pilih Tahun</label>
                    <select id="tahun" name="tahun" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @foreach(range(date('Y'), 2020) as $y)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="mt-6 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

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
            <p class="text-2xl mt-2 text-gray-700">{{ $jumlahPenabung }} unit</p>
        </div>
    </div>
    
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold mb-4">Uang Tabungan per Unit</h3>
            <canvas id="setoranUnitChart"></canvas>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold mb-4">Donasi per Unit</h3>
            <canvas id="donasiUnitChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data dari Laravel
        const setoranData = @json($setoranPerUnit);
        const donasiData = @json($donasiPerUnit);
        
        // Fungsi untuk menggenerate warna dinamis
        function generateColors(count) {
            const colors = [];
            const hueStep = 360 / count;
            for (let i = 0; i < count; i++) {
                const hue = (hueStep * i + 45) % 360; // Offset hue untuk variasi
                colors.push(`hsl(${hue}, 70%, 50%)`);
            }
            return colors;
        }

        // Pie Chart Setoran (Tabungan) per Unit
        const setoranLabels = setoranData.map(item => item.unit_name);
        const setoranValues = setoranData.map(item => item.total_setoran);
        const setoranBgColors = generateColors(setoranLabels.length);

        const setoranCtx = document.getElementById('setoranUnitChart').getContext('2d');
        new Chart(setoranCtx, {
            type: 'pie',
            data: {
                labels: setoranLabels,
                datasets: [{
                    data: setoranValues,
                    backgroundColor: setoranBgColors,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    const value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(context.parsed);
                                    label += value;
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Pie Chart Donasi per Unit
        const donasiLabels = donasiData.map(item => item.unit_name);
        const donasiValues = donasiData.map(item => item.total_donasi);
        const donasiBgColors = generateColors(donasiLabels.length);

        const donasiCtx = document.getElementById('donasiUnitChart').getContext('2d');
        new Chart(donasiCtx, {
            type: 'pie',
            data: {
                labels: donasiLabels,
                datasets: [{
                    data: donasiValues,
                    backgroundColor: donasiBgColors,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    const value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(context.parsed);
                                    label += value;
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
