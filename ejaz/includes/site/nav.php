<?php
// Get current page for active class
$current_page = basename($_SERVER['PHP_SELF']);
$current_page = str_replace('.php', '', $current_page);

// Fetch main navigation items
try {
    $navQuery = "SELECT * FROM nav_links WHERE parent_id IS NULL ORDER BY `order`";
    $navStmt = $pdo->query($navQuery);
    $mainNavItems = $navStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Fallback to static items if query fails
    $mainNavItems = [
        ['id' => 1, 'title_ar' => 'الرئيسية', 'title_en' => 'Home', 'url' => 'index.php'],
        ['id' => 2, 'title_ar' => 'من نحن', 'title_en' => 'About', 'url' => 'about.php'],
        ['id' => 3, 'title_ar' => 'خدماتنا', 'title_en' => 'Services', 'url' => 'services.php'],
        ['id' => 4, 'title_ar' => 'مشاريعنا', 'title_en' => 'Projects', 'url' => 'projects.php'],
        ['id' => 5, 'title_ar' => 'اتصل بنا', 'title_en' => 'Contact', 'url' => 'contact.php']
    ];
}

// Function to get child menu items
function getChildMenuItems($parentId, $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM nav_links WHERE parent_id = ? ORDER BY `order`");
        $stmt->execute([$parentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return [];
    }
}

// Simple function to check if current page matches the URL
function isActiveLink($url, $current_page) {
    $url_page = str_replace('.php', '', basename($url));
    return $url_page === $current_page;
}
?>
<style>
    /* Main Navigation Styles */
    .navbar {
        background-color: #ffffff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 15px 0;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .navbar-brand img {
        height: 50px;
        max-width: 100%;
    }

    .navbar-nav {
        margin: 0 auto;
    }

    .nav-item {
        position: relative;
        margin: 0 10px;
    }

    .nav-link {
        color: #333;
        font-weight: 600;
        padding: 10px 15px;
        transition: all 0.3s ease;
        position: relative;
        font-size: 16px;
    }

    .nav-link:hover,
    .nav-link:focus,
    .nav-link.active {
        color: #f39c12; /* Primary color - adjust to match your theme */
    }

    /* Animated underline effect */
    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        background-color: #f39c12; /* Primary color */
        bottom: 0;
        right: 0; /* RTL support - start from right */
        transition: width 0.3s ease;
    }

    .nav-link:hover::after,
    .nav-link:focus::after,
    .nav-link.active::after {
        width: 100%;
    }

    /* Dropdown styling */
    .dropdown-menu {
        border: none;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 10px 0;
        min-width: 220px;
        margin-top: 10px;
        right: 0; /* RTL support */
    }

    .dropdown-toggle::after {
        margin-right: 5px; /* RTL adjustment */
        vertical-align: middle;
    }

    .dropdown-item {
        padding: 8px 20px;
        font-weight: 500;
        color: #333;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover,
    .dropdown-item:focus,
    .dropdown-item.active {
        background-color: rgba(243, 156, 18, 0.1); /* Light primary color */
        color: #f39c12; /* Primary color */
    }

    /* Custom get quote button */
    .navbar .btn-primary {
        background-color: #f39c12; /* Primary color */
        border-color: #f39c12;
        color: white;
        padding: 8px 20px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-right: 15px;
    }

    .navbar .btn-primary:hover,
    .navbar .btn-primary:focus {
        background-color: #e67e22; /* Darker shade */
        border-color: #e67e22;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Mobile navigation */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }

        .navbar-toggler {
            border: none;
            padding: 0;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .nav-item {
            margin: 5px 0;
        }

        .nav-link::after {
            display: none;
        }

        .dropdown-menu {
            box-shadow: none;
            padding-right: 15px; /* RTL indentation */
            border-right: 2px solid #f39c12; /* RTL border */
            margin-top: 0;
        }

        .navbar .btn-primary {
            margin-top: 15px;
            display: block;
            text-align: center;
        }
    }
</style>
<!-- Navigation Bar -->
<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/logo.png" alt="شركة ايجاز البوادي للمقاولات">
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                    aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php foreach ($mainNavItems as $item): ?>
                        <?php
                        // Get child items if any
                        $childItems = getChildMenuItems($item['id'], $pdo);
                        $hasChildren = !empty($childItems);
                        $isActive = isActiveLink($item['url'], $current_page);

                        // Check if any child is active
                        if (!$isActive && $hasChildren) {
                            foreach ($childItems as $child) {
                                if (isActiveLink($child['url'], $current_page)) {
                                    $isActive = true;
                                    break;
                                }
                            }
                        }
                        ?>

                        <li class="nav-item <?= $hasChildren ? 'dropdown' : '' ?>">
                            <?php if ($hasChildren): ?>
                                <a class="nav-link dropdown-toggle <?= $isActive ? 'active' : '' ?>"
                                   href="#" id="navDropdown<?= $item['id'] ?>"
                                   role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= htmlspecialchars($item["title_{$lang}"]) ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navDropdown<?= $item['id'] ?>">
                                    <?php foreach ($childItems as $child): ?>
                                        <li>
                                            <a class="dropdown-item <?= isActiveLink($child['url'], $current_page) ? 'active' : '' ?>"
                                               href="<?= htmlspecialchars($child['url']) ?>">
                                                <?= htmlspecialchars($child["title_{$lang}"]) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <a class="nav-link <?= $isActive ? 'active' : '' ?>"
                                   href="<?= htmlspecialchars($item['url']) ?>">
                                    <?= htmlspecialchars($item["title_{$lang}"]) ?>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- CTA Button -->
                <div class="d-flex">
                    <a href="#contact" class="btn btn-primary">
                        <?= $lang === 'ar' ? 'احصل على عرض سعر' : 'Get a Quote' ?>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>