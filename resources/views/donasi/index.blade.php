<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Riwayat Donasi PBI JK</h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('donasi.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah Donasi</a>

        <table class="w-full mt-4 table-auto border">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Nama Peserta</th>
                    <th class="px-4 py-2">Nama Unit</th>
                    <th class="px-4 py-2">Jumlah Donasi</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Bukti</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donasis as $donasi)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($donasi->tanggal)->format('d M Y') }}</td>
                    <td class="px-4 py-2">{{ $donasi->nama_peserta }}</td>
                    <td class="px-4 py-2">{{ $donasi->unit->unit_name }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($donasi->jumlah_donasi, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">
                        @php
                            $badgeColor = match($donasi->status) {
                                'menunggu bukti' => 'bg-yellow-200 text-yellow-800',
                                'menunggu approval' => 'bg-blue-200 text-blue-800',
                                'disetujui' => 'bg-green-200 text-green-800',
                                default => 'bg-gray-200 text-gray-800',
                            };
                        @endphp
                        <span class="px-2 py-1 rounded text-sm {{ $badgeColor }}">
                            {{ ucfirst($donasi->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        @if ($donasi->bukti_tf)
                            <a href="{{ asset('storage/' . $donasi->bukti_tf) }}" target="_blank" class="text-blue-600 underline">
                                Lihat Bukti
                            </a>
                        @elseif($donasi->status === 'menunggu bukti')
                            <form action="{{ route('donasi.upload_bukti', $donasi->id) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <input type="file" name="bukti_tf" accept="image/*,application/pdf" required class="text-sm">
                                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded text-sm">Upload</button>
                            </form>
                        @else
                            <span class="text-gray-500 italic">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if (Auth::user()->role === 'admin' && $donasi->status === 'menunggu approval')
                            <form action="{{ route('donasi.approve', $donasi->id) }}" method="POST" onsubmit="return confirm('Setujui donasi ini?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm">Approve</button>
                            </form>
                        @else
                            <span class="text-gray-400 text-sm italic">-</span>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
