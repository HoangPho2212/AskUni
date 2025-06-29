<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Post</title>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" type="image/png" href="image/LogoTitle.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

  <div class="login-container">
    <h2>Add New Post</h2>
    <form action="add_post.php" method="POST" enctype="multipart/form-data">
      
      <label for="title">Title</label>
      <input type="text" id="title" name="title" required>

      <label for="content">Content</label>
      <textarea id="content" name="content" rows="5" required></textarea>

      <label for="module">Select Module</label>
      <select id="module" name="module_id" required>
        <option value="">-- Select Module --</option>
        <!-- Options will be populated from DB -->
      </select>

      <label for="screenshot">Upload Screenshot</label>
      <input type="file" id="screenshot" name="screenshot">

      <button type="submit" name="submit">Post</button>
    </form>

    <div class="register-link">
      <a href="index.php">
        <i class="fa-solid fa-backward"></i> Back to posts
        </a>
    </div>
  </div>

</body>
</html>
