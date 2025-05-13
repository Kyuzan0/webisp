<?php
// init_session.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Hanya akan dijalankan jika session belum dimulai
}
?>