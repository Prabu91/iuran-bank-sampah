<x-app-layout class="flex flex-col space-y-4 px-4">
    <div class="bg-white shadow-md rounded-lg p-4 md:p-6 mb-6 w-full">
        <div class="flex items-center justify-between flex-col md:flex-row">
            <x-header-page>
                {{ __('Riwayat Donasi PBI JK') }}
            </x-header-page>
            <a href="{{ route('donasi.create') }}" class="bg-primary hover:bg-hoverPrimary text-text-light font-bold py-2 px-4 rounded mt-2 md:mt-0">
                Tambah Donasi
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto w-full mt-4">
            <table id="donasiTable" class="min-w-full w-full bg-white border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border-b text-left">Tanggal</th>
                        <th class="px-4 py-2 border-b text-left">Nama Peserta</th>
                        <th class="px-4 py-2 border-b text-left">Nama Unit</th>
                        <th class="px-4 py-2 border-b text-left">Jumlah Donasi</th>
                        <th class="px-4 py-2 border-b text-left">Status</th>
                        <th class="px-4 py-2 border-b text-center">Bukti</th>
                        <th class="px-4 py-2 border-b text-center">Aksi</th>
                        <th class="px-4 py-2 border-b text-center">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donasis as $donasi)
                    <tr class="border-t">
                        <td class="p-2 border">{{ \Carbon\Carbon::parse($donasi->tanggal)->format('d/m/Y') }}</td>
                        <td class="p-2 border">{{ $donasi->peserta->nama }}</td>
                        <td class="p-2 border">{{ $donasi->unit->unit_name }}</td>
                        <td class="p-2 border">Rp {{ number_format($donasi->jumlah_donasi, 0, ',', '.') }}</td>
                        <td class="p-2 border">
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
                        </td>
                        <td class="p-2 border text-center">
                            @if ($donasi->bukti_tf)
                            <button type="button" class="viewBuktiButton text-blue-500 hover:underline" data-image-url="{{ asset('storage/' . $donasi->bukti_tf) }}">
                                Lihat
                            </button>
                            @else
                            <form action="{{ route('donasi.upload_bukti', $donasi->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-center gap-2">
                                @csrf
                                @method('PUT')
                                <input type="file" name="bukti_tf" accept="image/*" required class="text-xs max-w-[100px]">
                                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded text-xs">Upload</button>
                            </form>
                            @endif
                        </td>
                        <td class="p-2 border text-center">
                            @if (Auth::user()->role === 'admin' && $donasi->status === 'menunggu approval')
                            <div class="flex items-center justify-center space-x-2">
                                <button type="button" 
                                class="approveButton inline-flex items-center justify-center bg-green-500 hover:bg-green-400 text-white px-3 py-1.5 rounded text-sm font-medium"
                                data-id="{{ $donasi->id }}">
                                Approve
                            </button>
                            <button type="button" 
                            class="deleteButton bg-red-500 hover:bg-red-400 text-white px-3 py-1.5 rounded text-sm font-medium"
                            data-id="{{ $donasi->id }}" 
                            data-nama-peserta="{{ $donasi->peserta->nama }}">
                            Hapus
                        </button>
                    </div>
                    @elseif (Auth::user()->role === 'petugas' && $donasi->status === 'menunggu bukti')
                    <button type="button" 
                    class="deleteButton bg-red-500 hover:bg-red-400 text-white px-3 py-1.5 rounded text-sm font-medium"
                    data-id="{{ $donasi->id }}" 
                    data-nama-peserta="{{ $donasi->peserta->nama }}">
                    Hapus
                </button>
                @else
                <span class="text-gray-400 text-sm italic">-</span>
                @endif
            </td>
            <td class="p-2 border">
                <a href="{{ route('donasi.show', $donasi->id) }}" class="inline-flex items-center justify-center bg-blue-500 hover:bg-blue-400 text-white px-3 py-1.5 rounded text-sm font-medium">Detail</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center py-4">Belum ada data donasi.</td>
        </tr>
        @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="confirmationModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h3>
            <p id="modalMessage">Apakah Anda yakin ingin menghapus data ini?</p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end mt-4">
                    <button type="button" id="cancelButton" class="mr-2 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md">Batal</button>
                    <button type="submit" id="confirmButton" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-md">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
    
    <div id="buktiSetorModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Bukti Donasi</h3>
                <button type="button" id="closeBuktiModal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <img id="buktiSetorImage" src="" alt="Bukti Donasi" class="w-full h-auto max-w-full rounded-lg object-contain">
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <script>
            $(document).ready(function () {
                $('#donasiTable').DataTable({
                    responsive: true,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        paginate: {
                            previous: "Sebelumnya",
                            next: "Berikutnya"
                        },
                        zeroRecords: "Data tidak ditemukan",
                    },
                    initComplete: function () {
                        $('select.dt-input').addClass('px-3 py-2 rounded-md border border-gray-300 text-sm');
                        $('select.dt-input').css('padding-right', '1rem');
                    }
                });

                // Script untuk modal Hapus
                const deleteModal = document.getElementById("confirmationModal");
                const deleteCancelButton = document.getElementById("cancelButton");
                const modalMessage = document.getElementById("modalMessage");
                const deleteForm = document.getElementById("deleteForm");

                document.querySelectorAll(".deleteButton").forEach(button => {
                    button.addEventListener("click", function () {
                        const donasiId = this.getAttribute("data-id");
                        const namaPeserta = this.getAttribute("data-nama-peserta");
                        modalMessage.innerText = `Apakah Anda yakin ingin menghapus donasi untuk "${namaPeserta}"?`;
                        deleteForm.setAttribute("action", `{{ url('donasi') }}/${donasiId}`);
                        deleteModal.classList.remove("hidden");
                    });
                });

                deleteCancelButton.addEventListener("click", function () {
                    deleteModal.classList.add("hidden");
                });
                
                // Script untuk modal Approve
                document.querySelectorAll(".approveButton").forEach(button => {
                    button.addEventListener("click", function (e) {
                        e.preventDefault();
                        const donasiId = this.getAttribute("data-id");
                        console.log("Donasi ID:", donasiId); // Tambahkan baris ini untuk debugging

                        if (confirm('Setujui donasi ini?')) {
                            // Buat form dinamis
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `{{ url('donasi') }}/${donasiId}/approve`;
                            form.innerHTML = `@csrf @method('PUT')`;

                            // Kirim form
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });


                // Script untuk modal Bukti Donasi
                const buktiSetorModal = document.getElementById("buktiSetorModal");
                const buktiSetorImage = document.getElementById("buktiSetorImage");
                const closeBuktiModalButton = document.getElementById("closeBuktiModal");

                document.querySelectorAll(".viewBuktiButton").forEach(button => {
                    button.addEventListener("click", function () {
                        const imageUrl = this.getAttribute("data-image-url");
                        buktiSetorImage.src = imageUrl;
                        buktiSetorModal.classList.remove("hidden");
                    });
                });

                closeBuktiModalButton.addEventListener("click", function () {
                    buktiSetorModal.classList.add("hidden");
                });
            });
        </script>
    @endpush
</x-app-layout>