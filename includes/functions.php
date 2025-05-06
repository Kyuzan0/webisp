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

function tambah($data) {
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

function hapus ($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM users WHERE id_user = $id");
    return mysqli_affected_rows($conn);
}

function ubah($data) {
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

function hapuspaket ($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM produk WHERE id_produk = $id");
    return mysqli_affected_rows($conn);
}

?>