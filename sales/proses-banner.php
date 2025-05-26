<?php
require '../includes/init_session.php';
require '../includes/functions.php';

// Pastikan user adalah sales marketing
if ($_SESSION['level'] != 'Sales Marketing') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Ambil data form
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    
    // Ambil ID sales marketing dari session
    $query_sales = "SELECT id_salesmarketing FROM salesmarketing WHERE id_user = '{$_SESSION['id_user']}'";
    $result_sales = mysqli_query($conn, $query_sales);
    $sales_data = mysqli_fetch_assoc($result_sales);
    $id_salesmarketing = $sales_data['id_salesmarketing'];
    
    // Validasi file upload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        
        $file = $_FILES['gambar'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];
        
        // Validasi tipe file
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowedTypes)) {
            echo "<script>
                alert('Tipe file tidak valid! Hanya JPG, PNG, GIF yang diperbolehkan.');
                history.back();
            </script>";
            exit();
        }
        
        // Validasi ukuran file (2MB = 2097152 bytes)
        if ($fileSize > 2097152) {
            echo "<script>
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                history.back();
            </script>";
            exit();
        }
        
        // Buat nama file unik
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = 'banner_' . time() . '_' . rand(1000, 9999) . '.' . $fileExtension;
        
        // Folder upload
        $uploadDir = '../uploads/banners/';
        
        // Buat folder jika belum ada
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $uploadPath = $uploadDir . $newFileName;
        $relativePath = '../uploads/banners/' . $newFileName;
        
        // Upload file
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            
            // Insert ke database
            $query = "INSERT INTO banner_promo (id_salesmarketing, judul, deskripsi, gambar_path, tanggal_mulai, tanggal_selesai, status) 
                     VALUES ('$id_salesmarketing', '$judul', '$deskripsi', '$relativePath', '$tanggal_mulai', '$tanggal_selesai', 'aktif')";
            
            if (mysqli_query($conn, $query)) {
                echo "<script>
                    alert('Banner berhasil ditambahkan!');
                    window.location.href = 'list_banner.php';
                </script>";
            } else {
                // Hapus file jika gagal insert database
                unlink($uploadPath);
                echo "<script>
                    alert('Error: " . mysqli_error($conn) . "');
                    history.back();
                </script>";
            }
            
        } else {
            echo "<script>
                alert('Gagal mengupload file!');
                history.back();
            </script>";
        }
        
    } else {
        echo "<script>
            alert('File gambar wajib diupload!');
            history.back();
        </script>";
    }
    
} else {
    header("Location: tambah_banner.php");
    exit();
}
?>