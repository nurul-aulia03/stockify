# Stockify — Inventory & Sales Management System

Stockify adalah aplikasi berbasis web untuk membantu pengelolaan inventaris produk, pemasok, pembelian, penjualan, dan persediaan barang. Proyek ini dikembangkan menggunakan Laravel sebagai proyek perkuliahan.

## Fitur Utama

- Dashboard untuk melihat ringkasan inventaris dan transaksi.
- Manajemen kategori dan produk.
- Manajemen data pemasok.
- Transaksi pembelian barang dan pencatatan barang masuk.
- Transaksi penjualan dan pembaruan stok otomatis.
- Riwayat pergerakan stok produk.
- Laporan penjualan, pembelian, dan persediaan.
- Manajemen pengguna berdasarkan role Admin, Staff, dan Customer.
- Keranjang dan pesanan pelanggan.

## Teknologi

- PHP
- Laravel
- MySQL / MariaDB
- Blade
- HTML dan CSS

## Struktur Proyek

```text
stockify/
├── app/
├── bootstrap/
├── config/
├── database/
│   └── migrations/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── ERD.md
├── README.md
└── artisan
```

## Instalasi

Pastikan PHP, Composer, dan MySQL/MariaDB telah terpasang.

1. Clone repository:

   ```bash
   git clone URL_REPOSITORY
   cd stockify
   ```

2. Instal dependensi:

   ```bash
   composer install
   ```

3. Buat file konfigurasi lokal:

   ```bash
   copy .env.example .env
   ```

4. Buat application key:

   ```bash
   php artisan key:generate
   ```

5. Buat database bernama `stockify`, lalu sesuaikan konfigurasi database di file `.env`.

6. Jalankan migration:

   ```bash
   php artisan migrate
   ```

7. Jalankan server lokal:

   ```bash
   php artisan serve
   ```

8. Buka `http://127.0.0.1:8000` di browser.

## Database dan ERD

Diagram hubungan entitas (ERD) tersedia pada file [`ERD.md`](ERD.md). File tersebut menjelaskan hubungan antartabel utama dalam sistem Stockify.

## Keamanan

- Jangan mengunggah file `.env` ke repository.
- Jangan membagikan kata sandi atau kredensial database.
- Gunakan `.env.example` sebagai contoh konfigurasi.

## Status Proyek

Proyek dalam tahap pengembangan dan penyelesaian tugas perkuliahan.