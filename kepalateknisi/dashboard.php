<?php
require '../view/sidebar.php';
require '../includes/functions.php';

// Query untuk mengambil data perbaikan, termasuk nama customer
$query_perbaikan = "SELECT p.*, k.judul_keluhan, t.nama as nama_teknisi, c.nama as nama_customer
          FROM perbaikan p
          LEFT JOIN keluhan k ON p.id_keluhan = k.id_keluhan
          LEFT JOIN teknisi t ON p.id_teknisi = t.id_teknisi
          LEFT JOIN customer c ON k.id_user = c.id_user
          ORDER BY p.waktu_penugasan DESC";
$result_perbaikan = mysqli_query($conn, $query_perbaikan);

// Array untuk menyimpan data perbaikan
$jadwal_perbaikan = [];

// Periksa apakah query berhasil
if ($result_perbaikan) {
    while ($row = mysqli_fetch_assoc($result_perbaikan)) {
        $jadwal_perbaikan[] = $row;
    }
}

// Hitung status perbaikan untuk statistik
$total_perbaikan = count($jadwal_perbaikan);
$pending_perbaikan = 0;
$inprogress_perbaikan = 0;
$completed_perbaikan = 0;

foreach ($jadwal_perbaikan as $row) {
    $status = 'Pending';
    if ($row['waktu_selesai']) {
        $status = 'Completed';
    } else if (strtotime($row['waktu_penugasan']) <= time()) {
        $status = 'In Progress';
    }

    switch (strtolower($status)) {
        case 'pending':
            $pending_perbaikan++;
            break;
        case 'in progress':
            $inprogress_perbaikan++;
            break;
        case 'completed':
            $completed_perbaikan++;
            break;
    }
}

