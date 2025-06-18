<?php
session_start();
require_once '../../config/db.php';

// Auth check
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit;
}

// Delete department
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    // Fetch image to delete file
    $stmt = $pdo->prepare("SELECT image FROM departments WHERE id = ?");
    $stmt->execute([$id]);
    $dept = $stmt->fetch();
    if ($dept && !empty($dept['image']) && file_exists('../uploads/departments/' . $dept['image'])) {
        unlink('../uploads/departments/' . $dept['image']);
    }
    // Delete record
    $stmt = $pdo->prepare("DELETE FROM departments WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: index.php?deleted=1');
    exit;
}

// Fetch departments
$stmt = $pdo->query("SELECT * FROM departments ORDER BY name ASC");
$departments = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة الأقسام - لوحة التحكم</title>
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
            <h5 class="mb-0 me-3">قائمة الأقسام</h5>
        </div>
        <div class="user-dropdown">
            <div class="user-dropdown-toggle" onclick="toggleUserDropdown()">
                <img src="../assets/img/user-avatar.jpg" class="user-avatar" alt="..."><span><?= $_SESSION['admin_name']??'المدير' ?></span>
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
            <h3>قائمة الأقسام</h3>
            <a href="create_update.php" class="btn btn-primary"><i class="fas fa-plus-circle"></i> إضافة قسم جديد</a>
        </div>
        <?php if(isset($_GET['deleted'])): ?>
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> تم حذف القسم بنجاح.</div>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="60">#</th>
                    <th>الصورة</th>
                    <th>اسم القسم</th>
                    <th>الوصف</th>
                    <th width="150">الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                <?php if($departments): foreach($departments as $d): ?>
                    <tr>
                        <td><?= htmlspecialchars($d['id']) ?></td>
                        <td>
                            <?php if(!empty($d['image']) && file_exists('../uploads/departments/'.$d['image'])): ?>
                                <img src="../uploads/departments/<?= $d['image'] ?>" width="60" class="img-thumbnail">
                            <?php else: ?>
                                <div class="img-thumbnail bg-light d-flex justify-content-center align-items-center" style="width:60px;height:60px;"><i class="fas fa-building text-muted"></i></div>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($d['name']) ?></td>
                        <td><?= htmlspecialchars(mb_strimwidth($d['description'],0,50,'...')) ?></td>
                        <td>
                            <a href="create_update.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> تعديل</a>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $d['id'] ?>)"><i class="fas fa-trash-alt"></i> حذف</button>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="5" class="text-center">لا توجد أقسام مضافة.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">تأكيد الحذف</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">هل تريد حذف هذا القسم؟</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger">حذف</a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/admin/footer.php';?>

</body>
</html>

