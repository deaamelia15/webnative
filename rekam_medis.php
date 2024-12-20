<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pasien = $_POST['id_pasien'];
    $poli = $_POST['poli'];
    $nama_dokter = $_POST['nama_dokter'];
    $diagnosis = $_POST['diagnosis'];
    $tanggal_rekam = $_POST['tanggal_rekam'];

    $query = "INSERT INTO rekam_medis (id_pasien, poli, nama_dokter, diagnosis, tanggal_rekam) 
              VALUES ('$id_pasien', '$poli', '$nama_dokter', '$diagnosis', '$tanggal_rekam')";

    if (mysqli_query($conn, $query)) {
        echo "Data berhasil disimpan!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Rekam Medis</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.form-container {
    background: #fff;
    padding: 20px 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 400px;
}

.form-container h2 {
    margin-bottom: 20px;
    color: #cd1111;
    font-size: 24px;
    text-align: center;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #b22222;
    outline: none;
}

.form-group button,
.form-group a.btn-back {
    background-color: #cd1111;
    color: #fff;
    border: none;
    padding: 10px 15px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.form-group button:hover,
.form-group a.btn-back:hover {
    background-color: #800000;
}

.form-group a.btn-back {
    margin-left: 10px;
}

select {
    background-color: #f8f8f8;
    cursor: pointer;
}

input[readonly] {
    background-color: #f2f2f2;
    cursor: not-allowed;
}

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            // Ketika ID Pasien berubah
            $('#id_pasien').on('change', function(){
                var id_pasien = $(this).val();  // Ambil ID Pasien yang dipilih
                if(id_pasien != '') {
                    // Lakukan request AJAX untuk mendapatkan Nama Pasien
                    $.ajax({
                        url: "get_pasien.php",  // File PHP yang akan mengambil Nama Pasien
                        method: "POST",
                        data: {id_pasien: id_pasien},
                        success: function(response) {
                            $('#nama_pasien').val(response);  // Isi Nama Pasien di input
                        }
                    });
                }
            });
        });
    </script>
</head>
<body>
    <div class="form-container">
        <h2>Input Rekam Medis</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="id_pasien">ID Pasien:</label>
                <select id="id_pasien" name="id_pasien" required>
                    <option value="">Pilih ID Pasien</option>
                    <?php
                    // Ambil ID Pasien dari database
                    $query = "SELECT id_pasien, nama_pasien FROM daftar_pasien";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='".$row['id_pasien']."'>".$row['id_pasien']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nama_pasien">Nama Pasien:</label>
                <input type="text" id="nama_pasien" name="nama_pasien" required readonly>
            </div>
            <div class="form-group">
                <label for="poli">Poli:</label>
                <select id="poli" name="poli" required>
                    <option value="">Pilih Poli</option>
                    <option value="Umum">Umum</option>
                    <option value="Gigi">Gigi</option>
                    <option value="Kandungan">Kandungan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nama_dokter">Nama Dokter:</label>
                <input type="text" id="nama_dokter" name="nama_dokter" required>
            </div>
            <div class="form-group">
                <label for="diagnosis">Diagnosis:</label>
                <input type="text" id="diagnosis" name="diagnosis" required>
            </div>
            <div class="form-group">
                <label for="tanggal_rekam">Tanggal Rekam:</label>
                <input type="date" id="tanggal_rekam" name="tanggal_rekam" required>
            </div>
            <div class="form-group">
                <button type="submit">Simpan</button>
                <a href="dashboard.php" class="btn-back">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>
