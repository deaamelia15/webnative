<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Proses input data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik = isset($_POST['nik']) ? trim($_POST['nik']) : '';
    $berat_badan = isset($_POST['berat_badan']) ? (float) trim($_POST['berat_badan']) : 0;
    $tinggi_badan = isset($_POST['tinggi_badan']) ? (float) trim($_POST['tinggi_badan']) : 0;
    $tekanan_darah = isset($_POST['tekanan_darah']) ? trim($_POST['tekanan_darah']) : '';
    $keluhan = isset($_POST['keluhan']) ? trim($_POST['keluhan']) : '';
    $diagnosis = isset($_POST['diagnosis']) ? trim($_POST['diagnosis']) : '';

    if (!empty($nik) && $berat_badan > 0 && $tinggi_badan > 0 && !empty($tekanan_darah) && !empty($keluhan)) {
        // Validasi apakah NIK ada di tabel daftar_pasien
        $check_sql = "SELECT id_pasien, nama_pasien FROM daftar_pasien WHERE nik = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("s", $nik);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nama_pasien = $row['nama_pasien'];

            // Simpan data screening ke tabel data_pasien
            $sql = "INSERT INTO data_pasien (nik, nama_pasien, berat_badan, tinggi_badan, tekanan_darah, keluhan, diagnosis) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdssss", $nik, $nama_pasien, $berat_badan, $tinggi_badan, $tekanan_darah, $keluhan, $diagnosis);
            
            if ($stmt->execute()) {
                header("Location: data_screening.php");
                exit();
            } else {
                $error_message = "Gagal menyimpan data: " . $stmt->error;
            }
        } else {
            $error_message = "NIK tidak ditemukan di daftar pasien!";
        }
    } else {
        $error_message = "Semua field wajib diisi dengan benar!";
    }
}

// Ambil data NIK dan nama pasien untuk dropdown
$query = "SELECT nik, nama_pasien FROM daftar_pasien";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Screening</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #fff; color: #333; margin: 0; padding: 20px; }
        h1 { color: #cd1111; text-align: center; }
        .form-container { max-width: 600px; margin: auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-left: 10px solid #D32F2F; }
        .form-container h2 { color: #D32F2F; text-align: center; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; color: #cd1111; font-weight: bold; margin-bottom: 5px; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .button-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            text-align: center;
            font-size: 16px;
            padding: 10px 15px;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-submit {
            background-color: #cd1111;
        }
        .btn-submit:hover {
            background-color: #B71C1C;
        }
        .btn-back {
            background-color: #cd1111;
        }
        .btn-back:hover {
            background-color: #B71C1C;
        }
    </style>
</head>
<body>
    <h1>Input Data Screening</h1>
    <?php if (isset($error_message)): ?>
        <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <div class="form-container">
        <h2>Form Screening</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nik">NIK</label>
                <select id="nik" name="nik" required>
                    <option value="">Pilih NIK</option>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['nik']) . "'>" . htmlspecialchars($row['nik']) . " - " . htmlspecialchars($row['nama_pasien']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="berat_badan">Berat Badan (kg)</label>
                <input type="number" id="berat_badan" name="berat_badan" required>
            </div>
            <div class="form-group">
                <label for="tinggi_badan">Tinggi Badan (cm)</label>
                <input type="number" id="tinggi_badan" name="tinggi_badan" required>
            </div>
            <div class="form-group">
                <label for="tekanan_darah">Tekanan Darah (mmHg)</label>
                <input type="text" id="tekanan_darah" name="tekanan_darah" required>
            </div>
            <div class="form-group">
                <label for="keluhan">Keluhan</label>
                <textarea id="keluhan" name="keluhan" required></textarea>
            </div>
            <div class="form-group">
                <label for="diagnosis">Diagnosis</label>
                <textarea id="diagnosis" name="diagnosis"></textarea>
            </div>
            <div class="button-container">
                <button type="submit" class="btn btn-submit">Simpan</button>
                <a href="dashboard.php" class="btn btn-back">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>
