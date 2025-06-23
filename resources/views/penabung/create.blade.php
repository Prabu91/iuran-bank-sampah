<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Tambah Unit</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('penabung.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block">Nama Unit:</label>
                <input type="text" name="unit_name" required class="w-full rounded border p-2" />
            </div>
            <div>
                <label class="block">Nama PIC:</label>
                <input type="text" name="pic_name" required class="w-full rounded border p-2" />
            </div>
            <div>
                <label class="block">Alamat:</label>
                <textarea name="address" required class="w-full rounded border p-2"></textarea>
            </div>
            <div>
                <label class="block">No HP:</label>
                <input type="text" name="phone" required class="w-full rounded border p-2" />
            </div>
            <button class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>
