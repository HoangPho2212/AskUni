<!-- login -->
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