<?php
session_start();
require 'db.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if ($_SESSION['role'] !== 'admin' && $_SESSION['user_id'] != $post['user_id']) {
    die("Access denied. You can't delete this post.");
}

$post_id = $_GET['id'] ?? '';
if (!$post_id) {
    echo "Post ID is missing.";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();


$stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
$stmt->execute([$post_id]);

if ($stmt->rowCount() > 0) {
    echo "Post deleted successfully.";
} else {
    echo "Failed to delete the post or post does not exist.";
}

header("Location: index.php");
exit;
?>