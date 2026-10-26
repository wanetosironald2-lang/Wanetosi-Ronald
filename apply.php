<?php require_once __DIR__ . '/includes/header.php';
$success = null; $error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    try {
        $appNo = 'NSS-' . date('Y') . '-' . strtoupper(substr(uniqid(), -6));
        $stmt = $pdo->prepare("INSERT INTO applications 
          (application_no, first_name, last_name, gender, dob, class_applied, previous_school, parent_name, parent_phone, parent_email, address)
          VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute([
            $appNo,
            $_POST['first_name'], $_POST['last_name'], $_POST['gender'],
            $_POST['dob'], $_POST['class_applied'], $_POST['previous_school'] ?? '',
            $_POST['parent_name'], $_POST['parent_phone'], $_POST['parent_email'] ?? '',
            $_POST['address'] ?? ''
        ]);
        $success = "Application submitted! Your Application No: <strong>$appNo</strong>. Please save this number to track your application.";
    } catch (Exception $e) { $error = "Submission failed: " . $e->getMessage(); }
}
?>
<section class="page-header"><div class="container"><h1>Online Application</h1></div></section>
<section class="section">
  <div class="container narrow">
    <?php if ($success): ?><div class="alert success"><?= $success ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="form">
      <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
      <h3>Student Information</h3>
      <div class="row">
        <div><label>First Name *</label><input name="first_name" required></div>
        <div><label>Last Name *</label><input name="last_name" required></div>
      </div>
      <div class="row">
        <div><label>Gender *</label>
          <select name="gender" required><option value="">Select</option><option>Male</option><option>Female</option></select></div>
        <div><label>Date of Birth *</label><input type="date" name="dob" required></div>
      </div>
      <div class="row">
        <div><label>Class Applying For *</label>
          <select name="class_applied" required>
            <option value="">Select</option>
            <option>S.1</option><option>S.2</option><option>S.3</option><option>S.4</option>
            <option>S.5</option><option>S.6</option>
          </select></div>
        <div><label>Previous School</label><input name="previous_school"></div>
      </div>
      <h3>Parent/Guardian Information</h3>
      <div class="row">
        <div><label>Parent Name *</label><input name="parent_name" required></div>
        <div><label>Parent Phone *</label><input name="parent_phone" required></div>
      </div>
      <div class="row">
        <div><label>Parent Email</label><input type="email" name="parent_email"></div>
        <div><label>Address</label><input name="address"></div>
      </div>
      <button class="btn" type="submit">Submit Application</button>
    </form>
    <p class="muted">Already applied? <a href="track-application.php">Track your application</a></p>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>