<?php
session_start();
include 'db.php'; 

$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin_users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // VERIFY PASSWORD
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_name'] = $row['username'];
            $_SESSION['admin_logged_in'] = true; 

            // Redirect to Admin Dashboard or Homepage
            header("Location: ../frontend/index.php"); 
            exit();
        } else {
            $error = "Wrong Username or Password!";
        }
    } else {
        $error = "Wrong Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/styles.css">

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

    .back-link {
        display: block;
        margin-top: 15px;
        text-decoration: none;
        color: #555;
        font-size: 14px;
    }
    </style>
</head>

<body>

    <div class="login-box">
        <h2 class="mb-4">Admin Login</h2>

        <?php if($error): ?>
        <div class="error">❌ <?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label style="float:left; font-weight:bold; font-size:14px; mb-1;">Username</label>
            <input type="text" name="username" required>

            <label style="float:left; font-weight:bold; font-size:14px; mb-1;">Password</label>
            <input type="password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>

        <a href="../frontend/index.php" class="back-link">← Back to Website</a>
    </div>

</body>

</html>