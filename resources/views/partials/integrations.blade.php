@php
    $integrations = $content['integrations']['fields'];
    $hasTags = collect(['ga4','gtm','meta_pixel','google_ads','clarity','adsense'])->contains(fn ($key) => !empty($integrations[$key]));
@endphp
@if($hasTags)
<div id="marketingSettings" data-settings="{{ json_encode($integrations) }}" data-lead="{{ session()->pull('quotation_conversion', '') }}" hidden></div>
<div id="trackingConsent" class="tracking-consent" role="region" aria-label="Preferensi pengukuran" hidden><div><strong>Preferensi pengukuran website</strong><p>Izinkan layanan analitik dan iklan yang dipasang website ini untuk mengukur kunjungan Anda?</p></div><div><button id="consentReject" type="button">Tolak</button><button id="consentAccept" type="button">Izinkan</button></div></div>
<button id="trackingPreferences" class="tracking-preferences" type="button" hidden>Preferensi privasi</button>
<script src="{{ asset('assets/ft/js/integrations.js') }}" defer></script>
@endif
