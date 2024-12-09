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
$sql = "SELECT * FROM daftar_pasien"; // Pastikan tabel bernama `daftar_pasien`
$result = $conn->query($sql);

$patients = [];
if ($result && $result->num_rows > 0) {
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
    <title>Dashboard Klinik</title>
    <style>
        /* Reset & Body */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #fdfdfd;
            color: #333;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #b22222; /* Merah */
            color: #fff;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar .profile {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .sidebar nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar nav ul li {
            margin: 15px 0;
        }

        .sidebar nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar nav ul li a:hover,
        .sidebar nav ul li.active a {
            background-color: #800000; /* Merah tua */
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 15px;
        }

        /* Data Pasien Section */
        .data-pasien {
            margin-top: 1px;
        }

        .data-pasien h2 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #b22222; /* Merah */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #b22222; /* Merah */
            color: #fff;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:hover {
            background-color: #ffe6e6; /* Merah muda */
        }

        /* Buttons */
        .btn {
            padding: 10px 15px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #b22222; /* Merah */
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #800000; /* Merah tua */
        }

        .btn-danger {
            background-color: #ff6347; /* Tomat */
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #cc2900; /* Merah gelap */
        }

        .btn-back {
        background-color: #b22222; /* Merah */
        color: #ffffff; /* Putih */
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .btn-back:hover {
        background-color: #800000; /* Merah tua */
        transform: scale(1.05); /* Efek memperbesar */
    }

    .btn-back:active {
        background-color: #cc0000; /* Merah lebih terang */
        transform: scale(0.95); /* Efek menekan */
    }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="profile">
            <img src="logo klinik kinasih.jpg" alt="Profile Picture" class="profile-img">
            <h3>Username</h3>
            <p>Staff Administrasi</p>
        </div>
        <nav>
            <ul>
                <li class="active"><a href="dashboard.php">Dashboard</a></li>
                <li><a href="daftar_pasien.php">Pendaftaran Pasien</a></li>
                <li><a href="data_pasien.php">Input Data Scrinning Pasien</a></li>
                <li><a href="data_screening.php">Data Scrinning Pasien</a></li>
               <li>
                <li><a href="rekam_medis.php">Input Rekam Medis Pasien</a></li>
               <li>
                <li><a href="hasil_rekam_medis.php">Hasil Rekam Medis Pasien</a></li>
               <li>
    <button type="button" onclick="window.location.href='index.php';" class="btn-back">Kembali</button>
</li>

            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <section class="data-pasien">
            <h2>Data Pendaftaran Pasien</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Pasien</th>
                        <th>Nama Pasien</th>
                        <th>NIK</th>
                        <th>Tanggal Lahir</th>
                        <th>Umur</th>
                        <th>Alamat</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $index => $patient): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($patient['nama_pasien']) ?></td>
                            <td><?= htmlspecialchars($patient['nik']) ?></td>
                            <td><?= htmlspecialchars($patient['tanggal_lahir']) ?></td>
                            <td><?= htmlspecialchars($patient['umur']) ?></td>
                            <td><?= htmlspecialchars($patient['alamat']) ?></td>
                            <td><?= htmlspecialchars($patient['tanggal_daftar']) ?></td>
                            <td>
                                <a href="edit_pasien.php?id=<?= $patient['id_pasien'] ?>" class="btn btn-primary">Edit</a>
                                <a href="hapus_pasien.php?id=<?= $patient['id_pasien'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
