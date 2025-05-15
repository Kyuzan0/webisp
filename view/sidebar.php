<?php
// Mulai session untuk mendapatkan level user
require '../includes/init_session.php';

$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : 'user'; // Ambil level user dari session, default 'user' jika tidak ada

// Fungsi untuk menampilkan menu berdasarkan level
function showMenu($level) {

    // Menu untuk Admin - Admin mendapatkan semua menu
    if ($level == 'Admin') {
        $menu['./public/index'] = 'Dashboard';
        $menu['./datauser/keloladatauser'] = 'Kelola Data User';
        $menu['./datapelanggan/keloladatapelanggan'] = 'Kelola Data Pelanggan';
        $menu['./dataproduk/dataproduk'] = 'Daftar Paket Internet';
        $menu['./keluhan/daftarkeluhan'] = 'Daftar Keluhan';
        //$menu['./teknisi/jadwalperbaikan'] = 'Jadwal Perbaikan';
        //$menu['./teknisi/laporanperbaikan'] = 'Melaporkan Pekerjaan';
        $menu['./sales/datapromo'] = 'Promo Sales';
    }

    // Menu untuk Supervisor
    if ($level == 'Supervisor') {
        $menu['./supervisor/dashboard'] = 'Dashboard';
        $menu['./teknisi/laporanperbaikan'] = 'Laporan Pekerjaan';
        $menu['./datapelanggan/keloladatapelanggan'] = 'Daftar Pelanggan';
    }

    // Menu untuk Kepala Teknisi
    if ($level == 'Kepala Teknisi') {
        $menu['./public/index'] = 'Dashboard';
        $menu['./keluhan/daftarkeluhan'] = 'Daftar Keluhan';
        $menu['./teknisi/jadwalperbaikan'] = 'Jadwal Perbaikan';
        $menu['./teknisi/laporanperbaikan'] = 'Melaporkan Pekerjaan';
    }

    // Menu untuk Sales
    if ($level == 'Sales Marketing') {
        $menu['./sales/dashboard'] = 'Dashboard';
        $menu['./sales/datapromo'] = 'Promo Sales';
        $menu['./dataproduk/dataproduk'] = 'Daftar Paket Internet';
        $menu['./sales/datapelanggan'] = 'Daftar Pelanggan';
    }

    // Menu untuk Teknisi
    if ($level == 'Teknisi') {
        $menu['./public/index'] = 'Dashboard';
        $menu['./teknisi/jadwalperbaikan'] = 'Jadwal Perbaikan';
        $menu['./teknisi/laporanperbaikan'] = 'Melaporkan Pekerjaan';
    }

    // Menu untuk Customer
    if ($level == 'Customer') {
        $menu['./pelanggan/dashboard'] = 'Dashboard';
        //$menu['./tagihan/datatagihan'] = 'Tagihan';
        $menu['./pelanggan/pdatapromo'] = 'Promo';
        $menu['./pelanggan/pdataproduk'] = 'Daftar Paket Internet';
        $menu['./pelanggan/pformkeluhan'] = 'Form Keluhan';
    }

    return $menu;
}

// Ambil menu berdasarkan level pengguna
$menu = showMenu($user_level);
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../public/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a style="color: white; " href="#" class="d-block"><?= $_SESSION['username']; ?> <span style="color: grey; "> (<?= $_SESSION['level']; ?>)</span></a>
            <a style="color: white; " href="#" class="d-block"><?= $_SESSION['id_user']; ?></a>
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
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
