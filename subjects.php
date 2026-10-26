<?php require_once __DIR__ . '/includes/header.php';
$subjects = $pdo->query("SELECT * FROM subjects WHERE is_active=1 ORDER BY department, name")->fetchAll();
$byDept = [];
foreach ($subjects as $s) $byDept[$s['department'] ?: 'General'][] = $s;
?>
<section class="page-header"><div class="container"><h1>Subjects Offered</h1></div></section>
<section class="section">
  <div class="container">
    <?php foreach ($byDept as $dept => $list): ?>
    <h2 class="section-title"><?= e($dept) ?></h2>
    <div class="grid grid-3">
      <?php foreach ($list as $s): ?>
      <div class="card"><div class="card-body">
        <h3><?= e($s['name']) ?> <small>(<?= e($s['code']) ?>)</small></h3>
        <span class="badge"><?= e($s['level']) ?></span>
        <p><?= e($s['description']) ?></p>
      </div></div>
      <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>