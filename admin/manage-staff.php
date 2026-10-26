<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) $pdo->prepare("DELETE FROM staff WHERE id=?")->execute([$_POST['delete']]);
    elseif (!empty($_POST['name'])) {
        $img = uploadImage($_FILES['photo'] ?? [], 'staff');
        $pdo->prepare("INSERT INTO staff (name, position, bio, photo, email, phone, category, sort_order) VALUES (?,?,?,?,?,?,?,?)")
            ->execute([$_POST['name'], $_POST['position'], $_POST['bio'], $img, $_POST['email'], $_POST['phone'], $_POST['category'], (int)$_POST['sort_order']]);
    }
    redirect('manage-staff.php');
}
$items = $pdo->query("SELECT * FROM staff ORDER BY category, sort_order")->fetchAll();
?>
<!DOCTYPE html><html><head><title>Staff - Admin</title>
<link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body class="admin-body">
<?php include 'sidebar.php'; ?>
<div class="admin-main">
  <div class="admin-topbar"><h1>Manage Staff</h1></div>
  <form method="post" enctype="multipart/form-data" class="form panel">
    <h3>Add Staff</h3>
    <div class="row">
      <div><label>Name *</label><input name="name" required></div>
      <div><label>Position *</label><input name="position" required></div>
    </div>
    <div class="row">
      <div><label>Category</label>
        <select name="category"><option value="administration">Administration</option><option value="teaching">Teaching</option><option value="support">Support</option></select></div>
      <div><label>Sort Order</label><input type="number" name="sort_order" value="0"></div>
    </div>
    <div class="row">
      <div><label>Email</label><input name="email"></div>
      <div><label>Phone</label><input name="phone"></div>
    </div>
    <label>Bio</label><textarea name="bio" rows="3"></textarea>
    <label>Photo</label><input type="file" name="photo" accept="image/*">
    <button class="btn">Add Staff</button>
  </form>
  <table class="table">
    <tr><th>Photo</th><th>Name</th><th>Position</th><th>Category</th><th>Action</th></tr>
    <?php foreach ($items as $s): ?>
    <tr>
      <td><?php if ($s['photo']): ?><img src="<?= SITE_URL ?>/uploads/staff/<?= e($s['photo']) ?>" width="40" style="border-radius:50%"><?php endif; ?></td>
      <td><?= e($s['name']) ?></td><td><?= e($s['position']) ?></td><td><?= e($s['category']) ?></td>
      <td><form method="post" onsubmit="return confirm('Delete?')"><input type="hidden" name="delete" value="<?= $s['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div></body></html>