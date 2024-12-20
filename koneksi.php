<?php
// Pengaturan koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_klinik";

// Membuat koneksi ke database MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengatur koneksi menjadi UTF-8 untuk mendukung karakter lokal
$conn->set_charset("utf8");

// Koneksi berhasil, dapat digunakan untuk query lebih lanjut
?>
