<?php
session_start();
require_once '../../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit;
}

// Check if we're updating an existing project
$isUpdate = false;
$project = null;
$pageTitle = "إضافة مشروع جديد";
$submitButtonText = "حفظ المشروع";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $isUpdate = true;
    $pageTitle = "تعديل المشروع";
    $submitButtonText = "تحديث المشروع";

    // Fetch project data
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$project) {
        // Project not found, redirect to list
        header('Location: index.php');
        exit;
    }
}

// Get departments for dropdown
$departmentsQuery = $pdo->query("SELECT * FROM departments");
$departments = $departmentsQuery->fetchAll();

// Process form submission
$errors = [];
$success = false;

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

    // Check if we need to validate the image
    $requireImage = !$isUpdate || (isset($_FILES['main_image']) && $_FILES['main_image']['size'] > 0);

    // If update and no new image uploaded, we don't need to validate the image
    if (!$isUpdate && !isset($_FILES['main_image']) || (isset($_FILES['main_image']) && $_FILES['main_image']['error'] !== UPLOAD_ERR_OK && $_FILES['main_image']['error'] !== UPLOAD_ERR_NO_FILE)) {
        $errors[] = "الصورة الرئيسية مطلوبة";
    }

    // If scheduled, validate schedule date
    if (isset($_POST['publish_status']) && $_POST['publish_status'] === 'scheduled' && empty($_POST['schedule_date'])) {
        $errors[] = "تاريخ النشر مطلوب عند اختيار جدولة النشر";
    }

    // If no validation errors, proceed with insertion or update
    if (empty($errors)) {
        try {
            // Handle file upload
            $mainImage = $isUpdate ? $project['main_image'] : '';

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
                        // If updating, delete old image if it exists
                        if ($isUpdate && !empty($project['main_image'])) {
                            $oldImagePath = $uploadDir . $project['main_image'];
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                        }
                        $mainImage = $fileName;
                    } else {
                        $errors[] = "فشل في تحميل الصورة";
                    }
                }
            }

            if (empty($errors)) {
                if ($isUpdate) {
                    // Update existing project
                    $sql = "UPDATE projects SET 
                            project_title_ar = :project_title_ar, 
                            project_title_en = :project_title_en, 
                            project_category = :project_category, 
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
                } else {
                    // Insert new project
                    $sql = "INSERT INTO projects (
                            project_title_ar, project_title_en, project_category, department_id,
                            location_ar, location_en, client, area, start_date, end_date,
                            status, is_featured, main_image, summary_ar, summary_en,
                            description_ar, description_en, video_url, meta_title_ar,
                            meta_title_en, meta_description_ar, meta_description_en,
                            meta_keywords, publish_status, schedule_date, created_at
                        ) VALUES (
                            :project_title_ar, :project_title_en, :project_category, :department_id,
                            :location_ar, :location_en, :client, :area, :start_date, :end_date,
                            :status, :is_featured, :main_image, :summary_ar, :summary_en,
                            :description_ar, :description_en, :video_url, :meta_title_ar,
                            :meta_title_en, :meta_description_ar, :meta_description_en,
                            :meta_keywords, :publish_status, :schedule_date, NOW()
                        )";
                }

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
                    ':schedule_date' => ($_POST['publish_status'] === 'scheduled' && !empty($_POST['schedule_date'])) ? $_POST['schedule_date'] : null
                ];

                // Add id parameter for update
                if ($isUpdate) {
                    $params[':id'] = $_GET['id'];
                }

                $stmt->execute($params);

                // Success message
                $success = true;

                // Redirect to list page after a short delay (for update)
                if ($isUpdate) {
                    header("refresh:2;url=index.php");
                }
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

// Helper function to get form value
function getValue($field, $default = '') {
    global $project, $isUpdate;

    if (isset($_POST[$field])) {
        return htmlspecialchars($_POST[$field]);
    } else if ($isUpdate && isset($project[$field])) {
        return htmlspecialchars($project[$field]);
    }

    return $default;
}

// Helper function to check if an option is selected
function isSelected($field, $value) {
    global $project, $isUpdate;

    if (isset($_POST[$field])) {
        return $_POST[$field] === $value ? 'selected' : '';
    } else if ($isUpdate && isset($project[$field])) {
        return $project[$field] === $value ? 'selected' : '';
    }

    return '';
}

// Helper function to check if a checkbox is checked
function isChecked($field) {
    global $project, $isUpdate;

    if (isset($_POST[$field])) {
        return 'checked';
    } else if ($isUpdate && isset($project[$field]) && $project[$field] == 1) {
        return 'checked';
    }

    return '';
}

