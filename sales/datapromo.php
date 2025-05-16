<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

$promo = query("SELECT * FROM promosi"); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WebISP | Kelola Data Promo</title>

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
    
    .badge-promo-active {
      background-color: #28a745;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .badge-promo-inactive {
      background-color: #dc3545;
      color: white;
      padding: 5px 10px;
      border-radius: 10px;
      font-weight: normal;
    }
    
    .badge-promo-upcoming {
      background-color: #17a2b8;
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
    
    .promo-title {
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
            <h1><i class="fas fa-percentage mr-2"></i>Daftar Promo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
              <li class="breadcrumb-item active">Data Promo</li>
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
            <!-- Promo Stats Cards -->
            <div class="row mb-4">
              <div class="col-md-4">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?= count($promo) ?></h3>
                    <p>Total Promosi</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-tags"></i>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="small-box bg-success">
                  <div class="inner">
                    <?php
                    $today = date('Y-m-d');
                    $active = 0;
                    foreach($promo as $p) {
                      if($p["mulai_promosi"] <= $today && $p["akhir_promosi"] >= $today) {
                        $active++;
                      }
                    }
                    ?>
                    <h3><?= $active ?></h3>
                    <p>Promosi Aktif</p>
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
                    $expired = 0;
                    foreach($promo as $p) {
                      if($p["akhir_promosi"] < $today) {
                        $expired++;
                      }
                    }
                    ?>
                    <h3><?= $expired ?></h3>
                    <p>Promosi Berakhir</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-calendar-times"></i>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-fire mr-2"></i>
                  Daftar Promo Yang Berjalan
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-success add-button" onclick="window.location.href='tambahpromo.php';">
                    <i class="fas fa-plus-circle"></i> Tambah Promo Baru
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th width="5%">ID Promosi</th>
                    <th width="10%">Periode</th>
                    <th width="20%">Judul Promosi</th>
                    <th width="35%">Deskripsi</th>
                    <th width="15%">Status</th>
                    <th width="10%">Aksi</th>
                  </tr>
                  </thead>

                  <tbody>
                  <?php $i = 1; ?>
                  <?php foreach($promo as $row) : 
                    // Hitung status promo
                    $today = date('Y-m-d');
                    $start_date = $row["mulai_promosi"];
                    $end_date = $row["akhir_promosi"];
                    
                    if($start_date <= $today && $end_date >= $today) {
                      $status = "active";
                      $status_label = "Aktif";
                      $badge_class = "badge-promo-active";
                    } elseif($start_date > $today) {
                      $status = "upcoming";
                      $status_label = "Mendatang";
                      $badge_class = "badge-promo-upcoming";
                    } else {
                      $status = "inactive";
                      $status_label = "Berakhir";
                      $badge_class = "badge-promo-inactive";
                    }
                    
                    // Format tanggal
                    $mulai_format = date('d M Y', strtotime($start_date));
                    $akhir_format = date('d M Y', strtotime($end_date));
                  ?>
                  <tr class="data-row">
                    <td class="text-center"><?= $i;?></td>
                    <td><span class="badge badge-secondary"><?= $row["id_promosi"];?></span></td>
                    <td>
                      <i class="fas fa-calendar-day text-primary"></i> <?= $mulai_format;?><br>
                      <i class="fas fa-calendar-times text-danger"></i> <?= $akhir_format;?>
                    </td>
                    
                    <td class="promo-title"><?= $row["judul"];?></td>
                    <td class="description-cell"><?= $row["deskripsi"];?></td>
                    <td class="text-center">
                      <span class="<?= $badge_class; ?>">
                        <?php if($status == "active"): ?>
                          <i class="fas fa-check-circle mr-1"></i>
                        <?php elseif($status == "upcoming"): ?>
                          <i class="fas fa-clock mr-1"></i>
                        <?php else: ?>
                          <i class="fas fa-times-circle mr-1"></i>
                        <?php endif; ?>
                        <?= $status_label; ?>
                      </span>
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-info btn-sm btn-action view-promo" data-id="<?= $row["id_promosi"]; ?>" data-toggle="tooltip" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                      </button>
                      <a class="btn btn-primary btn-sm btn-action" href="ubahpromosi.php?id_promosi=<?= $row["id_promosi"]; ?>" data-toggle="tooltip" title="Ubah">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a class="btn btn-danger btn-sm btn-action delete-promo" href="javascript:void(0)" data-id="<?= $row["id_promosi"]; ?>" data-toggle="tooltip" title="Hapus">
                        <i class="fas fa-trash"></i>
                      </a>
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
          <h4 class="modal-title">Detail Promosi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-3">
            <img src="../public/img/promo-icon.png" alt="Promo Icon" width="100">
          </div>
          <table class="table table-striped">
            <tr>
              <th>ID Promosi</th>
              <td id="detail-id"></td>
            </tr>
            <tr>
              <th>Judul Promosi</th>
              <td id="detail-judul"></td>
            </tr>
            <tr>
              <th>Periode</th>
              <td id="detail-periode"></td>
            </tr>
            <tr>
              <th>Status</th>
              <td id="detail-status"></td>
            </tr>
            <tr>
              <th>Deskripsi</th>
              <td id="detail-deskripsi"></td>
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
    
    // View Promo Detail
    $('.view-promo').on('click', function() {
      const id = $(this).data('id');
      
      // Dalam implementasi nyata, Anda perlu melakukan AJAX request ke server
      // untuk mendapatkan data detail promo. Berikut contoh sederhananya:
      
      // AJAX request (mock demo)
      let promoData = null;
      
      <?php foreach($promo as $row): ?>
      if(<?= $row["id_promosi"]; ?> == id) {
        promoData = {
          id: "<?= $row["id_promosi"]; ?>",
          judul: "<?= $row["judul"]; ?>",
          mulai: "<?= date('d M Y', strtotime($row["mulai_promosi"])); ?>",
          akhir: "<?= date('d M Y', strtotime($row["akhir_promosi"])); ?>",
          deskripsi: "<?= $row["deskripsi"]; ?>"
        };
        
        // Hitung status
        const today = new Date();
        const startDate = new Date("<?= $row["mulai_promosi"]; ?>");
        const endDate = new Date("<?= $row["akhir_promosi"]; ?>");
        
        if(startDate <= today && endDate >= today) {
          promoData.status = '<span class="badge-promo-active"><i class="fas fa-check-circle mr-1"></i> Aktif</span>';
        } else if(startDate > today) {
          promoData.status = '<span class="badge-promo-upcoming"><i class="fas fa-clock mr-1"></i> Mendatang</span>';
        } else {
          promoData.status = '<span class="badge-promo-inactive"><i class="fas fa-times-circle mr-1"></i> Berakhir</span>';
        }
      }
      <?php endforeach; ?>
      
      if(promoData) {
        $('#detail-id').text(promoData.id);
        $('#detail-judul').text(promoData.judul);
        $('#detail-periode').html(
          '<i class="fas fa-calendar-day text-primary"></i> ' + promoData.mulai + 
          ' <br><i class="fas fa-calendar-times text-danger"></i> ' + promoData.akhir
        );
        $('#detail-status').html(promoData.status);
        $('#detail-deskripsi').text(promoData.deskripsi);
        
        $('#modal-detail').modal('show');
      }
    });
    
    // Delete confirmation
    $('.delete-promo').on('click', function() {
      const id = $(this).data('id');
      
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data promosi akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          // Redirect to delete page
          window.location.href = 'hapuspromosi.php?id_promosi=' + id;
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