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
      <div class="container-fluid">
        <div class="row justify-content-center"> <!-- Menambahkan justify-content-center -->
          <div class="col-md-8"> <!-- Mengubah ukuran kolom -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Data User</h3>
              </div>

              <form action="" method="POST">
                <div class="card-body">
                  <input type="hidden" name="id_user" value="<?= $usr['id_user']; ?>">
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                          </div>
                          <input type="email" name="email" id="email" class="form-control" required value="<?= $usr["email"]; ?>">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                          </div>
                          <input type="text" name="username" id="username" class="form-control" required value="<?= $usr["username"]; ?>">
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="level">Level</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-users-cog"></i></span>
                          </div>
                          <select name="level" id="level" class="form-control custom-select" required>
                            <option value="<?= $usr["level"]; ?>" selected><?= $usr["level"]; ?></option>
                            <option value="Admin">Admin</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Kepala Teknisi">Kepala Teknisi</option>
                            <option value="Sales Marketing">Sales Marketing</option>
                            <option value="Teknisi">Teknisi</option>
                            <option value="Customer">Customer</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row mt-4">
                    <div class="col-12">
                      <a href="keloladatauser.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                      </a>
                      <button type="submit" name="submit" class="btn btn-success float-right">
                        <i class="fas fa-save mr-2"></i>Ubah Data
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
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
