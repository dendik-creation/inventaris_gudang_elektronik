<?php
require_once __DIR__ . "/../../controller/aktivitas-barang.php";
require_once '../../utils/func.php';
$title = 'Aktivitas Barang (Log)';
$css_path = '../../public/css/layout.css';
ob_start();
?>

<!-- Form Search & Print -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <form method="get" class="d-flex gap-2 w-50">
        <input type="text" required name="search" class="form-control w-100" placeholder="Cari barang/kategori/aksi" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-info">Cari</button>
        <?php if ($search): ?>
            <a href="index.php" class="btn btn-secondary">Reset</a>
        <?php endif; ?>
    </form>
    <a target="_blank" href="print.php<?= $search ? '?search=' . urlencode($search) : '' ?>" class="btn btn-success">Print</a>
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
                    <th>Waktu</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($aktivitas_barang && mysqli_num_rows($aktivitas_barang) > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($aktivitas_barang)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_barang']); ?></td>
                            <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                            <td><?= (int)$row['quantity']; ?></td>
                            <td><?= htmlspecialchars($row['aksi']); ?></td>
                            <td><?= htmlspecialchars(humanDateFriendly($row['waktu'])); ?></td>
                            <td><?= htmlspecialchars($row['keterangan']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Belum ada aktivitas barang.</td>
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
