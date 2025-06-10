<?php
require_once '../../controller/dashboard.php';
require_once '../../utils/func.php';
$dashboard_data = getDashboardData();
$title = "Dashboard";
$css_path = "../../public/css/layout.css";
ob_start();
?>

<!-- Content Start -->
 <section class="">
    <p class="fs-5 mb-3">Selamat datang pengguna baik dan bijaksana 😁😁</p>
    <p>📦 Data terbaru hari ini</p>

    <!-- Cards -->
     <div class="row mb-2">
        <div class="col-md-6 col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total Barang</h5>
                    <p class="card-text display-6">
                        <?php echo isset($dashboard_data['total_barang']) ? $dashboard_data['total_barang'] : 0; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total Kategori Barang</h5>
                    <p class="card-text display-6">
                        <?php echo isset($dashboard_data['total_kategori']) ? $dashboard_data['total_kategori'] : 0; ?>
                    </p>
                </div>
            </div>
        </div>
     </div>

     <!-- Tables -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Aktivitas Barang Terkini</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Barang</th>
                            <th>Kategori</th>
                            <th>Aksi Barang</th>
                            <th>Waktu</th>
                            <th>Qty</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($dashboard_data['aktivitas_barang'])): ?>
                            <?php foreach ($dashboard_data['aktivitas_barang'] as $i => $row): ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_kategori']); ?></td>
                                    <td><?php echo htmlspecialchars($row['aksi']); ?></td>
                                    <td><?php echo htmlspecialchars(humanDateFriendly($row['waktu'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                    <td><?php echo htmlspecialchars($row['keterangan'] ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada aktivitas barang.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 </section>
<!-- Content End -->

<?php
$content = ob_get_clean();
include '../layout.php';