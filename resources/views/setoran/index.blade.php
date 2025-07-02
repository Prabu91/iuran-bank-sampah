<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Riwayat Setoran</h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('setoran.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">+ Tambah Setoran</a>

        <table class="w-full mt-4 table-auto border">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2">Tanggal</th>
                    <th class="p-2">Nama Unit</th>
                    <th class="p-2">Nama Penyetor</th>
                    <th class="p-2">Tipe Setoran</th>
                    <th class="p-2">Nominal</th>
                    <th class="p-2">Keterangan</th>
                    <th class="p-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse($setoran as $s)
                <tr class="border-t">
                    <td class="p-2">{{ \Carbon\Carbon::parse($s->tanggal)->format('d/m/Y') }}</td>
                    <td class="p-2">{{ $s->unit->unit_name }}</td>
                    <td class="p-2">{{ $s->nama_penyetor }}</td>
                    <td class="p-2 capitalize">{{ $s->type }}</td>
                    <td class="p-2">Rp {{ number_format($s->nominal, 0, ',', '.') }}</td>
                    <td class="p-2">{{ $s->keterangan }}</td>
                    <td class="p-2 space-x-1">
                        <a href="{{ route('setoran.edit', $s->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded text-sm">Edit</a>

                        <form action="{{ route('setoran.destroy', $s->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-4 text-gray-500 text-center">Belum ada data setoran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
