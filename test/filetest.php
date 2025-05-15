<?php
// Memulai session
include '../includes/init_session.php';
include '../includes/functions.php';

// Memastikan bahwa data login sudah ada dalam session
if(isset($_SESSION['username']) && isset($_SESSION['level']) && isset($_SESSION['id_user'])) {
    // Menampilkan data dari session
    $username = $_SESSION['username'];
    $level = $_SESSION['level'];
    $id_user = $_SESSION['id_user'];

    echo "<h1>Data Login</h1>";
    echo "<p>Username: $username</p>";
    echo "<p>Level: $level</p>";
    echo "<p>ID User: $id_user</p>";
} else {
    echo "<p>Anda belum login.</p>";
}
?>
