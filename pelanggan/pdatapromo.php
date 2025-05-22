<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

$promo = query("SELECT * FROM promosi"); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WebISP | Kelola Data Promo</title>

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
    
    .badge-promo-active {
      background-color: #28a745;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .badge-promo-expired {
      background-color: #dc3545;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .badge-promo-upcoming {
      background-color: #ffc107;
      color: black;
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
    
    .promo-title {
      font-weight: 600;
      color: #3c8dbc;
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
            <h1><i class="fas fa-tags mr-2"></i>Daftar Promo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
              <li class="breadcrumb-item active">Daftar Promo</li>
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
            <!-- Promo Stats Cards -->
            <div class="row mb-4">
              <div class="col-md-4">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?= count($promo) ?></h3>
                    <p>Total Promo</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-percentage"></i>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="small-box bg-success">
                  <div class="inner">
                    <?php
                    $active = 0;
                    $today = date('Y-m-d');
                    foreach($promo as $p) {
                      if($p["mulai_promosi"] <= $today && $p["akhir_promosi"] >= $today) {
                        $active++;
                      }
                    }
                    ?>
                    <h3><?= $active ?></h3>
                    <p>Promo Aktif</p>
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
                    $upcoming = 0;
                    foreach($promo as $p) {
                      if($p["mulai_promosi"] > $today) {
                        $upcoming++;
                      }
                    }
                    ?>
                    <h3><?= $upcoming ?></h3>
                    <p>Promo Mendatang</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-clock"></i>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-tags mr-2"></i>
                  Daftar Promo Yang Tersedia
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th width="20%">Mulai Promosi</th>
                    <th width="20%">Akhir Promosi</th>
                    <th width="25%">Judul Promosi</th>
                    <th width="20%">Deskripsi</th>
                    <th width="10%">Status</th>
                  </tr>
                  </thead>

                  <tbody>
                  <?php $i = 1; ?>
                  <?php foreach($promo as $row) : 
                    $today = date('Y-m-d');
                    if($row["mulai_promosi"] <= $today && $row["akhir_promosi"] >= $today) {
                      $status = "active";
                      $status_label = "Aktif";
                      $badge_class = "badge-promo-active";
                    } elseif($row["mulai_promosi"] > $today) {
                      $status = "upcoming";
                      $status_label = "Mendatang";
                      $badge_class = "badge-promo-upcoming";
                    } else {
                      $status = "expired";
                      $status_label = "Berakhir";
                      $badge_class = "badge-promo-expired";
                    }
                  ?>
                  <tr class="data-row">
                    <td class="text-center"><?= $i;?></td>
                    <input type="hidden" name="id_promosi" value="<?= $row["id_promosi"] ?>">
                    <td><?= date('d M Y', strtotime($row["mulai_promosi"]));?></td>
                    <td><?= date('d M Y', strtotime($row["akhir_promosi"]));?></td>
                    <td class="promo-title"><?= $row["judul"];?></td>
                    <td class="description-cell"><?= $row["deskripsi"];?></td>
                    <td class="text-center">
                      <span class="badge <?= $badge_class ?>"><?= $status_label ?></span>
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
