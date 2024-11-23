<?php
// proses_daftar.php
session_start();  // Pastikan session dimulai

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mendapatkan data dari form
    $nama_pasien = $_POST['nama_pasien'];
    $usia = $_POST['usia'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telepon = $_POST['telepon'];

    // Koneksi ke database
    $conn = new mysqli('localhost', 'root', '', 'klinikk');

    // Mengecek apakah koneksi berhasil
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk menyimpan data pasien
    $sql = "INSERT INTO data_pasien (nama_pasien, usia, alamat, jenis_kelamin, telepon) 
        VALUES ('$nama_pasien', '$usia', '$alamat', '$jenis_kelamin', '$telepon')";


    if ($conn->query($sql) === TRUE) {
        // Jika pendaftaran berhasil, redirect ke halaman dashboard
        $_SESSION['message'] = "Pendaftaran berhasil!";  // Menyimpan pesan ke session
        header("Location: dashboard.php");  // Redirect ke dashboard
        exit();  // Menghentikan eksekusi lebih lanjut
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi
    $conn->close();
}
?>
