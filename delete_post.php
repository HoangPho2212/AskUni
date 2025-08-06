<?php
session_start();
require 'db.php';

// redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get post ID from URL
$post_id = $_GET['id'] ?? '';
if (!$post_id) {
    die("Post ID is missing.");
}

// Fetch the post first
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if (!$post) {
    die("Post not found.");
}

// Check permissions
if ($_SESSION['role'] !== 'admin' && $_SESSION['user_id'] != $post['user_id']) {
    die("Access denied. You can't delete this post.");
}

// Now delete
$stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
$stmt->execute([$post_id]);

header("Location: index.php");
exit;
?>