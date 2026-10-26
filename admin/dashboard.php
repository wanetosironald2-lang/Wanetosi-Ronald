<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

$stats = [
  'slider' => $pdo->query("SELECT COUNT(*) FROM slider")->fetchColumn(),
  'news' => $pdo->query("SELECT COUNT(*) FROM news")->fetchColumn(),
  'subjects' => $pdo->query("SELECT COUNT(*) FROM subjects")->fetchColumn(),
  'staff' => $pdo->query("SELECT COUNT(*) FROM staff")->fetchColumn(),
  'applications' => $pdo->query("SELECT COUNT(*) FROM applications")->fetchColumn(),
  'pending' => $pdo->query("SELECT COUNT(*) FROM applications WHERE status='pending'")->fetchColumn(),
  'messages' => $pdo->query("SELECT COUNT(*) FROM messages WHERE is_read=0")->fetchColumn(),
];
?>
<!DOCTYPE html><html><head><title>Dashboard - Admin</title>
<link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head><body class="admin-body">
<?php include 'sidebar.php'; ?>
<div class="admin-main">
  <div class="admin-topbar">
    <h1>Dashboard</h1>
    <span>Welcome, <?= e($_SESSION['admin_name']) ?></span>
  </div>
  <div class="grid grid-4">
    <div class="stat-card"><i class="fa fa-newspaper"></i><h3><?= $stats['news'] ?></h3><p>News</p></div>
    <div class="stat-card"><i class="fa fa-book"></i><h3><?= $stats['subjects'] ?></h3><p>Subjects</p></div>
    <div class="stat-card"><i class="fa fa-user-graduate"></i><h3><?= $stats['applications'] ?></h3><p>Applications</p></div>
    <div class="stat-card"><i class="fa fa-clock"></i><h3><?= $stats['pending'] ?></h3><p>Pending Applications</p></div>
  </div>
  <h2>Quick Actions</h2>
  <div class="quick-actions">
    <a href="manage-slider.php" class="qa"><i class="fa fa-images"></i> Manage Slider</a>
    <a href="manage-news.php" class="qa"><i class="fa fa-bullhorn"></i> Post News</a>
    <a href="manage-applications.php" class="qa"><i class="fa fa-file-alt"></i> Applications</a>
    <a href="manage-results.php" class="qa"><i class="fa fa-award"></i> Results</a>
    <a href="manage-subjects.php" class="qa"><i class="fa fa-book"></i> Subjects</a>
    <a href="manage-staff.php" class="qa"><i class="fa fa-users"></i> Staff</a>
    <a href="manage-facilities.php" class="qa"><i class="fa fa-building"></i> Facilities</a>
  </div>
</div>
</body></html>