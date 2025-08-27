<x-app-layout class="container mx-auto flex flex-col md:flex-row md:space-x-8 px-4">
    
    <div class="bg-white shadow-md rounded-lg p-8 mb-6 md:w-full">
        <div class="flex items-center justify-between flex-col md:flex-row">
            <x-header-page>
                {{ __('Manajemen User') }}
            </x-header-page>
            <a href="{{ route('users.create') }}" class="bg-primary hover:bg-hoverPrimary text-text-light font-bold py-2 px-4 rounded mt-2 md:mt-0">
                Tambah Data
            </a>
        </div>

        <div class="overflow-x-auto">
            <table id="usersTable" class="min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border-b">Nama</th>
                        <th class="px-4 py-2 border-b">Username</th>
                        <th class="px-4 py-2 border-b">Email</th>
                        <th class="px-4 py-2 border-b">Role</th>
                        <th class="px-4 py-2 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="border-t">
                        <td class="p-2 border">{{ $user->name }}</td>
                        <td class="p-2 border">{{ $user->username }}</td>
                        <td class="p-2 border">{{ $user->email }}</td>
                        <td class="p-2 border capitalize">{{ $user->role }}</td>
                        <td class="p-2 border">
                            <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center justify-center bg-blue-500 hover:bg-blue-400 text-white px-3 py-1.5 rounded text-sm font-medium">Edit</a>
                            <button type="button" 
                                    class="deleteButton inline-flex items-center justify-center bg-red-500 hover:bg-red-400 text-white px-3 py-1.5 rounded text-sm font-medium"
                                    data-id="{{ $user->id }}" 
                                    data-name="{{ $user->name }}">
                                    Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
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
                $('#usersTable').DataTable({
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
