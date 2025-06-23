<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Donasi untuk Peserta Non-Aktif BPJS (PBI JK)</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('donasi.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block">Nama Penabung:</label>
                <select name="penabung_id" class="w-full p-2 border rounded" required>
                    <option value="">-- Pilih Penabung --</option>
                    @foreach($penabung as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block">Jumlah Donasi (Rp):</label>
                <input type="number" name="jumlah_donasi" required class="w-full p-2 border rounded" />
            </div>

            <div>
                <label class="block">Untuk Berapa Orang?:</label>
                <input type="number" name="jumlah_penerima" required class="w-full p-2 border rounded" />
            </div>

            <div>
                <label class="block">Tanggal Donasi:</label>
                <input type="date" name="tanggal" required class="w-full p-2 border rounded" />
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>
