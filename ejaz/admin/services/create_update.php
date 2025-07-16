<?php
session_start();
require_once '../../config/db.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Authentication check
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit;
}

// Determine if editing
$edit = isset($_GET['id']) && is_numeric($_GET['id']);
$service = null;
if ($edit) {
    $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $service = $stmt->fetch();
    if (!$service) {
        header('Location: index.php');
        exit;
    }
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation
    if (empty($_POST['title_ar'])) {
        $errors[] = 'حقل العنوان (عربي) مطلوب.';
    }
    if (empty($_POST['title_en'])) {
        $errors[] = 'حقل العنوان (إنجليزي) مطلوب.';
    }
    if (empty($_POST['order']) || !is_numeric($_POST['order'])) {
        $errors[] = 'حقل الترتيب مطلوب ورقمياً.';
    }

    // Handle image upload
    $imgName = $service['img'] ?? null;
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','gif'];
        if (!in_array(strtolower($ext), $allowed)) {
            $errors[] = 'نوع الصورة غير مدعوم.';
        } else {
            $newName = uniqid('srv_') . '.' . $ext;
            $uploadDir = '../uploads/services/';
            if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
            if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadDir . $newName)) {
                // delete old if editing
                if ($edit && !empty($service['img']) && file_exists($uploadDir . $service['img'])) {
                    unlink($uploadDir . $service['img']);
                }
                $imgName = $newName;
            } else {
                $errors[] = 'فشل رفع الصورة.';
            }
        }
    }

    if (empty($errors)) {
        if ($edit) {
            // Update
            $sql = "UPDATE services
                    SET title_ar = ?, title_en = ?, desc_ar = ?, desc_en = ?, url = ?, img = ?, `order` = ?
                    WHERE id = ?";
            $params = [
                $_POST['title_ar'],
                $_POST['title_en'],
                $_POST['desc_ar'] ?? null,
                $_POST['desc_en'] ?? null,
                $_POST['url'] ?? null,
                $imgName,
                $_POST['order'],
                $_GET['id']
            ];
        } else {
            // Insert
            $sql = "INSERT INTO services
                    (title_ar, title_en, desc_ar, desc_en, url, img, `order`)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $params = [
                $_POST['title_ar'],
                $_POST['title_en'],
                $_POST['desc_ar'] ?? null,
                $_POST['desc_en'] ?? null,
                $_POST['url'] ?? null,
                $imgName,
                $_POST['order']
            ];
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $edit ? 'تعديل الخدمة' : 'إضافة خدمة جديدة' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/admin/style.css">
</head>
<body>
<?php include '../../includes/admin/sidebar.php'; ?>
<div class="main-content">
    <div class="content-box">
        <div class="content-box-header">
            <h3><?= $edit ? 'تعديل الخدمة' : 'إضافة خدمة جديدة' ?></h3>
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-arrow-right me-1"></i> العودة إلى القائمة
            </a>
        </div>

        <?php if ($errors): ?>
            <div class="alert alert-danger"><ul>
                    <?php foreach ($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?>
                </ul></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">العنوان (عربي)<span class="text-danger">*</span></label>
                <input type="text" name="title_ar" class="form-control" value="<?= htmlspecialchars($service['title_ar'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">العنوان (إنجليزي)<span class="text-danger">*</span></label>
                <input type="text" name="title_en" class="form-control" value="<?= htmlspecialchars($service['title_en'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">الوصف (عربي)</label>
                <textarea name="desc_ar" class="form-control"><?= htmlspecialchars($service['desc_ar'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">الوصف (إنجليزي)</label>
                <textarea name="desc_en" class="form-control"><?= htmlspecialchars($service['desc_en'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">الرابط</label>
                <input type="url" name="url" class="form-control" value="<?= htmlspecialchars($service['url'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">الصورة</label><br>
                <?php if (!empty($service['img'])): ?>
                    <img src="../uploads/services/<?= htmlspecialchars($service['img']) ?>" width="100" class="mb-2">
                <?php endif; ?>
                <input type="file" name="img" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label">الترتيب<span class="text-danger">*</span></label>
                <input type="number" name="order" class="form-control" value="<?= htmlspecialchars($service['order'] ?? '') ?>" required>
            </div>
            <button type="submit" class="btn btn-success"><?= $edit ? 'حفظ التعديل' : 'إضافة الخدمة' ?></button>
            <a href="index.php" class="btn btn-secondary ms-2">إلغاء</a>
        </form>
    </div>
</div>
<?php require_once '../../includes/admin/footer.php';?>
</body>
</html>
