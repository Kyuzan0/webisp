<?php 
require '../includes/functions.php';

//ambil data di url
$id = $_GET["id_customer"];

// query data user berdasarkan id
$usr = query("SELECT * FROM customer WHERE id_customer = $id")[0];

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    // cek apakah data berhasil diubah atau tidak
    if( ubah($_POST) > 0 ) {
        echo "
            <script>
                alert('data berhasil diubah!');
                document.location.href = 'keloladatapelanggan.php'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal diubah! :(');
                document.location.href = 'ubahdatapelanggan.php'
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
  <title>WebISP | Kelola Data User</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../public/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="keloladatapelanggan.php" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Back
              </p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mengubah Data Pelanggan</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Data Pelanggan</h3>
            </div>

            <form action="" method="POST">
                <div class="card-body">

                <input type="hidden" name="id_user" value="<?= $usr['id_customer']; ?>">
                
                <!-- inputan -->
                <div class="form-group">
                    <label for="username">ID Customer</label>
                    <input type="text" name="id_customer" id="id_customer" class="form-control" required value="<?= $usr["id_customer"]; ?>">
                </div>

                <div class="form-group">
                    <label for="product_id">ID Produk</label>
                    <input type="text" name="id_produk" id="id_produk" class="form-control" required value="<?= $usr["id_produk"]; ?>">
                </div>

                <div class="form-group">
                    <label for="user_id">ID User</label>
                    <input type="text" name="id_user" id="id_user" class="form-control" required value="<?= $usr["id_user"]; ?>">
                </div>

                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required value="<?= $usr["nama"]; ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control" required value="<?= $usr["email"]; ?>">
                </div>

                <div class="form-group">
                    <label for="phone">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" required value="<?= $usr["no_hp"]; ?>">
                </div>

                <div class="form-group">
                    <label for="address">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" required value="<?= $usr["alamat"]; ?>">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" name="status" id="status" class="form-control" required value="<?= $usr["status"]; ?>">
                </div>

                <!-- button -->
                <button type="submit" name="submit" class="btn btn-success float-left">Ubah Data</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
</body>
</html>
