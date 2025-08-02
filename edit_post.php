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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <?php
                if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                    echo '<a href="users.php" class="menu_item">
                            <i class="fa-solid fa-users"></i>
                            <span>Users</span>
                        </a>';
                    echo '<a href="modules.php" class="menu_item">
                            <i class="fa-solid fa-pen-to-square"></i>
                            <span>Modules</span>
                        </a>';
                }
            ?>
    </div>

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