<?php
session_start();
// If the user is NOT logged in, kick them back to login page
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

// --- ACTION LOGIC (Mark Delivered, Cancel, or Delete) ---
if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == 'deliver') {
        // 1. Mark as Delivered
        mysqli_query($conn, "UPDATE orders SET status = 'Completed' WHERE id = $id");
        
    } elseif ($action == 'cancel') {
        // 2. NEW: Mark as Cancelled
        mysqli_query($conn, "UPDATE orders SET status = 'Cancelled' WHERE id = $id");

    } elseif ($action == 'delete') {
        // 3. Soft Delete (Hide from Admin, Keep for Customer)
        mysqli_query($conn, "UPDATE orders SET admin_visible = 0 WHERE id = $id");
    }
    
    // Refresh page to apply changes, with anchor to jump back to order
    header("Location: view-orders.php#order-$id");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/styles.css">
</head>

<body style="background-color: #fff0f0;">

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">📦 Customer Orders</h2>
            <div>
                <a href="add-food.php" class="btn btn-outline-secondary">Back to Dashboard</a>
                <a href="view-messages.php" class="btn btn-outline-info">View Messages</a>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Customer Details</th>
                                <th>Order Items</th>
                                <th>Total (Rs)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Filter by VISIBILITY (Soft Delete), then sort
                            $sql = "SELECT * FROM orders WHERE admin_visible = 1 ORDER BY id DESC";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $date = date("M d, h:i A", strtotime($row['order_date']));
                                    
                                    // Status Colors
                                    $status_color = 'bg-secondary';
                                    if($row['status'] == 'Pending') $status_color = 'bg-warning text-dark';
                                    if($row['status'] == 'Completed') $status_color = 'bg-success text-white';
                                    if($row['status'] == 'Cancelled') $status_color = 'bg-danger text-white';
                            ?>
                            <tr id="order-<?php echo $row['id']; ?>">
                                <td>#<?php echo $row['id']; ?></td>
                                <td style="font-size: 13px;"><?php echo $date; ?></td>

                                <td>
                                    <strong><?php echo $row['customer_name']; ?></strong><br>
                                    📞 <?php echo $row['phone']; ?><br>
                                    📍 <?php echo $row['address']; ?>
                                </td>

                                <td class="fw-bold text-primary">
                                    <?php echo isset($row['food_name']) ? $row['food_name'] : $row['total_products']; ?>
                                </td>

                                <td class="fw-bold">
                                    <?php echo isset($row['price']) ? $row['price'] : $row['total_price']; ?>
                                </td>

                                <td>
                                    <span class="badge <?php echo $status_color; ?> p-2">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>

                                <td>
                                    <?php if($row['status'] == 'Pending'): ?>
                                    <a href="view-orders.php?id=<?php echo $row['id']; ?>&action=deliver"
                                        class="btn btn-sm btn-success w-100 mb-1">
                                        ✅ Mark Delivered
                                    </a>

                                    <a href="view-orders.php?id=<?php echo $row['id']; ?>&action=cancel"
                                        class="btn btn-sm btn-warning w-100 mb-1"
                                        onclick="return confirm('Are you sure you want to CANCEL this order?');">
                                        ❌ Cancel Order
                                    </a>
                                    <?php else: ?>
                                    <button class="btn btn-sm btn-light w-100 mb-1 border" disabled>
                                        <?php echo $row['status']; ?>
                                    </button>
                                    <?php endif; ?>

                                    <a href="view-orders.php?id=<?php echo $row['id']; ?>&action=delete"
                                        class="btn btn-sm btn-danger w-100"
                                        onclick="return confirm('Hide this order from the list?');">
                                        🗑 Delete
                                    </a>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center text-muted'>No orders placed yet.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>