<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) $pdo->prepare("DELETE FROM subjects WHERE id=?")->execute([$_POST['delete']]);
    elseif (!empty($_POST['name'])) {
        $pdo->prepare("INSERT INTO subjects (name, code, description, level, department) VALUES (?,?,?,?,?)")
            ->execute([$_POST['name'], $_POST['code'], $_POST['description'], $_POST['level'], $_POST['department']]);
    }
    redirect('manage-subjects.php');
}
$items = $pdo->query("SELECT * FROM subjects ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html><html><head><title>Subjects - Admin</title>
<link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body class="admin-body">
<?php include 'sidebar.php'; ?>
<div class="admin-main">
  <div class="admin-topbar"><h1>Manage Subjects</h1></div>
  <form method="post" class="form panel">
    <h3>Add Subject</h3>
    <div class="row">
      <div><label>Name *</label><input name="name" required></div>
      <div><label>Code</label><input name="code"></div>
    </div>
    <div class="row">
      <div><label>Level</label>
        <select name="level"><option>O-Level</option><option>A-Level</option><option>Both</option></select></div>
      <div><label>Department</label><input name="department"></div>
    </div>
    <label>Description</label><textarea name="description" rows="3"></textarea>
    <button class="btn">Add Subject</button>
  </form>
  <table class="table">
    <tr><th>Name</th><th>Code</th><th>Level</th><th>Department</th><th>Action</th></tr>
    <?php foreach ($items as $s): ?>
    <tr><td><?= e($s['name']) ?></td><td><?= e($s['code']) ?></td><td><?= e($s['level']) ?></td><td><?= e($s['department']) ?></td>
    <td><form method="post" onsubmit="return confirm('Delete?')"><input type="hidden" name="delete" value="<?= $s['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form></td></tr>
    <?php endforeach; ?>
  </table>
</div></body></html>