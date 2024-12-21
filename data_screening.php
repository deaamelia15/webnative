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

// Mengambil data screening pasien
$sql = "SELECT dp.nik AS nik_pasien, dp.berat_badan, dp.tinggi_badan, dp.tekanan_darah, dp.keluhan, dp.diagnosis, dp2.nama_pasien
        FROM data_pasien dp
        JOIN daftar_pasien dp2 ON dp.nik = dp2.nik";
$result = $conn->query($sql);

// Memeriksa apakah query berhasil
if (!$result) {
    die("Query gagal: " . $conn->error);  // Menampilkan pesan kesalahan query jika gagal
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Screening Pasien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #cd1111;
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-left: 10px solid #D32F2F;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #cd1111;
            color: white;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #cd1111;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #a00;
        }

        .action-btn {
            padding: 5px 10px;
            font-size: 14px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        /* Edit button */
.edit-btn {
    background-color: #c11111; /* Merah */
    color: white;
}

.edit-btn:hover {
    background-color: #c62828; /* Merah lebih gelap saat hover */
}

/* Hapus button */
.hapus-btn {
    background-color: #c11111; /* Merah */
    color: white;
}

.hapus-btn:hover {
    background-color: #c62828; /* Merah lebih gelap saat hover */
}

    </style>
</head>
<body>

    <h1>Data Screening Pasien</h1>

    <div class="container">
        <?php if ($result->num_rows > 0): ?>
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nik_pasien'] ?? 'Data tidak tersedia') ?></td>
                            <td><?= htmlspecialchars($row['nama_pasien'] ?? 'Data tidak tersedia') ?></td>
                            <td><?= htmlspecialchars($row['berat_badan'] ?? 'Data tidak tersedia') ?></td>
                            <td><?= htmlspecialchars($row['tinggi_badan'] ?? 'Data tidak tersedia') ?></td>
                            <td><?= htmlspecialchars($row['tekanan_darah'] ?? 'Data tidak tersedia') ?></td>
                            <td><?= htmlspecialchars($row['keluhan'] ?? 'Data tidak tersedia') ?></td>
                            <td><?= htmlspecialchars($row['diagnosis'] ?? 'Data tidak tersedia') ?></td>
                            <td>
                            <a href="edit_screening.php?nik=<?= urlencode($row['nik_pasien']) ?>" class="action-btn edit-btn">Edit</a>
                            <a href="hapus_screening.php?nik=<?= urlencode($row['nik_pasien']) ?>" class="action-btn hapus-btn">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada data screening pasien.</p>
        <?php endif; ?>
    </div>

    <div class="btn-container">
        <a href="dashboard.php" class="btn">Kembali ke Dashboard</a>
    </div>

</body>
</html>
