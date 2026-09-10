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

## Struktur pengembangan

- `config/cms.php`: definisi kolom form dan isi awal template.
- `site_sections`: konten tersimpan per bagian dalam JSON. Kolom internal `field_1`, dst. dipetakan ke label form; jangan mengganti kuncinya tanpa migrasi data.
- `resources/views/pages/home/sections`: tampilan per bagian.
- `resources/views/admin`: form CMS dan kotak masuk.
- `public/assets/ft`: aset website asli; `public/assets/admin`: aset admin.

Gambar lama sengaja dipertahankan ketika konten diganti/dihapus untuk menghindari kehilangan file yang mungkin masih digunakan bagian lain. Menghapus item baru berlaku setelah Simpan. Tes memakai SQLite dalam memori, terpisah dari database lokal.
