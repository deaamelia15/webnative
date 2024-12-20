<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Variabel untuk menampilkan pesan
$message = "";

// Ambil data pasien
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    $sql = "SELECT * FROM daftar_pasien WHERE id_pasien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    } else {
        $message = "Data pasien tidak ditemukan.";
    }
    $stmt->close();
} else {
    $message = "ID pasien tidak valid.";
}

// Proses update data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nik = $_POST['nik'] ?? '';
    $nama_pasien = $_POST['nama_pasien'] ?? '';
    $tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
    $umur = $_POST['umur'] ?? '';
    $alamat = $_POST['alamat'] ?? '';

    if (!empty($nik) && !empty($nama_pasien) && !empty($tanggal_lahir) && !empty($umur) && !empty($alamat)) {
        $sql = "UPDATE daftar_pasien 
                SET nik = ?, nama_pasien = ?, tanggal_lahir = ?, umur = ?, alamat = ?, tanggal_daftar = CURRENT_DATE 
                WHERE id_pasien = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisi", $nik, $nama_pasien, $tanggal_lahir, $umur, $alamat, $id);

        if ($stmt->execute()) {
            $message = "Data pasien berhasil diperbarui.";
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Gagal memperbarui data pasien: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Semua field harus diisi.";
    }
}

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pasien</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #fdf1f0; /* Latar belakang merah muda lembut */
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    h1 {
        text-align: center;
        color: #cd1111; /* Warna merah tema utama */
    }

    form {
        margin-top: 20px;
    }

    label {
        font-size: 16px;
        color: #333;
    }

    input[type="text"], input[type="date"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #cd1111; /* Warna merah tombol utama */
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #c0392b; /* Warna merah lebih gelap untuk hover */
    }

    .message {
        text-align: center;
        margin: 20px 0;
        font-size: 14px;
        color: #cd1111; /* Warna merah tema */
    }

    .success {
        color: #2ecc71; /* Warna hijau untuk pesan sukses */
    }
</style>

</head>
<body>
    <div class="container">
        <h1>Edit Data Pasien</h1>

        <?php if (!empty($message)): ?>
            <div class="message <?= strpos($message, 'berhasil') !== false ? 'success' : '' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($patient)): ?>
            <form method="POST">
    <label for="nik">NIK:</label>
    <input type="text" id="nik" name="nik" value="<?= htmlspecialchars($patient['nik']) ?>" required>

    <label for="nama_pasien">Nama Pasien:</label>
    <input type="text" id="nama_pasien" name="nama_pasien" value="<?= htmlspecialchars($patient['nama_pasien']) ?>" required>

    <label for="tanggal_lahir">Tanggal Lahir:</label>
    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?= htmlspecialchars($patient['tanggal_lahir']) ?>" required>

    <label for="umur">Umur:</label>
    <input type="text" id="umur" name="umur" value="<?= htmlspecialchars($patient['umur']) ?>" required>

    <label for="alamat">Alamat:</label>
    <input type="text" id="alamat" name="alamat" value="<?= htmlspecialchars($patient['alamat']) ?>" required>

    <label for="tanggal_daftar">Tanggal Daftar:</label>
    <input type="date" id="tanggal_daftar" name="tanggal_daftar" value="<?= date('Y-m-d') ?>" readonly>

    <input type="submit" value="Update">
</form>

        <?php else: ?>
            <p>Data tidak tersedia untuk diedit.</p>
        <?php endif; ?>
    </div>
</body>
</html>
