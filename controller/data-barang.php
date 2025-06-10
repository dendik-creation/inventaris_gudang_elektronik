<?php
require __DIR__ . '/../config/koneksi.php';

// Fitur search
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = '';
if ($search !== '') {
    $esc = mysqli_real_escape_string($koneksi, $search);
    $where = "WHERE b.nama_barang LIKE '%$esc%' OR k.nama_kategori LIKE '%$esc%'";
}

// Tambah barang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $nama_barang = trim($_POST['nama_barang']);
    $kategori_id = (int)$_POST['kategori_id'];
    $quantity = (int)$_POST['quantity'];
    if ($nama_barang !== '' && $kategori_id && $quantity >= 0) {
        // Insert barang
        $stmt = mysqli_prepare($koneksi, "INSERT INTO barang (nama_barang, kategori_id, quantity) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sii", $nama_barang, $kategori_id, $quantity);
        mysqli_stmt_execute($stmt);

        $barang_id = mysqli_insert_id($koneksi);

        // insert log
        if ($barang_id && $quantity > 0) {
            $aksi = "MASUK";
            $keterangan = "Penambahan barang baru";
            $stmt_log = mysqli_prepare($koneksi, "INSERT INTO aktivitas_barang (barang_id, quantity, aksi, keterangan) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt_log, "iiss", $barang_id, $quantity, $aksi, $keterangan);
            mysqli_stmt_execute($stmt_log);
            mysqli_stmt_close($stmt_log);
        }

        mysqli_stmt_close($stmt);
        session_start();
        $_SESSION['success_message'] = "Barang berhasil ditambahkan";
        header("Location: index.php");
        exit;
    }
}

// Tambah barang masuk/keluar
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['barang-keluar-masuk'])) {
    $barang_id = (int)$_POST['barang_id'];
    $aksi = $_POST['aksi'];
    $quantity = (int)$_POST['quantity'];
    $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : null;

    if ($barang_id && $quantity > 0 && in_array($aksi, ['MASUK', 'KELUAR'])) {
        // Update quantity barang
        if ($aksi === 'KELUAR') {
            $res_qty = mysqli_query($koneksi, "SELECT quantity FROM barang WHERE id = $barang_id");
            $row_qty = mysqli_fetch_assoc($res_qty);
            if (!$row_qty || $row_qty['quantity'] < $quantity) {
            session_start();
            $_SESSION['error_message'] = "Stok barang tidak mencukupi untuk dikeluarkan.";
            header("Location: index.php");
            exit;
            }
            $adjustment = -$quantity;
        } else {
            $adjustment = $quantity;
        }
        $update_stmt = mysqli_prepare($koneksi, "UPDATE barang SET quantity = quantity + ? WHERE id = ?");
        mysqli_stmt_bind_param($update_stmt, "ii", $adjustment, $barang_id);
        mysqli_stmt_execute($update_stmt);
        mysqli_stmt_close($update_stmt);

        // Insert log aktivitas
        $log_stmt = mysqli_prepare($koneksi, "INSERT INTO aktivitas_barang (barang_id, quantity, aksi, keterangan) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($log_stmt, "iiss", $barang_id, $quantity, $aksi, $keterangan);
        mysqli_stmt_execute($log_stmt);
        mysqli_stmt_close($log_stmt);

        session_start();
        $_SESSION['success_message'] = "Aktivitas barang berhasil dicatat";
        header("Location: index.php");
        exit;
    }
}

// Edit barang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $nama_barang = trim($_POST['nama_barang']);
    $kategori_id = (int)$_POST['kategori_id'];
    if ($id && $nama_barang !== '' && $kategori_id) {
        $stmt = mysqli_prepare($koneksi, "UPDATE barang SET nama_barang=?, kategori_id=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sii", $nama_barang, $kategori_id, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        session_start();
        $_SESSION['success_message'] = "Barang berhasil diperbarui";
        header("Location: index.php");
        exit;
    }
}

// Hapus barang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus'])) {
    $id = (int)$_POST['id'];
    if ($id) {
        $stmt = mysqli_prepare($koneksi, "DELETE FROM barang WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        session_start();
        $_SESSION['success_message'] = "Barang berhasil dihapus";
        header("Location: index.php");
        exit;
    }
}

// Untuk form edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $res = mysqli_query($koneksi, "SELECT * FROM barang WHERE id=$id");
    $edit_data = mysqli_fetch_assoc($res);
}

// Ambil data kategori untuk select option
$kategori_list = [];
$res_kat = mysqli_query($koneksi, "SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC");
while ($row = mysqli_fetch_assoc($res_kat)) {
    $kategori_list[] = $row;
}

// Index & Search
$barangs = "SELECT b.id, b.nama_barang, k.nama_kategori, b.quantity
        FROM barang b
        INNER JOIN kategori k ON b.kategori_id = k.id
        $where
        ORDER BY b.id ASC";
$barang_list = mysqli_query($koneksi, $barangs);