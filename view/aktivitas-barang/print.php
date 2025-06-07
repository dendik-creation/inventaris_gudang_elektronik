<?php
require_once __DIR__ . '/../../controller/aktivitas-barang.php';
require_once '../../utils/func.php';
$title = 'Log Aktivitas Barang';
ob_start();
?>
<h2 class="my-4"><?= htmlspecialchars($title) ?></h2>
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
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                <td><?= (int) $row['quantity'] ?></td>
                <td><?= htmlspecialchars($row['aksi']) ?></td>
                <td><?= htmlspecialchars(humanDateFriendly($row['waktu'])) ?></td>
                <td><?= htmlspecialchars($row['keterangan']) ?></td>
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


<script>
    window.print();
    window.onafterprint = function() {
        window.close();
    };
</script>

<?php
$content = ob_get_clean();
include '../print_layout.php';
