@extends('admin.layout')
@section('title', 'Developer')
@section('content')
<h1>Developer</h1>
<p class="intro">Jalankan perintah pemeliharaan pada server aplikasi ini.</p>
@if($result = session('command_result'))
<section class="panel" role="status">
    <h2>{{ $result['successful'] ? 'Perintah selesai' : 'Perintah gagal' }}: {{ $result['command'] }}</h2>
    <pre class="command-output">{{ $result['output'] ?: 'Perintah selesai tanpa output.' }}</pre>
</section>
@endif
<div class="panel">
    @foreach($commands as $command => $description)
    <form method="post" action="{{ route('admin.developer.run') }}" class="command-row" data-action-form data-confirm="Jalankan php artisan {{ $command }} pada server ini? {{ $description }}">
        @csrf<input type="hidden" name="command" value="{{ $command }}">
        <div><h2><code>php artisan {{ $command }}</code></h2><p>{{ $description }}</p></div>
        <button class="secondary" aria-label="Jalankan php artisan {{ $command }}">Jalankan</button>
    </form>
    @endforeach
</div>
@endsection
