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

/* Login container styling */
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #f4f4f4;
}

/* Login card styling */
.login-card {
    background-color: #fff;
    padding: 5rem;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;

}

/* Text styling */
.text-center {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 1rem;
    color: #cd1111;
}

/* Form input styling */
.form-input {
    width: 100%;
    padding: 0.8rem;
    margin-bottom: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
}

/* Submit button styling */
.btn-submit {
    width: 100%;
    padding: 0.8rem;
    margin-bottom: 1rem;
    border: none;
    border-radius: 5px;
    background-color: #cd1111;
    color: #fff;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
    text-align: center;
}

.btn-submit:hover {
    background-color: #800000;
}

.login {
    position: relative;
    left: 2vh;
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
                <div class="login"><input type="submit" class="btn-submit" value="Login"></div>
            </form>
        </div>
    </div>
</body>
</html>
