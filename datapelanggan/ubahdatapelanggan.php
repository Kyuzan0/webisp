<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

//ambil data di url, Check if id_customer is set in the URL before using it
if(isset($_GET["id_customer"])) {
  $id = $_GET["id_customer"];
} else {
  echo "ID customer tidak ditemukan!";
  exit;
}

// query data user berdasarkan id
$usr = query("SELECT * FROM customer WHERE id_customer = $id")[0];

// Query untuk mengambil data produk
$products = query("SELECT * FROM produk");

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    // Cek apakah ada perubahan data
    $ada_perubahan = false;
    
    if($_POST['id_produk'] != $usr['id_produk'] ||
       $_POST['nama'] != $usr['nama'] ||
       $_POST['email'] != $usr['email'] ||
       $_POST['no_hp'] != $usr['no_hp'] ||
       $_POST['alamat'] != $usr['alamat'] ||
       $_POST['status'] != $usr['status']) {
        $ada_perubahan = true;
    }
    
    if(!$ada_perubahan) {
        echo "
            <script>
                alert('Tidak ada perubahan data!');
                document.location.href = 'ubahdatapelanggan.php?id_customer=$id'
            </script>
        ";
    } else {
        // cek apakah data berhasil diubah atau tidak
        if( ubahpelanggan($_POST) > 0 ) {
            echo "
                <script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'keloladatapelanggan.php'
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Data gagal diubah! :(');
                    document.location.href = 'ubahdatapelanggan.php?id_customer=$id'
                </script>
            ";
        }
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
                    <h1>Mengubah Data Pelanggan</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-12">  <!-- Mengubah dari col-md-6 menjadi col-12 -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Pelanggan</h3>
                </div>

                <form action="" method="POST">
                    <div class="card-body">
                        <div class="row">  <!-- Menambahkan row untuk grid system -->
                            <!-- Hidden input untuk menyimpan ID yang asli -->
                            <input type="hidden" name="id_customer" value="<?= $usr['id_customer']; ?>">
                            <input type="hidden" name="id_user" value="<?= $usr['id_user']; ?>">

                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_customer_display">ID Customer</label>
                                    <input type="text" id="id_customer_display" class="form-control" readonly value="<?= $usr["id_customer"]; ?>" style="background-color: #f4f4f4;">
                                </div>

                                <div class="form-group">
                                    <label for="product_id">Nama Produk</label>
                                    <select name="id_produk" id="id_produk" class="form-control custom-select" required>
                                        <option selected disabled>Pilih Produk</option>
                                        <?php foreach($products as $product) : ?>
                                            <option value="<?= $product['id_produk']; ?>" <?= $usr["id_produk"] == $product['id_produk'] ? 'selected' : ''; ?>>
                                                <?= $product['nama_produk']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="id_user_display">ID User</label>
                                    <input type="text" id="id_user_display" class="form-control" readonly value="<?= $usr["id_user"]; ?>" style="background-color: #f4f4f4;">
                                </div>

                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" required value="<?= $usr["nama"]; ?>">
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
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
                                    <select name="status" id="status" class="form-control custom-select" required>
                                        <option selected disabled>Select one</option>
                                        <option value="Active" <?= $usr["status"] == 'Active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="InActive" <?= $usr["status"] == 'InActive' ? 'selected' : ''; ?>>InActive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- button -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" name="submit" class="btn btn-success">Ubah Data</button>
                                <a href="keloladatapelanggan.php" class="btn btn-secondary float-right">Kembali</a>
                            </div>
                        </div>
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
<script src="../public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/js/adminlte.min.js"></script>
</body>
</html>