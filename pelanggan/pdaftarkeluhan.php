<?php 
require '../includes/init_session.php';
require '../includes/functions.php';
require '../view/sidebar.php';

// Pastikan variabel sesi id_user tersedia
if(isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
    // Filter keluhan berdasarkan id_user yang login
    $cpm = query("SELECT * FROM keluhan WHERE id_user = '$id_user' ORDER BY tanggal_keluhan DESC");
} else {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WebISP | Kelola Data Keluhan</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Sweetalert2 -->
  <link rel="stylesheet" href="../public/plugins/sweetalert2/sweetalert2.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../public/plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
  
  <style>
    .card {
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }
    
    .card:hover {
      transform: translateY(-5px);
    }
    
    .card-header {
      background: linear-gradient(45deg, #3c8dbc, #00c0ef);
      color: white;
      border-radius: 15px 15px 0 0 !important;
    }
    
    .badge-status-pending {
      background-color: #ffc107;
      color: black;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .badge-status-process {
      background-color: #17a2b8;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .badge-status-done {
      background-color: #28a745;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .btn-action {
      border-radius: 20px;
      margin: 2px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      transition: all 0.3s;
    }
    
    .btn-action:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .table-hover tbody tr:hover {
      background-color: rgba(0,123,255,0.1);
    }
    
    .description-cell {
      max-width: 250px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    
    .description-cell:hover {
      white-space: normal;
      overflow: visible;
    }

    .card-title {
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    
    .data-row {
      transition: all 0.2s;
    }
    
    .data-row:hover {
      transform: scale(1.01);
    }
    
    .keluhan-title {
      font-weight: 600;
      color: #3c8dbc;
    }

    .add-button {
      border-radius: 30px;
      box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
      font-weight: 600;
      padding: 10px 20px;
      transition: all 0.15s ease;
    }
    
    .add-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-clipboard-list mr-2"></i>Daftar Keluhan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
              <li class="breadcrumb-item active">Data Keluhan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Keluhan Stats Cards -->
            <div class="row mb-4">
              <div class="col-md-4">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?= count($cpm) ?></h3>
                    <p>Total Keluhan</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-clipboard-list"></i>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="small-box bg-success">
                  <div class="inner">
                    <?php
                    $selesai = 0;
                    foreach($cpm as $p) {
                      if($p["status"] == "Selesai") {
                        $selesai++;
                      }
                    }
                    ?>
                    <h3><?= $selesai ?></h3>
                    <p>Keluhan Selesai</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-check-circle"></i>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <?php
                    $proses = 0;
                    foreach($cpm as $p) {
                      if($p["status"] == "Proses") {
                        $proses++;
                      }
                    }
                    ?>
                    <h3><?= $proses ?></h3>
                    <p>Keluhan Diproses</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-clock"></i>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                  <h3 class="card-title">
                    <i class="fas fa-clipboard-list mr-2"></i>
                    Daftar Keluhan Anda
                  </h3>
                  <button type="button" class="btn btn-success add-button" onclick="window.location.href='pformkeluhan.php';">
                    <i class="fas fa-plus mr-2"></i>Tambah Keluhan
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th width="15%">Tanggal</th>
                    <th width="20%">Judul Keluhan</th>
                    <th width="35%">Deskripsi</th>
                    <th width="10%">Status</th>
                    <th width="15%">Aksi</th>
                  </tr>
                  </thead>

                  <tbody>
                  <?php $i = 1; ?>
                  <?php foreach($cpm as $row) : 
                    switch($row["status"]) {
                      case "Pending":
                        $badge_class = "badge-status-pending";
                        break;
                      case "Proses":
                        $badge_class = "badge-status-process";
                        break;
                      case "Selesai":
                        $badge_class = "badge-status-done";
                        break;
                      default:
                        $badge_class = "badge-secondary";
                    }
                  ?>
                  <tr class="data-row">
                    <td class="text-center"><?= $i;?></td>
                    <td><?= date('d M Y', strtotime($row["tanggal_keluhan"]));?></td>
                    <td class="keluhan-title"><?= htmlspecialchars($row["judul_keluhan"]);?></td>
                    <td class="description-cell"><?= htmlspecialchars($row["deskripsi"]);?></td>
                    <td class="text-center">
                      <span class="badge <?= $badge_class ?>"><?= $row["status"] ?></span>
                    </td>
                    <td class="text-center">
                      <a class="btn btn-danger btn-sm btn-action" href="../keluhan/hapuskeluhan.php?id_keluhan=<?= $row["id_keluhan"]; ?>" onclick="return confirm('Yakin ingin menghapus keluhan ini?');">
                        <i class="fas fa-trash"></i> Hapus
                      </a>
                    </td>
                  </tr>
                  <?php $i++; ?>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
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
<!-- DataTables  & Plugins -->
<script src="../public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../public/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/js/adminlte.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false
    });
  });
</script>
</body>
</html>