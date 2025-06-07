<?php
require_once '../../config/koneksi.php';
$title = 'Aktivitas Barang (Log)';
$css_path = '../../public/css/layout.css';
ob_start();

// Query join aktivitas_barang, barang, dan kategori
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
        ORDER BY ab.waktu DESC";
$result = mysqli_query($koneksi, $sql);
?>

<!-- Fitur Print -->
<div class="d-flex justify-content-end mb-3">
    <button onclick="window.print()" class="btn btn-success">Print</button>
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
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_barang']); ?></td>
                            <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                            <td><?= (int)$row['quantity']; ?></td>
                            <td><?= htmlspecialchars($row['aksi']); ?></td>
                            <td><?= htmlspecialchars($row['waktu']); ?></td>
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
