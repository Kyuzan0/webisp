<?php 
require '../view/sidebar.php';
require '../includes/functions.php';

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
  
  <!-- Tambahan CSS untuk banner promo -->
  <style>
    .promo-banner {
      background: linear-gradient(135deg, #4e73df 0%, #36b9cc 100%);
      color: white;
      border-radius: 5px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      position: relative;
      overflow: hidden;
    }
    
    .promo-banner h2 {
      margin-top: 0;
      font-weight: 600;
      margin-bottom: 10px;
    }
    
    .promo-banner p {
      margin-bottom: 15px;
      font-size: 16px;
    }
    
    .promo-banner .btn {
      background-color: white;
      color: #4e73df;
      font-weight: 600;
      border: none;
      padding: 8px 20px;
      border-radius: 30px;
      transition: all 0.3s;
    }
    
    .promo-banner .btn:hover {
      background-color: #f8f9fc;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .promo-banner .promo-icon {
      position: absolute;
      right: 30px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 80px;
      opacity: 0.2;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  
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
      <div class="container-fluid">
        
        <!-- Banner Promo -->
        <div class="row">
          <div class="col-12">
            <div class="promo-banner">
              <div class="promo-icon">
                <i class="fas fa-bullhorn"></i>
              </div>
              <h2>Promo Spesial Bulan Ini!</h2>
              <p>Dapatkan diskon hingga 25% untuk semua paket internet premium. Penawaran terbatas sampai akhir bulan.</p>
              <a href="../sales/datapromo.php" class="btn">Lihat Detail Promo</a>
            </div>
          </div>
        </div>
        
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <?php $jumlah_produk = getJumlahProduk($conn); ?>
                <h3 style="color: black;"><?php echo $jumlah_produk; ?><sup style="font-size: 20px"></sup></h3>

                <p style="color: black;">Daftar Paket</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="../dataproduk/dataproduk.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <?php $jumlah_pelanggan = getJumlahPelanggan($conn); ?>
              <h3 style="color: black;"><?php echo $jumlah_pelanggan; ?><sup style="font-size: 20px"></sup></h3>
    
                <p style="color: black;">Jumlah Pelanggan</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="datapelanggan.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            
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

<!-- AdminLTE for demo purposes 
<script src="js/demo.js"></script>
-- AdminLTE dashboard demo (This is only for demo purposes) --
<script src="js/pages/dashboard.js"></script> -->

</body>
</html>