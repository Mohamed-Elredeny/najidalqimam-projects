<?php
session_start();
require_once '../../config/db.php';
// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];

// Get project data
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    header('Location: index.php');
    exit;
}

// Get departments for dropdown
$departmentsQuery = $pdo->query("SELECT id, name FROM departments ORDER BY name");
$departments = $departmentsQuery->fetchAll();

// Process form submission
$errors = [];
$success = false;



// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    $requiredFields = [
        'project_title_ar' => 'عنوان المشروع (عربي)',
        'project_title_en' => 'عنوان المشروع (إنجليزي)',
        'project_category' => 'تصنيف المشروع',
        'location_ar' => 'الموقع (عربي)',
        'location_en' => 'الموقع (إنجليزي)',
        'start_date' => 'تاريخ البدء',
        'status' => 'حالة المشروع'
    ];

    foreach ($requiredFields as $field => $label) {
        if (empty($_POST[$field])) {
            $errors[] = "حقل $label مطلوب";
        }
    }

    // If no validation errors, proceed with update
    if (empty($errors)) {
        try {
            // Handle file upload
            $mainImage = $project['main_image']; // Keep existing image by default

            if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../uploads/projects/';

                // Create directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileExtension = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid('project_') . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fileName;

                // Check file type
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array(strtolower($fileExtension), $allowedTypes)) {
                    $errors[] = "نوع الملف غير مسموح به. الأنواع المسموحة هي: " . implode(', ', $allowedTypes);
                } else {
                    // Move uploaded file
                    if (move_uploaded_file($_FILES['main_image']['tmp_name'], $uploadFile)) {
                        // Delete old image if it exists
                        if (!empty($project['main_image']) && file_exists($uploadDir . $project['main_image'])) {
                            unlink($uploadDir . $project['main_image']);
                        }
                        $mainImage = $fileName;
                    } else {
                        $errors[] = "فشل في تحميل الصورة";
                    }
                }
            }

            if (empty($errors)) {
                // Prepare SQL query
                $sql = "UPDATE projects SET 
                            project_title_ar = :project_title_ar,
                            project_title_en = :project_title_en,
                            project_category = :project_category,
                            department_id = :department_id,
                            location_ar = :location_ar,
                            location_en = :location_en,project_category = :project_category,
department_id = :department_id,
location_ar = :location_ar,
location_en = :location_en,
client = :client,
area = :area,
start_date = :start_date,
end_date = :end_date,
status = :status,
is_featured = :is_featured,
main_image = :main_image,
summary_ar = :summary_ar,
summary_en = :summary_en,
description_ar = :description_ar,
description_en = :description_en,
video_url = :video_url,
meta_title_ar = :meta_title_ar,
meta_title_en = :meta_title_en,
meta_description_ar = :meta_description_ar,
meta_description_en = :meta_description_en,
meta_keywords = :meta_keywords,
publish_status = :publish_status,
schedule_date = :schedule_date
WHERE id = :id";

                $stmt = $pdo->prepare($sql);

// Bind parameters
                $params = [
                    ':project_title_ar' => $_POST['project_title_ar'],
                    ':project_title_en' => $_POST['project_title_en'],
                    ':project_category' => $_POST['project_category'],
                    ':department_id' => !empty($_POST['department_id']) ? $_POST['department_id'] : null,
                    ':location_ar' => $_POST['location_ar'],
                    ':location_en' => $_POST['location_en'],
                    ':client' => $_POST['client'] ?? null,
                    ':area' => !empty($_POST['area']) ? $_POST['area'] : null,
                    ':start_date' => $_POST['start_date'],
                    ':end_date' => !empty($_POST['end_date']) ? $_POST['end_date'] : null,
                    ':status' => $_POST['status'],
                    ':is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                    ':main_image' => $mainImage,
                    ':summary_ar' => $_POST['summary_ar'] ?? null,
                    ':summary_en' => $_POST['summary_en'] ?? null,
                    ':description_ar' => $_POST['description_ar'] ?? null,
                    ':description_en' => $_POST['description_en'] ?? null,
                    ':video_url' => $_POST['video_url'] ?? null,
                    ':meta_title_ar' => $_POST['meta_title_ar'] ?? null,
                    ':meta_title_en' => $_POST['meta_title_en'] ?? null,
                    ':meta_description_ar' => $_POST['meta_description_ar'] ?? null,
                    ':meta_description_en' => $_POST['meta_description_en'] ?? null,
                    ':meta_keywords' => $_POST['meta_keywords'] ?? null,
                    ':publish_status' => $_POST['publish_status'] ?? 'draft',
                    ':schedule_date' => ($_POST['publish_status'] === 'scheduled' && !empty($_POST['schedule_date'])) ? $_POST['schedule_date'] : null,
                    ':id' => $id
                ];

                $stmt->execute($params);

// Success message
                $success = true;

// Reload project data
                $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
                $stmt->execute([$id]);
                $project = $stmt->fetch();
            }
        } catch (PDOException $e) {
            $errors[] = "خطأ في قاعدة البيانات: " . $e->getMessage();
        }
    }
}

