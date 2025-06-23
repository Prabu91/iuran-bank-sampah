<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Edit Data Unit</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('penabung.update', $penabung->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block">Nama Unit:</label>
                <input type="text" name="unit_name" value="{{ $penabung->unit_name }}" required class="w-full rounded border p-2" />
            </div>
            <div>
                <label class="block">Nama PIC:</label>
                <input type="text" name="pic_name" value="{{ $penabung->pic_name }}" required class="w-full rounded border p-2" />
            </div>
            <div>
                <label class="block">Alamat:</label>
                <textarea name="address" required class="w-full rounded border p-2">{{ $penabung->address }}</textarea>
            </div>
            <div>
                <label class="block">No HP:</label>
                <input type="text" name="phone" value="{{ $penabung->phone }}" required class="w-full rounded border p-2" />
            </div>

            <div class="flex space-x-2">
                <button class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
                <a href="{{ route('penabung.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
