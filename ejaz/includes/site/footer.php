<?php
// Fetch contact information
$contactQuery = "SELECT * FROM contact_info";
$contactStmt = $pdo->prepare($contactQuery);
$contactStmt->execute();
$contacts = $contactStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch footer navigation links
$footerNavQuery = "SELECT * FROM nav_links WHERE id IN (1, 4, 3, 5, 16) ORDER BY `order`"; // Main pages for Quick Links
$footerNavStmt = $pdo->prepare($footerNavQuery);
$footerNavStmt->execute();
$footerNavLinks = $footerNavStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch service links for footer
$serviceNavQuery = "SELECT * FROM nav_links WHERE parent_id = 2 ORDER BY `order` LIMIT 5"; // Services for Services column
$serviceNavStmt = $pdo->prepare($serviceNavQuery);
$serviceNavStmt->execute();
$serviceNavLinks = $serviceNavStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch additional footer links (terms, privacy, etc.)
$extraNavQuery = "SELECT * FROM nav_links WHERE id >= 17 ORDER BY `order`"; // Extra links
$extraNavStmt = $pdo->prepare($extraNavQuery);
$extraNavStmt->execute();
$extraNavLinks = $extraNavStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="footer-about">
                    <div class="footer-logo">
                        <img src="assets/images/logo-white.png" alt="شركة انجاز النوادي للمقاولات">
                    </div>
                    <p>
                        <?= $lang === 'ar'
                            ? 'شركة انجاز النوادي للمقاولات العامة هي واحدة من الشركات الرائدة في مجال المقاولات والبناء في المملكة العربية السعودية، وتتميز بخبرة تمتد لأكثر من 15 عاماً في تنفيذ مشاريع متنوعة.'
                            : 'Injaz Al-Nawadi General Contracting Company is one of the leading companies in the field of contracting and construction in the Kingdom of Saudi Arabia, with more than 15 years of experience in implementing various projects.'
                        ?>
                    </p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h4><?= $lang === 'ar' ? 'روابط سريعة' : 'Quick Links' ?></h4>
                <ul class="footer-links">
                    <?php foreach ($footerNavLinks as $link): ?>
                        <li>
                            <a href="<?= htmlspecialchars($link['url']) ?>">
                                <?= htmlspecialchars($link["title_$lang"]) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h4><?= $lang === 'ar' ? 'خدماتنا' : 'Our Services' ?></h4>
                <ul class="footer-links">
                    <?php foreach ($serviceNavLinks as $link): ?>
                        <li>
                            <a href="<?= htmlspecialchars($link['url']) ?>">
                                <?= htmlspecialchars($link["title_$lang"]) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h4><?= $lang === 'ar' ? 'اتصل بنا' : 'Contact Us' ?></h4>
                <ul class="footer-contact">
                    <?php foreach ($contacts as $contact): ?>
                        <li>
                            <i class="<?= htmlspecialchars($contact['icon']) ?>"></i>
                            <?= htmlspecialchars($contact['value']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="copyright">
            <div class="row">
                <div class="col-md-6">
                    <p>
                        &copy; <?= date('Y') ?>
                        <?= $lang === 'ar'
                            ? " جميع الحقوق محفوظة شركه نجد القمم للحلول التقنيه"
                            : 'Injaz Al-Nawadi General Contracting Co. All rights reserved.'
                        ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <ul class="footer-extra-links">
                        <?php foreach ($extraNavLinks as $link): ?>
                            <li>
                                <a href="<?= htmlspecialchars($link['url']) ?>">
                                    <?= htmlspecialchars($link["title_$lang"]) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top -->
<a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>