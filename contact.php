<?php require_once __DIR__ . '/includes/header.php';
$msg = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $stmt = $pdo->prepare("INSERT INTO messages (name,email,subject,message) VALUES (?,?,?,?)");
    $stmt->execute([$_POST['name'],$_POST['email'],$_POST['subject'],$_POST['message']]);
    $msg = "Thank you! Your message has been received.";
}
?>
<section class="page-header"><div class="container"><h1>Contact Us</h1></div></section>
<section class="section"><div class="container narrow">
  <?php if ($msg): ?><div class="alert success"><?= e($msg) ?></div><?php endif; ?>
  <div class="grid grid-2">
    <div>
      <h3>Get in touch</h3>
      <p><i class="fa fa-map"></i> <?= e(getSetting($pdo,'school_address')) ?></p>
      <p><i class="fa fa-phone"></i> <?= e(getSetting($pdo,'school_phone')) ?></p>
      <p><i class="fa fa-envelope"></i> <?= e(getSetting($pdo,'school_email')) ?></p>
    </div>
    <form method="post" class="form">
      <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
      <label>Name *</label><input name="name" required>
      <label>Email *</label><input type="email" name="email" required>
      <label>Subject</label><input name="subject">
      <label>Message *</label><textarea name="message" rows="5" required></textarea>
      <button class="btn">Send Message</button>
    </form>
  </div>
</div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>