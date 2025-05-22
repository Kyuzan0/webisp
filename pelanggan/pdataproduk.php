<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

$produk = query("SELECT * FROM produk"); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WebISP | Kelola Data Paket</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Sweetalert2 -->
  <link rel="stylesheet" href="../public/plugins/sweetalert2/sweetalert2.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../public/plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
  
  <style>
    .card {
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }
    
    .card:hover {
      transform: translateY(-5px);
    }
    
    .card-header {
      background: linear-gradient(45deg, #3c8dbc, #00c0ef);
      color: white;
      border-radius: 15px 15px 0 0 !important;
    }
    
    .badge-paket-popular {
      background-color: #28a745;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .badge-paket-normal {
      background-color: #17a2b8;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .badge-paket-premium {
      background-color: #ffc107;
      color: black;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .btn-action {
      border-radius: 20px;
      margin: 2px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      transition: all 0.3s;
    }
    
    .btn-action:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .table-hover tbody tr:hover {
      background-color: rgba(0,123,255,0.1);
    }
    
    .description-cell {
      max-width: 250px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    
    .description-cell:hover {
      white-space: normal;
      overflow: visible;
    }

    .add-button {
      border-radius: 30px;
      box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
      font-weight: 600;
      padding: 10px 20px;
      transition: all 0.15s ease;
    }
    
    .add-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
    }
    
    .add-button i {
      margin-right: 5px;
    }
    
    .card-title {
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    
    .data-row {
      transition: all 0.2s;
    }
    
    .data-row:hover {
      transform: scale(1.01);
    }
    
    .paket-title {
      font-weight: 600;
      color: #3c8dbc;
    }
  </style>
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
            <h1><i class="fas fa-network-wired mr-2"></i>Daftar Paket</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
              <li class="breadcrumb-item active">Daftar Paket</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Paket Stats Cards -->
            <div class="row mb-4">
              <div class="col-md-4">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?= count($produk) ?></h3>
                    <p>Total Paket</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-wifi"></i>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="small-box bg-success">
                  <div class="inner">
                    <?php
                    $popular = 0;
                    foreach($produk as $p) {
                      // Misalnya paket dengan harga di atas 300rb dianggap popular
                      if($p["harga"] > 300000) {
                        $popular++;
                      }
                    }
                    ?>
                    <h3><?= $popular ?></h3>
                    <p>Paket Premium</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-crown"></i>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <?php
                    $basic = 0;
                    foreach($produk as $p) {
                      // Misalnya paket dengan harga di bawah 300rb dianggap basic
                      if($p["harga"] <= 300000) {
                        $basic++;
                      }
                    }
                    ?>
                    <h3><?= $basic ?></h3>
                    <p>Paket Dasar</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-signal"></i>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-wifi mr-2"></i>
                  Daftar Paket Yang Tersedia
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th width="20%">Nama Paket</th>
                    <th width="10%">Kategori</th>
                    <th width="40%">Deskripsi</th>
                    <th width="15%">Harga (Rp.)</th>
                    <th width="10%">Aksi</th>
                  </tr>
                  </thead>

                  <tbody>
                  <?php $i = 1; ?>
                  <?php foreach($produk as $row) : 
                    // Tentukan kategori paket berdasarkan harga
                    if($row["harga"] > 500000) {
                      $kategori = "premium";
                      $kategori_label = "Premium";
                      $badge_class = "badge-paket-premium";
                      $icon = "<i class='fas fa-crown mr-1'></i>";
                    } elseif($row["harga"] > 300000) {
                      $kategori = "popular";
                      $kategori_label = "Popular";
                      $badge_class = "badge-paket-popular";
                      $icon = "<i class='fas fa-star mr-1'></i>";
                    } else {
                      $kategori = "normal";
                      $kategori_label = "Standard";
                      $badge_class = "badge-paket-normal";
                      $icon = "<i class='fas fa-check-circle mr-1'></i>";
                    }
                  ?>
                  <tr class="data-row">
                    <td class="text-center"><?= $i;?></td>
                    <input type="hidden" name="id_produk" value="<?= $row['id_produk']; ?>">
                    <td class="paket-title"><?= $row["nama_produk"];?></td>
                    <td class="text-center">
                      <span class="<?= $badge_class ?>">
                        <?= $icon ?><?= $kategori_label ?>
                      </span>
                    </td>
                    <td class="description-cell"><?= $row["deskripsi"];?></td>
                    <td class="text-right">Rp. <?= number_format($row["harga"], 0, ',', '.');?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-info btn-sm btn-action view-paket" data-id="<?= $row["id_produk"]; ?>" data-toggle="tooltip" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                      </button>
                    </td>
                  </tr>
                  <?php $i++; ?>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Detail Modal -->
  <!-- Detail Modal -->
  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4 class="modal-title"><i class="fas fa-info-circle mr-2"></i>Detail Paket</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-4">
            <i class="fas fa-box-open fa-4x text-info mb-3"></i>
          </div>
          <table class="table table-striped">
            <tr>
              <th><i class="fas fa-hashtag mr-2"></i>ID Produk</th>
              <td id="detail-id"></td>
            </tr>
            <tr>
              <th><i class="fas fa-tag mr-2"></i>Nama Paket</th>
              <td id="detail-nama"></td>
            </tr>
            <tr>
              <th><i class="fas fa-money-bill-wave mr-2"></i>Harga</th>
              <td id="detail-harga"></td>
            </tr>
            <tr>
              <th><i class="fas fa-layer-group mr-2"></i>Kategori</th>
              <td id="detail-kategori"></td>
            </tr>
            <tr>
              <th><i class="fas fa-align-left mr-2"></i>Deskripsi</th>
              <td id="detail-deskripsi"></td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-2"></i>Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <!-- /.modal -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../public/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../public/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<!-- SweetAlert2 -->
<script src="../public/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../public/plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/js/adminlte.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    // DataTable initialization with responsive
    $("#example1").DataTable({
      "responsive": true, 
      "lengthChange": true, 
      "autoWidth": false,
      "pageLength": 10,
      "drawCallback": function(settings) {
        // Rebind click events after table redraw
        $('.view-paket').off('click').on('click', function() {
          const id = $(this).data('id');
          let paketData = null;
          
          <?php foreach($produk as $row): ?>
          if(<?= json_encode($row["id_produk"]); ?> == id) {
            paketData = {
              id: <?= json_encode($row["id_produk"]); ?>,
              nama: <?= json_encode($row["nama_produk"]); ?>,
              harga: <?= $row["harga"]; ?>,
              deskripsi: <?= json_encode($row["deskripsi"]); ?>
            };
            
            // Tentukan kategori
            if(paketData.harga > 500000) {
              paketData.kategori = '<span class="badge-paket-premium"><i class="fas fa-crown mr-1"></i> Premium</span>';
            } else if(paketData.harga > 300000) {
              paketData.kategori = '<span class="badge-paket-popular"><i class="fas fa-star mr-1"></i> Popular</span>';
            } else {
              paketData.kategori = '<span class="badge-paket-normal"><i class="fas fa-check-circle mr-1"></i> Standard</span>';
            }
          }
          <?php endforeach; ?>
          
          if(paketData) {
            $('#detail-id').text(paketData.id);
            $('#detail-nama').text(paketData.nama);
            $('#detail-harga').text('Rp. ' + paketData.harga.toLocaleString('id-ID'));
            $('#detail-kategori').html(paketData.kategori);
            $('#detail-deskripsi').text(paketData.deskripsi);
            
            $('#modal-detail').modal('show');
          }
        });
      },
      "language": {
        "search": "Cari:",
        "lengthMenu": "Tampilkan _MENU_ data per halaman",
        "zeroRecords": "Tidak ada data yang ditemukan",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "infoEmpty": "Tidak ada data yang ditampilkan",
        "infoFiltered": "(difilter dari _MAX_ total data)",
        "paginate": {
          "first": "Pertama",
          "last": "Terakhir",
          "next": "Selanjutnya",
          "previous": "Sebelumnya"
        }
      }
    });
    
    // Enable tooltips
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
</body>
</html>
