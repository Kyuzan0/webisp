<?php 
require '../includes/functions.php';
require '../view/sidebar.php';
$plggn = query("SELECT c.*, p.nama_produk 
                FROM customer c
                LEFT JOIN produk p ON c.id_produk = p.id_produk");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WebISP | Kelola Data Pelanggan</title>

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
    
    .badge-status-active {
      background-color: #28a745;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .badge-status-inactive {
      background-color: #dc3545;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .badge-status-pending {
      background-color: #ffc107;
      color: white;
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
    
    .address-cell {
      max-width: 250px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    
    .address-cell:hover {
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
    
    .customer-name {
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
            <h1><i class="fas fa-users mr-2"></i>Daftar Pelanggan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
              <li class="breadcrumb-item active">Data Pelanggan</li>
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
            <!-- Customer Stats Cards -->
            <div class="row mb-4">
              <div class="col-md-4">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?= count($plggn) ?></h3>
                    <p>Total Pelanggan</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-users"></i>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="small-box bg-success">
                  <div class="inner">
                    <?php
                    $active = 0;
                    foreach($plggn as $p) {
                      $status = trim(strtolower($p["status"]));
                      if($status == "aktif" || $status == "active") {
                        $active++;
                      }
                    }
                    ?>
                    <h3><?= $active ?></h3>
                    <p>Pelanggan Aktif</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-check-circle"></i>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="small-box bg-danger">
                  <div class="inner">
                    <?php
                    $inactive = 0;
                    foreach($plggn as $p) {
                      $status = trim(strtolower($p["status"]));
                      if($status != "aktif" && $status != "active") {
                        $inactive++;
                      }
                    }
                    ?>
                    <h3><?= $inactive ?></h3>
                    <p>Pelanggan Tidak Aktif</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-user-times"></i>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-table mr-2"></i>
                  Daftar Pelanggan Terdaftar
                </h3>
                <!--<div class="card-tools">
                  <button type="button" class="btn btn-success add-button" onclick="window.location.href='tambahpelanggan.php';">
                    <i class="fas fa-user-plus"></i> Tambah Pelanggan Baru
                  </button>
                </div>-->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th width="5%">ID Customer</th>
                    <th width="10%">Produk</th>
                    <th width="15%">Nama</th>
                    <th width="15%">Email / No HP</th>
                    <th width="25%">Alamat</th>
                    <th width="15%">Status</th>
                    <th width="10%">Aksi</th>
                  </tr>
                  </thead>

                  <tbody>
                  <?php $i = 1; ?>
                  <?php foreach($plggn as $row) : 
                    // Tentukan class badge berdasarkan status
                    // Trim spasi dan ubah ke huruf kecil untuk perbandingan yang lebih baik
                    $status = trim(strtolower($row["status"]));
                    
                    if($status == "aktif" || $status == "active") {
                      $badge_class = "badge-status-active";
                      $icon_class = "fa-check-circle";
                      $status_display = "Aktif";
                    } elseif($status == "pending") {
                      $badge_class = "badge-status-pending";
                      $icon_class = "fa-clock";
                      $status_display = "Pending";
                    } else {
                      $badge_class = "badge-status-inactive";
                      $icon_class = "fa-times-circle";
                      $status_display = "Tidak Aktif";
                    }
                  ?>
                  <tr class="data-row">
                    <td class="text-center"><?= $i;?></td>
                    <td><span class="badge badge-secondary"><?= $row["id_customer"];?></span></td>
                    <td><?= $row["nama_produk"];?></td>
                    <td class="customer-name"><?= $row["nama"];?></td>
                    <td>
                      <i class="fas fa-envelope text-primary"></i> <?= $row["email"];?><br>
                      <i class="fas fa-phone text-success"></i> <?= $row["no_hp"];?>
                    </td>
                    <td class="address-cell">
                      <i class="fas fa-map-marker-alt text-danger"></i> <?= $row["alamat"];?>
                    </td>
                    <td class="text-center">
                      <span class="<?= $badge_class; ?>">
                        <i class="fas <?= $icon_class; ?> mr-1"></i>
                        <?= $status_display; ?>
                      </span>
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-info btn-sm btn-action view-customer" data-id="<?= $row["id_customer"]; ?>" data-toggle="tooltip" title="Lihat Detail">
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
  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4 class="modal-title">Detail Pelanggan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-3">
            <i class="fas fa-user fa-5x text-info"></i>
          </div>
          <table class="table table-striped">
            <tr>
              <th>ID Customer</th>
              <td id="detail-id"></td>
            </tr>
            <tr>
              <th>Nama</th>
              <td id="detail-nama"></td>
            </tr>
            <tr>
              <th>Produk</th>
              <td id="detail-produk"></td>
            </tr>
            <tr>
              <th>Email</th>
              <td id="detail-email"></td>
            </tr>
            <tr>
              <th>No. HP</th>
              <td id="detail-hp"></td>
            </tr>
            <tr>
              <th>Alamat</th>
              <td id="detail-alamat"></td>
            </tr>
            <tr>
              <th>Status</th>
              <td id="detail-status"></td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
    
    // View Customer Detail
    $('.view-customer').on('click', function() {
      const id = $(this).data('id');
      
      // Dalam implementasi nyata, Anda perlu melakukan AJAX request ke server
      // untuk mendapatkan data detail pelanggan. Berikut contoh sederhananya:
      
      // AJAX request (mock demo)
      let customerData = null;
      
      <?php foreach($plggn as $row): ?>
      if(<?= json_encode($row["id_customer"]); ?> == id) {
        customerData = {
          id: <?= json_encode($row["id_customer"]); ?>,
          nama: <?= json_encode($row["nama"]); ?>,
          produk: <?= json_encode($row["nama_produk"]); ?>,
          email: <?= json_encode($row["email"]); ?>,
          hp: <?= json_encode($row["no_hp"]); ?>,
          alamat: <?= json_encode($row["alamat"]); ?>,
          status: <?= json_encode($row["status"]); ?>
        };
        
        // Set badge class - gunakan trim dan lowercase seperti pada tampilan tabel
        const statusLower = customerData.status.trim().toLowerCase();
        
        if(statusLower === "aktif" || statusLower === "active") {
          customerData.badgeHTML = '<span class="badge-status-active"><i class="fas fa-check-circle mr-1"></i> Aktif</span>';
        } else if(statusLower === "pending") {
          customerData.badgeHTML = '<span class="badge-status-pending"><i class="fas fa-clock mr-1"></i> Pending</span>';
        } else {
          customerData.badgeHTML = '<span class="badge-status-inactive"><i class="fas fa-times-circle mr-1"></i> Tidak Aktif</span>';
        }
      }
      <?php endforeach; ?>
      
      if(customerData) {
        $('#detail-id').text(customerData.id);
        $('#detail-nama').text(customerData.nama);
        $('#detail-produk').text(customerData.produk);
        $('#detail-email').text(customerData.email);
        $('#detail-hp').text(customerData.hp);
        $('#detail-alamat').text(customerData.alamat);
        $('#detail-status').html(customerData.badgeHTML);
        
        $('#modal-detail').modal('show');
      }
    });
    
    // Delete confirmation
    $('.delete-customer').on('click', function() {
      const id = $(this).data('id');
      
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data pelanggan akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          // Redirect to delete page
          window.location.href = 'hapuspelanggan.php?id_customer=' + id;
        }
      });
    });
    
    // Show toastr notification if there's a message
    <?php if(isset($_SESSION['message'])): ?>
    toastr.success('<?= $_SESSION['message']; ?>');
    <?php unset($_SESSION['message']); endif; ?>
  });
</script>
</body>
</html>