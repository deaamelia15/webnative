<?php
// Koneksi ke database
$conn = new mysqli("localhost", "username", "password", "db_klinik");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data pasien berdasarkan ID
$id_pasien = $_GET['id_pasien'];
$result = $conn->query("SELECT * FROM daftar_pasien WHERE id_pasien = $id_pasien");
$pasien = $result->fetch_assoc();

if (!$pasien) {
    die("Pasien tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Slip Pasien</title>
    <style>
        /* CSS untuk body dan latar belakang */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #8B0000; /* Warna merah gelap */
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* Kontainer utama */
.container {
    background-color: white;
    color: black;
    width: 50%;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
    text-align: center;
}

/* Judul */
h1 {
    font-size: 24px;
    margin-bottom: 20px;
    color: white;
    background-color: #8B0000;
    padding: 10px;
    border-radius: 5px;
}

/* Tabel */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 16px;
    text-align: left;
}

table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

/* Tombol Cetak */
button {
    background-color: #8B0000;
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #A52A2A; /* Warna merah bata */
}

    </style>
</head>
<body>
    <h1>Slip Pasien</h1>
    <table border="1">
        <tr>
            <th>ID Pasien</th>
            <td><?= $pasien['id_pasien'] ?></td>
        </tr>
        <tr>
            <th>NIK</th>
            <td><?= $pasien['nik'] ?></td>
        </tr>
        <tr>
            <th>Nama</th>
            <td><?= $pasien['nama_pasien'] ?></td>
        </tr>
        <tr>
            <th>Tanggal Lahir</th>
            <td><?= $pasien['tanggal_lahir'] ?></td>
        </tr>
        <tr>
            <th>Umur</th>
            <td><?= $pasien['umur'] ?></td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td><?= $pasien['alamat'] ?></td>
        </tr>
        <tr>
            <th>Tanggal Daftar</th>
            <td><?= $pasien['tanggal_daftar'] ?></td>
        </tr>
        <tr>
            <th>No. Antrian</th>
            <td><?= $pasien['no_antrian'] ?></td>
        </tr>
    </table>
</body>
</html>
