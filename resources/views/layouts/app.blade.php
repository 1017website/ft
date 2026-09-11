<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
@include('partials.seo')
@stack('vendor-styles')
<link rel="stylesheet" href="{{ asset('assets/ft/css/site.css') }}">
@stack('styles')
<style>
.logo{width:{{ (int)$content['branding']['fields']['front_width'] }}px}
.footer-logo{width:{{ (int)$content['branding']['fields']['footer_width'] }}px;max-width:100%}
.photo-grid{grid-template-columns:repeat({{ (int)$content['gallery']['fields']['photo_columns'] }},minmax(0,1fr));grid-template-rows:none;grid-auto-rows:280px}
.video-grid{grid-template-columns:repeat({{ (int)$content['gallery']['fields']['video_columns'] }},minmax(0,1fr))}
@media(max-width:1050px){.photo-grid,.video-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.photo-item:first-child{grid-column:1/3;grid-row:auto}}
@media(max-width:700px){.logo{width:min({{ (int)$content['branding']['fields']['mobile_width'] }}px,48vw)}.nav{gap:12px}.photo-grid,.video-grid{grid-template-columns:1fr}.photo-item:first-child{grid-column:auto;grid-row:auto}.photo-grid{grid-auto-rows:260px}}
</style>
</head>
<body>
@include('partials.header')

@yield('content')

@if($content['integrations']['fields']['ad_position'] === 'before_footer')@include('partials.advertisement')@endif
@include('partials.footer')

@stack('modals')
@stack('scripts')
@if(!empty($cmsPreview))
    @include('partials.cms-preview')
@else
    @include('partials.integrations')
@endif
</body>
</html>
