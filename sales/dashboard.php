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
  
  <!-- Tambahan CSS untuk banner promo carousel -->
  <style>
    .carousel-container {
      position: relative;
      margin-bottom: 20px;
      overflow: hidden;
      border-radius: 5px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .promo-banner {
      display: none;
      padding: 20px;
      color: white;
      position: relative;
    }
    
    .promo-banner.active {
      display: block;
      animation: fadeIn 0.5s ease-in;
    }
    
    .promo-banner:nth-child(1) {
      background: linear-gradient(135deg, #4e73df 0%, #36b9cc 100%);
    }
    
    .promo-banner:nth-child(2) {
      background: linear-gradient(135deg, #1cc88a 0%, #36b9cc 100%);
    }
    
    .promo-banner:nth-child(3) {
      background: linear-gradient(135deg, #f6c23e 0%, #e74a3b 100%);
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
    
    .carousel-indicators {
      position: absolute;
      bottom: 10px;
      left: 0;
      right: 0;
      text-align: center;
      z-index: 10;
    }
    
    .carousel-indicator {
      display: inline-block;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background-color: rgba(255, 255, 255, 0.5);
      margin: 0 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    
    .carousel-indicator.active {
      background-color: white;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    
    .promo-banner .btn-blue {
      color: #4e73df;
    }
    
    .promo-banner .btn-green {
      color: #1cc88a;
    }
    
    .promo-banner .btn-orange {
      color: #f6c23e;
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
        
        <!-- Banner Promo Carousel -->
        <div class="row">
          <div class="col-12">
            <div class="carousel-container">
              <!-- Banner 1 -->
              <div class="promo-banner active">
                <div class="promo-icon">
                  <i class="fas fa-bullhorn"></i>
                </div>
                <h2>Promo Spesial Bulan Ini!</h2>
                <p>Dapatkan diskon hingga 25% untuk semua paket internet premium. Penawaran terbatas sampai akhir bulan.</p>
                <a href="../sales/datapromo.php" class="btn btn-blue">Lihat Detail Promo</a>
              </div>
              
              <!-- Banner 2 -->
              <div class="promo-banner">
                <div class="promo-icon">
                  <i class="fas fa-wifi"></i>
                </div>
                <h2>Paket Keluarga Hemat</h2>
                <p>Internet super cepat dengan bonus streaming premium untuk seluruh keluarga. Dapatkan cashback 10%!</p>
                <a href="../sales/datapromo.php" class="btn btn-green">Pesan Sekarang</a>
              </div>
              
              <!-- Banner 3 -->
              <div class="promo-banner">
                <div class="promo-icon">
                  <i class="fas fa-gift"></i>
                </div>
                <h2>Referral Program</h2>
                <p>Ajak teman Anda berlangganan dan dapatkan reward untuk setiap pelanggan baru. Kesempatan terbatas!</p>
                <a href="../sales/datapromo.php" class="btn btn-orange">Ikut Program</a>
              </div>
              
              <!-- Carousel Indicators -->
              <div class="carousel-indicators">
                <span class="carousel-indicator active" data-slide="0"></span>
                <span class="carousel-indicator" data-slide="1"></span>
                <span class="carousel-indicator" data-slide="2"></span>
              </div>
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

<!-- Script untuk carousel banner -->
<script>
  $(document).ready(function() {
    // Variabel untuk slide aktif dan interval
    let activeSlide = 0;
    const totalSlides = $('.promo-banner').length;
    let slideInterval;
    
    // Fungsi untuk mengganti slide
    function changeSlide(index) {
      // Menghapus kelas active dari semua slide
      $('.promo-banner').removeClass('active');
      $('.carousel-indicator').removeClass('active');
      
      // Menambahkan kelas active ke slide yang dipilih
      $('.promo-banner').eq(index).addClass('active');
      $('.carousel-indicator').eq(index).addClass('active');
      
      // Update index slide aktif
      activeSlide = index;
    }
    
    // Fungsi untuk slide otomatis
    function startSlideShow() {
      slideInterval = setInterval(function() {
        let nextSlide = (activeSlide + 1) % totalSlides;
        changeSlide(nextSlide);
      }, 5000); // Ganti slide setiap 5 detik
    }
    
    // Memulai slide otomatis
    startSlideShow();
    
    // Event listener untuk indikator
    $('.carousel-indicator').click(function() {
      let slideIndex = $(this).data('slide');
      
      // Hentikan interval slide otomatis
      clearInterval(slideInterval);
      
      // Ganti slide
      changeSlide(slideIndex);
      
      // Mulai kembali slide otomatis
      startSlideShow();
    });
  });
</script>

</body>
</html>