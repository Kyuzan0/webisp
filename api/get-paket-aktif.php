<?php
require('../includes/init_session.php');
require('../includes/functions.php');

header('Content-Type: application/json');

if (!isset($_SESSION['id_user']) || $_SESSION['level'] !== 'Customer') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

try {
    // Get customer data with their current package
    $query = "SELECT * FROM customer c JOIN produk p ON c.id_produk = p.id_produk WHERE c.id_user = '".$_SESSION['id_user']."'";
    
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    
    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan']);
        exit;
    }
    
    // Format response data
    $response = [
        'success' => true,
        'customer' => [
            'id_customer' => $data['id_customer'],
            'nama' => $data['nama'],
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
            'alamat' => $data['alamat'],
            'status' => $data['status']
        ],
        'paket' => [
            'id_produk' => $data['id_produk'],
            'nama_produk' => $data['nama_produk'],
            'deskripsi' => $data['deskripsi'], // menggunakan nama yang sama dengan database
            'harga' => $data['harga']
        ]
    ];
    
    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>