<?php
require_once 'db.php';

session_start(); // Start the session to access session variables

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'] ?? '';
  $content = $_POST['content'];
  $user_id = $_SESSION['user_id'] ?? '';
  $module_id = $_POST['module_id'] ?? '';
  $imagePath = '';

  if (!empty($_FILES['image']['name'])) {
    $targetDir = 'uploads/';
    $fileName = basename($_FILES['image']['name']);
    $targetFilePath = $targetDir . time() . '_' .$fileName;

    if(move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
      $imagePath = $targetFilePath;
    }
  }

  if (empty($title) || empty($content)) {
    echo "Please fill in both fields.";
  } else {
    try {
    $stmt = $pdo->prepare( "INSERT INTO posts (User_id, title, content, image) VALUES (?,?,?,?)");
    $stmt->execute([$user_id, $title, $content, $imagePath ?? null]);

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
      <input type="file" name="image" id="screenshot">

      <button type="submit" name="submit">Submit</button>
    </form>
    <div class="register-link">
      <a href="index.php">← Back to posts</a>
    </div>
  </div>
</body>

</html>