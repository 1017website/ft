@php
    $seo = $content['settings']['fields'];
    $canonical = $seo['canonical'] ?: route('home');
    $ogTitle = $seo['og_title'] ?: $seo['title'];
    $ogDescription = $seo['og_description'] ?: $seo['description'];
    $organization = array_filter([
        '@context' => 'https://schema.org', '@type' => 'Organization',
        'name' => $seo['organization_name'], 'url' => $canonical,
        'logo' => asset($content['header']['fields']['field_1']),
        'description' => $seo['description'], 'telephone' => $seo['telephone'],
        'email' => $seo['email'], 'address' => $seo['address'],
        'sameAs' => array_values(array_filter(array_column($content['settings']['groups']['profiles'], 'url'))),
    ]);
@endphp
<title>{{ $seo['title'] }}</title>
<meta name="description" content="{{ $seo['description'] }}">
<meta name="robots" content="{{ !empty($cmsPreview) ? 'noindex,nofollow' : $seo['robots'] }}">
<link rel="canonical" href="{{ $canonical }}">
<link rel="icon" href="{{ asset($content['branding']['fields']['favicon']) }}">
<link rel="apple-touch-icon" href="{{ asset($content['branding']['fields']['favicon']) }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="id_ID">
<meta property="og:site_name" content="{{ $seo['site_name'] }}">
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDescription }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ asset($seo['og_image']) }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $ogTitle }}">
<meta name="twitter:description" content="{{ $ogDescription }}">
<meta name="twitter:image" content="{{ asset($seo['og_image']) }}">
@if($seo['google_verification'])<meta name="google-site-verification" content="{{ $seo['google_verification'] }}">@endif
@if($seo['bing_verification'])<meta name="msvalidate.01" content="{{ $seo['bing_verification'] }}">@endif
<script type="application/ld+json">{!! json_encode($organization, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
