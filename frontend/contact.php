<?php 
session_start();
include '../backend/db.php'; // Ensure database connection is included

// Handle Form Submission
if (isset($_POST['send_message'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Since the design has no Subject field, we set a default one
    $subject = "General Inquiry"; 

    $sql = "INSERT INTO messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
    
    if (mysqli_query($conn, $sql)) {
        // Success: Use JavaScript to show the alert just like the design intended
        echo "<script>alert('✅ Message Sent Successfully! We will contact you soon.'); window.location.href='contact.php';</script>";
    } else {
        echo "<script>alert('❌ Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Contact Us | Halal Delights</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles.css">

</head>

<body>

    <header class="contact-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="contact-logo">Halal Delights</div>
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

    <div class="contact-map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3401.4!2d74.3!3d31.5!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzHCsDMwJzAwLjAiTiA3NMKwMTgnMDAuMCJF!5e0!3m2!1sen!2s!4v1600000000000"
            loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>

        <div class="contact-card">
            <h1>Get In Touch</h1>
            <p>We'd love to hear from you</p>

            <form method="POST" action="">
                <input type="text" name="name" placeholder="Full Name" class="form-control contact-input" required>
                <input type="email" name="email" placeholder="Email Address" class="form-control contact-input"
                    required>
                <textarea name="message" placeholder="Your Message" class="form-control contact-input contact-textarea"
                    required></textarea>

                <button type="submit" name="send_message" class="btn contact-btn w-100">Send Message</button>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>