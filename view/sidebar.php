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
        $menu['./admin/dashboard'] = ['name' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'divider' => true];
        $menu['./datauser/keloladatauser'] = ['name' => 'Kelola Data User', 'icon' => 'fas fa-users-cog', 'divider' => false];
        $menu['./datapelanggan/keloladatapelanggan'] = ['name' => 'Kelola Data Pelanggan', 'icon' => 'fas fa-user-friends', 'divider' => true];
        $menu['./sales/datapromo'] = ['name' => 'Promo Sales', 'icon' => 'fas fa-bullhorn', 'divider' => false];
        $menu['./dataproduk/dataproduk'] = ['name' => 'Daftar Paket Internet', 'icon' => 'fas fa-box', 'divider' => false];
        $menu['./keluhan/daftarkeluhan'] = ['name' => 'Daftar Keluhan', 'icon' => 'fas fa-comments', 'divider' => false];
    }

    // Menu untuk Supervisor
    if ($level == 'Supervisor') {
        $menu['./supervisor/dashboard'] = ['name' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt'];
        $menu['./datauser/keloladatauser'] = ['name' => 'Data User', 'icon' => 'fas fa-users-cog', 'divider' => false];
        $menu['./datapelanggan/keloladatapelanggan'] = ['name' => 'Daftar Pelanggan', 'icon' => 'fas fa-user-friends'];
        $menu['./kepalateknisi/jadwalperbaikan'] = ['name' => 'Jadwal Perbaikan', 'icon' => 'fas fa-calendar-alt'];
        $menu['./kepalateknisi/daftarkeluhan'] = ['name' => 'Daftar Keluhan', 'icon' => 'fas fa-comments'];
    }

    // Menu untuk Kepala Teknisi
    if ($level == 'Kepala Teknisi') {
        $menu['./kepalateknisi/dashboard'] = ['name' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt'];
        $menu['./dataproduk/dataproduk'] = ['name' => 'Daftar Paket Internet', 'icon' => 'fas fa-box'];
        $menu['./kepalateknisi/daftarkeluhan'] = ['name' => 'Daftar Keluhan', 'icon' => 'fas fa-comments'];
        $menu['./kepalateknisi/jadwalperbaikan'] = ['name' => 'Jadwal Perbaikan', 'icon' => 'fas fa-calendar-alt'];
    }

    // Menu untuk Teknisi
    if ($level == 'Teknisi') {
        $menu['./teknisi/dashboard'] = ['name' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt'];
        $menu['./teknisi/jadwalperbaikan'] = ['name' => 'Jadwal Perbaikan', 'icon' => 'fas fa-calendar-alt'];
    }

    // Menu untuk Sales
    if ($level == 'Sales Marketing') {
        $menu['./sales/dashboard'] = ['name' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt'];
        $menu['./sales/datapromo'] = ['name' => 'Promo Sales', 'icon' => 'fas fa-bullhorn'];
        $menu['./dataproduk/dataproduk'] = ['name' => 'Daftar Paket Internet', 'icon' => 'fas fa-box'];
        $menu['./sales/datapelanggan'] = ['name' => 'Daftar Pelanggan', 'icon' => 'fas fa-user-friends'];
        $menu['./sales/kelola-request'] = ['name' => 'Request Paket', 'icon' => 'fas fa-box'];
    }

    // Menu untuk Customer
    if ($level == 'Customer') {
        $menu['./pelanggan/dashboard'] = ['name' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt'];
        $menu['./pelanggan/pdatapromo'] = ['name' => 'Promo', 'icon' => 'fas fa-bullhorn'];
        $menu['./pelanggan/pkelolapaket'] = ['name' => 'Kelola Paket', 'icon' => 'fas fa-box'];
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
// Tentukan warna tema - gunakan warna hijau untuk semua level
$sidebarTheme = 'sidebar-dark-secondary';
$accentColor = 'accent-secondary';


// Dapatkan nama halaman saat ini untuk menandai menu aktif
$current_page = basename($_SERVER['PHP_SELF'], '.php');

// Base URL handling yang diperbaiki
$base_url = "";
$root_dir = "webisp";
$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

// Ekstrak base URL dari REQUEST_URI dengan perbaikan
if (strpos($request_uri, $root_dir) !== false) {
    $base_url = substr($request_uri, 0, strpos($request_uri, $root_dir) + strlen($root_dir) + 1);
} else {
    // Fallback untuk base URL
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $script_dir = dirname($_SERVER['SCRIPT_NAME']);
    $base_url = $protocol . $host . rtrim($script_dir, '/') . '/';
}

// Normalisasi base URL
$base_url = rtrim($base_url, '/') . '/';
?>

<aside id="main-sidebar" class="main-sidebar <?php echo $sidebarTheme; ?> elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="<?php echo $base_url; ?>img/logo.png" alt="WebISP Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-bold">WebISP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo $base_url; ?>public/img/<?php echo getProfileImageByLevel($user_level); ?>" 
                     class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block text-white"><?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?></a>
                <span class="badge badge-sm badge-light mt-1"><?= htmlspecialchars($_SESSION['level'] ?? 'Guest'); ?></span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact" data-widget="treeview" role="menu" data-accordion="false">
                <?php foreach ($menu as $key => $item): 
                    // Perbaikan deteksi halaman aktif
                    $menu_page = basename(str_replace('./', '', $key));
                    $is_active = (strpos($current_page, $menu_page) !== false) || (strpos($_SERVER['REQUEST_URI'], $menu_page) !== false);
                    
                    // Perbaikan path untuk konsistensi
                    $menu_path = str_replace('./', $base_url, $key) . '.php';
                ?>
                    <li class="nav-item">
                        <a href="<?= htmlspecialchars($menu_path) ?>" class="nav-link <?php echo $is_active ? 'active' : ''; ?>">
                            <i class="nav-icon <?= htmlspecialchars($item['icon']) ?>"></i>
                            <p><?= htmlspecialchars($item['name']) ?></p>
                        </a>
                    </li>
                    <?php if (isset($item['divider']) && $item['divider']): ?>
                        <li class="nav-item">
                            <hr class="nav-divider">
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
                
                <!-- Logout Button -->
                <li class="nav-item logout-section">
                    <hr class="nav-divider mb-3">
                    <div class="logout-container">
                        <button type="button" onclick="confirmLogout()" class="btn btn-danger btn-block logout-btn">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            <span>Logout</span>
                        </button>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<!-- Hidden form untuk logout -->
<form id="logoutForm" action="<?php echo $base_url; ?>public/logout.php" method="POST" style="display: none;">
    <input type="hidden" name="logout" value="1">
</form>

<!-- Script untuk konfirmasi logout dan menu handling -->
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

// Enhanced menu activation dan smooth transitions
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar
    initializeSidebar();
    
    // Set active menu
    setActiveMenu();
    
    // Handle responsive sidebar
    handleResponsiveSidebar();
});

function initializeSidebar() {
    const sidebar = document.getElementById('main-sidebar');
    if (sidebar) {
        // Add smooth transition class
        sidebar.classList.add('sidebar-initialized');
        
        // Prevent sidebar flicker on page load
        setTimeout(() => {
            sidebar.style.visibility = 'visible';
        }, 50);
    }
}

function setActiveMenu() {
    const currentUrl = window.location.href;
    const currentPath = window.location.pathname;
    const menuLinks = document.querySelectorAll('.nav-sidebar .nav-link:not(.logout-btn)');
    
    // Remove all active classes first
    menuLinks.forEach(link => {
        link.classList.remove('active');
    });
    
    // Find and set active menu
    let activeFound = false;
    menuLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href) {
            const linkPath = new URL(href, window.location.origin).pathname;
            const linkPage = linkPath.split('/').pop().replace('.php', '');
            const currentPageBase = currentPath.split('/').pop().replace('.php', '');
            
            if (linkPage === currentPageBase || currentUrl.includes(linkPage)) {
                link.classList.add('active');
                activeFound = true;
            }
        }
    });
    
    // If no specific match found, activate Dashboard for home page
    if (!activeFound && (currentPath === '/' || currentPath.includes('index'))) {
        const dashboardLink = document.querySelector('a[href*="dashboard"], a[href*="index"]');
        if (dashboardLink) {
            dashboardLink.classList.add('active');
        }
    }
}

function handleResponsiveSidebar() {
    // Mobile sidebar toggle functionality
    const sidebarToggle = document.querySelector('[data-widget="pushmenu"]');
    const sidebar = document.getElementById('main-sidebar');
    const body = document.body;
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            body.classList.toggle('sidebar-open');
            body.classList.toggle('sidebar-collapse');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            const sidebar = document.getElementById('main-sidebar');
            const sidebarToggle = document.querySelector('[data-widget="pushmenu"]');
            
            if (sidebar && !sidebar.contains(e.target) && !sidebarToggle?.contains(e.target)) {
                document.body.classList.remove('sidebar-open');
                document.body.classList.add('sidebar-collapse');
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            document.body.classList.remove('sidebar-open', 'sidebar-collapse');
        }
    });
}

