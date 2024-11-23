<?php
// Pengaturan koneksi database
$servername = "localhost";  // Nama server, biasanya 'localhost'
$username = "root";         // Username untuk koneksi database
$password = "";             // Password untuk koneksi database, biarkan kosong jika menggunakan XAMPP default
$dbname = "klinikk"; // Nama database yang digunakan

// Membuat koneksi ke database MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengatur koneksi menjadi UTF-8 untuk mendukung karakter lokal
$conn->set_charset("utf8");

// Menutup koneksi saat sudah tidak diperlukan
// $conn->close(); // Pastikan untuk menutup koneksi saat tidak digunakan di halaman lain
?>
