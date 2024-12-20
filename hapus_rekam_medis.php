<?php
include 'koneksi.php';

// Hapus data berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sqlDelete = "DELETE FROM rekam_medis WHERE id_pasien = '$id'";

    if ($conn->query($sqlDelete) === TRUE) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='hasil_rekam_medis.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . $conn->error . "');</script>";
    }
} else {
    echo "<script>alert('ID tidak valid!'); window.location='hasil_rekam_medis.php';</script>";
}

$conn->close();
?>