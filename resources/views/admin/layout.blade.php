<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#202722">
    <meta name="robots" content="noindex,nofollow">
    <link rel="icon" href="{{ asset($cmsBranding['favicon']) }}">
    <title>@yield('title', 'Ringkasan') | FT Logistik CMS</title>
    <link rel="preload" href="{{ asset('assets/admin/fonts/jakarta-400.ttf') }}" as="font" type="font/ttf" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}?v={{ filemtime(public_path('assets/admin/admin.css')) }}">
    <script src="{{ asset('assets/admin/admin.js') }}?v={{ filemtime(public_path('assets/admin/admin.js')) }}" defer></script>
</head>
<body @class(['guest-page' => auth()->guest()])>
<a class="skip" href="#content">Langsung ke isi</a>
@auth
<button class="sidebar-overlay" data-menu-close aria-label="Tutup menu" tabindex="-1" hidden></button>
<aside class="sidebar" id="sidebar" aria-label="Navigasi CMS">
    <div class="sidebar-brand"><a href="{{ route('admin.index') }}"><img class="cms-logo" src="{{ asset($cmsBranding['cms_logo']) }}" alt="Logo CMS" style="width:{{ (int)$cmsBranding['cms_width'] }}px"></a><button class="mobile-close icon-button" data-menu-close aria-label="Tutup menu">@include('admin.icon', ['icon' => 'close'])</button></div>
    <div class="workspace-label"><span class="site-dot"></span>Website perusahaan</div>
    <nav aria-label="Menu pengelolaan">
        <p class="nav-label">Workspace</p>
        <a href="{{ route('admin.statistics') }}" @class(['nav-link', 'active' => request()->routeIs('admin.statistics')])>@include('admin.icon', ['icon' => 'chart'])<span>Statistik pengunjung</span></a>
        <a href="{{ route('admin.index') }}" @class(['nav-link', 'active' => request()->routeIs('admin.index')]) @if(request()->routeIs('admin.index')) aria-current="page" @endif>@include('admin.icon', ['icon' => 'grid'])<span>Ringkasan</span></a>
        <a href="{{ route('admin.requests') }}" @class(['nav-link', 'active' => request()->routeIs('admin.requests*')])>@include('admin.icon', ['icon' => 'inbox'])<span>Permintaan penawaran</span></a>
        <p class="nav-label">Konten website</p>
        @foreach(config('cms') as $key => $definition)
        <a href="{{ route('admin.edit', $key) }}" @class(['nav-link', 'active' => request()->route('section') === $key]) @if(request()->route('section') === $key) aria-current="page" @endif>@include('admin.icon', ['icon' => config('admin.sections.'.$key.'.icon')])<span>{{ $definition['title'] }}</span></a>
        @endforeach
        <p class="nav-label">Administrasi</p>
        <a href="{{ route('admin.users.index') }}" @class(['nav-link', 'active' => request()->routeIs('admin.users.*')]) @if(request()->routeIs('admin.users.*')) aria-current="page" @endif>@include('admin.icon', ['icon' => 'user'])<span>Manage Users</span></a>
        @if(auth()->user()->is_developer)
        <a href="{{ route('admin.developer.index') }}" @class(['nav-link', 'active' => request()->routeIs('admin.developer.*')]) @if(request()->routeIs('admin.developer.*')) aria-current="page" @endif>@include('admin.icon', ['icon' => 'settings'])<span>Developer</span></a>
        @endif
    </nav>
    <div class="sidebar-bottom"><span class="avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</span><a href="{{ route('admin.account') }}">{{ auth()->user()->name }}<small>Pengaturan akun</small></a><form method="post" action="{{ route('admin.logout') }}">@csrf<button class="icon-button" aria-label="Keluar" title="Keluar">@include('admin.icon', ['icon' => 'logout'])</button></form></div>
</aside>
@endauth
<div class="workspace">
    <header class="topbar">
        @auth
        <button class="menu-toggle icon-button" aria-label="Buka menu" aria-controls="sidebar" aria-expanded="false" data-menu-toggle>@include('admin.icon', ['icon' => 'menu'])</button>
        <div class="breadcrumb"><span>Workspace</span><span>/</span><strong>@yield('title', 'Ringkasan')</strong></div>
        <a class="website-link" href="{{ route('home') }}" target="_blank" rel="noopener">Lihat website @include('admin.icon', ['icon' => 'external'])</a>
        @else
        <a class="guest-brand" href="{{ route('home') }}"><img class="cms-logo" src="{{ asset($cmsBranding['cms_logo']) }}" alt="Logo CMS" style="width:{{ (int)$cmsBranding['cms_width'] }}px"></a>
        <a class="website-link" href="{{ route('home') }}">Kembali ke website @include('admin.icon', ['icon' => 'external'])</a>
        @endauth
    </header>
    <main id="content" tabindex="-1">
        @if(session('success'))<div class="notice" role="status">@include('admin.icon', ['icon' => 'check'])<span>{{ session('success') }}</span></div>@endif
        @if($errors->any())
        <div class="error-summary" role="alert" tabindex="-1">
            <strong>{{ request()->routeIs('login') ? 'Login belum berhasil.' : 'Perubahan belum tersimpan.' }}</strong>
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            @unless(request()->routeIs('login'))<p>Periksa kolom yang ditandai. Pilih ulang gambar baru jika diperlukan.</p>@endunless
        </div>
        @endif
        @yield('content')
        <footer class="workspace-footer"><span>FT Logistik · Content management</span><a href="{{ route('home') }}" target="_blank" rel="noopener">Buka website</a></footer>
    </main>
</div>
<dialog class="action-dialog" data-action-dialog aria-labelledby="action-title" aria-describedby="action-message">
    <h2 id="action-title">Konfirmasi tindakan</h2>
    <p id="action-message" data-action-message></p>
    <form method="dialog" class="user-actions">
        <button class="secondary" value="cancel" autofocus>Batal</button>
        <button class="primary" value="confirm">Lanjutkan</button>
    </form>
</dialog>
</body>
</html>
