<?php
// Function to determine the base path regardless of environment
function getBasePath() {
    // Get the current script path
    $currentPath = $_SERVER['SCRIPT_NAME'];

    // Extract the admin directory path
    $adminDir = '';
    if (strpos($currentPath, '/admin/') !== false) {
        $pathParts = explode('/admin/', $currentPath);
        $adminDir = $pathParts[0] . '/admin';
    }

    return $adminDir;
}

// Get the base path for the application
$basePath = getBasePath();
?>

<div class="sidebar">
    <div class="sidebar-header">
        <img src="<?php echo $basePath; ?>/assets/img/logo-white.png" alt="شركة ايجاز النوادي للمقاولات">
        <h4>لوحة التحكم</h4>
    </div>
    <ul class="sidebar-menu">
        <li>
            <a href="<?php echo $basePath; ?>/index.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], '/index.php') !== false) ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i>
                الرئيسية
            </a>
        </li>

        <li>
            <button class="submenu-toggle" onclick="toggleSubmenu(this)">
                <i class="fas fa-building"></i>
                أقسامنا
                <i class="fas fa-chevron-down menu-arrow"></i>
            </button>
            <ul class="submenu <?php echo (strpos($_SERVER['PHP_SELF'], '/departments/') !== false) ? 'active' : ''; ?>">
                <li><a href="<?php echo $basePath; ?>/departments/index.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], '/departments/index.php') !== false) ? 'active' : ''; ?>"><i class="fas fa-list"></i>قائمة الأقسام</a></li>
                <li><a href="<?php echo $basePath; ?>/departments/create_update.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], '/departments/create_update.php') !== false) ? 'active' : ''; ?>"><i class="fas fa-plus-circle"></i>إضافة قسم جديد</a></li>
            </ul>
        </li>
        <li>
            <button class="submenu-toggle" onclick="toggleSubmenu(this)">
                <i class="fas fa-tasks"></i>
                خدماتنا
                <i class="fas fa-chevron-down menu-arrow"></i>
            </button>
            <ul class="submenu <?php echo (strpos($_SERVER['PHP_SELF'], '/services/') !== false) ? 'active' : ''; ?>">
                <li><a href="<?php echo $basePath; ?>/services/index.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], '/services/index.php') !== false) ? 'active' : ''; ?>"><i class="fas fa-list"></i>قائمة الخدمات</a></li>
                <li><a href="<?php echo $basePath; ?>/services/create_update.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], '/services/create_update.php') !== false) ? 'active' : ''; ?>"><i class="fas fa-plus-circle"></i>إضافة خدمة جديدة</a></li>
            </ul>
        </li>
        <li>
            <button class="submenu-toggle" onclick="toggleSubmenu(this)">
                <i class="fas fa-project-diagram"></i>
                المشاريع
                <i class="fas fa-chevron-down menu-arrow"></i>
            </button>
            <ul class="submenu <?php echo (strpos($_SERVER['PHP_SELF'], '/projects/') !== false) ? 'active' : ''; ?>">
                <li><a href="<?php echo $basePath; ?>/projects/list.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], '/projects/index.php') !== false) ? 'active' : ''; ?>"><i class="fas fa-list"></i>قائمة المشاريع</a></li>
                <li><a href="<?php echo $basePath; ?>/projects/create_update.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], '/projects/create_update.php') !== false) ? 'active' : ''; ?>"><i class="fas fa-plus-circle"></i>إضافة مشروع جديد</a></li>
            </ul>
        </li>
        <li>
            <button class="submenu-toggle" onclick="toggleSubmenu(this)">
                <i class="fas fa-edit"></i>
                المدونة
                <i class="fas fa-chevron-down menu-arrow"></i>
            </button>
            <ul class="submenu <?php echo (strpos($_SERVER['PHP_SELF'], '/blogs/') !== false) ? 'active' : ''; ?>">
                <li><a href="<?php echo $basePath; ?>/blogs/index.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], '/blogs/index.php') !== false) ? 'active' : ''; ?>"><i class="fas fa-list"></i>قائمة المقالات</a></li>
                <li><a href="<?php echo $basePath; ?>/blogs/create_update.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], '/blogs/create_update.php') !== false) ? 'active' : ''; ?>"><i class="fas fa-plus-circle"></i>إضافة مقال جديد</a></li>
            </ul>
        </li>
        <li>
            <a href="<?php echo $basePath; ?>/messages/index.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], '/messages/') !== false) ? 'active' : ''; ?>">
                <i class="fas fa-envelope"></i>
                رسائل التواصل
            </a>
        </li>
        <li>
            <a href="<?php echo $basePath; ?>/users/index.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], '/users/') !== false) ? 'active' : ''; ?>">
                <i class="fas fa-users"></i>
                المستخدمين
            </a>
        </li>
        <li>
            <a href="<?php echo $basePath; ?>/settings/settings.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], '/settings/') !== false) ? 'active' : ''; ?>">
                <i class="fas fa-cog"></i>
                الإعدادات
            </a>
        </li>
        <li>
            <a href="<?php echo $basePath; ?>/logout.php">
                <i class="fas fa-sign-out-alt"></i>
                تسجيل الخروج
            </a>
        </li>
    </ul>
</div>