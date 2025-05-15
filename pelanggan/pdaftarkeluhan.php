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
<html lang="en">
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
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
  <style>
    .btn-ubah {
      background-color: #007bff;
      color: white;
      display: block;
      width: 100%;
      margin-bottom: 5px;
    }
    
    .btn-hapus {
      background-color: #dc3545;
      color: white;
      display: block;
      width: 100%;
    }
    
    th {
      background-color: #343a40;
      color: white;
    }
    
    .dataTables_wrapper .dataTables_filter {
      float: left;
      margin-right: 10px;
    }
    
    .dataTables_filter input {
      width: 300px;
    }
    
    .dataTables_wrapper .dt-buttons {
      float: right;
    }
    
    .btn-tambah {
      background-color: #28a745;
      color: white;
      float: right;
      margin-bottom: 10px;
    }
    
    th.sorting, th.sorting_asc, th.sorting_desc {
      position: relative;
    }
    
    th.sorting:after, th.sorting_asc:after, th.sorting_desc:after {
      position: absolute;
      right: 8px;
      content: "❯❯";
      transform: rotate(90deg);
      font-size: 10px;
      color: rgba(255,255,255,0.7);
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
            <h1>Daftar Keluhan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
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
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <label>Search: <input type="search" id="searchInput" class="form-control form-control-sm" placeholder=""></label>
                  </div>
                  <button type="button" class="btn btn-tambah" onclick="window.location.href='pformkeluhan.php';">Tambah Data</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped mb-0">
                    <thead>
                      <tr>
                        <th width="2%">No <span class="float-right"></span></th>
                        <!--<th width="10%">ID Customer <span class="float-right"></span></th>-->
                        <th width="10%">Tanggal Keluhan <span class="float-right"></span></th>
                        <th width="10%">Judul Keluhan <span class="float-right"></span></th>
                        <th width="40%">Deskripsi <span class="float-right"></span></th>
                        <th width="5%">Status <span class="float-right"></span></th>
                        <th width="5%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1; ?>
                      <?php foreach($cpm as $row) : ?>
                      <tr>
                        <td><?= $i; ?></td>
                        <!--<td><?= isset($row["id_user"]) ? $row["id_user"] : '-'; ?></td>-->
                        <td><?= $row["tanggal_keluhan"]; ?></td>
                        <td><?= htmlspecialchars($row["judul_keluhan"]); ?></td>
                        <td><?= htmlspecialchars($row["deskripsi"]); ?></td>
                        <td><?= $row["status"]; ?></td>
                        <td>
                          <!--<a class="btn btn-ubah" href="ubahdatakeluhan.php?id_keluhan=<?= $row["id_keluhan"]; ?>"><i class="fas fa-edit"></i> Ubah</a> -->
                          <a class="btn btn-hapus" href="../keluhan/hapuskeluhan.php?id_keluhan=<?= $row["id_keluhan"]; ?>" onclick="return confirm('Yakin ingin menghapus keluhan ini?');"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                      </tr>
                      <?php $i++; ?>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div class="d-flex justify-content-between">
                  <div>
                    Showing 1 to <?= count($cpm) > 8 ? 8 : count($cpm); ?> of <?= count($cpm); ?> entries
                  </div>
                  <div class="pagination">
                    <button class="btn btn-outline-secondary btn-sm mr-1" disabled>Previous</button>
                    <button class="btn btn-primary btn-sm mr-1">1</button>
                    <button class="btn btn-outline-secondary btn-sm">Next</button>
                  </div>
                </div>
              </div>
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
<!-- DataTables & Plugins -->
<script src="../public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/js/adminlte.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    // Inisialisasi DataTable dengan opsi sederhana
    var table = $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "pageLength": 8,
      "searching": true,
      "info": false,
      "paging": false,
      "ordering": true,
      "dom": 'lrtip' // Menyembunyikan search default
    });
    
    // Custom search
    $('#searchInput').keyup(function() {
      table.search($(this).val()).draw();
    });
  });
</script>
</body>
</html>