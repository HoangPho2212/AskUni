<?php
require_once 'db.php';
session_start();

$post_id = $_GET['id'] ?? null;

if (!$post_id) {
    echo "<p style='color:red; text-align:center;'>Post ID is missing.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_submit'])) {
    $comment = trim($_POST['comment']);
    if (!empty($comment) && isset($_SESSION['user_id'])) {
        $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)");
        $stmt->execute([$post_id, $_SESSION["user_id"], $comment]);
    }
    
    }

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

$comment_stmt = $pdo->prepare("SELECT c.comment, c.created_at, u.username 
                               FROM comments c
                               JOIN users u ON c.user_id = u.id 
                               WHERE c.post_id = ?
                               ORDER BY c.created_at DESC");

$comment_stmt->execute([$post_id]);
$comments = $comment_stmt->fetchAll();

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
    <link rel="icon" type="image/png" href="image/LogoTitle.png">
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

    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="card-body">
    <form style="max-width: 350px;" action="" method="POST">
        <h1>Leave a comment</h1>
    
        <label for="comment">Comment:</label><br>
        <textarea class="Comment-area" name="comment" placeholder="type your comment here..." required></textarea><br><br>

        <button class="submit-btn" type="submit" name="comment_submit"> Post </button>
    </form>
    </div>
    <?php else: ?>
        <p style="text-align: center;"> Please <a href="login.php">login</a> to comment.</p>
    <?php endif; ?>

    <div class="card-body">
        <h2>Comments</h2>
        <?php if (!empty($comment)): ?>
            <?php foreach ($comments as $c): ?>
                <div style="margin-bottom: 20px;">
                    <p><strong><?= htmlspecialchars($c['username']) ?></strong> commented on <?= date("F j, Y, g:i a", strtotime($c['created_at'])) ?>:</p>
                    <p><?= nl2br(htmlspecialchars($c['comment'])) ?></p>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No comments yet.</p>
        <?php endif; ?>



    </body>

</html>