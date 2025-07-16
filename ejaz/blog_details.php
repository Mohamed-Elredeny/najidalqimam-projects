<?php
session_start();
require_once 'config/db.php';

// Language switching
if (isset($_GET['lang']) && in_array($_GET['lang'], ['ar', 'en'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'ar';
$dir = $lang === 'ar' ? 'rtl' : 'ltr';

// Get blog ID from URL
$blog_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch blog details
$blogStmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ? AND status = 'published'");
$blogStmt->execute([$blog_id]);
$blog = $blogStmt->fetch(PDO::FETCH_ASSOC);

// If blog not found, redirect to blog page
if (!$blog) {
    header("Location: blog.php");
    exit;
}

// Fetch recent posts for sidebar
$recentPostsStmt = $pdo->prepare("SELECT id, title_ar, title_en, featured_image, created_at FROM blogs 
                                   WHERE id != ? AND status = 'published' 
                                   ORDER BY created_at DESC LIMIT 5");
$recentPostsStmt->execute([$blog_id]);
$recentPosts = $recentPostsStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch related posts (same category)
$relatedPostsStmt = $pdo->prepare("SELECT id, title_ar, title_en, featured_image, created_at FROM blogs 
                                    WHERE id != ? AND category = ? AND status = 'published' 
                                    ORDER BY created_at DESC LIMIT 3");
$relatedPostsStmt->execute([$blog_id, $blog['category']]);
$relatedPosts = $relatedPostsStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch categories for sidebar
$categoriesStmt = $pdo->prepare("SELECT category, COUNT(*) as count FROM blogs 
                                 WHERE status = 'published' GROUP BY category ORDER BY category");
$categoriesStmt->execute();
$categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

// Format date
function formatDate($date, $lang) {
    if ($lang === 'ar') {
        $months = [
            'يناير', 'فبراير', 'مارس', 'إبريل', 'مايو', 'يونيو',
            'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'
        ];
        $timestamp = strtotime($date);
        return date('d', $timestamp) . ' ' . $months[date('n', $timestamp) - 1] . ' ' . date('Y', $timestamp);
    } else {
        return date('F j, Y', strtotime($date));
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($blog["title_{$lang}"]) ?> - شركة انجاز النوادي للمقاولات العامة</title>
    <?php if ($lang === 'ar'): ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <?php else: ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link href="assets/css/site/style.css" rel="stylesheet">
    <style>
        /* Hero Section */
        .blog-hero {
            position: relative;
            height: 50vh;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
            url('admin/uploads/blogs/<?= htmlspecialchars($blog['featured_image']) ?>') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .blog-hero-content {
            max-width: 800px;
            padding: 0 15px;
        }

        .blog-hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .blog-meta {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .blog-meta span {
            margin: 0 10px;
        }

        /* Blog Content */
        .blog-content {
            padding: 60px 0;
        }

        .blog-main {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .blog-text {
            line-height: 1.8;
            color: #444;
        }

        .blog-text p {
            margin-bottom: 20px;
        }

        .blog-text img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 20px 0;
        }

        .blog-tags {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .blog-tag {
            display: inline-block;
            background: #f5f5f5;
            color: #666;
            padding: 5px 15px;
            border-radius: 30px;
            margin-right: 10px;
            margin-bottom: 10px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .blog-tag:hover {
            background: #f39c12;
            color: white;
        }

        /* Sidebar */
        .blog-sidebar {
            position: sticky;
            top: 100px;
        }

        .sidebar-box {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .sidebar-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f39c12;
            position: relative;
        }

        .sidebar-search {
            position: relative;
        }

        .sidebar-search input {
            width: 100%;
            padding: 10px 15px;
            border-radius: 30px;
            border: 1px solid #ddd;
            padding-<?= $lang === 'ar' ? 'left' : 'right' ?>: 40px;
        }

        .sidebar-search button {
            position: absolute;
        <?= $lang === 'ar' ? 'left' : 'right' ?>: 5px;
            top: 5px;
            background: none;
            border: none;
            color: #999;
            font-size: 1.2rem;
        }

        .categories-list {
            list-style: none;
            padding: 0;
        }

        .categories-list li {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .categories-list li:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .categories-list a {
            color: #444;
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            transition: all 0.3s;
        }

        .categories-list a:hover {
            color: #f39c12;
        }

        .categories-list .count {
            background: #f5f5f5;
            color: #999;
            border-radius: 30px;
            padding: 2px 10px;
            font-size: 0.8rem;
        }

        .recent-post {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .recent-post:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .recent-post-img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            margin-<?= $lang === 'ar' ? 'left' : 'right' ?>: 15px;
            flex-shrink: 0;
        }

        .recent-post-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .recent-post-info h6 {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .recent-post-info h6 a {
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
        }

        .recent-post-info h6 a:hover {
            color: #f39c12;
        }

        .recent-post-date {
            font-size: 0.8rem;
            color: #999;
        }

        /* Related Posts */
        .related-posts {
            padding: 60px 0;
            background: #f9f9f9;
        }

        .related-post-card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
            transition: all 0.3s;
        }

        .related-post-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .related-post-img {
            height: 200px;
            overflow: hidden;
        }

        .related-post-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s;
        }

        .related-post-card:hover .related-post-img img {
            transform: scale(1.1);
        }

        .related-post-content {
            padding: 20px;
        }

        .related-post-date {
            font-size: 0.8rem;
            color: #999;
            margin-bottom: 10px;
        }

        .related-post-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .related-post-title a {
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
        }

        .related-post-title a:hover {
            color: #f39c12;
        }

        /* Share Buttons */
        .share-buttons {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .share-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin: 0 5px;
            color: white;
            transition: all 0.3s;
        }

        .share-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        .share-btn.facebook {
            background: #3b5998;
        }

        .share-btn.twitter {
            background: #1da1f2;
        }

        .share-btn.linkedin {
            background: #0077b5;
        }

        .share-btn.whatsapp {
            background: #25d366;
        }

        @media (max-width: 991px) {
            .blog-sidebar {
                margin-top: 50px;
            }
        }

        @media (max-width: 767px) {
            .blog-hero h1 {
                font-size: 2rem;
            }

            .blog-main {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<!-- Language Switcher -->
<div class="lang-switcher">
    <?php if ($lang === 'ar'): ?>
        <a href="?id=<?= $blog_id ?>&lang=en" class="btn btn-sm btn-outline-primary">English</a>
    <?php else: ?>
        <a href="?id=<?= $blog_id ?>&lang=ar" class="btn btn-sm btn-outline-primary">العربية</a>
    <?php endif; ?>
</div>

<!-- Navigation -->
<?php include 'includes/site/nav.php'; ?>

<!-- Blog Hero -->
<section class="blog-hero">
    <div class="blog-hero-content">
        <h1><?= htmlspecialchars($blog["title_{$lang}"]) ?></h1>
        <div class="blog-meta">
            <span><i class="far fa-calendar-alt"></i> <?= formatDate($blog['created_at'], $lang) ?></span>
            <span><i class="far fa-folder"></i> <?= htmlspecialchars($blog['category']) ?></span>
            <span><i class="far fa-user"></i> <?= htmlspecialchars($blog['author']) ?></span>
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="blog-content">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="blog-main">
                    <div class="blog-text">
                        <?= $blog["content_{$lang}"] ?>

                        <?php if (!empty($blog['tags'])): ?>
                        <div class="blog-tags">
                            <strong><?= $lang === 'ar' ? 'الوسوم:' : 'Tags:' ?></strong>
                            <?php foreach (explode(',', $blog['tags']) as $tag): ?>
                                <a href="blog.php?<?= $lang !== 'ar' ? 'lang=' . $lang . '&' : '' ?>tag=<?= urlencode(trim($tag)) ?>" class="blog-tag">
                                    <?= htmlspecialchars(trim($tag)) ?>
                                </a>
                            <?php endforeach; ?>
                        </div><?php endif; ?>
                    </div>

                    <!-- Share Buttons -->
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" target="_blank" class="share-btn facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>&text=<?= urlencode($blog["title_{$lang}"]) ?>" target="_blank" class="share-btn twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>&title=<?= urlencode($blog["title_{$lang}"]) ?>" target="_blank" class="share-btn linkedin">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text=<?= urlencode($blog["title_{$lang}"] . ' - https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" target="_blank" class="share-btn whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="blog-sidebar">
                    <!-- Search Box -->
                    <div class="sidebar-box">
                        <h4 class="sidebar-title"><?= $lang === 'ar' ? 'بحث' : 'Search' ?></h4>
                        <form action="blog.php" method="get" class="sidebar-search">
                            <?php if ($lang !== 'ar'): ?>
                                <input type="hidden" name="lang" value="<?= $lang ?>">
                            <?php endif; ?>
                            <input type="text" name="search" placeholder="<?= $lang === 'ar' ? 'ابحث هنا...' : 'Search here...' ?>">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>

                    <!-- Categories -->
                    <div class="sidebar-box">
                        <h4 class="sidebar-title"><?= $lang === 'ar' ? 'الفئات' : 'Categories' ?></h4>
                        <ul class="categories-list">
                            <?php foreach ($categories as $category): ?>
                                <li>
                                    <a href="blog.php?<?= $lang !== 'ar' ? 'lang=' . $lang . '&' : '' ?>category=<?= urlencode($category['category']) ?>">
                                        <?= htmlspecialchars($category['category']) ?>
                                        <span class="count"><?= $category['count'] ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Recent Posts -->
                    <div class="sidebar-box">
                        <h4 class="sidebar-title"><?= $lang === 'ar' ? 'أحدث المقالات' : 'Recent Posts' ?></h4>
                        <?php foreach ($recentPosts as $post): ?>
                            <div class="recent-post">
                                <div class="recent-post-img">
                                    <img src="admin/uploads/blogs/<?= htmlspecialchars($post['featured_image']) ?>" alt="<?= htmlspecialchars($post["title_{$lang}"]) ?>">
                                </div>
                                <div class="recent-post-info">
                                    <h6>
                                        <a href="blog_details.php?id=<?= $post['id'] ?><?= $lang !== 'ar' ? '&lang=' . $lang : '' ?>">
                                            <?= htmlspecialchars($post["title_{$lang}"]) ?>
                                        </a>
                                    </h6>
                                    <div class="recent-post-date">
                                        <i class="far fa-calendar-alt"></i> <?= formatDate($post['created_at'], $lang) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Posts -->
<?php if (count($relatedPosts) > 0): ?>
    <section class="related-posts">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2><?= $lang === 'ar' ? 'مقالات ذات صلة' : 'Related Posts' ?></h2>
            </div>

            <div class="row">
                <?php foreach ($relatedPosts as $related): ?>
                    <div class="col-md-4 mb-4">
                        <div class="related-post-card">
                            <div class="related-post-img">
                                <img src="admin/uploads/blogs/<?= htmlspecialchars($related['featured_image']) ?>" alt="<?= htmlspecialchars($related["title_{$lang}"]) ?>">
                            </div>
                            <div class="related-post-content">
                                <div class="related-post-date">
                                    <i class="far fa-calendar-alt"></i> <?= formatDate($related['created_at'], $lang) ?>
                                </div>
                                <h5 class="related-post-title">
                                    <a href="blog_details.php?id=<?= $related['id'] ?><?= $lang !== 'ar' ? '&lang=' . $lang : '' ?>">
                                        <?= htmlspecialchars($related["title_{$lang}"]) ?>
                                    </a>
                                </h5>
                                <a href="blog_details.php?id=<?= $related['id'] ?><?= $lang !== 'ar' ? '&lang=' . $lang : '' ?>" class="read-more">
                                    <?= $lang === 'ar' ? 'اقرأ المزيد &larr;' : 'Read More &rarr;' ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

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