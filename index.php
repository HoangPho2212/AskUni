<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$moduleFilter = $_GET['module'] ?? '';
$search = $_GET['search'] ?? '';

$query = "
    SELECT posts.*, users.username, modules.name AS module_name
    FROM posts
    JOIN users ON posts.user_id = users.id
    JOIN modules ON posts.module_id = modules.id
    WHERE 1=1
    ";

$params = [];

if (!empty($moduleFilter)) {
    $query .= " AND modules.name = :module";
    $params[':module'] = $moduleFilter;
}

if (!empty($search)) {
    $query .= " AND (posts.title LIKE :search OR posts.content LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

$query .= " ORDER BY posts.created_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$modulestmt = $pdo->query("SELECT name FROM modules");
$modules = $modulestmt->fetchAll(PDO::FETCH_COLUMN);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Ask At University</title>
    <link rel="icon" type="image/png" href="image/LogoTitle.png">
    <link rel="stylesheet" href="style.css?v=1.1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="auth-links">
        <a href="logout.php" class="auth-btn">Log-out</a>
    </div>

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

    <div class="content">

        <div class="intro">
            <img src="image/LogoAskUni.png.png" alt="logo of AskUni">
            <p> a community-driven question-and-answer platform. solve college's academic problems by sharing knowledge </p>
        </div>

        <div class="container">
            <form method="GET" action="index.php">
                <div class="sort-option">
                    <label class="collapse">
                        <p>Filter by Module</p>
                        <select class="details" name="module">
                            <option value="">All</option>
                            <?php foreach ($modules as $module): ?>
                                <option value="<?= htmlspecialchars($module) ?>" <?= $moduleFilter === $module ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($module) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                </div>

                <!-- Submit Button -->
                <button type="submit" class="filter-btn"> Apply filter
                    <i class="fa-solid fa-filter"></i>
                </button>
            </form>
            <form method="GET" action="index.php">
            <div class="search-box">
                <input type="text" class="search-txt" name="search" placeholder="what's your problem?" value="<?= htmlspecialchars($search) ?>" >
                <button style="border: none;" type="submit" class="search-btn">
                    <i class="fa-solid fa-question"></i>
                </button>
                
            </div>
            </form>
        </div>

        <?php foreach ($posts as $post): ?>

            <div class="card-body">
                <h3 class="card-title"><?= htmlspecialchars($post['title']) ?></h3>
                <p><?= nl2br(htmlspecialchars(substr($post['content'], 0, 150))) ?>...</p>
                <p><strong>Posted by:</strong> <?php echo htmlspecialchars($post['username']);?>
                    | <strong>Module:</strong> <?php echo htmlspecialchars($post['module_name']);?>
                </p>
        

                <div class="btn-wrapper">
                    <a href="view.php?id=<?= $post['id'] ?>" class="btn-primary">View</a>

                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $post['user_id']): ?>
                        <a href="edit_post.php?id=<?= $post['id'] ?>" class="btn-secondary">Edit</a>
                    <?php endif; ?>
                    
                    <?php if ( 
                        (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') ||
                        (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $post ['user_id'])
                        ): ?>
                        <a href="delete_post.php?id=<?= $post['id'] ?>" class="btn-danger"
                            onclick="return confirm('Are you sure you want to delete this post?');">Delete</a> 
                    <?php endif; ?>

                </div>
            </div>
        <?php endforeach; ?>
        <footer>
            <div>
                <p>&copy; <?= date('Y') ?>.Ask At University. All rights reserved.</p>
                <p>
                    <a href="contact.php">Contact Us</a> |
                    <a>About</a>
                </p>
                <p class="developer"> developed by <a style="text-decoration: none;" href="https://github.com/HoangPho2212">Hoang Pho</a>
                </p>
            </div>
        </footer>
    </div>


    </div>



</body>

</html>