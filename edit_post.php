<?php
session_start();
require 'db.php'; 

// Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$post_id = $_GET['id'] ?? null;
if (!$post_id) {
    echo "post ID is missing.";
    exit;
}   

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if (!$post) {
    echo "Post not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $stmt->execute([$title, $content, $post_id]);
        header("Location: view.php?id=" . $post_id);
        exit; 
    } else {
        echo "Title and content cannot be empty.";      

    }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <link rel="stylesheet" href="style.css?v=1.1">
    <link rel="icon" type="image/png" href="image/LogoTitle.png">
</head>
<body>
    <div style="width: 400px;" class="login-container">
    <h2>Edit Post</h2>

    <form method="POST">
        <label for="title">Title:</label><br>
        <input class="Comment-area" type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br><br>
        
        <label for="content">Content:</label><br>
        <textarea class="Comment-area" name="content" required><?= htmlspecialchars($post['content']) ?></textarea><br><br>
        
        <button class="submit-btn" type="submit">Save Changes</button>
    </form>

    <div class="register-link">
    <a href="view.php?id=<?= $post['id'] ?>"> ← Back to posts</a>
    </div>

    </div>

</body>
</html>