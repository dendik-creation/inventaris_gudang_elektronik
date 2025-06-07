<?php
require __DIR__ . '/../config/koneksi.php';

function getDashboardData()
{
    global $koneksi;

    $query_count = "
        SELECT
            (SELECT COUNT(*) FROM barang) AS total_barang,
            (SELECT COUNT(*) FROM kategori) AS total_kategori
    ";
    $result = mysqli_query($koneksi, $query_count);
    $counts = mysqli_fetch_assoc($result);

    $aktivitas = [];
    $query_aktivitas_barang = "
        SELECT 
            ab.*, 
            brg.nama_barang, 
            ktg.nama_kategori
        FROM aktivitas_barang ab
        INNER JOIN barang brg ON ab.barang_id = brg.id
        INNER JOIN kategori ktg ON brg.kategori_id = ktg.id
        ORDER BY ab.waktu DESC
        LIMIT 5

    ";
    $resultAktivitas = mysqli_query($koneksi, $query_aktivitas_barang);
    if ($resultAktivitas) {
        while ($row = mysqli_fetch_assoc($resultAktivitas)) {
            $aktivitas[] = $row;
        }
    }

    return [
        'total_barang' => (int)$counts['total_barang'],
        'total_kategori' => (int)$counts['total_kategori'],
        'aktivitas_barang' => $aktivitas
    ];
}
