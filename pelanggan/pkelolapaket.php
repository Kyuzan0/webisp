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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            

            <!-- Main content -->
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
            loadDaftarPaket();
            loadRiwayatRequest();

            // Submit form request
            $('#form-request-paket').on('submit', function(e) {
                e.preventDefault();
                submitRequest();
            });
        });

        function loadPaketAktif() {
            $.ajax({
                url: 'api/get-paket-aktif.php',
                type: 'GET',
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        $('#paket-aktif').html(`
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="text-primary">${data.paket.nama_produk}</h4>
                                    <p class="mb-1">${data.paket.deskripsi}</p>
                                    <small class="text-muted">Status: <span class="badge bg-success">${data.customer.status}</span></small>
                                </div>
                                <div class="col-md-4 text-end">
                                    <h3 class="text-success">Rp ${data.paket.harga.toLocaleString()}</h3>
                                    <small class="text-muted">per bulan</small>
                                </div>
                            </div>
                        `);
                    }
                }
            });
        }

        function loadDaftarPaket() {
            $.ajax({
                url: 'api/get-daftar-paket.php',
                type: 'GET',
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        let options = '<option value="">-- Pilih Paket --</option>';
                        data.pakets.forEach(function(paket) {
                            options += `<option value="${paket.id_produk}" data-harga="${paket.harga}">${paket.nama_produk} - Rp ${paket.harga.toLocaleString()}</option>`;
                        });
                        $('#paket-baru').html(options);
                    }
                }
            });
        }

        function loadRiwayatRequest() {
            $.ajax({
                url: 'api/get-riwayat-request.php',
                type: 'GET',
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        let rows = '';
                        data.requests.forEach(function(req) {
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
                    }
                }
            });
        }

        function submitRequest() {
            const formData = new FormData($('#form-request-paket')[0]);
            
            $.ajax({
                url: 'api/submit-request-paket.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        alert('Request berhasil dikirim!');
                        $('#form-request-paket')[0].reset();
                        loadRiwayatRequest();
                    } else {
                        alert('Error: ' + data.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan sistem');
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
</body>
</html>