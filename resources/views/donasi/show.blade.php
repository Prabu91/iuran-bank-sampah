<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-gray-800">
            {{ __('Detail Donasi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Informasi Donasi</h3>
                        <p><strong>Jumlah Donasi:</strong> Rp{{ number_format($donasi->jumlah_donasi, 0, ',', '.') }}</p>
                        <p><strong>Tanggal Donasi:</strong> {{ \Carbon\Carbon::parse($donasi->tanggal)->format('d F Y') }}</p>
                        <p><strong>Keterangan:</strong> {{ $donasi->keterangan ?? '-' }}</p>
                        <p><strong>Status:</strong>
                            @php
                                $badgeColor = match($donasi->status) {
                                    'menunggu bukti' => 'bg-yellow-200 text-yellow-800',
                                    'menunggu approval' => 'bg-blue-200 text-blue-800',
                                    'disetujui' => 'bg-green-200 text-green-800',
                                    'ditolak' => 'bg-red-200 text-red-800',
                                    default => 'bg-gray-200 text-gray-800',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColor }}">
                                {{ ucfirst($donasi->status) }}
                            </span>
                        </p>
                    </div>

                    <hr class="my-6">

                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Data Peserta Donasi</h3>
                        <p><strong>Nama Peserta:</strong> {{ $donasi->peserta->nama }}</p>
                        <p><strong>NIK:</strong> {{ $donasi->peserta->nik }}</p>
                        <p><strong>Alamat:</strong> {{ $donasi->peserta->alamat }}</p>
                        <p><strong>Kecamatan:</strong> {{ $donasi->peserta->kecamatan }}</p>
                        <p><strong>Bulan Menunggak:</strong> {{ $donasi->peserta->bln_menunggak }} bulan</p>
                        <p><strong>Total Tagihan:</strong> Rp{{ number_format($donasi->peserta->total_tagihan, 0, ',', '.') }}</p>
                    </div>

                    <hr class="my-6">

                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Data Unit Pemberi Donasi</h3>
                        <p><strong>Nama Unit:</strong> {{ $donasi->unit->unit_name }}</p>
                        <p><strong>Alamat Unit:</strong> {{ $donasi->unit->address }}</p>
                    </div>

                    @if ($donasi->bukti_tf)
                        <hr class="my-6">
                        <div class="mt-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Bukti Transfer</h3>
                            {{-- <a href="{{ asset('storage/' . $donasi->bukti_tf) }}" target="_blank" class="text-blue-600 underline">Lihat Bukti Transfer</a> --}}
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $donasi->bukti_tf) }}" alt="Bukti Transfer" class="max-w-xs md:max-w-md rounded-lg shadow-md">
                            </div>
                        </div>
                    @endif

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('donasi.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>