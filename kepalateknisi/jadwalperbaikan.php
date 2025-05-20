<?php 
require '../includes/functions.php';
require '../view/sidebar.php';


// Query untuk mengambil data perbaikan
$query = "SELECT p.*, k.judul_keluhan, t.nama as nama_teknisi 
          FROM perbaikan p
          LEFT JOIN keluhan k ON p.id_keluhan = k.id_keluhan
          LEFT JOIN teknisi t ON p.id_teknisi = t.id_teknisi
          ORDER BY p.waktu_penugasan DESC";
$result = mysqli_query($conn, $query);

// Array untuk menyimpan data perbaikan
$jadwal_perbaikan = [];

// Periksa apakah query berhasil
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $jadwal_perbaikan[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WebISP | Jadwal Perbaikan</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
              <li class="breadcrumb-item active">Jadwal Perbaikan</li>
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
                <h3 class="card-title">Daftar Jadwal Perbaikan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Perbaikan</th>
                            <th>Keluhan</th>
                            <th>Teknisi</th>
                            <th>Waktu Penugasan</th>
                            <th>Waktu Selesai</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jadwal_perbaikan as $row): ?>
                        <tr>
                            <td><?= $row['id_perbaikan']; ?></td>
                            <td><?= $row['judul_keluhan']; ?></td>
                            <td><?= $row['nama_teknisi']; ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($row['waktu_penugasan'])); ?></td>
                            <td><?= $row['waktu_selesai'] ? date('d/m/Y H:i', strtotime($row['waktu_selesai'])) : '-'; ?></td>
                            <td><?= $row['deskripsi']; ?></td>
                            <td>
                                <?php 
                                // Tentukan status berdasarkan waktu selesai
                                $status = 'Pending';
                                if ($row['waktu_selesai']) {
                                    $status = 'Completed';
                                } else if (strtotime($row['waktu_penugasan']) <= time()) {
                                    $status = 'In Progress';
                                }
                                ?>
                                <span class="badge badge-<?= getStatusBadgeClass($status); ?>">
                                    <?= $status; ?>
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
<script src="../public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../public/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/js/adminlte.min.js"></script>
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

// Tutup koneksi database
mysqli_close($conn);
?>