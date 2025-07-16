<?php
session_start();
require_once '../../config/db.php';
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM contact_messages WHERE id = ?")
        ->execute([$id]);
    header('Location: index.php?deleted=1');
    exit;
}

// Fetch all messages
$stmt     = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>رسائل التواصل</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/admin/style.css">

</head>
<body>
<?php include '../../includes/admin/sidebar.php'; ?>
<div class="main-content p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>رسائل التواصل</h3>
        <a href="#" onclick="location.reload()" class="btn btn-secondary">
            <i class="fas fa-sync"></i> تحديث
        </a>
    </div>

    <?php if(isset($_GET['deleted'])): ?>
        <div class="alert alert-success">تم حذف الرسالة بنجاح.</div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الموضوع</th>
                <th>التاريخ</th>
                <th width="100">إجراء</th>
            </tr>
            </thead>
            <tbody>
            <?php if(count($messages)): foreach($messages as $m): ?>
                <tr>
                    <td><?= $m['id'] ?></td>
                    <td><?= htmlspecialchars($m['name']) ?></td>
                    <td><?= htmlspecialchars($m['email']) ?></td>
                    <td><?= htmlspecialchars($m['subject']) ?></td>
                    <td><?= date('Y/m/d H:i',strtotime($m['created_at'])) ?></td>
                    <td>
                        <a href="view.php?id=<?= $m['id'] ?>" class="btn btn-sm btn-info" title="عرض">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button onclick="confirmDelete(<?= $m['id'] ?>)" class="btn btn-sm btn-danger" title="حذف">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="6" class="text-center py-4">لا توجد رسائل حالياً</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../../includes/admin/footer.php'; ?>

<!-- Delete Confirmation -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmDelete(id) {
        if (confirm('هل أنت متأكد أنك تريد حذف هذه الرسالة؟')) {
            location.href = 'index.php?delete=' + id;
        }
    }
</script>
</body>
</html>
