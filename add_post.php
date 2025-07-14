<?php
require_once 'db.php';

session_start(); // Start the session to access session variables

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];  // Retrieve the logged-in user's ID
} else {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
  $title = $_POST['title'];
  $content = $_POST['content'];
  $module_id = $_POST['module_id'];

  // Handle image upload
  $imagePath = null;
  if (!empty($_FILES['screenshot']['name'])) {
    $imageName = basename($_FILES['screenshot']['name']);
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
      mkdir($targetDir); // create the folder if not exist
    }
    $targetFile = $targetDir . time() . '_' . $imageName;
    if (move_uploaded_file($_FILES["screenshot"]["tmp_name"], $targetFile)) {
      $imagePath = $targetFile;
    }
  }

  // Insert into DB
  $stmt = $pdo->prepare("INSERT INTO posts (title, content, module_id, image) VALUES (?, ?, ?, ?)");
  $stmt->execute([$title, $content, $module_id, $imagePath]);

  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Add Post</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="login-container">
    <h2>Add New Post</h2>
    <form action="add_post.php" method="POST" enctype="multipart/form-data">
      <label for="title">Title</label>
      <input type="text" id="title" name="title" required>

      <label for="content">Content</label>
      <textarea id="content" name="content" rows="5" required></textarea>

      <label for="module">Module</label>
      <select name="module_id" id="module" required>
        <option value="">-- Select Module --</option>
        <?php
        $stmt = $pdo->query("SELECT id, name FROM modules");
        while ($row = $stmt->fetch()) {
          echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
      </select>

      <label for="screenshot">Upload Screenshot</label>
      <input type="file" name="screenshot" id="screenshot">

      <button type="submit" name="submit">Submit</button>
    </form>
    <div class="register-link">
      <a href="index.php">← Back to posts</a>
    </div>
  </div>
</body>

</html>