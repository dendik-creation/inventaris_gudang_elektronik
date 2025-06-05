<?php
$envFile = __DIR__ . '/../.env';
if (!file_exists($envFile)) {
    die(".env file tidak ditemukan.\n");
}
$lines = file($envFile);
foreach ($lines as $line) {
    if (!trim($line) || str_starts_with(trim($line), '#')) continue;
    list($k, $v) = explode('=', trim($line), 2);
    $_ENV[trim($k)] = trim($v);
}