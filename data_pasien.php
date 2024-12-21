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

// Menyiapkan query SQL untuk mengambil NIK dan nama pasien
$sql = "SELECT nik, nama_pasien FROM daftar_pasien"; // Mengambil NIK dan Nama Pasien dari tabel daftar_pasien
$result = $conn->query($sql);

// Menangani form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = $_POST['nik'];
    $berat_badan = $_POST['berat_badan'];
    $tinggi_badan = $_POST['tinggi_badan'];
    $tekanan_darah = $_POST['tekanan_darah'];
    $keluhan = $_POST['keluhan'];
    $diagnosis = $_POST['diagnosis'];

    // Menyiapkan query SQL untuk menyimpan data
    $stmt = $conn->prepare("INSERT INTO data_pasien (nik, berat_badan, tinggi_badan, tekanan_darah, keluhan, diagnosis) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    // Mengikat parameter
    $stmt->bind_param("iiisss", $nik, $berat_badan, $tinggi_badan, $tekanan_darah, $keluhan, $diagnosis);

    // Menjalankan query
    if ($stmt->execute()) {
        // Redirect ke halaman data_screening setelah data berhasil disimpan
        header("Location: data_screening.php");
        exit(); // Pastikan eksekusi script dihentikan setelah redirect
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    // Menutup statement
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Screening</title>
    <style>
        /* Style CSS Anda */
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

        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-left: 10px solid #D32F2F;
        }

        .form-container h2 {
            color: #D32F2F;
            text-align: center;
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            color: #cd1111;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .button-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            text-align: center;
            font-size: 16px;
            padding: 12px 20px;
            border-radius: 6px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s ease-in-out;
            font-weight: bold;
            text-decoration: none;
        }

        .btn-submit {
            background-color: #cd1111;
            border: 2px solid #cd1111;
        }

        .btn-submit:hover {
            background-color: #B71C1C;
            border-color: #B71C1C;
            transform: translateY(-2px);
        }

        .btn-submit:active {
            background-color: #8E0000;
            border-color: #8E0000;
            transform: translateY(0);
        }

        .btn-back {
            background-color: #a40000;
            border: 2px solid #a40000;
        }

        .btn-back:hover {
            background-color: #a40000;
            border-color: #a40000;
            transform: translateY(-2px);
        }

        .btn-back:active {
            background-color: #a40000;
            border-color: #a40000;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <h1>Input Data Screening</h1>

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
