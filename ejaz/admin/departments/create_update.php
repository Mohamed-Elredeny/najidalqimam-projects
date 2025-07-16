<?php
session_start();
require_once '../../config/db.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Auth
if(!isset($_SESSION['admin_logged_in'])){
    header('Location: ../login.php'); exit;
}

// Edit mode
$edit = isset($_GET['id']) && is_numeric($_GET['id']);
$dept=null;
if($edit){
    $stmt=$pdo->prepare("SELECT * FROM departments WHERE id=?");
    $stmt->execute([$_GET['id']]);
    $dept=$stmt->fetch();
    if(!$dept){ header('Location:index.php'); exit; }
}

$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(empty($_POST['name'])) $errors[]='حقل اسم القسم مطلوب.';

    // File upload
    $imgName=$dept['image']??null;
    if(isset($_FILES['image']) && $_FILES['image']['error']===UPLOAD_ERR_OK){
        $ext=pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
        $allowed=['jpg','jpeg','png','gif'];
        if(!in_array(strtolower($ext),$allowed)){
            $errors[]='نوع الصورة غير مدعوم.';
        } else {
            $new=uniqid('dep_').".$ext";
            $dir='../uploads/departments/'; if(!file_exists($dir))mkdir($dir,0777,true);
            if(move_uploaded_file($_FILES['image']['tmp_name'],$dir.$new)){
                if($edit && !empty($dept['image']) && file_exists($dir.$dept['image']))
                    unlink($dir.$dept['image']);
                $imgName=$new;
            } else {
                $errors[]='فشل رفع الصورة.';
            }
        }
    }

    if(empty($errors)){
        if($edit){
            $sql="UPDATE departments SET name=?,description=?,image=? WHERE id=?";
            $params=[
                $_POST['name'],
                $_POST['description']??null,
                $imgName,
                $_GET['id']
            ];
        } else {
            $sql="INSERT INTO departments(name,description,image) VALUES(?,?,?)";
            $params=[$_POST['name'],$_POST['description']??null,$imgName];
        }
        $stmt=$pdo->prepare($sql);
        $stmt->execute($params);
        header('Location: index.php'); exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $edit?'تعديل قسم':'إضافة قسم جديد' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/admin/style.css">
</head>
<body>
<?php include '../../includes/admin/sidebar.php'; ?>
<div class="main-content">
    <div class="content-box">
        <div class="content-box-header">
            <h3><?= $edit?'تعديل قسم':'إضافة قسم جديد' ?></h3>
            <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-right me-1"></i> العودة</a>
        </div>
        <?php if($errors): ?><div class="alert alert-danger"><ul><?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul></div><?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">اسم القسم<span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($dept['name']??'') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">الوصف</label>
                <textarea name="description" class="form-control"><?= htmlspecialchars($dept['description']??'') ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">الصورة</label><br>
                <?php if(!empty($dept['image'])): ?>
                    <img src="../uploads/departments/<?= htmlspecialchars($dept['image']) ?>" width="100" class="mb-2">
                <?php endif; ?>
                <input type="file" name="image" accept="image/*">
            </div>
            <button class="btn btn-success"><?= $edit?'حفظ التعديل':'إضافة القسم' ?></button>
            <a href="index.php" class="btn btn-secondary ms-2">إلغاء</a>
        </form>
    </div>
</div>
<?php require_once '../../includes/admin/footer.php';?>
</body>
</html>
