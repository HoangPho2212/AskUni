<?php
require 'db.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';


$success = '';
$userrname = '';
$email = '';
$message = '';

if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if ($user) {
        $userrname = $user['username'];
        $email = $user['email']; 
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $userrname = trim($_POST['username']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if ($userrname && $email && $message) {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'Hoangpho.2212@gmail.com';
            $mail->Password = 'vhsj mmiq pggc dmeq';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('Hoangpho.2212@gmail.com', 'Contact Bot');
            $mail->addAddress('phonhhgcd230181@fpt.edu.vn', 'Admin');

            $mail->isHTML(true);
            $mail->Subject = 'Contact Form Submission';
            $mail->Body = "<strong>Username:</strong> " . htmlspecialchars($userrname) . "<br>" .
                          "<strong>Email:</strong> " . htmlspecialchars($email) . "<br>" .
                          "<strong>Message:</strong><br>" . nl2br(htmlspecialchars($message));

            $mail->send();
            $success = 'Message sent successfully!';
            $message = ''; // Clear the message after sending
            $success = '';

        } catch (Exception $e) {
            $success = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    } else {
        $success = 'Please fill in all fields.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact admin</title>
    <link rel="stylesheet" href="style.css?v=1.1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/png" href="image/LogoTitle.png">
</head>
<body>
    <input type="checkbox" id="menu-toggle" hidden>
    <label for="menu-toggle" class="menu-toggle"><i class="fa-solid fa-bars-staggered"></i></label>

    <div class="menu">

        <div class="menu_header">
            <h2>Q&A Portal</h2>
        </div>

        <a href="index.php" class="menu_item">
            <i class="fa-solid fa-house"></i>
            <span>Home</span>
        </a>

        <a href="add_post.php" class="menu_item">
            <i class="fa-solid fa-plus"></i>
            <span>Add Post</span>
        </a>

        <a href="contact.php" class="menu_item">
            <i class="fa-solid fa-address-book"></i>
            <span>Contact</span>
        </a>
    </div>

    <div style="max-height: 600px;" class="login-container">
        <h2>Contact Admin</h2>

        <?php if ($success): ?>
            <p class="notice"> <?= htmlspecialchars($success) ?> </p>
        <?php endif; ?>

        <form method="POST" action="contact.php">

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($userrname) ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

            <label for="message">Message:</label>
            <textarea class="Comment-area" id="message" name="message" rows="4" required><?= htmlspecialchars($message) ?></textarea>

            <button style="margin-top: 20px;" type="submit" class="submit-btn">Send Message</button>

    </div>
    
</body>
</html>