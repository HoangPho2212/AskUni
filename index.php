<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Ask At University</title>
    <link rel="icon" type="image/png" href="image/LogoTitle.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="auth-links">
        <a href="login.php" class="auth-btn">Login</a>
        <a href="register.php" class="auth-btn">Register</a>
    </div>

</head>

<body>
    <input type="checkbox" id="menu-toggle" hidden>
    <label for="menu-toggle" class="menu-toggle"><i class="fa-solid fa-bars-staggered"></i></label>

    <div class="menu">

        <div class="menu_header">
            <h2>Q&A Portal</h2>
        </div>

        <div class="menu_item">
            <i class="fa-solid fa-house"></i>
            <span>Home</span>
        </div>

        <div class="menu_item">
            <i class="fa-solid fa-plus"></i>
            <span>Add Post</span>
        </div>

        <div class="menu_item">
            <i class="fa-solid fa-address-book"></i>
            <span>Contact</span>
        </div>
        <div class="watermark">
            <a href="https://www.facebook.com/hoang.pho.1911?locale=vi_VN">@2025 Hoang Pho</a>
        </div>
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
                            <option value="COMP1841">Web Programming 1</option>
                            <option value="COMP1773"> User Interface Design</option>
                            <option value="COMP1770"> Professional Project Management</option>
                        </select>
                    </label>

                </div>

                <div class="sort-option">
                    <label class="collapse">
                        <p>Filter by Lecturer</p>
                        <select class="details" name="lecturer">
                            <option value="">All</option>
                            <option value="Truc">Mr. Tran Thanh Truc</option>
                            <option value="Son">Dr. Pham Thanh Son</option>
                            <option value="Vinh">Dr. Vinh</option>
                        </select>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="filter-btn"> Apply filter
                    <i class="fa-solid fa-filter"></i>
                </button>
            </form>
            <div class="search-box">
                <input type="text" class="search-txt" name="" placeholder="what's your problem?">
                <a href="#" class="search-btn">
                    <i class="fa-solid fa-question"></i>
                </a>
            </div>
        </div>
        <?php
        require 'db.php';
        $stmt = $pdo->query("SELECT posts.*, users.username, modules.name AS module_name 
                     FROM posts 
                     JOIN users ON posts.user_id = users.id 
                     JOIN modules ON posts.module_id = modules.id 
                     ORDER BY posts.created_at DESC");

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>';
            echo '<p class="card-text">By ' . htmlspecialchars($row['username']) . ' | Module: ' . htmlspecialchars($row['module_name']) . ' | ' . $row['created_at'] . '</p>';
            echo '<p class="card-text">' . nl2br(htmlspecialchars($row['content'])) . '</p>';

            if (!empty($row['image'])) {
                echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Post Image" style="max-width:100%; height:auto;">';
            }

            echo '<a href="#" class="btn-primary">View</a> ';
            echo '<a href="#" class="btn-secondary">Edit</a> ';
            echo '<a href="#" class="btn-danger">Delete</a>';
            echo '</div>';
        }
        ?>

    </div>



</body>

</html>