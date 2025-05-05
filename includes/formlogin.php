<?php
session_start();
if (isset($_SESSION['login'])) {
    switch ($_SESSION['level']) {
        case 'Owner':
            header("Location: ../public/index.php");
            break;
        case 'Admin':
            header("Location: ../public/index.php");
            break;
        case 'gudang':
            header("Location: DashboardStaffGudang.php");
            break;
        default:
            header("Location: ../public/index.php");
    }
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - PT Sinar Komunikasi Nusantara</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-info text-white text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']); ?></div>
                        <?php endif; ?>
                        <form action="ProsesLogin.php" method="post">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" required autofocus>
                            </div>
                            <div class="form-group">
                                <label>Kata Sandi</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-info btn-block">Login</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <small>PT Sinar Komunikasi Nusantara</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>