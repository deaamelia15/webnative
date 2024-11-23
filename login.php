<?php
// Start session for potential login session management
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Staff</title>
    <style>
        /* Reset default styling */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #333;
        }

        /* Login card styling */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .login-card {
            background-color: white;
            padding: 2rem;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .text-center {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #d50000;
        }

        .form-input {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .btn-submit {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            background-color: #d50000;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-submit:hover {
            background-color: #a80000;
        }
    </style>
</head>
<body>
    
    <div class="login-container">
        <div class="login-card">
            <h3 class="text-center">Login Staff</h3>
            <form method="post" action="cek_login.php">
                <input type="text" class="form-input" placeholder="Username" name="username" required>
                <input type="password" class="form-input" placeholder="Password" name="password" required>
                <input type="submit" class="btn-submit" value="Login">
            </form>
        </div>
    </div>
</body>
</html>
