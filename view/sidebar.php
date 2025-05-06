<?php
// Mulai session untuk mendapatkan level user
session_start();
$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : 'user'; // Ambil level user dari session, default 'user' jika tidak ada

// Fungsi untuk menampilkan menu berdasarkan level
function showMenu($level) {

    // Menu untuk Admin - Admin mendapatkan semua menu
    if ($level == 'Admin') {
        $menu['./public/index'] = 'Dashboard';
        $menu['./datauser/keloladatauser'] = 'Kelola Data User';
        $menu['./datapelanggan/keloladatapelanggan'] = 'Kelola Data Pelanggan';
        $menu['./dataproduk/dataproduk'] = 'Daftar Paket Speed Internet';
        $menu['job_reports'] = 'Daftar Keluhan';
        $menu['repair_schedule'] = 'Jadwal Perbaikan';
        $menu['sales_promo'] = 'Promo Sales';
        $menu['work_report'] = 'Melaporkan Pekerjaan';
    }

    // Menu untuk Supervisor
    if ($level == 'Supervisor') {
        $menu['./public/index'] = 'Dashboard';
        $menu['./sales/datapromo'] = 'Promo Sales';
    }

    // Menu untuk Kepala Teknisi
    if ($level == 'Kepala Teknisi') {
        $menu['repair_schedule'] = 'Jadwal Perbaikan';
        $menu['work_report'] = 'Melaporkan Pekerjaan';
    }

    // Menu untuk Sales
    if ($level == 'Sales Marketing') {
        $menu['./public/index'] = 'Dashboard';
        $menu['./sales/datapromo'] = 'Promo Sales';
    }

    // Menu untuk Teknisi
    if ($level == 'teknisi') {
        $menu['repair_schedule'] = 'Jadwal Perbaikan';
        $menu['work_report'] = 'Melaporkan Pekerjaan';
    }

    if ($level == 'customer') {
        $menu['repair_schedule'] = 'Jadwal Perbaikan';
        $menu['work_report'] = 'Melaporkan Pekerjaan';
    }

    return $menu;
}

// Ambil menu berdasarkan level pengguna
$menu = showMenu($user_level);
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="#" class="d-block">Selamat Datang, <?= $_SESSION['username']; ?>!</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Loop menu yang disesuaikan berdasarkan level -->
                <?php foreach ($menu as $key => $value): ?>
                    <li class="nav-item">
                        <a href="../<?= $key ?>.php" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p><?= $value ?></p>
                        </a>
                    </li>
                <?php endforeach; ?>

                <!-- Logout Button -->
                <form id="logoutForm" action="../public/logout.php" method="POST" style="display: none;">
                    <button type="submit" class="btn">Logout</button>
                </form>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="document.getElementById('logoutForm').submit();">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
