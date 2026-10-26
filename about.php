<?php require_once __DIR__ . '/includes/header.php';
$staff = $pdo->query("SELECT * FROM staff WHERE is_active=1 ORDER BY sort_order ASC, id ASC")->fetchAll();
$grouped = ['administration'=>[], 'teaching'=>[], 'support'=>[]];
foreach ($staff as $s) $grouped[$s['category']][] = $s;
?>
<section class="page-header"><div class="container"><h1>School Administration & Management</h1></div></section>
<section class="section">
  <div class="container">
    <?php foreach (['administration'=>'Administration','teaching'=>'Teaching Staff','support'=>'Support Staff'] as $k=>$label): 
      if (empty($grouped[$k])) continue; ?>
    <h2 class="section-title"><?= $label ?></h2>
    <div class="grid grid-4">
      <?php foreach ($grouped[$k] as $m): ?>
      <div class="staff-card">
        <img src="<?= SITE_URL ?>/uploads/staff/<?= e($m['photo'] ?: 'default.jpg') ?>" alt="">
        <h3><?= e($m['name']) ?></h3>
        <p class="role"><?= e($m['position']) ?></p>
        <p><?= e($m['bio']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>