<?php require_once __DIR__ . '/includes/header.php';
$app = null; $searched = false;
if (isset($_GET['app_no'])) {
    $searched = true;
    $stmt = $pdo->prepare("SELECT * FROM applications WHERE application_no=?");
    $stmt->execute([trim($_GET['app_no'])]);
    $app = $stmt->fetch();
}
?>
<section class="page-header"><div class="container"><h1>Track Your Application</h1></div></section>
<section class="section">
  <div class="container narrow">
    <form method="get" class="form">
      <label>Application Number</label>
      <input name="app_no" placeholder="e.g. NSS-2025-ABCDEF" required value="<?= e($_GET['app_no']??'') ?>">
      <button class="btn" type="submit">Track</button>
    </form>
    <?php if ($searched && !$app): ?><div class="alert error">No application found with that number.</div><?php endif; ?>
    <?php if ($app): ?>
    <div class="panel">
      <h3>Application <?= e($app['application_no']) ?></h3>
      <p><strong>Name:</strong> <?= e($app['first_name'].' '.$app['last_name']) ?></p>
      <p><strong>Class:</strong> <?= e($app['class_applied']) ?></p>
      <p><strong>Date Submitted:</strong> <?= date('d M Y', strtotime($app['created_at'])) ?></p>
      <p><strong>Status:</strong> <span class="status status-<?= e($app['status']) ?>"><?= e(ucfirst($app['status'])) ?></span></p>
      <?php if ($app['remarks']): ?><p><strong>Remarks:</strong> <?= e($app['remarks']) ?></p><?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>