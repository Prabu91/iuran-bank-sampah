<x-app-layout class="flex flex-col space-y-4 px-4">
    <div class="bg-white shadow-md rounded-lg p-4 md:p-6 mb-6 w-full">
        <div class="flex items-center justify-between flex-col md:flex-row">
            <x-header-page>
                {{ __('Riwayat Setoran') }}
            </x-header-page>
            <a href="{{ route('setoran.create') }}" class="bg-primary hover:bg-hoverPrimary text-text-light font-bold py-2 px-4 rounded mt-2 md:mt-0">
                Tambah Setoran
            </a>
        </div>

        <div class="overflow-x-auto w-full mt-4">
            <table id="setoranTable" class="min-w-full w-full bg-white border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border-b text-left">Tanggal</th>
                        <th class="px-4 py-2 border-b text-left">Nama Unit</th>
                        <th class="px-4 py-2 border-b text-left">Nama Penyetor</th>
                        <th class="px-4 py-2 border-b text-left">Sampah</th>
                        <th class="px-4 py-2 border-b text-left">Nominal</th>
                        <th class="px-4 py-2 border-b text-left">Keterangan</th>
                        <th class="px-4 py-2 border-b text-center">Bukti Setor</th>
                        <th class="px-4 py-2 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($setoran as $s)
                    <tr class="border-t">
                        <td class="p-2 border">{{ \Carbon\Carbon::parse($s->tanggal)->format('d/m/Y') }}</td>
                        <td class="p-2 border">{{ $s->unit->unit_name }}</td>
                        <td class="p-2 border">{{ $s->nama_penyetor }}</td>
                        <td class="p-2 border capitalize">{{ $s->sampah }}</td>
                        <td class="p-2 border">Rp {{ number_format($s->nominal, 0, ',', '.') }}</td>
                        <td class="p-2 border">{{ $s->keterangan }}</td>
                        <td class="p-2 border text-center">
                            @if($s->bukti_setor_path)
                                <button type="button" class="viewBuktiButton text-blue-500 hover:underline" 
                                    data-image-url="{{ Storage::url($s->bukti_setor_path) }}">
                                    Lihat
                                </button>
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-2 border text-center space-x-1">
                            <a href="{{ route('setoran.edit', $s->id) }}" class="inline-flex items-center justify-center bg-yellow-500 hover:bg-yellow-400 text-white px-3 py-1.5 rounded text-sm font-medium">Edit</a>
                            <button type="button" 
                                class="deleteButton inline-flex items-center justify-center bg-red-500 hover:bg-red-400 text-white px-3 py-1.5 rounded text-sm font-medium"
                                data-id="{{ $s->id }}" 
                                data-name="{{ $s->nama_penyetor }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">Belum ada data setoran.</td>
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
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full max-h-[90vh] overflow-y-auto"> {{-- Tambah max-w-lg dan max-h-[90vh] --}}
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Bukti Setor</h3>
                <button type="button" id="closeBuktiModal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <img id="buktiSetorImage" src="" alt="Bukti Setor" class="w-full h-auto max-w-full rounded-lg object-contain"> {{-- Tambah max-w-full dan object-contain --}}
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <script>
            $(document).ready(function () {
                $('#setoranTable').DataTable({
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
                        const setoranId = this.getAttribute("data-id");
                        const namaPenyetor = this.getAttribute("data-name");
                        modalMessage.innerText = `Apakah Anda yakin ingin menghapus setoran dari "${namaPenyetor}"?`;
                        deleteForm.setAttribute("action", `{{ url('setoran') }}/${setoranId}`);
                        deleteModal.classList.remove("hidden");
                    });
                });

                deleteCancelButton.addEventListener("click", function () {
                    deleteModal.classList.add("hidden");
                });

                // Script untuk modal Bukti Setor
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