<?php
session_start();
$level = isset($_SESSION['level']) ? $_SESSION['level'] : 'tamu';

$dashboard = "#";
switch ($level) {
    case 'Owner':
        $dashboard = "LaporanStok.php";
        break;
    case 'Admin':
        $dashboard = "Index.php";
        break;
    case 'gudang':
        $dashboard = "DashboardStaffGudang.php";
        $dashboard = "BarangMasukStaffGudang.php";
        $dashboard = "BarangKeluarStaffGudang.php";
        break;
    default:
        $dashboard = "FormLogin.php";
        break;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Akses Ditolak</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5 text-center">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="text-danger">Akses Ditolak</h1>
            <p class="lead">Halo <strong><?= htmlspecialchars($level); ?></strong>, Anda tidak memiliki hak akses ke halaman ini.</p>
            <p>Silakan kembali ke halaman dashboard Anda atau hubungi administrator sistem.</p>
            <a href="<?= $dashboard = "FormLogin.php"; ?>" class="btn btn-primary">Kembali ke Dashboard</a>
        </div>
    </div>
</div>

</body>
</html>