<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Donasi untuk Peserta Non-Aktif BPJS (PBI JK)</h2>
    </x-slot>

    <div class="p-6 max-w-2xl mx-auto">
        <form action="{{ route('donasi.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- UNIT --}}
            <div>
                <label for="unit_id" class="block font-medium">Nama Unit:</label>
                <select name="unit_id" id="unit_id" class="w-full border rounded p-2" onchange="tampilkanSaldoUnit()">
                    <option value="">-- Pilih Unit --</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}"
                            {{ old('unit_id') == $unit->id ? 'selected' : '' }}
                            data-saldo="{{ number_format($unit->wallet?->balance ?? 0, 0, ',', '.') }}">
                            {{ $unit->unit_name }}
                        </option>
                    @endforeach
                </select>
                @error('unit_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror

                <div id="saldoUnit" class="bg-yellow-50 p-3 rounded border border-yellow-300 mt-2 hidden">
                    <p><strong>Saldo Unit:</strong> <span id="unit_saldo" class="font-semibold text-yellow-700"></span></p>
                </div>
            </div>

            {{-- PESERTA --}}
            <div>
                <label for="peserta_id" class="block font-medium">Pilih Peserta:</label>
                <select name="peserta_id" id="peserta_id" class="w-full border rounded p-2" onchange="tampilkanDetailPeserta()">
                    <option value="">-- Pilih Peserta --</option>
                    @foreach($pesertas as $peserta)
                        <option value="{{ $peserta->id }}"
                            {{ old('peserta_id') == $peserta->id ? 'selected' : '' }}
                            data-nik="{{ $peserta->nik }}"
                            data-nohp="{{ $peserta->no_hp }}"
                            data-alamat="{{ $peserta->alamat }}"
                            data-kecamatan="{{ $peserta->kecamatan }}"
                            data-menunggak="{{ $peserta->bln_menunggak }}"
                            data-tagihan="{{ number_format($peserta->total_tagihan, 0, ',', '.') }}">
                            {{ $peserta->nama }} - {{ $peserta->nik }}
                        </option>
                    @endforeach
                </select>
                @error('peserta_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror

                {{-- Detail Peserta --}}
                <div id="detailPeserta" class="bg-gray-100 p-4 rounded hidden mt-2">
                    <p><strong>NIK:</strong> <span id="peserta_nik"></span></p>
                    <p><strong>No HP:</strong> <span id="peserta_nohp"></span></p>
                    <p><strong>Alamat:</strong> <span id="peserta_alamat"></span></p>
                    <p><strong>Kecamatan:</strong> <span id="peserta_kecamatan"></span></p>
                    <p><strong>Bulan Menunggak:</strong> <span id="peserta_menunggak"></span></p>
                    <p><strong>Total Tagihan:</strong> <span id="peserta_tagihan"></span></p>
                </div>
            </div>

            {{-- JUMLAH DONASI --}}
            <div>
                <label for="jumlah_donasi" class="block font-medium">Jumlah Donasi (Rp):</label>
                <input type="number" name="jumlah_donasi" id="jumlah_donasi" value="{{ old('jumlah_donasi') }}" required class="w-full p-2 border rounded" />
                @error('jumlah_donasi')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- TANGGAL --}}
            <div>
                <label for="tanggal" class="block font-medium">Tanggal Donasi:</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" required class="w-full p-2 border rounded" />
                @error('tanggal')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- KETERANGAN --}}
            <div>
                <label for="keterangan" class="block font-medium">Keterangan (Opsional):</label>
                <textarea name="keterangan" id="keterangan" class="w-full border rounded p-2">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded">Simpan Donasi</button>
        </form>
    </div>

    <script>
        function tampilkanDetailPeserta() {
            const select = document.getElementById('peserta_id');
            const selected = select.options[select.selectedIndex];
            if (!selected.value) {
                document.getElementById('detailPeserta').classList.add('hidden');
                return;
            }

            document.getElementById('peserta_nik').innerText = selected.getAttribute('data-nik');
            document.getElementById('peserta_nohp').innerText = selected.getAttribute('data-nohp');
            document.getElementById('peserta_alamat').innerText = selected.getAttribute('data-alamat');
            document.getElementById('peserta_kecamatan').innerText = selected.getAttribute('data-kecamatan');
            document.getElementById('peserta_menunggak').innerText = selected.getAttribute('data-menunggak');
            document.getElementById('peserta_tagihan').innerText = 'Rp' + selected.getAttribute('data-tagihan');

            document.getElementById('detailPeserta').classList.remove('hidden');
        }

        function tampilkanSaldoUnit() {
            const select = document.getElementById('unit_id');
            const selected = select.options[select.selectedIndex];
            if (!selected.value) {
                document.getElementById('saldoUnit').classList.add('hidden');
                return;
            }

            const saldo = selected.getAttribute('data-saldo');
            document.getElementById('unit_saldo').innerText = 'Rp' + saldo;
            document.getElementById('saldoUnit').classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('unit_id').value) {
                tampilkanSaldoUnit();
            }
            if (document.getElementById('peserta_id').value) {
                tampilkanDetailPeserta();
            }
        });
    </script>
</x-app-layout>
