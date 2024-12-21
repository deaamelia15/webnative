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

// Memeriksa apakah ada data yang dikirim melalui metode GET
if (isset($_GET['nik'])) {
    $nik = $conn->real_escape_string($_GET['nik']);

    // Mendapatkan data pasien berdasarkan NIK
    $sql = "SELECT * FROM data_pasien WHERE nik = '$nik'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
}

// Memproses form edit jika data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik = $conn->real_escape_string($_POST['nik']);
    $nama_pasien = $conn->real_escape_string($_POST['nama_pasien']);
    $berat_badan = $conn->real_escape_string($_POST['berat_badan']);
    $tinggi_badan = $conn->real_escape_string($_POST['tinggi_badan']);
    $tekanan_darah = $conn->real_escape_string($_POST['tekanan_darah']);
    $keluhan = $conn->real_escape_string($_POST['keluhan']);
    $diagnosis = $conn->real_escape_string($_POST['diagnosis']);

    // Update data pasien
    $sql = "UPDATE data_pasien 
            SET nama_pasien = '$nama_pasien', berat_badan = '$berat_badan', tinggi_badan = '$tinggi_badan', tekanan_darah = '$tekanan_darah', keluhan = '$keluhan', diagnosis = '$diagnosis' 
            WHERE nik = '$nik'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='data_screening.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Screening</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #cd1111;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #cd1111;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #a00;
        }

        button:focus {
            outline: none;
        }

        input[type="text"]:focus, textarea:focus {
            border-color: #cd1111;
        }

        @media screen and (max-width: 600px) {
            .container {
                width: 90%;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Data Screening</h1>
    <form method="POST">
        <input type="hidden" name="nik" value="<?= htmlspecialchars($data['nik']) ?>">
        <label for="nama_pasien">Nama Pasien</label>
        <input type="text" id="nama_pasien" name="nama_pasien" value="<?= htmlspecialchars($data['nama_pasien']) ?>" required>

        <label for="berat_badan">Berat Badan</label>
        <input type="text" id="berat_badan" name="berat_badan" value="<?= htmlspecialchars($data['berat_badan']) ?>" required>

        <label for="tinggi_badan">Tinggi Badan</label>
        <input type="text" id="tinggi_badan" name="tinggi_badan" value="<?= htmlspecialchars($data['tinggi_badan']) ?>" required>

        <label for="tekanan_darah">Tekanan Darah</label>
        <input type="text" id="tekanan_darah" name="tekanan_darah" value="<?= htmlspecialchars($data['tekanan_darah']) ?>" required>

        <label for="keluhan">Keluhan</label>
        <textarea id="keluhan" name="keluhan" required><?= htmlspecialchars($data['keluhan']) ?></textarea>

        <label for="diagnosis">Diagnosis</label>
        <textarea id="diagnosis" name="diagnosis" required><?= htmlspecialchars($data['diagnosis']) ?></textarea>

        <button type="submit">Simpan Perubahan</button>
    </form>
</div>

</body>
</html>
