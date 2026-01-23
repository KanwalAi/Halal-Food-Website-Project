<?php
include 'db.php';

echo "<h3>Starting Fix...</h3>";

// 1. DELETE the old table completely to remove any bad settings
$sql_drop = "DROP TABLE IF EXISTS admin_users";
if (mysqli_query($conn, $sql_drop)) {
    echo "✅ Old table deleted.<br>";
}

// 2. CREATE the table again with correct 'VARCHAR(255)' length
$sql_create = "CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

if (mysqli_query($conn, $sql_create)) {
    echo "✅ New table created successfully.<br>";
} else {
    echo "❌ Error creating table: " . mysqli_error($conn) . "<br>";
}

// 3. INSERT the user (Letting PHP calculate the hash ensures it matches)
$password = 'password123';
$hashed_password = md5($password); 

$sql_insert = "INSERT INTO admin_users (username, password) VALUES ('admin', '$hashed_password')";

if (mysqli_query($conn, $sql_insert)) {
    echo "✅ Admin user inserted successfully.<br>";
    echo "<hr>";
    echo "<h1 style='color:green'>FIX COMPLETE!</h1>";
    echo "<p>Please go to <a href='login.php'>Login Page</a> and try:</p>";
    echo "<ul><li>Username: <b>admin</b></li><li>Password: <b>password123</b></li></ul>";
} else {
    echo "❌ Error inserting user: " . mysqli_error($conn);
}
?>