// Smooth scroll for long sidebars
function smoothScrollToActive() {
    const activeLink = document.querySelector('.nav-sidebar .nav-link.active');
    if (activeLink) {
        activeLink.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }
}

// Call smooth scroll after DOM is loaded
window.addEventListener('load', function() {
    setTimeout(smoothScrollToActive, 100);
});
</script>

<style>
/* =================================
   SIDEBAR CORE STYLES - FIXED VERSION
   ================================= */

/* Main Sidebar Container */
.main-sidebar {
    position: fixed !important;
    top: 0;
    left: 0;
    width: 250px;
    height: 100vh;
    z-index: 1038;
    overflow: hidden;
    transition: all 0.3s ease-in-out;
    visibility: hidden; /* Prevent FOUC */
    backface-visibility: hidden;
    transform: translateZ(0); /* Force GPU acceleration */
}

.main-sidebar.sidebar-initialized {
    visibility: visible;
}

/* Brand Link */
.brand-link {
    display: flex !important;
    align-items: center;
    padding: 0.8125rem 0.5rem;
    font-size: 1.25rem;
    line-height: 1.2;
    text-decoration: none;
    white-space: nowrap;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    background-color: rgba(0,0,0,0.1);
    transition: background-color 0.3s ease;
}

.brand-link:hover {
    text-decoration: none;
    background-color: rgba(0,0,0,0.15);
}

