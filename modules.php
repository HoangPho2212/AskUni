<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");  // Redirect to homepage if not an admin
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['module_name'])) {
    $name = trim($_POST['module_name']);

    try {
        $insert_stmt = $pdo->prepare("INSERT INTO modules (name) VALUES (:module_name)");
        $insert_stmt->execute([':module_name' => $name]);
        header("Location: modules.php");
        exit();
    } catch (PDOException $e) {
        echo "Error adding module: " . $e->getMessage();    
    }


    // Prepare and execute the insert query
    try {
        $insert_stmt = $pdo->prepare("INSERT INTO modules (name) VALUES (:module_name)");
        $insert_stmt->bindParam(':module_name', $module_name, PDO::PARAM_STR);
        $insert_stmt->execute();

        // Redirect back to modules page after insertion
        header("Location: modules.php");
        exit();
    } catch (PDOException $e) {
        echo "Error adding module: " . $e->getMessage();
    }
}

try {
    $stmt = $pdo->prepare("SELECT id, name FROM modules");
    $stmt->execute();
    $modules = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database query failed: " . $e->getMessage());
}

// Handle module deletion
if (isset($_GET['delete_module'])) {
    $module_id = $_GET['delete_module'];

    // Prepare and execute the delete query
    try {
        $delete_stmt = $pdo->prepare("DELETE FROM modules WHERE id = :module_id");
        $delete_stmt->bindParam(':module_id', $module_id, PDO::PARAM_INT);
        $delete_stmt->execute();

        // Redirect back to modules page after deletion
        header("Location: modules.php");
        exit();
    } catch (PDOException $e) {
        echo "Error deleting module: " . $e->getMessage();
    }
}

try {
    $stmt = $pdo->prepare("SELECT id, name FROM modules");
    $stmt->execute();
    $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database query failed: " . $e->getMessage());

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Module Management</title>
    <link rel="icon" type="image/png" href="image/LogoTitle.png">
    <link rel="stylesheet" href="style.css?v=1.1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body style="display: flex; flex-direction: column;" >
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
        <h2>Module Management</h2>
        <p>Below is the list of all Modules</p>

        <table class="card-body">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Module name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($modules as $module): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($module['id']); ?></td>
                        <td><?php echo htmlspecialchars($module['name']); ?></td>
                        <td>
                            <a href="modules.php?delete_module=<?php echo $module['id']; ?>" class="btn-danger" onclick="return confirm('Are you sure you want to delete this module?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<!-- Form to add a new module -->
    <div class="login-container">
        <h2>Add New Module</h2>
    <form method="POST" class="form">
        <input type="text" name="module_name" class="input" placeholder="Enter new module name" required>
        <button type="submit" class="button">Add Module</button>
    </form>

    
</body>
</html>