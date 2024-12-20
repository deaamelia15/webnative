<?php
include 'koneksi.php';

// Validasi ID dari parameter URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Query untuk menghapus data berdasarkan ID
    $sql = "DELETE FROM daftar_pasien WHERE id_pasien = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Cek apakah ada data yang dihapus
            if ($stmt->affected_rows > 0) {
                // Redirect ke halaman data_pasien.php jika sukses
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Data dengan ID pasien tidak ditemukan atau sudah dihapus.";
            }
        } else {
            echo "Gagal menghapus data: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Gagal mempersiapkan pernyataan: " . $conn->error;
    }
} else {
    echo "ID tidak valid. Pastikan ID pasien berupa angka.";
}

$conn->close();
?>
