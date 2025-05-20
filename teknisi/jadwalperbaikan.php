<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

// Dapatkan id teknisi dari session user
$id_user = $_SESSION['id_user'];
$query_teknisi = "SELECT id_teknisi FROM teknisi WHERE id_user = '$id_user'";
$result_teknisi = mysqli_query($conn, $query_teknisi);
$teknisi = mysqli_fetch_assoc($result_teknisi);
$id_teknisi = $teknisi['id_teknisi'];

// Query untuk mengambil data jadwal perbaikan
$query = "SELECT p.*, k.judul_keluhan, k.deskripsi as deskripsi_keluhan, k.id_user, 
          c.nama as nama_pelanggan 
          FROM perbaikan p 
          JOIN keluhan k ON p.id_keluhan = k.id_keluhan 
          JOIN customer c ON k.id_user = c.id_user 
          WHERE p.id_teknisi = '$id_teknisi' 
          ORDER BY p.waktu_penugasan DESC";
$perbaikan = query($query);
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
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
  <style>
    .badge-status-pending {
      background-color: #ffc107;
      color: black;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .badge-status-proses {
      background-color: #17a2b8;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .badge-status-selesai {
      background-color: #28a745;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
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
            <h1><i class="fas fa-calendar-check mr-2"></i>Jadwal Perbaikan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
              <li class="breadcrumb-item active">Jadwal Perbaikan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php if(isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i> Sukses!</h5>
          Laporan penyelesaian perbaikan berhasil disimpan.
        </div>
        <?php endif; ?>
        
        <?php if(isset($_GET['error']) && $_GET['error'] == 1): ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-ban"></i> Error!</h5>
          Data perbaikan tidak ditemukan atau bukan tanggung jawab Anda.
        </div>
        <?php endif; ?>
        
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Jadwal Perbaikan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Tanggal</th>
                      <th>Jam</th>
                      <th>Nama Pelanggan</th>
                      <th>Judul Keluhan</th>
                      <th>Deskripsi Masalah</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1; ?>
                    <?php foreach($perbaikan as $p): 
                      // Tentukan status dan badge
                      if (!empty($p['waktu_selesai'])) {
                        $status = "Selesai";
                        $badge_class = "badge-status-selesai";
                      } else {
                        $status = "Proses";
                        $badge_class = "badge-status-proses";
                      }
                      
                      // Format waktu
                      $waktu = strtotime($p['waktu_penugasan']);
                    ?>
                    <tr>
                      <td><?= $i; ?></td>
                      <td><?= date('d/m/Y', $waktu) ?></td>
                      <td><?= date('H:i', $waktu) ?></td>
                      <td><?= $p['nama_pelanggan'] ?></td>
                      <td><?= $p['judul_keluhan'] ?></td>
                      <td class="description-cell"><?= $p['deskripsi_keluhan'] ?></td>
                      <td>
                        <span class="<?= $badge_class ?>">
                          <?= $status ?>
                        </span>
                      </td>
                      <td>
                        <?php if($status != "Selesai"): ?>
                        <a href="formlaporanselesai.php?id=<?= $p['id_perbaikan'] ?>" class="btn btn-success btn-sm">
                          <i class="fas fa-check"></i> Laporkan Selesai
                        </a>
                        <?php else: ?>
                        <button class="btn btn-secondary btn-sm" disabled>
                          <i class="fas fa-check-circle"></i> Sudah Selesai
                        </button>
                        <?php endif; ?>
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
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables & Plugins -->
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
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "language": {
        "search": "Cari:",
        "lengthMenu": "Tampilkan _MENU_ data per halaman",
        "zeroRecords": "Tidak ada data yang ditemukan",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "infoEmpty": "Tidak ada data yang ditampilkan",
        "infoFiltered": "(difilter dari _MAX_ total data)",
        "paginate": {
          "first": "Pertama",
          "last": "Terakhir",
          "next": "Selanjutnya",
          "previous": "Sebelumnya"
        }
      }
    });
  });
</script>
</body>
</html>