<x-app-layout class="container mx-auto flex flex-col md:flex-row md:space-x-8 px-4">
    <div class="container mx-auto max-w-lg p-8 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl text-center font-bold text-primary">Tambah User</h1>

        <div class="relative w-full">
            <form id="userForm" action="{{ route('users.store') }}" method="POST" class="p-4">
                @csrf
                <div>
                    <label class="mt-4 block text-md font-medium text-primary">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" placeholder="Nama User" required>
                </div>
                <div>
                    <label class="mt-4 block text-md font-medium text-primary">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username ?? '') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" placeholder="Username" required>
                </div>
                <div>
                    <label class="mt-4 block text-md font-medium text-primary">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" placeholder="Email" required>
                </div>
                <div>
                    <label class="mt-4 block text-md font-medium text-primary">Role</label>
                    <select name="role" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary text-primary" >
                        @foreach (['petugas', 'viewer'] as $role)
                            <option value="{{ $role }}" @if((old('role', $user->role ?? '') == $role)) selected @endif>{{ ucfirst($role) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mt-4 block text-md font-medium text-primary">Password {{ isset($user) ? '(opsional)' : '' }}</label>
                    <input type="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" placeholder="Password" {{ isset($user) ? '' : 'required' }}>
                </div>


                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">
                    <a href="{{ url()->previous() }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-200 text-gray-700 font-semibold rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Kembali
                    </a>

                    <button 
                        type="button" 
                        id="openModalButton" 
                        class="inline-flex items-center px-4 py-2 bg-primary text-white font-semibold rounded-md shadow-sm hover:bg-hoverPrimary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        Simpan Data
                    </button>
                </div>
            </form>

            <div id="confirmationModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
                    <h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
                    <p>Apakah Anda Yakin Ingin Menyimpan Data user?</p>
                    <div class="flex justify-end mt-4 gap-2">
                        <button 
                            id="cancelButton" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 hover:bg-gray-200 rounded-md">
                            Batal
                        </button>
                        <button 
                            id="confirmButton" 
                            class="px-4 py-2 bg-primary hover:bg-hoverPrimary text-white rounded-md">
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
                document.getElementById('userForm').submit(); 
            });
        </script>
    @endpush
</x-app-layout>
