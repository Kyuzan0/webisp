<?php

require '../view/sidebar.php';
require '../includes/functions.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Paket - Customer Dashboard</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Main Sidebar Container sudah diinclude dari sidebar.php -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kelola Paket</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Kelola Paket</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Isi konten Anda di sini -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Kelola Paket</h1>
                </div>

                <!-- Paket Saat Ini -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-star"></i> Paket Saat Ini</h5>
                            </div>
                            <div class="card-body">
                                <div id="paket-aktif">
                                    <!-- Data akan diload via AJAX -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Request Perubahan -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-exchange-alt"></i> Request Perubahan Paket</h5>
                            </div>
                            <div class="card-body">
                                <form id="form-request-paket">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="paket-baru" class="form-label">Pilih Paket Baru</label>
                                                <select class="form-select" id="paket-baru" name="id_produk_baru" required>
                                                    <option value="">-- Pilih Paket --</option>
                                                    <!-- Options akan diload via AJAX -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="jenis-request" class="form-label">Jenis Request</label>
                                                <select class="form-select" id="jenis-request" name="jenis_request" required>
                                                    <option value="">-- Pilih Jenis --</option>
                                                    <option value="upgrade">Upgrade</option>
                                                    <option value="downgrade">Downgrade</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alasan" class="form-label">Alasan Request</label>
                                        <textarea class="form-control" id="alasan" name="alasan_request" rows="3" placeholder="Jelaskan alasan Anda ingin mengubah paket..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-paper-plane"></i> Kirim Request
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Request -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="fas fa-history"></i> Riwayat Request</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-riwayat">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Paket Lama</th>
                                                <th>Paket Baru</th>
                                                <th>Jenis</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data akan diload via AJAX -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            loadPaketAktif();
            loadRiwayatRequest();

            // Submit form request
            $('#form-request-paket').on('submit', function(e) {
                e.preventDefault();
                submitRequest();
            });

            // Load paket options when jenis request changes
            $('#jenis-request').on('change', function() {
                const jenisRequest = $(this).val();
                if (jenisRequest) {
                    loadDaftarPaket(jenisRequest);
                } else {
                    $('#paket-baru').html('<option value="">-- Pilih Jenis Request Dahulu --</option>');
                }
            });
        });

        // Fungsi untuk format rupiah
        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function loadPaketAktif() {
            $.ajax({
                url: '../api/get-paket-aktif.php',
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#paket-aktif').html(`
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="text-primary">${response.paket.nama_produk}</h4>
                                    <p class="mb-1">${response.paket.deskripsi}</p>
                                    <small class="text-muted">Status: <span class="badge bg-success">${response.customer.status}</span></small>
                                </div>
                                <div class="col-md-4 text-end">
                                    <h3 class="text-success">${formatRupiah(response.paket.harga)}</h3>
                                    <small class="text-muted">per bulan</small>
                                </div>
                            </div>
                        `);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan sistem');
                }
            });
        }

        function loadDaftarPaket(jenisRequest = '') {
            let url = '../api/get-daftar-paket.php';
            if (jenisRequest) {
                url += '?jenis_request=' + jenisRequest;
            }

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        let options = '<option value="">-- Pilih Paket --</option>';
                        
                        if (response.pakets.length === 0) {
                            const jenisText = jenisRequest === 'upgrade' ? 'upgrade' : 'downgrade';
                            options = `<option value="">-- Tidak ada paket untuk ${jenisText} --</option>`;
                        } else {
                            response.pakets.forEach(function(paket) {
                                options += `<option value="${paket.id_produk}" data-harga="${paket.harga}">${paket.nama_produk} - ${formatRupiah(paket.harga)}</option>`;
                            });
                        }
                        
                        $('#paket-baru').html(options);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan sistem saat memuat daftar paket.');
                }
            });
        }

        function loadRiwayatRequest() {
            $.ajax({
                url: '../api/get-riwayat-request.php',
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        let rows = '';
                        response.requests.forEach(function(req) {
                            const statusBadge = getStatusBadge(req.status_request);
                            rows += `
                                <tr>
                                    <td>${formatDate(req.tanggal_request)}</td>
                                    <td>${req.paket_lama}</td>
                                    <td>${req.paket_baru}</td>
                                    <td><span class="badge bg-${req.jenis_request === 'upgrade' ? 'success' : 'warning'}">${req.jenis_request}</span></td>
                                    <td>${statusBadge}</td>
                                    <td>${req.catatan_admin || '-'}</td>
                                </tr>
                            `;
                        });
                        $('#table-riwayat tbody').html(rows);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan sistem saat memuat riwayat request.');
                }
            });
        }

        function submitRequest() {
            const formData = new FormData($('#form-request-paket')[0]);
            
            $.ajax({
                url: '../api/submit-request-paket.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        alert('Request berhasil dikirim!');
                        $('#form-request-paket')[0].reset();
                        // Reset dropdown paket baru
                        $('#paket-baru').html('<option value="">-- Pilih Jenis Request Dahulu --</option>');
                        loadRiwayatRequest();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan sistem saat mengirim request.');
                }
            });
        }

        function getStatusBadge(status) {
            const badges = {
                'pending': '<span class="badge bg-warning">Pending</span>',
                'disetujui': '<span class="badge bg-success">Disetujui</span>',
                'ditolak': '<span class="badge bg-danger">Ditolak</span>',
                'diproses': '<span class="badge bg-info">Diproses</span>',
                'selesai': '<span class="badge bg-primary">Selesai</span>'
            };
            return badges[status] || '<span class="badge bg-secondary">Unknown</span>';
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID') + ' ' + date.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});
        }
    </script>
    </div>
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
<script src="../public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/js/adminlte.js"></script>

<!-- Script lainnya di sini -->
</body>
</html>