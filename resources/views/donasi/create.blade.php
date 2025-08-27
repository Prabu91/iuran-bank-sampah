<x-app-layout class="container mx-auto flex flex-col md:flex-row md:space-x-8 px-4">
    <div class="container mx-auto max-w-lg p-8 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl text-center font-bold text-primary">Donasi untuk Peserta Non-Aktif BPJS (PBI JK)</h1>

        <div class="relative w-full">
            <form id="donasiForm" action="{{ route('donasi.store') }}" method="POST" class="p-4">
                @csrf

                {{-- UNIT --}}
                <div>
                    <label class="mt-4 block text-md font-medium text-gray-700">Nama Unit</label>
                    <select name="unit_id" id="unit_id"
                        class="mt-1 block w-full px-3 py-2 border @error('unit_id') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600"
                        onchange="tampilkanSaldoUnit()" required>
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
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div id="saldoUnit" class="bg-yellow-50 p-3 rounded border border-yellow-300 mt-2 hidden">
                        <p><strong>Saldo Unit:</strong> <span id="unit_saldo" class="font-semibold text-yellow-700"></span></p>
                    </div>
                </div>

                {{-- PESERTA --}}
                <div>
                    <label class="mt-4 block text-md font-medium text-gray-700">Pilih Peserta</label>
                    <select name="peserta_id" id="peserta_id"
                        class="mt-1 block w-full px-3 py-2 border @error('peserta_id') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600"
                        onchange="tampilkanDetailPeserta()" required>
                        <option value="">-- Pilih Peserta --</option>
                        @foreach($pesertas as $peserta)
                            <option value="{{ $peserta->id }}"
                                {{ old('peserta_id') == $peserta->id ? 'selected' : '' }}
                                data-nik="{{ $peserta->nik }}"
                                data-nohp="{{ $peserta->no_hp }}"
                                data-alamat="{{ $peserta->alamat }}"
                                data-kecamatan="{{ $peserta->kecamatan }}"
                                data-menunggak="{{ $peserta->bln_menunggak }}"
                                data-tagihan="{{ $peserta->total_tagihan }}">
                                {{ $peserta->nama }} - {{ $peserta->nik }}
                            </option>
                        @endforeach
                    </select>
                    @error('peserta_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    <div id="detailPeserta" class="bg-gray-100 p-4 rounded mt-2 hidden">
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
                    <label class="mt-4 block text-md font-medium text-gray-700">Jumlah Donasi (Rp)</label>
                    <input type="number" name="jumlah_donasi" id="jumlah_donasi" value="{{ old('jumlah_donasi') }}"
                        class="mt-1 block w-full px-3 py-2 border @error('jumlah_donasi') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 bg-gray-100 cursor-not-allowed"
                        placeholder="Jumlah Donasi" required readonly>
                    @error('jumlah_donasi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- KETERANGAN --}}
                <div>
                    <label class="mt-4 block text-md font-medium text-gray-700">Keterangan</label>
                    <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                        class="mt-1 block w-full px-3 py-2 border @error('keterangan') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600"
                        placeholder="Contoh: Donasi dari Unit A untuk Peserta B">
                    @error('keterangan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">
                    <a href="{{ route('donasi.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-200 text-gray-700 font-semibold rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Kembali
                    </a>

                    <button type="button" id="openModalButton"
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-md shadow-sm hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">
                        Simpan Donasi
                    </button>
                </div>
            </form>

            <div id="confirmationModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
                    <h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
                    <p>Apakah Anda yakin ingin menyimpan donasi ini?</p>
                    <div class="flex justify-end mt-4 gap-2">
                        <button id="cancelButton"
                            class="px-4 py-2 bg-gray-300 text-gray-700 hover:bg-gray-200 rounded-md">
                            Batal
                        </button>
                        <button id="confirmButton"
                            class="px-4 py-2 bg-green-600 hover:bg-green-500 text-white rounded-md">
                            Ya, Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Inisialisasi Select2
            $(document).ready(function() {
                $('#unit_id').select2({
                    placeholder: "-- Pilih Unit --",
                    allowClear: true,
                    dropdownParent: $('#unit_id').parent()
                });
                $('#peserta_id').select2({
                    placeholder: "-- Pilih Peserta --",
                    allowClear: true,
                    dropdownParent: $('#peserta_id').parent()
                });
            });

            // Script untuk modal konfirmasi
            document.getElementById('openModalButton').addEventListener('click', function() {
                document.getElementById('confirmationModal').classList.remove('hidden');
            });

            document.getElementById('cancelButton').addEventListener('click', function() {
                document.getElementById('confirmationModal').classList.add('hidden');
            });

            document.getElementById('confirmButton').addEventListener('click', function() {
                document.getElementById('donasiForm').submit();
            });

            // Script untuk menampilkan saldo unit dan detail peserta
            function tampilkanDetailPeserta() {
                const select = document.getElementById('peserta_id');
                const selected = select.options[select.selectedIndex];
                const jumlahDonasiInput = document.getElementById('jumlah_donasi');

                if (!selected.value) {
                    document.getElementById('detailPeserta').classList.add('hidden');
                    jumlahDonasiInput.value = ''; 
                    return;
                }
                
                // Mengisi input jumlah donasi dengan total tagihan
                const totalTagihan = selected.getAttribute('data-tagihan');
                jumlahDonasiInput.value = totalTagihan;
                
                // Menampilkan detail peserta
                document.getElementById('peserta_nik').innerText = selected.getAttribute('data-nik');
                document.getElementById('peserta_nohp').innerText = selected.getAttribute('data-nohp');
                document.getElementById('peserta_alamat').innerText = selected.getAttribute('data-alamat');
                document.getElementById('peserta_kecamatan').innerText = selected.getAttribute('data-kecamatan');
                document.getElementById('peserta_menunggak').innerText = selected.getAttribute('data-menunggak');
                
                const formattedTagihan = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(totalTagihan);
                document.getElementById('peserta_tagihan').innerText = formattedTagihan;

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
    @endpush
</x-app-layout>