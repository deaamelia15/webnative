<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_klinik";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Memproses penghapusan data
if (isset($_GET['nik'])) {
    $nik = $conn->real_escape_string($_GET['nik']);

    // Menghapus data pasien berdasarkan NIK
    $sql = "DELETE FROM data_pasien WHERE nik = '$nik'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='data_screening.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "NIK tidak ditemukan.";
}

$conn->close();
?>
