<?php

return [
    'header' => [
        'title' => 'Logo & menu',
        'fields' => [
            'field_1' => [
                'label' => 'Gambar',
                'type' => 'image',
            ],
            'field_2' => [
                'label' => 'Keterangan gambar',
                'type' => 'text',
            ],
            'field_3' => [
                'label' => 'Teks tombol / menu — Company',
                'type' => 'text',
            ],
            'field_4' => [
                'label' => 'Teks tombol / menu — Services',
                'type' => 'text',
            ],
            'field_5' => [
                'label' => 'Teks tombol / menu — Fleet',
                'type' => 'text',
            ],
            'field_6' => [
                'label' => 'Teks tombol / menu — Network',
                'type' => 'text',
            ],
            'field_7' => [
                'label' => 'Teks tombol / menu — Gallery',
                'type' => 'text',
            ],
            'field_8' => [
                'label' => 'Teks tombol / menu — Request Quote',
                'type' => 'text',
            ],
        ],
        'groups' => [
        ],
        'defaults' => [
            'fields' => [
                'field_1' => 'assets/ft/images/image-01.png',
                'field_2' => 'Firman Tangguh',
                'field_3' => 'Company',
                'field_4' => 'Services',
                'field_5' => 'Fleet',
                'field_6' => 'Network',
                'field_7' => 'Gallery',
                'field_8' => 'Request Quote',
            ],
            'groups' => [
            ],
        ],
    ],
    'hero' => [
        'title' => 'Banner utama',
        'fields' => [
            'field_1' => [
                'label' => 'Gambar',
                'type' => 'image',
            ],
            'field_2' => [
                'label' => 'Keterangan gambar',
                'type' => 'text',
            ],
            'field_3' => [
                'label' => 'Label keunggulan — Nationwide Coverage',
                'type' => 'text',
            ],
            'field_4' => [
                'label' => 'Label keunggulan — Container 20’ / 40’',
                'type' => 'text',
            ],
            'field_5' => [
                'label' => 'Label bagian — PT Firman Tangguh Logistik',
                'type' => 'text',
            ],
            'field_6' => [
                'label' => 'Judul / nama — Moving business',
                'type' => 'text',
            ],
            'field_7' => [
                'label' => 'Teks — across Indonesia.',
                'type' => 'text',
            ],
            'field_8' => [
                'label' => 'Deskripsi — Reliable trucking, container hauling, and logis…',
                'type' => 'textarea',
            ],
            'field_9' => [
                'label' => 'Teks tombol / menu — Request a Quote',
                'type' => 'text',
            ],
            'field_10' => [
                'label' => 'Teks tombol / menu — Explore Fleet',
                'type' => 'text',
            ],
        ],
        'groups' => [
        ],
        'defaults' => [
            'fields' => [
                'field_1' => 'assets/ft/images/image-02.jpg',
                'field_2' => 'FT Logistik Truck',
                'field_3' => 'Nationwide Coverage',
                'field_4' => 'Container 20’ / 40’',
                'field_5' => 'PT Firman Tangguh Logistik',
                'field_6' => 'Moving business',
                'field_7' => 'across Indonesia.',
                'field_8' => 'Reliable trucking, container hauling, and logistics solutions designed for business distribution across Indonesia.',
                'field_9' => 'Request a Quote',
                'field_10' => 'Explore Fleet',
            ],
            'groups' => [
            ],
        ],
    ],
    'stats' => [
        'title' => 'Ringkasan perusahaan',
        'fields' => [
        ],
        'groups' => [
            'items' => [
                'label' => 'Ringkasan',
                'fields' => [
                    'field_1' => [
                        'label' => 'Judul / nama',
                        'type' => 'text',
                    ],
                    'field_2' => [
                        'label' => 'Teks',
                        'type' => 'text',
                    ],
                ],
            ],
        ],
        'defaults' => [
            'fields' => [
            ],
            'groups' => [
                'items' => [
                    0 => [
                        'field_1' => '10+',
                        'field_2' => 'Years Experience',
                    ],
                    1 => [
                        'field_1' => '20’ / 40’',
                        'field_2' => 'Container Capability',
                    ],
                    2 => [
                        'field_1' => 'Multi Fleet',
                        'field_2' => 'Vehicle Options',
                    ],
                    3 => [
                        'field_1' => 'Nationwide',
                        'field_2' => 'Indonesia Coverage',
                    ],
                ],
            ],
        ],
    ],
    'about' => [
        'title' => 'Tentang perusahaan',
        'fields' => [
            'field_1' => [
                'label' => 'Label bagian — About FT Logistik',
                'type' => 'text',
            ],
            'field_2' => [
                'label' => 'Judul bagian (Enter untuk baris baru)',
                'type' => 'textarea',
            ],
            'field_3' => [
                'label' => 'Deskripsi — FT Logistik membantu bisnis mengelola kebutuhan…',
                'type' => 'textarea',
            ],
        ],
        'groups' => [
            'features' => [
                'label' => 'Keunggulan',
                'fields' => [
                    'field_1' => [
                        'label' => 'Judul / nama',
                        'type' => 'text',
                    ],
                    'field_2' => [
                        'label' => 'Teks',
                        'type' => 'text',
                    ],
                ],
            ],
        ],
        'defaults' => [
            'fields' => [
                'field_1' => 'About FT Logistik',
                'field_2' => 'Reliable movement.
Clear execution.',
                'field_3' => 'FT Logistik membantu bisnis mengelola kebutuhan transportasi darat, container, dan cargo movement dengan armada yang sesuai, koordinasi yang jelas, dan jangkauan pengiriman lintas Indonesia.',
            ],
            'groups' => [
                'features' => [
                    0 => [
                        'field_1' => 'Trusted Operation',
                        'field_2' => 'Pengiriman dikelola dengan alur operasional yang terstruktur.',
                    ],
                    1 => [
                        'field_1' => 'Flexible Fleet',
                        'field_2' => 'Pilihan unit disesuaikan dengan jenis cargo dan rute.',
                    ],
                    2 => [
                        'field_1' => 'Nationwide Reach',
                        'field_2' => 'Coverage pengiriman ke berbagai wilayah Indonesia.',
                    ],
                    3 => [
                        'field_1' => 'Business Focused',
                        'field_2' => 'Solusi transportasi untuk kebutuhan B2B dan distribusi.',
                    ],
                ],
            ],
        ],
    ],
    'services' => [
        'title' => 'Layanan',
        'fields' => [
            'field_1' => [
                'label' => 'Label bagian — Our Services',
                'type' => 'text',
            ],
            'field_2' => [
                'label' => 'Judul bagian (Enter untuk baris baru)',
                'type' => 'textarea',
            ],
            'field_3' => [
                'label' => 'Deskripsi — Layanan dibuat sederhana dan mudah dipahami aga…',
                'type' => 'textarea',
            ],
        ],
        'groups' => [
            'items' => [
                'label' => 'Daftar layanan',
                'fields' => [
                    'field_1' => [
                        'label' => 'Judul / nama',
                        'type' => 'text',
                    ],
                    'field_2' => [
                        'label' => 'Deskripsi',
                        'type' => 'textarea',
                    ],
                ],
            ],
        ],
        'defaults' => [
            'fields' => [
                'field_1' => 'Our Services',
                'field_2' => 'Transport solutions
for every shipment.',
                'field_3' => 'Layanan dibuat sederhana dan mudah dipahami agar calon customer cepat menemukan solusi yang sesuai.',
            ],
            'groups' => [
                'items' => [
                    0 => [
                        'field_1' => 'Trucking Services',
                        'field_2' => 'Multi fleet untuk kebutuhan distribusi regional dan antarkota.',
                    ],
                    1 => [
                        'field_1' => 'Container Hauling',
                        'field_2' => 'Trailer 20’ dan 40’ untuk port serta industrial movement.',
                    ],
                    2 => [
                        'field_1' => 'Door to Door',
                        'field_2' => 'Pickup hingga destination dengan koordinasi end-to-end.',
                    ],
                    3 => [
                        'field_1' => 'Domestic LCL / FCL',
                        'field_2' => 'Solusi pengiriman berdasarkan volume dan kebutuhan cargo.',
                    ],
                    4 => [
                        'field_1' => 'EMKL & Cargo Handling',
                        'field_2' => 'Loading, unloading, container movement, dan operational support.',
                    ],
                ],
            ],
        ],
    ],
    'fleet' => [
        'title' => 'Armada',
        'fields' => [
            'field_1' => [
                'label' => 'Label bagian — Our Fleet',
                'type' => 'text',
            ],
            'field_2' => [
                'label' => 'Judul bagian (Enter untuk baris baru)',
                'type' => 'textarea',
            ],
            'field_3' => [
                'label' => 'Deskripsi — Armada ditampilkan sebagai solusi transportasi,…',
                'type' => 'textarea',
            ],
            'field_4' => [
                'label' => 'Gambar',
                'type' => 'image',
            ],
            'field_5' => [
                'label' => 'Keterangan gambar',
                'type' => 'text',
            ],
            'field_6' => [
                'label' => 'Kategori — Container Hauling',
                'type' => 'text',
            ],
            'field_7' => [
                'label' => 'Judul / nama — Trailer Container 20’ / 40’',
                'type' => 'text',
            ],
        ],
        'groups' => [
            'items' => [
                'label' => 'Armada tambahan',
                'fields' => [
                    'field_1' => [
                        'label' => 'Gambar',
                        'type' => 'image',
                    ],
                    'field_2' => [
                        'label' => 'Keterangan gambar',
                        'type' => 'text',
                    ],
                    'field_3' => [
                        'label' => 'Kategori',
                        'type' => 'text',
                    ],
                    'field_4' => [
                        'label' => 'Judul / nama',
                        'type' => 'text',
                    ],
                ],
            ],
        ],
        'defaults' => [
            'fields' => [
                'field_1' => 'Our Fleet',
                'field_2' => 'The right vehicle
for the right cargo.',
                'field_3' => 'Armada ditampilkan sebagai solusi transportasi, bukan sekadar katalog kendaraan.',
                'field_4' => 'assets/ft/images/image-03.jpg',
                'field_5' => 'Trailer Container',
                'field_6' => 'Container Hauling',
                'field_7' => 'Trailer Container 20’ / 40’',
            ],
            'groups' => [
                'items' => [
                    0 => [
                        'field_1' => 'assets/ft/images/image-04.jpg',
                        'field_2' => 'Tronton Wingsbox',
                        'field_3' => 'High Volume',
                        'field_4' => 'Tronton Wingsbox',
                    ],
                    1 => [
                        'field_1' => 'assets/ft/images/image-05.jpg',
                        'field_2' => 'Fuso',
                        'field_3' => 'Distribution',
                        'field_4' => 'Fuso',
                    ],
                    2 => [
                        'field_1' => 'assets/ft/images/image-06.jpg',
                        'field_2' => 'Tronton Box',
                        'field_3' => 'General Cargo',
                        'field_4' => 'Tronton Box',
                    ],
                    3 => [
                        'field_1' => 'assets/ft/images/image-07.jpg',
                        'field_2' => 'CDD CDE',
                        'field_3' => 'Urban Delivery',
                        'field_4' => 'CDD / CDE',
                    ],
                ],
            ],
        ],
    ],
    'network' => [
        'title' => 'Jangkauan pengiriman',
        'fields' => [
            'field_1' => [
                'label' => 'Label bagian — Coverage',
                'type' => 'text',
            ],
            'field_2' => [
                'label' => 'Judul bagian (Enter untuk baris baru)',
                'type' => 'textarea',
            ],
            'field_3' => [
                'label' => 'Deskripsi — Peta interaktif untuk melihat titik jangkauan o…',
                'type' => 'textarea',
            ],
        ],
        'groups' => [
            'cities' => [
                'label' => 'Kota jangkauan',
                'fields' => [
                    'field_1' => [
                        'label' => 'Teks tombol / menu',
                        'type' => 'text',
                    ],
                    'field_2' => [
                        'label' => 'Nama kota',
                        'type' => 'text',
                    ],
                    'field_3' => [
                        'label' => 'Provinsi',
                        'type' => 'text',
                    ],
                    'field_4' => [
                        'label' => 'Latitude',
                        'type' => 'latitude',
                    ],
                    'field_5' => [
                        'label' => 'Longitude',
                        'type' => 'longitude',
                    ],
                ],
            ],
        ],
        'defaults' => [
            'fields' => [
                'field_1' => 'Coverage',
                'field_2' => 'Indonesia
within reach.',
                'field_3' => 'Peta interaktif untuk melihat titik jangkauan operasional FT Logistik. Bisa di-zoom, drag, dan klik marker.',
            ],
            'groups' => [
                'cities' => [
                    0 => [
                        'field_1' => 'Jakarta',
                        'field_2' => 'Jakarta',
                        'field_3' => 'DKI Jakarta',
                        'field_4' => '-6.2088',
                        'field_5' => '106.8456',
                    ],
                    1 => [
                        'field_1' => 'Surabaya',
                        'field_2' => 'Surabaya',
                        'field_3' => 'Jawa Timur',
                        'field_4' => '-7.2575',
                        'field_5' => '112.7521',
                    ],
                    2 => [
                        'field_1' => 'Palembang',
                        'field_2' => 'Palembang',
                        'field_3' => 'Sumatera Selatan',
                        'field_4' => '-2.9761',
                        'field_5' => '104.7754',
                    ],
                    3 => [
                        'field_1' => 'Banjarmasin',
                        'field_2' => 'Banjarmasin',
                        'field_3' => 'Kalimantan Selatan',
                        'field_4' => '-3.3186',
                        'field_5' => '114.5944',
                    ],
                    4 => [
                        'field_1' => 'Bali / Denpasar',
                        'field_2' => 'Denpasar',
                        'field_3' => 'Bali',
                        'field_4' => '-8.6705',
                        'field_5' => '115.2126',
                    ],
                    5 => [
                        'field_1' => 'NTT / Kupang',
                        'field_2' => 'Kupang',
                        'field_3' => 'Nusa Tenggara Timur',
                        'field_4' => '-10.1772',
                        'field_5' => '123.607',
                    ],
                    6 => [
                        'field_1' => 'Makassar',
                        'field_2' => 'Makassar',
                        'field_3' => 'Sulawesi Selatan',
                        'field_4' => '-5.1477',
                        'field_5' => '119.4327',
                    ],
                    7 => [
                        'field_1' => 'Papua / Jayapura',
                        'field_2' => 'Jayapura',
                        'field_3' => 'Papua',
                        'field_4' => '-2.5337',
                        'field_5' => '140.7181',
                    ],
                ],
            ],
        ],
    ],
    'process' => [
        'title' => 'Alur pengiriman',
        'fields' => [
            'field_1' => [
                'label' => 'Label bagian — How We Work',
                'type' => 'text',
            ],
            'field_2' => [
                'label' => 'Judul bagian (Enter untuk baris baru)',
                'type' => 'textarea',
            ],
        ],
        'groups' => [
            'items' => [
                'label' => 'Langkah pengiriman',
                'fields' => [
                    'field_1' => [
                        'label' => 'Judul / nama',
                        'type' => 'text',
                    ],
                    'field_2' => [
                        'label' => 'Deskripsi',
                        'type' => 'textarea',
                    ],
                    'field_3' => [
                        'label' => 'Teks',
                        'type' => 'text',
                    ],
                ],
            ],
        ],
        'defaults' => [
            'fields' => [
                'field_1' => 'How We Work',
                'field_2' => 'Simple from
request to delivery.',
            ],
            'groups' => [
                'items' => [
                    0 => [
                        'field_1' => 'Request',
                        'field_2' => 'Pickup, tujuan, jenis cargo, dan kebutuhan khusus.',
                        'field_3' => 'Request',
                    ],
                    1 => [
                        'field_1' => 'Planning',
                        'field_2' => 'Pemilihan armada dan route yang sesuai.',
                        'field_3' => 'Planning',
                    ],
                    2 => [
                        'field_1' => 'Pickup',
                        'field_2' => 'Loading dan dispatch armada.',
                        'field_3' => 'Execution',
                    ],
                    3 => [
                        'field_1' => 'Transportation',
                        'field_2' => 'Pergerakan cargo menuju tujuan.',
                        'field_3' => 'Transit',
                    ],
                    4 => [
                        'field_1' => 'Delivery',
                        'field_2' => 'Serah terima dan konfirmasi pengiriman.',
                        'field_3' => 'Completed',
                    ],
                ],
            ],
        ],
    ],
    'gallery' => [
        'title' => 'Galeri foto & video',
        'fields' => [
            'field_1' => [
                'label' => 'Label bagian — Gallery',
                'type' => 'text',
            ],
            'field_2' => [
                'label' => 'Judul bagian (Enter untuk baris baru)',
                'type' => 'textarea',
            ],
            'field_3' => [
                'label' => 'Deskripsi — Dokumentasi armada, container movement, aktivit…',
                'type' => 'textarea',
            ],
            'field_4' => [
                'label' => 'Teks tombol / menu — Photo Gallery',
                'type' => 'text',
            ],
            'field_5' => [
                'label' => 'Teks tombol / menu — Video Gallery',
                'type' => 'text',
            ],
        ],
        'groups' => [
            'photos' => [
                'label' => 'Foto',
                'fields' => [
                    'field_1' => [
                        'label' => 'Gambar',
                        'type' => 'image',
                    ],
                    'field_2' => [
                        'label' => 'Keterangan gambar',
                        'type' => 'text',
                    ],
                    'field_3' => [
                        'label' => 'Kategori',
                        'type' => 'text',
                    ],
                    'field_4' => [
                        'label' => 'Judul / nama',
                        'type' => 'text',
                    ],
                ],
            ],
            'videos' => [
                'label' => 'Video',
                'fields' => [
                    'field_1' => [
                        'label' => 'Gambar',
                        'type' => 'image',
                    ],
                    'field_2' => [
                        'label' => 'Keterangan gambar',
                        'type' => 'text',
                    ],
                    'field_3' => [
                        'label' => 'Kategori',
                        'type' => 'text',
                    ],
                    'field_4' => [
                        'label' => 'Judul / nama',
                        'type' => 'text',
                    ],
                    'field_5' => [
                        'label' => 'Link video MP4 atau YouTube (opsional)',
                        'type' => 'url',
                    ],
                ],
            ],
        ],
        'defaults' => [
            'fields' => [
                'field_1' => 'Gallery',
                'field_2' => 'Inside our
operation.',
                'field_3' => 'Dokumentasi armada, container movement, aktivitas loading, dan perjalanan distribusi.',
                'field_4' => 'Photo Gallery',
                'field_5' => 'Video Gallery',
            ],
            'groups' => [
                'photos' => [
                    0 => [
                        'field_1' => 'assets/ft/images/image-02.jpg',
                        'field_2' => 'Container Operation',
                        'field_3' => 'Operation',
                        'field_4' => 'Container Movement',
                    ],
                    1 => [
                        'field_1' => 'assets/ft/images/image-04.jpg',
                        'field_2' => 'Wingsbox',
                        'field_3' => 'Fleet',
                        'field_4' => 'Tronton Wingsbox',
                    ],
                    2 => [
                        'field_1' => 'assets/ft/images/image-05.jpg',
                        'field_2' => 'Fuso',
                        'field_3' => 'Distribution',
                        'field_4' => 'Fuso Operation',
                    ],
                    3 => [
                        'field_1' => 'assets/ft/images/image-03.jpg',
                        'field_2' => 'Trailer',
                        'field_3' => 'Container',
                        'field_4' => 'Trailer 40’',
                    ],
                    4 => [
                        'field_1' => 'assets/ft/images/image-06.jpg',
                        'field_2' => 'Tronton',
                        'field_3' => 'Handling',
                        'field_4' => 'Loading & Delivery',
                    ],
                ],
                'videos' => [
                    0 => [
                        'field_1' => 'assets/ft/images/image-02.jpg',
                        'field_2' => 'Fleet Video',
                        'field_3' => 'Video',
                        'field_4' => 'Fleet Operation',
                        'field_5' => '',
                    ],
                    1 => [
                        'field_1' => 'assets/ft/images/image-03.jpg',
                        'field_2' => 'Container Video',
                        'field_3' => 'Video',
                        'field_4' => 'Container Handling',
                        'field_5' => '',
                    ],
                    2 => [
                        'field_1' => 'assets/ft/images/image-04.jpg',
                        'field_2' => 'Distribution Video',
                        'field_3' => 'Video',
                        'field_4' => 'Distribution Journey',
                        'field_5' => '',
                    ],
                ],
            ],
        ],
    ],
    'cta' => [
        'title' => 'Ajakan pengiriman',
        'fields' => [
            'field_1' => [
                'label' => 'Gambar',
                'type' => 'image',
            ],
            'field_2' => [
                'label' => 'Keterangan gambar',
                'type' => 'text',
            ],
            'field_3' => [
                'label' => 'Label bagian — Start Your Shipment',
                'type' => 'text',
            ],
            'field_4' => [
                'label' => 'Judul bagian (Enter untuk baris baru)',
                'type' => 'textarea',
            ],
            'field_5' => [
                'label' => 'Deskripsi — Kirim detail pickup, tujuan, dan cargo Anda. Ti…',
                'type' => 'textarea',
            ],
            'field_6' => [
                'label' => 'Teks tombol / menu — Request Shipping Quote',
                'type' => 'text',
            ],
        ],
        'groups' => [
        ],
        'defaults' => [
            'fields' => [
                'field_1' => 'assets/ft/images/image-04.jpg',
                'field_2' => 'FT Logistik',
                'field_3' => 'Start Your Shipment',
                'field_4' => 'Need a reliable
transport partner?',
                'field_5' => 'Kirim detail pickup, tujuan, dan cargo Anda. Tim FT Logistik akan membantu menentukan armada dan solusi transportasi yang sesuai.',
                'field_6' => 'Request Shipping Quote',
            ],
            'groups' => [
            ],
        ],
    ],
    'footer' => [
        'title' => 'Footer & kontak',
        'fields' => [
            'field_1' => [
                'label' => 'Gambar',
                'type' => 'image',
            ],
            'field_2' => [
                'label' => 'Keterangan gambar',
                'type' => 'text',
            ],
            'field_3' => [
                'label' => 'Deskripsi — PT Firman Tangguh Logistik — The Transporter.',
                'type' => 'textarea',
            ],
            'field_4' => [
                'label' => 'Judul / nama — Company',
                'type' => 'text',
            ],
            'field_5' => [
                'label' => 'Teks tombol / menu — About Us',
                'type' => 'text',
            ],
            'field_6' => [
                'label' => 'Teks tombol / menu — Network',
                'type' => 'text',
            ],
            'field_7' => [
                'label' => 'Teks tombol / menu — Gallery',
                'type' => 'text',
            ],
            'field_8' => [
                'label' => 'Judul / nama — Services',
                'type' => 'text',
            ],
            'field_9' => [
                'label' => 'Teks tombol / menu — Trucking',
                'type' => 'text',
            ],
            'field_10' => [
                'label' => 'Teks tombol / menu — Container',
                'type' => 'text',
            ],
            'field_11' => [
                'label' => 'Teks tombol / menu — LCL / FCL',
                'type' => 'text',
            ],
            'field_12' => [
                'label' => 'Judul / nama — Contact',
                'type' => 'text',
            ],
            'field_13' => [
                'label' => 'Deskripsi — Indonesia',
                'type' => 'textarea',
            ],
            'field_14' => [
                'label' => 'Deskripsi — Trusted & Reliable Transporter',
                'type' => 'textarea',
            ],
            'field_15' => [
                'label' => 'Teks — © 2026 PT Firman Tangguh Logistik',
                'type' => 'text',
            ],
            'field_16' => [
                'label' => 'Teks — The Transporter',
                'type' => 'text',
            ],
        ],
        'groups' => [
        ],
        'defaults' => [
            'fields' => [
                'field_1' => 'assets/ft/images/image-01.png',
                'field_2' => 'Firman Tangguh',
                'field_3' => 'PT Firman Tangguh Logistik — The Transporter.',
                'field_4' => 'Company',
                'field_5' => 'About Us',
                'field_6' => 'Network',
                'field_7' => 'Gallery',
                'field_8' => 'Services',
                'field_9' => 'Trucking',
                'field_10' => 'Container',
                'field_11' => 'LCL / FCL',
                'field_12' => 'Contact',
                'field_13' => 'Indonesia',
                'field_14' => 'Trusted & Reliable Transporter',
                'field_15' => '© 2026 PT Firman Tangguh Logistik',
                'field_16' => 'The Transporter',
            ],
            'groups' => [
            ],
        ],
    ],
    'settings' => [
        'title' => 'Judul website & SEO',
        'fields' => [
            'title' => [
                'label' => 'Judul tab browser',
                'type' => 'text',
            ],
            'description' => [
                'label' => 'Deskripsi website di mesin pencari',
                'type' => 'textarea',
            ],
        ],
        'groups' => [
        ],
        'defaults' => [
            'fields' => [
                'title' => 'FT Logistik — Modern Transportation',
                'description' => 'PT Firman Tangguh Logistik — modern trucking, container hauling, and logistics services across Indonesia.',
            ],
            'groups' => [
            ],
        ],
    ],
];
