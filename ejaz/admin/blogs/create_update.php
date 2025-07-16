<?php
session_start();
require_once '../../config/db.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Auth
if (!isset($_SESSION['admin_logged_in'])) { header('Location: ../login.php'); exit; }

// Edit
$edit = isset($_GET['id']) && is_numeric($_GET['id']);
$post = null;
if ($edit) {
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $post = $stmt->fetch();
    if (!$post) { header('Location: index.php'); exit; }
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['title_ar'])) $errors[] = 'عنوان عربي مطلوب.';
    if (empty($_POST['title_en'])) $errors[] = 'عنوان إنجليزي مطلوب.';
    if (empty($_POST['content_ar'])) $errors[] = 'المحتوى العربي مطلوب.';
    if (empty($_POST['content_en'])) $errors[] = 'المحتوى الإنجليزي مطلوب.';
    if (empty($_POST['category'])) $errors[] = 'التصنيف مطلوب.';

    if (!$errors) {
        if ($edit) {
            $sql = "UPDATE blogs SET title_ar=?,title_en=?,content_ar=?,content_en=?,category=? WHERE id=?";
            $params = [
                $_POST['title_ar'],
                $_POST['title_en'],
                $_POST['content_ar'],
                $_POST['content_en'],
                $_POST['category'],
                $_GET['id']
            ];
        } else {
            $sql = "INSERT INTO blogs(title_ar,title_en,content_ar,content_en,category) VALUES(?,?,?,?,?)";
            $params = [
                $_POST['title_ar'],
                $_POST['title_en'],
                $_POST['content_ar'],
                $_POST['content_en'],
                $_POST['category']
            ];
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        header('Location: index.php'); exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $edit?'تعديل مقال':'إضافة مقال جديد' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/admin/style.css">
</head>
<body>
<?php include '../../includes/admin/sidebar.php'; ?>
<div class="main-content"><div class="content-box">
        <div class="content-box-header">
            <h3><?= $edit?'تعديل مقال':'إضافة مقال جديد' ?></h3>
            <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-right me-1"></i> العودة</a>
        </div>
        <?php if($errors): ?><div class="alert alert-danger"><ul><?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul></div><?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">العنوان (عربي)<span class="text-danger">*</span></label>
                <input type="text" name="title_ar" class="form-control" value="<?= htmlspecialchars($post['title_ar']??'') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">العنوان (إنجليزي)<span class="text-danger">*</span></label>
                <input type="text" name="title_en" class="form-control" value="<?= htmlspecialchars($post['title_en']??'') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">التصنيف<span class="text-danger">*</span></label>
                <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($post['category']??'') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">المحتوى (عربي)<span class="text-danger">*</span></label>
                <textarea name="content_ar" class="form-control" rows="5" required><?= htmlspecialchars($post['content_ar']??'') ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">المحتوى (إنجليزي)<span class="text-danger">*</span></label>
                <textarea name="content_en" class="form-control" rows="5" required><?= htmlspecialchars($post['content_en']??'') ?></textarea>
            </div>
            <button class="btn btn-success"><?= $edit?'حفظ التعديل':'إضافة المقال' ?></button>
            <a href="index.php" class="btn btn-secondary ms-2">إلغاء</a>
        </form>
    </div></div>
<?php require_once '../../includes/admin/footer.php';?>
</body>
</html>
