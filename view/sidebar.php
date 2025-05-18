<?php
// Mulai session untuk mendapatkan level user
require '../includes/init_session.php';

$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : 'user'; // Ambil level user dari session, default 'user' jika tidak ada

// Fungsi untuk menampilkan menu berdasarkan level
function showMenu($level) {

    // Array untuk menyimpan menu dan ikonnya
    $menu = [];

    // Menu untuk Admin - Admin mendapatkan semua menu
    if ($level == 'Admin') {
        $menu['./public/index'] = ['name' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt'];
        $menu['./datauser/keloladatauser'] = ['name' => 'Kelola Data User', 'icon' => 'fas fa-users-cog'];
        $menu['./datapelanggan/keloladatapelanggan'] = ['name' => 'Kelola Data Pelanggan', 'icon' => 'fas fa-user-friends'];
        $menu['./dataproduk/dataproduk'] = ['name' => 'Daftar Paket Internet', 'icon' => 'fas fa-box'];
        $menu['./keluhan/daftarkeluhan'] = ['name' => 'Daftar Keluhan', 'icon' => 'fas fa-comments'];
        //$menu['./teknisi/jadwalperbaikan'] = ['name' => 'Jadwal Perbaikan', 'icon' => 'fas fa-calendar-alt'];
        //$menu['./teknisi/laporanperbaikan'] = ['name' => 'Melaporkan Pekerjaan', 'icon' => 'fas fa-clipboard-check'];
        $menu['./sales/datapromo'] = ['name' => 'Promo Sales', 'icon' => 'fas fa-bullhorn'];
    }

    // Menu untuk Supervisor
    if ($level == 'Supervisor') {
        $menu['./supervisor/dashboard'] = ['name' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt'];
        $menu['./teknisi/laporanperbaikan'] = ['name' => 'Laporan Pekerjaan', 'icon' => 'fas fa-clipboard-check'];
        $menu['./datapelanggan/keloladatapelanggan'] = ['name' => 'Daftar Pelanggan', 'icon' => 'fas fa-user-friends'];
    }

    // Menu untuk Kepala Teknisi
    if ($level == 'Kepala Teknisi') {
        $menu['./kepalateknisi/dashboard'] = ['name' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt'];
        $menu['./keluhan/daftarkeluhan'] = ['name' => 'Daftar Keluhan', 'icon' => 'fas fa-comments'];
        $menu['./teknisi/jadwalperbaikan'] = ['name' => 'Jadwal Perbaikan', 'icon' => 'fas fa-calendar-alt'];
        $menu['./teknisi/laporanperbaikan'] = ['name' => 'Melaporkan Pekerjaan', 'icon' => 'fas fa-clipboard-check'];
    }

    // Menu untuk Sales
    if ($level == 'Sales Marketing') {
        $menu['./sales/dashboard'] = ['name' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt'];
        $menu['./sales/datapromo'] = ['name' => 'Promo Sales', 'icon' => 'fas fa-bullhorn'];
        $menu['./dataproduk/dataproduk'] = ['name' => 'Daftar Paket Internet', 'icon' => 'fas fa-box'];
        $menu['./sales/datapelanggan'] = ['name' => 'Daftar Pelanggan', 'icon' => 'fas fa-user-friends'];
    }

    // Menu untuk Teknisi
    if ($level == 'Teknisi') {
        $menu['./teknisi/dashboard'] = ['name' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt'];
        $menu['./teknisi/jadwalperbaikan'] = ['name' => 'Jadwal Perbaikan', 'icon' => 'fas fa-calendar-alt'];
        $menu['./teknisi/laporanperbaikan'] = ['name' => 'Melaporkan Pekerjaan', 'icon' => 'fas fa-clipboard-check'];
    }

    // Menu untuk Customer
    if ($level == 'Customer') {
        $menu['./pelanggan/dashboard'] = ['name' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt'];
        //$menu['./tagihan/datatagihan'] = ['name' => 'Tagihan', 'icon' => 'fas fa-file-invoice-dollar'];
        $menu['./pelanggan/pdatapromo'] = ['name' => 'Promo', 'icon' => 'fas fa-bullhorn'];
        $menu['./pelanggan/pdataproduk'] = ['name' => 'Daftar Paket Internet', 'icon' => 'fas fa-box'];
        $menu['./pelanggan/pdaftarkeluhan'] = ['name' => 'Bantuan', 'icon' => 'fas fa-hands-helping'];
    }

    return $menu;
}

// Fungsi untuk mendapatkan profil gambar berdasarkan level
function getProfileImageByLevel($level) {
    switch ($level) {
        case 'Admin':
            return '../img/AdminLTELogo.png';
        case 'Supervisor':
            return '../img/user8-128x128.jpg';
        case 'Kepala Teknisi':
            return '../img/avatar5.png';
        case 'Teknisi':
            return '../img/avatar5.png';
        case 'Sales Marketing':
            return '../img/avatar3.png';
        case 'Customer':
            return '../img/avatar4.png';
        default:
            return '../img/avatar.png';
    }
}

// Ambil menu berdasarkan level pengguna
$menu = showMenu($user_level);

// Tentukan warna tema berdasarkan level
$sidebarTheme = 'sidebar-dark-primary';
$accentColor = 'accent-primary';

switch ($user_level) {
    case 'Admin':
        $sidebarTheme = 'sidebar-dark-danger';
        $accentColor = 'accent-danger';
        break;
    case 'Supervisor':
        $sidebarTheme = 'sidebar-dark-warning';
        $accentColor = 'accent-warning';
        break;
    case 'Kepala Teknisi':
    case 'Teknisi':
        $sidebarTheme = 'sidebar-dark-success';
        $accentColor = 'accent-success';
        break;
    case 'Sales Marketing':
        $sidebarTheme = 'sidebar-dark-info';
        $accentColor = 'accent-info';
        break;
    case 'Customer':
        $sidebarTheme = 'sidebar-dark-primary';
        $accentColor = 'accent-primary';
        break;
}

// Dapatkan nama halaman saat ini untuk menandai menu aktif
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<aside class="main-sidebar <?php echo $sidebarTheme; ?> elevation-4 position-fixed">
    <!-- Brand Logo -->
    <a href="../public/index.php" class="brand-link d-flex align-items-center">
      <img src="../img/logo.png" alt="WebISP Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-bold">WebISP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
        <div class="image">
          <img src="../public/img/<?php echo getProfileImageByLevel($user_level); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block text-white"><?= $_SESSION['username']; ?></a>
          <span class="badge badge-pill badge-light"><?= $_SESSION['level']; ?></span>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact" data-widget="treeview" role="menu" data-accordion="false">
          <?php foreach ($menu as $key => $item): 
            $is_active = (strpos($key, $current_page) !== false);
          ?>
            <li class="nav-item">
              <a href="../<?= $key ?>.php" class="nav-link <?php echo $is_active ? 'active' : ''; ?>">
                <i class="nav-icon <?= $item['icon'] ?>"></i>
                <p><?= $item['name'] ?></p>
              </a>
            </li>
          <?php endforeach; ?>
          
          <!-- Logout Button -->
          <form id="logoutForm" action="../public/logout.php" method="POST" style="display: none;">
            <button type="submit" class="btn">Logout</button>
          </form>
          <li class="nav-item mt-3">
            <a href="#" class="nav-link text-danger logout-btn" onclick="confirmLogout()">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
</aside>

<!-- CSS untuk sidebar yang lebih menarik -->
<style>
  .main-sidebar {
    height: 100vh;
    overflow-y: auto;
    overflow-x: hidden;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    z-index: 1038;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
  }
  
  /* Custom scrollbar */
  .main-sidebar::-webkit-scrollbar {
    width: 6px;
  }
  
  .main-sidebar::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.1);
    border-radius: 3px;
  }
  
  .main-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.3);
    border-radius: 3px;
    transition: all 0.3s ease;
  }
  
  .main-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.5);
  }

  /* Brand Logo */
  .brand-link {
    transition: all 0.3s ease;
    border-bottom: 1px solid rgba(255,255,255,0.1);
  }

  .brand-link:hover {
    background: rgba(255,255,255,0.1);
  }

  .brand-link .brand-image {
    transition: transform 0.3s ease;
  }

  .brand-link:hover .brand-image {
    transform: scale(1.1);
  }

  /* User Panel */
  .user-panel {
    border-bottom: 1px solid rgba(255,255,255,0.1);
    padding: 15px 0;
  }

  .user-panel .image img {
    transition: all 0.3s ease;
  }

  .user-panel:hover .image img {
    transform: scale(1.1);
    box-shadow: 0 0 10px rgba(255,255,255,0.3);
  }

  .user-panel .badge {
    font-size: 0.8rem;
    padding: 5px 10px;
    margin-top: 5px;
    background: rgba(255,255,255,0.2);
    color: rgba(255,255,255,0.8);
    border: 1px solid rgba(255,255,255,0.1);
  }

  /* Nav Links */
  .nav-link {
    border-radius: 8px;
    margin: 2px 10px;
    transition: all 0.3s ease;
  }

  .nav-link:not(.active):hover {
    background: rgba(255,255,255,0.1);
    transform: translateX(5px);
  }

  .nav-link.active {
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
  }

  .nav-link i {
    transition: all 0.3s ease;
  }

  .nav-link:hover i {
    transform: scale(1.2);
  }

  /* Logout Button */
  .logout-btn {
    border: 1px solid rgba(255,255,255,0.1);
    margin-top: 20px;
    transition: all 0.3s ease;
  }

  .logout-btn:hover {
    background: rgba(220,53,69,0.2);
    border-color: #dc3545;
    transform: translateX(5px);
  }

  .logout-btn i {
    transition: transform 0.3s ease;
  }

  .logout-btn:hover i {
    transform: rotate(-180deg);
  }
</style>

<!-- Script untuk konfirmasi logout dengan SweetAlert2 -->
<script>
function confirmLogout() {
  Swal.fire({
    title: 'Apakah Anda yakin ingin keluar?',
    text: "Anda harus login kembali untuk mengakses sistem",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#dc3545',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, Keluar!',
    cancelButtonText: 'Batal',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('logoutForm').submit();
    }
  });
}
</script>