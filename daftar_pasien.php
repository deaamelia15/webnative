<?php
$host = "localhost";       // Host default untuk MySQL
$username = "root";        // Username default XAMPP adalah 'root'
$password = "";            // Password default XAMPP adalah kosong
$database = "db_klinik";   // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambahkan data pasien jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = $_POST['nik'];
    $nama_pasien = $_POST['nama_pasien'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $umur = $_POST['umur'];
    $alamat = $_POST['alamat'];

    // Mendapatkan nomor antrian terbaru
    $sql = "SELECT MAX(no_antrian) AS max_antrian FROM daftar_pasien";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $no_antrian = $row['max_antrian'] + 1;  // Tambahkan 1 untuk nomor antrian berikutnya

    // Memeriksa apakah nomor antrian sudah ada
    while (true) {
        // Cek apakah no_antrian sudah ada di database
        $check_sql = "SELECT COUNT(*) AS count FROM daftar_pasien WHERE no_antrian = $no_antrian";
        $check_result = $conn->query($check_sql);
        $check_row = $check_result->fetch_assoc();

        // Jika no_antrian belum ada, break dari loop
        if ($check_row['count'] == 0) {
            break;
        }

        // Jika no_antrian sudah ada, coba nomor berikutnya
        $no_antrian++;
    }

    // Insert data pasien dengan no_antrian yang baru
    $insert_sql = "INSERT INTO daftar_pasien (nik, nama_pasien, tanggal_lahir, umur, alamat, tanggal_daftar, no_antrian)
                   VALUES ('$nik', '$nama_pasien', '$tanggal_lahir', $umur, '$alamat', CURDATE(), $no_antrian)";

    if ($conn->query($insert_sql) === TRUE) {
        echo  "" . $no_antrian;
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}

// Ambil data pasien
$sql = "SELECT * FROM daftar_pasien"; // Pastikan query ini benar
$result = $conn->query($sql); // Jalankan query

// Cek apakah query berhasil
if (!$result) {
    die("Query gagal: " . $conn->error); // Menangani kesalahan SQL
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pasien</title>
    <style>
        body {
            background-color: #a40000; /* Warna merah gelap */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: white;
            background-color: #a40000;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #a40000;
        }

        form input[type="text"],
        form input[type="date"],
        form input[type="number"],
        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #a40000;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form button {
            background-color: #a40000;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }

        form button:hover {
            background-color: #800000; /* Warna merah lebih gelap */
        }

        form button:last-child {
            background-color: #333; /* Warna tombol kembali */
        }

        form button:last-child:hover {
            background-color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #a40000;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .table-container {
            overflow-x: auto; /* Untuk membuat tabel responsive */
        }

        /* Tombol Kembali dengan warna merah */
        .back-button {
            background-color: #a40000;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            display: inline-block;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #800000; /* Warna merah lebih gelap */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Pasien</h1>

        <form method="POST" action="">
            <label>NIK:</label>
            <input type="text" name="nik" required>
            <label>Nama Pasien:</label>
            <input type="text" name="nama_pasien" required>
            <label>Tanggal Lahir:</label>
            <input type="date" name="tanggal_lahir" required>
            <label>Umur:</label>
            <input type="number" name="umur" required>
            <label>Alamat:</label>
            <textarea name="alamat" required></textarea>
            <button type="submit">Daftar</button>
        <a href="index.php" class="back-button">Kembali</a>
        </form>

        <h2>Data Pasien</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Tanggal Lahir</th>
                    <th>Umur</th>
                    <th>Alamat</th>
                    <th>Tanggal Daftar</th>
                    <th>No. Antrian</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_pasien'] ?></td>
                    <td><?= $row['nik'] ?></td>
                    <td><?= $row['nama_pasien'] ?></td>
                    <td><?= $row['tanggal_lahir'] ?></td>
                    <td><?= $row['umur'] ?></td>
                    <td><?= $row['alamat'] ?></td>
                    <td><?= $row['tanggal_daftar'] ?></td>
                    <td><?= $row['no_antrian'] ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
