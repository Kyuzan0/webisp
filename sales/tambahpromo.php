<?php 
require '../includes/functions.php';
require '../view/sidebar.php';

// Cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    // Cek apakah data berhasil ditambahkan atau tidak
    if( tambahpromosi($_POST) > 0 ) {
        echo "
            <script>
                alert('Data promosi berhasil ditambahkan!');
                document.location.href = 'datapromo.php'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data promosi gagal ditambahkan! :(');
                document.location.href = 'tambahpromo.php'
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
  <title>WebISP | Kelola Data Promosi</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
  
  <style>
    .preview-container {
      margin-top: 15px;
      border: 2px dashed #ddd;
      border-radius: 8px;
      padding: 20px;
      text-align: center;
      background: #f9f9f9;
    }
    
    .preview-image {
      max-width: 100%;
      max-height: 200px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .upload-area {
      border: 2px dashed #007bff;
      border-radius: 8px;
      padding: 30px;
      text-align: center;
      background: #f8f9ff;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .upload-area:hover {
      background: #e7f1ff;
      border-color: #0056b3;
    }
    
    .upload-area.dragover {
      background: #e7f1ff;
      border-color: #0056b3;
    }
    
    .btn-custom {
      padding: 10px 25px;
      border-radius: 6px;
      font-weight: 500;
    }
    
    .section-divider {
      border-top: 2px solid #e9ecef;
      margin: 30px 0;
      padding-top: 20px;
    }
    
    .section-title {
      color: #495057;
      font-weight: 600;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
    }
    
    .section-title i {
      margin-right: 10px;
      color: #007bff;
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
            <h1>Menambahkan Promosi</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Menambahkan Promosi</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Form Tambah Promosi</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>

              <form action="" method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <!-- BAGIAN DATA PROMOSI -->
                  <div class="section-title">
                    <i class="fas fa-bullhorn"></i>
                    <span>Data Promosi</span>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-6">
                      <!-- Hidden field untuk ID Sales Marketing -->
                      <input type="hidden" name="id_salesmarketing" value="1">
                      
                      <div class="form-group">
                        <label for="mulai_promosi">Tanggal Mulai Promosi *</label>
                        <input type="date" name="mulai_promosi" id="mulai_promosi" class="form-control" required>
                      </div>

                      <div class="form-group">
                        <label for="akhir_promosi">Tanggal Akhir Promosi *</label>
                        <input type="date" name="akhir_promosi" id="akhir_promosi" class="form-control" required>
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="judul">Judul Promosi *</label>
                        <input type="text" name="judul" id="judul" class="form-control" required 
                               placeholder="Masukkan judul promosi" maxlength="100">
                        <small class="form-text text-muted">Maksimal 100 karakter</small>
                      </div>

                      <div class="form-group">
                        <label for="deskripsi">Deskripsi Promosi *</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" required 
                                  placeholder="Masukkan detail promosi..." rows="4"></textarea>
                      </div>
                    </div>
                  </div>

                  <!-- DIVIDER -->
                  <div class="section-divider">
                    <div class="section-title">
                      <i class="fas fa-image"></i>
                      <span>Gambar Promosi (Opsional)</span>
                    </div>
                  </div>

                  <!-- BAGIAN UPLOAD GAMBAR -->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="gambar">Upload Gambar Promosi</label>
                        <div class="upload-area" onclick="document.getElementById('gambar').click()">
                          <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                          <h6>Klik atau drag gambar ke sini</h6>
                          <p class="text-muted small">Format: JPG, PNG, GIF (Max: 2MB)<br>Ukuran recommended: 1200x400px</p>
                        </div>
                        <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*" style="display: none;">
                        <div class="preview-container" id="previewContainer" style="display: none;">
                          <img id="previewImage" class="preview-image" alt="Preview">
                          <p class="mt-2 text-success small"><i class="fas fa-check"></i> Gambar siap diupload</p>
                          <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeImage()">
                            <i class="fas fa-trash"></i> Hapus Gambar
                          </button>
                        </div>
                        <small class="form-text text-muted">
                          Gambar akan disimpan di folder uploads/promosi/. Kosongkan jika tidak ingin menambahkan gambar.
                        </small>
                      </div>
                    </div>
                  </div>

                  <!-- TOMBOL AKSI -->
                  <div class="form-group text-right mt-4">
                    <a href="../sales/datapromo.php" class="btn btn-secondary btn-custom mr-2">
                      <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" name="submit" class="btn btn-success btn-custom">
                      <i class="fas fa-save"></i> Simpan Promosi
                    </button>
                  </div>

                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
</div>

<!-- jQuery -->
<script src="../public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/js/adminlte.min.js"></script>

<script>
$(document).ready(function() {
    const uploadArea = $('.upload-area');
    const fileInput = $('#gambar');
    const previewContainer = $('#previewContainer');
    const previewImage = $('#previewImage');
    
    // Set tanggal minimum ke hari ini
    const today = new Date().toISOString().split('T')[0];
    $('#mulai_promosi, #akhir_promosi').attr('min', today);
    
    // Update tanggal akhir minimum ketika tanggal mulai berubah
    $('#mulai_promosi').change(function() {
        const selectedDate = $(this).val();
        $('#akhir_promosi').attr('min', selectedDate);
        
        // Reset akhir_promosi jika lebih kecil dari mulai_promosi
        if ($('#akhir_promosi').val() && $('#akhir_promosi').val() < selectedDate) {
            $('#akhir_promosi').val('');
        }
    });
    
    // Handle file input change
    fileInput.change(function() {
        handleFileSelect(this.files[0]);
    });
    
    // Drag and drop functionality
    uploadArea.on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });
    
    uploadArea.on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
    });
    
    uploadArea.on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
        
        const files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            fileInput[0].files = files;
            handleFileSelect(files[0]);
        }
    });
    
    function handleFileSelect(file) {
        if (!file) return;
        
        // Validasi tipe file
        if (!file.type.match('image.*')) {
            alert('Hanya file gambar yang diperbolehkan!');
            fileInput.val('');
            return;
        }
        
        // Validasi ukuran file (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 2MB.');
            fileInput.val('');
            return;
        }
        
        // Preview gambar
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.attr('src', e.target.result);
            previewContainer.show();
            uploadArea.hide();
        };
        reader.readAsDataURL(file);
    }
    
    // Form validation
    $('form').submit(function(e) {
        const mulaiPromosi = new Date($('#mulai_promosi').val());
        const akhirPromosi = new Date($('#akhir_promosi').val());
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Reset jam ke 00:00
        
        // Validasi tanggal tidak boleh di masa lalu
        if (mulaiPromosi < today) {
            e.preventDefault();
            alert('Tanggal mulai promosi tidak boleh di masa lalu!');
            return false;
        }
        
        // Validasi tanggal akhir harus lebih besar dari tanggal mulai
        if (akhirPromosi <= mulaiPromosi) {
            e.preventDefault();
            alert('Tanggal akhir promosi harus lebih besar dari tanggal mulai!');
            return false;
        }
        
        // Validasi judul tidak boleh kosong atau hanya spasi
        const judul = $('#judul').val().trim();
        if (judul === '') {
            e.preventDefault();
            alert('Judul promosi tidak boleh kosong!');
            $('#judul').focus();
            return false;
        }
        
        // Validasi deskripsi tidak boleh kosong atau hanya spasi
        const deskripsi = $('#deskripsi').val().trim();
        if (deskripsi === '') {
            e.preventDefault();
            alert('Deskripsi promosi tidak boleh kosong!');
            $('#deskripsi').focus();
            return false;
        }
        
        return true;
    });
    
    // Fungsi untuk menghapus gambar
    window.removeImage = function() {
        if (confirm('Hapus gambar yang sudah dipilih?')) {
            previewContainer.hide();
            uploadArea.show();
            fileInput.val('');
        }
    };
    
    // Auto-resize textarea
    $('#deskripsi').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});
</script>

</body>
</html>