<?php
$title = "Anggota Kelompok 8";
$css_path = "../../public/css/layout.css";
ob_start();
?>

<!-- Content Start -->
<section class="">
    <ul>
        <li>Dendi' Setiawan (202451181)</li>
        <li>Muhammad Bintang Adhipura (202451165)</li>
        <li>Naufal Rizqi Ilham Gibran (202451154)</li>
        <li>Ahmad Ilham Mujib (202451163)</li>
        <li>Aditya Wahyu Aji Pangestu (202451153)</li>
    </ul>
</section>
<!-- Content End -->

<?php
$content = ob_get_clean();
include '../layout.php';