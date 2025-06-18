<?php
session_start();
require_once '../../config/db.php';
if(!isset($_SESSION['admin_logged_in'])) header('Location: ../login.php');
$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = ?");
$stmt->execute([$id]);
$msg = $stmt->fetch();
if(!$msg) die('Message not found');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"><title>عرض الرسالة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../../assets/css/admin/style.css">

</head>
<body class="p-5">
<?php include '../../includes/admin/sidebar.php'; ?>
<div class="main-content p-4">

<h3>رسالة من: <?= htmlspecialchars($msg['name']) ?></h3>
<p><strong>البريد الإلكتروني:</strong> <?= htmlspecialchars($msg['email']) ?></p>
<p><strong>الموضوع:</strong> <?= htmlspecialchars($msg['subject']) ?></p>
<hr>
<p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
<a href="index.php" class="btn btn-outline-secondary mt-3">رجوع للائحة الرسائل</a>
</div>
</body>
</html>
