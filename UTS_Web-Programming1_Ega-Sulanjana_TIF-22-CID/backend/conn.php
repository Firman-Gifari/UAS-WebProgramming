<?php
$database_hostname= "localhost";
$database_user= "root";
$database_password="";
$database_name="uas_wp1";


try {
    $database_connection = new PDO("mysql:host=$database_hostname;dbname=$database_name", $database_user, $database_password);
    // echo "Koneksi Berhasil!";
} catch (PDOException $cek_koneksi) {
    die($cek_koneksi->getMessage());
}
?>
