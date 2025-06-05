<?php
require __DIR__ . '../config/env.php';
$host = $_ENV['DB_HOST'] ?? 'localhost';
$db_name = $_ENV['DB_NAME'] ?? '';
$db_user = $_ENV['DB_USER'] ?? '';
$db_pass = $_ENV['DB_PASS'] ?? '';
$db_port = $_ENV['DB_PORT'] ?? '3306';

$koneksi = mysqli_connect($host, $db_user, $db_pass, $db_name, $db_port);

if (!$koneksi) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>
