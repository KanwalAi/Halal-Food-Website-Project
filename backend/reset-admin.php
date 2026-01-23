<?php
include 'db.php';

$username = 'admin';// Change it according to your preference
$password = '123'; // Change it according to your preference

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

mysqli_query($conn, "DELETE FROM admin_users WHERE username='$username'");

$sql = "INSERT INTO admin_users (username, password) VALUES ('$username', '$hashed_password')";

if (mysqli_query($conn, $sql)) {
    echo "<h1>✅ Admin User Created!</h1>";
    echo "<p><strong>Username:</strong> admin</p>";
    echo "<p><strong>Password:</strong> $password</p>";
    echo "<br><a href=login.php>Go to Login</a>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>