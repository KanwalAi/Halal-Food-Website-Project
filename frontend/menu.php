<?php 
session_start(); 
include '../backend/db.php'; 

// 1. Get the current Cuisine
$cuisine = isset($_GET['cuisine']) ? $_GET['cuisine'] : 'Pakistani';

// 2. LOGIC: Add Item to Cart
if (isset($_POST['add_to_cart'])) {
    
    // --- SECURITY CHECK: IS USER LOGGED IN? ---
    if (!isset($_SESSION['customer_id'])) {
        echo "<script>
            alert('⚠️ You must Login to order food!');
            window.location.href='cust-login.php';
        </script>";
        exit();
    }

    // --- IF LOGGED IN, PROCEED ---
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Initialize cart if empty
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Check if item already exists (to increase quantity)
    $found = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $id) {
            $_SESSION['cart'][$key]['qty'] += 1;
            $found = true;
        }
    }

    // If new item, add it
    if (!$found) {
        $item_array = array(
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'qty' => 1
        );
        $_SESSION['cart'][] = $item_array;
    }

    $food_id = $id;
    header("Location: menu.php?cuisine=$cuisine&added=1&food_id=$food_id#food-$food_id");
    exit();
}

// 3. Count items in cart
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo $cuisine; ?> Menu | Halal Delights</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Playfair+Display&display=swap" rel="stylesheet">
    <style>
    .btn-add {
        background-color: #800000;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-add:hover {
        background-color: #500000;
    }
    </style>
</head>

<body>

    <header
        style="background: #800000; padding: 15px 50px; display: flex; justify-content: space-between; align-items: center; color: white;">
        <div style="font-family: 'Playfair Display'; font-size: 24px; color: #D4AF37; font-weight: bold;">Halal Delights
        </div>
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
        </nav>
    </header>

    <h1 class="menu-title">Authentic <?php echo $cuisine; ?> Cuisine</h1>

    <?php if (isset($_GET['added'])): ?>
    <div
        style="background-color: #d4edda; color: #155724; padding: 15px; text-align: center; margin: 10px 50px; border-radius: 5px; border: 1px solid #c3e6cb;">
        ✅ Item added to cart successfully!
    </div>
    <?php endif; ?>

    <div class="menu-grid">

        <?php
    $safe_cuisine = mysqli_real_escape_string($conn, $cuisine);
    $sql = "SELECT * FROM menu_items WHERE category = '$safe_cuisine'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            // Fix image path if needed
            $img_path = "../backend/" . $row['img'];
    ?>
        <div class="card" id="food-<?php echo $row['id']; ?>">
            <div class="card-image">
                <img src="<?php echo $img_path; ?>" alt="<?php echo $row['name']; ?>">
            </div>
            <div class="card-info">
                <h3><?php echo $row['name']; ?></h3>
                <p class="price">Rs. <?php echo $row['price']; ?></p>

                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                    <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                    <button type="submit" name="add_to_cart" class="btn-add">Add to Cart</button>
                </form>

                <br>
            </div>
        </div>
        <?php
        }
    } else {
        echo "<p style='text-align:center; width:100%; font-size: 18px;'>No $cuisine items found.</p>";
    }
    ?>

    </div>

</body>

</html>