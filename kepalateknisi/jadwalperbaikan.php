<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

// Data dummy untuk jadwal perbaikan
$jadwal_dummy = [
    [
        'id_perbaikan' => 'PB001',
        'id_keluhan' => 'KL001',
        'id_teknisi' => 'TK001',
        'waktu_penugasan' => '2024-01-15 09:00:00',
        'waktu_selesai' => '2024-01-15 11:30:00',
        'deskripsi' => 'Perbaikan koneksi internet putus-putus',
        'status' => 'Completed'
    ],
    [
        'id_perbaikan' => 'PB002',
        'id_keluhan' => 'KL002',
        'id_teknisi' => 'TK002',
        'waktu_penugasan' => '2024-01-16 10:00:00',
        'waktu_selesai' => null,
        'deskripsi' => 'Pemasangan internet baru',
        'status' => 'In Progress'
    ],
    [
        'id_perbaikan' => 'PB003',
        'id_keluhan' => 'KL003',
        'id_teknisi' => 'TK001',
        'waktu_penugasan' => '2024-01-17 13:00:00',
        'waktu_selesai' => null,
        'deskripsi' => 'Pengecekan router bermasalah',
        'status' => 'Pending'
    ]
];
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WebISP | Kelola Data Promo</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Jadwal Perbaikan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Komplain</li>
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
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Perbaikan</th>
                            <th>ID Keluhan</th>
                            <th>ID Teknisi</th>
                            <th>Waktu Penugasan</th>
                            <th>Waktu Selesai</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jadwal_dummy as $row): ?>
                        <tr>
                            <td><?= $row['id_perbaikan']; ?></td>
                            <td><?= $row['id_keluhan']; ?></td>
                            <td><?= $row['id_teknisi']; ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($row['waktu_penugasan'])); ?></td>
                            <td><?= $row['waktu_selesai'] ? date('d/m/Y H:i', strtotime($row['waktu_selesai'])) : '-'; ?></td>
                            <td><?= $row['deskripsi']; ?></td>
                            <td>
                                <span class="badge badge-<?= getStatusBadgeClass($row['status']); ?>">
                                    <?= $row['status']; ?>
                                </span>
                            </td>
                        </tr>
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
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
</body>
</html>

<?php
// Fungsi untuk menentukan class badge berdasarkan status
function getStatusBadgeClass($status) {
    switch(strtolower($status)) {
        case 'pending':
            return 'warning';
        case 'in progress':
            return 'info';
        case 'completed':
            return 'success';
        case 'cancelled':
            return 'danger';
        default:
            return 'secondary';
    }
}
?>