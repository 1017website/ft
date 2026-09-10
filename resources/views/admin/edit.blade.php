@extends('admin.layout')
@section('title', $definition['title'])
@section('content')
<a class="back-link" href="{{ route('admin.index') }}">@include('admin.icon', ['icon' => 'back']) Semua bagian</a>
<div class="page-heading"><div><h1>{{ $definition['title'] }}</h1><p class="intro">{{ config('admin.sections.'.$section.'.description') }}</p></div><a class="secondary preview-link" href="{{ route('home') }}{{ in_array($section, ['about','services','fleet','network','process','gallery']) ? '#'.$section : '' }}" target="_blank" rel="noopener">Lihat di website @include('admin.icon', ['icon' => 'external'])</a></div>
<div class="editor-note">@include('admin.icon', ['icon' => 'image']) <span>Desain website sudah siap. Anda cukup mengisi teks dan memilih gambar.</span></div>
<form method="post" action="{{ route('admin.update', $section) }}" enctype="multipart/form-data" data-editor data-dirty="{{ session()->hasOldInput() ? 'true' : 'false' }}">
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
        <div class="panel-heading"><span class="section-icon">@include('admin.icon', ['icon' => 'steps'])</span><div><h2>{{ $group['label'] }} <span class="item-count" data-item-count>{{ count($data['groups'][$groupKey]) }}</span></h2><p>Atur urutan sesuai tampilan website. Maksimal 40 item.</p></div></div>
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
@endsection
