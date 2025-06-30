<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card-body" style="max-width: 800px;">
        <h2 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h2>
        <p><strong>Module:</strong> <?php echo htmlspecialchars($post['module_name']); ?></p>
        <p style="margin-top: 20px;"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>

        <?php if (!empty($post['image'])): ?>
            <div style="margin-top: 30px;">
                <p><strong>Screenshot:</strong></p>
                <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Screenshot" style="max-width: 100%; border-radius: 10px; box-shadow: 0 0 12px rgba(0,0,0,0.1);">
            </div>
        <?php endif; ?>

        <div style="margin-top: 30px;">
            <a href="index.php" class="btn-secondary">← Back to Posts</a>
        </div>
    </div>
</body>
</html>