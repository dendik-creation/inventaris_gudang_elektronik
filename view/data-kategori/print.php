<?php
require_once __DIR__ . '/../../controller/data-kategori.php';
$title = 'Daftar Data Kategori Barang';
ob_start();
?>
<h2 class="my-4"><?= htmlspecialchars($title) ?></h2>
<div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Jumlah Barang</th>
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

<script>
    window.print();
    window.onafterprint = function() {
        window.close();
    };
</script>

<?php
$content = ob_get_clean();
include '../print_layout.php';
