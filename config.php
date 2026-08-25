<?php
// Konfigurasi database InfinityFree
// Isi sesuai MySQL Databases di panel hosting.
$db_host = 'localhost';
$db_name = 'NAMA_DATABASE';
$db_user = 'NAMA_USER_DATABASE';
$db_pass = 'PASSWORD_DATABASE';

try {
    $pdo = new PDO(
        "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    die("Koneksi database gagal. Periksa config.php.");
}
