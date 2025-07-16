<?php
session_start();
require_once '../../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit;
}

// Delete user if requested
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // Don't allow deleting yourself
    if ($id == $_SESSION['admin_id']) {
        $error = 'لا يمكنك حذف حسابك الحالي';
    } else {
        // Delete user
        $stmt = $pdo->prepare("DELETE FROM admin_users WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: index.php?deleted=1");
        exit;
    }
}

// Fetch all users
$query = "SELECT * FROM admin_users ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستخدمين - شركة انجاز النوادي للمقاولات العامة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/admin/style.css">
</head>
<body>
<?php include '../../includes/admin/sidebar.php'; ?>


<div class="main-content">
    <div class="top-navbar">
        <div class="d-flex align-items-center">
                <span class="menu-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </span>
            <h5 class="mb-0 me-3">إدارة المستخدمين</h5>
        </div>
        <div class="user-dropdown">
            <div class="user-dropdown-toggle" onclick="toggleUserDropdown()">
                <img src="../assets/img/user-avatar.jpg" alt="صورة المستخدم" class="user-avatar">
                <span><?= $_SESSION['admin_name'] ?? 'المدير' ?></span>
            </div>
            <div class="user-dropdown-menu">
                <a href="../settings/profile.php"><i class="fas fa-user"></i>الملف الشخصي</a>
                <a href="../settings/general.php"><i class="fas fa-cog"></i>الإعدادات</a>
                <a href="../logout.php"><i class="fas fa-sign-out-alt"></i>تسجيل الخروج</a>
            </div>
        </div>
    </div>

    <div class="content-box">
        <div class="content-box-header">
            <h3>إدارة المستخدمين</h3>
            <a href="add.php" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> إضافة مستخدم جديد
            </a>
        </div>

        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle me-2"></i> تم حذف المستخدم بنجاح.
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="50">#</th>
                    <th>اسم المستخدم</th>
                    <th>تاريخ الإنشاء</th>
                    <th width="120">الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= date('Y/m/d H:i', strtotime($user['created_at'])) ?></td>
                            <td>
                                <a href="edit.php?id=<?= $user['id'] ?>" class="table-action-btn btn-edit" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                    <a href="#" class="table-action-btn btn-delete" title="حذف" onclick="confirmDelete(<?= $user['id'] ?>)">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-4">لا يوجد مستخدمين متاحين</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                هل أنت متأكد من رغبتك في حذف هذا المستخدم؟ هذا الإجراء لا يمكن التراجع عنه.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">تأكيد الحذف</a>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/admin/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // show the “Confirm Delete” modal and wire up its button
    function confirmDelete(id) {
        // if this page is users/index.php, you can just use '?delete='
        // otherwise explicitly include the filename, e.g. 'index.php?delete='
        const url = '?delete=' + id;
        document.getElementById('confirmDeleteBtn').href = url;

        // launch the Bootstrap modal
        const modalEl = document.getElementById('deleteModal');
        const bsModal = new bootstrap.Modal(modalEl);
        bsModal.show();
    }
</script>

</body>
</html>