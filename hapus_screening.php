<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "klinikk";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah parameter id_data ada di URL
if (isset($_GET['id_data'])) {
    $id_data = $_GET['id_data'];

    // Siapkan query untuk menghapus data pasien
    $sql = "DELETE FROM data_pasien WHERE id_data = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameter
    $stmt->bind_param("i", $id_data);

    // Eksekusi query
    if ($stmt->execute()) {
        // Redirect kembali ke halaman data_screening.php setelah berhasil
        header("Location: data_screening.php?message=success");
        exit();
    } else {
        echo "Gagal menghapus data pasien.";
    }

    $stmt->close();
} else {
    echo "ID pasien tidak ditemukan.";
}

// Tutup koneksi
$conn->close();
?>
