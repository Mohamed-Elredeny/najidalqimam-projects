<?php
session_start();
require_once 'config/db.php';

// Language switching
if (isset($_GET['lang']) && in_array($_GET['lang'], ['ar', 'en'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'ar';
$dir = $lang === 'ar' ? 'rtl' : 'ltr';

// Fetch all dynamic sections
// Hero
$heroStmt = $pdo->prepare("SELECT * FROM hero WHERE id=1");
$heroStmt->execute();
$hero = $heroStmt->fetch(PDO::FETCH_ASSOC) ?: [];

// Services Intro
$introStmt = $pdo->prepare("SELECT * FROM services_intro WHERE id=1");
$introStmt->execute();
$intro = $introStmt->fetch(PDO::FETCH_ASSOC) ?: [];

// Services Grid
$services = $pdo->query("SELECT * FROM services ORDER BY `order`")->fetchAll(PDO::FETCH_ASSOC);

// Service Types
$types = $pdo->query("SELECT * FROM service_types ORDER BY `order`")->fetchAll(PDO::FETCH_ASSOC);

// About Texts
$aboutTexts = $pdo->query("SELECT * FROM about_texts ORDER BY `order`")->fetchAll(PDO::FETCH_ASSOC);

// Counters
$counters = $pdo->query("SELECT * FROM counters ORDER BY `order`")->fetchAll(PDO::FETCH_ASSOC);

// Projects
$projects = $pdo->query("SELECT * FROM projects ORDER BY `id` LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);

// Equipment
$equipment = $pdo->query("SELECT * FROM equipment ORDER BY `order`")->fetchAll(PDO::FETCH_ASSOC);

// Partners
$partners = $pdo->query("SELECT * FROM partners ORDER BY `order`")->fetchAll(PDO::FETCH_ASSOC);

// Contact Info
$contacts = $pdo->query("SELECT * FROM contact_info")->fetchAll(PDO::FETCH_ASSOC);

// Service Options
$options = $pdo->query("SELECT * FROM service_options")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= htmlspecialchars($hero["title_{$lang}"] ?? ''); ?></title>
    <!-- Fixed Bootstrap CSS loading -->
    <?php if ($lang === 'ar'): ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <?php else: ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php endif; ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="assets/css/site/style.css" rel="stylesheet">
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

<!-- Hero -->
<section id="hero" class="hero">
    <div class="hero-content" data-aos="fade-up">
        <h1><?= htmlspecialchars($hero["title_{$lang}"] ?? ''); ?></h1>
        <p><?= htmlspecialchars($hero["subtitle_{$lang}"] ?? ''); ?></p>
        <a href="<?= htmlspecialchars($hero['btn_url'] ?? '#'); ?>" class="btn btn-primary btn-lg">
            <?= htmlspecialchars($hero["btn_text_{$lang}"] ?? ''); ?>
        </a>
    </div>
</section>

<!-- Services Intro -->
<section id="services-intro" class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="intro-images-container d-flex" style="height:350px">
                    <?php for ($i = 1; $i <= 3; $i++):
                        $key = "img{$i}";
                        if (!empty($intro[$key])):
                            ?>
                            <div class="intro-image-wrapper me-2" style="flex:1;overflow:hidden;border-radius:15px">
                                <img src="<?= htmlspecialchars($intro[$key]) ?>"
                                     style="width:100%;height:100%;object-fit:cover"
                                     alt="">
                            </div>
                        <?php endif; endfor; ?>
                </div>
            </div>
            <div class="col-lg-6 text-<?= $lang === 'ar' ? 'end' : 'start' ?>">
                <h2 class="mb-4 fw-bold text-primary">
                    <?= $lang === 'ar'
                        ? 'شركة ايجاز البوادي للمقاولات العامة'
                        : 'Egaz Al‑Bawadi General Contracting Co.' ?>
                </h2>
                <p class="mb-3"><?= nl2br(htmlspecialchars($intro["content_{$lang}"] ?? '')); ?></p>
                <a href="#" class="btn btn-primary">
                    <?= $lang === 'ar' ? 'عرض الكل' : 'View All'; ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section id="services" class="services py-5 bg-light">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'خدماتنا' : 'Our Services'; ?></h2>
        </div>
        <div class="row">
            <?php foreach ($services as $s): ?>
                <div class="col-md-4 mb-4" data-aos="fade-up">
                    <div class="service-card">
                        <img src="<?= htmlspecialchars($s['img']) ?>" alt="">
                        <h3><?= htmlspecialchars($s["title_{$lang}"]) ?></h3>
                        <p><?= htmlspecialchars($s["desc_{$lang}"]) ?></p>
                        <a href="<?= htmlspecialchars($s['url']) ?>" class="btn btn-sm btn-outline-primary">
                            <?= $lang === 'ar' ? 'المزيد' : 'More'; ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Service Types -->
<section class="service-types py-5">
    <div class="container text-center">
        <div class="section-title" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'مجالات عملنا' : 'Our Fields'; ?></h2>
        </div>
        <div class="row justify-content-center">
            <?php foreach ($types as $t): ?>
                <div class="col" data-aos="zoom-in">
                    <div class="service-circle">
                        <img src="<?= htmlspecialchars($t['img']) ?>" alt="">
                        <h4><?= htmlspecialchars($t["title_{$lang}"]) ?></h4>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- About -->
<section id="about" class="about py-5 bg-light">
    <div class="container">
        <div class="about-content" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'قصة نجاحنا' : 'Our Story'; ?></h2>
            <?php foreach ($aboutTexts as $p): ?>
                <p><?= htmlspecialchars($p["paragraph_{$lang}"]) ?></p>
            <?php endforeach; ?>
            <div class="row mt-4">
                <?php foreach ($counters as $c): ?>
                    <div class="col-md-3 col-6 text-center mb-4">
                        <i class="fas <?= htmlspecialchars($c['icon']) ?> fa-3x text-primary mb-2"></i>
                        <h2><?= (int)$c['value'] ?></h2>
                        <p><?= htmlspecialchars($c["label_{$lang}"]) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Projects -->
<section id="projects" class="projects py-5">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'مشاريعنا' : 'Our Projects'; ?></h2>
        </div>
        <div class="row">
            <?php foreach ($projects as $pr): ?>
                <a class="col-md-4 mb-4" data-aos="fade-up" href="project_details.php?id=<?= $pr['id'] ?>&lang=<?= $lang ?>" target="_blank">
                    <div class="project-card">
                        <img src="<?= htmlspecialchars($pr['main_image']) ?>" alt="">
                        <div class="project-tag"><?= htmlspecialchars($pr["meta_description_{$lang}"]) ?></div>
                        <div class="project-overlay">
                            <h4><?= htmlspecialchars($pr["project_title_{$lang}"]) ?></h4>
                            <p><?= htmlspecialchars($pr["location_{$lang}"]) ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Equipment -->
<section class="equipment py-5 bg-light">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'معداتنا' : 'Our Equipment'; ?></h2>
        </div>
        <div class="equipment-grid">
            <?php foreach ($equipment as $e): ?>
                <div class="equipment-item" data-aos="fade-up">
                    <img src="<?= htmlspecialchars($e['img']) ?>" alt="">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Partners -->
<section class="partners py-5">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'شركاؤنا' : 'Our Partners'; ?></h2>
        </div>
        <div class="partners-logos">
            <?php foreach ($partners as $p): ?>
                <img src="<?= htmlspecialchars($p['img']) ?>" alt="<?= htmlspecialchars($p['alt']) ?>"
                     class="partner-logo" data-aos="fade-up">
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Contact -->
<section id="contact" class="contact py-5 bg-light">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'اتصل بنا' : 'Contact Us'; ?></h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-5" data-aos="fade-up">
                <div class="contact-info p-4 bg-white rounded shadow-sm">
                    <?php foreach ($contacts as $c): ?>
                        <div class="d-flex mb-3">
                            <i class="fas <?= htmlspecialchars($c['icon']) ?> fa-2x text-primary me-3"></i>
                            <div>
                                <h6><?= htmlspecialchars($c["label_{$lang}"]) ?></h6>
                                <p class="mb-0"><?= htmlspecialchars($c['value']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-up">
                <form action="services/site/send_message.php" method="post"
                      class="contact-form p-4 bg-white rounded shadow-sm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control"
                                   placeholder="<?= $lang === 'ar' ? 'الاسم الكامل' : 'Full Name'; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <input type="tel" name="phone" class="form-control"
                                   placeholder="<?= $lang === 'ar' ? 'رقم الجوال' : 'Phone'; ?>">
                        </div>
                        <div class="col-12">
                            <input type="email" name="email" class="form-control"
                                   placeholder="<?= $lang === 'ar' ? 'البريد الإلكتروني' : 'Email'; ?>" required>
                        </div>
                        <div class="col-12">
                            <select name="service" class="form-select" required>
                                <option value=""><?= $lang === 'ar' ? 'اختر الخدمة' : 'Select Service'; ?></option>
                                <?php foreach ($options as $o): ?>
                                    <option value="<?= htmlspecialchars($o['value']) ?>">
                                        <?= htmlspecialchars($o["label_{$lang}"]) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <textarea name="message" rows="5" class="form-control"
                                      placeholder="<?= $lang === 'ar' ? 'تفاصيل المشروع' : 'Project Details'; ?>"></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit"
                                    class="btn btn-primary"><?= $lang === 'ar' ? 'إرسال' : 'Send Message'; ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include 'includes/site/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({duration: 1000, once: true});
</script>
</body>
</html>