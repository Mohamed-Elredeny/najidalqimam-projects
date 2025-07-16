<?php
session_start();
require_once 'config/db.php';

// Language switching
if (isset($_GET['lang']) && in_array($_GET['lang'], ['ar', 'en'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'ar';
$dir = $lang === 'ar' ? 'rtl' : 'ltr';

// Fetch about content from database
// About Texts
$aboutTexts = $pdo->query("SELECT * FROM about_texts ORDER BY `order`")->fetchAll(PDO::FETCH_ASSOC);

// Counters
$counters = $pdo->query("SELECT * FROM counters ORDER BY `order`")->fetchAll(PDO::FETCH_ASSOC);

// Vision, Mission, Values
$vmvStmt = $pdo->prepare("SELECT * FROM company_vmv WHERE id=1");
$vmvStmt->execute();
$vmv = $vmvStmt->fetch(PDO::FETCH_ASSOC) ?: [];

// Team Members
$team = $pdo->query("SELECT * FROM team_members ORDER BY `id`")->fetchAll(PDO::FETCH_ASSOC);

// Timeline
$timeline = $pdo->query("SELECT * FROM company_timeline ORDER BY `year` ASC")->fetchAll(PDO::FETCH_ASSOC);

// Certificates
$certificates = $pdo->query("SELECT * FROM certificates ORDER BY `order`")->fetchAll(PDO::FETCH_ASSOC);

// Clients/Partners
$clients = $pdo->query("SELECT * FROM partners ORDER BY `order`")->fetchAll(PDO::FETCH_ASSOC);

// Contact Info
$contacts = $pdo->query("SELECT * FROM contact_info")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang === 'ar' ? 'من نحن' : 'About Us' ?> - شركة انجاز النوادي للمقاولات العامة</title>
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
        .hero-about {
            position: relative;
            height: 50vh;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1606836576983-8b458e75221d?q=80&w=1470&auto=format&fit=crop') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            overflow: hidden;
        }

        .hero-about::before {
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

        .hero-about h1 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.7);
        }

        .hero-about p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.7);
        }

        /* About Section Styling */
        .about-section {
            padding: 80px 0;
        }

        .about-content h3 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .about-content h3::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: -10px;
            width: 50px;
            height: 3px;
            background-color: var(--primary-color);
        }

        .about-content p {
            margin-bottom: 20px;
            line-height: 1.8;
        }

        .about-img {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .about-img img {
            width: 100%;
            height: auto;
            transition: all 0.5s ease;
        }

        .about-img:hover img {
            transform: scale(1.05);
        }

        /* Vision Mission Values */
        .vmv-section {
            padding: 80px 0;
            background-color: #f5f5f5;
        }

        .vmv-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
        }

        .vmv-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .vmv-card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .vmv-card-header i {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .vmv-card-header h3 {
            font-weight: 700;
            margin-bottom: 0;
        }

        .vmv-card-body {
            padding: 30px;
        }

        .vmv-card-body p {
            margin-bottom: 0;
            line-height: 1.7;
        }

        /* Team Section */
        .team-section {
            padding: 80px 0;
        }

        .team-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .team-img {
            position: relative;
            overflow: hidden;
        }

        .team-img img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .team-card:hover .team-img img {
            transform: scale(1.1);
        }

        .team-info {
            padding: 20px;
            text-align: center;
        }

        .team-info h4 {
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--dark-color);
        }

        .team-info p {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 15px;
        }

        .team-social {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        .team-social a {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-color);
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .team-social a:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }

        /* Timeline Section */
        .timeline-section {
            padding: 80px 0;
            background-color: #f5f5f5;
        }

        .timeline {
            position: relative;
            padding: 40px 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            width: 3px;
            background-color: var(--primary-color);
            top: 0;
            bottom: 0;
            right: 50%;
            margin-right: -1.5px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 50px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-icon {
            position: absolute;
            width: 50px;
            height: 50px;
            right: 50%;
            margin-right: -25px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            z-index: 2;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .timeline-content {
            position: relative;
            width: 45%;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .timeline-item:nth-child(odd) .timeline-content {
            margin-left: auto;
        }

        .timeline-date {
            position: absolute;
            top: 20px;
            color: var(--primary-color);
            font-weight: 600;
        }

        .timeline-item:nth-child(odd) .timeline-date {
            right: 120%;
        }

        .timeline-item:nth-child(even) .timeline-date {
            left: 120%;
        }

        .timeline-content h4 {
            margin-top: 30px;
            margin-bottom: 15px;
            font-weight: 700;
            color: var(--dark-color);
        }

        .timeline-content p {
            margin-bottom: 0;
            line-height: 1.7;
        }

        /* Stats Section */
        .stats-section {
            padding: 80px 0;
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?q=80&w=1470&auto=format&fit=crop') center/cover no-repeat fixed;
            color: white;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
        }

        .stat-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .stat-num {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-text {
            font-weight: 600;
        }

        /* Certificates */
        .certificate-item {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .certificate-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .certificate-img {
            overflow: hidden;
        }

        .certificate-img img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .certificate-item:hover .certificate-img img {
            transform: scale(1.1);
        }

        .certificate-info {
            padding: 20px;
        }

        .certificate-info h4 {
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--dark-color);
        }

        .certificate-info p {
            margin-bottom: 0;
            line-height: 1.7;
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
<section class="hero-about">
    <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
        <h1><?= $lang === 'ar' ? 'من نحن' : 'About Us' ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="index.php"><?= $lang === 'ar' ? 'الرئيسية' : 'Home' ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $lang === 'ar' ? 'من نحن' : 'About Us' ?></li>
            </ol>
        </nav>
    </div>
</section>

<!-- About Section -->
<section class="about-section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'قصة نجاحنا' : 'Our Success Story' ?></h2>
            <p><?= $lang === 'ar' ? 'تعرف على مسيرة نجاح شركة انجاز النوادي للمقاولات العامة' : 'Learn about the success journey of Injaz Al-Nawadi General Contracting Co.' ?></p>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                <div class="about-content">
                    <h3><?= $lang === 'ar' ? 'خبرة تزيد عن 15 عاماً' : 'Experience of over 15 years' ?></h3>
                    <?php foreach ($aboutTexts as $text): ?>
                        <p><?= htmlspecialchars($text["paragraph_{$lang}"]) ?></p>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="about-img">
                    <img src="https://images.unsplash.com/photo-1586996292898-71f4036c4e07?q=80&w=1000&auto=format&fit=crop" alt="<?= $lang === 'ar' ? 'مشروع بناء' : 'Construction Project' ?>">
                </div>
                <div class="row mt-4">
                    <div class="col-6">
                        <div class="about-img">
                            <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1000&auto=format&fit=crop" alt="<?= $lang === 'ar' ? 'مبنى تجاري' : 'Commercial Building' ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="about-img">
                            <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1000&auto=format&fit=crop" alt="<?= $lang === 'ar' ? 'مشروع سكني' : 'Residential Project' ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'فريق العمل' : 'Our Team' ?></h2>
            <p><?= $lang === 'ar' ? 'نفخر بفريقنا المتميز من المهندسين والفنيين ذوي الخبرة العالية' : 'We are proud of our distinguished team of highly experienced engineers and technicians' ?></p>
        </div>

        <div class="row">
            <?php foreach ($team as $index => $member): ?>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>">
                    <div class="team-card">
                        <div class="team-img">
                            <img src="admin/uploads/team/<?= htmlspecialchars($member['image']) ?>" alt="<?= htmlspecialchars($member["name_{$lang}"]) ?>">
                        </div>
                        <div class="team-info">
                            <h4><?= htmlspecialchars($member["name_{$lang}"]) ?></h4>
                            <p><?= htmlspecialchars($member["position_{$lang}"]) ?></p>
                            <p class="small"><?= htmlspecialchars($member["bio_{$lang}"]) ?></p>
                            <div class="team-social">
                                <?php if (!empty($member['linkedin'])): ?>
                                    <a href="<?= htmlspecialchars($member['linkedin']) ?>"><i class="fab fa-linkedin-in"></i></a>
                                <?php endif; ?>
                                <?php if (!empty($member['twitter'])): ?>
                                    <a href="<?= htmlspecialchars($member['twitter']) ?>"><i class="fab fa-twitter"></i></a>
                                <?php endif; ?>
                                <?php if (!empty($member['email'])): ?>
                                    <a href="mailto:<?= htmlspecialchars($member['email']) ?>"><i class="fas fa-envelope"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Timeline Section -->
<section class="timeline-section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'مسيرة نجاحنا' : 'Our Journey' ?></h2>
            <p><?= $lang === 'ar' ? 'رحلة شركة انجاز النوادي للمقاولات العامة عبر السنوات' : 'The journey of Injaz Al-Nawadi General Contracting Co. through the years' ?></p>
        </div>

        <div class="timeline" data-aos="fade-up">
            <?php foreach ($timeline as $index => $item): ?>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="<?= htmlspecialchars($item['icon']) ?>"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-date"><?= htmlspecialchars($item['year']) ?></div>
                        <h4><?= htmlspecialchars($item["title_{$lang}"]) ?></h4>
                        <p><?= htmlspecialchars($item["description_{$lang}"]) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Vision Mission Values Section -->
<section class="vmv-section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'رؤيتنا ورسالتنا وقيمنا' : 'Our Vision, Mission and Values' ?></h2>
            <p><?= $lang === 'ar' ? 'نسعى لأن نكون الخيار الأول في مجال المقاولات والبناء' : 'We strive to be the first choice in the field of contracting and construction' ?></p>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="vmv-card">
                    <div class="vmv-card-header">
                        <i class="fas fa-eye"></i>
                        <h3><?= $lang === 'ar' ? 'رؤيتنا' : 'Our Vision' ?></h3>
                    </div>
                    <div class="vmv-card-body">
                        <p><?= htmlspecialchars($vmv["vision_{$lang}"] ?? '') ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="vmv-card">
                    <div class="vmv-card-header">
                        <i class="fas fa-paper-plane"></i>
                        <h3><?= $lang === 'ar' ? 'رسالتنا' : 'Our Mission' ?></h3>
                    </div>
                    <div class="vmv-card-body">
                        <p><?= htmlspecialchars($vmv["mission_{$lang}"] ?? '') ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="vmv-card">
                    <div class="vmv-card-header">
                        <i class="fas fa-gem"></i>
                        <h3><?= $lang === 'ar' ? 'قيمنا' : 'Our Values' ?></h3>
                    </div>
                    <div class="vmv-card-body">
                        <?= nl2br(htmlspecialchars($vmv["values_{$lang}"] ?? '')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <?php foreach ($counters as $index => $counter): ?>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="<?= htmlspecialchars($counter['icon']) ?>"></i>
                        </div>
                        <div class="stat-num" data-count="<?= (int)$counter['value'] ?>"><?= (int)$counter['value'] ?></div>
                        <div class="stat-text"><?= htmlspecialchars($counter["label_{$lang}"]) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Certificates Section -->
<section class="certificates-section py-5">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'شهاداتنا واعتماداتنا' : 'Our Certificates and Accreditations' ?></h2>
            <p><?= $lang === 'ar' ? 'حاصلون على أهم الشهادات والاعتمادات في مجال المقاولات والبناء' : 'We have obtained the most important certificates and accreditations in the field of contracting and construction' ?></p>
        </div>

        <div class="row">
            <?php foreach ($certificates as $index => $cert): ?>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>">
                    <div class="certificate-item">
                        <div class="certificate-img">
                            <img src="admin/uploads/certificates/<?= htmlspecialchars($cert['image']) ?>" alt="<?= htmlspecialchars($cert["title_{$lang}"]) ?>">
                        </div>
                        <div class="certificate-info">
                            <h4><?= htmlspecialchars($cert["title_{$lang}"]) ?></h4>
                            <p><?= htmlspecialchars($cert["description_{$lang}"]) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Clients Section -->
<section class="clients-section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2><?= $lang === 'ar' ? 'عملاؤنا' : 'Our Clients' ?></h2>
            <p><?= $lang === 'ar' ? 'نفخر بثقة عملائنا من القطاعين الحكومي والخاص' : 'We are proud of the trust of our clients from both the public and private sectors' ?></p>
        </div>

        <div class="clients-logos" data-aos="fade-up">
            <?php foreach ($clients as $client): ?>
                <div class="client-logo">
                    <img src="admin/uploads/partners/<?= htmlspecialchars($client['img']) ?>" alt="<?= htmlspecialchars($client['alt']) ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2 data-aos="fade-up"><?= $lang === 'ar' ? 'هل تبحث عن شريك موثوق لتنفيذ مشروعك؟' : 'Are you looking for a reliable partner to implement your project?' ?></h2>
        <p data-aos="fade-up" data-aos-delay="100"><?= $lang === 'ar' ? 'نحن هنا لتنفيذ مشروعك بأعلى معايير الجودة وبأسعار منافسة. تواصل معنا الآن للحصول على استشارة مجانية ودراسة أولية لمشروعك.' : 'We are here to implement your project with the highest quality standards and competitive prices. Contact us now for a free consultation and initial study of your project.' ?></p>
        <a href="#contact" class="btn btn-cta" data-aos="fade-up" data-aos-delay="200"><?= $lang === 'ar' ? 'تواصل معنا الآن' : 'Contact Us Now' ?></a>
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

    // Counter Animation
    const counterNums = document.querySelectorAll('.stat-num');

    function animateCounter() {
        counterNums.forEach(counter => {
            const target = +counter.dataset.count;
            const count = +counter.innerText;
            const increment = target / 100;

            if (countif (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(animateCounter, 50);
            } else {
                counter.innerText = target;
            }
        });
    }

    // Start animation when in view
    const statsSection = document.querySelector('.stats-section');
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) {
            animateCounter();
            observer.unobserve(statsSection);
        }
    });

    if (statsSection) {
        observer.observe(statsSection);
    }

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
                });
            }
        });
    });
</script>
</body>
</html>