<?php
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = [
    'product_id' => $_POST['product_id'],
    'quantity' => $_POST['quantity'],
    'varian' => $_POST['varian'],
    'ukuran' => $_POST['ukuran']
  ];

  try {
    $stmt = $database_connection->prepare("
      INSERT INTO keranjang 
        (product_id, quantity, varian, ukuran)
      VALUES 
        (:product_id, :quantity, :varian, :ukuran)
    ");
    
    $stmt->execute($data);
    
    header('Location: ../frontend/keranjang.php');
    exit;
    
  } catch (PDOException $e) {
    die("Error: " . $e->getMessage());
  }
}