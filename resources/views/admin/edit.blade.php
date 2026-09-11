@extends('admin.layout')
@section('title', $definition['title'])
@section('content')
<a class="back-link" href="{{ route('admin.index') }}">@include('admin.icon', ['icon' => 'back']) Semua bagian</a>
<div class="page-heading"><div><h1>{{ $definition['title'] }}</h1><p class="intro">{{ config('admin.sections.'.$section.'.description') }}</p></div><a class="secondary preview-link" href="{{ route('home') }}{{ in_array($section, ['about','services','fleet','network','process','gallery']) ? '#'.$section : '' }}" target="_blank" rel="noopener">Lihat di website @include('admin.icon', ['icon' => 'external'])</a></div>
<div class="editor-note">@include('admin.icon', ['icon' => 'image']) <span>Desain website sudah siap. Anda cukup mengisi teks dan memilih gambar.</span></div>
@if($section === 'branding')<div class="editor-note"><span>Ganti logo frontend di <a href="{{ route('admin.edit','header') }}">Logo & menu</a>, dan logo footer di <a href="{{ route('admin.edit','footer') }}">Footer & kontak</a>. Ukurannya diatur di sini.</span></div>@endif
@if($section === 'integrations')<div class="editor-note"><span>Kosongkan ID untuk menonaktifkan layanan. Script iklan tidak dijalankan dalam preview. Pengaturan ini memasang tag; anggaran dan materi kampanye tetap dikelola di akun Google/Meta.</span></div>@endif
<div class="editor-workspace">
<form method="post" action="{{ route('admin.update', $section) }}" enctype="multipart/form-data" data-editor data-preview-url="{{ route('admin.preview',$section) }}" data-dirty="{{ session()->hasOldInput() ? 'true' : 'false' }}">
    @csrf @method('PUT')
    <input type="hidden" name="version" value="{{ $version }}">
    @if(count($definition['fields']))
    <section class="panel">
        <div class="panel-heading"><span class="section-icon">@include('admin.icon', ['icon' => config('admin.sections.'.$section.'.icon')])</span><div><h2>{{ $section === 'fleet' ? 'Judul bagian & armada utama' : 'Isi bagian' }}</h2><p>Informasi yang ditampilkan kepada pengunjung.</p></div></div>
        <div class="field-grid">
        @foreach($definition['fields'] as $key => $field)
            @include('admin.field', ['name' => "fields[$key]", 'value' => $data['fields'][$key] ?? ''])
        @endforeach
        </div>
    </section>
    @endif
    @foreach($definition['groups'] as $groupKey => $group)
    <section class="panel" data-repeater="{{ $groupKey }}">
        <div class="panel-heading"><span class="section-icon">@include('admin.icon', ['icon' => 'steps'])</span><div><h2>{{ $group['label'] }} <span class="item-count" data-item-count>{{ count($data['groups'][$groupKey]) }}</span></h2><p>Atur urutan sesuai tampilan website. Maksimal 100 item.</p></div></div>
        @if($groupKey === 'cities')<p class="hint">Isi koordinat desimal dari Google Maps, misalnya latitude -6.2088 dan longitude 106.8456.</p>@endif
        <div data-items>
        @foreach(old('groups.'.$groupKey, session()->hasOldInput() ? [] : $data['groups'][$groupKey]) as $index => $item)
            @include('admin.item')
        @endforeach
        </div>
        <p data-empty>Belum ada item. Klik tombol di bawah untuk menambahkan.</p>
        <button type="button" class="add-button" data-add>@include('admin.icon', ['icon' => 'plus']) Tambah {{ strtolower($group['label']) }}</button>
        <template>@include('admin.item', ['index' => '__INDEX__', 'item' => []])</template>
    </section>
    @endforeach
    <div class="savebar"><div class="save-status">@include('admin.icon', ['icon' => 'check'])<span data-save-status role="status">Semua perubahan tersimpan.</span></div><button class="primary" type="submit">@include('admin.icon', ['icon' => 'check']) Simpan perubahan</button></div>
</form>
<aside class="live-preview" aria-label="Preview frontend">
    <div class="preview-toolbar"><strong>Preview frontend</strong><div><button type="button" class="quiet active" data-preview-width="1280" aria-pressed="true">Desktop</button><button type="button" class="quiet" data-preview-width="390" aria-pressed="false">HP</button></div></div>
    @if($section === 'settings')<div class="search-preview"><small>Simulasi hasil pencarian</small><span data-seo-url>{{ $data['fields']['canonical'] ?: route('home') }}</span><strong data-seo-title>{{ $data['fields']['title'] }}</strong><p data-seo-description>{{ $data['fields']['description'] }}</p></div>@endif
    <div class="preview-caption-note">Bagian yang Anda edit ditandai garis emas. Preview belum mengubah website publik.</div>
    <div class="preview-screen"><iframe title="Preview {{ $definition['title'] }}" sandbox="allow-scripts" data-preview-frame></iframe></div>
    <div class="preview-bottom"><span data-preview-status role="status">Memuat preview…</span><button type="button" class="quiet" data-preview-refresh>Perbarui</button></div>
</aside>
</div>
@endsection
