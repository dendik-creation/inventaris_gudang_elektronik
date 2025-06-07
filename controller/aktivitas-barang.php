<?php 
require __DIR__ . '/../config/koneksi.php';

// Index & Search
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where_search = '';
$params = [];
if ($search) {
    $search_escaped = mysqli_real_escape_string($koneksi, $search);
    $where_search = "WHERE brg.nama_barang LIKE '%$search_escaped%' 
              OR ktg.nama_kategori LIKE '%$search_escaped%' 
              OR ab.aksi LIKE '%$search_escaped%'";
}

$sql = "SELECT 
            ab.id,
            brg.nama_barang,
            ktg.nama_kategori,
            ab.quantity,
            ab.aksi,
            ab.waktu,
            ab.keterangan
        FROM aktivitas_barang ab
        INNER JOIN barang brg ON ab.barang_id = brg.id
        INNER JOIN kategori ktg ON brg.kategori_id = ktg.id
        $where_search
        ORDER BY ab.waktu DESC";
$aktivitas_barang = mysqli_query($koneksi, $sql);