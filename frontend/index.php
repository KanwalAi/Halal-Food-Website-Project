 <?php
session_start(); 
?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <title>Halal Delights | Home</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Playfair+Display&display=swap"
         rel="stylesheet">
     <link rel="stylesheet" href="styles.css">
 </head>

 <body class="d-flex flex-column min-vh-100">

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

     <section class="index-hero">
         <h1>Welcome,
             <span id="username">
                 <?php 
            if (isset($_SESSION['customer_name'])) {
                echo htmlspecialchars($_SESSION['customer_name']); 
            } else {
                echo "Guest"; 
            }
        ?>
             </span>
         </h1>

         <p>Experience the finest Halal Pakistani Cuisine</p>
         <div style="width: fit-content; margin: 0 auto;">
             <button class="index-btn" onclick="window.location.href='categories.php'">View Menu</button>
         </div>
     </section>

     <footer class="mt-auto pt-5 pb-4" style="background-color: #fffef2; color: #333;">
         <div class="container text-center text-md-start">
             <div class="row text-center text-md-start">

                 <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                     <h5 class="text-uppercase mb-4 fw-bold text-warning">Halal Delights</h5>
                     <p class="text-muted">Experience the authentic taste of Pakistani cuisine, prepared with the finest
                         halal ingredients and love.</p>
                 </div>

                 <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                     <h5 class="text-uppercase mb-4 fw-bold text-warning">Quick Links</h5>
                     <p><a href="index.php" class="text-dark text-decoration-none">Home</a></p>
                     <p><a href="categories.php" class="text-dark text-decoration-none">Menu</a></p>
                     <p><a href="about.php" class="text-dark text-decoration-none">About Us</a></p>
                     <p><a href="contact.php" class="text-dark text-decoration-none">Contact</a></p>
                 </div>

                 <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                     <h5 class="text-uppercase mb-4 fw-bold text-warning">Contact</h5>
                     <p class="text-muted">🏠 123 Food Street, Islamabad</p>
                     <p class="text-muted">📧 info@halaldelights.com</p>
                     <p class="text-muted">📞 +92 300 1234567</p>
                 </div>
             </div>

             <hr class="mb-4 text-muted">

             <div class="row align-items-center">
                 <div class="col-md-7 col-lg-8">
                     <p class="text-muted">Copyright © 2024 All rights reserved by:
                         <strong class="text-warning">Halal Delights</strong>
                     </p>
                 </div>
             </div>
         </div>
     </footer>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 </body>

 </html>