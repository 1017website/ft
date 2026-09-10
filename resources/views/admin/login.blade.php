@extends('admin.layout')
@section('title', 'Masuk admin')
@section('content')
<div class="login-emblem">@include('admin.icon', ['icon' => 'user'])</div>
<p class="eyebrow">FT Logistik CMS</p>
<h1>Selamat datang kembali.</h1>
<p class="intro">Masuk untuk mengelola konten dan permintaan pelanggan Anda.</p>
<form method="post" action="{{ route('admin.login') }}" class="panel">
    @csrf
    <label for="email">Email admin</label>
    <input id="email" name="email" type="email" autocomplete="username" value="{{ old('email') }}" required autofocus>
    <label for="password">Kata sandi</label>
    <input id="password" name="password" type="password" autocomplete="current-password" required>
    <button class="primary">Masuk ke workspace @include('admin.icon', ['icon' => 'arrow'])</button>
</form>
@endsection
