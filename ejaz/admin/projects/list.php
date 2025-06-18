<?php
session_start();
require_once '../../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit;
}

// Delete project if requested
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // Get project info to delete the image file
    $stmt = $pdo->prepare("SELECT main_image FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch();

    if ($project && !empty($project['main_image']) && file_exists("../uploads/projects/" . $project['main_image'])) {
        unlink("../uploads/projects/" . $project['main_image']);
    }

    // Delete project
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php?deleted=1");
    exit;
}

// Handle filtering
$whereConditions = [];
$params = [];

if (isset($_GET['category']) && !empty($_GET['category'])) {
    $whereConditions[] = "project_category = ?";
    $params[] = $_GET['category'];
}

if (isset($_GET['status']) && !empty($_GET['status'])) {
    $whereConditions[] = "status = ?";
    $params[] = $_GET['status'];
}

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $whereConditions[] = "(project_title_ar LIKE ? OR project_title_en LIKE ? OR client LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// Build the WHERE clause
$whereClause = '';
if (!empty($whereConditions)) {
    $whereClause = "WHERE " . implode(' AND ', $whereConditions);
}

// Pagination
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Count total projects
$countQuery = "SELECT COUNT(*) FROM projects $whereClause";
$stmt = $pdo->prepare($countQuery);
$stmt->execute($params);
$totalProjects = $stmt->fetchColumn();
$totalPages = ceil($totalProjects / $perPage);

// Fetch projects with pagination
$query = "SELECT *
          FROM projects p 
          LEFT JOIN departments d ON p.department_id = d.id 
          $whereClause 
          ORDER BY p.created_at DESC 
          LIMIT $offset, $perPage";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$projects = $stmt->fetchAll();

// Get categories for filter
$categoryQuery = $pdo->query("SELECT DISTINCT project_category FROM projects");
$categories = $categoryQuery->fetchAll(PDO::FETCH_COLUMN);

// Status mapping for display
$statusLabels = [
    'planning' => 'مرحلة التخطيط',
    'design' => 'مرحلة التصميم',
    'execution' => 'قيد التنفيذ',
    'completed' => 'مكتمل'
];

$statusClasses = [
    'planning' => 'bg-primary',
    'design' => 'bg-info',
    'execution' => 'bg-warning',
    'completed' => 'bg-success'
];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المشاريع - شركة انجاز النوادي للمقاولات العامة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/admin/style.css">
</head>
<body>
<div class="sidebar">
    <div class="sidebar-header">
        <img src="../assets/img/logo-white.png" alt="شركة انجاز النوادي للمقاولات">
        <h4>لوحة التحكم</h4>
    </div>
    <ul class="sidebar-menu">
        <li>
            <a href="../index.php">
                <i class="fas fa-tachometer-alt"></i>
                الرئيسية
            </a>
        </li>
        <li>
            <button class="submenu-toggle" onclick="toggleSubmenu(this)">
                <i class="fas fa-home"></i>
                الصفحة الرئيسية
                <i class="fas fa-chevron-down menu-arrow"></i>
            </button>
            <ul class="submenu">
                <li><a href="../homepage/slider.php"><i class="fas fa-image"></i>صور السلايدر</a></li>
                <li><a href="../homepage/welcome.php"><i class="fas fa-info-circle"></i>نص الترحيب</a></li>
                <li><a href="../homepage/featured.php"><i class="fas fa-star"></i>الخدمات المميزة</a></li>
            </ul>
        </li>
        <li>
            <button class="submenu-toggle" onclick="toggleSubmenu(this)">
                <i class="fas fa-building"></i>
                أقسامنا
                <i class="fas fa-chevron-down menu-arrow"></i>
            </button>
            <ul class="submenu">
                <li><a href="../departments/index.php"><i class="fas fa-list"></i>قائمة الأقسام</a></li>
                <li><a href="../departments/add.php"><i class="fas fa-plus-circle"></i>إضافة قسم جديد</a></li>
            </ul>
        </li>
        <li>
            <button class="submenu-toggle" onclick="toggleSubmenu(this)">
                <i class="fas fa-tasks"></i>
                خدماتنا
                <i class="fas fa-chevron-down menu-arrow"></i>
            </button>
            <ul class="submenu">
                <li><a href="../services/index.php"><i class="fas fa-list"></i>قائمة الخدمات</a></li>
                <li><a href="../services/add.php"><i class="fas fa-plus-circle"></i>إضافة خدمة جديدة</a></li>
            </ul>
        </li>
        <li>
            <button class="submenu-toggle" onclick="toggleSubmenu(this)">
                <i class="fas fa-project-diagram"></i>
                المشاريع
                <i class="fas fa-chevron-down menu-arrow"></i>
            </button>
            <ul class="submenu active">
                <li><a href="list.php" class="active"><i class="fas fa-list"></i>قائمة المشاريع</a></li>
                <li><a href="add.php"><i class="fas fa-plus-circle"></i>إضافة مشروع جديد</a></li>
            </ul>
        </li>
        <li>
            <button class="submenu-toggle" onclick="toggleSubmenu(this)">
                <i class="fas fa-edit"></i>
                المدونة
                <i class="fas fa-chevron-down menu-arrow"></i>
            </button>
            <ul class="submenu">
                <li><a href="../blogs/list.php"><i class="fas fa-list"></i>قائمة المقالات</a></li>
                <li><a href="../blogs/add.php"><i class="fas fa-plus-circle"></i>إضافة مقال جديد</a></li>
            </ul>
        </li>
        <li>
            <a href="../messages/index.php">
                <i class="fas fa-envelope"></i>
                رسائل التواصل
            </a>
        </li>
        <li>
            <a href="../users/index.php">
                <i class="fas fa-users"></i>
                المستخدمين
            </a>
        </li>
        <li>
            <a href="../settings/general.php">
                <i class="fas fa-cog"></i>
                الإعدادات
            </a>
        </li>
        <li>
            <a href="../logout.php">
                <i class="fas fa-sign-out-alt"></i>
                تسجيل الخروج
            </a>
        </li>
    </ul>
