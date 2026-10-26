<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username=?");
    $stmt->execute([$_POST['username']]);
    $a = $stmt->fetch();
    if ($a && password_verify($_POST['password'], $a['password'])) {
        $_SESSION['admin_id'] = $a['id'];
        $_SESSION['admin_name'] = $a['full_name'];
        redirect('dashboard.php');
    }
    $error = "Invalid credentials";
}
?>
<!DOCTYPE html><html><head><title>Admin Login</title>
<link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css"></head>
<body class="admin-login">
  <div class="login-box">
    <h2>Admin Login</h2>
    <p>NKOMA SECONDARY SCHOOL</p>
    <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
      <label for="user_input">Username</label>
<input type="text" id="user_input" name="username" required autofocus>

<label for="pass_input">Password</label>
<input type="password" id="pass_input" name="password" required>
      <button class="btn">Login</button>
    </form>
    <p class="muted"><a href="../index.php">← Back to site</a></p>
  </div>
</body></html>