<?php
require_once '../../config/db.php';
include '../../includes/sidebar.php';
include '../../includes/header.php';
?>
<div class="main-content p-4">
<?php
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();
?>
<h3><?= $p['title'] ?></h3>
<p><strong>الوصف:</strong> <?= nl2br($p['description']) ?></p>
<p><strong>الحالة:</strong> <?= $p['status'] ?></p>
<p><strong>التواريخ:</strong> <?= $p['start_date'] ?> → <?= $p['end_date'] ?></p>
</div>