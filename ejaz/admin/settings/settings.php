<?php
session_start();
require_once '../../config/db.php';
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// fetch data for each section
$slider   = $pdo->query("SELECT * FROM homepage_slider ORDER BY `order`")->fetchAll();
$welcome  = $pdo->query("SELECT * FROM homepage_welcome WHERE id=1")->fetch();
$featured = $pdo->query("SELECT * FROM homepage_featured ORDER BY `order`")->fetchAll();
$contact  = $pdo->query("SELECT * FROM contact_info")->fetchAll();
$options  = $pdo->query("SELECT * FROM service_options")->fetchAll();

// handle POST save
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['tab'])) {
    $tab = $_POST['tab'];
    try {
        $pdo->beginTransaction();
        switch($tab) {
            case 'slider':
                $upd = $pdo->prepare("UPDATE homepage_slider SET link=?, `order`=? WHERE id=?");
                foreach($_POST['slider_id'] as $i=>$id) {
                    $upd->execute([
                        $_POST['slider_link'][$i],
                        $_POST['slider_order'][$i],
                        $id
                    ]);
                }
                break;
            case 'welcome':
                $upd = $pdo->prepare("UPDATE homepage_welcome SET title_ar=?,title_en=?,text_ar=?,text_en=? WHERE id=1");
                $upd->execute([
                    $_POST['welcome_title_ar'],
                    $_POST['welcome_title_en'],
                    $_POST['welcome_text_ar'],
                    $_POST['welcome_text_en']
                ]);
                break;
            case 'featured':
                $upd = $pdo->prepare("UPDATE homepage_featured SET icon=?,title_ar=?,title_en=?,`order`=? WHERE id=?");
                foreach($_POST['feat_id'] as $i=>$id) {
                    $upd->execute([
                        $_POST['feat_icon'][$i],
                        $_POST['feat_title_ar'][$i],
                        $_POST['feat_title_en'][$i],
                        $_POST['feat_order'][$i],
                        $id
                    ]);
                }
                break;
            case 'contact':
                $upd = $pdo->prepare("UPDATE contact_info SET value=? WHERE id=?");
                foreach($_POST['contact_id'] as $i=>$id) {
                    $upd->execute([
                        $_POST['contact_value'][$i],
                        $id
                    ]);
                }
                break;
            case 'options':
                $upd = $pdo->prepare("UPDATE service_options SET label_ar=?,label_en=? WHERE id=?");
                foreach($_POST['opt_id'] as $i=>$id) {
                    $upd->execute([
                        $_POST['opt_label_ar'][$i],
                        $_POST['opt_label_en'][$i],
                        $id
                    ]);
                }
                break;
        }
        $pdo->commit();
        $success = true;
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = $e->getMessage();
    }
    // re‐fetch fresh data
    $slider   = $pdo->query("SELECT * FROM homepage_slider ORDER BY `order`")->fetchAll();
    $welcome  = $pdo->query("SELECT * FROM homepage_welcome WHERE id=1")->fetch();
    $featured = $pdo->query("SELECT * FROM homepage_featured ORDER BY `order`")->fetchAll();
    $contact  = $pdo->query("SELECT * FROM contact_info")->fetchAll();
    $options  = $pdo->query("SELECT * FROM service_options")->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>الإعدادات العامة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/admin/style.css">
</head>
<body>
<?php include '../../includes/admin/sidebar.php'; ?>
<div class="main-content p-4">
    <h3>الإعدادات العامة</h3>
    <?php if(!empty($success)): ?>
        <div class="alert alert-success">تم الحفظ بنجاح</div>
    <?php elseif(!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <ul class="nav nav-tabs mb-3" id="settingsTabs" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-slider">سلايدر</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-welcome">نص الترحيب</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-featured">الخدمات المميزة</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-contact">معلومات الاتصال</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-options">خيارات الخدمة</button></li>
    </ul>

    <div class="tab-content">
        <!-- Slider -->
        <div class="tab-pane fade show active" id="tab-slider">
            <form method="post">
                <input type="hidden" name="tab" value="slider">
                <table class="table table-striped align-middle">
                    <thead>
                    <tr><th>#</th><th>صورة</th><th>الرابط</th><th>ترتيب</th></tr>
                    </thead>
                    <tbody>
                    <?php foreach($slider as $s): ?>
                        <tr>
                            <td><?= $s['id'] ?></td>
                            <td><img src="<?= htmlspecialchars($s['img']) ?>" height="60"></td>
                            <td>
                                <input type="hidden" name="slider_id[]" value="<?= $s['id'] ?>">
                                <input name="slider_link[]" class="form-control" value="<?= htmlspecialchars($s['link']) ?>">
                            </td>
                            <td><input name="slider_order[]" type="number" class="form-control" value="<?= $s['order'] ?>"></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="btn btn-primary">حفظ السلايدر</button>
            </form>
        </div>

        <!-- Welcome Text -->
        <div class="tab-pane fade" id="tab-welcome">
            <form method="post">
                <input type="hidden" name="tab" value="welcome">
                <div class="mb-3">
                    <label class="form-label">العنوان (عربي)</label>
                    <input name="welcome_title_ar" class="form-control" value="<?= htmlspecialchars($welcome['title_ar']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">العنوان (إنجليزي)</label>
                    <input name="welcome_title_en" class="form-control" value="<?= htmlspecialchars($welcome['title_en']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">النص (عربي)</label>
                    <textarea name="welcome_text_ar" class="form-control"><?= htmlspecialchars($welcome['text_ar']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">النص (إنجليزي)</label>
                    <textarea name="welcome_text_en" class="form-control"><?= htmlspecialchars($welcome['text_en']) ?></textarea>
                </div>
                <button class="btn btn-primary">حفظ نص الترحيب</button>
            </form>
        </div>

        <!-- Featured Services -->
        <div class="tab-pane fade" id="tab-featured">
            <form method="post">
                <input type="hidden" name="tab" value="featured">
                <table class="table table-striped align-middle">
                    <thead>
                    <tr><th>#</th><th>أيقونة</th><th>العنوان (عربي)</th><th>العنوان (إنجليزي)</th><th>ترتيب</th></tr>
                    </thead>
                    <tbody>
                    <?php foreach($featured as $f): ?>
                        <tr>
                            <td><?= $f['id'] ?></td>
                            <td><input name="feat_icon[]" class="form-control" value="<?= htmlspecialchars($f['icon']) ?>"></td>
                            <td><input name="feat_title_ar[]" class="form-control" value="<?= htmlspecialchars($f['title_ar']) ?>"></td>
                            <td><input name="feat_title_en[]" class="form-control" value="<?= htmlspecialchars($f['title_en']) ?>"></td>
                            <td>
                                <input type="hidden" name="feat_id[]" value="<?= $f['id'] ?>">
                                <input name="feat_order[]" type="number" class="form-control" value="<?= $f['order'] ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="btn btn-primary">حفظ الخدمات المميزة</button>
            </form>
        </div>

        <!-- Contact Info -->
        <div class="tab-pane fade" id="tab-contact">
            <form method="post">
                <input type="hidden" name="tab" value="contact">
                <table class="table table-striped align-middle">
                    <thead>
                    <tr><th>#</th><th>نوع</th><th>القيمة</th></tr>
                    </thead>
                    <tbody>
                    <?php foreach($contact as $c): ?>
                        <tr>
                            <td><?= $c['id'] ?></td>
                            <td><?= htmlspecialchars($c['label_ar']) ?> / <?= htmlspecialchars($c['label_en']) ?></td>
                            <td>
                                <input type="hidden" name="contact_id[]" value="<?= $c['id'] ?>">
                                <input name="contact_value[]" class="form-control" value="<?= htmlspecialchars($c['value']) ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="btn btn-primary">حفظ معلومات الاتصال</button>
            </form>
        </div>

        <!-- Service Options -->
        <div class="tab-pane fade" id="tab-options">
            <form method="post">
                <input type="hidden" name="tab" value="options">
                <table class="table table-striped align-middle">
                    <thead>
                    <tr><th>#</th><th>قيمة</th><th>التسمية (عربي)</th><th>التسمية (إنجليزي)</th></tr>
                    </thead>
                    <tbody>
                    <?php foreach($options as $o): ?>
                        <tr>
                            <td><?= $o['id'] ?></td>
                            <td><?= htmlspecialchars($o['value']) ?></td>
                            <td>
                                <input type="hidden" name="opt_id[]" value="<?= $o['id'] ?>">
                                <input name="opt_label_ar[]" class="form-control" value="<?= htmlspecialchars($o['label_ar']) ?>">
                            </td>
                            <td><input name="opt_label_en[]" class="form-control" value="<?= htmlspecialchars($o['label_en']) ?>"></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="btn btn-primary">حفظ خيارات الخدمة</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../../includes/admin/footer.php';?>
</body>
</html>
