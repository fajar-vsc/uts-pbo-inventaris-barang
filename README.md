# Sistem Inventaris Barang (UTS PBO)

Aplikasi CRUD inventaris barang memakai **Laravel 13** dengan pola **Route -> Controller -> Blade**.
Data disimpan di **session** (`SESSION_DRIVER=file`), tanpa database.

Nama: Muhammad Fajar Ghaisan
NIM: 20251020013

## Struktur file utama

| File | Fungsi |
|---|---|
| `routes/web.php` | 7 route barang (named route `barang.*`) |
| `app/Http/Controllers/BarangController.php` | Logika CRUD dan pengelolaan session |
| `resources/views/layouts/app.blade.php` | Layout utama (judul, navigasi, konten, footer) |
| `resources/views/barang/index.blade.php` | Daftar barang |
| `resources/views/barang/show.blade.php` | Detail barang |
| `resources/views/barang/create.blade.php` | Form tambah |
| `resources/views/barang/edit.blade.php` | Form edit |
| `resources/views/barang/_form.blade.php` | Field form bersama tambah dan edit |

## Cara menjalankan

1. Clone repository dan masuk ke foldernya:
   ```bash
   git clone https://github.com/fajar-vsc/uts-pbo-inventaris-barang.git
   cd uts-pbo-inventaris-barang
   ```
2. Install dependensi:
   ```bash
   composer install
   ```
3. Salin `.env.example` menjadi `.env`, lalu buat app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Pada file `.env`, pastikan:
   ```
   SESSION_DRIVER=file
   ```
5. Pastikan folder `storage/framework/sessions` dapat ditulisi (di Linux/Mac: `chmod -R 775 storage bootstrap/cache`).
6. Jalankan server:
   ```bash
   php artisan serve
   ```
7. Buka `http://127.0.0.1:8000` di browser.
8. Cek daftar route:
   ```bash
   php artisan route:list
   ```

## Catatan
- Data tersimpan di session, jadi akan hilang jika session berakhir atau dibersihkan.
- File `.env`, `vendor/`, dan `node_modules/` tidak disertakan di repository.
