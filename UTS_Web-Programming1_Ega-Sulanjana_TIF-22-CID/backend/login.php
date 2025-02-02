<?php
header("Access-Control-Allow-Origin: *");
include 'conn.php';

// Ambil data dari input pengguna
$username = $_POST['user'] ?? '';
$password = $_POST['pwd'] ?? '';

// Cek jika username dan password diatur
if (!empty($username) && !empty($password)) {

    // Ambil data pengguna dari database berdasarkan username
    $statement = $database_connection->prepare("SELECT id, username, password FROM user WHERE username = ?");
    $statement->execute([$username]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Verifikasi kata sandi dengan SHA1
    if ($user && $user['password'] === sha1($password)) {
        
        // Buat token sesi baru
        $session_token = bin2hex(random_bytes(16));

        // Perbarui token sesi di database
        $updateStatement = $database_connection->prepare("UPDATE user SET session_token = ? WHERE id = ?");
        $updateStatement->execute([$session_token, $user['id']]);

        // Kembalikan respons JSON sukses dengan token sesi
        echo json_encode([
            'status' => 'success',
            'session_token' => $session_token
        ]);
    } else {
        // Respons jika verifikasi gagal
        echo json_encode([
            'status' => 'error',
            'message' => 'Kredensial tidak valid'
        ]);
    }
} else {
    // Respons jika input kosong
    echo json_encode([
        'status' => 'error',
        'message' => 'Username dan atau password salah.'
    ]);
}
?>