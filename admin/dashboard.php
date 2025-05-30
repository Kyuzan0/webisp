<?php 
require '../view/sidebar.php';
require '../includes/functions.php';

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PT Sinar Komunikasi Nusantara</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
  <style>
    .content-wrapper {
      background-color: #f4f6f9;
    }
    
    .small-box {
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      overflow: hidden;
      transition: all 0.3s ease;
    }
    
    .small-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
    
    .small-box .icon {
      opacity: 0.8;
      transition: all 0.3s ease;
      position: absolute;
      right: 15px;
      top: 15px;
      z-index: 0;
      font-size: 70px;
      color: rgba(255, 255, 255, 0.3);
      cursor: default;
      pointer-events: none;
    }
    
    .small-box:hover .icon {
      transform: scale(1.1) rotate(5deg);
      opacity: 1;
      color: rgba(255, 255, 255, 0.5);
    }
    
    .small-box .inner {
      padding: 20px;
    }
    
    .small-box .inner h3 {
      font-weight: 600;
      margin-bottom: 10px;
      font-size: 2rem;
    }
    
    .small-box .inner p {
      font-size: 1.1rem;
      font-weight: 500;
    }
    
    .small-box-footer {
      background: rgba(0,0,0,0.1);
      padding: 8px 0;
      transition: all 0.3s ease;
    }
    
    .small-box:hover .small-box-footer {
      background: rgba(0,0,0,0.2);
      padding: 10px 0;
    }
    
    .small-box-footer i {
      transition: transform 0.3s ease;
    }
    
    .small-box:hover .small-box-footer i {
      transform: translateX(5px);
    }
    
    .content-header h1 {
      font-weight: 600;
      font-size: 2.2rem;
      display: inline-block;
      position: relative;
      padding-bottom: 10px;
    }
    
    .content-header h1:after {
      content: '';
      position: absolute;
      width: 50px;
      height: 3px;
      background: #007bff;
      bottom: 0;
      left: 0;
    }
    
    .breadcrumb-item a {
      color: #007bff;
      font-weight: 500;
    }
    
    .breadcrumb-item.active {
      font-weight: 500;
    }
    
    .navbar {
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .welcome-message {
      margin-top: 10px;
      color: #6c757d;
      font-size: 1.1rem;
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
            <h1 class="m-0"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</h1>
            <p class="welcome-message">Selamat datang di sistem manajemen WebISP</p>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home mr-1"></i>Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <?php $jumlah_produk = getJumlahProduk($conn); ?>
                <h3><?php echo $jumlah_produk; ?></h3>
                <p>Daftar Paket</p>
              </div>
              <div class="icon">
                <i class="fas fa-wifi"></i>
              </div>
              <a href="../dataproduk/dataproduk.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
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
              <a href="../datapelanggan/keloladatapelanggan.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <?php $jumlah_user = getJumlahUser($conn); ?>
                <h3 style="color: #fff;"><?php echo $jumlah_user; ?></h3>
                <p style="color: #fff;">Jumlah User</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-shield"></i>
              </div>
              <a href="../datauser/keloladatauser.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <?php $jumlah_keluhan = getjumlahkeluhan($conn); ?>
                <h3 style="color: #fff;"><?php echo $jumlah_keluhan; ?></h3>
                <p style="color: #fff;">Jumlah Keluhan</p>
              </div>
              <div class="icon">
                <i class="fas fa-exclamation-circle"></i>
              </div>
              <a href="../keluhan/daftarkeluhan.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
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
