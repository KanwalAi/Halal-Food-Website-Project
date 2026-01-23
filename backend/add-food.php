<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Owner Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/styles.css">
</head>

<body class="background-color:#fff0f0">
    <header class="index-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <span class="navbar-brand mb-0 h1 text-warning">👨‍🍳 Owner Panel</span>
                <nav class="d-flex gap-3 align-items-center">
                    <div>
                        <a href="../frontend/index.php" class="btn btn-outline-light btn-sm me-2">Go to Website</a>
                        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <div class="container mt-5">

        <div class="row text-center mb-5">
            <div class="col-md-4">
                <div class="card p-4 shadow-sm border-primary">
                    <h4 class="text-primary">📦 Orders</h4>
                    <p>Check new customer orders</p>
                    <a href="view-orders.php" class="btn btn-primary w-100">View Orders</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 shadow-sm border-success">
                    <h4 class="text-success">🍔 Manage Food</h4>
                    <p>Add or delete menu items</p>
                    <a href="#add-form" class="btn btn-success w-100">Add New Food</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 shadow-sm border-info">
                    <h4 class="text-info">📩 Messages</h4>
                    <p>Read customer inquiries</p>
                    <a href="view-messages.php" class="btn btn-info text-white w-100">Read Inbox</a>
                </div>
            </div>
        </div>

        <div id="add-form" class="card shadow p-4 mx-auto" style="max-width: 600px;">
            <h3 class="text-center text-dark mb-4">Add New Food Item</h3>

            <?php
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $category = $_POST['category']; 
            
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            $target_file = $target_dir . basename($_FILES["image"]["name"]);

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO menu_items (name, price, img, category) VALUES ('$name', '$price', '$target_file', '$category')";
                if (mysqli_query($conn, $sql)) {
                    header("Location: add-food.php#food-list");
                    exit();
                }
            } else {
                echo "<div class='alert alert-danger'>❌ Image upload failed.</div>";
            }
        }
        ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Cuisine</label>
                        <select name="category" class="form-control" required>
                            <option value="Pakistani">Pakistani</option>
                            <option value="Italian">Italian</option>
                            <option value="Chinese">Chinese</option>
                            <option value="Continental">Continental</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Price (Rs)</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                </div>

                <label class="fw-bold">Food Name</label>
                <input type="text" name="name" class="form-control mb-3" required>

                <label class="fw-bold">Image</label>
                <input type="file" name="image" class="form-control mb-3" required>

                <button type="submit" name="submit" class="btn btn-dark w-100">Add to Menu</button>
            </form>
        </div>

        <div class="mt-5" id="food-list">
            <h4 class="mb-3">Existing Menu Items (Manage)</h4>
            <div class="bg-white p-3 rounded shadow-sm">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $res = mysqli_query($conn, "SELECT * FROM menu_items ORDER BY id DESC LIMIT 10");
                    while($row = mysqli_fetch_assoc($res)) {
                        echo "<tr>
                                <td>{$row['name']}</td>
                                <td>{$row['category']}</td>
                                <td>{$row['price']}</td>
                                <td><a href='delete.php?id={$row['id']}&cuisine={$row['category']}' class='text-danger'>Delete</a></td>
                              </tr>";
                    }
                    ?>
                    </tbody>
                </table>
                <div class="text-center text-muted"><small>Showing last 10 items added</small></div>
            </div>
        </div>
    </div>

</body>

</html>