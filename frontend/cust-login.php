<?php
session_start();
include '../backend/db.php';

$error = "";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM customers WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        $_SESSION['customer_id'] = $row['id'];
        $_SESSION['customer_name'] = $row['name'];
        $_SESSION['customer_email'] = $row['email'];
        $_SESSION['customer_phone'] = $row['phone'];

        header("Location: index.php"); 
        exit();
    } else {
        $error = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Customer Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">

    <style>
    body {
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #fff0f0;
    }

    .login-box {
        width: 100%;
        max-width: 400px;
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .login-box input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        display: block;
    }

    .login-box button {
        width: 100%;
        padding: 10px;
        background-color: #800000;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        font-size: 16px;
        transition: 0.3s;
    }

    .login-box button:hover {
        background-color: #600000;
    }

    .error {
        color: red;
        background: #ffe6e6;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .login-box label {
        float: left;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 5px;
        display: block;
    }

    .bottom-links {
        margin-top: 15px;
        font-size: 14px;
    }

    .bottom-links a {
        color: #555;
        text-decoration: none;
        margin: 0 5px;
    }

    .bottom-links a:hover {
        color: #800000;
        text-decoration: underline;
    }
    </style>
</head>

<body>

    <div class="login-box">
        <h2 class="mb-4">Customer Login</h2>

        <?php if($error): ?>
        <div class="error">❌ <?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Email Address</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>

        <div class="bottom-links">
            <p>New here? <a href="register.php" style="font-weight:bold;">Create Account</a></p>
            <a href="index.php">← Back to Home</a>
        </div>
    </div>

</body>

</html>