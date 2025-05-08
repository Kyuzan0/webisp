<?php 
require '../includes/functions.php';
require '../view/sidebar.php';


// cek apakah tombol submit sudah ditekan atau belum

if( isset($_POST["submit"]) ) {

    // cek apakah data berhasil ditambahkan atau tidak
    if( tambahuser($_POST) > 0 ) {
        echo "
            <script>
                alert('data berhasil ditambahkan!');
                document.location.href = 'keloladatauser.php'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal ditambahkan! :(');
                document.location.href = 'keloladatauser.php'
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
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
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
            <h1>Menambahkan User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Menambahkan User</li>
            </ol>
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
              <h3 class="card-title">Data User</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>

            <form action="" method="POST">
                <div class="card-body">

                <div class="form-group">
                    <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required placeholder="Email">
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required placeholder="Username">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Password">
                </div>

                <div class="form-group">
                    <label for="level">Level</label>
                        <select name="level" id="level" class="form-control custom-select">
                            <option selected disabled>Select one</option>
                            <option>Admin</option>
                            <option>Supervisor</option>
                            <option>Kepala Teknisi</option>
                            <option>Sales Marketing</option>
                            <option>Teknisi</option>
                            <option>Customer</option>
                        </select>
                </div>
                    <button type="submit" name="submit" class="btn btn-success float-left">Tambah Data</button>
                </div>
            </form>

            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
      </div>
      <div class="row">
        
      </div>
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
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
</body>
</html>
