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

      <!-- Messages Dropdown Menu -->
      
      <!-- Notifications Dropdown Menu -->
      
      
      
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
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <?php $jumlah_produk = getJumlahProduk($conn); ?>
                <h3 style="color: black;"><?php echo $jumlah_produk; ?><sup style="font-size: 20px"></sup></h3>

                <p style="color: black;">Daftar Paket Yang Tersedia</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="../pelanggan/pdataproduk.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 style="color: black;"><?php echo $nama_paket; ?><sup style="font-size: 20px"></sup></h3>
                        <p style="color: black;">Paket Yang Digunakan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="../pelanggan/pdataproduk.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <!-- <div class="small-box bg-success">
              <div class="inner">
              <?php $jumlah_pelanggan = getJumlahPelanggan($conn); ?>
              <h3 style="color: black;"><?php echo $jumlah_pelanggan; ?><sup style="font-size: 20px"></sup></h3>
    
                <p style="color: black;">Jumlah Pelanggan</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="../datapelanggan/keloladatapelanggan.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div> -->
          </div>
          <!-- ./col -->
          <!--
          <div class="col-lg-3 col-6">
            
            <div class="small-box bg-warning">
              <div class="inner">
                <?php $jumlah_user = getJumlahUser($conn); ?>
                <h3 ><?php echo $jumlah_user; ?><sup style="font-size: 20px"></sup></h3>

                <p>Jumlah User</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="../datauser/keloladatauser.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div> -->
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
             <!--
            <div class="small-box bg-danger">
              <div class="inner">
                <?php $jumlah_keluhan = getjumlahkeluhan($conn); ?>
                <h3 style="color: black;"><?php echo $jumlah_keluhan; ?><sup style="font-size: 20px"></sup></h3>

                <p style="color: black;">Jumlah Keluhan</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div> -->
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
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.js"></script>

<!-- AdminLTE for demo purposes 
<script src="js/demo.js"></script>
-- AdminLTE dashboard demo (This is only for demo purposes) --
<script src="js/pages/dashboard.js"></script> -->

</body>
</html>
