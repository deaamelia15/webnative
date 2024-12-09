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

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menangani pengambilan data berdasarkan ID pasien
if (isset($_GET['id_data'])) {
    $id_data = $_GET['id_data'];

    // Mengambil data pasien berdasarkan ID
    $sql = "SELECT * FROM data_pasien WHERE id_data = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_data);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    } else {
        echo "Data pasien tidak ditemukan.";
        exit();
    }
} else {
    echo "ID data pasien tidak ditemukan.";
    exit();
}

// Menangani pengeditan data pasien
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $nama_pasien = $_POST['nama_pasien'];
    $berat_badan = $_POST['berat_badan'];
    $tinggi_badan = $_POST['tinggi_badan'];
    $tekanan_darah = $_POST['tekanan_darah'];
    $keluhan = $_POST['keluhan'];
    $diagnosis = $_POST['diagnosis'];

    // Update data pasien
    $update_sql = "UPDATE data_pasien SET nik = ?, nama_pasien = ?, berat_badan = ?, tinggi_badan = ?, tekanan_darah = ?, keluhan = ?, diagnosis = ? WHERE id_data = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssiiissi", $nik, $nama_pasien, $berat_badan, $tinggi_badan, $tekanan_darah, $keluhan, $diagnosis, $id_data);

    if ($stmt->execute()) {
        header("Location: data_screening.php");
        exit();
    } else {
        echo "Gagal memperbarui data pasien.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Screening Pasien</title>
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
            color: #b22222;
            margin-bottom: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #b22222;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            cursor: pointer;
        }

        button:hover {
            background-color: #c0392b;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #b22222;
            font-size: 0.9em;
            text-align: center;
        }

        a:hover {
            color: #c0392b;
        }
    </style>
</head>
<body>
<h1>Edit Data Screening Pasien</h1>

<div class="container">
    <form action="edit_screening.php?id_data=<?= $patient['id_data'] ?>" method="POST">
        <label for="nik">NIK:</label>
        <input type="text" name="nik" value="<?= htmlspecialchars($patient['nik']) ?>" required>

        <label for="nama_pasien">Nama Pasien:</label>
        <input type="text" name="nama_pasien" value="<?= htmlspecialchars($patient['nama_pasien']) ?>" required>

        <label for="berat_badan">Berat Badan (kg):</label>
        <input type="number" name="berat_badan" value="<?= htmlspecialchars($patient['berat_badan']) ?>" required>

        <label for="tinggi_badan">Tinggi Badan (cm):</label>
        <input type="number" name="tinggi_badan" value="<?= htmlspecialchars($patient['tinggi_badan']) ?>" required>

        <label for="tekanan_darah">Tekanan Darah:</label>
        <input type="text" name="tekanan_darah" value="<?= htmlspecialchars($patient['tekanan_darah']) ?>" required>

        <label for="keluhan">Keluhan:</label>
        <textarea name="keluhan" required><?= htmlspecialchars($patient['keluhan']) ?></textarea>

        <label for="diagnosis">Diagnosis:</label>
        <textarea name="diagnosis" required><?= htmlspecialchars($patient['diagnosis']) ?></textarea>

        <button type="submit">Simpan Perubahan</button>
    </form>

    <a href="data_screening.php">Kembali ke Data Screening</a>
</div>

</body>
</html>
