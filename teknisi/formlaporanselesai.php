
<?php 
ob_start(); // Mulai output buffering
require '../includes/init_session.php';
require '../includes/functions.php';
require '../view/sidebar.php';


// Dapatkan id teknisi dari session user
$id_user = $_SESSION['id_user'];
$query_teknisi = "SELECT id_teknisi FROM teknisi WHERE id_user = '$id_user'";
$result_teknisi = mysqli_query($conn, $query_teknisi);
$teknisi = mysqli_fetch_assoc($result_teknisi);
$id_teknisi = $teknisi['id_teknisi'];

// Ambil ID perbaikan jika ada di parameter URL
$id_perbaikan = isset($_GET['id']) ? $_GET['id'] : 0;

// Jika form laporan disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_perbaikan = $_POST['id_perbaikan'];
    $deskripsi_laporan = $_POST['deskripsi_laporan'];
    $waktu_selesai = date('Y-m-d H:i:s'); // Waktu saat ini
    
    // Update tabel perbaikan
    $query_update = "UPDATE perbaikan SET 
                    waktu_selesai = '$waktu_selesai', 
                    deskripsi = CONCAT(deskripsi, '\n\nLAPORAN SELESAI: ', '$deskripsi_laporan') 
                    WHERE id_perbaikan = '$id_perbaikan' AND id_teknisi = '$id_teknisi'";
    
    $result_update = mysqli_query($conn, $query_update);
    
    // Dapatkan id_keluhan dari perbaikan
    $query_keluhan = "SELECT id_keluhan FROM perbaikan WHERE id_perbaikan = '$id_perbaikan'";
    $result_keluhan = mysqli_query($conn, $query_keluhan);
    $keluhan_data = mysqli_fetch_assoc($result_keluhan);
    $id_keluhan = $keluhan_data['id_keluhan'];
    
    // Update status keluhan menjadi selesai
    $query_keluhan_update = "UPDATE keluhan SET status = 'Selesai' WHERE id_keluhan = '$id_keluhan'";
    $result_keluhan_update = mysqli_query($conn, $query_keluhan_update);
    
    if ($result_update && $result_keluhan_update) {
        ob_end_clean(); // Bersihkan buffer sebelum redirect
        // Redirect ke halaman jadwal perbaikan dengan pesan sukses
        header("Location: jadwalperbaikan.php?success=1");
        exit;
    } else {
        $error = "Gagal memperbarui data: " . mysqli_error($conn);
    }
}

// Ambil data perbaikan berdasarkan ID
if ($id_perbaikan > 0) {
    $query = "SELECT p.*, k.judul_keluhan, k.deskripsi as deskripsi_keluhan 
              FROM perbaikan p
              LEFT JOIN keluhan k ON p.id_keluhan = k.id_keluhan
              WHERE p.id_perbaikan = '$id_perbaikan' AND p.id_teknisi = '$id_teknisi'";
    
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $perbaikan = mysqli_fetch_assoc($result);
    } else {
        ob_end_clean(); // Bersihkan buffer sebelum redirect
        header("Location: jadwalperbaikan.php?error=1");
        exit;
    }
} else {
    ob_end_clean(); // Bersihkan buffer sebelum redirect
    header("Location: jadwalperbaikan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WebISP | Laporan Perbaikan</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
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
            <h1>Laporan Penyelesaian Perbaikan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="daftar_perbaikan_teknisi.php">Daftar Perbaikan</a></li>
              <li class="breadcrumb-item active">Laporan Penyelesaian</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Laporan Penyelesaian Perbaikan</h3>
              </div>
              <!-- /.card-header -->
              
              <?php if (isset($error)): ?>
              <div class="alert alert-danger m-3">
                <?= $error; ?>
              </div>
              <?php endif; ?>
              
              <!-- form start -->
              <form method="post" action="">
                <div class="card-body">
                  <input type="hidden" name="id_perbaikan" value="<?= $perbaikan['id_perbaikan']; ?>">
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>ID Perbaikan</label>
                        <input type="text" class="form-control" value="<?= $perbaikan['id_perbaikan']; ?>" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Waktu Penugasan</label>
                        <input type="text" class="form-control" value="<?= date('d/m/Y H:i', strtotime($perbaikan['waktu_penugasan'])); ?>" readonly>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label>Judul Keluhan</label>
                    <input type="text" class="form-control" value="<?= $perbaikan['judul_keluhan']; ?>" readonly>
                  </div>
                  
                  <div class="form-group">
                    <label>Deskripsi Keluhan</label>
                    <textarea class="form-control" rows="3" readonly><?= $perbaikan['deskripsi_keluhan']; ?></textarea>
                  </div>
                  
                  <div class="form-group">
                    <label>Instruksi Perbaikan</label>
                    <textarea class="form-control" rows="3" readonly><?= $perbaikan['deskripsi']; ?></textarea>
                  </div>
                  
                  <div class="form-group">
                    <label for="deskripsi_laporan">Laporan Penyelesaian <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="deskripsi_laporan" name="deskripsi_laporan" rows="5" placeholder="Masukkan detail perbaikan yang telah dilakukan dan hasil penyelesaian" required></textarea>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Laporkan Selesai</button>
                  <a href="daftar_perbaikan_teknisi.php" class="btn btn-secondary">Kembali</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
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
<!-- AdminLTE App -->
<script src="../public/js/adminlte.min.js"></script>
</body>
</html>