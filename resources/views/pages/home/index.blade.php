@extends('layouts.app')

@push('vendor-styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
@endpush

@section('content')
@foreach(['hero','stats','about','services','fleet','network','process','gallery','cta'] as $homeSection)
    @if(($content[$homeSection]['fields']['visible'] ?? '1') === '1' || (!empty($cmsPreview) && $previewSection === $homeSection))
        @include('pages.home.sections.'.$homeSection)
    @endif
    @if($homeSection === 'hero' && $content['integrations']['fields']['ad_position'] === 'after_hero')@include('partials.advertisement')@endif
@endforeach
@endsection

@push('modals')
@include('partials.modals.lightbox')
@include('partials.modals.video')
@include('partials.modals.quote')
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="{{ asset('assets/ft/js/home.js') }}"></script>
@endpush
