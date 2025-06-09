<?php
require_once '../../controller/data-kategori.php';
$title = 'Data Kategori Barang';
$css_path = '../../public/css/layout.css';
ob_start();
?>

<!-- Form Search & Print -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <form method="get" class="d-flex gap-2 w-50">
        <input type="text" name="search" class="form-control" placeholder="Cari kategori..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-info">Cari</button>
        <?php if ($search): ?>
            <a href="index.php" class="btn btn-secondary">Reset</a>
        <?php endif; ?>
    </form>
    <a href="print.php" target="_blank" class="btn btn-success">Print</a>
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
                    <th>Jumlah Jenis Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($data_kategori && mysqli_num_rows($data_kategori) > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($data_kategori)): ?>
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
                                <a href="../data-barang?search=<?= $row['nama_kategori'] ?>" class="btn btn-sm btn-info">Lihat Barang</a>
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

<!-- Content End -->

<?php
$content = ob_get_clean();
include '../layout.php';
