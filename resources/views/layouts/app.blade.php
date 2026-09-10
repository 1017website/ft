<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>{{ $content['settings']['fields']['title'] }}</title>
<meta name="description" content="{{ $content['settings']['fields']['description'] }}">
@stack('vendor-styles')
<link rel="stylesheet" href="{{ asset('assets/ft/css/site.css') }}">
@stack('styles')
</head>
<body>
@include('partials.header')

@yield('content')

@include('partials.footer')

@stack('modals')
@stack('scripts')
</body>
</html>
