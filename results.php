<?php require_once __DIR__ . '/includes/header.php';
$results = []; $student = null; $searched = false;
if (isset($_GET['student_no'], $_GET['term'], $_GET['year'])) {
    $searched = true;
    $stmt = $pdo->prepare("SELECT * FROM students WHERE student_no=? AND is_active=1");
    $stmt->execute([trim($_GET['student_no'])]);
    $student = $stmt->fetch();
    if ($student) {
        $s = $pdo->prepare("SELECT * FROM results WHERE student_id=? AND term=? AND year=? ORDER BY subject");
        $s->execute([$student['id'], $_GET['term'], $_GET['year']]);
        $results = $s->fetchAll();
    }
}
?>
<section class="page-header"><div class="container"><h1>Student Results Portal</h1></div></section>
<section class="section">
  <div class="container narrow">
    <form method="get" class="form">
      <div class="row">
        <div><label>Student Number</label><input name="student_no" required value="<?= e($_GET['student_no']??'') ?>"></div>
        <div><label>Term</label>
          <select name="term" required>
            <?php foreach (['Term 1','Term 2','Term 3'] as $t): ?>
            <option <?= ($_GET['term']??'')==$t?'selected':'' ?>><?= $t ?></option>
            <?php endforeach; ?>
          </select></div>
        <div><label>Year</label>
          <input type="number" name="year" value="<?= e($_GET['year']??date('Y')) ?>" required></div>
      </div>
      <button class="btn" type="submit">View Results</button>
    </form>

    <?php if ($searched && !$student): ?>
      <div class="alert error">Student not found. Please check the student number.</div>
    <?php elseif ($student): ?>
      <div class="panel">
        <h3><?= e($student['first_name'].' '.$student['last_name']) ?> — <?= e($student['class']) ?></h3>
        <p><strong><?= e($_GET['term']) ?> <?= e($_GET['year']) ?></strong></p>
        <?php if (!$results): ?><p>No results published yet.</p>
        <?php else: ?>
        <table class="table">
          <tr><th>Subject</th><th>Marks</th><th>Grade</th><th>Remarks</th></tr>
          <?php $total=0; foreach ($results as $r): $total+=$r['marks']; ?>
          <tr>
            <td><?= e($r['subject']) ?></td>
            <td><?= (int)$r['marks'] ?></td>
            <td><?= e($r['grade']) ?></td>
            <td><?= e($r['remarks']) ?></td>
          </tr>
          <?php endforeach; ?>
          <tr><td><strong>Average</strong></td><td colspan="3"><strong><?= round($total/count($results),1) ?></strong></td></tr>
        </table>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>