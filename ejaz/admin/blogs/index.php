<?php
session_start();
require_once '../../config/db.php';

// Auth
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php'); exit;
}

// Delete post
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: index.php?deleted=1'); exit;
}

// Fetch posts
$stmt = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المقالات - لوحة التحكم</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/admin/style.css">
</head>
<body>
<?php include '../../includes/admin/sidebar.php'; ?>
<div class="main-content">
    <div class="top-navbar">
        <div class="d-flex align-items-center">
            <span class="menu-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></span>
            <h5 class="mb-0 me-3">قائمة المقالات</h5>
        </div>
        <div class="user-dropdown">
            <div class="user-dropdown-toggle" onclick="toggleUserDropdown()">
                <img src="../assets/img/user-avatar.jpg" class="user-avatar"><span><?= $_SESSION['admin_name']??'المدير' ?></span>
            </div>
            <div class="user-dropdown-menu">
                <a href="../settings/profile.php"><i class="fas fa-user"></i> الملف الشخصي</a>
                <a href="../settings/general.php"><i class="fas fa-cog"></i> الإعدادات</a>
                <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</a>
            </div>
        </div>
    </div>
    <div class="content-box">
        <div class="content-box-header">
            <h3>قائمة المقالات</h3>
            <a href="create_update.php" class="btn btn-primary"><i class="fas fa-plus-circle"></i> إضافة مقال جديد</a>
        </div>
        <?php if(isset($_GET['deleted'])): ?><div class="alert alert-success"><i class="fas fa-check-circle"></i> تم حذف المقال.</div><?php endif; ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="60">#</th>
                    <th>العنوان (عربي)</th>
                    <th>العنوان (إنجليزي)</th>
                    <th>التصنيف</th>
                    <th>تاريخ الإنشاء</th>
                    <th width="150">الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                <?php if($posts): foreach($posts as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['title_ar']) ?></td>
                        <td><?= htmlspecialchars($p['title_en']) ?></td>
                        <td><?= htmlspecialchars($p['category']) ?></td>
                        <td><?= date('Y/m/d',strtotime($p['created_at'])) ?></td>
                        <td>
                            <a href="create_update.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> تعديل</a>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $p['id'] ?>)"><i class="fas fa-trash-alt"></i> حذف</button>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="6" class="text-center">لا توجد مقالات.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">تأكيد الحذف</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">هل تريد حذف هذا المقال؟</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger">حذف</a>
            </div>
        </div></div></div>


<?php require_once '../../includes/admin/footer.php';?>

</body>
</html>