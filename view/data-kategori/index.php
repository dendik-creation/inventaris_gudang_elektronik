<?php
require_once '../../config/koneksi.php';
$title = 'Data Kategori Barang';
$css_path = '../../public/css/layout.css';
ob_start();


// Fitur search
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = '';
if ($search !== '') {
    $where = "WHERE k.nama_kategori LIKE '%" . mysqli_real_escape_string($koneksi, $search) . "%'";
}

$sql = "SELECT k.id, k.nama_kategori, COUNT(b.id) AS jumlah_barang
        FROM kategori k
        LEFT JOIN barang b ON b.kategori_id = k.id
        $where
        GROUP BY k.id, k.nama_kategori
        ORDER BY k.id ASC";
$result = mysqli_query($koneksi, $sql);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $nama_kategori = trim($_POST['nama_kategori']);
    if ($nama_kategori !== '') {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO kategori (nama_kategori) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $nama_kategori);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
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
?>

<!-- Form Search & Print -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <form method="get" class="d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Cari kategori..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-info">Cari</button>
        <?php if ($search): ?>
            <a href="index.php" class="btn btn-secondary">Reset</a>
        <?php endif; ?>
    </form>
    <button onclick="window.print()" class="btn btn-success">Print</button>
</div>

<!-- Form Tambah/Edit -->
<div class="mb-3">
    <form method="post" class="d-flex gap-2">
        <input type="hidden" name="<?= $edit_data ? 'edit' : 'tambah' ?>" value="1">
        <?php if ($edit_data): ?>
            <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
        <?php endif; ?>
        <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori" required value="<?= $edit_data ? htmlspecialchars($edit_data['nama_kategori']) : '' ?>">
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
                    <th>Kategori</th>
                    <th>Jumlah Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                            <td><?= (int)$row['jumlah_barang']; ?></td>
                            <td>
                                <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form method="post" action="" style="display:inline;" onsubmit="return confirm('Yakin hapus kategori ini?');">
                                    <input type="hidden" name="hapus" value="1">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                                <a href="?list_barang=<?= $row['id'] ?>" class="btn btn-sm btn-info">Lihat Barang</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data kategori.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<!-- Content End -->

<?php
// Fitur: List barang pada kategori tertentu
if (isset($_GET['list_barang'])):
    $kategori_id = (int)$_GET['list_barang'];
    $q = mysqli_query($koneksi, "SELECT nama_kategori FROM kategori WHERE id=$kategori_id");
    $kat = mysqli_fetch_assoc($q);
    $barang = [];
    $q_barang = mysqli_query($koneksi, "SELECT nama_barang, quantity FROM barang WHERE kategori_id=$kategori_id");
    while ($b = mysqli_fetch_assoc($q_barang)) {
        $barang[] = $b;
    }
?>
<div class="card mt-4">
    <div class="card-header">
        <strong>Daftar Barang pada Kategori: <?= htmlspecialchars($kat['nama_kategori'] ?? '-') ?></strong>
        <a href="index.php" class="btn btn-sm btn-secondary float-end">Tutup</a>
    </div>
    <div class="card-body">
        <?php if ($barang): ?>
            <ul>
                <?php foreach ($barang as $b): ?>
                    <li><?= htmlspecialchars($b['nama_barang']) ?> (Jumlah: <?= (int)$b['quantity'] ?>)</li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Tidak ada barang pada kategori ini.</p>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- Content End -->

<?php
$content = ob_get_clean();
include '../layout.php';
