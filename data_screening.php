<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Inisialisasi array untuk data pasien
$patients = [];

// Mengambil data pasien
$sql = "SELECT * FROM data_pasien";
$result = $conn->query($sql);

// Cek apakah query berhasil dan ada data pasien
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
} else {
    $message = "Tidak ada data pasien.";
}

// Menangani penghapusan data pasien
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Menghapus data dari database
    $delete_sql = "DELETE FROM data_pasien WHERE id_data = ?";
    $stmt = $conn->prepare($delete_sql);

    // Periksa apakah prepare berhasil
    if ($stmt) {
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            header("Location: data_screening.php?message=success");
            exit();
        } else {
            echo "Gagal menghapus data pasien.";
        }
    } else {
        echo "Gagal mempersiapkan query: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Screening Pasien</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #cd1111;
            margin-bottom: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
            background-color: #cd1111;
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

        .btn {
            padding: 8px 12px;
            border: none;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9em;
            cursor: pointer;
        }

        .btn-delete {
            background-color: #cd1111;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        p {
            text-align: center;
            color: #e74c3c;
            font-size: 1.2em;
            margin-top: 20px;
        }

        a {
            display: inline-block;
            padding: 10px 15px;
            background-color: #cd1111;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
        }

        a:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
<h1>Hasil Data Screening Pasien</h1>

<div class="container">
    <?php if (!empty($patients)): ?>
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
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?= htmlspecialchars($patient['nik']) ?></td>
                        <td><?= htmlspecialchars($patient['nama_pasien']) ?></td>
                        <td><?= htmlspecialchars($patient['berat_badan']) ?> kg</td>
                        <td><?= htmlspecialchars($patient['tinggi_badan']) ?> cm</td>
                        <td><?= htmlspecialchars($patient['tekanan_darah']) ?></td>
                        <td><?= htmlspecialchars($patient['keluhan']) ?></td>
                        <td><?= htmlspecialchars($patient['diagnosis']) ?></td>
                        <td>
                            <a href="data_screening.php?delete_id=<?= $patient['id_data']; ?>" 
                               onclick="return confirm('Yakin ingin menghapus data pasien ini?');" 
                               class="btn btn-delete">Hapus</a>
                               <a href="edit_screening.php?id_data=<?= $patient['id_data']; ?>" 
       onclick="return confirm('Yakin ingin mengedit data pasien ini?');" 
       class="btn btn-edit">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p><?= isset($message) ? $message : "Data screening belum ada."; ?></p>
    <?php endif; ?>
</div>

<a href="dashboard.php">Kembali</a>
</body>
</html>
