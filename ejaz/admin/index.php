<?php
// dashboard.php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Fetch stats
$stats = [];

// Total completed projects
$stmt = $pdo->prepare("SELECT COUNT(*) FROM projects WHERE status = 'completed'");
$stmt->execute();
$stats['completed_projects'] = $stmt->fetchColumn();

// Projects in progress (not completed)
$stmt = $pdo->prepare("SELECT COUNT(*) FROM projects WHERE status <> 'completed'");
$stmt->execute();
$stats['in_progress_projects'] = $stmt->fetchColumn();

// Departments count
$stmt = $pdo->query("SELECT COUNT(*) FROM departments");
$stats['departments'] = $stmt->fetchColumn();

// New messages count (all unread? here we count all)
$stmt = $pdo->query("SELECT COUNT(*) FROM contact_messages");
$stats['new_messages'] = $stmt->fetchColumn();

// Satisfied clients from counters table
$stmt = $pdo->prepare("SELECT value FROM counters WHERE label_en = 'Satisfied Clients' LIMIT 1");
$stmt->execute();
$stats['satisfied_clients'] = $stmt->fetchColumn() ?? 0;

// Visits this month — if you have an analytics table, replace this. Otherwise placeholder:
$stats['visits_month'] = 0;

// Recent 5 projects
$stmt = $pdo->query("SELECT project_title_ar, project_category, status, created_at, id
                     FROM projects
                     ORDER BY created_at DESC
                     LIMIT 5");
$recentProjects = $stmt->fetchAll();

// Recent 5 messages
$stmt = $pdo->query("SELECT name, email, message, created_at
                     FROM contact_messages
                     ORDER BY created_at DESC
                     LIMIT 5");
$recentMessages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم - شركة إنجاز النوادي</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/admin/style.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/admin/sidebar.php'; ?>

<div class="main-content p-4">
    <div class="top-navbar mb-4">
        <div class="d-flex align-items-center">
            <span class="menu-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></span>
            <h5 class="mb-0 me-3">لوحة التحكم</h5>
        </div>
        <div class="user-dropdown">
            <div class="user-dropdown-toggle" onclick="toggleUserDropdown()">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="user-avatar" alt="">
                <span><?= htmlspecialchars($_SESSION['admin_name'] ?? 'المدير') ?></span>
            </div>
            <div class="user-dropdown-menu">
                <a href="#"><i class="fas fa-user"></i> الملف الشخصي</a>
                <a href="#"><i class="fas fa-cog"></i> الإعدادات</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</a>
            </div>
        </div>
    </div>

    <!-- Welcome -->
    <div class="content-box mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">مرحباً، <?= htmlspecialchars($_SESSION['admin_name'] ?? ''); ?></h4>
                <p class="text-muted mb-0">إدارة ومتابعة نشاط الموقع</p>
            </div>
            <div class="text-end">
                <p class="mb-1">اليوم: <?= date('l، d F Y', time()); ?></p>
                <p class="mb-0">آخر تسجيل دخول: <?= date('H:i', $_SESSION['last_login'] ?? time()); ?></p>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-lg-2">
            <div class="content-box text-center">
                <i class="fas fa-project-diagram fa-2x text-primary mb-2"></i>
                <h3><?= $stats['completed_projects'] ?></h3>
                <p>مشاريع مكتملة</p>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="content-box text-center">
                <i class="fas fa-building fa-2x text-success mb-2"></i>
                <h3><?= $stats['in_progress_projects'] ?></h3>
                <p>مشاريع قيد التنفيذ</p>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="content-box text-center">
                <i class="fas fa-tasks fa-2x text-info mb-2"></i>
                <h3><?= $stats['departments'] ?></h3>
                <p>أقسام</p>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="content-box text-center">
                <i class="fas fa-envelope fa-2x text-warning mb-2"></i>
                <h3><?= $stats['new_messages'] ?></h3>
                <p>رسائل</p>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="content-box text-center">
                <i class="fas fa-user-tie fa-2x text-danger mb-2"></i>
                <h3><?= $stats['satisfied_clients'] ?></h3>
                <p>عملاء راضون</p>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="content-box text-center">
                <i class="fas fa-eye fa-2x text-primary mb-2"></i>
                <h3><?= $stats['visits_month'] ?></h3>
                <p>زيارات الشهر</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="content-box mb-4">
        <div class="d-flex justify-content-between mb-3">
            <h3>الإجراءات السريعة</h3>
        </div>
        <div class="row g-3">
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="quick-action-card" onclick="location.href='projects/add.php'">
                    <i class="fas fa-plus fa-2x"></i>
                    <p>إضافة مشروع</p>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="quick-action-card" onclick="location.href='services/add.php'">
                    <i class="fas fa-cogs fa-2x"></i>
                    <p>إضافة خدمة</p>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="quick-action-card" onclick="location.href='contact_messages/list.php'">
                    <i class="fas fa-inbox fa-2x"></i>
                    <p>إدارة الرسائل</p>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="quick-action-card" onclick="location.href='homepage/edit.php'">
                    <i class="fas fa-home fa-2x"></i>
                    <p>تحرير الصفحة الرئيسية</p>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="quick-action-card" onclick="location.href='admin_users/index.php'">
                    <i class="fas fa-users fa-2x"></i>
                    <p>المستخدمون</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Projects -->
        <div class="col-lg-7">
            <div class="content-box">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>أحدث المشاريع</h3>
                    <a href="projects/list.php" class="btn btn-sm btn-primary">عرض الكل</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>المشروع</th>
                            <th>التصنيف</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                            <th>...</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($recentProjects as $pr): ?>
                            <tr>
                                <td><?= htmlspecialchars($pr['project_title_ar']) ?></td>
                                <td><?= htmlspecialchars($pr['project_category']) ?></td>
                                <td>
                    <span class="badge
                      <?= $pr['status']==='completed'?'bg-success':
                        ($pr['status']==='design'?'bg-info':
                            ($pr['status']==='execution'?'bg-warning':'bg-secondary')) ?>">
                      <?= htmlspecialchars($pr['status']) ?>
                    </span>
                                </td>
                                <td><?= date('Y/m/d', strtotime($pr['created_at'])) ?></td>
                                <td>
                                    <a href="projects/view.php?id=<?= $pr['id'] ?>" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="projects/add.php?id=<?= $pr['id'] ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Messages -->
        <div class="col-lg-5">
            <div class="content-box">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>أحدث الرسائل</h3>
                    <a href="contact_messages/list.php" class="btn btn-sm btn-primary">عرض الكل</a>
                </div>
                <div class="list-group">
                    <?php foreach($recentMessages as $msg): ?>
                        <a href="contact_messages/view.php?id=<?= $msg['id'] ?>" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between">
                                <h6><?= htmlspecialchars($msg['name']) ?></h6>
                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($msg['created_at'])) ?></small>
                            </div>
                            <p class="mb-1 text-truncate"><?= htmlspecialchars($msg['message']) ?></p>
                            <small class="text-muted"><?= htmlspecialchars($msg['email']) ?></small>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('sidebar-collapsed');
        document.querySelector('.main-content').classList.toggle('main-content-expanded');
    }
    function toggleUserDropdown() {
        document.querySelector('.user-dropdown-menu').classList.toggle('show');
    }
</script>
<?php include '../includes/admin/footer.php'; ?>
</body>
</html>
