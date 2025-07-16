<?php
require_once '../../config/db.php';
include '../../includes/sidebar.php';
include '../../includes/header.php';
?>
<div class="main-content p-4">
<?php
$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
$stmt->execute([$id]);
header('Location: index.php');
?>
</div>