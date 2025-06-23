<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Riwayat Setoran</h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('setoran.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">+ Tambah Setoran</a>

        <table class="w-full mt-4 table-auto border">
            <thead>
                <tr class="bg-gray-100">
                    <th>Tanggal</th>
                    <th>Nama Unit</th>
                    <th>Nama penyetor</th>
                    <th>Tipe Setoran</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($setoran as $s)
                <tr class="border-t">
                    <td>{{ $s->tanggal }}</td>
                    <td>{{ $s->unit->unit_name }}</td>
                    <td>{{ $s->nama_penyetor }}</td>
                    <td>{{ $s->type }}</td>
                    <td>Rp {{ number_format($s->nominal, 0, ',', '.') }}</td>
                    <td>{{ $s->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
