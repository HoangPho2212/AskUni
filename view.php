<?php
require_once 'db.php';

// Get post ID from the URL and validate it as an integer
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : null;
$post = null;

// Fetch the post if ID is valid
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Post</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            display: block;
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        .post-container {
            min-height: 500px;
            max-width: 700px;
            margin-left: auto;
            margin-top: 200px;
            margin-right: auto;
            padding: 30px;
            background: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;

        }

        .post-container img {
            max-width: 100%;
            margin-top: 15px;
            border-radius: 8px;
        }

        .not-found {
            color: red;
            text-align: center;
        }
    </style>
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

        <a class="menu_item">
            <i class="fa-solid fa-address-book"></i>
            <span>Contact</span>
        </a>
    </div>

    <div class="post-container">
        <?php if ($post): ?>
            <h2><?= htmlspecialchars($post['title']) ?></h2>
            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

            <?php if (!empty($post['image'])): ?>
                <img src="<?= htmlspecialchars($post['image']) ?>" alt="A detailed description of the primary subject in the post image, including actions, surroundings, any visible text, and the emotional tone if apparent">
            <?php endif; ?>

        <?php else: ?>
            <p class="not-found"> Post not found.</p>
        <?php endif; ?>
    </div>

    <form style="max-width: 700px;" class="login-container" action="" method="POST">
        <h1>Leave a comment</h1>
        <label for="username">User name</label>
        <input type="text" name="username" required><br><br>
        
        <label for="comment">Comment:</label><br>
        <textarea class="Comment-area" name="comment" rows="4" required></textarea><br><br>

        <input class="submit-btn" type="submit" name="submit_comment" value="Post">
    </form>


    </body>

</html>