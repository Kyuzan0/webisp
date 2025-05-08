<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

$users = getdatapelanggan($conn);
$produks = getdataproduk($conn);

// cek apakah tombol submit sudah ditekan
if( isset($_POST["submit"]) ) {
    // cek apakah data pelanggan berhasil ditambahkan
    if( tambahpelanggan($_POST) > 0 ) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'keloladatapelanggan.php'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal ditambahkan! :(');
                document.location.href = 'keloladatapelanggan.php'
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
    <title>WebISP | Tambah Data Pelanggan</title>

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
                        <h1>Menambahkan Pelanggan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Tambah Pelanggan</li>
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
                            <h3 class="card-title">Data Pelanggan</h3>
                        </div>
                        <form action="" method="POST">
                            <div class="card-body"> 
                                
                            <div class="form-group">
                                <label for="id_user">Pilih Pengguna</label>
                                <select id="id_user" name="id_user" class="form-control custom-select" required>
                                    <option selected disabled>Select one</option>
                                    <?php
                                    // Perulangan untuk menampilkan username dalam elemen <select>
                                    foreach ($users as $user) {
                                        echo "<option value='{$user['id_user']}'>{$user['username']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>  
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" required placeholder="Nama">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required placeholder="Email">
                                </div>

                                <div class="form-group">
                                    <label for="no_hp">No HP</label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control" required placeholder="No HP">
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" name="alamat" id="alamat" class="form-control" required placeholder="Alamat">
                                </div>
                                
                            </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Data Produk</h3>
                        </div>
                            <div class="card-body">  
                                <div class="form-group">
                                    <label for="id_produk">Pilih Paket</label>
                                    <select name="id_produk" id="id_produk" class="form-control custom-select">
                                        <option selected disabled>Select one</option>
                                        <?php
                                        // Perulangan untuk menampilkan username dalam elemen <select>
                                        foreach ($produks as $produk) {
                                            echo "<option value='{$produk['id_produk']}'>{$produk['nama_produk']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>    

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control custom-select">
                                        <option selected disabled>Select one</option>
                                        <option>Active</option>
                                        <option>InActive</option>
                                    </select>
                                </div>
                            </div>
                    </div>
                    <a href="../datapelanggan/keloladatapelanggan.php" class="btn btn-secondary float-left">Cancel</a>
                    <button type="submit" name="submit" class="btn btn-success float-right">Tambah Data</button>
                </div>
                <!-- Tombol Submit -->
                
            </form>
        </section>
        <!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside><!-- /.control-sidebar -->
</div><!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
</body>
</html>
