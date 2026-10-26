<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';
$schoolName = getSetting($pdo, 'school_name', 'NKOMA SECONDARY SCHOOL');
$motto = getSetting($pdo, 'school_motto', 'HONESTY AND HARDWORK');
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($schoolName) ?> - <?= e($motto) ?></title>
<link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<header class="site-header">
  <div class="topbar">
    <div class="container topbar-inner">
      <div><i class="fa fa-phone"></i> <?= e(getSetting($pdo,'school_phone')) ?> 
        &nbsp; <i class="fa fa-envelope"></i> <?= e(getSetting($pdo,'school_email')) ?></div>
      <div><a href="<?= SITE_URL ?>/admin/login.php"><i class="fa fa-user-shield"></i> Admin</a></div>
    </div>
  </div>
  <div class="container navbar">
    <a href="<?= SITE_URL ?>/index.php" class="logo">
      <div class="logo.jpg"></div>
      <div>
        <h1><?= e($schoolName) ?></h1>
        <small><?= e($motto) ?></small>
      </div>
    </a>
    <nav>
      <a href="<?= SITE_URL ?>/index.php" class="<?= $currentPage=='index.php'?'active':'' ?>">Home</a>
      <a href="<?= SITE_URL ?>/about.php" class="<?= $currentPage=='about.php'?'active':'' ?>">Administration</a>
      <a href="<?= SITE_URL ?>/subjects.php" class="<?= $currentPage=='subjects.php'?'active':'' ?>">Subjects</a>
      <a href="<?= SITE_URL ?>/facilities.php" class="<?= $currentPage=='facilities.php'?'active':'' ?>">Facilities</a>
      <a href="<?= SITE_URL ?>/apply.php" class="<?= $currentPage=='apply.php'?'active':'' ?>">Apply</a>
      <a href="<?= SITE_URL ?>/results.php" class="<?= $currentPage=='results.php'?'active':'' ?>">Results</a>
      <a href="<?= SITE_URL ?>/news.php" class="<?= $currentPage=='news.php'?'active':'' ?>">News</a>
      <a href="<?= SITE_URL ?>/contact.php" class="<?= $currentPage=='contact.php'?'active':'' ?>">Contact</a>
    </nav>
  </div>
</header>
<main>