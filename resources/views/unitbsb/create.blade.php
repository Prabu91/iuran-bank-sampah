<x-app-layout class="container mx-auto flex flex-col md:flex-row md:space-x-8 px-4 py-auto">
    <div class="container mx-auto max-w-lg p-8 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl text-center font-bold text-primary">Tambah Unit BSB</h1>

        <div class="relative w-full">
            <form id="unitForm" action="{{ route('unitbsb.store') }}" method="POST" class="p-4">
                @csrf

                <div>
                    <label class="mt-4 block text-md font-medium text-gray-700">Nama Unit</label>
                    <input type="text" name="unit_name" value="{{ old('unit_name') }}"
                        class="mt-1 block w-full px-3 py-2 border @error('unit_name') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600"
                        placeholder="Nama Unit" required>
                    @error('unit_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mt-4 block text-md font-medium text-gray-700">Nama PIC</label>
                    <input type="text" name="pic_name" value="{{ old('pic_name') }}"
                        class="mt-1 block w-full px-3 py-2 border @error('pic_name') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600"
                        placeholder="Nama PIC" required>
                    @error('pic_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mt-4 block text-md font-medium text-gray-700">Alamat</label>
                    <textarea name="address"
                        class="mt-1 block w-full px-3 py-2 border @error('address') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600"
                        placeholder="Alamat" required>{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mt-4 block text-md font-medium text-gray-700">No HP</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="mt-1 block w-full px-3 py-2 border @error('phone') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600"
                        placeholder="Nomor HP" required>
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">
                    <a href="{{ url()->previous() }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-200 text-gray-700 font-semibold rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Kembali
                    </a>

                    <button type="button" id="openModalButton"
                        class="inline-flex items-center px-4 py-2 bg-primary text-white font-semibold rounded-md shadow-sm hover:bg-hoverPrimary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        Simpan Data
                    </button>
                </div>
            </form>

            <div id="confirmationModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
                    <h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
                    <p>Apakah Anda yakin ingin menyimpan data unit ini?</p>
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
            document.getElementById('openModalButton').addEventListener('click', function() {
                document.getElementById('confirmationModal').classList.remove('hidden');
            });

            document.getElementById('cancelButton').addEventListener('click', function() {
                document.getElementById('confirmationModal').classList.add('hidden');
            });

            document.getElementById('confirmButton').addEventListener('click', function() {
                document.getElementById('unitForm').submit();
            });
        </script>
    @endpush
</x-app-layout>