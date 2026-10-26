<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function e($str) { return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8'); }

function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    return strtolower(trim(preg_replace('~-+~', '-', $text), '-'));
}

function redirect($url) { header("Location: $url"); exit; }

function isAdmin() { return isset($_SESSION['admin_id']); }

function requireAdmin() {
    if (!isAdmin()) redirect('login.php');
}

function getSetting($pdo, $key, $default = '') {
    $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key=?");
    $stmt->execute([$key]);
    $v = $stmt->fetchColumn();
    return $v !== false ? $v : $default;
}

function uploadImage($file, $folder) {
    if (empty($file['name'])) return null;
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif','webp'];
    if (!in_array($ext, $allowed)) return null;
    $dir = UPLOAD_PATH . $folder . '/';
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $name = uniqid() . '.' . $ext;
    if (move_uploaded_file($file['tmp_name'], $dir . $name)) return $name;
    return null;
}

function gradeFromMarks($marks) {
    if ($marks >= 80) return 'A';
    if ($marks >= 70) return 'B';
    if ($marks >= 60) return 'C';
    if ($marks >= 50) return 'D';
    if ($marks >= 40) return 'E';
    return 'F';
}

function flash($key, $msg = null) {
    if ($msg === null) {
        $v = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $v;
    }
    $_SESSION['flash'][$key] = $msg;
}

function csrfToken() {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}

function verifyCsrf() {
    if (($_POST['csrf'] ?? '') !== ($_SESSION['csrf'] ?? '')) {
        die('Invalid CSRF token');
    }
}
?>