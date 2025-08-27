<div class="bg-white rounded-lg shadow-lg p-6">
    <h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
    <p id="modalMessage">Apakah Anda yakin ingin menghapus data ini?</p>
    <div class="flex justify-end mt-4">
        <button id="cancelButton" class="mr-2 px-4 py-2 bg-gray-300 hover:bg-gray-200 text-gray-700 rounded-md">Batal</button>
        <form id="deleteForm" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-md">Ya, Hapus</button>
        </form>
    </div>
</div>