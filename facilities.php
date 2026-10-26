<?php require_once __DIR__ . '/includes/header.php';
$fac = $pdo->query("SELECT * FROM facilities WHERE is_active=1 ORDER BY id DESC")->fetchAll();
?>
<section class="page-header"><div class="container"><h1>Our Facilities</h1></div></section>
<section class="section">
  <div class="container">
    <div class="grid grid-2">
      <?php foreach ($fac as $f): ?>
      <div class="card">
        <?php if ($f['image']): ?><img src="<?= SITE_URL ?>/uploads/facilities/<?= e($f['image']) ?>"><?php endif; ?>
        <div class="card-body">
          <h3><?= e($f['name']) ?></h3>
          <p><?= e($f['description']) ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>