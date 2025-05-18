<?php
session_start();
// Hancurkan sesi
session_unset();
session_destroy();
// Redirect ke halaman login setelah logout
header("Location: /webisp/includes/formlogin.php");
exit();
?>