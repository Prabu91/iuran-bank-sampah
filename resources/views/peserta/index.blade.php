<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Data Peserta</h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('peserta.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah Peserta</a>

        <table class="w-full mt-4 table-auto border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">NIK</th>
                    <th>Nama</th>
                    <th>No. Kartu</th>
                    <th>No. HP</th>
                    <th>Kecamatan</th>
                    <th>Bln Menunggak</th>
                    <th>Total Tagihan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesertas as $peserta)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $peserta->nik }}</td>
                        <td>{{ $peserta->nama }}</td>
                        <td>{{ $peserta->noka }}</td>
                        <td>{{ $peserta->no_hp }}</td>
                        <td>{{ $peserta->kecamatan }}</td>
                        <td>{{ $peserta->bln_menunggak }}</td>
                        <td>Rp{{ number_format($peserta->total_tagihan, 0, ',', '.') }}</td>
                        <td class="space-x-2">
                            <a href="{{ route('peserta.edit', $peserta->id) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('peserta.destroy', $peserta->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center py-4">Belum ada data peserta.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
