<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $pdo->prepare("DELETE FROM slider WHERE id=?")->execute([$_POST['delete']]);
    } elseif (!empty($_POST['title'])) {
        $img = uploadImage($_FILES['image'] ?? [], 'slider');
        if ($img) {
            $stmt = $pdo->prepare("INSERT INTO slider (title, subtitle, image, link, sort_order, is_active) VALUES (?,?,?,?,?,?)");
            $stmt->execute([$_POST['title'], $_POST['subtitle'], $img, $_POST['link'], (int)$_POST['sort_order'], isset($_POST['is_active'])?1:0]);
        }
    }
    redirect('manage-slider.php');
}
$items = $pdo->query("SELECT * FROM slider ORDER BY sort_order, id DESC")->fetchAll();
?>
<!DOCTYPE html><html><head><title>Slider - Admin</title>
<link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body class="admin-body">
<?php include 'sidebar.php'; ?>
<div class="admin-main">
  <div class="admin-topbar"><h1>Manage Slider</h1></div>
  <form method="post" enctype="multipart/form-data" class="form panel">
    <h3>Add New Slide</h3>
    <div class="row">
      <div><label>Title</label><input name="title" required></div>
      <div><label>Subtitle</label><input name="subtitle"></div>
    </div>
    <div class="row">
      <div><label>Image</label><input type="file" name="image" accept="image/*" required></div>
      <div><label>Link (optional)</label><input name="link"></div>
    </div>
    <div class="row">
      <div><label>Sort Order</label><input type="number" name="sort_order" value="0"></div>
      <div><label><input type="checkbox" name="is_active" checked> Active</label></div>
    </div>
    <button class="btn">Add Slide</button>
  </form>
  <div class="grid grid-3">
    <?php foreach ($items as $s): ?>
    <div class="card">
      <img src="<?= SITE_URL ?>/uploads/slider/<?= e($s['image']) ?>">
      <div class="card-body">
        <h3><?= e($s['title']) ?></h3>
        <p><?= e($s['subtitle']) ?></p>
        <form method="post" onsubmit="return confirm('Delete?')">
          <input type="hidden" name="delete" value="<?= $s['id'] ?>">
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div></body></html>