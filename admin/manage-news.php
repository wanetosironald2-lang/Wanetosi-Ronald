<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $pdo->prepare("DELETE FROM news WHERE id=?")->execute([$_POST['delete']]);
    } elseif (!empty($_POST['title'])) {
        $slug = slugify($_POST['title']);
        $img = uploadImage($_FILES['image'] ?? [], 'news');
        $stmt = $pdo->prepare("INSERT INTO news (title, slug, content, image, category, author, is_published) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([
            $_POST['title'], $slug, $_POST['content'], $img, $_POST['category'],
            $_SESSION['admin_name'] ?? 'Admin', isset($_POST['is_published'])?1:0
        ]);
    }
    redirect('manage-news.php');
}
$items = $pdo->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html><html><head><title>News - Admin</title>
<link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body class="admin-body">
<?php include 'sidebar.php'; ?>
<div class="admin-main">
  <div class="admin-topbar"><h1>Manage News & Announcements</h1></div>
  <form method="post" enctype="multipart/form-data" class="form panel">
    <h3>Add News</h3>
    <label>Title *</label><input name="title" required>
    <label>Content *</label><textarea name="content" rows="6" required></textarea>
    <div class="row">
      <div><label>Category</label>
        <select name="category">
          <option value="news">News</option>
          <option value="announcement">Announcement</option>
          <option value="event">Event</option>
        </select></div>
      <div><label>Image</label><input type="file" name="image" accept="image/*"></div>
    </div>
    <label><input type="checkbox" name="is_published" checked> Publish</label>
    <button class="btn">Post</button>
  </form>

  <table class="table">
    <tr><th>Title</th><th>Category</th><th>Status</th><th>Date</th><th>Action</th></tr>
    <?php foreach ($items as $n): ?>
    <tr>
      <td><?= e($n['title']) ?></td>
      <td><?= e($n['category']) ?></td>
      <td><?= $n['is_published']?'Published':'Draft' ?></td>
      <td><?= date('d M Y', strtotime($n['created_at'])) ?></td>
      <td><form method="post" onsubmit="return confirm('Delete?')"><input type="hidden" name="delete" value="<?= $n['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div></body></html>