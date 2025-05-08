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
    $username = htmlspecialchars($data["username"]);
    $level = $data["level"];

    $query = "UPDATE users SET
            username = '$username',
            level = '$level'
            WHERE id_user = $id";

echo "Query: " . $query . "<br>";
if (mysqli_query($conn, $query)) {
    return mysqli_affected_rows($conn);
} else {
    echo "Error: " . mysqli_error($conn) . "<br>";
    return 0;
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


?>