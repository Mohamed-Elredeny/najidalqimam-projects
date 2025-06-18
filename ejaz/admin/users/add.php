<?php
session_start();
require_once '../../config/db.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit;
}

$errors   = [];
$success  = false;
$isEdit   = !empty($_GET['id']);
$user     = null;

// If we’re editing, fetch existing user
if ($isEdit) {
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $user = $stmt->fetch();
    if (!$user) {
        die('المستخدم غير موجود');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // Validation
    if ($username === '') {
        $errors[] = 'حقل اسم المستخدم مطلوب';
    }
    // If creating, or if password is non‑empty on edit, enforce password rules
    if (!$isEdit || $password !== '') {
        if (strlen($password) < 6) {
            $errors[] = 'كلمة المرور يجب أن تكون 6 أحرف على الأقل';
        } elseif ($password !== $confirm) {
            $errors[] = 'كلمتا المرور غير متطابقتين';
        }
    }

    // Ensure username is unique
    $sql = "SELECT id FROM admin_users WHERE username = ?"
        . ($isEdit ? " AND id <> ?" : "");
    $stmt = $pdo->prepare($sql);
    $stmt->execute($isEdit
        ? [$username, $_GET['id']]
        : [$username]
    );
    if ($stmt->fetch()) {
        $errors[] = 'اسم المستخدم محجوز';
    }

    // If no errors, insert or update
    if (empty($errors)) {
        if ($isEdit) {
            if ($password !== '') {
                // update username + password
                $hash = hash('sha256', $password);
                $upd  = $pdo->prepare(
                    "UPDATE admin_users SET username = ?, password = ? WHERE id = ?"
                );
                $upd->execute([$username, $hash, $_GET['id']]);
            } else {
                // update only username
                $pdo->prepare(
                    "UPDATE admin_users SET username = ? WHERE id = ?"
                )->execute([$username, $_GET['id']]);
            }
        } else {
            // new user
            $hash = hash('sha256', $password);
            $ins  = $pdo->prepare(
                "INSERT INTO admin_users(username, password) VALUES(?, ?)"
            );
            $ins->execute([$username, $hash]);
        }
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title><?= $isEdit ? 'تعديل' : 'إضافة' ?> مستخدم</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/admin/style.css">
</head>
<body>
<?php include '../../includes/admin/sidebar.php'; ?>

<div class="main-content p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><?= $isEdit ? 'تعديل' : 'إضافة' ?> مستخدم</h3>
        <a href="index.php" class="btn btn-outline-secondary">
            <i class="fas fa-list"></i> قائمة المستخدمين
        </a>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success">
            تم <?= $isEdit ? 'تحديث' : 'إضافة' ?> المستخدم بنجاح.
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" novalidate>
        <div class="mb-3">
            <label class="form-label">اسم المستخدم</label>
            <input
                    type="text"
                    name="username"
                    class="form-control"
                    required
                    value="<?= htmlspecialchars($user['username'] ?? '') ?>"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">
                <?= $isEdit ? 'تغيير كلمة المرور' : 'كلمة المرور' ?>
                <?php if (!$isEdit) echo '<span class="text-danger">*</span>'; ?>
            </label>
            <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="<?= $isEdit ? 'اتركه فارغاً إذا لم ترغب بالتغيير' : '' ?>"
                <?= $isEdit ? '' : 'required' ?>
            >
        </div>

        <div class="mb-3">
            <label class="form-label">
                تأكيد كلمة المرور
                <?php if (!$isEdit) echo '<span class="text-danger">*</span>'; ?>
            </label>
            <input
                    type="password"
                    name="confirm_password"
                    class="form-control"
                <?= $isEdit ? '' : 'required' ?>
            >
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> حفظ
        </button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
