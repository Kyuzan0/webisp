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
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
        <div class="image">
          <img src="../public/img/<?php echo getProfileImageByLevel($user_level); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block text-white"><?= $_SESSION['username']; ?></a>
          <span class="badge badge-light"><?= $_SESSION['level']; ?></span>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Loop menu yang disesuaikan berdasarkan level -->
          <?php foreach ($menu as $key => $item): 
            // Check if current page matches this menu item
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
          <li class="nav-item">
            <a href="#" class="nav-link text-danger" onclick="confirmLogout()">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- CSS untuk sidebar responsif -->
<style>
  /* Memastikan sidebar tetap ada dalam view saat di-scroll */
  .main-sidebar {
    height: 100vh;
    overflow-y: auto;
    overflow-x: hidden;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    z-index: 1038;
    transition: width 0.3s ease-in-out, margin-left 0.3s ease-in-out;
  }
  
  /* Custom scrollbar untuk sidebar */
  .main-sidebar::-webkit-scrollbar {
    width: 5px;
  }
  
  .main-sidebar::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.1);
  }
  
  .main-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.2);
    border-radius: 3px;
  }
  
  /* Penyesuaian untuk layar kecil */
  @media (max-width: 992px) {
    .main-sidebar {
      box-shadow: 0 14px 28px rgba(0,0,0,.25), 0 10px 10px rgba(0,0,0,.22);
    }
    
    body:not(.sidebar-collapse) .main-sidebar {
      margin-left: 0;
    }
    
    body.sidebar-collapse .main-sidebar {
      margin-left: -250px;
    }
  }
  
  /* Memastikan konten menu responsif */
  .nav-sidebar .nav-link p {
    display: block;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  
  /* Menyesuaikan ukuran brand text pada ukuran layar kecil */
  @media (max-width: 576px) {
    .brand-text {
      font-size: 1rem;
    }
  }
</style>

<!-- Tambahkan script untuk konfirmasi logout -->
<script>
function confirmLogout() {
  // Periksa apakah SweetAlert2 tersedia
  if (typeof Swal !== 'undefined') {
    Swal.fire({
      title: 'Logout',
      text: "Apakah Anda yakin ingin keluar dari sistem?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, Logout',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('logoutForm').submit();
      }
    });
  } else {
    // Fallback jika SweetAlert2 tidak tersedia
    if (confirm('Apakah Anda yakin ingin keluar dari sistem?')) {
      document.getElementById('logoutForm').submit();
    }
  }
}

// Script untuk menangani sidebar toggle pada versi mobile
document.addEventListener('DOMContentLoaded', function() {
  // Cek apakah ada tombol toggle sidebar
  const sidebarToggleBtn = document.querySelector('[data-widget="pushmenu"]');
  
  if (sidebarToggleBtn) {
    sidebarToggleBtn.addEventListener('click', function() {
      document.body.classList.toggle('sidebar-collapse');
    });
  }
  
  // Menutup sidebar otomatis pada layar kecil saat menu item diklik
  const navLinks = document.querySelectorAll('.nav-sidebar .nav-link');
  const screenWidth = window.innerWidth;
  
  if (screenWidth < 992) {
    navLinks.forEach(link => {
      link.addEventListener('click', function() {
        if (sidebarToggleBtn && !link.classList.contains('has-treeview')) {
          setTimeout(() => {
            sidebarToggleBtn.click();
          }, 100);
        }
      });
    });
  }
});
</script>