<?php require_once __DIR__ . '/includes/header.php';
$page = max(1, (int)($_GET['page'] ?? 1));
$per = 6; $offset = ($page-1)*$per;
$total = $pdo->query("SELECT COUNT(*) FROM news WHERE is_published=1")->fetchColumn();
$pages = ceil($total/$per);
$stmt = $pdo->prepare("SELECT * FROM news WHERE is_published=1 ORDER BY created_at DESC LIMIT $per OFFSET $offset");
$stmt->execute();
$items = $stmt->fetchAll();
?>
<section class="page-header"><div class="container"><h1>News & Announcements</h1></div></section>
<section class="section"><div class="container">
  <div class="grid grid-3">
    <?php foreach ($items as $n): ?>
    <div class="card">
      <?php if ($n['image']): ?><img src="<?= SITE_URL ?>/uploads/news/<?= e($n['image']) ?>"><?php endif; ?>
      <div class="card-body">
        <span class="badge"><?= e(ucfirst($n['category'])) ?></span>
        <h3><?= e($n['title']) ?></h3>
        <small><?= date('d M Y', strtotime($n['created_at'])) ?></small>
        <p><?= e(mb_substr(strip_tags($n['content']),0,120)) ?>...</p>
        <a href="news-detail.php?slug=<?= e($n['slug']) ?>">Read more →</a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="pagination">
    <?php for ($i=1; $i<=$pages; $i++): ?>
      <a class="<?= $i==$page?'active':'' ?>" href="?page=<?= $i ?>"><?= $i ?></a>
    <?php endfor; ?>
  </div>
</div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>