// Status options mapping
$statusOptions = [
    'planning' => 'مرحلة التخطيط',
    'design' => 'مرحلة التصميم',
    'execution' => 'قيد التنفيذ',
    'completed' => 'مكتمل'
];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل مشروع - شركة انجاز النوادي للمقاولات العامة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap');

        :root {
            --primary-color: #f39c12;
            --secondary-color: #3498db;
            --dark-color: #333;
            --light-color: #f4f4f4;
            --sidebar-width: 280px;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #17a2b8;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            right: 0;
            top: 0;
            background-color: var(--dark-color);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: -3px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar-collapsed {
            right: calc(var(--sidebar-width) * -1 + 50px);
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header img {
            height: 60px;
            margin-bottom: 10px;
        }

        .sidebar-header h4 {
            margin-bottom: 0;
            font-weight: 700;
            color: var(--primary-color);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu a, .sidebar-menu button {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            background: transparent;
            border: none;
            width: 100%;
            text-align: right;
        }

        .sidebar-menu a:hover, .sidebar-menu button:hover, .sidebar-menu a.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar-menu i {
            font-size: 1.2rem;
            margin-left: 10px;
            min-width: 25px;
            text-align: center;
        }

        .submenu {
            list-style: none;
            padding: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background-color: rgba(0, 0, 0, 0.2);
        }

        .submenu.active {
            max-height: 500px;
        }

        .submenu a {
            padding: 10px 20px 10px 40px;
            font-size: 0.9rem;
        }

        .menu-arrow {
            margin-right: auto;
            transition: transform 0.3s ease;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        /* Main content */
        .main-content {
            margin-right: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s ease;
        }

        .main-content-expanded {
            margin-right: 50px;
        }

        /* Navbar */
        .top-navbar {
            background-color: white;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .menu-toggle {
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--dark-color);
            margin-left: 15px;
        }

        .user-dropdown {
            position: relative;
        }

        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-left: 10px;
            object-fit: cover;
        }

        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            width: 200px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            margin-top: 10px;
            z-index: 1000;
            display: none;
        }

        .user-dropdown-menu.show {
            display: block;
        }

        .user-dropdown-menu a {
            display: block;
            padding: 10px 20px;
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .user-dropdown-menu a:hover {
            background-color: #f8f9fa;
        }

        .user-dropdown-menu i {
            margin-left: 10px;
            color: var(--primary-color);
        }

        /* Content boxes */
        .content-box {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .content-box-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .content-box-header h3 {
            font-weight: 700;
            margin-bottom: 0;
            color: var(--dark-color);
        }

        /* Form styling */
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(243, 156, 18, 0.25);
        }

        /* File Upload */
        .file-upload-container {
            border: 2px dashed #ddd;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            margin-bottom: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-container:hover {
            border-color: var(--primary-color);
        }

        .file-upload-container i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .file-upload-container h5 {
            margin-bottom: 10px;
            font-weight: 600;
        }

        .file-upload-container p {
            color: #6c757d;
            margin-bottom: 0;
        }

        .file-upload-container input {
            display: none;
        }

        /* Preview thumbnails */
        .image-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .preview-item {
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-preview {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: var(--danger);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .remove-preview i {
            font-size: 10px;
        }

        /* Tabs */
        .nav-tabs .nav-link {
            color: #6c757d;
            font-weight: 600;
            border: none;
            border-bottom: 2px solid transparent;
            padding: 10px 20px;
            margin-bottom: -1px;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
        }

        .tab-content {
            padding: 20px 0;
        }

        /* Media Queries */
        @media (max-width: 992px) {
            .sidebar {
                right: calc(var(--sidebar-width) * -1);
            }

            .sidebar-collapsed {
                right: 0;
            }

            .main-content {
                margin-right: 0;
            }

            .main-content-expanded {
                margin-right: 0;
            }
        }
    </style>
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
                <li><a href="list.php"><i class="fas fa-list"></i>قائمة المشاريع</a></li>
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
            <h5 class="mb-0 me-3">تعديل مشروع</h5>
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
            <h3>تعديل مشروع</h3>
            <a href="list.php" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-right me-1"></i>
                العودة إلى قائمة المشاريع
            </a>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle me-2"></i> تم تحديث المشروع بنجاح.
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <ul class="nav nav-tabs" id="projectTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">البيانات الأساسية</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false">التفاصيل</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab" aria-controls="seo" aria-selected="false">إعدادات SEO</button>
            </li>
        </ul>

        <form id="projectForm" method="POST" enctype="multipart/form-data">
            <div class="tab-content" id="projectTabsContent">
                <!-- البيانات الأساسية -->
                <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                    <div class="row mb-4 mt-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="is_featured" class="form-label d-block">عرض في الصفحة الرئيسية</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" <?= $project['is_featured'] ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="is_featured">عرض المشروع في الصفحة الرئيسية</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">الصورة الرئيسية<span class="text-danger">*</span></label>
                        <?php if (!empty($project['main_image']) && file_exists("../uploads/projects/" . $project['main_image'])): ?>
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <img src="../uploads/projects/<?= htmlspecialchars($project['main_image']) ?>" alt="صورة المشروع" class="rounded" style="height: 120px; object-fit: cover;">
                                    <div class="ms-3">
                                        <p class="mb-1">الصورة الحالية</p>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeCurrentImage()">
                                            <i class="fas fa-trash-alt me-1"></i> حذف الصورة
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="file-upload-container" onclick="document.getElementById('main_image').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <h5><?= !empty($project['main_image']) ? 'تغيير الصورة' : 'اسحب الصورة هنا أو انقر للتحميل' ?></h5>
                            <p>الحد الأقصى لحجم الملف: 5 ميجابايت، الأبعاد الموصى بها: 1200 × 800 بكسل</p>
                            <input type="file" id="main_image" name="main_image" accept="image/*" onchange="previewMainImage(this)">
                            <input type="hidden" id="remove_image" name="remove_image" value="0">
                        </div>
                        <div class="image-preview" id="mainImagePreview"></div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary px-4" onclick="nextTab('details-tab')">التالي</button>
                    </div>
                </div>

                <!-- التفاصيل -->
                <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                    <div class="row mb-4 mt-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="summary_ar" class="form-label">ملخص المشروع (عربي)</label>
                                <textarea class="form-control" id="summary_ar" name="summary_ar" rows="3"><?= htmlspecialchars($project['summary_ar'] ?? '') ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="summary_en" class="form-label">ملخص المشروع (إنجليزي)</label>
                                <textarea class="form-control" id="summary_en" name="summary_en" rows="3"><?= htmlspecialchars($project['summary_en'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description_ar" class="form-label">وصف المشروع (عربي)</label>
                        <textarea class="form-control" id="description_ar" name="description_ar" rows="5"><?= htmlspecialchars($project['description_ar'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="description_en" class="form-label">وصف المشروع (إنجليزي)</label>
                        <textarea class="form-control" id="description_en" name="description_en" rows="5"><?= htmlspecialchars($project['description_en'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="video_url" class="form-label">رابط فيديو (اختياري)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                            <input type="url" class="form-control" id="video_url" name="video_url" placeholder="مثال: https://www.youtube.com/watch?v=..." value="<?= htmlspecialchars($project['video_url'] ?? '') ?>">
                        </div>
                        <small class="text-muted">أدخل رابط فيديو يوتيوب أو فيميو</small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary px-4" onclick="prevTab('basic-tab')">السابق</button>
                        <button type="button" class="btn btn-primary px-4" onclick="nextTab('seo-tab')">التالي</button>
                    </div>
                </div>

                <!-- إعدادات SEO -->
                <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                    <div class="row mb-4 mt-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="meta_title_ar" class="form-label">عنوان ميتا (عربي)</label>
                                <input type="text" class="form-control" id="meta_title_ar" name="meta_title_ar" value="<?= htmlspecialchars($project['meta_title_ar'] ?? '') ?>">
                                <small class="text-muted">يُفضل ألا يتجاوز 60 حرفًا</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="meta_title_en" class="form-label">عنوان ميتا (إنجليزي)</label>
                                <input type="text" class="form-control" id="meta_title_en" name="meta_title_en" value="<?= htmlspecialchars($project['meta_title_en'] ?? '') ?>">
                                <small class="text-muted">يُفضل ألا يتجاوز 60 حرفًا</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="meta_description_ar" class="form-label">وصف ميتا (عربي)</label>
                                <textarea class="form-control" id="meta_description_ar" name="meta_description_ar" rows="3"><?= htmlspecialchars($project['meta_description_ar'] ?? '') ?></textarea>
                                <small class="text-muted">يُفضل ألا يتجاوز 160 حرفًا</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="meta_description_en" class="form-label">وصف ميتا (إنجليزي)</label>
                                <textarea class="form-control" id="meta_description_en" name="meta_description_en" rows="3"><?= htmlspecialchars($project['meta_description_en'] ?? '') ?></textarea>
                                <small class="text-muted">يُفضل ألا يتجاوز 160 حرفًا</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="meta_keywords" class="form-label">الكلمات المفتاحية</label>
                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="<?= htmlspecialchars($project['meta_keywords'] ?? '') ?>">
                        <small class="text-muted">افصل بين الكلمات المفتاحية بفواصل</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">خيارات النشر</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="publish_status" id="publish_now" value="published" <?= $project['publish_status'] === 'published' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="publish_now">نشر الآن</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="publish_status" id="save_draft" value="draft" <?= $project['publish_status'] === 'draft' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="save_draft">حفظ كمسودة</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="publish_status" id="schedule" value="scheduled" <?= $project['publish_status'] === 'scheduled' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="schedule">جدولة النشر</label>
                        </div>
                        <div class="schedule-date-container mt-3" id="scheduleDateContainer" style="display: <?= $project['publish_status'] === 'scheduled' ? 'block' : 'none' ?>;">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="schedule_date" class="form-label">تاريخ النشر</label>
                                    <input type="datetime-local" class="form-control" id="schedule_date" name="schedule_date" value="<?= !empty($project['schedule_date']) ? date('Y-m-d\TH:i', strtotime($project['schedule_date'])) : '' ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary px-4" onclick="prevTab('details-tab')">السابق</button>
                        <button type="submit" class="btn btn-success px-4">حفظ التغييرات</button>
                    </div>
                </div>
            </div>
        </form>
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

    // Navigation between tabs
    function nextTab(tabId) {
        const tab = document.getElementById(tabId);
        const bsTab = new bootstrap.Tab(tab);
        bsTab.show();
    }

    function prevTab(tabId) {
        const tab = document.getElementById(tabId);
        const bsTab = new bootstrap.Tab(tab);
        bsTab.show();
    }

    // Preview main image
    function previewMainImage(input) {
        const preview = document.getElementById('mainImagePreview');
        preview.innerHTML = '';

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                previewItem.innerHTML = `
                        <img src="${e.target.result}" alt="صورة المشروع">
                        <div class="remove-preview" onclick="removeMainImage()">
                            <i class="fas fa-times"></i>
                        </div>
                    `;
                preview.appendChild(previewItem);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Remove main image
    function removeMainImage() {
        document.getElementById('main_image').value = '';
        document.getElementById('mainImagePreview').innerHTML = '';
    }

    // Remove current image
    function removeCurrentImage() {
        document.getElementById('remove_image').value = '1';
        const currentImageContainer = document.querySelector('.d-flex.align-items-center');
        if (currentImageContainer) {
            currentImageContainer.parentElement.style.display = 'none';
        }
    }

    // Toggle schedule date field
    document.addEventListener('DOMContentLoaded', function() {
        const scheduleRadio = document.getElementById('schedule');
        const scheduleDateContainer = document.getElementById('scheduleDateContainer');

        // Add event listeners to all publish status radio buttons
        document.querySelectorAll('input[name="publish_status"]').forEach(radio => {
            radio.addEventListener('change', function() {
                scheduleDateContainer.style.display = scheduleRadio.checked ? 'block' : 'none';
            });
        });
    });
</script>
</body>
</html>
<label for="project_title_ar" class="form-label">عنوان المشروع (عربي)<span class="text-danger">*</span></label>
<input type="text" class="form-control" id="project_title_ar" name="project_title_ar" value="<?= htmlspecialchars($project['project_title_ar']) ?>" required>
</div>
</div>
<div class="col-md-6">
    <div class="mb-3">
        <label for="project_title_en" class="form-label">عنوان المشروع (إنجليزي)<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="project_title_en" name="project_title_en" value="<?= htmlspecialchars($project['project_title_en']) ?>" required>
    </div>
</div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="project_category" class="form-label">تصنيف المشروع<span class="text-danger">*</span></label>
            <select class="form-select" id="project_category" name="project_category" required>
                <option value="" selected disabled>اختر التصنيف</option>
                <option value="residential" <?= $project['project_category'] === 'residential' ? 'selected' : '' ?>>سكني</option>
                <option value="commercial" <?= $project['project_category'] === 'commercial' ? 'selected' : '' ?>>تجاري</option>
                <option value="government" <?= $project['project_category'] === 'government' ? 'selected' : '' ?>>حكومي</option>
                <option value="infrastructure" <?= $project['project_category'] === 'infrastructure' ? 'selected' : '' ?>>بنية تحتية</option>
                <option value="development" <?= $project['project_category'] === 'development' ? 'selected' : '' ?>>تطوير عقاري</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="department_id" class="form-label">القسم</label>
            <select class="form-select" id="department_id" name="department_id">
                <option value="">اختر القسم</option>
                <?php foreach ($departments as $department): ?>
                    <option value="<?= $department['id'] ?>" <?= $project['department_id'] == $department['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($department['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="location_ar" class="form-label">الموقع (عربي)<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="location_ar" name="location_ar" value="<?= htmlspecialchars($project['location_ar']) ?>" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="location_en" class="form-label">الموقع (إنجليزي)<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="location_en" name="location_en" value="<?= htmlspecialchars($project['location_en']) ?>" required>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="client" class="form-label">العميل</label>
            <input type="text" class="form-control" id="client" name="client" value="<?= htmlspecialchars($project['client'] ?? '') ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="area" class="form-label">المساحة (متر مربع)</label>
            <input type="number" step="0.01" class="form-control" id="area" name="area" value="<?= htmlspecialchars($project['area'] ?? '') ?>">
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="start_date" class="form-label">تاريخ البدء<span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= htmlspecialchars($project['start_date']) ?>" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="end_date" class="form-label">تاريخ الانتهاء</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="<?= htmlspecialchars($project['end_date'] ?? '') ?>">
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="status" class="form-label">حالة المشروع<span class="text-danger">*</span></label>
            <select class="form-select" id="status" name="status" required>
                <option value="" selected disabled>اختر الحالة</option>
                <?php foreach ($statusOptions as $value => $label): ?>
                    <option value="<?= $value ?>" <?= $project['status'] === $value ? 'selected' : '' ?>>
                        <?= $label ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3"><?php

?>