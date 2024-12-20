<?php
// Koneksi ke database
include 'koneksi.php'; // Pastikan file koneksi sudah sesuai dengan konfigurasi

// Periksa apakah form telah di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama_pasien = $_POST['nama_pasien'];
    $nik = $_POST['nik'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $umur = intval($_POST['umur']); // Pastikan umur dikonversi ke integer
    $alamat = $_POST['alamat'];
    $tanggal_daftar = date("Y-m-d"); // Tanggal daftar otomatis diambil dari waktu sekarang

    // Periksa apakah NIK sudah ada
    $query_check_nik = "SELECT id_pasien FROM daftar_pasien WHERE nik = ?";
    $stmt_check_nik = $conn->prepare($query_check_nik);
    $stmt_check_nik->bind_param("s", $nik);
    $stmt_check_nik->execute();
    $stmt_check_nik->store_result();

    if ($stmt_check_nik->num_rows > 0) {
        echo "<p>NIK sudah terdaftar!</p>";
    } else {
        // Query untuk menyimpan data ke tabel daftar_pasien
        $query_daftar_pasien = "INSERT INTO daftar_pasien (nama_pasien, nik, tanggal_lahir, umur, alamat, tanggal_daftar) 
                                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_daftar_pasien = $conn->prepare($query_daftar_pasien);

        // Cek apakah query berhasil dipersiapkan
        if ($stmt_daftar_pasien === false) {
            die("Error preparing query: " . $conn->error);
        }

        // Bind parameter dan eksekusi query
        $stmt_daftar_pasien->bind_param("sssiss", $nama_pasien, $nik, $tanggal_lahir, $umur, $alamat, $tanggal_daftar);

        if ($stmt_daftar_pasien->execute()) {
            // Setelah data pasien berhasil disimpan, ambil id_pasien
            $id_pasien = $stmt_daftar_pasien->insert_id;

            // Sekarang ambil id_data dari tabel data_pasien berdasarkan nik
            $query_id_data = "SELECT id_data FROM data_pasien WHERE nik = ?";
            $stmt_id_data = $conn->prepare($query_id_data);
            $stmt_id_data->bind_param("s", $nik);
            $stmt_id_data->execute();
            $stmt_id_data->bind_result($id_data);
            $stmt_id_data->fetch();
            $stmt_id_data->close();

            // Cek apakah id_data ditemukan
            if ($id_data) {
                // Update id_data di tabel daftar_pasien dengan nilai yang sesuai
                $query_update_id_data = "UPDATE daftar_pasien SET id_data = ? WHERE id_pasien = ?";
                $stmt_update_id_data = $conn->prepare($query_update_id_data);
                $stmt_update_id_data->bind_param("ii", $id_data, $id_pasien);

                if ($stmt_update_id_data->execute()) {
                    // Redirect ke halaman slip_pasien.php dan meneruskan ID pasien
                    header("Location: slip_pasien.php?id_pasien=$id_pasien");
                    exit(); // Pastikan script berhenti setelah redirect
                } else {
                    echo "<p>Terjadi kesalahan saat mengupdate id_data: " . $stmt_update_id_data->error . "</p>";
                }

                $stmt_update_id_data->close();
            } else {
                echo "<p>Data dengan NIK tersebut tidak ditemukan di tabel data_pasien.</p>";
            }
        } else {
            echo "<p>Terjadi kesalahan saat menyimpan data daftar pasien: " . $stmt_daftar_pasien->error . "</p>";
        }

        $stmt_daftar_pasien->close();
    }
    $stmt_check_nik->close();
}
$conn->close();
?>
