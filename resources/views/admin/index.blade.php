@extends('admin.layout')
@section('content')
<div class="page-heading"><div><p class="eyebrow">Website perusahaan</p><h1>Konten rapi. Bisnis siap jalan.</h1><p class="intro">Selamat datang, {{ auth()->user()->name }}. Apa yang ingin Anda perbarui hari ini?</p></div><span class="workspace-tag">FT Logistik</span></div>
<div class="overview-grid">
    <section class="feature-preview">
        <div class="preview-image"><img src="{{ asset($websiteContent['hero']['fields']['field_1']) }}" alt="Banner utama website saat ini"><span>Halaman utama</span></div>
        <div class="preview-caption"><div><h2>Kesan pertama dimulai di sini.</h2><p>Perbarui banner dan pesan utama website Anda.</p></div><a class="primary" href="{{ route('admin.edit', 'hero') }}">Edit banner @include('admin.icon', ['icon' => 'arrow'])</a></div>
    </section>
    <div class="overview-side">
        <a class="inbox-card" href="{{ route('admin.requests') }}"><span class="card-heading">@include('admin.icon', ['icon' => 'inbox']) Permintaan penawaran</span><strong>{{ $newRequests }}</strong><p>{{ $newRequests ? 'Permintaan baru menunggu tindak lanjut.' : 'Belum ada permintaan baru. Pesan pelanggan akan muncul di sini.' }}</p><span class="text-action">Buka kotak masuk @include('admin.icon', ['icon' => 'arrow'])</span></a>
        <div class="help-card"><span class="help-number">01 / 02 / 03</span><h3>Edit. Simpan. Tampil.</h3><p>Pilih bagian di bawah, ubah isinya, lalu simpan. Perubahan langsung terlihat di website.</p></div>
    </div>
</div>
<section class="content-library">
    <div class="library-heading"><div><h2>Bagian website</h2><p>Semua konten, dalam satu tempat.</p></div><div class="section-search">@include('admin.icon', ['icon' => 'search'])<input type="search" aria-label="Cari bagian website" placeholder="Cari bagian…" data-section-search></div></div>
    <div class="section-grid">
    @foreach(config('cms') as $key => $definition)
        <a class="section-card" href="{{ route('admin.edit', $key) }}" data-section-card="{{ strtolower($definition['title']) }}">
            <span class="section-icon">@include('admin.icon', ['icon' => config('admin.sections.'.$key.'.icon')])</span>
            <div><h3>{{ $definition['title'] }}</h3><p>{{ config('admin.sections.'.$key.'.description') }}</p><small>{{ $updates->get($key) ? 'Diperbarui '.$updates[$key]->updated_at->timezone('Asia/Jakarta')->format('d M Y') : 'Konten awal template' }}</small></div>
            <span class="card-arrow">@include('admin.icon', ['icon' => 'arrow'])</span>
        </a>
    @endforeach
    </div>
    <p class="empty-search" data-search-empty hidden>Tidak ada bagian yang cocok. Coba kata seperti “galeri” atau “armada”.</p>
    <span class="sr-only" data-search-status role="status"></span>
</section>
@endsection