.brand-image {
    width: 33px;
    height: 33px;
    margin-right: 0.5rem;
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.brand-text {
    color: rgba(255,255,255,0.9) !important;
    font-weight: 600 !important;
}

/* Sidebar Content */
.sidebar {
    height: calc(100vh - 57px); /* Account for brand link height */
    overflow-y: auto;
    overflow-x: hidden;
    padding-bottom: 80px; /* Space for logout button */
    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,0.3) transparent;
}

/* Custom Scrollbar */
.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.05);
}

.sidebar::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.3);
    border-radius: 3px;
    transition: background 0.3s ease;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.5);
}

/* User Panel */
.user-panel {
    border-bottom: 1px solid rgba(255,255,255,0.1);
    margin-bottom: 1rem !important;
    padding-bottom: 1rem !important;
}

.user-panel .image img {
    width: 2.1rem;
    height: 2.1rem;
    border: 2px solid rgba(255,255,255,0.2);
    transition: border-color 0.3s ease;
}

.user-panel:hover .image img {
    border-color: rgba(255,255,255,0.4);
}

.user-panel .info a {
    color: rgba(255,255,255,0.9) !important;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.user-panel .info a:hover {
    color: #fff !important;
}

.user-panel .badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    background-color: rgba(255,255,255,0.2) !important;
    color: rgba(255,255,255,0.9) !important;
    border: 1px solid rgba(255,255,255,0.1);
}

/* Navigation Styles */
.nav-sidebar {
    padding: 0 0.5rem;
}

.nav-sidebar .nav-item {
    margin-bottom: 0.2rem;
}

.nav-sidebar .nav-link {
    border-radius: 0.375rem !important;
    padding: 0.6rem 0.75rem !important;
    color: rgba(255,255,255,0.8) !important;
    transition: all 0.2s ease-in-out !important;
    position: relative;
    overflow: hidden;
}

.nav-sidebar .nav-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    transition: left 0.5s ease;
}

.nav-sidebar .nav-link:hover::before {
    left: 100%;
}

