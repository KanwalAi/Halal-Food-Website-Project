<?php
session_start();
include '../backend/db.php';

// 1. SECURITY: Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: cust-login.php");
    exit();
}

$name = $_SESSION['customer_name'];
$phone = $_SESSION['customer_phone'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Account | Halal Delights</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header class="index-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="index-logo">Halal Delights</div>
                <nav class="d-flex gap-3 align-items-center">
                    <a href="index.php" class="index-nav-link">Home</a>
                    <a href="categories.php" class="index-nav-link">Cuisines</a>
                    <a href="about.php" class="index-nav-link">About</a>

                    <?php if (isset($_SESSION['customer_id'])): ?>
                    <a href="contact.php" class="index-nav-link">Contact</a>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['customer_id'])): ?>
                    <a href="cart.php" class="index-nav-link">Cart</a>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['customer_id'])): ?>
                    <a href="my-account.php" class="index-nav-link">👤 <?php echo $_SESSION['customer_name']; ?></a>
                    <a href="logout.php" class="btn index-logout-btn">Logout</a>

                    <?php elseif (isset($_SESSION['admin_logged_in'])): ?>
                    <a href="../backend/add-food.php" class="index-nav-link" style="color:#D4AF37;">⚙️ Admin Panel</a>
                    <a href="../backend/logout.php" class="btn index-logout-btn"
                        style="background-color: #dc3545; border-color: #dc3545;">Logout</a>

                    <?php else: ?>
                    <a href="cust-login.php" class="btn index-logout-btn">Login / Sign Up</a>
                    <a href="../backend/login.php" class="index-nav-link" style="font-size: 0.9rem;">🔒 Staff</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <div style="font-size: 3rem;">👤</div>
                        <h4 class="header-title mt-2"><?php echo htmlspecialchars($name); ?></h4>
                        <p class="text-muted"><?php echo htmlspecialchars($phone); ?></p>
                        <hr>
                        <p class="small text-muted">Thanks for being a loyal customer!</p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <h3 class="header-title mb-3">📜 Order History</h3>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            // Fetch orders for this specific phone number
                            $sql = "SELECT * FROM orders WHERE phone = '$phone' ORDER BY id DESC";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Determine Status Color
                                    $status_class = "bg-secondary";
                                    if ($row['status'] == 'Pending') $status_class = "bg-pending";
                                    if ($row['status'] == 'Completed') $status_class = "bg-completed";
                                    if ($row['status'] == 'Cancelled') $status_class = "bg-cancelled";
                            ?>
                                <tr>
                                    <td>#<?php echo $row['id']; ?></td>
                                    <td><?php echo $row['food_name']; ?></td>
                                    <td>Rs. <?php echo $row['price']; ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $status_class; ?>">
                                            <?php echo $row['status']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $row['order_date']; ?></td>
                                </tr>
                                <?php 
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center py-4'>You haven't placed any orders yet. <a href='categories.php'>Order now!</a></td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>