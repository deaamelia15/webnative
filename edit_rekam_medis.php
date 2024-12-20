<?php
include 'koneksi.php';

// Mengambil data berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM rekam_medis WHERE id_pasien = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location='hasil_rekam_medis.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID tidak diberikan!'); window.location='hasil_rekam_medis.php';</script>";
    exit;
}

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPasien = $_POST['id_pasien'];
    $poli = $_POST['poli'];
    $namaDokter = $_POST['nama_dokter'];
    $diagnosis = $_POST['diagnosis'];
    $tanggalRekam = $_POST['tanggal_rekam'];

    $sqlUpdate = "UPDATE rekam_medis SET 
                  poli='$poli', nama_dokter='$namaDokter', diagnosis='$diagnosis', tanggal_rekam='$tanggalRekam'
                  WHERE id_pasien='$idPasien'";

    if ($conn->query($sqlUpdate) === TRUE) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='hasil_rekam_medis.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rekam Medis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .form-container h2 {
            color: #b22222;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-group button {
            width: 100%;
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-group button:hover {
            background-color: #218838;
        }

        .btn-back {
            text-decoration: none;
            display: block;
            margin-top: 10px;
            text-align: center;
            background-color: #b22222;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #800000;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Rekam Medis</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="id_pasien">ID Pasien:</label>
                <input type="text" id="id_pasien" name="id_pasien" value="<?= isset($row['id_pasien']) ? htmlspecialchars($row['id_pasien']) : '' ?>" readonly>
            </div>
            <div class="form-group">
                <label for="nama_pasien">Nama Pasien:</label>
                <input type="text" id="nama_pasien" name="nama_pasien" value="<?= isset($row['nama_pasien']) ? htmlspecialchars($row['nama_pasien']) : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="poli">Poli:</label>
                <select id="poli" name="poli" required>
                    <option value="Umum" <?= isset($row['poli']) && $row['poli'] == 'Umum' ? 'selected' : '' ?>>Umum</option>
                    <option value="Gigi" <?= isset($row['poli']) && $row['poli'] == 'Gigi' ? 'selected' : '' ?>>Gigi</option>
                    <option value="Kandungan" <?= isset($row['poli']) && $row['poli'] == 'Kandungan' ? 'selected' : '' ?>>Kandungan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nama_dokter">Nama Dokter:</label>
                <input type="text" id="nama_dokter" name="nama_dokter" value="<?= isset($row['nama_dokter']) ? htmlspecialchars($row['nama_dokter']) : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="diagnosis">Diagnosis:</label>
                <input type="text" id="diagnosis" name="diagnosis" value="<?= isset($row['diagnosis']) ? htmlspecialchars($row['diagnosis']) : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggal_rekam">Tanggal Rekam:</label>
                <input type="date" id="tanggal_rekam" name="tanggal_rekam" value="<?= isset($row['tanggal_rekam']) ? htmlspecialchars($row['tanggal_rekam']) : '' ?>" required>
            </div>
            <div class="form-group">
                <button type="submit">Simpan Perubahan</button>
            </div>
            <a href="hasil_rekam_medis.php" class="btn-back">Kembali</a>
        </form>
    </div>
</body>
</html>
