<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Data Unit BSB</h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('penabung.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">+ Tambah Unit</a>

        <table class="w-full mt-4 table-auto border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">Nama Unit</th>
                    <th>Nama PIC</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penabung as $p)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $p->unit_name }}</td>
                    <td>{{ $p->pic_name }}</td>
                    <td>{{ $p->phone }}</td>
                    <td>{{ $p->address }}</td>
                    <td class="space-x-2">
                        <a href="{{ route('penabung.edit', $p->id) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('penabung.destroy', $p->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
