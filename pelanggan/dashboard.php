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

// Update query to use promosi table instead of banner_promo
$query_banner = "SELECT gambar_path, judul, deskripsi 
                FROM promosi 
                WHERE CURDATE() BETWEEN mulai_promosi AND akhir_promosi
                ORDER BY id_promosi DESC";

$result_banner = mysqli_query($conn, $query_banner);
$banners = [];

// Ambil semua promosi aktif
while($row = mysqli_fetch_assoc($result_banner)) {
    $banners[] = $row;
}

$result = mysqli_query($conn, $query);

// Default paket jika tidak ditemukan
$nama_paket = "Tidak ada paket";

// Jika data ditemukan, ambil nama produk
if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $nama_paket = $row['nama_produk'];
}

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
  margin-left: 0;
  /* Hapus transition CSS, gunakan jQuery animate */
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
  transform: translateY(-50%) scale(1.05);
}

.banner-nav.prev {
  left: 20px;
}

.banner-nav.next {
  right: 20px;
}

/* Responsive styles untuk banner */
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
  
  .banner-container {
    height: 150px;
  }
}

@media (max-width: 576px) {
  .banner-container {
    height: 120px;
  }
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
      background: rgba(0,0,0,0.2);
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
            <h1 class="m-0">Dashboard Pelanggan</h1>
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
            <div class="banner-container" onclick="window.open('http://wa.me/+6281214878902', '_blank')" style="cursor: pointer;">
              <button class="banner-nav prev" onclick="changeBanner(-1); event.stopPropagation();"><i class="fas fa-chevron-left"></i></button>
              <button class="banner-nav next" onclick="changeBanner(1); event.stopPropagation();"><i class="fas fa-chevron-right"></i></button>
              <div id="bannerWrapper" class="banner-wrapper">
                <!-- Initial images - will be updated by script -->
                <img src="" alt="Banner PT Sinar Komunikasi Nusantara" class="banner-image">
                <img src="" alt="Banner PT Sinar Komunikasi Nusantara" class="banner-image">
              </div>
            </div>
          </div>
        </div>
        
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
              <a href="../pelanggan/pdataproduk.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-md-4 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $nama_paket; ?></h3>

                <p>Paket Yang Digunakan</p>
              </div>
              <div class="icon">
                <i class="fas fa-wifi"></i>
              </div>
              <a href="../pelanggan/pkelolapaket.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
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
              <a href="../pelanggan/pdatapromo.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
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
                  <div class="col-md-6 col-sm-6 col-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-primary"><i class="fas fa-wifi"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">Info Paket</span>
                        <a href="../pelanggan/pdataproduk.php" class="text-sm">Lihat detail paket &nbsp;<i class="fas fa-arrow-right"></i></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-warning"><i class="fas fa-tags"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">Promo Terbaru</span>
                        <a href="../pelanggan/pdatapromo.php" class="text-sm">Lihat penawaran khusus &nbsp;<i class="fas fa-arrow-right"></i></a>
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

<!-- Script untuk rotasi banner dengan transisi slide -->
<script>
  $(document).ready(function() {
    // Banner dari database PHP
    $('[data-widget="pushmenu"]').on('click', function(e) {
        e.preventDefault();
        if ($('body').hasClass('sidebar-collapse')) {
            $('body').removeClass('sidebar-collapse');
        } else {
            $('body').addClass('sidebar-collapse');
        }
    });

    const banners = [
      <?php 
      if(!empty($banners)) {
          foreach($banners as $index => $banner) {
              echo "'../uploads/promosi/" . $banner['gambar_path'] . "'";
              if($index < count($banners) - 1) echo ",";
          } 
      } else {
          // Fallback ke banner default jika tidak ada banner dari database
          echo "'../img/banner1.png', '../img/banner2.png'";
      }
      ?>
    ];
    
    if (banners.length === 0) {
        $(".banner-container").hide();
        return;
    }

    // Jika hanya 1 banner, sembunyikan navigasi
    if (banners.length === 1) {
        $(".banner-nav").hide();
        return;
    }

    const $wrapper = $("#bannerWrapper");
    const $images = $wrapper.find(".banner-image");
    
    let currentBannerIndex = 0;
    let intervalId;
    let isTransitioning = false;

    // Set initial image
    $images.eq(0).attr("src", banners[0]);
    $images.eq(1).attr("src", banners[1] || banners[0]);

    function changeBanner(direction) {
        if (isTransitioning || banners.length <= 1) return;
        
        isTransitioning = true;
        clearInterval(intervalId);

        const totalBanners = banners.length;
        let nextIndex;

        if (direction === 1) {
            // Next banner (slide left)
            nextIndex = (currentBannerIndex + 1) % totalBanners;
            $images.eq(1).attr("src", banners[nextIndex]);
            
            $wrapper.animate({
                marginLeft: '-50%'
            }, 600, 'swing', function() {
                // Setelah animasi selesai
                $images.eq(0).attr("src", banners[nextIndex]);
                $wrapper.css('margin-left', '0');
                currentBannerIndex = nextIndex;
                
                // Set gambar berikutnya untuk transisi selanjutnya
                const nextNextIndex = (nextIndex + 1) % totalBanners;
                $images.eq(1).attr("src", banners[nextNextIndex]);
                
                isTransitioning = false;
                startAutoRotation();
            });
        } else {
            // Previous banner (slide right)
            nextIndex = (currentBannerIndex - 1 + totalBanners) % totalBanners;
            
            // Set gambar sebelumnya di posisi kiri
            $wrapper.css('margin-left', '-50%');
            $images.eq(0).attr("src", banners[nextIndex]);
            
            // Animate ke posisi normal
            $wrapper.animate({
                marginLeft: '0'
            }, 600, 'swing', function() {
                currentBannerIndex = nextIndex;
                
                // Set gambar berikutnya
                const nextNextIndex = (nextIndex + 1) % totalBanners;
                $images.eq(1).attr("src", banners[nextNextIndex]);
                
                isTransitioning = false;
                startAutoRotation();
            });
        }
    }
    
    function startAutoRotation() {
        if (banners.length <= 1) return;
        clearInterval(intervalId);
        intervalId = setInterval(() => {
            if (!isTransitioning) {
                changeBanner(1);
            }
        }, 4000); // 4 detik per banner
    }
    
    // Start auto rotation
    if (banners.length > 1) {
        startAutoRotation();
    }
    
    // Stop auto rotation on hover
    $(".banner-container").hover(
        function() {
            clearInterval(intervalId);
        },
        function() {
            if (banners.length > 1 && !isTransitioning) {
                startAutoRotation();
            }
        }
    );
    
    window.changeBanner = changeBanner;
});
</script>

</body>
</html>