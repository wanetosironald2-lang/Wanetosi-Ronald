<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_student'])) {
        $no = 'STD-' . date('Y') . '-' . strtoupper(substr(uniqid(),-5));
        $pdo->prepare("INSERT INTO students (student_no, first_name, last_name, class, gender) VALUES (?,?,?,?,?)")
            ->execute([$no, $_POST['first_name'], $_POST['last_name'], $_POST['class'], $_POST['gender']]);
    } elseif (isset($_POST['add_result'])) {
        $grade = gradeFromMarks((int)$_POST['marks']);
        $pdo->prepare("INSERT INTO results (student_id, term, year, subject, marks, grade, remarks) VALUES (?,?,?,?,?,?,?)")
            ->execute([$_POST['student_id'], $_POST['term'], $_POST['year'], $_POST['subject'], $_POST['marks'], $grade, $_POST['remarks']]);
    } elseif (isset($_POST['delete_result'])) {
        $pdo->prepare("DELETE FROM results WHERE id=?")->execute([$_POST['delete_result']]);
    }
    redirect('manage-results.php');
}
$students = $pdo->query("SELECT * FROM students WHERE is_active=1 ORDER BY class, last_name")->fetchAll();
$results = $pdo->query("SELECT r.*, s.first_name, s.last_name, s.class, s.student_no FROM results r JOIN students s ON s.id=r.student_id ORDER BY r.year DESC, r.term DESC, s.last_name LIMIT 100")->fetchAll();
?>
<!DOCTYPE html><html><head><title>Results - Admin</title>
<link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body class="admin-body">
<?php include 'sidebar.php'; ?>
<div class="admin-main">
  <div class="admin-topbar"><h1>Manage Results & Students</h1></div>
  <div class="grid grid-2">
    <form method="post" class="form panel">
      <h3>Add Student</h3>
      <input type="hidden" name="add_student" value="1">
      <div class="row">
        <div><label>First Name *</label><input name="first_name" required></div>
        <div><label>Last Name *</label><input name="last_name" required></div>
      </div>
      <div class="row">
        <div><label>Class *</label><input name="class" required></div>
        <div><label>Gender</label><select name="gender"><option>Male</option><option>Female</option></select></div>
      </div>
      <button class="btn">Add Student</button>
    </form>
    <form method="post" class="form panel">
      <h3>Add Result</h3>
      <input type="hidden" name="add_result" value="1">
      <label>Student</label>
      <select name="student_id" required>
        <?php foreach ($students as $s): ?>
        <option value="<?= $s['id'] ?>"><?= e($s['student_no'].' - '.$s['first_name'].' '.$s['last_name'].' ('.$s['class'].')') ?></option>
        <?php endforeach; ?>
      </select>
      <div class="row">
        <div><label>Term</label><select name="term"><option>Term 1</option><option>Term 2</option><option>Term 3</option></select></div>
        <div><label>Year</label><input type="number" name="year" value="<?= date('Y') ?>" required></div>
      </div>
      <div class="row">
        <div><label>Subject</label><input name="subject" required></div>
        <div><label>Marks</label><input type="number" name="marks" min="0" max="100" required></div>
      </div>
      <label>Remarks</label><input name="remarks">
      <button class="btn">Add Result</button>
    </form>
  </div>
  <h2>Students (<?= count($students) ?>)</h2>
  <table class="table">
    <tr><th>Student No</th><th>Name</th><th>Class</th></tr>
    <?php foreach ($students as $s): ?>
    <tr><td><?= e($s['student_no']) ?></td><td><?= e($s['first_name'].' '.$s['last_name']) ?></td><td><?= e($s['class']) ?></td></tr>
    <?php endforeach; ?>
  </table>
  <h2>Recent Results</h2>
  <table class="table">
    <tr><th>Student</th><th>Class</th><th>Term</th><th>Year</th><th>Subject</th><th>Marks</th><th>Grade</th><th></th></tr>
    <?php foreach ($results as $r): ?>
    <tr>
      <td><?= e($r['first_name'].' '.$r['last_name']) ?></td>
      <td><?= e($r['class']) ?></td><td><?= e($r['term']) ?></td><td><?= e($r['year']) ?></td>
      <td><?= e($r['subject']) ?></td><td><?= e($r['marks']) ?></td><td><?= e($r['grade']) ?></td>
      <td><form method="post"><input type="hidden" name="delete_result" value="<?= $r['id'] ?>"><button class="btn btn-sm btn-danger">X</button></form></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div></body></html>