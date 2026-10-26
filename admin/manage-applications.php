<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $pdo->prepare("UPDATE applications SET status=?, remarks=? WHERE id=?")
        ->execute([$_POST['status'], $_POST['remarks'], $_POST['id']]);
    redirect('manage-applications.php');
}
$items = $pdo->query("SELECT * FROM applications ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html><html><head><title>Applications - Admin</title>
<link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body class="admin-body">
<?php include 'sidebar.php'; ?>
<div class="admin-main">
  <div class="admin-topbar"><h1>Applications (<?= count($items) ?>)</h1></div>
  <?php foreach ($items as $a): ?>
  <div class="panel">
    <h3><?= e($a['application_no']) ?> — <?= e($a['first_name'].' '.$a['last_name']) ?></h3>
    <p><strong>Class:</strong> <?= e($a['class_applied']) ?> • <strong>Gender:</strong> <?= e($a['gender']) ?> • <strong>DOB:</strong> <?= e($a['dob']) ?></p>
    <p><strong>Parent:</strong> <?= e($a['parent_name']) ?> (<?= e($a['parent_phone']) ?>)</p>
    <p><strong>Previous School:</strong> <?= e($a['previous_school']) ?></p>
    <p><strong>Status:</strong> <span class="status status-<?= e($a['status']) ?>"><?= e(ucfirst($a['status'])) ?></span></p>
    <form method="post" class="form">
      <input type="hidden" name="id" value="<?= $a['id'] ?>">
      <input type="hidden" name="update_status" value="1">
      <div class="row">
        <div><label>Update Status</label>
          <select name="status">
            <?php foreach (['pending','reviewed','accepted','rejected'] as $st): ?>
            <option value="<?= $st ?>" <?= $a['status']==$st?'selected':'' ?>><?= ucfirst($st) ?></option>
            <?php endforeach; ?>
          </select></div>
        <div><label>Remarks</label><input name="remarks" value="<?= e($a['remarks']) ?>"></div>
      </div>
      <button class="btn btn-sm">Update</button>
    </form>
  </div>
  <?php endforeach; ?>
</div></body></html>