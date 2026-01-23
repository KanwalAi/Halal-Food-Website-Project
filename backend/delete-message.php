<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM messages WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: view-messages.php"); // Go back to the list
    } else {
        echo "Error deleting message: " . mysqli_error($conn);
    }
}
?>