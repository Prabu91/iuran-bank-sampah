<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Tambah Setoran</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('setoran.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block">Unit:</label>
                <select name="unit_id" class="w-full p-2 border rounded" required>
                    <option value="">-- Pilih Unit --</option>
                    @foreach($penabung as $p)
                        <option value="{{ $p->id }}">{{ $p->unit_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block">type:</label>
                <select name="type" class="w-full p-2 border rounded" required>
                    <option value="">-- Pilih tipe --</option>
                    <option value="nabung">Nabung</option>
                    <option value="donasi">Donasi</option>
                </select>
            </div>

            <div>
                <label class="block">Nama Penyetor:</label>
                <input type="text" name="nama_penyetor" required class="w-full p-2 border rounded" />
            </div>
            
            <div>
                <label class="block">Tanggal:</label>
                <input type="date" name="tanggal" required class="w-full p-2 border rounded" />
            </div>

            <div>
                <label class="block">Sampah:</label>
                <input type="text" name="sampah" required class="w-full p-2 border rounded" />
            </div>
            
            <div>
                <label class="block">Jumlah (Kg):</label>
                <input type="number" step="0.01" name="jumlah_kg" required class="w-full p-2 border rounded" />
            </div>
            
            <div>
                <label class="block">Total (Rp):</label>
                <input type="number" name="nominal" required class="w-full p-2 border rounded" />
            </div>
            
            <div>
                <label class="block">Keterangan:</label>
                <input type="text" name="keterangan" class="w-full p-2 border rounded" />
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>
