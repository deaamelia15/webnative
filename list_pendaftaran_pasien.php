<?php
$conn = new mysqli("localhost", "root", "", "klinikk");

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pasien = $_POST['id_pasien'];
    $nik = $_POST['nik'];
    $nama_pasien = $_POST['nama_pasien'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $umur = $_POST['umur'];
    $alamat = $_POST['alamat'];

    if ($id_pasien) {
        // Edit data pasien
        $stmt = $conn->prepare("UPDATE daftar_pasien SET nik=?, nama_pasien=?, tanggal_lahir=?, umur=?, alamat=? WHERE id_pasien=?");
        $stmt->bind_param("sssisi", $nik, $nama_pasien, $tanggal_lahir, $umur, $alamat, $id_pasien);
        $stmt->execute();
    } else {
        // Tambah data pasien
        $stmt = $conn->prepare("INSERT INTO daftar_pasien (nik, nama_pasien, tanggal_lahir, umur, alamat) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssisi", $nik, $nama_pasien, $tanggal_lahir, $umur, $alamat);
        $stmt->execute();
    }

    header("Location: list_pendaftaran_pasien.php");
    exit;
}

// Ambil data pasien jika ada ID (untuk Edit)
$edit_data = null;
if (isset($_GET['id_pasien'])) {
    $id_pasien = $_GET['id_pasien'];
    $result = $conn->query("SELECT * FROM daftar_pasien WHERE id_pasien='$id_pasien'");
    $edit_data = $result->fetch_assoc();
}

// Ambil semua data pasien untuk ditampilkan
$patients_result = $conn->query("SELECT * FROM daftar_pasien");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Pendaftaran Pasien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>List Pendaftaran Pasien</h1>

    <!-- Formulir untuk menambah atau mengedit data pasien -->
    <form method="POST">
        <input type="hidden" name="id_pasien" value="<?= $edit_data['id_pasien'] ?? '' ?>">
        <label>NIK:</label>
        <input type="text" name="nik" value="<?= $edit_data['nik'] ?? '' ?>" required>
        <label>Nama Pasien:</label>
        <input type="text" name="nama_pasien" value="<?= $edit_data['nama_pasien'] ?? '' ?>" required>
        <label>Tanggal Lahir:</label>
        <input type="date" name="tanggal_lahir" value="<?= $edit_data['tanggal_lahir'] ?? '' ?>" required>
        <label>Umur:</label>
        <input type="number" name="umur" value="<?= $edit_data['umur'] ?? '' ?>" required>
        <label>Alamat:</label>
        <input type="text" name="alamat" value="<?= $edit_data['alamat'] ?? '' ?>" required>
        <button type="submit"><?= isset($edit_data) ? 'Edit' : 'Tambah' ?> Data</button>
    </form>

    <h2>Daftar Pasien Terdaftar</h2>

    <!-- Tabel untuk menampilkan daftar pasien -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>NIK</th>
                <th>Nama Pasien</th>
                <th>Tanggal Lahir</th>
                <th>Umur</th>
                <th>Alamat</th>
                <th>Tanggal Daftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $patients_result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id_pasien'] ?></td>
                <td><?= $row['nik'] ?></td>
                <td><?= $row['nama_pasien'] ?></td>
                <td><?= $row['tanggal_lahir'] ?></td>
                <td><?= $row['umur'] ?></td>
                <td><?= $row['alamat'] ?></td>
                <td><?= $row['tanggal_daftar'] ?></td>
                <td>
                    <a href="?id_pasien=<?= $row['id_pasien'] ?>">Edit</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="index.php">Kembali ke Dashboard</a>
</body>
</html>
