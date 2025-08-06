<?php
session_start();
require_once 'db.php';


$registerMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  $role = $_POST['role'] ?? 'student'; // Default role if not provided

  // Validate input
  if (empty($username) || empty($email) || empty($password)) {
    $registerMessage = "Please fill in all required fields.";
  } else {
    try {
      // Hash the password
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      // Insert into DB using PDO
      $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
      $stmt->execute([$username, $email, $hashedPassword, $role]);

      $registerMessage = "User registered successfully!";

    } catch (PDOException $e) {
      $registerMessage = "Registration failed: " . $e->getMessage();
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Register</title>
  <link rel="stylesheet" href="style.css"> <!-- Link to your CSS -->
</head>

<body>

  <div id="regisform" class="login-container">
    <h2>User Registration</h2>

    <?php if (!empty($registerMessage)): ?>
      <p style="color: red;"><?= $registerMessage ?></p>
    <?php endif; ?>

    <form method="POST" action="register.php">
      <label for="username">Username:</label>
      <input type="text" name="username" required>

      <label for="email">Email:</label>
      <input id="email" type="email" name="email" required>

      <label for="password">Password:</label>
      <input type="password" name="password" required>

      <label for="role">Role:</label>
      <select name="role">
        <option value="student">Student</option>
        <option value="admin" hidden>Admin</option>
      </select>

      <br><br>
      <button type="submit">Register</button>

      <div class="register-link">
        Already have an account? <a href="login.php">Login here</a>
      </div>
    </form>
  </div>

</body>

</html>