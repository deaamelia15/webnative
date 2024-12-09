<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "klinikk");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pasien = $_POST['id_pasien'];
    $nama_pasien = $_POST['nama_pasien'];
    $poli = $_POST['poli'];
    $nama_dokter = $_POST['nama_dokter'];
    $diagnosis = $_POST['diagnosis'];
    $tanggal_rekam = date('Y-m-d');

    // Query insert data ke tabel rekam_medis
    $query = "INSERT INTO rekam_medis (id_pasien, nama_pasien, poli, nama_dokter, diagnosis, tanggal_rekam) 
              VALUES ('$id_pasien', '$nama_pasien', '$poli', '$nama_dokter', '$diagnosis', '$tanggal_rekam')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data rekam medis berhasil disimpan!');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Rekam Medis</title>
     <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: #b22222;
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

        .form-group input:focus,
        .form-group select:focus {
            border-color: #b22222;
            outline: none;
        }

        .form-group button,
        .form-group a.btn-back {
            background-color: #b22222;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .form-group button:hover,
        .form-group a.btn-back:hover {
            background-color: #800000;
        }

        .form-group a.btn-back {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Input Rekam Medis</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="id_pasien">ID Pasien:</label>
                <input type="text" id="id_pasien" name="id_pasien" required>
            </div>
            <div class="form-group">
                <label for="nama_pasien">Nama Pasien:</label>
                <input type="text" id="nama_pasien" name="nama_pasien" required>
            </div>
            <div class="form-group">
                <label for="poli">Poli:</label>
                <select id="poli" name="poli" required>
                    <option value="">Pilih Poli</option>
                    <option value="Umum">Umum</option>
                    <option value="Gigi">Gigi</option>
                    <option value="Kandungan">Kandungan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nama_dokter">Nama Dokter:</label>
                <input type="text" id="nama_dokter" name="nama_dokter" required>
            </div>
            <div class="form-group">
                <label for="diagnosis">Diagnosis:</label>
                <input type="text" id="diagnosis" name="diagnosis" required>
            </div>
            <div class="form-group">
                <label for="tanggal_rekam">Tanggal Rekam:</label>
                <input type="date" id="tanggal_rekam" name="tanggal_rekam" required>
            </div>
            <div class="form-group">
                <button type="submit">Simpan Data</button>
                <a href="dashboard.php" class="btn-back">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>
