<?php
session_start();

// Pastikan id_user ada di dalam session
if (isset($_SESSION['id_user'])) {
    // Ambil id_user dari session
    $id_user = $_SESSION['id_user'];

    // Debugging: Cek ID Pengguna di sesi
    echo "ID Pengguna di Sesi: " . $id_user . "<br>";

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "dbisp");

    // Cek koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query untuk menampilkan keluhan berdasarkan id_user
    $sql = "SELECT id_keluhan, id_user, id_kepalateknisi, judul_keluhan, deskripsi, tanggal_keluhan, status
            FROM keluhan 
            WHERE id_user = ?";  // Menampilkan keluhan hanya berdasarkan id_user

    // Debugging: Tampilkan query yang dijalankan
    echo "Query SQL yang Dijalankan: " . $sql . "<br>";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user); // Mengikat hanya id_user sebagai parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Mengecek apakah ada keluhan yang ditemukan
    if ($result->num_rows > 0) {
        // Menampilkan data keluhan
        while ($row = $result->fetch_assoc()) {
            echo "ID Keluhan: " . $row['id_keluhan'] . "<br>";
            echo "Judul: " . $row['judul_keluhan'] . "<br>";
            echo "Deskripsi: " . $row['deskripsi'] . "<br>";
            echo "Tanggal: " . $row['tanggal_keluhan'] . "<br>";
            echo "Status: " . $row['status'] . "<br><br>";
        }
    } else {
        echo "Tidak ada keluhan yang ditemukan.";
    }

    // Menutup koneksi
    $conn->close();
} else {
    // Jika id_user tidak ada di sesi, pengguna harus login terlebih dahulu
    echo "Anda harus login terlebih dahulu.";
}
?>
