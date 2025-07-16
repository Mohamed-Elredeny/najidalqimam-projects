<?php
session_start();
require_once 'config/db.php';

// Language switching
if (isset($_GET['lang']) && in_array($_GET['lang'], ['ar', 'en'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'ar';
$dir = $lang === 'ar' ? 'rtl' : 'ltr';

// Get department ID from URL
$department_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch department details
$deptStmt = $pdo->prepare("SELECT * FROM departments WHERE id = ?");
$deptStmt->execute([$department_id]);
$department = $deptStmt->fetch(PDO::FETCH_ASSOC);

// If department not found, redirect to departments page
if (!$department) {
    header("Location: departments.php");
    exit;
}

// Fetch department features
$featuresStmt = $pdo->prepare("SELECT * FROM department_features WHERE department_id = ? ORDER BY `order`");
$featuresStmt->execute([$department_id]);
$features = $featuresStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch department benefits
$benefitsStmt = $pdo->prepare("SELECT * FROM department_benefits WHERE department_id = ? ORDER BY `order`");
$benefitsStmt->execute([$department_id]);
$benefits = $benefitsStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch projects related to this department
$projectsStmt = $pdo->prepare("SELECT * FROM projects WHERE department_id = ? AND status = 'completed' ORDER BY end_date DESC LIMIT 3");
$projectsStmt->execute([$department_id]);
$projects = $projectsStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch service icons
$serviceIconsStmt = $pdo->query("SELECT * FROM service_types ORDER BY `order` LIMIT 12");
$serviceIcons = $serviceIconsStmt->fetchAll(PDO::FETCH_ASSOC);

// Contact Info
$contacts = $pdo->query("SELECT * FROM contact_info")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($department["name_{$lang}"]) ?> - شركة ايجاز النوادي للمقاولات العامة</title>
    <!-- Bootstrap RTL/LTR CSS -->
    <?php if ($lang === 'ar'): ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <?php else: ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <?php endif; ?>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link href="assets/css/site/style.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap');

        /* Hero Section */
        .hero-section {
            position: relative;
            height: 40vh;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
            url('admin/uploads/departments/<?= htmlspecialchars($department['image']) ?>') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            overflow: hidden;
        }

        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.7);
        }

        .hero-section p {
            font-size: 1.2rem;
            margin-bottom: 20px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.7);
        }

        /* Service Icons */
        .service-icons {
            padding: 20px 0;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .service-icon-box {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            margin: 10px 0;
            height: 120px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .service-icon-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .service-icon-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .service-icon-box:hover img {
            transform: scale(1.1);
        }

        /* Featured Section */
        .featured-section {
            padding: 60px 0;
            position: relative;
        }

        .featured-img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        /* Department Title */
        .department-title {
            padding: 40px 0 0;
            text-align: center;
        }

        .department-title h2 {
            color: var(--primary-color);
            font-weight: 700;
            display: inline-block;
            position: relative;
            margin-bottom: 20px;
        }

        .department-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            margin: 0 auto;
            width: 100px;
            height: 3px;
            background-color: var(--primary-color);
        }

        /* Department Content */
        .department-content {
            padding: 40px 0;
        }

        .content-title {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            padding-<?= $lang === 'ar' ? 'right' : 'left' ?>: 15px;
        }

        .content-title::before {
            content: '';
            position: absolute;
            top: 0;
        <?= $lang === 'ar' ? 'right' : 'left' ?>: 0;
            width: 5px;
            height: 100%;
            background-color: var(--primary-color);
            border-radius: 2px;
        }

        .department-content p {
            margin-bottom: 20px;
            line-height: 1.8;
            color: #666;
            text-align: justify;
        }

        /* Department Benefits */
        .benefits-section {
            padding: 40px 0;
            background-color: #f9f9f9;
        }

        .benefits-title {
            color: var(--primary-color);
            font-weight: 700;
            text-align: center;
            margin-bottom: 40px;
        }

        .benefit-card {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
        }

        .benefit-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .benefit-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .benefit-title::after {
            content: '';
            position: absolute;
        <?= $lang === 'ar' ? 'right' : 'left' ?>: 0;
            bottom: -10px;
            width: 40px;
            height: 3px;
            background-color: var(--primary-color);
        }

        .benefit-card p {
            color: #666;
            line-height: 1.7;
        }

        /* Projects Section */
        .projects-section {
            padding: 60px 0;
        }

        .project-card {
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            height: 300px;
        }

        .project-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .project-card:hover img {
            transform: scale(1.1);
        }

        .project-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 60%, rgba(0,0,0,0) 100%);
            color: white;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .project-card:hover .project-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.6) 60%, rgba(0,0,0,0.3) 100%);
        }

        .project-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .project-location {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .project-tag {
            position: absolute;
            top: 15px;
        <?= $lang === 'ar' ? 'right' : 'left' ?>: 15px;
            background-color: var(--primary-color);
            color: white;
            padding: 5px 15px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 1;
        }

        @media (max-width: 991px) {
            .hero-section {
                height: 30vh;
            }

            .hero-section h1 {
                font-size: 2rem;
            }

            .featured-img {
                height: 300px;
                margin-bottom: 30px;
            }
        }

        @media (max-width: 767px) {
            .hero-section h1 {
                font-size: 1.8rem;
            }

            .service-icon-box {
                height: 100px;
            }

            .benefit-card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
<!-- Language Switcher -->
<div class="lang-switcher">
    <?php if ($lang === 'ar'): ?>
        <a href="?id=<?= $department_id ?>&lang=en" class="btn btn-sm btn-outline-primary">English</a>
    <?php else: ?>
        <a href="?id=<?= $department_id ?>&lang=ar" class="btn btn-sm btn-outline-primary">العربية</a>
    <?php endif; ?>
</div>

<!-- Navigation -->
<?php include 'includes/site/nav.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1><?= htmlspecialchars($department["name_{$lang}"]) ?></h1>
                <p><?= $lang === 'ar' ? 'الإحترافية - كفاءة الأداء' : 'Professionalism - Performance Efficiency' ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Service Icons -->
<section class="service-icons py-4">
    <div class="container">
        <div class="row">
            <?php foreach ($serviceIcons as $icon): ?>
                <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                    <div class="service-icon-box">
                        <img src="admin/uploads/service_types/<?= htmlspecialchars($icon['img']) ?>" alt="<?= htmlspecialchars($icon["title_{$lang}"]) ?>">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Section -->
<section class="featured-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <img src="admin/uploads/departments/<?= !empty($department['banner_image']) ? htmlspecialchars($department['banner_image']) : htmlspecialchars($department['image']) ?>" alt="<?= htmlspecialchars($department["name_{$lang}"]) ?>" class="featured-img">
            </div>
        </div>
    </div>
</section>

<!-- Department Title -->
<div class="department-title">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2><?= htmlspecialchars($department["name_{$lang}"]) ?></h2>
            </div>
        </div>
    </div>
</div>

<!-- Department Content -->
<section class="department-content">
    <div class="container">
        <?php
        $contentSections = [
            'design' => $lang === 'ar' ? 'التصميم' : 'Design',
            'construction' => $lang === 'ar' ? 'البناء' : 'Construction',
            'maintenance' => $lang === 'ar' ? 'الصيانة' : 'Maintenance',
            'quality' => $lang === 'ar' ? 'معايير الجودة والسلامة' : 'Quality and Safety Standards',
            'technology' => $lang === 'ar' ? 'التقنيات الحديثة' : 'Modern Technologies',
            'analysis' => $lang === 'ar' ? 'التحليل الاقتصادي والمالي' : 'Economic and Financial Analysis'
        ];

        foreach ($contentSections as $key => $title):
            $contentField = "content_{$key}_{$lang}";
            if (!empty($department[$contentField])):
                ?>
                <div class="row mb-5">
                    <div class="col-12">
                        <h3 class="content-title"><?= $title ?>:</h3>
                        <p><?= nl2br(htmlspecialchars($department[$contentField])) ?></p>
                    </div>
                </div>
            <?php
            endif;
        endforeach;
        ?>

        <?php if (!empty($department["content_extra_{$lang}"])): ?>
            <div class="row">
                <div class="col-12">
                    <h3 class="content-title"><?= $lang === 'ar' ? 'معلومات إضافية' : 'Additional Information' ?>:</h3>
                    <p><?= nl2br(htmlspecialchars($department["content_extra_{$lang}"])) ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Department Benefits -->
<?php if (count($benefits) > 0): ?>
    <section class="benefits-section">
        <div class="container">
            <h2 class="benefits-title mb-5"><?= $lang === 'ar' ? 'فوائد القسم' : 'Department Benefits' ?></h2>

            <div class="row">
                <?php foreach ($benefits as $benefit): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="benefit-card">
                            <h3 class="benefit-title"><?= htmlspecialchars($benefit["title_{$lang}"]) ?>:</h3>
                            <p><?= nl2br(htmlspecialchars($benefit["description_{$lang}"])) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Projects Section -->
<?php if (count($projects) > 0): ?>
    <section class="projects-section">
        <div class="container">
            <div class="section-title text-center mb-5" data-aos="fade-up">
                <h2><?= $lang === 'ar' ? 'المشاريع المنجزة' : 'Completed Projects' ?></h2>
                <p><?= $lang === 'ar' ? 'بعض المشاريع التي قمنا بتنفيذها في هذا القسم' : 'Some projects we have completed in this department' ?></p>
            </div>

            <div class="row">
                <?php foreach ($projects as $project): ?>
                    <div class="col-md-4" data-aos="fade-up">
                        <a href="project_details.php?id=<?= $project['id'] ?><?= $lang !== 'ar' ? '&lang=' . $lang : '' ?>" class="text-decoration-none">
                            <div class="project-card">
                                <img src="admin/uploads/projects/<?= htmlspecialchars($project['main_image']) ?>" alt="<?= htmlspecialchars($project["project_title_{$lang}"]) ?>">
                                <div class="project-tag"><?= htmlspecialchars($project["category_{$lang}"]) ?></div>
                                <div class="project-overlay">
                                    <h4 class="project-title"><?= htmlspecialchars($project["project_title_{$lang}"]) ?></h4>
                                    <p class="project-location"><?= htmlspecialchars($project["location_{$lang}"]) ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-4">
                <a href="projects.php?department=<?= $department_id ?><?= $lang !== 'ar' ? '&lang=' . $lang : '' ?>" class="btn btn-outline-primary">
                    <?= $lang === 'ar' ? 'عرض جميع المشاريع' : 'View All Projects' ?>
                </a>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2><?= $lang === 'ar' ? 'هل تبحث عن شريك موثوق لتنفيذ مشروعك؟' : 'Are you looking for a reliable partner to implement your project?' ?></h2>
                <p><?= $lang === 'ar' ? 'نحن هنا لتنفيذ مشروعك بأعلى معايير الجودة وبأسعار منافسة. تواصل معنا الآن للحصول على استشارة مجانية ودراسة أولية لمشروعك.' : 'We are here to implement your project with the highest quality standards and competitive prices. Contact us now for a free consultation and initial study of your project.' ?></p>
                <a href="contact.php" class="btn btn-cta"><?= $lang === 'ar' ? 'تواصل معنا الآن' : 'Contact Us Now' ?></a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include 'includes/site/footer.php'; ?>

<!-- Back to Top -->
<a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS Animation Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

<script>
    // Initialize AOS Animation
    AOS.init({
        duration: 1000,
        once: true
    });

    // Back to Top Button
    const backToTopButton = document.querySelector('.back-to-top');

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('active');
        } else {
            backToTopButton.classList.remove('active');
        }
    });

    backToTopButton.addEventListener('click', (e) => {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>
</body>
</html>