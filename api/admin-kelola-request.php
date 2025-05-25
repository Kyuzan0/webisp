<?php
// File: api/admin-kelola-request.php - untuk Sales Marketing mengelola request
require('../includes/init_session.php');
require('../includes/functions.php');

header('Content-Type: application/json');

if (!isset($_SESSION['id_user']) || $_SESSION['level'] !== 'Sales Marketing') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get all pending requests
    try {
        $query = "SELECT rpp.*, 
                   c.nama as customer_name, c.no_hp, c.email, 
                   pl.nama_produk as paket_lama, pl.harga as harga_lama, 
                   pb.nama_produk as paket_baru, pb.harga as harga_baru,
                   sm.nama as sales_name
            FROM request_perubahan_paket rpp 
            JOIN customer c ON rpp.id_customer = c.id_customer 
            JOIN produk pl ON rpp.id_produk_lama = pl.id_produk 
            JOIN produk pb ON rpp.id_produk_baru = pb.id_produk
            LEFT JOIN salesmarketing sm ON rpp.id_salesmarketing = sm.id_salesmarketing
            ORDER BY FIELD(rpp.status_request, 'pending', 'disetujui', 'ditolak'), rpp.tanggal_request DESC";
        
        $result = mysqli_query($conn, $query);
        $requests = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $requests[] = $row;
        }
        
        echo json_encode(['success' => true, 'requests' => $requests]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process request approval/rejection
    try {
        $id_request = $_POST['id_request'];
        $action = $_POST['action']; // 'approve' or 'reject'
        $catatan = $_POST['catatan'] ?? '';
        
        // Get sales marketing ID
        $query = "SELECT id_salesmarketing FROM salesmarketing WHERE id_user = '".$_SESSION['id_user']."'";
        $result = mysqli_query($conn, $query);
        $salesmarketing = mysqli_fetch_assoc($result);
        
        if (!$salesmarketing) {
            echo json_encode(['success' => false, 'message' => 'Sales Marketing tidak ditemukan']);
            exit;
        }
        
        mysqli_begin_transaction($conn);
        
        if ($action === 'approve') {
            // Update request status
            $query = "
                UPDATE request_perubahan_paket 
                SET status_request = 'disetujui', 
                    id_salesmarketing = '".$salesmarketing['id_salesmarketing']."', 
                    catatan_admin = '".$catatan."', 
                    tanggal_diproses = NOW() 
                WHERE id_request = '".$id_request."'
            ";
            mysqli_query($conn, $query);
            
            // Get request details
            $query = "SELECT * FROM request_perubahan_paket WHERE id_request = '".$id_request."'";
            $result = mysqli_query($conn, $query);
            $request = mysqli_fetch_assoc($result);
            
            // Update customer's package
            $query = "UPDATE customer SET id_produk = '".$request['id_produk_baru']."' WHERE id_customer = '".$request['id_customer']."'";
            mysqli_query($conn, $query);
            
            // Mark as completed
            $query = "
                UPDATE request_perubahan_paket 
                SET status_request = 'disetujui', tanggal_selesai = NOW() 
                WHERE id_request = '".$id_request."'
            ";
            mysqli_query($conn, $query);
            
        } else {
            // Reject request
            $query = "
                UPDATE request_perubahan_paket 
                SET status_request = 'ditolak', 
                    id_salesmarketing = '".$salesmarketing['id_salesmarketing']."', 
                    catatan_admin = '".$catatan."', 
                    tanggal_diproses = NOW() 
                WHERE id_request = '".$id_request."'
            ";
            mysqli_query($conn, $query);
        }
        
        mysqli_commit($conn);
        echo json_encode(['success' => true, 'message' => 'Request berhasil diproses']);
        
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>