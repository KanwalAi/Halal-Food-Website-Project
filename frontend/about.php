<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>About Us | Halal Delights</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="styles.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@600&display=swap"
        rel="stylesheet">
</head>

<body>

    <header class="about-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="about-logo">Halal Delights</div>
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

    <section class="about-section">
        <div class="container" style="max-width: 1100px;">

            <div class="row align-items-center">

                <div class="col-lg-6 about-text">
                    <h1>About Halal Delights</h1>
                    <p>
                        Halal Delights is dedicated to serving authentic halal cuisine crafted
                        with premium ingredients, rich tradition, and uncompromising hygiene.
                    </p>
                    <p>
                        From sizzling kebabs to aromatic biryanis, our dishes reflect the soul
                        of traditional Pakistani cooking blended with modern excellence.
                    </p>
                </div>

                <div class="col-lg-6 about-image">
                    <img src="https://t4.ftcdn.net/jpg/12/72/93/19/360_F_1272931996_vh0E9L1SYTUOMJUA2R1Jt6DCC89NEYo8.jpg"
                        alt="Pakistani Food Platter" class="img-fluid">
                </div>

            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>