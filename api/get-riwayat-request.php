<?php
// File: api/get-riwayat-request.php
require('../includes/init_session.php');
require('../includes/functions.php');

header('Content-Type: application/json');

if (!isset($_SESSION['id_user']) || $_SESSION['level'] !== 'Customer') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

try {
    // Get customer ID first
    $query = "SELECT id_customer FROM customer WHERE id_user = '".$_SESSION['id_user']."'";
    $result = mysqli_query($conn, $query);
    $customer = mysqli_fetch_assoc($result);
    
    if (!$customer) {
        echo json_encode(['success' => false, 'message' => 'Customer tidak ditemukan']);
        exit;
    }
    
    $query = " 
        SELECT rpp.*, 
               pl.nama_produk as paket_lama, 
               pb.nama_produk as paket_baru, 
               sm.nama as sales_name 
        FROM request_perubahan_paket rpp 
        JOIN produk pl ON rpp.id_produk_lama = pl.id_produk 
        JOIN produk pb ON rpp.id_produk_baru = pb.id_produk 
        LEFT JOIN salesmarketing sm ON rpp.id_salesmarketing = sm.id_salesmarketing 
        WHERE rpp.id_customer = '".$customer['id_customer']."' 
        ORDER BY rpp.tanggal_request DESC 
    ";
    
    $result = mysqli_query($conn, $query);
    $requests = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $requests[] = $row;
    }
    
    echo json_encode(['success' => true, 'requests' => $requests]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>