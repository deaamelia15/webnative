<?php
session_start();
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "klinikk";

// Koneksi ke database
$conn = new mysqli($servername, $username_db, $password_db, $dbname);
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Ambil data pasien berdasarkan ID
$patient_id = $_GET['id'] ?? null;
if (!$patient_id) {
    echo "ID pasien tidak ditemukan.";
    exit();
}

$stmt = $conn->prepare("SELECT * FROM data_pasien WHERE id = ?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();
if (!$patient) {
    echo "Data pasien tidak ditemukan.";
    exit();
}

// Proses penyimpanan rekam medis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $diagnosa = $_POST['diagnosa'];
    $tindakan = $_POST['tindakan'];
    $keterangan = $_POST['keterangan'];

    $stmt = $conn->prepare("INSERT INTO rekam_medis (id_pasien, diagnosa, tindakan, keterangan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $patient_id, $diagnosa, $tindakan, $keterangan);

    if ($stmt->execute()) {
        echo "<script>alert('Rekam medis berhasil disimpan.');</script>";
    } else {
        echo "<script>alert('Gagal menyimpan rekam medis: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekam Medis Pasien</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Rekam Medis Pasien</h2>
    <h3>Nama Pasien: <?= htmlspecialchars($patient['nama_pasien']) ?></h3>

    <form method="POST">
        <div>
            <label for="diagnosa">Diagnosa:</label>
            <textarea id="diagnosa" name="diagnosa" required></textarea>
        </div>
        <div>
            <label for="tindakan">Tindakan:</label>
            <textarea id="tindakan" name="tindakan" required></textarea>
        </div>
        <div>
            <label for="keterangan">Keterangan:</label>
            <textarea id="keterangan" name="keterangan"></textarea>
        </div>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
