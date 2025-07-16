<?php
session_start();
require_once 'config/db.php';

// Language switching
if (isset($_GET['lang']) && in_array($_GET['lang'], ['ar', 'en'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'ar';
$dir = $lang === 'ar' ? 'rtl' : 'ltr';

// Get category filter if set
$category = $_GET['category'] ?? '';

// Prepare blog query
if (empty($category) || $category === 'all') {
    $blogQuery = "SELECT * FROM blogs WHERE status = 'published' ";
    if ($lang === 'ar') {
        $blogQuery .= "AND title_ar != '' ";
    } else {
        $blogQuery .= "AND title_en != '' ";
    }
    $blogQuery .= "ORDER BY created_at DESC";
    $stmt = $pdo->prepare($blogQuery);
    $stmt->execute();
} else {
    $blogQuery = "SELECT * FROM blogs WHERE status = 'published' AND category = :category ";
    if ($lang === 'ar') {
        $blogQuery .= "AND title_ar != '' ";
    } else {
        $blogQuery .= "AND title_en != '' ";
    }
    $blogQuery .= "ORDER BY created_at DESC";
    $stmt = $pdo->prepare($blogQuery);
    $stmt->execute(['category' => $category]);
}

$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get blog categories
$catQuery = "SELECT DISTINCT category FROM blogs WHERE status = 'published' ORDER BY category";
$catStmt = $pdo->prepare($catQuery);
$catStmt->execute();
$categories = $catStmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $lang === 'ar' ? 'المدونة' : 'Blog' ?> - شركة انجاز النوادي للمقاولات العامة</title>
    <?php if ($lang === 'ar'): ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <?php else: ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link href="assets/css/site/style.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap');

        .hero {
            height: 40vh;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1470') center/cover no-repeat;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            text-shadow: 0 2px 10px rgba(0,0,0,0.7);
        }

        .section-title h2 {
            font-weight: bold;
            font-size: 2rem;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-title h2::before {
            content: '';
            width: 60px;
            height: 3px;
            background-color: #f39c12;
            position: absolute;
            bottom: -10px;
            right: 50%;
            transform: translateX(50%);
        }

        .filter-btn {
            margin: 0 8px;
        }

        .blog-card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: 0.3s;
            height: 100%;
        }

        .blog-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.1);
        }

        .blog-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .blog-body {
            padding: 20px;
        }

        .blog-body h5 {
            font-weight: 700;
            color: #333;
        }

        .blog-meta {
            font-size: 0.85rem;
            color: #999;
            margin-bottom: 10px;
        }

        .read-more {
            color: #f39c12;
            font-weight: 600;
            text-decoration: none;
        }

        .read-more:hover {
            color: #e67e22;
        }

        .empty-state {
            text-align: center;
            padding: 50px 0;
        }

        .empty-state i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-state h4 {
            color: #777;
            margin-bottom: 15px;
        }

        .empty-state p {
            color: #999;
            max-width: 500px;
            margin: 0 auto 20px;
        }
    </style>
</head>
<body>

<!-- Language Switcher -->
<div class="lang-switcher">
    <?php if ($lang === 'ar'): ?>
        <a href="?lang=en<?= !empty($category) ? '&category=' . urlencode($category) : '' ?>" class="btn btn-sm btn-outline-primary">English</a>
    <?php else: ?>
        <a href="?lang=ar<?= !empty($category) ? '&category=' . urlencode($category) : '' ?>" class="btn btn-sm btn-outline-primary">العربية</a>
    <?php endif; ?>
</div>

<!-- Navigation -->
<?php include 'includes/site/nav.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1><?= $lang === 'ar' ? 'المدونة' : 'Blog' ?></h1>
    </div>
</section>

<!-- Blog Section -->
<section class="py-5">
    <div class="container">
        <div class="section-title text-center mb-4" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'أحدث المقالات' : 'Latest Articles' ?></h2>
            <p class="text-muted"><?= $lang === 'ar' ? 'تابع جديد أخبار المشاريع والمقالات الفنية' : 'Follow the latest project news and technical articles' ?></p>
        </div>

        <!-- Filter Buttons -->
        <div class="text-center mb-4" data-aos="fade-up" data-aos-delay="100">
            <a href="?<?= $lang !== 'ar' ? 'lang=' . $lang . '&' : '' ?>category=all" class="btn <?= empty($category) || $category === 'all' ? 'btn-primary' : 'btn-outline-primary' ?> filter-btn">
                <?= $lang === 'ar' ? 'جميع الفئات' : 'All Categories' ?>
            </a>

            <?php foreach ($categories as $cat): ?>
                <a href="?<?= $lang !== 'ar' ? 'lang=' . $lang . '&' : '' ?>category=<?= urlencode($cat) ?>"
                   class="btn <?= $category === $cat ? 'btn-primary' : 'btn-outline-primary' ?> filter-btn">
                    <?= htmlspecialchars($cat) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Blog Grid -->
        <div class="row" id="blogContainer">
            <?php if (count($blogs) > 0): ?>
                <?php foreach ($blogs as $blog): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="blog-card" data-aos="fade-up">
                            <img src="admin/uploads/blogs/<?= htmlspecialchars($blog['featured_image']) ?>" alt="<?= htmlspecialchars($blog["title_{$lang}"]) ?>">
                            <div class="blog-body">
                                <div class="blog-meta">
                                    <i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($blog['created_at'])) ?> |
                                    <i class="far fa-folder"></i> <?= htmlspecialchars($blog['category']) ?>
                                </div>
                                <h5><?= htmlspecialchars($blog["title_{$lang}"]) ?></h5>
                                <p><?= substr(strip_tags($blog["excerpt_{$lang}"]), 0, 100) ?>...</p>
                                <a href="blog_details.php?id=<?= $blog['id'] ?><?= $lang !== 'ar' ? '&lang=' . $lang : '' ?>" class="read-more">
                                    <?= $lang === 'ar' ? 'اقرأ المزيد &larr;' : 'Read More &rarr;' ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state" data-aos="fade-up">
                        <i class="far fa-newspaper"></i>
                        <h4><?= $lang === 'ar' ? 'لا توجد مقالات في هذه الفئة' : 'No articles in this category' ?></h4>
                        <p><?= $lang === 'ar' ? 'لم يتم العثور على أي مقالات في هذه الفئة. يرجى تحديد فئة أخرى أو العودة لاحقاً.' : 'No articles were found in this category. Please select another category or check back later.' ?></p>
                        <a href="blog.php<?= $lang !== 'ar' ? '?lang=' . $lang : '' ?>" class="btn btn-primary">
                            <?= $lang === 'ar' ? 'عرض جميع المقالات' : 'View All Articles' ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include 'includes/site/footer.php'; ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true
    });
</script>
</body>
</html>