// Helper function to check if a radio is checked
function isRadioChecked($field, $value, $default = '') {
    global $project, $isUpdate;

    if (isset($_POST[$field])) {
        return $_POST[$field] === $value ? 'checked' : '';
    } else if ($isUpdate && isset($project[$field])) {
        return $project[$field] === $value ? 'checked' : '';
    }

    return $value === $default ? 'checked' : '';
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - شركة انجاز النوادي للمقاولات العامة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/admin/style.css">
    <style>
        /* Additional styles for validation */
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            display: block;
        }

        /* Image preview styles */
        .image-preview .preview-item {
            position: relative;
            display: inline-block;
            margin: 10px 0;
        }

        .image-preview .preview-item img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .image-preview .remove-preview {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #f44336;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            text-align: center;
            line-height: 24px;
            cursor: pointer;
        }

        /* Style for required fields */
        .required-field::after {
            content: "*";
            color: red;
            margin-right: 4px;
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
                <li><a href="add.php" class="active"><i class="fas fa-plus-circle"></i>إضافة مشروع جديد</a></li>
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
            <h5 class="mb-0 me-3"><?= $pageTitle ?></h5>
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
            <h3><?= $pageTitle ?></h3>
            <a href="list.php" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-right me-1"></i>
                العودة إلى قائمة المشاريع
            </a>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= $isUpdate ? 'تم تحديث المشروع بنجاح.' : 'تم إضافة المشروع بنجاح.' ?>
                <a href="list.php" class="alert-link">العودة إلى قائمة المشاريع</a>
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

        <form id="projectForm" method="POST" enctype="multipart/form-data" novalidate>
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

            <div class="tab-content" id="projectTabsContent">
                <!-- البيانات الأساسية -->
                <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                    <div class="row mb-4 mt-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="project_title_ar" class="form-label required-field">عنوان المشروع (عربي)</label>
                                <input type="text" class="form-control <?= isset($errors) && in_array('حقل عنوان المشروع (عربي) مطلوب', $errors) ? 'is-invalid' : '' ?>"
                                       id="project_title_ar" name="project_title_ar" value="<?= getValue('project_title_ar') ?>" required>
                                <div class="invalid-feedback">حقل عنوان المشروع (عربي) مطلوب</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="project_title_en" class="form-label required-field">عنوان المشروع (إنجليزي)</label>
                                <input type="text" class="form-control <?= isset($errors) && in_array('حقل عنوان المشروع (إنجليزي) مطلوب', $errors) ? 'is-invalid' : '' ?>"
                                       id="project_title_en" name="project_title_en" value="<?= getValue('project_title_en') ?>" required>
                                <div class="invalid-feedback">حقل عنوان المشروع (إنجليزي) مطلوب</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="project_category" class="form-label required-field">تصنيف المشروع</label>
                                <select class="form-select <?= isset($errors) && in_array('حقل تصنيف المشروع مطلوب', $errors) ? 'is-invalid' : '' ?>"
                                        id="project_category" name="project_category" required>
                                    <option value="" disabled>اختر التصنيف</option>
                                    <option value="residential" <?= isSelected('project_category', 'residential') ?>>سكني</option>
                                    <option value="commercial" <?= isSelected('project_category', 'commercial') ?>>تجاري</option>
                                    <option value="government" <?= isSelected('project_category', 'government') ?>>حكومي</option>
                                    <option value="infrastructure" <?= isSelected('project_category', 'infrastructure') ?>>بنية تحتية</option>
                                    <option value="development" <?= isSelected('project_category', 'development') ?>>تطوير عقاري</option>
                                </select>
                                <div class="invalid-feedback">حقل تصنيف المشروع مطلوب</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="department_id" class="form-label">القسم</label>
                                <select class="form-select" id="department_id" name="department_id">
                                    <option value="">اختر القسم</option>
                                    <?php foreach ($departments as $department): ?>
                                        <option value="<?= $department['id'] ?>" <?= isSelected('department_id', $department['id']) ?>>
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
                                <label for="location_ar" class="form-label required-field">الموقع (عربي)</label>
                                <input type="text" class="form-control <?= isset($errors) && in_array('حقل الموقع (عربي) مطلوب', $errors) ? 'is-invalid' : '' ?>"
                                       id="location_ar" name="location_ar" value="<?= getValue('location_ar') ?>" required>
                                <div class="invalid-feedback">حقل الموقع (عربي) مطلوب</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location_en" class="form-label required-field">الموقع (إنجليزي)</label>
                                <input type="text" class="form-control <?= isset($errors) && in_array('حقل الموقع (إنجليزي) مطلوب', $errors) ? 'is-invalid' : '' ?>"
                                       id="location_en" name="location_en" value="<?= getValue('location_en') ?>" required>
                                <div class="invalid-feedback">حقل الموقع (إنجليزي) مطلوب</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="client" class="form-label">العميل</label>
                                <input type="text" class="form-control" id="client" name="client" value="<?= getValue('client') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="area" class="form-label">المساحة (متر مربع)</label>
                                <input type="number" step="0.01" class="form-control" id="area" name="area" value="<?= getValue('area') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label required-field">تاريخ البدء</label>
                                <input type="date" class="form-control <?= isset($errors) && in_array('حقل تاريخ البدء مطلوب', $errors) ? 'is-invalid' : '' ?>"
                                       id="start_date" name="start_date" value="<?= getValue('start_date') ?>" required>
                                <div class="invalid-feedback">حقل تاريخ البدء مطلوب</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">تاريخ الانتهاء</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="<?= getValue('end_date') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label required-field">حالة المشروع</label>
                                <select class="form-select <?= isset($errors) && in_array('حقل حالة المشروع مطلوب', $errors) ? 'is-invalid' : '' ?>"
                                        id="status" name="status" required>
                                    <option value="" disabled>اختر الحالة</option>
                                    <?php foreach ($statusOptions as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= isSelected('status', $value) ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">حقل حالة المشروع مطلوب</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="is_featured" class="form-label d-block">عرض في الصفحة الرئيسية</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" <?= isChecked('is_featured') ?>>
                                    <label class="form-check-label" for="is_featured">عرض المشروع في الصفحة الرئيسية</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label <?= !$isUpdate ? 'required-field' : '' ?>">الصورة الرئيسية</label>
                        <div class="file-upload-container" onclick="document.getElementById('main_image').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <h5>اسحب الصورة هنا أو انقر للتحميل</h5>
                            <p>الحد الأقصى لحجم الملف: 5 ميجابايت، الأبعاد الموصى بها: 1200 × 800 بكسل</p>
                            <input type="file" id="main_image" name="main_image" accept="image/*" onchange="previewMainImage(this)">
                        </div>
                        <div class="image-preview" id="mainImagePreview">
                            <?php if($isUpdate && !empty($project['main_image'])): ?>
                                <div class="preview-item">
                                    <img src="../uploads/projects/<?= htmlspecialchars($project['main_image']) ?>" alt="صورة المشروع">
                                    <div class="remove-preview" onclick="removeMainImage()">
                                        <i class="fas fa-times"></i>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div></div> <!-- Empty div for alignment -->
                        <button type="button" class="btn btn-primary px-4" onclick="validateAndNextTab('basic', 'details-tab')">التالي</button>
                    </div>
                </div>

                <!-- التفاصيل -->
                <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                    <div class="row mb-4 mt-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="summary_ar" class="form-label">ملخص المشروع (عربي)</label>
                                <textarea class="form-control" id="summary_ar" name="summary_ar" rows="3"><?= getValue('summary_ar') ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="summary_en" class="form-label">ملخص المشروع (إنجليزي)</label>
                                <textarea class="form-control" id="summary_en" name="summary_en" rows="3"><?= getValue('summary_en') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description_ar" class="form-label">وصف المشروع (عربي)</label>
                        <textarea class="form-control" id="description_ar" name="description_ar" rows="5"><?= getValue('description_ar') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="description_en" class="form-label">وصف المشروع (إنجليزي)</label>
                        <textarea class="form-control" id="description_en" name="description_en" rows="5"><?= getValue('description_en') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="video_url" class="form-label">رابط فيديو (اختياري)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                            <input type="url" class="form-control" id="video_url" name="video_url" placeholder="مثال: https://www.youtube.com/watch?v=..." value="<?= getValue('video_url') ?>">
                        </div>
                        <small class="text-muted">أدخل رابط فيديو يوتيوب أو فيميو</small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary px-4" onclick="switchTab('basic-tab')">السابق</button>
                        <button type="button" class="btn btn-primary px-4" onclick="validateAndNextTab('details', 'seo-tab')">التالي</button>
                    </div>
                </div>

                <!-- إعدادات SEO -->
                <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                    <div class="row mb-4 mt-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="meta_title_ar" class="form-label">عنوان ميتا (عربي)</label>
                                <input type="text" class="form-control" id="meta_title_ar" name="meta_title_ar" value="<?= getValue('meta_title_ar') ?>">
                                <small class="text-muted">يُفضل ألا يتجاوز 60 حرفًا</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="meta_title_en" class="form-label">عنوان ميتا (إنجليزي)</label>
                                <input type="text" class="form-control" id="meta_title_en" name="meta_title_en" value="<?= getValue('meta_title_en') ?>">
                                <small class="text-muted">يُفضل ألا يتجاوز 60 حرفًا</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="meta_description_ar" class="form-label">وصف ميتا (عربي)</label>
                                <textarea class="form-control" id="meta_description_ar" name="meta_description_ar" rows="3"><?= getValue('meta_description_ar') ?></textarea>
                                <small class="text-muted">يُفضل ألا يتجاوز 160 حرفًا</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="meta_description_en" class="form-label">وصف ميتا (إنجليزي)</label>
                                <textarea class="form-control" id="meta_description_en" name="meta_description_en" rows="3"><?= getValue('meta_description_en') ?></textarea>
                                <small class="text-muted">يُفضل ألا يتجاوز 160 حرفًا</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="meta_keywords" class="form-label">الكلمات المفتاحية</label>
                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="<?= getValue('meta_keywords') ?>">
                        <small class="text-muted">افصل بين الكلمات المفتاحية بفواصل</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">خيارات النشر</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="publish_status" id="publish_now" value="published"
                                <?= isRadioChecked('publish_status', 'published', 'published') ?>>
                            <label class="form-check-label" for="publish_now">نشر الآن</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="publish_status" id="save_draft" value="draft"
                                <?= isRadioChecked('publish_status', 'draft') ?>>
                            <label class="form-check-label" for="save_draft">حفظ كمسودة</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="publish_status" id="schedule" value="scheduled"
                                <?= isRadioChecked('publish_status', 'scheduled') ?>>
                            <label class="form-check-label" for="schedule">جدولة النشر</label>
                        </div>
                        <div class="schedule-date-container mt-3" id="scheduleDateContainer" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="schedule_date" class="form-label">تاريخ النشر</label>
                                    <input type="datetime-local" class="form-control" id="schedule_date" name="schedule_date" value="<?= getValue('schedule_date') ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary px-4" onclick="switchTab('details-tab')">السابق</button>
                        <button type="submit" class="btn btn-success px-4" id="submitBtn"><?= $submitButtonText ?></button>
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

    // Switch to tab
    function switchTab(tabId) {
        const tab = document.getElementById(tabId);
        const bsTab = new bootstrap.Tab(tab);
        bsTab.show();
    }

    // Validate form fields and proceed to next tab
    function validateAndNextTab(currentTabId, nextTabId) {
        let isValid = true;

        // Validate fields in current tab
        const currentTab = document.getElementById(currentTabId);
        const requiredFields = currentTab.querySelectorAll('input[required], select[required], textarea[required]');

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        // If validation passes, go to next tab
        if (isValid) {
            switchTab(nextTabId);
        } else {
            // Scroll to first invalid field
            const firstInvalid = currentTab.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    }

    // Preview main image
    function previewMainImage(input) {
        const preview = document.getElementById('mainImagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Clear preview first
                preview.innerHTML = '';

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

    // Toggle schedule date field based on publish status
    document.addEventListener('DOMContentLoaded', function() {
        const scheduleRadio = document.getElementById('schedule');
        const scheduleDateContainer = document.getElementById('scheduleDateContainer');

        // Set initial state
        scheduleDateContainer.style.display = scheduleRadio.checked ? 'block' : 'none';

        // Add event listeners to all publish status radio buttons
        document.querySelectorAll('input[name="publish_status"]').forEach(radio => {
            radio.addEventListener('change', function() {
                scheduleDateContainer.style.display = scheduleRadio.checked ? 'block' : 'none';
            });
        });

        // Form validation on submit
        const form = document.getElementById('projectForm');
        form.addEventListener('submit', function(event) {
            let isValid = true;

            // Validate all required fields
            const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            // Validate scheduled date if scheduling is selected
            if (scheduleRadio.checked) {
                const scheduleDate = document.getElementById('schedule_date');
                if (!scheduleDate.value) {
                    scheduleDate.classList.add('is-invalid');
                    isValid = false;
                } else {
                    scheduleDate.classList.remove('is-invalid');
                }
            }

            // If validation fails, prevent form submission
            if (!isValid) {
                event.preventDefault();

                // Find which tab contains validation errors and switch to it
                const tabs = ['basic', 'details', 'seo'];
                for (const tabId of tabs) {
                    const tab = document.getElementById(tabId);
                    if (tab.querySelector('.is-invalid')) {
                        switchTab(tabId + '-tab');

                        // Scroll to first invalid field
                        const firstInvalid = tab.querySelector('.is-invalid');
                        if (firstInvalid) {
                            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                        break;
                    }
                }
            }
        });

        // Add event listener for input fields to remove validation errors on input
        form.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    this.classList.remove('is-invalid');
                }
            });
        });

        // If there are errors, show the tab with the first error
        <?php if (!empty($errors)): ?>
        document.addEventListener('DOMContentLoaded', function() {
            // Check which tab has validation errors
            const tabs = ['basic', 'details', 'seo'];
            let foundTab = false;

            for (const tabId of tabs) {
                const tab = document.getElementById(tabId);
                if (tab.querySelector('.is-invalid')) {
                    switchTab(tabId + '-tab');
                    foundTab = true;
                    break;
                }
            }

            // If no specific field errors found, default to first tab
            if (!foundTab) {
                switchTab('basic-tab');
            }
        });
        <?php endif; ?>
    });
</script>
</body>
</html>