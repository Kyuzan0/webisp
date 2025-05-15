<?php
require 'functions.php';
require 'init_session.php';

if (isset($_SESSION['username'])) {
    header("Location: ../public/index.php");
    exit();
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Jangan hash password di sini

    // Query SQL untuk memeriksa email pengguna dengan prepared statements
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password yang di-hash
        if (password_verify($password, $row['password'])) {
            // Menyimpan data login ke session
            $_SESSION['id_user'] = $row['id_user']; // Menyimpan id_user ke session
            $_SESSION['username'] = $row['username'];
            $_SESSION['level'] = $row['level'];  // Menyimpan level ke dalam session

            // Redirect ke halaman sesuai dengan level pengguna
            switch ($_SESSION['level']) {
                case 'Admin':
                    header("Location: ../public/index.php");
                    break;
                case 'Supervisor':
                    header("Location: ../supervisor/dashboard.php");
                    break;
                case 'Kepala Teknisi':
                    header("Location: ../kepalateknisi/dashboard.php");
                    break;
                case 'Teknisi':
                    header("Location: ../teknisi/dashboard.php");
                    break;
                case 'Sales Marketing':
                    header("Location: ../sales/dashboard.php");
                    break;
                case 'Customer':
                    header("Location: ../pelanggan/dashboard.php");
                    break;
                default:
                    echo "<script>alert('Level tidak dikenali!')</script>";
                    break;
            }
            exit();
        } else {
            $error = "Email atau password Anda salah. Silakan coba lagi!";
        }
    } else {
        $error = "Email atau password Anda salah. Silakan coba lagi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>WebISP | Form Login</title>
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #224abe;
            --success-color: #1cc88a;
            --background-color: #f8f9fc;
            --text-color: #5a5c69;
            --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            width: 100%;
            min-height: 100vh;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            width: 400px;
            max-width: 100%;
            background-color: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: var(--box-shadow);
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h2 {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .login-header p {
            color: var(--text-color);
            font-size: 0.9rem;
        }
        
        .login-form .input-group {
            position: relative;
            margin-bottom: 25px;
        }
        
        .input-group input {
            width: 100%;
            height: 50px;
            padding: 15px 20px;
            padding-left: 45px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            outline: none;
            font-size: 1rem;
            color: #333;
            transition: all 0.3s ease;
        }
        
        .input-group input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.2);
        }
        
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 18px;
        }
        
        .input-group input:focus + i {
            color: var(--primary-color);
        }
        
        .error-message {
            background-color: #ffe5e5;
            color: #d63031;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }
        
        .error-message i {
            margin-right: 10px;
            font-size: 16px;
        }
        
        .login-btn {
            width: 100%;
            height: 50px;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .login-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            color: var(--text-color);
            font-size: 0.9rem;
        }
        
        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .register-link a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 30px 0;
        }
        
        .divider::before, .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background-color: #e0e0e0;
        }
        
        .divider span {
            padding: 0 15px;
            color: #aaa;
            font-size: 0.8rem;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo img {
            height: 60px;
            width: auto;
        }
        
        /* Responsif untuk layar kecil */
        @media screen and (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }
            
            .login-header h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-header">
            <div class="logo">
                <!-- Ganti dengan logo WebISP Anda -->
                <i class="fas fa-wifi" style="font-size: 50px; color: #4e73df;"></i>
            </div>
            <h2>Selamat Datang</h2>
            <p>Silakan masuk untuk melanjutkan ke WebISP</p>
        </div>
        
        <?php if(isset($error)): ?>
        <div class="error-message">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo $error; ?>
        </div>
        <?php endif; ?>
        
        <form action="" method="POST" class="login-form">
            <div class="input-group">
                <input type="email" placeholder="Email" name="email" required>
                <i class="fas fa-envelope"></i>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" required>
                <i class="fas fa-lock"></i>
            </div>
            <button type="submit" name="submit" class="login-btn">Masuk</button>
            
            
        </form>
    </div>
</body>
</html>