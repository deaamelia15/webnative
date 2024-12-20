<?php
include 'koneksi.php';

// Ambil id_pasien dari URL
$id_pasien = $_GET['id_pasien'];

// Ambil data pasien berdasarkan id_pasien
$query = "SELECT * FROM daftar_pasien WHERE id_pasien = $id_pasien";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<p>Data pasien tidak ditemukan.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Pasien - Klinik Kinasih</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* Global styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #b22222;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Header styles */
        header {
            background-color: #D32F2F; /* Red theme */
            color: white;
            text-align: center;
            padding: 40px 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 40px;
            font-weight: 500;
        }

        /* Main content styles */
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            text-align: center;
            color: #D32F2F; /* Red title */
            font-size: 28px;
            margin-bottom: 30px;
            font-weight: 500;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid #eee;
            font-size: 16px;
        }

        th {
            background-color: #ffffff; /* Light red background */
            color: #D32F2F;
        }

        td {
            background-color: #ffffff; /* Soft white-red */
            color: #D32F2F;
        }

        td strong {
            color: #D32F2F;
        }

        /* Button styles */
        .back-button {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 20px;
            background-color: #D32F2F;
            color: white;
            text-decoration: none;
            text-align: center;
            font-size: 16px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .back-button:hover {
            background-color: #C2185B;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

    </style>
</head>
<body>


    <!-- Container for the slip details -->
    <div class="container">
        <h1>Slip Pendaftaran Pasien</h1>
        <table>
            <tr>
                <th>Nama:</th>
                <td><?php echo $row['nama_pasien']; ?></td>
            </tr>
            <tr>
                <th>NIK:</th>
                <td><?php echo $row['nik']; ?></td>
            </tr>
            <tr>
                <th>Tanggal Lahir:</th>
                <td><?php echo $row['tanggal_lahir']; ?></td>
            </tr>
            <tr>
                <th>Umur:</th>
                <td><?php echo $row['umur']; ?> tahun</td>
            </tr>
            <tr>
                <th>Alamat:</th>
                <td><?php echo $row['alamat']; ?></td>
            </tr>
            <tr>
                <th>Tanggal Daftar:</th>
                <td><?php echo $row['tanggal_daftar']; ?></td>
            </tr>
        </table>

        <!-- Button to go back -->
        <div style="text-align: center;">
            <a href="daftar_pasien.php" class="back-button">Kembali ke Home</a>
        </div>
    </div>

</body>
</html>
