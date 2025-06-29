<!-- register.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
  <title>Register | AskUni</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" type="image/png" href="image/LogoTitle.png">
</head>

<body>

  <div class="login-container">
    <form action="register.php" method="POST" class="login-box">
      <h2 class="login-title">Create an AskUni Account</h2>

      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Choose a username" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Create a password" required>

      <label for="confirm">Confirm Password</label>
      <input type="password" id="confirm" name="confirm" placeholder="Re-type password" required>

      <button type="submit" name="register">Register</button>

      <p class="register-link">
        Already have an account? <a href="login.php">Login here</a>
      </p>

      <div class="logo-wrapper">
            <img src="image/LogoAskUni.png.png" alt="logo of ask uni">
        </div>
      
    </form>
  </div>

</body>

</html>