@extends('layouts.app')

@push('vendor-styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
@endpush

@section('content')
@include('pages.home.sections.hero')
@include('pages.home.sections.stats')
@include('pages.home.sections.about')
@include('pages.home.sections.services')
@include('pages.home.sections.fleet')
@include('pages.home.sections.network')
@include('pages.home.sections.process')
@include('pages.home.sections.gallery')
@include('pages.home.sections.cta')
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
