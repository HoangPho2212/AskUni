<?php
session_start();
require 'db.php'; // Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$post_id = $_GET['id'] ?? null;
if (!$post_id) {
    echo "post ID is missing.";
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