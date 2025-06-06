<?php

return [
    'CREATE DATABASE IF NOT EXISTS ' . $_ENV['DB_NAME'] . ' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci',

    'USE ' . $_ENV['DB_NAME'],

    'CREATE TABLE IF NOT EXISTS kategori (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama_kategori VARCHAR(100) NOT NULL
    )',

    'CREATE TABLE IF NOT EXISTS barang (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama_barang VARCHAR(100) NOT NULL,
        kategori_id INT NOT NULL,
        quantity INT DEFAULT 0,
        FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE CASCADE
    )',

    'CREATE TABLE IF NOT EXISTS aktivitas_barang (
        id INT AUTO_INCREMENT PRIMARY KEY,
        barang_id INT NOT NULL,
        quantity INT NOT NULL,
        aksi ENUM("MASUK", "KELUAR") NOT NULL,
        waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        keterangan TEXT NULL,
        FOREIGN KEY (barang_id) REFERENCES barang(id) ON DELETE CASCADE
    )'
];
