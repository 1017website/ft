@extends('admin.layout')
@section('title', $user->exists ? 'Edit user' : 'Tambah user')
@section('content')
<h1>{{ $user->exists ? 'Edit user' : 'Tambah user' }}</h1>
<p class="intro">Admin dapat mengelola konten dan user. User biasa tidak memiliki akses CMS.</p>
<form method="post" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" class="panel narrow" data-action-form>
    @csrf @if($user->exists) @method('PUT') @endif
    <label for="name">Nama</label><input id="name" name="name" value="{{ old('name', $user->name) }}" maxlength="255" autocomplete="name" required>
    <label for="email">Email</label><input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" maxlength="255" autocomplete="email" required>
    <label for="role">Akses</label><select id="role" name="role" required>
        <option value="admin" @selected(old('role', $user->is_admin ? 'admin' : 'user') === 'admin')>Admin</option>
        <option value="user" @selected(old('role', $user->is_admin ? 'admin' : 'user') === 'user')>User</option>
    </select>
    <label for="password">{{ $user->exists ? 'Kata sandi baru (opsional)' : 'Kata sandi' }}</label>
    <input id="password" name="password" type="password" minlength="12" autocomplete="new-password" aria-describedby="password-hint" @required(!$user->exists)>
    <p id="password-hint" class="hint">Minimal 12 karakter. @if($user->exists)Kosongkan untuk mempertahankan kata sandi saat ini.@endif</p>
    <label for="password_confirmation">Ulangi kata sandi</label><input id="password_confirmation" name="password_confirmation" type="password" minlength="12" autocomplete="new-password" @required(!$user->exists)>
    <div class="user-actions"><button class="primary">{{ $user->exists ? 'Simpan perubahan' : 'Tambah user' }}</button><a class="secondary" href="{{ route('admin.users.index') }}">Batal</a></div>
</form>
@endsection
