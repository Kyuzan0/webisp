<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

$promo = query("SELECT * FROM promosi"); 
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
  <link rel="stylesheet" href="../public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
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
            <h1>Daftar Promo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Data Promo</li>
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
                <h3 class="card-title">Daftar Promo Yang Berjalan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- <div class="mt-3"> 
                  <button type="button" class="btn btn-success float-right" onclick="window.location.href='tambahproduk.php';">Tambah Data</button>
                </div> -->
                
                <table id="example1" class="table table-bordered table-striped table-responsive">
                </div>
                  <button type="button" class="btn btn-success float-right" onclick="window.location.href='tambahpromo.php';">Tambah Data</button>
                </div>
                  <thead class="thead-dark">
                  <tr>
                    <th>No</th>
                    <th>ID Promosi</th></th>
                    <th>Mulai Promosi</th>
                    <th>Akhir Promosi</th>
                    <th>Judul Promosi</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>

                  <tbody>
                  <?php $i = 1; ?>
                  <?php foreach($promo as $row) : ?>
                  <tr>
                    <td><?= $i;?></td>
                    <td><?= $row["id_promosi"];?></td>
                    <td><?= $row["mulai_promosi"];?></td>
                    <td><?= $row["akhir_promosi"];?></td>
                    <td><?= $row["judul"];?></td>
                    <td><?= $row["deskripsi"];?></td>
                    <td>
                      <a class="btn btn-primary btn-sm" href="ubahpromosi.php?id_promosi=<?= $row["id_promosi"]; ?>">Ubah</a>
                      <a class="btn btn-danger btn-sm" href="hapuspromosi.php?id_promosi=<?= $row["id_promosi"]; ?>" onclick="return confirm('Yakin?');">Hapus</a>
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
