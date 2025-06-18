<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>لوحة التحكم – شركة إنجاز النوادي</title>
    <!-- RTL Bootstrap & Font‑Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom Dashboard CSS -->
    <link href="/assets/css/dashboard.css" rel="stylesheet">
</head>
<body>
<div class="sidebar">
    <div class="sidebar-header text-center">
        <img src="/assets/img/logo-white.png" alt="Logo" class="mb-2" style="height:60px">
        <h4>لوحة التحكم</h4>
    </div>
    <ul class="sidebar-menu">
        <li><a href="?module=dashboard"><i class="fas fa-tachometer-alt"></i> الرئيسية</a></li>
        <li>
            <button class="submenu-toggle"><i class="fas fa-project-diagram"></i> المشاريع
                <i class="fas fa-chevron-down menu-arrow"></i>
            </button>
            <ul class="submenu">
                <li><a href="?module=projects&action=list"><i class="fas fa-list"></i> قائمة المشاريع</a></li>
                <li><a href="?module=projects&action=add"><i class="fas fa-plus-circle"></i> إضافة مشروع جديد</a></li>
            </ul>
        </li>
        <!-- … repeat for services, departments, etc. … -->
        <li><a href="login.php?logout"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</a></li>
    </ul>
</div>

<div class="main-content">
    <nav class="top-navbar d-flex justify-content-between align-items-center mb-4">
        <div>
            <button class="menu-toggle btn btn-light"><i class="fas fa-bars"></i></button>
            <span class="h5 ms-3"><?= ucfirst($module) ?></span>
        </div>
        <div class="user-dropdown">
            <button class="user-dropdown-toggle btn btn-light">
                <img src="/assets/img/user-avatar.jpg" class="user-avatar" alt="User">
                <span><?=$_SESSION['admin_name']?></span>
            </button>
            <div class="user-dropdown-menu">
                <a href="?module=settings&action=profile"><i class="fas fa-user"></i> الملف الشخصي</a>
                <a href="?module=settings&action=general"><i class="fas fa-cog"></i> الإعدادات</a>
                <a href="login.php?logout"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</a>
            </div>
        </div>
    </nav>
