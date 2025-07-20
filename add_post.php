<?php
require_once 'db.php';

session_start(); // Start the session to access session variables

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'] ?? '';
  $content = $_POST['content'];
  $user_id = $_SESSION['user_id'] ?? '';

  if (empty($title) || empty($content)) {
    echo "Please fill in both fields.";
  } else {
    try {
    $stmt = $pdo->prepare( "INSERT INTO posts (User_id, title, content) VALUES (?,?,?)");
    $stmt->execute([$user_id, $title, $content]);

    header("Location: index.php");
    exit;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  }

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