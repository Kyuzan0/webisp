<?php
$server = "localhost";
$user = "root";
$pass = "";
$database = "dbisp";
$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows [] = $row;
    }
    return $rows;
}

function setFlash($type, $message) {
    // Start the session if it hasn't been started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Set flash message in session
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}


// user section //

function getJumlahUser($conn) {
    // Query untuk mendapatkan jumlah user
    $sql = "SELECT COUNT(*) AS jumlah_user FROM users";
    $result = $conn->query($sql);
    
    // Mengecek apakah query berhasil
    if ($result->num_rows > 0) {
        // Mengambil data hasil query
        $row = $result->fetch_assoc();
        return $row['jumlah_user'];
    } else {
        return 0; // Jika tidak ada user
    }
}

function tambahuser($data) {
    global $conn;

    // Menggunakan htmlspecialchars untuk menghindari XSS
    $email = htmlspecialchars($data["email"]);
    $username = htmlspecialchars($data["username"]);
    $password = password_hash($data["password"], PASSWORD_DEFAULT);  // Hash password
    $level = htmlspecialchars($data["level"]);

    // Membuat query SQL
    $query = "INSERT INTO users (email, username, password, level) VALUES ('$email','$username', '$password', '$level')";
    
    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        // Menampilkan error jika query gagal
        echo "Error: " . mysqli_error($conn);
        return 0;
    }
}

function hapususer ($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM users WHERE id_user = $id");
    return mysqli_affected_rows($conn);
}

function ubahuser($data) {
    global $conn;

    $id = $data["id_user"];
    $email = htmlspecialchars($data["email"]);
    $username = htmlspecialchars($data["username"]);
    $level = $data["level"];

    $query = "UPDATE users SET
            email = '$email',
            username = '$username',
            level = '$level'
            WHERE id_user = $id";

    // Hapus echo debug jika sudah berfungsi dengan baik
    // echo "Query: " . $query . "<br>";
    
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        echo "Error: " . mysqli_error($conn) . "<br>";
        return 0;
    }
}
// user end section //


// paket section //
// produk section //

function getdataproduk($conn) {
    // Query untuk mendapatkan id_user dan username
    $sql = "SELECT id_produk, nama_produk FROM produk";
    $result = $conn->query($sql);
    
    // Mengecek apakah query berhasil
    if ($result->num_rows > 0) {
        // Membuat array untuk menyimpan id_user dan username
        $produks = [];
        
        // Mengambil data hasil query
        while ($row = $result->fetch_assoc()) {
            // Menyimpan id_user dan username ke dalam array
            $produks[] = $row;
        }
        
        // Mengembalikan array id_user dan username
        return $produks;
    } else {
        return []; // Jika tidak ada user
    }
}


function getJumlahProduk($conn) {
    // Query untuk mendapatkan jumlah user
    $sql = "SELECT COUNT(*) AS jumlah_produk FROM produk";
    $result = $conn->query($sql);
    
    // Mengecek apakah query berhasil
    if ($result->num_rows > 0) {
        // Mengambil data hasil query
        $row = $result->fetch_assoc();
        return $row['jumlah_produk'];
    } else {
        return 0; // Jika tidak ada produk
    }
}

