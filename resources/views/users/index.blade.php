<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Manajemen User</h2>
    </x-slot>

    <div class="p-4">
        <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah User</a>
        <table class="w-full mt-4 table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Nama</th>
                    <th class="p-2">Username</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Role</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="border-t">
                    <td class="p-2">{{ $user->name }}</td>
                    <td class="p-2">{{ $user->username }}</td>
                    <td class="p-2">{{ $user->email }}</td>
                    <td class="p-2 capitalize">{{ $user->role }}</td>
                    <td class="p-2">
                        <a href="{{ route('users.edit', $user) }}" class="text-blue-500">Edit</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 ml-2">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
