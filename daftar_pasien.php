<?php
include 'koneksi.php'; // Pastikan file koneksi sudah benar

// Proses penyimpanan data jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pasien = $_POST['nama_pasien'];
    $nik = $_POST['nik'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $umur = intval($_POST['umur']);
    $alamat = $_POST['alamat'];
    $tanggal_daftar = date("Y-m-d"); // Tanggal daftar otomatis dari sistem

    // Periksa apakah NIK sudah ada di tabel data_pasien
    $query_check = "SELECT id_data FROM data_pasien WHERE nik = ?";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bind_param("s", $nik);
    $stmt_check->execute();
    $stmt_check->bind_result($id_data);
    $stmt_check->fetch();
    $stmt_check->close();

    if (!$id_data) {
        // Jika NIK belum ada, tambahkan ke tabel data_pasien
        $query_insert_data = "INSERT INTO data_pasien (nik, nama_pasien, tanggal_lahir, alamat) VALUES (?, ?, ?, ?)";
        $stmt_insert_data = $conn->prepare($query_insert_data);
        $stmt_insert_data->bind_param("ssss", $nik, $nama_pasien, $tanggal_lahir, $alamat);
        $stmt_insert_data->execute();
        $id_data = $stmt_insert_data->insert_id; // Ambil ID yang baru saja dibuat
        $stmt_insert_data->close();
    }

    // Cari nomor antrean terakhir untuk tanggal ini
    $query_antrian = "SELECT MAX(no_antrian) FROM daftar_pasien WHERE tanggal_daftar = ?";
    $stmt_antrian = $conn->prepare($query_antrian);
    $stmt_antrian->bind_param("s", $tanggal_daftar);
    $stmt_antrian->execute();
    $stmt_antrian->bind_result($no_antrian_terakhir);
    $stmt_antrian->fetch();
    $stmt_antrian->close();

    $no_antrian = $no_antrian_terakhir ? $no_antrian_terakhir + 1 : 1; // Tambahkan antrean jika ada, atau mulai dari 1

    // Simpan data ke tabel daftar_pasien
    $query_insert_pasien = "INSERT INTO daftar_pasien (nik, nama_pasien, tanggal_lahir, umur, alamat, tanggal_daftar, no_antrian, id_data)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert_pasien = $conn->prepare($query_insert_pasien);
    $stmt_insert_pasien->bind_param("sssissii", $nik, $nama_pasien, $tanggal_lahir, $umur, $alamat, $tanggal_daftar, $no_antrian, $id_data);

    if ($stmt_insert_pasien->execute()) {
        $id_pasien = $stmt_insert_pasien->insert_id; // Ambil ID pasien yang baru saja dimasukkan
        header("Location: daftar_pasien.php?id_pasien=$id_pasien"); // Redirect untuk menampilkan slip
        exit();
    } else {
        echo "Error: " . $stmt_insert_pasien->error;
    }
}
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
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }
        h1 {
            color: #b30000;
            text-align: center;
        }
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #b30000;
            border-radius: 5px;
            margin-bottom: 20px;
            max-width: 500px;
            margin: 0 auto;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-container input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #b30000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #e60000;
        }
        .slip {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #b30000;
            border-radius: 5px;
            text-align: center;
        }
        .slip p {
            margin: 10px 0;
            font-size: 16px;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #b30000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .back-button:hover {
            background-color: #e60000;
        }
    </style>
</head>
<body>

<h1>Form Input dan Slip Pasien</h1>

<div class="form-container">
    <form method="POST" action="">
        <label for="nama_pasien">Nama Pasien</label>
        <input type="text" id="nama_pasien" name="nama_pasien" required>

        <label for="nik">NIK</label>
        <input type="text" id="nik" name="nik" required>

        <label for="tanggal_lahir">Tanggal Lahir</label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>

        <label for="umur">Umur</label>
        <input type="number" id="umur" name="umur" required>

        <label for="alamat">Alamat</label>
        <input type="text" id="alamat" name="alamat" required>

        <button type="submit">Simpan dan Tampilkan Slip</button>
    </form>
</div>

<?php
// Tampilkan slip pasien jika ID pasien ada di URL
if (isset($_GET['id_pasien'])) {
    $id_pasien = intval($_GET['id_pasien']);
    $query = "SELECT * FROM daftar_pasien WHERE id_pasien = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pasien);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        ?>
        <div class="slip">
            <h2>Slip Pasien</h2>
            <p><strong>Nama Pasien:</strong> <?php echo $data['nama_pasien']; ?></p>
            <p><strong>NIK:</strong> <?php echo $data['nik']; ?></p>
            <p><strong>Tanggal Lahir:</strong> <?php echo $data['tanggal_lahir']; ?></p>
            <p><strong>Umur:</strong> <?php echo $data['umur']; ?> tahun</p>
            <p><strong>Alamat:</strong> <?php echo $data['alamat']; ?></p>
            <p><strong>Tanggal Daftar:</strong> <?php echo $data['tanggal_daftar']; ?></p>
            <p><strong>Nomor Antrian:</strong> <?php echo $data['no_antrian']; ?></p>
            <!-- Tombol Kembali -->
            <a href="index.php" class="back-button">Kembali ke Halaman Index</a>
        </div>
        <?php
    } else {
        echo "<p style='color:red; text-align:center;'>Data pasien tidak ditemukan.</p>";
    }
}
?>

</body>
</html>
