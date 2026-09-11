@php
    [$heading, $description] = match ($status) {
        400 => ['Permintaan tidak dapat diproses.', 'Periksa alamat atau data yang Anda kirim, lalu coba kembali.'],
        401 => ['Silakan masuk terlebih dahulu.', 'Anda perlu masuk ke akun untuk membuka halaman ini.'],
        403 => ['Akses halaman ini dibatasi.', 'Akun Anda tidak memiliki izin untuk membuka halaman ini. Hubungi administrator jika Anda membutuhkan akses.'],
        404 => ['Halaman tidak ditemukan.', 'Alamat yang Anda buka mungkin sudah berubah atau halaman tersebut sudah tidak tersedia.'],
        405 => ['Permintaan tidak didukung.', 'Buka kembali halaman melalui tautan yang tersedia di website.'],
        408 => ['Waktu permintaan habis.', 'Periksa koneksi internet Anda, lalu buka kembali halaman yang dituju.'],
        410 => ['Halaman sudah tidak tersedia.', 'Halaman ini telah dihapus. Kunjungi beranda untuk menemukan informasi lainnya.'],
        413 => ['Ukuran unggahan terlalu besar.', 'Kurangi ukuran file sebelum mengirimkannya kembali.'],
        419 => ['Sesi Anda telah berakhir.', 'Buka kembali halaman formulir sebelum mengirim data. Jika diperlukan, masuk kembali ke akun Anda.'],
        422 => ['Data belum dapat diproses.', 'Periksa kembali data yang Anda isi sebelum mengirimkannya.'],
        429 => ['Terlalu banyak permintaan.', 'Tunggu beberapa saat sebelum membuka halaman atau mengirim permintaan kembali.'],
        500 => ['Terjadi gangguan pada server.', 'Halaman belum dapat ditampilkan. Silakan kembali beberapa saat lagi.'],
        502 => ['Layanan belum dapat dijangkau.', 'Terjadi gangguan komunikasi pada server. Silakan kembali beberapa saat lagi.'],
        503 => ['Layanan sementara tidak tersedia.', 'Website sedang tidak dapat melayani permintaan. Silakan kembali beberapa saat lagi.'],
        504 => ['Server belum merespons.', 'Permintaan membutuhkan waktu terlalu lama. Silakan kembali beberapa saat lagi.'],
        default => $status >= 500
            ? ['Layanan sedang mengalami gangguan.', 'Halaman belum dapat ditampilkan. Silakan kembali beberapa saat lagi.']
            : ['Halaman belum dapat dibuka.', 'Permintaan Anda belum dapat diproses. Kunjungi beranda untuk melanjutkan.'],
    };
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $status }} | {{ $heading }} | FT</title>
    <style>
        :root { color-scheme: light; font-family: Arial, Helvetica, sans-serif; color: #111213; background: #f6f5f1; }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; min-height: 100svh; display: flex; flex-direction: column; }
        .wrap { width: min(1120px, calc(100% - 64px)); margin-inline: auto; }
        header { padding-block: 28px; border-bottom: 1px solid #deddd7; }
        .brand { display: inline-block; }
        .brand img { display: block; width: 210px; max-width: 100%; height: auto; }
        main { flex: 1; display: grid; grid-template-columns: 0.9fr 1.1fr; align-items: center; gap: 64px; padding-block: 72px; }
        .code { margin: 0; font-size: clamp(100px, 17vw, 224px); line-height: 1; font-weight: 800; letter-spacing: -0.07em; }
        .label { margin: 18px 0 0; color: #595b57; font-size: 14px; }
        .message { border-left: 4px solid #d1a23e; padding-left: 36px; }
        h1 { margin: 0; max-width: 540px; font-size: clamp(30px, 3.5vw, 48px); line-height: 1.12; letter-spacing: -0.035em; }
        .description { max-width: 470px; margin: 24px 0 30px; font-size: 17px; line-height: 1.75; color: #595b57; }
        .actions { display: flex; flex-wrap: wrap; gap: 12px; }
        .button { display: inline-flex; align-items: center; justify-content: center; min-height: 48px; padding: 14px 20px; background: #111213; color: #fff; text-decoration: none; font-size: 16px; font-weight: 700; border: 1px solid #111213; }
        .button:hover { background: #333; }
        .secondary { background: transparent; color: #111213; }
        .secondary:hover { background: #eceae3; }
        a:focus-visible { outline: 3px solid #805d16; outline-offset: 5px; }
        footer { border-top: 1px solid #deddd7; padding-block: 24px; color: #595b57; font-size: 14px; }
        @media (max-width: 700px) {
            .wrap { width: calc(100% - 40px); }
            header { padding-block: 22px; }
            .brand img { width: 180px; }
            main { grid-template-columns: 1fr; gap: 36px; padding-block: 48px; }
            .code { font-size: clamp(96px, 29vw, 160px); }
            .message { padding-left: 20px; }
            .description { margin-block: 20px 24px; }
        }
    </style>
</head>
<body>
    <header><div class="wrap"><a class="brand" href="{{ url('/') }}" aria-label="Beranda FT"><img src="{{ asset('assets/ft/images/image-01.png') }}" alt="FT"></a></div></header>
    <main class="wrap">
        <div><p class="code">{{ $status }}</p><p class="label">Halaman tidak dapat ditampilkan</p></div>
        <section class="message" aria-labelledby="error-heading">
            <h1 id="error-heading">{{ $heading }}</h1>
            <p class="description">{{ $description }}</p>
            <div class="actions">
                <a class="button" href="{{ url('/') }}">Kembali ke beranda</a>
                @if(in_array($status, [401, 419], true))
                    <a class="button secondary" href="{{ url('/admin/login') }}">Masuk ke akun</a>
                @endif
            </div>
        </section>
    </main>
    <footer><div class="wrap">FT &middot; {{ $status }}</div></footer>
</body>
</html>
