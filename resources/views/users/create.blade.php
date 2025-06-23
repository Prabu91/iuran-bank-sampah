<x-app-layout>
    <x-slot name="header"><h2 class="text-xl">Tambah User</h2></x-slot>

    <form action="{{ route('users.store') }}" method="POST" class="p-4">
        @include('users.form')
        <button class="mt-4 bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</x-app-layout>
