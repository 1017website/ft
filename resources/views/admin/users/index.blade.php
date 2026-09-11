@extends('admin.layout')
@section('title', 'Manage Users')
@section('content')
<div class="page-heading">
    <div><h1>Manage Users</h1><p class="intro">Kelola akun dan akses ke CMS FT Logistik.</p></div>
    <a class="primary" href="{{ route('admin.users.create') }}">Tambah user</a>
</div>
<div class="panel">
    @if($users->isEmpty())
    <h2>Belum ada user</h2><p>Gunakan tombol Tambah user untuk membuat akun.</p>
    @else
    <div class="table-scroll user-table" tabindex="0" role="region" aria-label="Daftar user, geser untuk melihat semua kolom"><table>
        <caption class="sr-only">Daftar user dan akses CMS</caption>
        <thead><tr><th scope="col">Nama</th><th scope="col">Email</th><th scope="col">Akses</th><th scope="col">Tindakan</th></tr></thead>
        <tbody>@foreach($users as $user)
        <tr><td>{{ $user->name }} @if($user->is(auth()->user()))<small>(Anda)</small>@endif</td><td>{{ $user->email }}</td><td>{{ $user->is_admin ? 'Admin' : 'User' }}</td><td>
            <div class="user-actions"><a class="secondary" href="{{ route('admin.users.edit', $user) }}" aria-label="Edit {{ $user->name }}">Edit</a>
            @unless($user->is(auth()->user()))
            <form method="post" action="{{ route('admin.users.destroy', $user) }}" data-action-form data-confirm="Hapus user {{ $user->name }}? Akun ini tidak dapat dipulihkan.">
                @csrf @method('DELETE')<button class="danger" aria-label="Hapus {{ $user->name }}">Hapus</button>
            </form>
            @endunless</div>
        </td></tr>
        @endforeach</tbody>
    </table></div>
    @endif
</div>
<div class="pagination">@if($users->previousPageUrl())<a href="{{ $users->previousPageUrl() }}">Sebelumnya</a>@endif <span>Halaman {{ $users->currentPage() }} dari {{ $users->lastPage() }}</span> @if($users->nextPageUrl())<a href="{{ $users->nextPageUrl() }}">Berikutnya</a>@endif</div>
@endsection
