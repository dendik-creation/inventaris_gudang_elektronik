<?php
require_once __DIR__ . "/../../controller/data-barang.php";
$title = 'Data Barang';
$css_path = '../../public/css/layout.css';
ob_start();
?>

<!-- Form Search & Print -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <form method="get" class="d-flex gap-2 w-50">
        <input type="text" required name="search" class="form-control w-100" placeholder="Cari barang/kategori..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-info">Cari</button>
        <?php if ($search): ?>
            <a href="index.php" class="btn btn-secondary">Reset</a>
        <?php endif; ?>
    </form>
    <a target="_blank" href="print.php" class="btn btn-success">Print</a>
</div>

<!-- Form Tambah/Edit -->
<div class="mb-3">
    <form method="post" class="row">
        <?php if ($edit_data): ?>
            <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
        <?php endif; ?>
        <input type="hidden" name="<?= $edit_data ? 'edit' : 'tambah' ?>" value="1">
        <div class="col-md-4 col-12">
            <input type="text" name="nama_barang" class="form-control" placeholder="Nama Barang" required value="<?= $edit_data ? htmlspecialchars($edit_data['nama_barang']) : '' ?>">
        </div>
        <div class="col-md-4 col-12">
            <select name="kategori_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                <?php foreach ($kategori_list as $kat): ?>
                    <option value="<?= $kat['id'] ?>" <?= $edit_data && $edit_data['kategori_id'] == $kat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($kat['nama_kategori']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4 col-12">
            <input type="number" name="quantity" class="form-control" placeholder="Jumlah" min="0" required value="<?= $edit_data ? (int)$edit_data['quantity'] : '' ?>">
        </div>
        <div class="<?= $edit_data ? 'col-6' : 'col-12' ?> mt-2">
            <button type="submit" class="btn btn-primary w-100"><?= $edit_data ? 'Update Barang' : 'Tambah Barang Baru' ?></button>
        </div>
        <div class="col-6 mt-2">
            <?php if ($edit_data): ?>
                <a href="index.php" class="btn w-100 btn-secondary">Batal</a>
            <?php endif; ?>
        </div>
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
                <?php if ($barang_list && mysqli_num_rows($barang_list) > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($barang_list)): ?>
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
