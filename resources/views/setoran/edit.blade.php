<x-app-layout class="container mx-auto flex flex-col md:flex-row md:space-x-8 px-4">
    <div class="container mx-auto max-w-lg p-8 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl text-center font-bold text-primary">Edit Setoran</h1>

        <div class="relative w-full">
            <form id="setoranForm" action="{{ route('setoran.update', $setoran->id) }}" method="POST" class="p-4" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div>
                    <label class="mt-4 block text-md font-medium text-gray-700">Unit</label>
                    <select name="unit_id"
                        class="mt-1 block w-full px-3 py-2 border @error('unit_id') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600"
                        required>
                        <option value="">-- Pilih Unit --</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ (old('unit_id', $setoran->unit_id) == $unit->id) ? 'selected' : '' }}>
                                {{ $unit->unit_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('unit_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="mt-4 block text-md font-medium text-gray-700">Nama Penyetor</label>
                    <input type="text" name="nama_penyetor" value="{{ old('nama_penyetor', $setoran->nama_penyetor) }}"
                        class="mt-1 block w-full px-3 py-2 border @error('nama_penyetor') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600"
                        placeholder="Nama Penyetor" required>
                    @error('nama_penyetor')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="mt-4 block text-md font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($setoran->tanggal)->format('Y-m-d')) }}"
                        class="mt-1 block w-full px-3 py-2 border @error('tanggal') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600"
                        required>
                    @error('tanggal')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mt-4 block text-md font-medium text-gray-700">Sampah</label>
                    <textarea name="sampah"
                        class="mt-1 block w-full px-3 py-2 border @error('sampah') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 resize-none"
                        placeholder="Contoh: Plastik, Kertas, Botol Kaca" required>{{ old('sampah', $setoran->sampah) }}</textarea>
                    @error('sampah')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mt-4 block text-md font-medium text-gray-700">Jumlah (Kg)</label>
                    <input type="number" step="0.01" name="jumlah_kg" value="{{ old('jumlah_kg', $setoran->jumlah_kg) }}"
                        class="mt-1 block w-full px-3 py-2 border @error('jumlah_kg') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600"
                        placeholder="Jumlah dalam kilogram" required>
                    @error('jumlah_kg')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mt-4 block text-md font-medium text-gray-700">Total Nominal (Rp)</label>
                    <input type="number" name="nominal" value="{{ old('nominal', $setoran->nominal) }}"
                        class="mt-1 block w-full px-3 py-2 border @error('nominal') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600"
                        placeholder="Total Nominal" required>
                    @error('nominal')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mt-4 block text-md font-medium text-gray-700">Keterangan</label>
                    <input type="text" name="keterangan" value="{{ old('keterangan', $setoran->keterangan) }}"
                        class="mt-1 block w-full px-3 py-2 border @error('keterangan') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600"
                        placeholder="Contoh: Setoran Bulan Juni" required>
                    @error('keterangan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="mt-4 block text-md font-medium text-gray-700">Bukti Setor</label>
                    <input type="file" name="bukti_setor" id="buktiSetor" accept="image/*" 
                        class="mt-1 block w-full px-3 py-2 border @error('bukti_setor') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600">
                    @error('bukti_setor')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    {{-- Kontainer pratinjau gambar --}}
                    <div id="image-preview-container" class="mt-4 @if(!$setoran->bukti_setor_path) hidden @endif">
                        <p class="text-sm font-medium text-gray-600 mb-2">Pratinjau Gambar:</p>
                        <img id="image-preview" src="{{ $setoran->bukti_setor_path ? Storage::url($setoran->bukti_setor_path) : '' }}" alt="Image Preview" class="max-w-xs h-auto rounded-md shadow-md">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">
                    <a href="{{ route('setoran.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-200 text-gray-700 font-semibold rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Kembali
                    </a>

                    <button type="button" id="openModalButton"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        Update Data
                    </button>
                </div>
            </form>

            <div id="confirmationModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
                    <h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
                    <p>Apakah Anda yakin ingin memperbarui data setoran ini?</p>
                    <div class="flex justify-end mt-4 gap-2">
                        <button id="cancelButton"
                            class="px-4 py-2 bg-gray-300 text-gray-700 hover:bg-gray-200 rounded-md">
                            Batal
                        </button>
                        <button id="confirmButton"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-md">
                            Ya, Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Script untuk modal konfirmasi
            document.getElementById('openModalButton').addEventListener('click', function() {
                document.getElementById('confirmationModal').classList.remove('hidden');
            });

            document.getElementById('cancelButton').addEventListener('click', function() {
                document.getElementById('confirmationModal').classList.add('hidden');
            });

            document.getElementById('confirmButton').addEventListener('click', function() {
                document.getElementById('setoranForm').submit();
            });

            // Script untuk pratinjau gambar
            const imageInput = document.getElementById('buktiSetor');
            const previewContainer = document.getElementById('image-preview-container');
            const previewImage = document.getElementById('image-preview');

            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Jika file dihapus, kembalikan ke gambar lama jika ada
                    const existingImagePath = "{{ $setoran->bukti_setor_path ? Storage::url($setoran->bukti_setor_path) : '' }}";
                    if (existingImagePath) {
                        previewImage.src = existingImagePath;
                    } else {
                        previewImage.src = '';
                        previewContainer.classList.add('hidden');
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>