<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

// Ambil data di URL, pastikan id_keluhan ada
if(isset($_GET["id_promosi"])) {
    $id = $_GET["id_promosi"];
} else {
    echo "ID keluhan tidak ditemukan!";
    exit;
}

// Query data keluhan berdasarkan id
$prom = query("SELECT * FROM promosi WHERE id_promosi = $id")[0];

// Cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    // Cek apakah ada perubahan data
    $is_changed = false;
    
    // Bandingkan nilai lama dengan nilai baru
    if($prom['mulai_promosi'] != $_POST['mulai_promosi'] ||
       $prom['akhir_promosi'] != $_POST['akhir_promosi'] ||
       $prom['judul'] != $_POST['judul'] ||
       $prom['deskripsi'] != $_POST['deskripsi']) {
        $is_changed = true;
    }
    
    if(!$is_changed) {
        echo "
            <script>
                alert('Tidak ada perubahan data yang dilakukan!');
                document.location.href = '../sales/datapromo.php';
            </script>
        ";
        exit;
    }
    
    // Cek apakah data berhasil diubah atau tidak
    if( ubahpromosi($_POST) > 0 ) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                document.location.href = '../sales/datapromo.php'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal diubah! :(');
                document.location.href = '../sales/ubahpromosi.php'
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
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  <div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Mengubah Data Promosi</h1>
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
                        <!--<input type="hidden" name="id_promosi" value="<?= $prom['id_promosi']; ?>">-->
                        <input type="hidden" name="id_promosi" value="<?= $prom['id_promosi']; ?>">
                        <!--<div class="form-group">
                            <label for="id_promosi">ID Promosi</label>
                            <input type="text" name="id_promosi" id="id_promosi" class="form-control" required value="<?= $prom["id_promosi"]; ?>">
                        </div>-->

                        <div class="form-group">
                            <label for="mulai_promosi">Tanggal Mulai Promosi</label>
                            <input type="date" name="mulai_promosi" id="mulai_promosi" class="form-control" required value="<?= $prom["mulai_promosi"]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="akhir_promosi">Tanggal Akhir Promosi</label>
                            <input type="date" name="akhir_promosi" id="akhir_promosi" class="form-control" required value="<?= $prom["akhir_promosi"]; ?>">
                        </div>


                        <div class="form-group">
                            <label for="judul">Judul Promosi</label>
                            <input type="text" name="judul" id="judul_keluhan" class="form-control" required value="<?= $prom["judul"]; ?>">

                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" required><?= $prom["deskripsi"]; ?></textarea>
                        </div>

                        <a href="datapromo.php" class="btn btn-secondary float-left">Cancel</a>
                        <button type="submit" name="submit" class="btn btn-success float-right">Ubah Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
</div>
</div>

<script src="../public/plugins/jquery/jquery.min.js"></script>
<script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../public/js/adminlte.min.js"></script>
</body>
</html>
