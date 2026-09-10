@extends('admin.layout')
@section('title', 'Permintaan penawaran')
@section('content')
<h1>Permintaan penawaran</h1>
<p class="intro">Permintaan dari formulir website. Hubungi customer melalui email atau nomor yang mereka isi.</p>
@forelse($requests as $entry)
<article class="panel">
    <div class="item-toolbar"><h2>{{ $entry->company }}</h2><time>{{ $entry->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</time></div>
    <p><strong>{{ $entry->pickup }} → {{ $entry->destination }}</strong> · {{ $entry->fleet }}</p>
    <dl class="request-details">
        <dt>Kontak</dt><dd>{{ $entry->contact }}</dd>
        <dt>Email</dt><dd><a href="mailto:{{ $entry->email }}">{{ $entry->email }}</a></dd>
        <dt>Telepon</dt><dd>{{ $entry->phone }}</dd>
        <dt>Berat / volume</dt><dd>{{ $entry->weight ?: 'Tidak diisi' }}</dd>
        <dt>Detail</dt><dd class="multiline">{{ $entry->details ?: 'Tidak diisi' }}</dd>
    </dl>
    <form action="{{ route('admin.requests.update', $entry) }}" method="post" class="status-form">
        @csrf @method('PATCH')
        <label for="status-{{ $entry->id }}">Status</label>
        <select name="status" id="status-{{ $entry->id }}">@foreach(['baru' => 'Baru', 'diproses' => 'Diproses', 'selesai' => 'Selesai'] as $value => $label)<option value="{{ $value }}" @selected($entry->status === $value)>{{ $label }}</option>@endforeach</select>
        <button class="secondary">Simpan status</button>
    </form>
</article>
@empty
<div class="panel"><h2>Belum ada permintaan</h2><p>Permintaan akan muncul di sini setelah pengunjung mengirim formulir Request Quote di website.</p></div>
@endforelse
<div class="pagination">@if($requests->previousPageUrl())<a href="{{ $requests->previousPageUrl() }}">Sebelumnya</a>@endif <span>Halaman {{ $requests->currentPage() }} dari {{ $requests->lastPage() }}</span> @if($requests->nextPageUrl())<a href="{{ $requests->nextPageUrl() }}">Berikutnya</a>@endif</div>
@endsection
