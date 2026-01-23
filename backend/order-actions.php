<?php
include 'db.php';

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = intval($_GET['id']); // Security: Use intval to prevent SQL Injection
    $action = $_GET['action'];

    if ($action == 'deliver') {
        // Update status to Delivered
        $sql = "UPDATE orders SET status = 'Delivered' WHERE id = $id";
        
    } elseif ($action == 'delete') {
\        // Instead of DELETE, we UPDATE the visibility
        $sql = "UPDATE orders SET admin_visible = 0 WHERE id = $id";
    } elseif ($action == 'cancel') { 
        // 2. NEW: Mark as Cancelled
        $sql = "UPDATE orders SET status = 'Cancelled' WHERE id = $id";
    }
    if (mysqli_query($conn, $sql)) {
        header("Location: view-orders.php");
        exit(); 
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>