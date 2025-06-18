<?php
session_start();
require_once '../../config/db.php';
$messages = $pdo->query("SELECT * FROM contact_messages ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head><meta charset="UTF-8"><title>الرسائل</title>
<link rel="stylesheet" href="../../assets/css/bootstrap.rtl.min.css"></head>
<body>
<?php include '../../includes/sidebar.php'; ?>
<?php include '../../includes/header.php'; ?>
<div class="main-content p-4">
  <h3>رسائل التواصل</h3>
  <table class="table table-bordered">
    <thead><tr><th>الاسم</th><th>البريد</th><th>الموضوع</th><th>الرسالة</th><th>التاريخ</th></tr></thead>
    <tbody>
    <?php foreach($messages as $m): ?>
      <tr>
        <td><?= $m['name'] ?></td>
        <td><?= $m['email'] ?></td>
        <td><?= $m['subject'] ?></td>
        <td><?= $m['message'] ?></td>
        <td><?= $m['created_at'] ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body></html>
