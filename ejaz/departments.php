<?php
session_start();
require_once 'config/db.php';

// Language switching
if (isset($_GET['lang']) && in_array($_GET['lang'], ['ar', 'en'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'ar';
$dir = $lang === 'ar' ? 'rtl' : 'ltr';

// Fetch departments from database
$departmentsStmt = $pdo->query("SELECT * FROM departments ORDER BY `order`");
$departments = $departmentsStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch service circles
$serviceTypesStmt = $pdo->query("SELECT * FROM service_types ORDER BY `order`");
$serviceTypes = $serviceTypesStmt->fetchAll(PDO::FETCH_ASSOC);

// Contact Info
$contacts = $pdo->query("SELECT * FROM contact_info")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang === 'ar' ? 'أقسامنا' : 'Our Departments' ?> - شركة ايجاز النوادي للمقاولات العامة</title>
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
        .hero-departments {
            position: relative;
            height: 50vh;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1470&auto=format&fit=crop') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            overflow: hidden;
        }

        .hero-departments::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
        }

        .hero-departments h1 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.7);
        }

        .hero-departments p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.7);
        }

        /* Department Circles */
        .department-circles {
            padding: 60px 0;
            background-color: #f9f9f9;
        }

        .circle-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .department-circle {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .department-circle:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .department-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .department-circle:hover img {
            transform: scale(1.1);
        }

        .department-circle::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0) 100%);
        }

        .department-circle-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            color: white;
            padding: 15px;
            z-index: 1;
        }

        .department-circle-content h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .department-circle::before {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            height: 5px;
            background-color: var(--primary-color);
            z-index: 2;
            border-radius: 5px;
        }

        /* Department Sections */
        .department-section {
            padding: 80px 0;
            position: relative;
        }

        .department-section:nth-child(even) {
            background-color: #f5f5f5;
        }

        .department-img {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            height: 400px;
        }

        .department-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .department-img:hover img {
            transform: scale(1.05);
        }

        .department-content {
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .department-content h2 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .department-content h2::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: -10px;
            width: 60px;
            height: 3px;
            background-color: var(--primary-color);
        }

        .department-content p {
            margin-bottom: 20px;
            line-height: 1.8;
            color: #666;
        }

        .department-features {
            margin-top: 20px;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-<?= $lang === 'ar' ? 'left' : 'right' ?>: 15px;
            color: white;
            flex-shrink: 0;
        }

        .feature-text {
            flex-grow: 1;
        }

        .feature-text h5 {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--dark-color);
        }

        /* Overlay Image */
        .overlay-image {
            position: absolute;
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .overlay-image.top-right {
            top: -30px;
            right: 50px;
            transform: rotate(8deg);
        }

        .overlay-image.bottom-left {
            bottom: -30px;
            left: 50px;
            transform: rotate(-8deg);
        }

        @media (max-width: 991px) {
            .hero-departments h1 {
                font-size: 2.5rem;
            }

            .department-img {
                margin-bottom: 30px;
                height: 300px;
            }

            .department-section .row {
                flex-direction: column-reverse;
            }

            .department-section:nth-child(odd) .row {
                flex-direction: column;
            }

            .overlay-image {
                display: none;
            }
        }

        @media (max-width: 767px) {
            .hero-departments h1 {
                font-size: 2rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .department-circle {
                width: 150px;
                height: 150px;
            }

            .department-circle-content h3 {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
<!-- Language Switcher -->
<div class="lang-switcher">
    <?php if ($lang === 'ar'): ?>
        <a href="?lang=en" class="btn btn-sm btn-outline-primary">English</a>
    <?php else: ?>
        <a href="?lang=ar" class="btn btn-sm btn-outline-primary">العربية</a>
    <?php endif; ?>
</div>

<!-- Navigation -->
<?php include 'includes/site/nav.php'; ?>

<!-- Hero Section -->
<section class="hero-departments">
    <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
        <h1><?= $lang === 'ar' ? 'أقسامنا' : 'Our Departments' ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="index.php"><?= $lang === 'ar' ? 'الرئيسية' : 'Home' ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $lang === 'ar' ? 'أقسامنا' : 'Our Departments' ?></li>
            </ol>
        </nav>
    </div>
</section>

<!-- Department Circles Section -->
<section class="department-circles">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'مجالات عملنا وأقسام المشاريع' : 'Our Work Fields and Project Departments' ?></h2>
            <p><?= $lang === 'ar' ? 'نتميز بتغطية شاملة لكافة مجالات المقاولات العامة' : 'We excel in comprehensive coverage of all general contracting fields' ?></p>
        </div>

        <div class="circle-container">
            <?php foreach ($serviceTypes as $index => $service): ?>
                <a href="#<?= strtolower(str_replace(' ', '-', $service["title_en"])) ?>" class="department-circle" data-aos="zoom-in" data-aos-delay="<?= ($index + 1) * 100 ?>">
                    <img src="admin/uploads/service_types/<?= htmlspecialchars($service['img']) ?>" alt="<?= htmlspecialchars($service["title_{$lang}"]) ?>">
                    <div class="department-circle-content">
                        <h3><?= htmlspecialchars($service["title_{$lang}"]) ?></h3>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Department Sections -->
<?php foreach ($departments as $index => $dept): ?>
    <section id="<?= strtolower(str_replace(' ', '-', $dept["name_en"])) ?>" class="department-section">
        <div class="container">
            <div class="row align-items-center">
                <?php if ($index % 2 == 0): ?>
                    <div class="col-lg-6" data-aos="fade-right">
                        <div class="department-img">
                            <img src="admin/uploads/departments/<?= htmlspecialchars($dept['image']) ?>" alt="<?= htmlspecialchars($dept["name_{$lang}"]) ?>">
                            <?php if (!empty($dept['image_overlay_1'])): ?>
                                <img src="admin/uploads/departments/<?= htmlspecialchars($dept['image_overlay_1']) ?>" alt="<?= htmlspecialchars($dept["name_{$lang}"]) ?>" class="overlay-image top-right">
                            <?php endif; ?>
                            <?php if (!empty($dept['image_overlay_2'])): ?>
                                <img src="admin/uploads/departments/<?= htmlspecialchars($dept['image_overlay_2']) ?>" alt="<?= htmlspecialchars($dept["name_{$lang}"]) ?>" class="overlay-image bottom-left">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <div class="department-content">
                            <h2><?= htmlspecialchars($dept["name_{$lang}"]) ?></h2>
                            <p><?= nl2br(htmlspecialchars($dept["description_{$lang}"])) ?></p>

                            <?php
                            // Fetch features for this department
                            $featuresStmt = $pdo->prepare("SELECT * FROM department_features WHERE department_id = ? ORDER BY `order`");
                            $featuresStmt->execute([$dept['id']]);
                            $features = $featuresStmt->fetchAll(PDO::FETCH_ASSOC);

                            if (count($features) > 0):
                                ?>
                                <div class="department-features">
                                    <?php foreach ($features as $feature): ?>
                                        <div class="feature-item">
                                            <div class="feature-icon">
                                                <i class="<?= htmlspecialchars($feature['icon']) ?>"></i>
                                            </div>
                                            <div class="feature-text">
                                                <h5><?= htmlspecialchars($feature["title_{$lang}"]) ?></h5>
                                                <p><?= htmlspecialchars($feature["description_{$lang}"]) ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <a href="department_details.php?id=<?= $dept['id'] ?><?= $lang !== 'ar' ? '&lang=' . $lang : '' ?>" class="btn btn-primary mt-3">
                                <?= $lang === 'ar' ? 'المزيد من التفاصيل' : 'More Details' ?>
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-lg-6" data-aos="fade-right">
                        <div class="department-content">
                            <h2><?= htmlspecialchars($dept["name_{$lang}"]) ?></h2>
                            <p><?= nl2br(htmlspecialchars($dept["description_{$lang}"])) ?></p>

                            <?php
                            // Fetch features for this department
                            $featuresStmt = $pdo->prepare("SELECT * FROM department_features WHERE department_id = ? ORDER BY `order`");
                            $featuresStmt->execute([$dept['id']]);
                            $features = $featuresStmt->fetchAll(PDO::FETCH_ASSOC);

                            if (count($features) > 0):
                                ?>
                                <div class="department-features">
                                    <?php foreach ($features as $feature): ?>
                                        <div class="feature-item">
                                            <div class="feature-icon">
                                                <i class="<?= htmlspecialchars($feature['icon']) ?>"></i>
                                            </div>
                                            <div class="feature-text">
                                                <h5><?= htmlspecialchars($feature["title_{$lang}"]) ?></h5>
                                                <p><?= htmlspecialchars($feature["description_{$lang}"]) ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <a href="department_details.php?id=<?= $dept['id'] ?><?= $lang !== 'ar' ? '&lang=' . $lang : '' ?>" class="btn btn-primary mt-3">
                                <?= $lang === 'ar' ? 'المزيد من التفاصيل' : 'More Details' ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <div class="department-img">
                            <img src="admin/uploads/departments/<?= htmlspecialchars($dept['image']) ?>" alt="<?= htmlspecialchars($dept["name_{$lang}"]) ?>">
                            <?php if (!empty($dept['image_overlay_1'])): ?>
                                <img src="admin/uploads/departments/<?= htmlspecialchars($dept['image_overlay_1']) ?>" alt="<?= htmlspecialchars($dept["name_{$lang}"]) ?>" class="overlay-image top-right">
                            <?php endif; ?>
                            <?php if (!empty($dept['image_overlay_2'])): ?>
                                <img src="admin/uploads/departments/<?= htmlspecialchars($dept['image_overlay_2']) ?>" alt="<?= htmlspecialchars($dept["name_{$lang}"]) ?>" class="overlay-image bottom-left">
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endforeach; ?>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2 data-aos="fade-up"><?= $lang === 'ar' ? 'هل تبحث عن شريك موثوق لتنفيذ مشروعك؟' : 'Are you looking for a reliable partner to implement your project?' ?></h2>
        <p data-aos="fade-up" data-aos-delay="100"><?= $lang === 'ar' ? 'نحن هنا لتنفيذ مشروعك بأعلى معايير الجودة وبأسعار منافسة. تواصل معنا الآن للحصول على استشارة مجانية ودراسة أولية لمشروعك.' : 'We are here to implement your project with the highest quality standards and competitive prices. Contact us now for a free consultation and initial study of your project.' ?></p>
        <a href="contact.php" class="btn btn-cta" data-aos="fade-up" data-aos-delay="200"><?= $lang === 'ar' ? 'تواصل معنا الآن' : 'Contact Us Now' ?></a>
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

    // Smooth Scrolling for Navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 70,
                    behavior: 'smooth'
                });}
        });
    });
</script>
</body>
</html>