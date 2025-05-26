<?php
require '../includes/functions.php';
require '../includes/init_session.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id_user']) || $_SESSION['level'] !== 'Customer') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

try {
    // Get customer's current package
    $query = "SELECT p.id_produk, p.harga FROM customer c 
              JOIN produk p ON c.id_produk = p.id_produk 
              WHERE c.id_user = '".$_SESSION['id_user']."'";
    $result = mysqli_query($conn, $query);
    $currentPackage = mysqli_fetch_assoc($result);
    
    if (!$currentPackage) {
        echo json_encode(['success' => false, 'message' => 'Paket aktif tidak ditemukan']);
        exit;
    }
    
    $currentPrice = (int)$currentPackage['harga'];
    $currentId = $currentPackage['id_produk'];
    
    // Get jenis_request parameter
    $jenisRequest = isset($_GET['jenis_request']) ? $_GET['jenis_request'] : '';
    
    if ($jenisRequest == 'upgrade') {
        // Show packages with higher price
        $query = "SELECT id_produk, nama_produk, deskripsi, harga FROM produk 
                  WHERE harga > $currentPrice AND id_produk != '$currentId'";
    } elseif ($jenisRequest == 'downgrade') {
        // Show packages with lower price
        $query = "SELECT id_produk, nama_produk, deskripsi, harga FROM produk 
                  WHERE harga < $currentPrice AND id_produk != '$currentId'";
    } else {
        // Show all packages except current one
        $query = "SELECT id_produk, nama_produk, deskripsi, harga FROM produk 
                  WHERE id_produk != '$currentId'";
    }
    
    $result = mysqli_query($conn, $query);
    $results = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $row['harga'] = (int)$row['harga'];
        // Extract Mbps value for sorting
        preg_match('/(\d+)\s*Mbps/i', $row['nama_produk'], $matches);
        $row['mbps_value'] = isset($matches[1]) ? (int)$matches[1] : 0;
        $results[] = $row;
    }
    
    // Sort by Mbps value (lowest to highest)
    usort($results, function($a, $b) {
        return $a['mbps_value'] - $b['mbps_value'];
    });
    
    // Remove mbps_value from final result
    foreach ($results as &$row) {
        unset($row['mbps_value']);
    }
    
    echo json_encode(['success' => true, 'pakets' => $results]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>