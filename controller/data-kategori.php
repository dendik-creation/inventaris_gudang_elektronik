<?php
require __DIR__ . '/../config/koneksi.php';

// Index & Search
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = '';
if ($search !== '') {
    $where = "WHERE k.nama_kategori LIKE '%" . mysqli_real_escape_string($koneksi, $search) . "%'";
}

$kategories = "SELECT k.id, k.nama_kategori, COUNT(b.id) AS jumlah_barang
        FROM kategori k
        LEFT JOIN barang b ON b.kategori_id = k.id
        $where
        GROUP BY k.id, k.nama_kategori
        ORDER BY k.id ASC";
$data_kategori = mysqli_query($koneksi, $kategories);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $nama_kategori = trim($_POST['nama_kategori']);
    if ($nama_kategori !== '') {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO kategori (nama_kategori) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $nama_kategori);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        session_start();
        $_SESSION['success_message'] = "Kategori berhasil ditambahkan";
        header("Location: index.php");
        exit;
    }
}

// Edit kategori
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $nama_kategori = trim($_POST['nama_kategori']);
    if ($id && $nama_kategori !== '') {
        $stmt = mysqli_prepare($koneksi, "UPDATE kategori SET nama_kategori=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "si", $nama_kategori, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        session_start();
        $_SESSION['success_message'] = "Kategori berhasil diperbarui";
        header("Location: index.php");
        exit;
    }
}

// Hapus kategori
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus'])) {
    $id = (int)$_POST['id'];
    if ($id) {
        $stmt = mysqli_prepare($koneksi, "DELETE FROM kategori WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        session_start();
        $_SESSION['success_message'] = "Kategori berhasil dihapus";
        header("Location: index.php");
        exit;
    }
}

// Untuk form edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $res = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id=$id");
    $edit_data = mysqli_fetch_assoc($res);
}