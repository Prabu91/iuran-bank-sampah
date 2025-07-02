<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Edit Peserta</h2>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto">
        <form action="{{ route('peserta.update', $peserta->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <x-input-label for="nik" value="NIK" />
            <x-text-input name="nik" type="text" class="w-full" value="{{ old('nik', $peserta->nik) }}" required />

            <x-input-label for="nama" value="Nama" />
            <x-text-input name="nama" type="text" class="w-full" value="{{ old('nama', $peserta->nama) }}" required />

            <x-input-label for="noka" value="No. Kartu" />
            <x-text-input name="noka" type="text" class="w-full" value="{{ old('noka', $peserta->noka) }}" required />

            <x-input-label for="no_hp" value="No. HP" />
            <x-text-input name="no_hp" type="text" class="w-full" value="{{ old('no_hp', $peserta->no_hp) }}" />

            <x-input-label for="alamat" value="Alamat" />
            <textarea name="alamat" class="w-full border rounded p-2">{{ old('alamat', $peserta->alamat) }}</textarea>

            <x-input-label for="kecamatan" value="Kecamatan" />
            <x-text-input name="kecamatan" type="text" class="w-full" value="{{ old('kecamatan', $peserta->kecamatan) }}" />

            <x-input-label for="bln_menunggak" value="Bulan Menunggak" />
            <x-text-input name="bln_menunggak" type="number" class="w-full" value="{{ old('bln_menunggak', $peserta->bln_menunggak) }}" />

            <x-input-label for="total_tagihan" value="Total Tagihan (Rp)" />
            <x-text-input name="total_tagihan" type="number" class="w-full" value="{{ old('total_tagihan', $peserta->total_tagihan) }}" />

            <x-primary-button>Update</x-primary-button>
        </form>
    </div>
</x-app-layout>
