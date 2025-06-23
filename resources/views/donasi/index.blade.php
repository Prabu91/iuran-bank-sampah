<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Riwayat Donasi PBI JK</h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('donasi.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah Donasi</a>

        <table class="w-full mt-4 table-auto border">
            <thead>
                <tr class="bg-gray-100">
                    <th>Penabung</th>
                    <th>Jumlah Donasi</th>
                    <th>Jumlah Penerima</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donasi as $d)
                <tr class="border-t">
                    <td>{{ $d->penabung->name }}</td>
                    <td>Rp {{ number_format($d->jumlah_donasi, 0, ',', '.') }}</td>
                    <td>{{ $d->jumlah_penerima }} Orang</td>
                    <td>{{ $d->tanggal }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
