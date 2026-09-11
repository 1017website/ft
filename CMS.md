# CMS FT Logistik

Jalankan server lokal dari folder project:

```powershell
php artisan cms:serve
```

Website: http://127.0.0.1:8000. Admin: http://127.0.0.1:8000/admin.

Database lokal saat ini menggunakan MySQL di `127.0.0.1:3306`, database `ft`, mengikuti konfigurasi `.env`. Database menyimpan konten, akun admin, dan permintaan penawaran. Gambar upload berada di `storage/app/public/cms`. Cadangkan database dan folder gambar secara bersamaan.

Pada lingkungan `local` atau `testing`, `php artisan db:seed` mengisi konten awal dan menyiapkan akun `admin@ftlogistik.local` serta `1017website@gmail.com` dengan akses admin. Seeder yang dijalankan ulang mempertahankan password dan konten yang sudah diubah. Akun lokal tidak dibuat pada lingkungan production.

## Mengisi konten

1. Masuk dengan akun admin, lalu pilih bagian website.
2. Edit teks melalui kolom biasa. Pada judul bagian, Enter membuat baris baru.
3. Pilih gambar JPG, PNG, atau WebP maksimal 5 MB. Preview ditampilkan sebelum disimpan. Kosongkan upload untuk mempertahankan gambar lama.
4. Gunakan Tambah, Naik, Turun, atau Hapus pada daftar. Armada utama diisi di bagian atas; unit lainnya di daftar Armada tambahan.
5. Klik Simpan perubahan. Perubahan langsung terbit. Buka Lihat website untuk mengecek hasil.

Galeri video menerima link YouTube atau MP4. Link kosong menampilkan poster dan informasi bahwa video belum tersedia. Jangkauan memakai koordinat desimal latitude/longitude. Peta membutuhkan internet.

Permintaan dari formulir website tersimpan di menu Permintaan penawaran. Ubah status menjadi Diproses atau Selesai setelah ditindaklanjuti. CMS tidak mengirim email atau WhatsApp otomatis.

Menu Akun digunakan untuk mengganti kata sandi. Untuk membuat admin tambahan:

```powershell
php artisan cms:admin alamat@email.com
```

Perintah menampilkan kata sandi acak satu kali dan tidak menimpa akun yang sudah ada. Tidak tersedia registrasi publik.

