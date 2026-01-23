<?php
session_start();
// If the user is NOT logged in, kick them back to login page
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
include 'db.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Check if we know which cuisine this was (Default to Pakistani if missing)
    $cuisine = isset($_GET['cuisine']) ? $_GET['cuisine'] : 'Pakistani';

    // 2. Delete the item
    $sql = "DELETE FROM menu_items WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        // 3. Redirect back to the SPECIFIC cuisine page
        header("Location: add-food.php?cuisine=" . $cuisine);
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>