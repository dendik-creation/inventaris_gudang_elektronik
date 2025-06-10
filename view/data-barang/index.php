<?php
require_once __DIR__ . '/../../controller/data-barang.php';
$title = 'Data Barang';
$css_path = '../../public/css/layout.css';
ob_start();
?>

<!-- Form Search, Barang keluar masuk, print -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <form method="get" class="d-flex gap-2 w-50">
        <input type="text" required name="search" class="form-control w-100" placeholder="Cari barang/kategori..."
            value="<?= htmlspecialchars($search ?? '') ?>">
        <button type="submit" class="btn btn-info">Cari</button>
        <?php if (!empty($search)): ?>
        <a href="index.php" class="btn btn-secondary">Reset</a>
        <?php endif; ?>
    </form>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#barangModal">Barang
            Keluar & Masuk</button>
        <a target="_blank" href="print.php" class="btn btn-success">Print</a>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="barangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="barangModalLabel">Barang Keluar & Masuk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="row">
                    <input type="hidden" name="barang-keluar-masuk" value="1">
                    <div class="row">
                        <div class="col-md-6 col-12 p-2">
                            <select name="barang_id" id="barang_id" class="form-control" required>
                                <option value="" selected>Pilih Barang</option>
                                <?php if (!empty($barang_list) && mysqli_num_rows($barang_list) > 0): ?>
                                <?php mysqli_data_seek($barang_list, 0); ?>
                                <?php while ($row = mysqli_fetch_assoc($barang_list)): ?>
                                <option value="<?= htmlspecialchars($row['id']) ?>">
                                    <?= htmlspecialchars($row['nama_barang']) ?>
                                </option>
                                <?php endwhile; ?>
                                <?php mysqli_data_seek($barang_list, 0); ?>
                                <?php endif; ?>
                            </select>
                        </div>
    
                        <div class="col-md-6 col-12 p-2">
                            <select name="aksi" class="form-control" required>
                                <option value="">Pilih Aksi</option>
                                <option value="MASUK">Barang Masuk</option>
                                <option value="KELUAR">Barang Keluar</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-12 p-2">
                            <input type="number" name="quantity" class="form-control" placeholder="Jumlah" min="0"
                                required value="">
                        </div>
    
                        <div class="col-md-6 col-12 p-2">
                            <textarea name="keterangan" id="keterangan" placeholder="Keterangan tambahan (opsional)" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit"
                            class="btn btn-warning w-100">Tambah barang</button>
                    </div>
                    <?php if (!empty($edit_data)): ?>
                    <div class="col-6 mt-2">
                        <a href="index.php" class="btn w-100 btn-secondary">Batal</a>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Form Tambah/Edit -->
<div class="mb-3">
    <form method="post" class="row">
        <?php if (!empty($edit_data)): ?>
        <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
        <?php endif; ?>
        <input type="hidden" name="<?= !empty($edit_data) ? 'edit' : 'tambah' ?>" value="1">
        <div class="col-md-4 col-12">
            <input type="text" name="nama_barang" class="form-control" placeholder="Nama Barang" required
                value="<?= !empty($edit_data) ? htmlspecialchars($edit_data['nama_barang']) : '' ?>">
        </div>
        <div class="col-md-4 col-12">
            <select name="kategori_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                <?php foreach ($kategori_list as $kat): ?>
                <option value="<?= $kat['id'] ?>"
                    <?= !empty($edit_data) && $edit_data['kategori_id'] == $kat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($kat['nama_kategori']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4 col-12">
            <input type="number" name="quantity" class="form-control" placeholder="Jumlah" min="0"
                value="<?= !empty($edit_data) ? (int) $edit_data['quantity'] : '' ?>" <?= !empty($edit_data) ? 'disabled' : '' ?>>
        </div>
        <div class="<?= !empty($edit_data) ? 'col-6' : 'col-12' ?> mt-2">
            <button type="submit"
                class="btn btn-primary w-100"><?= !empty($edit_data) ? 'Update Barang' : 'Tambah Barang Baru' ?></button>
        </div>
        <?php if (!empty($edit_data)): ?>
        <div class="col-6 mt-2">
            <a href="index.php" class="btn w-100 btn-secondary">Batal</a>
        </div>
        <?php endif; ?>
    </form>
</div>

<!-- Content Start -->
<section>
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
                <?php if (!empty($barang_list) && mysqli_num_rows($barang_list) > 0): ?>
                <?php $no = 1;
                mysqli_data_seek($barang_list, 0); ?>
                <?php while ($row = mysqli_fetch_assoc($barang_list)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                    <td><?= (int) $row['quantity'] ?></td>
                    <td>
                        <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form method="post" action="" style="display:inline;"
                            onsubmit="return confirm('Yakin hapus barang ini?');">
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
