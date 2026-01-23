<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['customer_id'])) {
    echo "<script>alert('Please login to view your cart!'); window.location.href='cust-login.php';</script>";
    exit();
}

include '../backend/db.php';

if (!isset($_SESSION['cart'])) {
$_SESSION['cart'] = array();
}

// Add Item to Cart (If link clicked from Menu)
if (isset($_GET['name']) && isset($_GET['price'])) {
$name = $_GET['name'];
$price = $_GET['price'];

// Check if item already exists (to increase quantity)
$found = false;
foreach ($_SESSION['cart'] as $key => $cart_item) {
    if ($cart_item['name'] == $name) {
        $_SESSION['cart'][$key]['qty'] += 1;
        $found = true;
        break;
    }
}

// If new item, add it
if (!$found) {
    $item = array(
        'name' => $name,
        'price' => $price,
        'qty' => 1
    );
    $_SESSION['cart'][] = $item;
}

// Redirect back to cart
header("Location: cart.php");
exit();
}

// Clear Cart Logic
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
unset($_SESSION['cart']);
header("Location: cart.php");
exit();
}

// 4. Handle Order Submission
$order_placed = false;

if (isset($_POST['confirm_order'])) {
// Combine all food names into one string
$food_names = array();
$total_price = 0;

foreach ($_SESSION['cart'] as $cart_item) {
$food_names[] = $cart_item['name'];
$total_price += $cart_item['price'];
}

$all_food = implode(", ", $food_names); // Joins names with commas

$name = mysqli_real_escape_string($conn, $_POST['full_name']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$addr = mysqli_real_escape_string($conn, $_POST['address']);

// Insert into DB
$sql = "INSERT INTO orders (food_name, price, customer_name, phone, address)
VALUES ('$all_food', '$total_price', '$name', '$phone', '$addr')";

if (mysqli_query($conn, $sql)) {
$order_placed = true;
unset($_SESSION['cart']); // Empty cart after successful order
} else {
echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
}
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Your Cart | Halal Delights</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header class="cart-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="cart-logo">Halal Delights</div>
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

    <div class="container mt-5 mb-5">
        <div class="cart-box">

            <?php if ($order_placed): ?>
            <div class="text-center">
                <div class="alert alert-success">
                    ✅ <b>Order Confirmed!</b><br>
                    Thank you, <?php echo $name; ?>. Your total was <b>Rs. <?php echo $total_price; ?></b>.<br>
                    We will deliver to your address soon.
                </div>
                <a href="categories.php" class="btn btn-primary mt-3">Order More Food</a>
            </div>

            <?php elseif (empty($_SESSION['cart'])): ?>
            <div class="text-center py-5">
                <h3>Your Cart is Empty</h3>
                <p class="text-muted">Looks like you haven't added any delicious food yet.</p>
                <a href="categories.php" class="btn btn-danger">Browse Menu</a>
            </div>

            <?php else: ?>
            <h2 class="cart-box-title">Your Cart</h2>

            <div class="table-responsive mb-4">
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Item Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                    $grand_total = 0;
                    foreach ($_SESSION['cart'] as $item): 
                        $qty = isset($item['qty']) ? $item['qty'] : 1;
                        $subtotal = $item['price'] * $qty;
                        $grand_total += $subtotal;
                    ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td>Rs. <?php echo $item['price']; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td>Rs. <?php echo $subtotal; ?></td>
                        </tr>
                        <?php endforeach; ?>

                        <tr class="table-active fw-bold">
                            <td colspan="3">GRAND TOTAL</td>
                            <td class="text-danger">Rs. <?php echo $grand_total; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between mb-4">
                <a href="cart.php?action=clear" class="btn btn-outline-danger btn-sm"
                    onclick="return confirm('Clear entire cart?');">Clear Cart</a>
                <a href="categories.php" class="btn btn-outline-secondary btn-sm">Add More Items</a>
            </div>

            <h4 class="mb-3">Delivery Details</h4>
            <form method="POST" action="">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control cart-input mb-2" placeholder="Enter Name"
                    required>

                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control cart-input mb-2" placeholder="0300-1234567"
                    required>

                <label class="form-label">Delivery Address</label>
                <textarea name="address" class="form-control cart-input cart-textarea mb-3"
                    placeholder="House #, Street, City" required></textarea>

                <button type="submit" name="confirm_order" class="btn cart-confirm-btn w-100">CONFIRM ORDER (Rs.
                    <?php echo $grand_total; ?>)</button>
            </form>

            <?php endif; ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>