<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) $pdo->prepare("DELETE FROM facilities WHERE id=?")->execute([$_POST['delete']]);
    elseif (!empty($_POST['name'])) {
        $img = uploadImage($_FILES['image'] ?? [], 'facilities');
        $pdo->prepare("INSERT INTO facilities (name, description, image) VALUES (?,?,?)")
            ->execute([$_POST['name'], $_POST['description'], $img]);
    }
    redirect('manage-facilities.php');
}
$items = $pdo->query("SELECT * FROM facilities ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html><html><head><title>Facilities - Admin</title>
<link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body class="admin-body">
<?php include 'sidebar.php'; ?>
<div class="admin-main">
  <div class="admin-topbar"><h1>Manage Facilities</h1></div>
  <form method="post" enctype="multipart/form-data" class="form panel">
    <h3>Add Facility</h3>
    <label>Name *</label><input name="name" required>
    <label>Description</label><textarea name="description" rows="3"></textarea>
    <label>Image</label><input type="file" name="image" accept="image/*">
    <button class="btn">Add Facility</button>
  </form>
  <table class="table">
    <tr><th>Image</th><th>Name</th><th>Action</th></tr>
    <?php foreach ($items as $f): ?>
    <tr>
      <td><?php if ($f['image']): ?><img src="<?= SITE_URL ?>/uploads/facilities/<?= e($f['image']) ?>" width="70"><?php endif; ?></td>
      <td><?= e($f['name']) ?></td>
      <td><form method="post" onsubmit="return confirm('Delete?')"><input type="hidden" name="delete" value="<?= $f['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div></body></html>