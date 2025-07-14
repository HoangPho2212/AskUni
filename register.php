<!-- register.php -->
<?php
  session_start();
  include('db.php');

  if (isset($_POST['register'])) {
    $user = $_POST ['username'];
    $email = $_POST ['email'];
    $password = $_POST ['password'];
    $role = $_POST ['role'];
  }
?>

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

      <label for="email">Email</label>
      <input type="text" id="email" name="email" placeholder="type your Gmail" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Create a password" required>

      <select id="role" name="role" require>
        <option value="student">student</option>
        <option value="admin">admin</option>
      </select>

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