@extends('admin.layout')
@section('title', 'Akun admin')
@section('content')
<h1>Akun admin</h1>
<p class="intro">{{ auth()->user()->email }}</p>
<form method="post" action="{{ route('admin.password') }}" class="panel narrow">
    @csrf @method('PUT')
    <h2>Ganti kata sandi</h2>
    <label for="current">Kata sandi saat ini</label>
    <input id="current" type="password" name="current_password" autocomplete="current-password" required>
    <label for="new">Kata sandi baru (minimal 12 karakter)</label>
    <input id="new" type="password" name="password" autocomplete="new-password" minlength="12" required>
    <label for="confirmation">Ulangi kata sandi baru</label>
    <input id="confirmation" type="password" name="password_confirmation" autocomplete="new-password" minlength="12" required>
    <button class="primary">Simpan kata sandi</button>
</form>
@endsection
