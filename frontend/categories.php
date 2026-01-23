<?php
session_start(); // Essential for checking admin status.
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cuisines | Halal Delights</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header class="cat-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="cat-logo">Halal Delights</div>
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

    <section class="cat-hero">
        <h1>Explore World Cuisines</h1>
        <p>Handcrafted halal dishes from around the globe</p>

        <div class="cat-grid">

            <a href="menu.php?cuisine=Pakistani" class="cat-card">
                <img src="https://static.vecteezy.com/system/resources/thumbnails/038/970/589/small/ai-generated-spicy-chicken-biryani-cuisine-in-a-shiny-silver-bowl-authentic-indian-food-serving-fancy-food-in-a-restaurant-photo.jpg"
                    alt="Pakistani Cuisine">
                <div class="cat-overlay">
                    <h3>Pakistani Cuisine</h3>
                    <span>Authentic Desi Flavors</span>
                </div>
            </a>

            <a href="menu.php?cuisine=Italian" class="cat-card">
                <img src="https://media.cnn.com/api/v1/images/stellar/prod/210211142532-18-classic-italian-dishes.jpg?q=w_1110,c_fill"
                    alt="Italian Cuisine">
                <div class="cat-overlay">
                    <h3>Italian Cuisine</h3>
                    <span>Pasta, Pizza & Risotto</span>
                </div>
            </a>

            <a href="menu.php?cuisine=Chinese" class="cat-card">
                <img src="https://images.unsplash.com/photo-1585032226651-759b368d7246?auto=format&fit=crop&w=1200&q=80"
                    alt="Chinese Cuisine">
                <div class="cat-overlay">
                    <h3>Chinese Cuisine</h3>
                    <span>Noodles & Stir Fry</span>
                </div>
            </a>

            <a href="menu.php?cuisine=Continental" class="cat-card">
                <img src="https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=1200&q=80"
                    alt="Continental">
                <div class="cat-overlay">
                    <h3>Continental</h3>
                    <span>Grills, Steaks & Salads</span>
                </div>
            </a>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>