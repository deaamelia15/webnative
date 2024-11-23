<?php
// Koneksi database
$conn = new mysqli("localhost", "root", "", "klinikk");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Proses penyimpanan data ke database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $umur = $_POST['umur'];
    $alamat = $_POST['alamat'];

    $insertQuery = "INSERT INTO daftar_pasien (nik, nama_pasien, tanggal_lahir, umur, alamat) 
                    VALUES ('$nik', '$nama', '$tanggal_lahir', '$umur', '$alamat')";

    if ($conn->query($insertQuery) === TRUE) {
        // Ambil id_pasien yang baru saja disimpan
        $last_id = $conn->insert_id;
        
        // Redirect ke slip_pasien.php setelah data berhasil disimpan
        header("Location: slip_pasien.php?id_pasien=$last_id");
        exit();
    } else {
        echo "<script>alert('Pendaftaran gagal: " . $conn->error . "');</script>";
    }
}

// Ambil data pasien dari database
$query = "SELECT * FROM daftar_pasien";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pasien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #b30000; /* Latar belakang putih */
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #ffffff; /* Teks merah */
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff; /* Latar belakang tabel putih */
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #b30000; /* Border tabel merah */
        }
        th {
            background-color: #ffcccc; /* Header tabel merah muda */
            color: #b30000; /* Teks header merah */
        }
        td {
            color: #b30000; /* Teks merah */
        }
        form {
            background-color: #ffffff; /* Latar belakang form merah muda */
            padding: 20px;
            border: 1px solid #b30000; /* Border form merah */
            border-radius: 5px;
            margin-bottom: 20px;
        }
        form div {
            margin-bottom: 10px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #b30000; /* Label merah */
        }
        input[type="text"], input[type="number"], input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #b30000; /* Border input merah */
            border-radius: 5px;
            background-color: #ffffff; /* Latar belakang input putih */
            color: #b30000; /* Teks input merah */
        }
        button {
            padding: 10px 15px;
            background-color: #b30000; /* Tombol merah */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #e60000; /* Tombol merah gelap saat hover */
        }
        a {
            text-decoration: none;
            color: #b30000; /* Link merah */
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Form Pendaftaran -->
    <h2>Form Pendaftaran Pasien</h2>
    <form method="POST" action="">
        <div>
            <label for="nik">NIK:</label>
            <input type="text" id="nik" name="nik" required>
        </div>
        <div>
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        <div>
            <label for="tanggal_lahir">Tanggal Lahir:</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
        </div>
        <div>
            <label for="umur">Umur:</label>
            <input type="number" id="umur" name="umur" required>
        </div>
        <div>
            <label for="alamat">Alamat:</label>
            <input type="text" id="alamat" name="alamat" required>
        </div>
        <button type="submit">Daftar</button>
        <button type="button" onclick="window.location.href='dashboard.php';">Kembali</button>
    </form>

</body>
</html>
