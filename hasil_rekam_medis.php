<?php
include 'koneksi.php';

// Query untuk mengambil data dari rekam_medis yang sudah dihubungkan dengan tabel daftar_pasien

$query = "SELECT rm.id_pasien, dp.nama_pasien, rm.poli, rm.nama_dokter, rm.diagnosis, rm.tanggal_rekam 
          FROM rekam_medis rm
          JOIN daftar_pasien dp ON rm.id_pasien = dp.id_pasien";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error dalam query: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Rekam Medis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .table-container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .table-container h2 {
            text-align: center;
            color: #b22222;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead {
            background-color: #b22222;
            color: #fff;
        }

        table th, table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s;
            color: #fff;
        }

        .btn-edit {
            background-color: #28a745;
        }

        .btn-edit:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-back {
            display: inline-block;
            text-decoration: none;
            background-color: #b22222;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #800000;
        }
    </style>
</head>
<body>
    <div class="table-container">
        <h2>Data Rekam Medis</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Pasien</th>
                    <th>Nama Pasien</th>
                    <th>Poli</th>
                    <th>Nama Dokter</th>
                    <th>Diagnosis</th>
                    <th>Tanggal Rekam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id_pasien']}</td>
                                <td>{$row['nama_pasien']}</td>
                                <td>{$row['poli']}</td>
                                <td>{$row['nama_dokter']}</td>
                                <td>{$row['diagnosis']}</td>
                                <td>{$row['tanggal_rekam']}</td>
                                <td>
                                    <a href='edit_rekam_medis.php?id={$row['id_pasien']}' class='btn btn-edit'>Edit</a>
                                    <a href='hapus_rekam_medis.php?id={$row['id_pasien']}' class='btn btn-delete' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?')\">Hapus</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align: center;'>Belum ada data rekam medis.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="btn-back">Kembali</a>
    </div>
</body>
</html>
