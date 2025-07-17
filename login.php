<!-- Login -->
<?php
session_start();
require_once 'db.php';

$loginMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $loginMessage = "Please enter both username and password.";
    } else {
        try {
            // Fetch the user from the database by username
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // // Debugging 
            // echo '<pre>';
            // print_r($user);
            // echo '</pre>';

            if ($user) {
                // Check if the password is correct
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    header("Location: index.php");
                    exit;
                } else {
                    $loginMessage = "Invalid password.";
                }
            } else {
                $loginMessage = "Invalid username.";
            }
        } catch (PDOException $e) {
            $loginMessage = "Login failed: " . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login | AskUni</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="image/LogoTitle.png">
</head>

<body>

    <div class="login-container">
        <h2> Login to AskUni </h2>

        <?php if (!empty($loginMessage)): ?>
            <div style="color: red; margin-bottom: 12px;">
                <?= htmlspecialchars($loginMessage) ?>
            </div>
        <?php endif; ?>


        <form action="login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="type your username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="type your password" required>

            <button type="submit" name="login">Login</button>
            <i class="fa-solid fa-question"></i>
        </form>

        <div class="register-link">
            Don't have an account? <a href="register.php">Register here</a>
            <div class="logo-wrapper">
                <img src="image/LogoAskUni.png.png" alt="logo of ask uni">
            </div>


        </div>
</body>

</html>