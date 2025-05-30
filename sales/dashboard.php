<?php 
require '../view/sidebar.php';
require '../includes/functions.php';

// Ambil jumlah produk (paket)
$jumlah_produk = getJumlahProduk($conn);

// Ambil jumlah pelanggan
$jumlah_pelanggan = getJumlahPelanggan($conn);

// Ambil jumlah promo aktif
$jumlah_promo = getJumlahPromo($conn); // Asumsi fungsi ini ada di includes/functions.php

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
    
    .small-box .small-box-footer {
      background: rgba(0,0,0,0.1);
      padding: 10px;
      transition: all 0.3s ease;
      font-weight: 500;
    }
    
    .small-box:hover .small-box-footer {
      background: rgba(255, 255, 255, 0.2);
    }
    
    .small-box h3 {
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 12px;
      color: black;
    }
    
    .small-box p {
      font-size: 1rem;
      margin-bottom: 0;
      font-weight: 500;
      color: black;
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
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard Sales</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard </li>
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
        
        
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <?php $jumlah_produk = getJumlahProduk($conn); ?>
                <h3><?php echo $jumlah_produk; ?></h3>

                <p>Daftar Paket</p>
              </div>
              <div class="icon">
                <i class="fas fa-box"></i>
              </div>
              <a href="../dataproduk/dataproduk.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-md-4 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <?php $jumlah_pelanggan = getJumlahPelanggan($conn); ?>
              <h3><?php echo $jumlah_pelanggan; ?></h3>
    
                <p>Jumlah Pelanggan</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="datapelanggan.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-md-4 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $jumlah_promo; ?></h3>
                <p>Promo Aktif</p>
              </div>
              <div class="icon">
                <i class="fas fa-percentage"></i>
              </div>
              <a href="../sales/datapromo.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        
        <!-- Main Features Section -->
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Fitur Utama</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-12"> <!-- Changed col-md-4 to col-md-6 -->
                    <div class="info-box">
                      <span class="info-box-icon bg-primary"><i class="fas fa-clipboard-list"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">Kelola Produk</span>
                        <a href="../dataproduk/dataproduk.php" class="text-sm">Atur paket internet &nbsp;<i class="fas fa-arrow-right"></i></a>
                      </div>
                    </div>
                  </div>
                  <!-- Removed "Tambah Pelanggan" info box -->
                  <div class="col-md-6 col-sm-6 col-12"> <!-- Changed col-md-4 to col-md-6 -->
                    <div class="info-box">
                      <span class="info-box-icon bg-warning"><i class="fas fa-tags"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">Kelola Promo</span>
                        <a href="../sales/datapromo.php" class="text-sm">Atur penawaran khusus &nbsp;<i class="fas fa-arrow-right"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
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

<script>
$(document).ready(function() {
    $('[data-widget="pushmenu"]').on('click', function(e) {
        e.preventDefault();
        if ($('body').hasClass('sidebar-collapse')) {
            $('body').removeClass('sidebar-collapse');
        } else {
            $('body').addClass('sidebar-collapse');
        }
    });
});
</script>

</body>
</html>