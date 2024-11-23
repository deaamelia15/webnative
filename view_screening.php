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
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil data pasien
$sql = "SELECT * FROM data_pasien";
$result = $conn->query($sql);

$patients = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Screening yang Sudah Diinput</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f8f8; /* Warna latar belakang yang lembut */
            color: #333; /* Warna teks utama */
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #b22222; /* Warna merah klinik Kinasih */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
        }
        th {
            background-color: #b22222; /* Warna merah klinik Kinasih */
            color: white;
            font-weight: bold;
        }
        td {
            border-top: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        a {
    display: inline-block;
    padding: 10px 15px;
    background-color: #b22222; /* Warna merah untuk tombol */
    color: white;
    text-decoration: none;
    border-radius: 5px;
    text-align: center;
    margin-top: 20px; /* Memberikan jarak atas setelah data/tabel */
    float: right; /* Membuat tombol berada di sebelah kanan */
}

        a:hover {
            background-color: #c0392b; /* Warna merah lebih gelap saat hover */
        }
        p {
            text-align: center;
            color: #e74c3c;
            font-size: 1.2em;
        }
    </style>
</head>
<body>


<h1>Data Screening Pasien</h1>

<div class="container">
    <?php if (count($patients) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama Pasien</th>
                    <th>Berat Badan</th>
                    <th>Tinggi Badan</th>
                    <th>Tekanan Darah</th>
                    <th>Keluhan</th>
                    <th>Diagnosis</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?= htmlspecialchars($patient['nik']) ?></td>
                        <td><?= htmlspecialchars($patient['nama_pasien']) ?></td>
                        <td><?= htmlspecialchars($patient['berat_badan']) ?> kg</td>
                        <td><?= htmlspecialchars($patient['tinggi_badan']) ?> cm</td>
                        <td><?= htmlspecialchars($patient['tekanan_darah']) ?></td>
                        <td><?= htmlspecialchars($patient['keluhan']) ?></td>
                        <td><?= htmlspecialchars($patient['diagnosis']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Data screening belum ada.</p>
    <?php endif; ?>
</div>

<a href="dashboard.php">Kembali</a> <!-- Tombol Kembali di kiri atas -->
</body>
</html>
