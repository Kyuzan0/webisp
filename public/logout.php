<?php
// Mulai sesi jika belum dimulai
session_start();

// Hapus semua data sesi
$_SESSION = array();

// Hapus cookie sesi jika ada
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Hancurkan sesi
session_destroy();

// Pastikan semua buffer output dibersihkan
while (ob_get_level()) {
    ob_end_clean();
}

// Redirect ke halaman login dengan mencegah caching
header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
header('Pragma: no-cache');
header('Location: /webisp/index.php');
exit();
?>