<?php
session_start();
// If the user is NOT logged in, kick them back to login page
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>
<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Customer Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/styles.css">
</head>

<body class="background-color:#fff0f0">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-danger">Inbox (Customer Messages)</h2>
            <div>
                <a href="add-food.php" class="btn btn-outline-secondary">Back to Dashboard</a>
                <a href="../frontend/index.php" class="btn btn-outline-primary">Go to Website</a>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
    $sql = "SELECT * FROM messages ORDER BY status ASC, id DESC";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $date = date("M d", strtotime($row['created_at']));
            
            // Check status for styling
            $is_replied = ($row['status'] == 'Replied');
            $status_badge = $is_replied 
                ? '<span class="badge bg-success">Replied</span>' 
                : '<span class="badge bg-warning text-dark">Pending</span>';
    ?>
                        <tr id="message-<?php echo $row['id']; ?>">
                            <td><?php echo $date; ?></td>
                            <td>
                                <strong><?php echo $row['name']; ?></strong><br>
                                <small class="text-muted"><?php echo $row['email']; ?></small>
                            </td>
                            <td><?php echo $row['subject']; ?></td>
                            <td><?php echo substr($row['message'], 0, 50) . '...'; ?></td>
                            <td><?php echo $status_badge; ?></td>
                            <td>
                                <a href="reply-message.php?id=<?php echo $row['id']; ?>"
                                    class="btn btn-primary btn-sm mb-1">
                                    <?php echo $is_replied ? 'View Reply' : 'Reply'; ?>
                                </a>

                                <a href="delete-message.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this message?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        <?php
        }
    } else {
        echo "<tr><td colspan='6' class='text-center'>No messages yet.</td></tr>";
    }
    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>