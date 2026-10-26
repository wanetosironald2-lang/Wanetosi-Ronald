</main>
<footer class="site-footer">
  <div class="container footer-grid">
    <div>
      <h3><?= e($schoolName) ?></h3>
      <p><?= e($motto) ?></p>
      <p><?= e(getSetting($pdo,'school_address')) ?></p>
    </div>
    <div>
      <h3>Quick Links</h3>
      <a href="<?= SITE_URL ?>/apply.php">Apply Online</a>
      <a href="<?= SITE_URL ?>/track-application.php">Track Application</a>
      <a href="<?= SITE_URL ?>/results.php">Check Results</a>
      <a href="<?= SITE_URL ?>/news.php">News & Events</a>
    </div>
    <div>
      <h3>Contact Us</h3>
      <p><i class="fa fa-phone"></i> <?= e(getSetting($pdo,'school_phone')) ?></p>
      <p><i class="fa fa-envelope"></i> <?= e(getSetting($pdo,'school_email')) ?></p>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      &copy; <?= date('Y') ?> <?= e($schoolName) ?>
    </div>
  </div>
</footer>
</body>
</html>