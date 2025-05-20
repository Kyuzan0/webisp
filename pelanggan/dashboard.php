<?php 
require '../view/sidebar.php';
require '../includes/functions.php';
require '../includes/init_session.php';

// Pastikan session sudah dimulai dan koneksi database sudah ada
// Ambil ID user yang login
$id_user = $_SESSION['id_user']; // Sesuaikan dengan variabel session Anda

// Query untuk mengambil nama produk berdasarkan id_user yang login
$query = "SELECT produk.nama_produk 
          FROM produk 
          JOIN customer ON produk.id_produk = customer.id_produk 
          WHERE customer.id_user = '$id_user'";

$result = mysqli_query($conn, $query);

// Default paket jika tidak ditemukan
$nama_paket = "Tidak ada paket";

// Jika data ditemukan, ambil nama produk
if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $nama_paket = $row['nama_produk'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PT Sinar Komunikasi Nusantara</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
  <style>
    /* Banner styles */
    .banner-container {
      position: relative;
      width: 100%;
      height: 210px;
      margin: 0 auto 30px auto;
      overflow: hidden;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .banner-wrapper {
      position: relative;
      display: flex;
      width: 200%; /* Untuk menampung 2 gambar */
      height: 100%;
      transition: transform 0.6s ease-in-out;
    }
    
    .banner-image {
      width: 50%; /* Setengah dari parent (banner-wrapper) */
      height: 100%;
      object-fit: cover;
      flex-shrink: 0;
    }
    
    .banner-nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0, 0, 0, 0.6);
      color: white;
      border: none;
      padding: 12px 16px;
      cursor: pointer;
      transition: all 0.3s ease;
      z-index: 100;
      border-radius: 50%;
      opacity: 0;
    }
    
    .banner-container:hover .banner-nav {
      opacity: 1;
    }
    
    .banner-nav:hover {
      background: rgba(0, 0, 0, 0.9);
      transform: translateY(-50%) scale(1.1);
    }
    
    .banner-nav.prev {
      left: 20px;
    }
    
    .banner-nav.next {
      right: 20px;
    }

    /* Card styles */
    .small-box {
      transition: all 0.3s ease;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      margin-bottom: 20px;
      border: 1px solid rgba(0,0,0,0.05);
      position: relative;
    }
    
    .small-box .icon {
      position: absolute;
      right: 15px;
      top: 15px;
      font-size: 70px;
      color: rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
      z-index: 0;
    }
    
    .small-box:hover .icon {
      font-size: 75px;
      right: 20px;
      top: 10px;
      color: rgba(0, 0, 0, 0.2);
      transform: rotate(5deg);
    }
    
    .small-box .inner {
      padding: 22px 20px;
      position: relative;
      z-index: 1;
    }
    
    .small-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    
    .small-box .icon {
      transition: all 0.3s ease;
      opacity: 0.8;
    }
    
    .small-box:hover .icon {
      transform: scale(1.1);
      opacity: 1;
    }
    
    .small-box .small-box-footer {
      background: rgba(0,0,0,0.1);
      padding: 10px;
      transition: all 0.3s ease;
      font-weight: 500;
    }
    
    .small-box:hover .small-box-footer {
      background: rgba(0,0,0,0.2);
    }
    
    .small-box .inner {
      padding: 22px 20px;
    }
    
    .small-box h3 {
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 12px;
    }
    
    .small-box p {
      font-size: 1rem;
      margin-bottom: 0;
      font-weight: 500;
    }

    /* Dashboard container */
    .dashboard-container {
      padding: 10px 20px;
    }
    
    /* Content header styling */
    .content-header {
      padding-bottom: 10px;
    }
    
    .content-header h1 {
      font-weight: 600;
      color: #333;
    }
    
    /* Breadcrumb styling */
    .breadcrumb {
      background-color: transparent;
      padding: 0;
    }
    
    .breadcrumb-item a {
      color: #007bff;
      font-weight: 500;
    }
    
    /* Responsive styles */
    @media (max-width: 1200px) {
      .banner-container {
        height: 180px;
      }
    }
    
    @media (max-width: 768px) {
      .banner-nav {
        opacity: 0.8;
        padding: 8px 12px;
      }
      
      .small-box h3 {
        font-size: 1.7rem;
      }
      
      .small-box p {
        font-size: 0.95rem;
      }
      
      .banner-container {
        height: 150px;
      }
      
      .dashboard-container {
        padding: 5px 10px;
      }
    }
    
    @media (max-width: 576px) {
      .banner-container {
        height: 120px;
      }
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid dashboard-container">
        <!-- Banner -->
        <div class="row">
          <div class="col-12">
            <div class="banner-container">
              <button class="banner-nav prev" onclick="changeBanner(-1)"><i class="fas fa-chevron-left"></i></button>
              <button class="banner-nav next" onclick="changeBanner(1)"><i class="fas fa-chevron-right"></i></button>
              <div id="bannerWrapper" class="banner-wrapper">
                <img src="../img/banner1.png" alt="Banner PT Sinar Komunikasi Nusantara" class="banner-image">
                <img src="../img/banner2.png" alt="Banner PT Sinar Komunikasi Nusantara" class="banner-image">
              </div>
            </div>
          </div>
        </div>
        
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-md-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <?php $jumlah_produk = getJumlahProduk($conn); ?>
                <h3 style="color: black;"><?php echo $jumlah_produk; ?></h3>
                <p style="color: black;">Daftar Paket Yang Tersedia</p>
              </div>
              <div class="icon">
                <i class="fas fa-box"></i>
              </div>
              <a href="../pelanggan/pdataproduk.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 style="color: black;"><?php echo $nama_paket; ?></h3>
                <p style="color: black;">Paket Yang Digunakan</p>
              </div>
              <div class="icon">
                <i class="fas fa-wifi"></i>
              </div>
              <a href="../pelanggan/pdataproduk.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/js/adminlte.js"></script>

<!-- Script untuk rotasi banner dengan transisi slide -->
<script>
  $(document).ready(function() {
    const banners = [
      '../img/banner1.png',
      '../img/banner2.png'
    ];
    
    let currentBannerIndex = 0;
    let intervalId;
    let isTransitioning = false;
    const $wrapper = $("#bannerWrapper");
    
    // Fungsi untuk mengganti banner dengan arah tertentu
    function changeBanner(direction) {
      if (isTransitioning) return;
      isTransitioning = true;
      
      clearInterval(intervalId);
      
      const nextIndex = (currentBannerIndex + direction + banners.length) % banners.length;
      
      if (direction > 0) {
        // Slide ke kiri
        $wrapper.css("transform", "translateX(-50%)");
        setTimeout(() => {
          $wrapper.find(".banner-image").eq(0).attr("src", banners[nextIndex]);
          $wrapper.css("transition", "none");
          $wrapper.css("transform", "translateX(0)");
          setTimeout(() => {
            $wrapper.css("transition", "transform 0.6s ease-in-out");
            isTransitioning = false;
          }, 50);
        }, 600);
      } else {
        // Slide ke kanan
        $wrapper.find(".banner-image").eq(1).attr("src", banners[nextIndex]);
        $wrapper.css("transition", "none");
        $wrapper.css("transform", "translateX(-50%)");
        setTimeout(() => {
          $wrapper.css("transition", "transform 0.6s ease-in-out");
          $wrapper.css("transform", "translateX(0)");
          setTimeout(() => {
            isTransitioning = false;
          }, 600);
        }, 50);
      }
      
      currentBannerIndex = nextIndex;
      startAutoRotation();
    }
    
    // Fungsi untuk memulai rotasi otomatis
    function startAutoRotation() {
      clearInterval(intervalId);
      intervalId = setInterval(() => {
        if (!isTransitioning) {
          changeBanner(1);
        }
      }, 5000);
    }
    
    // Mulai rotasi otomatis
    startAutoRotation();
    
    // Membuat fungsi changeBanner tersedia secara global
    window.changeBanner = changeBanner;
  });
</script>

</body>
</html>