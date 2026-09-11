<?php

$sections['settings']['title'] = 'SEO & mesin pencari';
$seoFields = [
    'canonical' => ['label' => 'URL utama / canonical', 'type' => 'url', 'hint' => 'Kosongkan untuk memakai URL website. Isi domain publik setelah website online.'],
    'robots' => ['label' => 'Izin mesin pencari', 'type' => 'select', 'options' => ['index,follow' => 'Izinkan muncul di mesin pencari', 'noindex,nofollow' => 'Jangan indeks website']],
    'og_title' => ['label' => 'Judul saat dibagikan', 'type' => 'text', 'hint' => 'Kosongkan untuk mengikuti judul SEO.'],
    'og_description' => ['label' => 'Deskripsi saat dibagikan', 'type' => 'textarea'],
    'og_image' => ['label' => 'Gambar share WhatsApp / Facebook / X', 'type' => 'image', 'hint' => 'Disarankan 1200 × 630 piksel.'],
    'site_name' => ['label' => 'Nama website / perusahaan', 'type' => 'text'],
    'google_verification' => ['label' => 'Token verifikasi Google Search Console', 'type' => 'text', 'hint' => 'Isi nilai content dari meta verifikasi, bukan seluruh kode HTML.'],
    'bing_verification' => ['label' => 'Token verifikasi Bing Webmaster', 'type' => 'text'],
    'organization_name' => ['label' => 'Nama legal perusahaan (structured data)', 'type' => 'text'],
    'telephone' => ['label' => 'Telepon perusahaan (structured data)', 'type' => 'text'],
    'email' => ['label' => 'Email perusahaan (structured data)', 'type' => 'email'],
    'address' => ['label' => 'Alamat perusahaan (structured data)', 'type' => 'textarea'],
];
$sections['settings']['fields'] = array_merge($sections['settings']['fields'], $seoFields);
$sections['settings']['defaults']['fields'] = array_merge($sections['settings']['defaults']['fields'], [
    'canonical' => '', 'robots' => 'index,follow', 'og_title' => '', 'og_description' => '',
    'og_image' => 'assets/ft/images/image-02.jpg', 'site_name' => 'FT Logistik',
    'google_verification' => '', 'bing_verification' => '', 'organization_name' => 'PT Firman Tangguh Logistik',
    'telephone' => '', 'email' => '', 'address' => '',
]);
$sections['settings']['groups']['profiles'] = ['label' => 'Profil sosial perusahaan', 'fields' => ['url' => ['label' => 'URL profil resmi', 'type' => 'url']]];
$sections['settings']['defaults']['groups']['profiles'] = [];
$sections['branding'] = [
    'title' => 'Logo, favicon & ukuran',
    'fields' => [
        'cms_logo' => ['label' => 'Logo CMS', 'type' => 'image'],
        'favicon' => ['label' => 'Favicon website & CMS', 'type' => 'image', 'hint' => 'Gunakan PNG persegi, disarankan 512 × 512 piksel.'],
        'front_width' => ['label' => 'Lebar logo frontend desktop (px)', 'type' => 'number', 'min' => 80, 'max' => 360],
        'mobile_width' => ['label' => 'Lebar logo frontend HP (px)', 'type' => 'number', 'min' => 60, 'max' => 200],
        'footer_width' => ['label' => 'Lebar logo footer (px)', 'type' => 'number', 'min' => 80, 'max' => 360],
        'cms_width' => ['label' => 'Lebar logo CMS (px)', 'type' => 'number', 'min' => 60, 'max' => 180],
    ],
    'groups' => [],
    'defaults' => ['fields' => ['cms_logo' => 'assets/ft/images/image-01.png', 'favicon' => 'assets/ft/images/image-01.png', 'front_width' => '245', 'mobile_width' => '190', 'footer_width' => '235', 'cms_width' => '150'], 'groups' => []],
];
$sections['integrations'] = [
    'title' => 'Analytics & iklan',
    'fields' => [
        'ga4' => ['label' => 'Google Analytics 4 Measurement ID', 'type' => 'text', 'pattern' => '^G-[A-Z0-9]+$', 'hint' => 'Contoh format: G-XXXXXXXXXX. Kosong berarti tidak aktif.'],
        'gtm' => ['label' => 'Google Tag Manager Container ID', 'type' => 'text', 'pattern' => '^GTM-[A-Z0-9]+$', 'hint' => 'Untuk TikTok Pixel, LinkedIn Insight, atau tag lain. Jangan memasang tag yang sama di sini dan melalui GTM.'],
        'meta_pixel' => ['label' => 'Meta / Facebook Pixel ID', 'type' => 'text', 'pattern' => '^[0-9]{5,30}$'],
        'google_ads' => ['label' => 'Google Ads Conversion ID', 'type' => 'text', 'pattern' => '^AW-[0-9]+$', 'hint' => 'Format AW-123456789.'],
        'ads_label' => ['label' => 'Google Ads Conversion Label', 'type' => 'text', 'pattern' => '^[A-Za-z0-9_-]+$', 'hint' => 'Konversi dikirim setelah formulir penawaran berhasil diterima.'],
        'clarity' => ['label' => 'Microsoft Clarity Project ID', 'type' => 'text', 'pattern' => '^[a-zA-Z0-9]+$'],
        'adsense' => ['label' => 'Google AdSense Publisher ID', 'type' => 'text', 'pattern' => '^ca-pub-[0-9]{16}$', 'hint' => 'Untuk menampilkan iklan di website, berbeda dari Google Ads untuk mengukur kampanye.'],
        'ad_slot' => ['label' => 'AdSense Ad Slot ID', 'type' => 'text', 'pattern' => '^[0-9]+$'],
        'ad_position' => ['label' => 'Posisi iklan AdSense', 'type' => 'select', 'options' => ['off' => 'Tidak ditampilkan', 'after_hero' => 'Setelah banner utama', 'before_footer' => 'Sebelum footer']],
        'consent' => ['label' => 'Aktivasi tag pengunjung', 'type' => 'select', 'options' => ['ask' => 'Setelah pengunjung menyetujui', 'immediate' => 'Langsung saat halaman dibuka']],
    ],
    'groups' => [],
    'defaults' => ['fields' => ['ga4' => '', 'gtm' => '', 'meta_pixel' => '', 'google_ads' => '', 'ads_label' => '', 'clarity' => '', 'adsense' => '', 'ad_slot' => '', 'ad_position' => 'off', 'consent' => 'ask'], 'groups' => []],
];
foreach (['hero','stats','about','services','fleet','network','process','gallery','cta'] as $name) {
    $sections[$name]['fields']['visible'] = ['label' => 'Tampilkan bagian ini', 'type' => 'select', 'options' => ['1' => 'Tampilkan', '0' => 'Sembunyikan']];
    $sections[$name]['defaults']['fields']['visible'] = '1';
}
foreach (['photo', 'video'] as $type) {
    $sections['gallery']['fields'][$type.'_limit'] = ['label' => 'Jumlah '.$type.' yang ditampilkan', 'type' => 'number', 'min' => 0, 'max' => 100, 'hint' => '0 = tampilkan semua. Item lain tetap tersimpan di CMS.'];
    $sections['gallery']['defaults']['fields'][$type.'_limit'] = '0';
    $sections['gallery']['fields'][$type.'_columns'] = ['label' => 'Kolom '.$type.' di desktop', 'type' => 'select', 'options' => ['2' => '2 kolom', '3' => '3 kolom', '4' => '4 kolom']];
    $sections['gallery']['defaults']['fields'][$type.'_columns'] = '3';
}
return $sections;
