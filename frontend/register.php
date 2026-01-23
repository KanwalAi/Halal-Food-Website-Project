<?php
session_start();
include '../backend/db.php';

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = md5($_POST['password']);

    // Check if email or phone already exists
    $check_sql = "SELECT * FROM customers WHERE email='$email' OR phone='$phone'";
    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        $existing_user = mysqli_fetch_assoc($result);
        
        if ($existing_user['email'] === $email) {
            $error = "❌ This Email is already registered!";
        } elseif ($existing_user['phone'] === $phone) {
            $error = "❌ This Phone Number is already registered!";
        }
    } else {
        $sql = "INSERT INTO customers (name, email, password, phone) VALUES ('$name', '$email', '$password', '$phone')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('✅ Account created! Please Login.'); window.location.href='cust-login.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register | Halal Delights</title>
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
        box-sizing: border-box;
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
    }

    .bottom-links a:hover {
        color: #800000;
        text-decoration: underline;
    }
    </style>
</head>

<body>

    <div class="login-box">
        <h2 class="mb-4">Create Account</h2>

        <?php if(isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Full Name</label>
            <input type="text" name="name" required>

            <label>Email Address</label>
            <input type="email" name="email" required>

            <label>Phone Number</label>
            <input type="text" name="phone" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" name="register">Sign Up</button>
        </form>

        <div class="bottom-links">
            <p>Already have an account? <a href="cust-login.php" style="font-weight:bold;">Login here</a></p>
            <a href="index.php">← Back to Home</a>
        </div>
    </div>

</body>

</html>