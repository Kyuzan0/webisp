<?php
// teruskan_keluhan.php - Memproses form penerusan keluhan ke teknisi
require '../includes/functions.php';

// Cek jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_keluhan = $_POST["id_keluhan"];
    $id_teknisi = $_POST["id_teknisi"];
    $waktu_penugasan = $_POST["waktu_penugasan"];
    $deskripsi = $_POST["deskripsi"];
    
    // Simpan data ke tabel perbaikan
    $query = "INSERT INTO perbaikan (id_keluhan, id_teknisi, waktu_penugasan, deskripsi) 
              VALUES ('$id_keluhan', '$id_teknisi', '$waktu_penugasan', '$deskripsi')";
    
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        // Update status keluhan menjadi "Proses"
        $update_status = "UPDATE keluhan SET status = 'Proses' WHERE id_keluhan = '$id_keluhan'";
        mysqli_query($conn, $update_status);
        
        // Set alert success
        setFlash('success', 'Keluhan berhasil diteruskan ke teknisi');
    } else {
        // Set alert error
        setFlash('error', 'Gagal meneruskan keluhan: ' . mysqli_error($conn));
    }
    
    // Redirect kembali ke halaman daftar keluhan
    header("Location: daftarkeluhan.php");
    exit;
} else {
    // Jika bukan method POST, redirect ke halaman daftar keluhan
    header("Location: daftarkeluhan.php");
    exit;
}
?>