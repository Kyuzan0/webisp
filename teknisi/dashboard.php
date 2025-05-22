<?php 
require '../view/sidebar.php';
require '../includes/functions.php';

// Dapatkan id teknisi dari session user
$id_user = $_SESSION['id_user'];
$query_teknisi = "SELECT id_teknisi FROM teknisi WHERE id_user = '$id_user'";
$result_teknisi = mysqli_query($conn, $query_teknisi);
$teknisi = mysqli_fetch_assoc($result_teknisi);
$id_teknisi = $teknisi['id_teknisi'];

// Persiapkan data untuk chart
$labels = [];
$completedRepairs = [];

// Loop untuk 7 hari terakhir
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    
    // Format label untuk tampilan
    if ($i == 0) {
        $labels[] = 'Hari ini';
    } else if ($i == 1) {
        $labels[] = 'Kemarin';
    } else {
        $labels[] = $i . ' hari lalu';
    }
    
    // Query untuk menghitung perbaikan selesai pada tanggal tersebut
    $query = "SELECT COUNT(*) as total 
              FROM perbaikan 
              WHERE id_teknisi = '$id_teknisi' 
              AND DATE(waktu_selesai) = '$date'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    $completedRepairs[] = $data['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WebISP | Dashboard Teknisi</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .small-box {
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      transition: transform 0.3s;
      overflow: hidden;
    }
    
    .small-box:hover {
      transform: translateY(-5px);
    }

    .small-box .icon {
      transition: all 0.3s;
      font-size: 70px;
      padding-right: 20px;
      color: rgba(0, 0, 0, 0.15);
    }

    .small-box:hover .icon {
      transform: scale(1.1);
    }

    .small-box .inner {
      padding: 20px;
    }

    .small-box h3 {
      font-size: 38px;
      font-weight: bold;
      margin: 0 0 10px 0;
      white-space: nowrap;
      padding: 0;
      color: #fff;
    }

    .small-box p {
      font-size: 15px;
      margin-bottom: 0;
      color: #fff;
    }

    .small-box .small-box-footer {
      background: rgba(0, 0, 0, 0.1);
      color: rgba(255, 255, 255, 0.8);
      padding: 5px 0;
      text-align: center;
      text-decoration: none;
      transition: all 0.3s;
    }

    .small-box .small-box-footer:hover {
      background: rgba(0, 0, 0, 0.15);
      color: #fff;
    }

    .content-header h1 {
      font-size: 1.8rem;
      margin: 0;
      font-weight: 600;
    }

    .breadcrumb-item a {
      color: #3c8dbc;
    }

    .content-wrapper {
      background: #f4f6f9;
      min-height: 100vh;
      overflow-x: hidden;
      padding-bottom: 20px;
    }

    .container-fluid {
      padding-right: 15px;
      padding-left: 15px;
      margin-right: auto;
      margin-left: auto;
      max-width: 100%;
    }

    .row {
      display: flex;
      flex-wrap: wrap;
      margin-right: -7.5px;
      margin-left: -7.5px;
    }

    .col-lg-3, .col-6 {
      padding-right: 7.5px;
      padding-left: 7.5px;
    }

    @media (max-width: 768px) {
      .content-header h1 {
        font-size: 1.5rem;
      }
      
      .small-box h3 {
        font-size: 30px;
      }

      .small-box .icon {
        font-size: 50px;
      }
    }

    .main-header {
      position: fixed;
      top: 0;
      right: 0;
      left: 0;
      z-index: 1000;
    }

    body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper {
      margin-left: 250px;
    }

    @media (max-width: 991.98px) {
      body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper {
        margin-left: 0;
      }
    }
    
    /* Perbaikan CSS untuk chart */
    .chart-container {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
      margin-bottom: 20px;
    }
    
    .chart-wrapper {
      height: 300px;
      position: relative;
      width: 100%;
    }
    
    .chart-wrapper canvas {
      height: 100% !important;
      width: 100% !important;
    }
    
    .recent-activity {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
      margin-bottom: 20px;
      height: 400px; /* Tinggi sama dengan chart */
      overflow-y: auto; /* Scroll jika konten terlalu panjang */
    }
    
    .activity-item {
      padding: 15px 0;
      border-bottom: 1px solid #f0f0f0;
    }
    
    .activity-item:last-child {
      border-bottom: none;
    }
    
    .timeline {
      position: relative;
      padding: 0;
      margin: 0;
    }
    
    .timeline > div {
      margin-bottom: 15px;
      position: relative;
    }
    
    .timeline > div i.bg-info {
      background-color: #17a2b8 !important;
      color: white;
      width: 30px;
      height: 30px;
      line-height: 30px;
      text-align: center;
      border-radius: 50%;
      position: absolute;
      left: 0;
      top: 0;
    }
    
    .timeline-item {
      margin-left: 45px;
      padding: 10px;
      background: #f8f9fa;
      border-radius: 5px;
      position: relative;
    }
    
    .timeline-header {
      font-size: 16px;
      margin: 0;
      padding: 5px 0;
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
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-tachometer-alt mr-2"></i>Dashboard Teknisi</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Stats Cards Row -->
        <div class="row">
          <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <?php
                $query = "SELECT COUNT(*) as total FROM perbaikan WHERE id_teknisi = '$id_teknisi' AND waktu_selesai IS NULL";
                $result = mysqli_query($conn, $query);
                $data = mysqli_fetch_assoc($result);
                ?>
                <h3><?= $data['total'] ?></h3>
                <p>Perbaikan Aktif</p>
              </div>
              <div class="icon">
                <i class="fas fa-tools"></i>
              </div>
              <a href="jadwalperbaikan.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <?php
                $query = "SELECT COUNT(*) as total FROM perbaikan WHERE id_teknisi = '$id_teknisi' AND waktu_selesai IS NOT NULL";
                $result = mysqli_query($conn, $query);
                $data = mysqli_fetch_assoc($result);
                ?>
                <h3><?= $data['total'] ?></h3>
                <p>Perbaikan Selesai</p>
              </div>
              <div class="icon">
                <i class="fas fa-check-circle"></i>
              </div>
              <a href="laporanperbaikan.php" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <?php
                $query = "SELECT COUNT(*) as total 
                          FROM perbaikan 
                          WHERE id_teknisi = '$id_teknisi' 
                          AND DATE(waktu_selesai) = CURDATE()";
                $result = mysqli_query($conn, $query);
                $data = mysqli_fetch_assoc($result);
                ?>
                <h3><?= $data['total'] ?></h3>
                <p>Selesai Hari Ini</p>
              </div>
              <div class="icon">
                <i class="fas fa-calendar-check"></i>
              </div>
              <a href="#" class="small-box-footer">Info <i class="fas fa-info-circle"></i></a>
            </div>
          </div>
        </div>
        
        <!-- Charts Row -->
        <div class="row">
          <div class="col-md-12">
            <div class="chart-container">
              <h5 class="mb-4">Statistik Perbaikan 7 Hari Terakhir</h5>
              <div class="chart-wrapper">
                <canvas id="repairChart"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- Activity and Timeline Row -->
        <div class="row">
          <div class="col-md-6">
            <div class="recent-activity">
              <h5 class="mb-4">Aktivitas Terbaru</h5>
              <?php
              $query = "SELECT p.*, k.judul_keluhan, c.nama as nama_pelanggan 
                        FROM perbaikan p 
                        JOIN keluhan k ON p.id_keluhan = k.id_keluhan 
                        JOIN customer c ON k.id_user = c.id_user 
                        WHERE p.id_teknisi = '$id_teknisi' 
                        ORDER BY p.waktu_penugasan DESC LIMIT 5";
              $result = mysqli_query($conn, $query);
              while($row = mysqli_fetch_assoc($result)) {
                $status = !empty($row['waktu_selesai']) ? 'Selesai' : 'Dalam Proses';
                $status_class = !empty($row['waktu_selesai']) ? 'text-success' : 'text-warning';
              ?>
              <div class="activity-item">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h6 class="mb-1"><?= $row['judul_keluhan'] ?></h6>
                    <small class="text-muted">Pelanggan: <?= $row['nama_pelanggan'] ?></small>
                  </div>
                  <span class="badge <?= $status_class ?>"><?= $status ?></span>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>

          <div class="col-md-6">
            <div class="recent-activity">
              <h5 class="mb-4">Timeline Perbaikan Hari Ini</h5>
              <div class="timeline">
                <?php
                $query = "SELECT p.*, k.judul_keluhan, c.nama as nama_pelanggan 
                          FROM perbaikan p 
                          JOIN keluhan k ON p.id_keluhan = k.id_keluhan 
                          JOIN customer c ON k.id_user = c.id_user 
                          WHERE p.id_teknisi = '$id_teknisi' 
                          AND DATE(p.waktu_penugasan) = CURDATE() 
                          ORDER BY p.waktu_penugasan DESC";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_assoc($result)) {
                  $waktu = date('H:i', strtotime($row['waktu_penugasan']));
                ?>
                <div>
                  <i class="fas fa-clock bg-info"></i>
                  <div class="timeline-item">
                    <span class="time"><i class="fas fa-clock"></i> <?= $waktu ?></span>
                    <h3 class="timeline-header"><?= $row['judul_keluhan'] ?></h3>
                    <div class="timeline-body">
                      Pelanggan: <?= $row['nama_pelanggan'] ?>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<!-- jQuery -->
<script src="../public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/js/adminlte.min.js"></script>

<!-- Chart Initialization -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Data untuk grafik perbaikan 7 hari terakhir
  const repairCtx = document.getElementById('repairChart');
  
  if (repairCtx) {
    new Chart(repairCtx, {
      type: 'line',
      data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
          label: 'Perbaikan Selesai',
          data: <?php echo json_encode($completedRepairs); ?>,
          borderColor: '#28a745',
          backgroundColor: 'rgba(40, 167, 69, 0.1)',
          tension: 0.1,
          fill: true
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: true,
            position: 'top'
          },
          tooltip: {
            callbacks: {
              title: function(tooltipItems) {
                return tooltipItems[0].label;
              },
              label: function(context) {
                return 'Perbaikan selesai: ' + context.raw + ' perbaikan';
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });
    console.log('Chart initialized');
  } else {
    console.error('Chart canvas not found');
  }
});
</script>
</body>
</html>