<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Edit Setoran</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('setoran.update', $setoran->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block">Unit:</label>
                <select name="unit_id" class="w-full p-2 border rounded" required>
                    <option value="">-- Pilih Unit --</option>
                    @foreach($penabung as $p)
                        <option value="{{ $p->id }}" {{ $setoran->unit_id == $p->id ? 'selected' : '' }}>
                            {{ $p->unit_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block">Type:</label>
                <select name="type" class="w-full p-2 border rounded" required>
                    <option value="">-- Pilih tipe --</option>
                    <option value="nabung" {{ $setoran->type == 'nabung' ? 'selected' : '' }}>Nabung</option>
                    <option value="donasi" {{ $setoran->type == 'donasi' ? 'selected' : '' }}>Donasi</option>
                </select>
            </div>

            <div>
                <label class="block">Nama Penyetor:</label>
                <input type="text" name="nama_penyetor" value="{{ $setoran->nama_penyetor }}" required class="w-full p-2 border rounded" />
            </div>
            
            <div>
                <label class="block">Tanggal:</label>
                <input type="date" name="tanggal" value="{{ $setoran->tanggal->format('Y-m-d') }}" required class="w-full p-2 border rounded" />
            </div>

            <div>
                <label class="block">Sampah:</label>
                <input type="text" name="sampah" value="{{ $setoran->sampah }}" required class="w-full p-2 border rounded" />
            </div>
            
            <div>
                <label class="block">Jumlah (Kg):</label>
                <input type="number" step="0.01" name="jumlah_kg" value="{{ $setoran->jumlah_kg }}" required class="w-full p-2 border rounded" />
            </div>
            
            <div>
                <label class="block">Total (Rp):</label>
                <input type="number" name="nominal" value="{{ $setoran->nominal }}" required class="w-full p-2 border rounded" />
            </div>
            
            <div>
                <label class="block">Keterangan:</label>
                <input type="text" name="keterangan" value="{{ $setoran->keterangan }}" required class="w-full p-2 border rounded" />
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
</x-app-layout>
