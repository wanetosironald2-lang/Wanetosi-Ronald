<?php require_once __DIR__ . '/includes/header.php';
$stmt = $pdo->prepare("SELECT * FROM news WHERE slug=? AND is_published=1");
$stmt->execute([$_GET['slug'] ?? '']);
$n = $stmt->fetch();
if (!$n) { echo "<div class='container section'><h2>Article not found</h2></div>"; require 'includes/footer.php'; exit; }
?>
<section class="page-header"><div class="container"><h1><?= e($n['title']) ?></h1>
<small><?= date('d M Y', strtotime($n['created_at'])) ?> • <?= e(ucfirst($n['category'])) ?></small></div></section>
<section class="section"><div class="container narrow article">
  <?php if ($n['image']): ?><img class="feature" src="<?= SITE_URL ?>/uploads/news/<?= e($n['image']) ?>"><?php endif; ?>
  <div><?= nl2br(e($n['content'])) ?></div>
</div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>