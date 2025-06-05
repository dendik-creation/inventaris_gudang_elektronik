<?php

function runSeeder($pdo) {
    seedKategori($pdo);
    seedBarang($pdo);
    seedAktivitasBarang($pdo);
}

function seedKategori($pdo) {
    $sql = "INSERT INTO kategori (nama_kategori) VALUES 
            ('Elektronik'),
            ('Aksesoris'),
            ('Peralatan')";
    $pdo->exec($sql);
}

function seedBarang($pdo) {
    $sql = "INSERT INTO barang (nama_barang, kategori_id, quantity) VALUES 
            ('Smartphone', 1, 50),
            ('Charger Laptop', 2, 25),
            ('Obeng Set', 3, 15)";
    $pdo->exec($sql);
}

function seedAktivitasBarang($pdo) {
    $sql = "INSERT INTO aktivitas_barang (barang_id, quantity, aksi, keterangan) VALUES 
            (1, 10, 'MASUK', 'Stok awal smartphone'),
            (2, 5, 'MASUK', 'Stok awal charger laptop'),
            (3, 3, 'MASUK', 'Stok awal obeng set')";
    $pdo->exec($sql);
}
