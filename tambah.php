<?php
include 'koneksi.php';

$pasien = new pasien();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $modal = $_POST['modal'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    if ($pasien->tambahPasien(" $nama_produk, $modal, $harga, $stok")) {
        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #354d9c;
        }
        h1 {
            text-align: center;
            color: #fcfcfc;
        }
        form {
            max-width: 400px;
            margin: auto;
            background: #475fad;
            padding: 50px 50px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 12px;
            margin-top: -8px;
            margin-bottom: 10px;
        }
    </style>
    <script>
        function validateForm() {
            var valid = true;

            // Clear previous error messages
            document.querySelectorAll('.error').forEach(function(el) {
                el.textContent = '';
            });

            var nama_produk = document.forms["produkForm"]["nama_produk"].value;
            var modal = document.forms["produkForm"]["modal"].value;
            var harga = document.forms["produkForm"]["harga"].value;
            var stok = document.forms["produkForm"]["stok"].value;
            if (nama_produk == "") {
                document.getElementById('namaProdukError').textContent = "Nama produk harus diisi";
                valid = false;
            }

            if (modal == "" || isNaN(modal) || modal < 1000 || modal > 1200000) {
                document.getElementById('modalError').textContent = "Modal harus diisi dan harus antara 1000 dan 1200000";
                valid = false;
            }

            if (harga == "") {
                document.getElementById('hargaError').textContent = "Harga harus dipilih";
                valid = false;
            }

            if (stok == "") {
                document.getElementById('stokError').textContent = "Stok harus diisi";
                valid = false;
            }

            return valid; // Kembalikan true jika semua validasi berhasil
        }
    </script>
</head>
<body>
    <h1>Tambah Produk</h1>
    <form name="produkForm" action="" method="POST" onsubmit="return validateForm()">
        <label for="nama_produk">Nama Produk:</label>
        <input type="text" id="nama_produk" name="nama_produk">
        <div id="namaProdukError" class="error"></div>

        <label for="modal">Modal:</label>
        <input type="number" id="modal" name="modal">
        <div id="modalError" class="error"></div>

        <label for="harga">Harga:</label>
        <input type="text" id="harga" name="harga">
        <div id="hargaError" class="error"></div>

        <label for="stok">Stok:</label>
        <input type="text" id="stok" name="stok">
        <div id="stokError" class="error"></div>

        <input type="submit" value="Tambah">
    </form>
</body>
</html>