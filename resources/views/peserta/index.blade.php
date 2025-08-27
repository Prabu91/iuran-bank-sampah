<x-app-layout class="flex flex-col space-y-4 px-4">

    <div class="bg-white shadow-md rounded-lg p-8 mb-6 md:w-full">
        <div class="flex items-center justify-between flex-col md:flex-row">
            <x-header-page>
                {{ __('Data Peserta') }}
            </x-header-page>
            <a href="{{ route('peserta.create') }}" class="bg-primary hover:bg-hoverPrimary text-text-light font-bold py-2 px-4 rounded mt-2 md:mt-0">
                Tambah Peserta
            </a>
        </div>

        <div class="overflow-x-auto w-full">
            <table id="pesertaTable" class="min-w-full w-full bg-white border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border-b">NIK</th>
                        <th class="px-4 py-2 border-b">Nama</th>
                        <th class="px-4 py-2 border-b">No. Kartu</th>
                        <th class="px-4 py-2 border-b">No. HP</th>
                        <th class="px-4 py-2 border-b">Kecamatan</th>
                        <th class="px-4 py-2 border-b">Bln Menunggak</th>
                        <th class="px-4 py-2 border-b">Total Tagihan</th>
                        <th class="px-4 py-2 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesertas as $peserta)
                        <tr class="border-t">
                            <td class="p-2 border">{{ $peserta->nik }}</td>
                            <td class="p-2 border">{{ $peserta->nama }}</td>
                            <td class="p-2 border">{{ $peserta->noka }}</td>
                            <td class="p-2 border">{{ $peserta->no_hp }}</td>
                            <td class="p-2 border">{{ $peserta->kecamatan }}</td>
                            <td class="p-2 border">{{ $peserta->bln_menunggak }}</td>
                            <td class="p-2 border">Rp{{ number_format($peserta->total_tagihan, 0, ',', '.') }}</td>
                            <td class="p-2 border">
                                <a href="{{ route('peserta.edit', $peserta->id) }}" class="inline-flex items-center justify-center bg-blue-500 hover:bg-blue-400 text-white px-3 py-1.5 rounded text-sm font-medium">Edit</a>
                                <button type="button" 
                                    class="deleteButton inline-flex items-center justify-center bg-red-500 hover:bg-red-400 text-white px-3 py-1.5 rounded text-sm font-medium"
                                    data-id="{{ $peserta->id }}" 
                                    data-name="{{ $peserta->name }}">
                                        Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-4">Belum ada data peserta.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div id="confirmationModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
                <p id="modalMessage">Apakah Anda yakin ingin menghapus data pengguna?</p>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end mt-4">
                        <button type="button" id="cancelButton" class="mr-2 px-4 py-2 bg-btn hover:bg-btnh text-txtd rounded-md">Batal</button>
                        <button type="submit" id="confirmButton" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-md">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#pesertaTable').DataTable({
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

                // Modal hapus (sama seperti sebelumnya)
                const modal = document.getElementById("confirmationModal");
                const cancelButton = document.getElementById("cancelButton");
                const modalMessage = document.getElementById("modalMessage");
                const deleteForm = document.getElementById("deleteForm");

                document.querySelectorAll(".deleteButton").forEach(button => {
                    button.addEventListener("click", function () {
                        const userId = this.getAttribute("data-id");
                        const userName = this.getAttribute("data-name");
                        modalMessage.innerText = `Apakah Anda yakin ingin menghapus data "${userName}"?`;
                        deleteForm.setAttribute("action", `/users/${userId}`);
                        modal.classList.remove("hidden");
                    });
                });

                cancelButton.addEventListener("click", function () {
                    modal.classList.add("hidden");
                });
            });
        </script>
    @endpush
</x-app-layout>
