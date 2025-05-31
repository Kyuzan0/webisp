<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

//ambil data di url, Check if id_customer is set in the URL before using it
if(isset($_GET["id_produk"])) {
  $id = $_GET["id_produk"];
} else {
  echo "ID customer tidak ditemukan!";
  exit;
}

// query data user berdasarkan id
$produ = query("SELECT * FROM produk WHERE id_produk = $id")[0];

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    // Cek apakah ada perubahan data
    $is_changed = false;
    
    // Bandingkan nilai lama dengan nilai baru
    if($produ['nama_produk'] != $_POST['nama_produk'] ||
       $produ['deskripsi'] != $_POST['deskripsi'] ||
       $produ['harga'] != $_POST['harga']) {
        $is_changed = true;
    }
    
    if(!$is_changed) {
        echo "
            <script>
                alert('Tidak ada perubahan data yang dilakukan!');
                document.location.href = 'dataproduk.php';
            </script>
        ";
        exit;
    }
    
    // cek apakah data berhasil diubah atau tidak
    if( ubahpaket($_POST) > 0 ) {
        echo "
            <script>
                alert('data berhasil diubah!');
                document.location.href = 'dataproduk.php'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal diubah! :(');
                document.location.href = 'ubahdataproduk.php'
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
                    <h1>Ubah Data Paket</h1>
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
                    <h3 class="card-title">Data Paket</h3>
                </div>

                <form action="" method="POST">
                    <div class="card-body">
                        <input type="hidden" name="id_produk" value="<?= $produ['id_produk']; ?>">

                        <!-- inputan -->
                        <div class="form-group">
                            <label for="product_id">ID Produk</label>
                            <input type="text" id="id_produk" class="form-control" value="<?= $produ["id_produk"]; ?>" readonly disabled>
                        </div>

                        <div class="form-group">
                            <label for="nama_produk">Nama Paket</label>
                            <input type="text" name="nama_produk" id="nama_produk" class="form-control" required value="<?= $produ["nama_produk"]; ?>">
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" name="deskripsi" id="deskripsi" class="form-control" required value="<?= $produ["deskripsi"]; ?>">
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga (Rp.)</label>
                            <input type="text" name="harga" id="harga" class="form-control" required value="<?= $produ["harga"]; ?>">
                        </div>

                        <!-- button -->
                        <a href="dataproduk.php" class="btn btn-secondary float-left">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" name="submit" class="btn btn-success float-right">Ubah Data</button>

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
