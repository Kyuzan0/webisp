<?php
session_start();
//require '../includes/functions.php';
$conn = new mysqli("localhost", "root", "", "dbisp");

$username = $_POST['username'];
$password = $_POST['password'];

$query = $conn->prepare("SELECT * FROM users WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 1) {
    $data = $result->fetch_assoc();

    
    if (password_verify($password, $data['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $data['username'];
        $_SESSION['level'] = $data['level']; 

        
        if ($data['level'] == 'supervisor') {
            header("Location: LaproanStok.php");
        } elseif ($data['level'] == 'admin') {
            header("Location: ../public/index.php");
        } elseif ($data['level'] == 'gudang') {
            header("Location: DashboardStaffGudang.php");
        } else {
            
            header("Location: FormLogin.php?error=Level tidak dikenali");
        }
        exit;
    } else {
        header("Location: FormLogin.php?error=Password salah");
        exit;
    }
} else {
    header("Location: FormLogin.php?error=Username tidak ditemukan");
    exit;
}