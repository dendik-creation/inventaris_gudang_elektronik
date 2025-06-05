<?php
require __DIR__ . '../config/env.php';
try {
    $pdo = new PDO(
        'mysql:host=' . $_ENV['DB_HOST'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage() . "\n");
}

echo "🛠️ Inisialisasi Database..\n";

$sqls = require __DIR__ . '/database.php';

foreach ($sqls as $sql) {
    try {
        $pdo->exec($sql);
    } catch (PDOException $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
}

echo "✅ Inisialisasi Selesai\n\n";

echo "🔄 Menjalankan Dummy Data...\n";
require __DIR__ . '/seeder.php';
runSeeder($pdo);
echo "✅ Dummy Data Selesai\n";
