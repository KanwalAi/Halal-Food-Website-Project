<?php
session_start();
// If the user is NOT logged in, kick them back to login page
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php"); 
    exit();
}

include 'db.php';

// --- PHPMAILER SETUP ---
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
// -----------------------

$msg_id = intval($_GET['id']); // This forces the ID to be a safe number
$success = "";
$error = "";

// 1. Fetch the original message
$sql = "SELECT * FROM messages WHERE id = $msg_id";
$result = mysqli_query($conn, $sql);
$message_data = mysqli_fetch_assoc($result);

// 2. Handle the Reply Form Submission
if (isset($_POST['send_reply'])) {
    $reply_body = $_POST['reply_body'];
    $to_email = $message_data['email'];
    $subject = "Re: " . $message_data['subject'];

    // Create PHPMailer Instance
    $mail = new PHPMailer(true);

    try {
        // --- GMAIL SMTP SETTINGS ---
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        
        // ************************************************************
        // YOUR GMAIL CREDENTIALS GO HERE:
        $mail->Username   = 'username@gmail.com';     // <--- REPLACE THIS
        $mail->Password   = '0000000000000000';      // <--- PASTE YOUR 16-CHAR APP PASSWORD
        // ************************************************************

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipient
        $mail->setFrom('username@gmail.com', 'Halal Delights Admin'); // Change sender name if you want
        $mail->addAddress($to_email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br($reply_body); // Converts newlines to HTML breaks <br>

        // 3. SEND THE EMAIL
        $mail->send();

        // 4. Update Database Status to 'Replied' ONLY if email succeeds
        $update_sql = "UPDATE messages SET status = 'Replied', reply_text = '$reply_body' WHERE id = $msg_id";
        mysqli_query($conn, $update_sql);

        $success = "✅ Email Sent Successfully & Database Updated!";
        
        // Refresh data to show 'Replied' status immediately
        $message_data['status'] = 'Replied'; 
        $message_data['reply_text'] = $reply_body;

    } catch (Exception $e) {
        $error = "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Reply to Message</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="background-color:#fff0f0">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="view-messages.php" class="btn btn-secondary mb-3">← Back to Inbox</a>
                <?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
                <?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        Original Message from
                        <strong><?php echo $message_data['name']; // Changed to match your likely DB column ?></strong>
                    </div>
                    <div class="card-body">
                        <p><strong>Subject:</strong> <?php echo $message_data['subject']; ?></p>
                        <p><strong>Email:</strong> <?php echo $message_data['email']; ?></p>
                        <p class="bg-light p-3 border rounded"><?php echo $message_data['message']; ?></p>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        Reply to Customer (via Gmail SMTP)
                    </div>
                    <div class="card-body">
                        <?php if ($message_data['status'] == 'Replied'): ?>
                        <div class="alert alert-info">
                            <strong>✅ You have already replied:</strong><br>
                            <?php echo $message_data['reply_text']; ?>
                        </div>
                        <?php else: ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="fw-bold">Your Reply:</label>
                                <textarea name="reply_body" rows="6" class="form-control"
                                    placeholder="Type your response here..." required></textarea>
                            </div>
                            <button type="submit" name="send_reply" class="btn btn-success w-100">🚀 Send Real
                                Email</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>