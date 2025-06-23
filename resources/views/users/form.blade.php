@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label>Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="w-full border p-2" required>
    </div>
    <div>
        <label>Username</label>
        <input type="text" name="username" value="{{ old('username', $user->username ?? '') }}" class="w-full border p-2" required>
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full border p-2" required>
    </div>
    <div>
        <label>Role</label>
        <select name="role" class="w-full border p-2">
            @foreach (['admin', 'petugas', 'viewer'] as $role)
                <option value="{{ $role }}" @if((old('role', $user->role ?? '') == $role)) selected @endif>{{ ucfirst($role) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Password {{ isset($user) ? '(opsional)' : '' }}</label>
        <input type="password" name="password" class="w-full border p-2" {{ isset($user) ? '' : 'required' }}>
    </div>
</div>
