# Inventaris Gudang Elektronik

## Deskripsi Projek

Inventaris Gudang Elektronik adalah aplikasi berbasis web untuk mengelola inventaris barang elektronik di gudang. Fitur utama meliputi pengelolaan data barang, kategori barang, serta pencatatan aktivitas keluar-masuk barang.

## Tujuan Projek

Proyek ini dibuat untuk memenuhi tugas akhir mata kuliah Praktikum Pemrograman Lanjut dan dikerjakan secara berkelompok:

- Dendi' Setiawan (202451181)
- Muhammad Bintang Adhipura (202451165)
- Naufal Rizqi Ilham Gibran (202451154)
- Ahmad Ilham Mujib (202451163)
- Aditya Wahyu Aji Pangestu (202451153)

## Persyaratan Sistem

- PHP 7.4 atau lebih baru
- MySQL 5.7 atau lebih baru
- Web server (Apache, Nginx)
- 3 poin diatas dapat di gunakan di XAMPP, Laragon, atau lainnya...

## Instalasi

1. Pindah ke direktori `htdocs` atau `www` sesuai web server yang digunakan:
   ```bash
   # Untuk XAMPP
   cd C:/xampp/htdocs
   # Untuk Laragon
   cd C:/laragon/www
   ```
2. Clone repositori:
   ```bash
   git clone https://github.com/dendik-creation/inventaris_gudang_elektronik.git
   ```
3. Masuk ke directory:
   ```bash
   cd inventaris_gudang_elektronik
   ```
4. Salin file environment:
   ```bash
   cp .env.example .env
   ```
5. Jalankan migrasi database:
   ```bash
   php database/migration.php
   ```
6. Jalankan aplikasi pada web server lokal (misal: http://localhost/inventaris_gudang_elektronik).

## Fitur Utama

- Manajemen data barang elektronik
- Pengelolaan kategori barang
- Pencatatan log aktivitas keluar-masuk barang
