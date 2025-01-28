<?php
$database_hostname= "localhost";
$database_user= "novx1544_ega1";
$database_password="UTB_2024#";
$database_name="novx1544_ega1";


try {
    $database_connection = new PDO("mysql:host=$database_hostname;dbname=$database_name", $database_user, $database_password);
    echo "Koneksi Berhasil!";
} catch (PDOException $cek_koneksi) {
    die($cek_koneksi->getMessage());
}
?>
