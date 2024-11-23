<?php
session_start();

// Kredensial staf klinik (harus disimpan di database pada aplikasi nyata)
$valid_username = "admin";
$valid_password = "123"; // Gunakan hashing pada aplikasi nyata

// Validasi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $valid_username && $password === $valid_password) {
        // Set session login
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        // Redirect ke dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Jika login gagal
        $error_message = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Gagal</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            margin-top: 50px;
        }
        .error {
            color: red;
            font-size: 18px;
            margin-bottom: 20px;
        }
        a {
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>
    <p class="error"><?php if (isset($error_message)) echo $error_message; ?></p>
    <a href="index.php">Kembali ke Halaman Home</a>
</body>
</html>
