<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

//ambil data di url

$id = $_GET["id_user"];

// query data user berdasarkan id
$usr = query("SELECT * FROM users WHERE id_user = $id")[0];

// cek apakah tombol submit sudah ditekan atau belum

if( isset($_POST["submit"]) ) {

    // cek apakah data berhasil ditambahkan atau tidak
    if( ubahuser($_POST) > 0 ) {
        echo "
            <script>
                alert('data berhasil diubah!');
                document.location.href = 'keloladatauser.php'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal diubah! :(');
                document.location.href = 'ubahdatauser.php'
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
                
                <input type="hidden" name="id_user" value="<?= $usr['id_user']; ?>">
                
                <div class="form-group">
                    <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control" required value="<?= $usr["email"]; ?>">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required value="<?= $usr["username"]; ?>">
                </div>

                <div class="form-group">
                    <label for="level">Level</label>
                        
                        <select name="level" id="level" class="form-control custom-select" required> 
                            <option selected disabled><?= $usr["level"]; ?></option>
                            <option>Admin</option>
                            <option>Supervisor</option>
                            <option>Kepala Teknisi</option>
                            <option>Sales Marketing</option>
                            <option>Teknisi</option>
                            <option>Customer</option>
                        </select>
                </div>
                    <button type="submit" name="submit" class="btn btn-success float-left">Ubah Data</button>
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