</div>

<div class="main-content">
    <div class="top-navbar">
        <div class="d-flex align-items-center">
                <span class="menu-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </span>
            <h5 class="mb-0 me-3">قائمة المشاريع</h5>
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

    <!-- Page Content -->
    <div class="content-box">
        <div class="content-box-header">
            <h3>قائمة المشاريع</h3>
            <a href="add.php" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> إضافة مشروع جديد
            </a>
        </div>

        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle me-2"></i> تم حذف المشروع بنجاح.
            </div>
        <?php endif; ?>

        <div class="filter-section mb-4">
            <form class="filter-form" method="GET" action="">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <input type="text" class="form-control" name="search" placeholder="بحث..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <select class="form-select" name="category">
                            <option value="">كل التصنيفات</option>
                            <?php foreach($categories as $category): ?>
                                <option value="<?= $category ?>" <?= (isset($_GET['category']) && $_GET['category'] == $category) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <select class="form-select" name="status">
                            <option value="">كل الحالات</option>
                            <?php foreach($statusLabels as $key => $label): ?>
                                <option value="<?= $key ?>" <?= (isset($_GET['status']) && $_GET['status'] == $key) ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> تصفية
                        </button>
                        <a href="list.php" class="btn btn-secondary ms-2">
                            <i class="fas fa-redo"></i> إعادة ضبط
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="70">#</th>
                    <th width="80">الصورة</th>
                    <th>عنوان المشروع</th>
                    <th>التصنيف</th>
                    <th>القسم</th>
                    <th>الحالة</th>
                    <th>تاريخ الإنشاء</th>
                    <th width="150">الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($projects) > 0): ?>
                    <?php foreach($projects as $project): ?>
                        <tr>
                            <td><?= htmlspecialchars($project['id']) ?></td>
                            <td>
                                <?php if(!empty($project['main_image']) && file_exists("../uploads/projects/" . $project['main_image'])): ?>
                                    <img src="../uploads/projects/<?= htmlspecialchars($project['main_image']) ?>" class="project-thumbnail" style="width: 80px">
                                <?php else: ?>
                                    <div class="project-thumbnail bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($project['project_title_ar']) ?></td>
                            <td><?= htmlspecialchars($project['project_category']) ?></td>
                            <td><?= htmlspecialchars($project['department_name'] ?? 'غير محدد') ?></td>
                            <td>
                                <?php
                                $status = $project['status'];
                                $statusClass = $statusClasses[$status] ?? 'bg-secondary';
                                $statusLabel = $statusLabels[$status] ?? $status;
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= $statusLabel ?></span>
                            </td>
                            <td><?= date('Y/m/d', strtotime($project['created_at'])) ?></td>
                            <td>
                                <a href="add.php?id=<?= $project['id'] ?>" class="table-action-btn btn-edit" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="table-action-btn btn-delete" title="حذف" onclick="confirmDelete(<?= $project['id'] ?>)">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-4">لا توجد مشاريع متاحة</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page - 1 ?><?= isset($_GET['category']) ? '&category=' . htmlspecialchars($_GET['category']) : '' ?><?= isset($_GET['status']) ? '&status=' . htmlspecialchars($_GET['status']) : '' ?><?= isset($_GET['search']) ? '&search=' . htmlspecialchars($_GET['search']) : '' ?>">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?><?= isset($_GET['category']) ? '&category=' . htmlspecialchars($_GET['category']) : '' ?><?= isset($_GET['status']) ? '&status=' . htmlspecialchars($_GET['status']) : '' ?><?= isset($_GET['search']) ? '&search=' . htmlspecialchars($_GET['search']) : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page + 1 ?><?= isset($_GET['category']) ? '&category=' . htmlspecialchars($_GET['category']) : '' ?><?= isset($_GET['status']) ? '&status=' . htmlspecialchars($_GET['status']) : '' ?><?= isset($_GET['search']) ? '&search=' . htmlspecialchars($_GET['search']) : '' ?>">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
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
                هل أنت متأكد من رغبتك في حذف هذا المشروع؟ هذا الإجراء لا يمكن التراجع عنه.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">تأكيد الحذف</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle sidebar
    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('sidebar-collapsed');
        document.querySelector('.main-content').classList.toggle('main-content-expanded');
    }

    // Toggle user dropdown
    function toggleUserDropdown() {
        document.querySelector('.user-dropdown-menu').classList.toggle('show');
    }

    // Toggle submenu
    function toggleSubmenu(button) {
        const submenu = button.nextElementSibling;
        submenu.classList.toggle('active');
        button.querySelector('.menu-arrow').classList.toggle('rotate-180');
    }

    // Close dropdown when clicking outside
    window.addEventListener('click', function(e) {
        if (!e.target.closest('.user-dropdown')) {
            const dropdown = document.querySelector('.user-dropdown-menu');
            if (dropdown && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        }
    });

    // Delete confirmation
    function confirmDelete(id) {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        document.getElementById('confirmDeleteBtn').href = 'index.php?delete=' + id;
        modal.show();
    }
</script>
</body>
</html>