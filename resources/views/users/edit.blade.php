<x-app-layout>
    <x-slot name="header"><h2 class="text-xl">Edit User</h2></x-slot>

    <form action="{{ route('users.update', $user) }}" method="POST" class="p-4">
        @method('PUT')
        @include('users.form', ['user' => $user])
        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</x-app-layout>
