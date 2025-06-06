<?php
$title = 'Data Ketegori Barang';
$css_path = '../../public/css/layout.css';
ob_start();
?>

<!-- Content Start -->
<section class="">
    <h1 class="text-center">Data Kategori Barang</h1>
</section>
<!-- Content End -->

<?php
$content = ob_get_clean();
include '../layout.php';
