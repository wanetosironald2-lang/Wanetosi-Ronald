<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $pdo->prepare("DELETE FROM messages WHERE id=?")->execute([$_POST['delete']]);
    redirect('manage-messages.php');
}
$pdo->exec("UPDATE messages SET is_read=1");
$items = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html><html><head><title>Messages - Admin</title>
<link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body class="admin-body">
<?php include 'sidebar.php'; ?>
<div class="admin-main">
  <div class="admin-topbar"><h1>Messages (<?= count($items) ?>)</h1></div>
  <?php foreach ($items as $m): ?>
  <div class="panel">
    <h3><?= e($m['subject'] ?: 'No Subject') ?></h3>
    <p><small>From: <strong><?= e($m['name']) ?></strong> (<?= e($m['email']) ?>) on <?= date('d M Y H:i', strtotime($m['created_at'])) ?></small></p>
    <p><?= nl2br(e($m['message'])) ?></p>
    <form method="post"><input type="hidden" name="delete" value="<?= $m['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form>
  </div>
  <?php endforeach; ?>
</div></body></html>