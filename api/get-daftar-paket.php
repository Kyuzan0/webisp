<?php
require '../includes/functions.php';
require '../includes/init_session.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id_user']) || $_SESSION['level'] !== 'Customer') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

try {
    $query = "SELECT id_produk, nama_produk, deskripsi, harga FROM produk ORDER BY harga ASC";
    $result = mysqli_query($conn, $query);
    $results = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $row['harga'] = (int)$row['harga'];
        $results[] = $row;
    }
    
    echo json_encode(['success' => true, 'pakets' => $results]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}