<?php
require_once __DIR__ . '/../../controller/data-barang.php';
$title = 'Daftar Data Barang';
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
            </tr>
        </thead>
        <tbody>
            <?php if ($barang_list && mysqli_num_rows($barang_list) > 0): ?>
            <?php $no = 1; ?>
            <?php while ($row = mysqli_fetch_assoc($barang_list)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                <td><?= (int) $row['quantity'] ?></td>
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

<script>
    window.print();
    window.onafterprint = function() {
        window.close();
    };
</script>

<?php
$content = ob_get_clean();
include '../print_layout.php';
