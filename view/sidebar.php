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
        $menu['./public/index'] = ['name' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'divider' => true];
        $menu['./datauser/keloladatauser'] = ['name' => 'Kelola Data User', 'icon' => 'fas fa-users-cog', 'divider' => false];
        $menu['./datapelanggan/keloladatapelanggan'] = ['name' => 'Kelola Data Pelanggan', 'icon' => 'fas fa-user-friends', 'divider' => true];
        $menu['./sales/datapromo'] = ['name' => 'Promo Sales', 'icon' => 'fas fa-bullhorn', 'divider' => false];
        $menu['./dataproduk/dataproduk'] = ['name' => 'Daftar Paket Internet', 'icon' => 'fas fa-box', 'divider' => false];
        $menu['./keluhan/daftarkeluhan'] = ['name' => 'Daftar Keluhan', 'icon' => 'fas fa-comments', 'divider' => false];
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
            return 'AdminLTELogo.png';
        case 'Supervisor':
            return 'user8-128x128.jpg';
        case 'Kepala Teknisi':
            return 'avatar5.png';
        case 'Teknisi':
            return 'avatar5.png';
        case 'Sales Marketing':
            return 'avatar3.png';
        case 'Customer':
            return 'avatar4.png';
        default:
            return 'avatar.png';
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

// Dapatkan base URL untuk path yang konsisten
$base_url = "";
$root_dir = "webisp";
$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

// Ekstrak base URL dari REQUEST_URI
if (strpos($request_uri, $root_dir) !== false) {
    $base_url = substr($request_uri, 0, strpos($request_uri, $root_dir) + strlen($root_dir) + 1);
} else {
    $base_url = "/";
}
?>

<aside class="main-sidebar <?php echo $sidebarTheme; ?> elevation-4 position-fixed">
    <!-- Brand Logo -->
    <a href="<?php echo $base_url; ?>public/index.php" class="brand-link d-flex align-items-center">
      <img src="<?php echo $base_url; ?>img/logo.png" alt="WebISP Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-bold">WebISP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
        <div class="image">
          <img src="<?php echo $base_url; ?>public/img/<?php echo getProfileImageByLevel($user_level); ?>" class="img-circle elevation-2" alt="User Image">
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
            // Perbaikan deteksi halaman aktif
            $menu_page = basename(str_replace('./', '', $key));
            $is_active = (strpos($current_page, $menu_page) !== false);
            
            // Perbaikan path untuk konsistensi
            $menu_path = str_replace('./', $base_url, $key) . '.php';
          ?>
            <li class="nav-item">
              <a href="<?= $menu_path ?>" class="nav-link <?php echo $is_active ? 'active' : ''; ?>">
                <i class="nav-icon <?= $item['icon'] ?>"></i>
                <p><?= $item['name'] ?></p>
              </a>
            </li>
            <?php if (isset($item['divider']) && $item['divider']): ?>
              <li class="nav-item"><hr class="nav-divider"></li>
            <?php endif; ?>
          <?php endforeach; ?>
          
          <!-- Logout Button -->
          <li class="nav-item mt-4 mb-2">
            <form id="logoutForm" action="<?php echo $base_url; ?>public/logout.php" method="POST" style="margin: 0; padding: 0 1rem;">
              <input type="hidden" name="logout" value="1">
              <button type="button" onclick="confirmLogout()" class="btn btn-danger btn-block d-flex align-items-center justify-content-center logout-btn">
                <i class="fas fa-sign-out-alt mr-2"></i>
                <span>Logout</span>
              </button>
            </form>
          </li>
        </ul>
      </nav>
    </div>
</aside>

<!-- Script untuk konfirmasi logout -->
<script>
function confirmLogout() {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Konfirmasi Logout',
            text: 'Apakah Anda yakin ingin keluar dari sistem?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    } else {
        if (confirm('Apakah Anda yakin ingin keluar dari sistem?')) {
            document.getElementById('logoutForm').submit();
        }
    }
}

// Menambahkan kelas aktif ke menu yang sesuai dan mencegah flicker
document.addEventListener('DOMContentLoaded', function() {
    // Dapatkan URL saat ini
    const currentLocation = window.location.href;
    
    // Ambil semua link menu
    const menuLinks = document.querySelectorAll('.nav-sidebar .nav-link');
    
    // Hapus kelas aktif dari semua menu
    menuLinks.forEach(link => {
        link.classList.remove('active');
    });
    
    // Tambahkan kelas aktif ke menu yang sesuai
    menuLinks.forEach(link => {
        if (currentLocation.includes(link.getAttribute('href'))) {
            link.classList.add('active');
        }
    });
});
</script>

<style>
/* Style untuk divider */
.nav-divider {
    border: 0;
    height: 1px;
    background: rgba(255, 255, 255, 0.2);
    margin: 10px 0;
    width: 90%;
    margin-left: 5%;
}

/* Style untuk tombol logout */
.logout-btn {
    background: linear-gradient(45deg, #dc3545, #c82333) !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 10px 15px !important;
    font-weight: 500 !important;
    letter-spacing: 0.5px;
    transition: all 0.3s ease !important;
    box-shadow: 0 2px 6px rgba(220, 53, 69, 0.2) !important;
}

.logout-btn:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3) !important;
    background: linear-gradient(45deg, #c82333, #dc3545) !important;
}

.logout-btn:active {
    transform: translateY(1px) !important;
}

.logout-btn i {
    transition: transform 0.3s ease;
}

.logout-btn:hover i {
    transform: translateX(3px);
}

/* Perbaikan untuk sidebar agar tidak flicker dan responsive saat scroll */
.main-sidebar {
    position: fixed !important;
    height: 100vh !important;
    overflow-y: auto !important;
    will-change: transform !important; /* Mencegah flicker */
    transition: transform 0.3s ease, width 0.3s ease !important;
    z-index: 1038 !important;
}

/* Optimasi scroll sidebar */
.sidebar {
    height: calc(100vh - 57px) !important; /* Tinggi viewport - tinggi header */
    overflow-y: auto !important;
    padding-bottom: 60px !important; /* Memberi ruang untuk logout button */
}

/* Mencegah content flicker pada transisi */
.nav-link {
    transition: background-color 0.2s ease !important;
    will-change: background-color !important;
}

/* Menghilangkan highlight default ketika mengklik menu */
.nav-link:focus {
    outline: none !important;
}

/* Media query untuk perangkat mobile */
@media (max-width: 768px) {
    .main-sidebar {
        box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23) !important;
    }
    
    .sidebar-open .main-sidebar {
        transform: translateX(0) !important;
    }
}
</style>