function tambahpaket($data) {
    global $conn;

    // Menggunakan htmlspecialchars untuk menghindari XSS
    $namaproduk = htmlspecialchars($data["nama_produk"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $harga = htmlspecialchars($data["harga"]);

    // Membuat query SQL
    $query = "INSERT INTO produk (nama_produk, deskripsi, harga) VALUES ('$namaproduk', '$deskripsi', '$harga')";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        // Menampilkan error jika query gagal
        echo "Error: " . mysqli_error($conn);
        return 0;
    }
}

function ubahpaket($data) {
    global $conn;

    // Menggunakan htmlspecialchars untuk menghindari XSS
    $id = htmlspecialchars($data["id_produk"]);
    $namaproduk = htmlspecialchars($data["nama_produk"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $harga = htmlspecialchars($data["harga"]);

    // Membuat query SQL
    $query = "UPDATE produk SET nama_produk = '$namaproduk', deskripsi = '$deskripsi', harga = '$harga' WHERE id_produk = '$id'";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        // Menampilkan error jika query gagal
        echo "Error: " . mysqli_error($conn);
        return 0;
    }
}


function hapuspaket ($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM produk WHERE id_produk = $id");
    return mysqli_affected_rows($conn);
}

// produk end section //
// paket end section //


// pelanggan section //

function getJumlahPelanggan($conn) {
    // Query untuk mendapatkan jumlah user
    $sql = "SELECT COUNT(*) AS jumlah_pelanggan FROM customer";
    $result = $conn->query($sql);
    
    // Mengecek apakah query berhasil
    if ($result->num_rows > 0) {
        // Mengambil data hasil query
        $row = $result->fetch_assoc();
        return $row['jumlah_pelanggan'];
    } else {
        return 0; // Jika tidak ada pelanggan
    }
}

function getdatapelanggan($conn) {
    // Query untuk mendapatkan id_user dan username
    $sql = "SELECT id_user, username FROM users";
    $result = $conn->query($sql);
    
    // Mengecek apakah query berhasil
    if ($result->num_rows > 0) {
        // Membuat array untuk menyimpan id_user dan username
        $users = [];
        
        // Mengambil data hasil query
        while ($row = $result->fetch_assoc()) {
            // Menyimpan id_user dan username ke dalam array
            $users[] = $row;
        }
        
        // Mengembalikan array id_user dan username
        return $users;
    } else {
        return []; // Jika tidak ada user
    }
}

function hapuspelanggan ($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM customer WHERE id_customer = $id");
    return mysqli_affected_rows($conn);
}

function ubahpelanggan($data) {
    global $conn;

    // Menggunakan htmlspecialchars untuk menghindari XSS
    $id = htmlspecialchars($data["id_customer"]);
    $idproduk = htmlspecialchars($data["id_produk"]);
    $iduser = htmlspecialchars($data["id_user"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $nohp = htmlspecialchars($data["no_hp"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $status = htmlspecialchars($data["status"]);

    // Membuat query SQL untuk memperbarui data pelanggan berdasarkan id_customer
    $query = "UPDATE customer SET 
              id_produk = '$idproduk',
              id_user = '$iduser',
              nama = '$nama',
              email = '$email',
              no_hp = '$nohp',
              alamat = '$alamat',
              status = '$status'
              WHERE id_customer = '$id'";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        // Menampilkan error jika query gagal
        echo "Error: " . mysqli_error($conn);
        return 0;
    }
}

function tambahpelanggan($data) {
    global $conn;

    // Menggunakan htmlspecialchars untuk menghindari XSS
    
    $idproduk = htmlspecialchars($data["id_produk"]);
    $iduser = htmlspecialchars($data["id_user"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $nohp = htmlspecialchars($data["no_hp"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $status = htmlspecialchars($data["status"]);

    // Membuat query SQL, id_customer diabaikan karena auto increment
    $query = "INSERT INTO customer ( id_produk, id_user, nama, email, no_hp, alamat, status) 
              VALUES ( '$idproduk', '$iduser','$nama', '$email', '$nohp', '$alamat', '$status')";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        // Menampilkan error jika query gagal
        echo "Error: " . mysqli_error($conn);
        return 0;
    }
}

// pelanggan end section //

// keluhan section //

function tambahkeluhan($data) {
    global $conn;

    // Menggunakan htmlspecialchars untuk menghindari XSS
    $idkepalateknisi = htmlspecialchars($data["id_kepalateknisi"]);
    $idcustomer = htmlspecialchars($data["id_customer"]);
    $judul = htmlspecialchars($data["judul_keluhan"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $status = htmlspecialchars($data["status"]);

    // Membuat query SQL, id_customer diabaikan karena auto increment
    $query = "INSERT INTO keluhan (id_kepalateknisi, id_customer, judul_keluhan, deskripsi, status) 
              VALUES ('$idkepalateknisi', '$idcustomer', '$judul', '$deskripsi', '$status')";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        // Menampilkan error jika query gagal
        echo "Error: " . mysqli_error($conn);
        return 0;
    }
}


function getjumlahkeluhan($conn) {
    // Query untuk mendapatkan jumlah keluhan
    global $conn; // Tambahkan ini untuk memastikan koneksi tersedia
    $sql = "SELECT COUNT(*) AS jumlah_keluhan FROM keluhan";
    $result = $conn->query($sql);
    
    // Mengecek apakah query berhasil
    if ($result && $result->num_rows > 0) { // Tambahkan pengecekan $result
        // Mengambil data hasil query
        $row = $result->fetch_assoc();
        return $row['jumlah_keluhan'];
    } else {
        return 0; // Jika tidak ada keluhan atau query gagal
    }
}

function ubahkeluhan($data) {
    global $conn;

    // Menggunakan htmlspecialchars untuk menghindari XSS
    $id = htmlspecialchars($data["id_keluhan"]);
    $idcustomer = htmlspecialchars($data["id_user"]);
    $tanggalkel = htmlspecialchars($data["tanggal_keluhan"]);
    $judul_keluhan = htmlspecialchars($data["judul_keluhan"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $status = htmlspecialchars($data["status"]);

    // Membuat query SQL untuk mengupdate data keluhan
    $query = "UPDATE keluhan SET 
                id_user = '$idcustomer', 
                tanggal_keluhan = '$tanggalkel', 
                judul_keluhan = '$judul_keluhan', 
                deskripsi = '$deskripsi', 
                status = '$status' 
              WHERE id_keluhan = '$id'";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        // Menampilkan error jika query gagal
        echo "Error: " . mysqli_error($conn);
        return 0;
    }
}


function hapuskeluhan($id) {
    global $conn;
    
    // Hapus data terkait di tabel perbaikan terlebih dahulu
    mysqli_query($conn, "DELETE FROM perbaikan WHERE id_keluhan = $id");
    
    // Kemudian hapus data keluhan
    mysqli_query($conn, "DELETE FROM keluhan WHERE id_keluhan = $id");
    
    return mysqli_affected_rows($conn);
}

// keluhan end section //

// pelanggan section //

function tambahkeluhanp($data) {
    global $conn;

    // Menggunakan htmlspecialchars untuk menghindari XSS
    $idkepalateknisi = htmlspecialchars($data["id_kepalateknisi"]);
    $iduser = htmlspecialchars($data["id_user"]);
    $judul = htmlspecialchars($data["judul_keluhan"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $status = htmlspecialchars($data["status"]);

    // Membuat query SQL, id_customer diabaikan karena auto increment
    $query = "INSERT INTO keluhan (id_kepalateknisi, id_user, judul_keluhan, deskripsi, status) 
              VALUES ('$idkepalateknisi', '$iduser', '$judul', '$deskripsi', '$status')";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        // Menampilkan error jika query gagal
        echo "Error: " . mysqli_error($conn);
        return 0;
    }
}

// pelanggan end section //

// promosi section //

function getJumlahPromo($conn) {
    // Query untuk mendapatkan jumlah promo
    $sql = "SELECT COUNT(*) AS jumlah_promo FROM promosi";
    $result = $conn->query($sql);

    // Mengecek apakah query berhasil
    if ($result && $result->num_rows > 0) {
        // Mengambil data hasil query
        $row = $result->fetch_assoc();
        return $row['jumlah_promo'];
    } else {
        return 0; // Jika tidak ada promo atau query gagal
    }
}

function tambahpromosi($data) {
    global $conn;

    // Menggunakan htmlspecialchars untuk menghindari XSS
    $mulai_promosi = htmlspecialchars($data["mulai_promosi"]);
    $akhir_promosi = htmlspecialchars($data["akhir_promosi"]);
    $judul = htmlspecialchars($data["judul"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $id_salesmarketing = htmlspecialchars($data["id_salesmarketing"]);  // Added foreign key field

    // Pastikan id_salesmarketing valid di salesmarketing table
    $query_check = "SELECT id_salesmarketing FROM salesmarketing WHERE id_salesmarketing = '$id_salesmarketing'";
    $result_check = mysqli_query($conn, $query_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Membuat query SQL untuk insert
        $query = "INSERT INTO promosi (mulai_promosi, akhir_promosi, judul, deskripsi, id_salesmarketing) 
                  VALUES ('$mulai_promosi', '$akhir_promosi', '$judul', '$deskripsi', '$id_salesmarketing')";

        // Eksekusi query
        if (mysqli_query($conn, $query)) {
            return mysqli_affected_rows($conn);
        } else {
            echo "Error: " . mysqli_error($conn);
            return 0;
        }
    } else {
        echo "Error: id_salesmarketing tidak valid.";
        return 0;
    }
}


function hapuspromosi ($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM promosi WHERE id_promosi = $id");
    return mysqli_affected_rows($conn);
}

function ubahpromosi($data) {
    global $conn;

    // Menggunakan htmlspecialchars untuk menghindari XSS
    $id = htmlspecialchars($data["id_promosi"]);
    $mulai_promosi = htmlspecialchars($data["mulai_promosi"]);
    $akhir_promosi = htmlspecialchars($data["akhir_promosi"]);
    $judul = htmlspecialchars($data["judul"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);

    // Membuat query SQL untuk memperbarui data promosi berdasarkan id_promosi
    $query = "UPDATE promosi SET 
              mulai_promosi = '$mulai_promosi',
              akhir_promosi = '$akhir_promosi',
              judul = '$judul',
              deskripsi = '$deskripsi'
              WHERE id_promosi = '$id'";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        // Menampilkan error jika query gagal
        echo "Error: " . mysqli_error($conn);
        return 0;
    }
}


// promosi end section //

?>