<?php
session_start();
require_once '../../config/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit;
}

// Delete service if requested
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // Get service image to delete file
    $stmt = $pdo->prepare("SELECT img FROM services WHERE id = ?");
    $stmt->execute([$id]);
    $service = $stmt->fetch();

    if ($service && !empty($service['img']) && file_exists('../uploads/services/' . $service['img'])) {
        unlink('../uploads/services/' . $service['img']);
    }

    // Delete the service record
    $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: index.php?deleted=1');
    exit;
}

// Fetch all services
$stmt = $pdo->query("SELECT * FROM services ORDER BY `order` ASC");
$services = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة الخدمات - لوحة التحكم</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/admin/style.css">
</head>
<body>
<?php require_once '../../includes/admin/sidebar.php';?>

<div class="main-content">
    <div class="top-navbar">
        <div class="d-flex align-items-center">
            <span class="menu-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></span>
            <h5 class="mb-0 me-3">قائمة الخدمات</h5>
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
            <h3>قائمة الخدمات</h3>
            <a href="create_update.php" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> إضافة خدمة جديدة
            </a>
        </div>

        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle me-2"></i> تم حذف الخدمة بنجاح.
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="60">#</th>
                    <th width="80">الصورة</th>
                    <th>العنوان (عربي)</th>
                    <th>العنوان (إنجليزي)</th>
                    <th width="100">الترتيب</th>
                    <th width="150">الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($services) > 0): ?>
                    <?php foreach ($services as $s): ?>
                        <tr>
                            <td><?= htmlspecialchars($s['id']) ?></td>
                            <td>
                                <?php if (!empty($s['img']) && file_exists('../uploads/services/' . $s['img'])): ?>
                                    <img src="../uploads/services/<?= htmlspecialchars($s['img']) ?>" class="img-thumbnail" width="60">
                                <?php else: ?>
                                    <div class="img-thumbnail bg-light d-flex justify-content-center align-items-center" style="width:60px; height:60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($s['title_ar']) ?></td>
                            <td><?= htmlspecialchars($s['title_en']) ?></td>
                            <td><?= htmlspecialchars($s['order']) ?></td>
                            <td>
                                <a href="create_update.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> تعديل</a>
                                <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $s['id'] ?>)"><i class="fas fa-trash-alt"></i> حذف</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center py-4">لا توجد خدمات مضافة</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تأكيد الحذف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">هل أنت متأكد أنك تريد حذف هذه الخدمة؟</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger">تأكيد</a>
            </div>
        </div>
    </div>
</div>
<?php require_once '../../includes/admin/footer.php';?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('sidebar-collapsed');
        document.querySelector('.main-content').classList.toggle('main-content-expanded');
    }
    function toggleUserDropdown() {
        document.querySelector('.user-dropdown-menu').classList.toggle('show');
    }
    function toggleSubmenu(btn) {
        btn.nextElementSibling.classList.toggle('active');
        btn.querySelector('.menu-arrow').classList.toggle('rotate-180');
    }

    function confirmDelete(id) {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        document.getElementById('deleteConfirmBtn').href = 'index.php?delete=' + id;
        modal.show();
    }

    // close user dropdown
    window.addEventListener('click', e => {
        if (!e.target.closest('.user-dropdown')) {
            document.querySelector('.user-dropdown-menu').classList.remove('show');
        }
    });
</script>
</body>
</html>
