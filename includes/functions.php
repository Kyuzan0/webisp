<?php 

$conn = new mysqli('localhost', 'root', '', 'dbisp');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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

function tambah($data) {
    global $conn;

    // Menggunakan htmlspecialchars untuk menghindari XSS
    $username = htmlspecialchars($data["username"]);
    $password = password_hash($data["password"], PASSWORD_DEFAULT);  // Hash password
    $level = htmlspecialchars($data["level"]);

    // Membuat query SQL
    $query = "INSERT INTO users (username, password, level) VALUES ('$username', '$password', '$level')";

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

function ubahp($data) {
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

?>