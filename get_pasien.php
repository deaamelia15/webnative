<?php
include 'koneksi.php';

if (isset($_POST['id_pasien'])) {
    $id_pasien = $_POST['id_pasien'];

    // Query untuk mendapatkan nama pasien berdasarkan ID Pasien
    $query = "SELECT nama_pasien FROM daftar_pasien WHERE id_pasien = '$id_pasien'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo $row['nama_pasien'];
    } else {
        echo "Data tidak ditemukan.";
    }
}
?>
