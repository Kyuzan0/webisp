<?php 
require '../includes/functions.php';

// Ambil data di URL, pastikan id_keluhan ada
if(isset($_GET["id_keluhan"])) {
    $id = $_GET["id_keluhan"];
} else {
    echo "ID keluhan tidak ditemukan!";
    exit;
}

// Query data keluhan berdasarkan id
$kel = query("SELECT * FROM keluhan WHERE id_keluhan = $id")[0];

// Cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    // Cek apakah data berhasil diubah atau tidak
    if( ubahkeluhan($_POST) > 0 ) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                document.location.href = 'daftarkeluhan.php'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal diubah! :(');
                document.location.href = 'ubahkeluhan.php'
            </script>
        ";
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WebISP | Ubah Data Pelanggan</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../public/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="daftarkeluhan.php" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>Back</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Mengubah Data Pelanggan</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Pelanggan</h3>
                </div>

                <form action="" method="POST">
                    <div class="card-body">
                        <input type="hidden" name="id_keluhan" value="<?= $kel['id_keluhan']; ?>">

                        <div class="form-group">
                            <label for="username">ID Customer</label>
                            <input type="text" name="id_customer" id="id_customer" class="form-control" required value="<?= $kel["id_customer"]; ?>">
                        </div>

                        <div class="form-group">
                            <label for="tanggal_keluhan">Tanggal Keluhan</label>
                            <input type="text" name="tanggal_keluhan" id="tanggal_keluhan" class="form-control" required value="<?= $kel["tanggal_keluhan"]; ?>">
                        </div>

                        <div class="form-group">
                            <label for="judul_keluhan">Judul Keluhan</label>
                            <input type="text" name="judul_keluhan" id="judul_keluhan" class="form-control" required value="<?= $kel["judul_keluhan"]; ?>">
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" required><?= $kel["deskripsi"]; ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="level" class="form-control custom-select">
                                        <option selected disabled>Select one</option>
                                        <option>Proses</option>
                                        <option>Selesai</option>
                                        <option>Batal</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <a href="daftarkeluhan.php" class="btn btn-secondary float-left">Cancel</a>
                        <button type="submit" name="submit" class="btn btn-success float-right">Ubah Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
</div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="js/adminlte.min.js"></script>
</body>
</html>
