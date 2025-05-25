<?php
// File: api/submit-request-paket.php
require('../includes/init_session.php');
require('../includes/functions.php');

header('Content-Type: application/json');

if (!isset($_SESSION['id_user']) || $_SESSION['level'] !== 'Customer') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Get customer data
    $query = "SELECT id_customer, id_produk FROM customer WHERE id_user = '".$_SESSION['id_user']."'";
    $result = mysqli_query($conn, $query);
    $customer = mysqli_fetch_assoc($result);
    
    if (!$customer) {
        echo json_encode(['success' => false, 'message' => 'Customer tidak ditemukan']);
        exit;
    }
    
    $id_produk_baru = $_POST['id_produk_baru'];
    $jenis_request = $_POST['jenis_request'];
    $alasan_request = $_POST['alasan_request'];
    
    // Validasi input
    if (empty($id_produk_baru) || empty($jenis_request) || empty($alasan_request)) {
        echo json_encode(['success' => false, 'message' => 'Semua field harus diisi']);
        exit;
    }
    
    // Check if same package
    if ($customer['id_produk'] == $id_produk_baru) {
        echo json_encode(['success' => false, 'message' => 'Paket yang dipilih sama dengan paket saat ini']);
        exit;
    }
    
    // Check if there's pending request
    $query = "SELECT COUNT(*) as count FROM request_perubahan_paket WHERE id_customer = '".$customer['id_customer']."' AND status_request = 'pending'";
    $result = mysqli_query($conn, $query);
    $pendingCount = mysqli_fetch_assoc($result)['count'];
    
    if ($pendingCount > 0) {
        echo json_encode(['success' => false, 'message' => 'Anda masih memiliki request yang pending']);
        exit;
    }
    
    // Insert new request
    $query = "INSERT INTO request_perubahan_paket 
              (id_customer, id_produk_lama, id_produk_baru, jenis_request, alasan_request) 
              VALUES (
                  '".$customer['id_customer']."',
                  '".$customer['id_produk']."',
                  '".$id_produk_baru."',
                  '".$jenis_request."',
                  '".$alasan_request."'
              )";
    
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Request berhasil dikirim']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal mengirim request']);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>