## Alternatif setup SQLite di komputer lain

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
New-Item database/database.sqlite -ItemType File
php artisan migrate
php artisan db:seed --class=CmsSeeder
php artisan storage:link
php artisan cms:admin alamat@email.com
```

Gunakan `DB_CONNECTION=sqlite`, tanpa `DB_DATABASE` agar Laravel memilih path database lokal. Jangan menjalankan perintah pembuatan file di atas pada database yang sudah ada. Seeder CMS hanya mengisi bagian yang belum ada, tidak mereset konten.

## Fitur lanjutan CMS

- **Statistik pengunjung:** menu Statistik menampilkan tayangan, estimasi pengunjung unik harian, sumber kunjungan, perangkat, dan penawaran untuk 7/30/90 hari. Data mulai terkumpul sejak fitur dipasang; bukan data historis Google Analytics. Admin yang login dan bot yang dikenali tidak dihitung. Identitas berupa hash harian, bukan alamat IP mentah; total unik periode adalah penjumlahan unik harian, bukan orang unik lintas hari.
- **SEO & mesin pencari:** isi canonical, deskripsi, Open Graph, gambar bagikan, verifikasi Google/Bing, serta profil organisasi. Metadata Twitter, JSON-LD Organization, `/robots.txt`, dan `/sitemap.xml` dibuat otomatis. Pilihan noindex menghapus halaman dari sitemap. Pengaturan ini tidak menjamin peringkat pencarian.
- **Analytics & iklan:** masukkan ID GA4, Google Tag Manager, Google Ads beserta label konversi, Meta Pixel, Microsoft Clarity, atau AdSense. Tidak perlu menempelkan script. AdSense memiliki slot setelah banner atau sebelum footer. Google Ads dan Meta Pixel melacak kampanye, bukan tempat menampilkan banner iklan. Tag lain dapat dikelola melalui GTM; hindari memasang tag yang sama lewat GTM dan kolom langsung agar tidak terhitung dua kali.
- **Persetujuan pelacakan:** bawaan meminta persetujuan sebelum memuat integrasi pihak ketiga. Pengunjung dapat mengubah pilihan melalui tombol preferensi. Sesuaikan kebijakan privasi dan kebutuhan persetujuan untuk website yang dipublikasikan. Semua integrasi masih nonaktif jika ID belum diisi; verifikasi penerimaan event pada dashboard penyedia setelah konfigurasi.
- **Preview editor:** panel samping memperbarui frontend setelah input berubah dan menyorot bagian terkait. Tersedia ukuran desktop dan HP. Preview tidak menyimpan konten, tidak mencatat kunjungan, dan tidak menjalankan integrasi iklan. Perubahan baru terbit setelah Simpan perubahan. Gambar baru juga bisa diperiksa sebelum upload disimpan.
- **Logo & favicon:** gambar logo frontend di Logo & menu, logo footer di Footer & kontak. Menu Logo, favicon & ukuran mengatur logo CMS, favicon, serta lebar logo frontend desktop/HP, footer, dan CMS. Gunakan PNG transparan untuk logo; favicon mengikuti ukuran tampilan yang ditentukan browser.
- **Jumlah konten:** daftar dapat ditambah, dihapus, dan diurutkan hingga 100 item per daftar, tidak terikat jumlah awal template. Galeri memiliki pengaturan jumlah yang ditampilkan (0 berarti semua) serta jumlah kolom foto/video. Bagian halaman juga dapat disembunyikan tanpa menghapus isinya.

Upload menerima JPG/PNG/WebP hingga 5 MB per gambar; maksimal 100 file dan 60 MB total per penyimpanan. Jalankan `php artisan cms:serve` agar batas PHP lokal sesuai. Pada hosting, sesuaikan juga batas PHP/web server. Setelah memasang pembaruan di lingkungan lain, jalankan `php artisan migrate` dan `php artisan storage:link`; cadangkan data sebelum pembaruan.

## Struktur pengembangan

- `config/cms.php`: definisi kolom form dan isi awal template.
- `resources/cms/extensions.php`: definisi SEO, branding, integrasi, visibilitas, dan jumlah galeri.
- `daily_visitors`: statistik agregat kunjungan per identitas harian.
- `site_sections`: konten tersimpan per bagian dalam JSON. Kolom internal `field_1`, dst. dipetakan ke label form; jangan mengganti kuncinya tanpa migrasi data.
- `resources/views/pages/home/sections`: tampilan per bagian.
- `resources/views/admin`: form CMS dan kotak masuk.
- `public/assets/ft`: aset website asli; `public/assets/admin`: aset admin.

Gambar lama sengaja dipertahankan ketika konten diganti/dihapus untuk menghindari kehilangan file yang mungkin masih digunakan bagian lain. Menghapus item baru berlaku setelah Simpan. Tes memakai SQLite dalam memori, terpisah dari database lokal.

## Catatan desain dan verifikasi 11 September 2026

CMS dibaca sebagai alat pengisian konten untuk staf FT Logistik, mengikuti identitas emas/charcoal template: ENERGY 1 / RHYTHM 2 / MOTION 1. Sidebar gelap membedakan navigasi dari form terang; emas menandai bagian aktif. Jakarta dipilih untuk keterbacaan label Indonesia dengan bentuk huruf yang lebih terbuka. Panel editor dikelompokkan sesuai bagian frontend, dengan preview di samping pada desktop dan ditumpuk pada HP. Kartu ringkasan adalah pintasan ke bagian nyata, bukan statistik buatan. Pola papan kotak pada upload menunjukkan transparansi gambar, bukan dekorasi halaman. Ikon truk, gambar, dan kotak masuk menandai armada, galeri, dan penawaran; logo/gambar memakai aset pengguna. Animasi dibatasi pada umpan balik kontrol dan drawer, dengan dukungan reduced motion.

Hasil pemeriksaan:

- PASS fungsi backend: `php artisan test`, 18 tes / 146 assertions; mencakup otorisasi, login, upload, validasi, konflik edit, daftar dinamis, statistik, metadata, sitemap, dan preview tanpa penyimpanan.
- PASS integrasi simulasi: `node --test tests/JavaScript/integrations.test.cjs`, 3 tes; tag menunggu persetujuan, penolakan disimpan, pencabutan memuat ulang, serta event konversi sesuai ID. Tes tidak mengirim data ke penyedia.
- PASS browser preview: edit judul mengubah HTML preview; upload PNG menghasilkan preview lokal dan frontend; Batalkan mengembalikan gambar; Simpan berhasil. Teks dan gambar uji sudah dikembalikan ke nilai asli.
- PASS daftar video: Tambah video menaikkan jumlah 3 ke 4; Hapus mengembalikan ke 3; penyimpanan berhasil.
- PASS statistik: filter 7 hari menghasilkan 7 baris; Lihat data harian membuka tabel; kondisi kosong dijelaskan tanpa grafik/data rekaan.
- PASS layout yang diuji: CMS pada lebar 320/390/768/1440, tanpa overflow halaman pada pemeriksaan DOM layar kecil; menu HP membuka navigasi dan tautan menuju editor. Tidak ditemukan error console pada sesi uji.
- PASS kontras pasangan yang diperbaiki: teks bantuan #5c6857 pada putih 5.88:1; teks #202722 pada emas #dfb958 8.16:1; batas input #859080 pada #fcfdfb 3.27:1 (batas komponen, bukan teks). Tombol preview dan pengurutan memiliki tinggi minimum 44px.

Penerimaan event di dashboard Google/Meta/Clarity/AdSense belum diuji dengan akun nyata karena ID belum diisi. Pengujian browser menggunakan emulasi ukuran layar, bukan perangkat HP fisik. Teks/klaim bisnis bawaan template tetap perlu ditinjau pemilik sebelum publikasi.