// Query untuk mengambil data keluhan
$keluhan = query("SELECT k.*, c.nama as nama_customer
                 FROM keluhan k
                 LEFT JOIN users u ON k.id_user = u.id_user
                 LEFT JOIN customer c ON k.id_user = c.id_user");

// Hitung status keluhan untuk statistik
$total_keluhan = count($keluhan);
$pending_keluhan = 0;
$proses_keluhan = 0;
$selesai_keluhan = 0;

foreach($keluhan as $k) {
  if($k["status"] == "Pending") {
    $pending_keluhan++;
  } else if ($k["status"] == "Proses") {
    $proses_keluhan++;
  } else if ($k["status"] == "Selesai") {
    $selesai_keluhan++;
  }
}

// Ambil data paket
$jumlah_produk = getJumlahProduk($conn);
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
    /* Styling untuk komponen statistik */
    .stats-box {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 4px;
      color: #333;
      background: #fff;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }
    
    .stats-number {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 5px;
    }
    
    .stats-label {
      font-size: 14px;
      color: #555;
    }
    
    .stats-icon {
      float: right;
      font-size: 28px;
      margin-top: -30px;
      color: rgba(0,0,0,0.15);
    }
    
    /* Styling untuk tabel data */
    .data-table {
      background: #fff;
      border-radius: 4px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
      padding: 15px;
      margin-bottom: 20px;
    }
    
    .data-table h4 {
      margin-top: 0;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
      margin-bottom: 15px;
    }
    
    /* Styling warna untuk status */
    .status-pending {
      background-color: #ffeeba;
      color: #856404;
    }
    
    .status-progress {
      background-color: #b8daff;
      color: #004085;
    }
    
    .status-completed {
      background-color: #c3e6cb;
      color: #155724;
    }
    
    /* Styling untuk dashboard container */
    .dashboard-container {
      padding: 20px;
      background-color: #f8f9fa;
    }
    
    /* Styling untuk grafik */
    .chart-container {
      background: #fff;
      border-radius: 4px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
      padding: 15px;
      margin-bottom: 20px;
    }
    
    .chart-container h4 {
      margin-top: 0;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
      margin-bottom: 15px;
    }
    
    /* Styling khusus untuk tampilan small box yang dipertahankan */
    .small-box {
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      margin-bottom: 20px;
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
        <!-- Ringkasan Statistik -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Ringkasan Statistik</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <!-- Statistik Perbaikan -->
                  <div class="col-md-6">
                    <h5><i class="fas fa-tools mr-2"></i>Statistik Perbaikan</h5>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead class="bg-light">
                          <tr>
                            <th>Status</th>
                            <th width="120">Jumlah</th>
                            <th width="120">Persentase</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- <tr>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td><?= $pending_perbaikan ?></td>
                            <td><?= ($total_perbaikan > 0) ? round(($pending_perbaikan / $total_perbaikan) * 100) : 0 ?>%</td>
                          </tr> -->
                          <tr>
                            <td><span class="badge bg-primary">Diproses</span></td>
                            <td><?= $inprogress_perbaikan ?></td>
                            <td><?= ($total_perbaikan > 0) ? round(($inprogress_perbaikan / $total_perbaikan) * 100) : 0 ?>%</td>
                          </tr>
                          <tr>
                            <td><span class="badge bg-success">Selesai</span></td>
                            <td><?= $completed_perbaikan ?></td>
                            <td><?= ($total_perbaikan > 0) ? round(($completed_perbaikan / $total_perbaikan) * 100) : 0 ?>%</td>
                          </tr>
                          <tr class="font-weight-bold bg-light">
                            <td>Total</td>
                            <td><?= $total_perbaikan ?></td>
                            <td>100%</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <a href="jadwalperbaikan.php" class="btn btn-sm btn-info mt-2">
                      <i class="fas fa-list mr-1"></i> Lihat Daftar Perbaikan
                    </a>
                  </div>
                  
                  <!-- Statistik Keluhan -->
                  <div class="col-md-6">
                    <h5><i class="fas fa-comments mr-2"></i>Statistik Keluhan</h5>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead class="bg-light">
                          <tr>
                            <th>Status</th>
                            <th width="120">Jumlah</th>
                            <th width="120">Persentase</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td><?= $pending_keluhan ?></td>
                            <td><?= ($total_keluhan > 0) ? round(($pending_keluhan / $total_keluhan) * 100) : 0 ?>%</td>
                          </tr>
                          <tr>
                            <td><span class="badge bg-primary">Diproses</span></td>
                            <td><?= $proses_keluhan ?></td>
                            <td><?= ($total_keluhan > 0) ? round(($proses_keluhan / $total_keluhan) * 100) : 0 ?>%</td>
                          </tr>
                          <tr>
                            <td><span class="badge bg-success">Selesai</span></td>
                            <td><?= $selesai_keluhan ?></td>
                            <td><?= ($total_keluhan > 0) ? round(($selesai_keluhan / $total_keluhan) * 100) : 0 ?>%</td>
                          </tr>
                          <tr class="font-weight-bold bg-light">
                            <td>Total</td>
                            <td><?= $total_keluhan ?></td>
                            <td>100%</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <a href="daftarkeluhan.php" class="btn btn-sm btn-info mt-2">
                      <i class="fas fa-list mr-1"></i> Lihat Daftar Keluhan
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Info Paket -->
        <div class="row">
          <div class="col-md-12">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-box-open"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Paket Layanan</span>
                <span class="info-box-number"><?= $jumlah_produk ?></span>
                <div class="mt-2">
                  <a href="../dataproduk/dataproduk.php" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-arrow-right mr-1"></i> Lihat Daftar Paket
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Keluhan Terbaru -->
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Keluhan Terbaru</h3>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Judul</th>
                        <th>Customer</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $keluhan_terbaru = array_slice($keluhan, 0, 5); // Ambil 5 keluhan terbaru
                      foreach($keluhan_terbaru as $k): 
                        $status_class = '';
                        if($k["status"] == "Pending") {
                          $status_class = 'badge-warning';
                        } else if ($k["status"] == "Proses") {
                          $status_class = 'badge-primary';
                        } else if ($k["status"] == "Selesai") {
                          $status_class = 'badge-success';
                        }
                      ?>
                      <tr>
                        <td><?= $k["judul_keluhan"] ?></td>
                        <td><?= $k["nama_customer"] ?></td>
                        <td><span class="badge <?= $status_class ?>"><?= $k["status"] ?></span></td>
                      </tr>
                      <?php endforeach; ?>
                      <?php if(empty($keluhan_terbaru)): ?>
                      <tr>
                        <td colspan="3" class="text-center">Tidak ada data keluhan</td>
                      </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer">
                <a href="daftarkeluhan.php" class="btn btn-sm btn-secondary">Lihat Semua</a>
              </div>
            </div>
          </div>
          
          <!-- Perbaikan Terbaru -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Perbaikan Terbaru</h3>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Keluhan</th>
                        <th>Teknisi</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $perbaikan_terbaru = array_slice($jadwal_perbaikan, 0, 5); // Ambil 5 perbaikan terbaru
                      foreach($perbaikan_terbaru as $p): 
                        $status = 'Pending';
                        $status_class = 'badge-warning';
                        if ($p['waktu_selesai']) {
                          $status = 'Selesai';
                          $status_class = 'badge-success';
                        } else if (strtotime($p['waktu_penugasan']) <= time()) {
                          $status = 'Diproses';
                          $status_class = 'badge-primary';
                        }
                      ?>
                      <tr>
                        <td><?= $p["judul_keluhan"] ?></td>
                        <td><?= $p["nama_teknisi"] ?></td>
                        <td><span class="badge <?= $status_class ?>"><?= $status ?></span></td>
                      </tr>
                      <?php endforeach; ?>
                      <?php if(empty($perbaikan_terbaru)): ?>
                      <tr>
                        <td colspan="3" class="text-center">Tidak ada data perbaikan</td>
                      </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer">
                <a href="jadwalperbaikan.php" class="btn btn-sm btn-secondary">Lihat Semua</a>
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