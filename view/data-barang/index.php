<?php
require_once '../../config/koneksi.php';
$title = 'Data Barang';
$css_path = '../../public/css/layout.css';
ob_start();

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
        $stmt = mysqli_prepare($koneksi, "INSERT INTO barang (nama_barang, kategori_id, quantity) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sii", $nama_barang, $kategori_id, $quantity);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: index.php");
        exit;
    }
}

// Edit barang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $nama_barang = trim($_POST['nama_barang']);
    $kategori_id = (int)$_POST['kategori_id'];
    $quantity = (int)$_POST['quantity'];
    if ($id && $nama_barang !== '' && $kategori_id && $quantity >= 0) {
        $stmt = mysqli_prepare($koneksi, "UPDATE barang SET nama_barang=?, kategori_id=?, quantity=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "siii", $nama_barang, $kategori_id, $quantity, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
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

// Query ambil data barang beserta kategori + search
$sql = "SELECT b.id, b.nama_barang, k.nama_kategori, b.quantity
        FROM barang b
        INNER JOIN kategori k ON b.kategori_id = k.id
        $where
        ORDER BY b.id ASC";
$result = mysqli_query($koneksi, $sql);
?>

<!-- Form Search & Print -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <form method="get" class="d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Cari barang/kategori..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-info">Cari</button>
        <?php if ($search): ?>
            <a href="index.php" class="btn btn-secondary">Reset</a>
        <?php endif; ?>
    </form>
    <button onclick="window.print()" class="btn btn-success">Print</button>
</div>

<!-- Form Tambah/Edit -->
<div class="mb-3">
    <form method="post" class="d-flex gap-2 flex-wrap">
        <input type="hidden" name="<?= $edit_data ? 'edit' : 'tambah' ?>" value="1">
        <?php if ($edit_data): ?>
            <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
        <?php endif; ?>
        <input type="text" name="nama_barang" class="form-control" placeholder="Nama Barang" required value="<?= $edit_data ? htmlspecialchars($edit_data['nama_barang']) : '' ?>">
        <select name="kategori_id" class="form-control" required>
            <option value="">Pilih Kategori</option>
            <?php foreach ($kategori_list as $kat): ?>
                <option value="<?= $kat['id'] ?>" <?= $edit_data && $edit_data['kategori_id'] == $kat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($kat['nama_kategori']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="quantity" class="form-control" placeholder="Jumlah" min="0" required value="<?= $edit_data ? (int)$edit_data['quantity'] : '' ?>">
        <button type="submit" class="btn btn-primary"><?= $edit_data ? 'Update' : 'Tambah' ?></button>
        <?php if ($edit_data): ?>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        <?php endif; ?>
    </form>
</div>

<!-- Content Start -->
<section class="">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_barang']); ?></td>
                            <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                            <td><?= (int)$row['quantity']; ?></td>
                            <td>
                                <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form method="post" action="" style="display:inline;" onsubmit="return confirm('Yakin hapus barang ini?');">
                                    <input type="hidden" name="hapus" value="1">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data barang.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<!-- Content End -->

<?php
$content = ob_get_clean();
include '../layout.php';