.nav-sidebar .nav-link:hover {
    background-color: rgba(255,255,255,0.1) !important;
    color: #fff !important;
    transform: translateX(3px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.nav-sidebar .nav-link.active {
    background-color: rgba(255,255,255,0.2) !important;
    color: #fff !important;
    font-weight: 600;
    box-shadow: 0 2px 12px rgba(0,0,0,0.15);
    border-left: 3px solid rgba(255,255,255,0.8);
}

.nav-icon {
    margin-right: 0.5rem !important;
    width: 1.2rem;
    text-align: center;
    transition: transform 0.2s ease;
}

.nav-link:hover .nav-icon {
    transform: scale(1.1);
}

/* Dividers */
.nav-divider {
    border: 0;
    height: 1px;
    background: linear-gradient(to right, transparent, rgba(255,255,255,0.3), transparent);
    margin: 0.8rem 1rem;
    opacity: 0.7;
}

/* Logout Section */
.logout-section {
    margin-top: auto;
    position: sticky;
    bottom: 0;
    background-color: inherit;
    padding: 1rem 0.5rem 0.5rem;
}

.logout-container {
    padding: 0 0.25rem;
}

.logout-btn {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
    border: none !important;
    border-radius: 0.5rem !important;
    padding: 0.75rem 1rem !important;
    font-weight: 600 !important;
    letter-spacing: 0.025em;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3) !important;
    position: relative;
    overflow: hidden;
}

.logout-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.logout-btn:hover::before {
    left: 100%;
}

.logout-btn:hover {
    background: linear-gradient(135deg, #c82333 0%, #dc3545 100%) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4) !important;
}

.logout-btn:active {
    transform: translateY(0) !important;
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3) !important;
}

.logout-btn i {
    transition: transform 0.3s ease;
}

.logout-btn:hover i {
    transform: translateX(2px);
}

/* Theme Colors */
.sidebar-dark-primary {
    background: linear-gradient(180deg, #007bff 0%, #0056b3 100%);
}

.sidebar-dark-danger {
    background: linear-gradient(180deg, #dc3545 0%, #c82333 100%);
}

.sidebar-dark-warning {
    background: linear-gradient(180deg, #ffc107 0%, #e0a800 100%);
}

.sidebar-dark-success {
    background: linear-gradient(180deg, #28a745 0%, #1e7e34 100%);
}

.sidebar-dark-info {
    background: linear-gradient(180deg, #17a2b8 0%, #138496 100%);
}

/* Content Wrapper Adjustment */
.content-wrapper {
    margin-left: 250px !important;
    transition: margin-left 0.3s ease-in-out;
    min-height: 100vh;
}

/* Mobile Responsiveness */
@media (max-width: 991.98px) {
    .main-sidebar {
        transform: translateX(-250px);
        box-shadow: none;
    }
    
    .content-wrapper {
        margin-left: 0 !important;
    }
    
    .sidebar-open .main-sidebar {
        transform: translateX(0);
        box-shadow: 0 0 20px rgba(0,0,0,0.3);
    }
    
    .sidebar-open .content-wrapper::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0,0,0,0.5);
        z-index: 1037;
    }
}

@media (max-width: 575.98px) {
    .brand-text {
        font-size: 1.1rem;
    }
    
    .nav-sidebar .nav-link {
        padding: 0.5rem 0.6rem !important;
        font-size: 0.9rem;
    }
    
    .logout-btn {
        padding: 0.6rem 0.8rem !important;
        font-size: 0.9rem;
    }
}

/* Animation untuk loading */
@keyframes slideInLeft {
    from {
        transform: translateX(-100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.sidebar-initialized {
    animation: slideInLeft 0.3s ease-out;
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .nav-sidebar .nav-link {
        border: 1px solid rgba(255,255,255,0.3);
    }
    
    .nav-sidebar .nav-link.active {
        border: 2px solid #fff;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .main-sidebar,
    .nav-sidebar .nav-link,
    .logout-btn {
        transition: none !important;
    }
    
    .sidebar-initialized {
        animation: none;
    }
}

/* Print styles */
@media print {
    .main-sidebar {
        display: none !important;
    }
    
    .content-wrapper {
        margin-left: 0 !important;
    }
}
</style>