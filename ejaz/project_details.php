<?php
session_start();
require_once 'config/db.php';

// Language switching
if (isset($_GET['lang']) && in_array($_GET['lang'], ['ar', 'en'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'ar';
$dir = $lang === 'ar' ? 'rtl' : 'ltr';

// Get project ID from URL
$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch project details
$projectStmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$projectStmt->execute([$project_id]);
$project = $projectStmt->fetch(PDO::FETCH_ASSOC);

// If project not found, redirect to projects page
if (!$project) {
    header("Location: index.php#projects");
    exit;
}

// Fetch project gallery images
//$galleryStmt = $pdo->prepare("SELECT * FROM project_gallery WHERE project_id = ? ORDER BY `order`");
//$galleryStmt->execute([$project_id]);
//$gallery = $galleryStmt->fetchAll(PDO::FETCH_ASSOC);
$gallery = [];
// Contact Info for sidebar
$contacts = $pdo->query("SELECT * FROM contact_info")->fetchAll(PDO::FETCH_ASSOC);

// Status mapping
$statusMap = [
    'planning' => $lang === 'ar' ? 'مرحلة التخطيط' : 'Planning Phase',
    'design' => $lang === 'ar' ? 'مرحلة التصميم' : 'Design Phase',
    'execution' => $lang === 'ar' ? 'قيد التنفيذ' : 'In Progress',
    'completed' => $lang === 'ar' ? 'مكتمل' : 'Completed'
];

// Category mapping
$categoryMap = [
    'residential' => $lang === 'ar' ? 'سكني' : 'Residential',
    'commercial' => $lang === 'ar' ? 'تجاري' : 'Commercial',
    'government' => $lang === 'ar' ? 'حكومي' : 'Government',
    'infrastructure' => $lang === 'ar' ? 'بنية تحتية' : 'Infrastructure',
    'development' => $lang === 'ar' ? 'تطوير عقاري' : 'Real Estate Development'
];
?>
    <!DOCTYPE html>
    <html lang="<?= $lang ?>" dir="<?= $dir ?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title><?= htmlspecialchars($project["project_title_{$lang}"] ?? ''); ?></title>
        <!-- Bootstrap RTL/LTR CSS based on language -->
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
            <a href="?id=<?= $project_id ?>&lang=en" class="btn btn-sm btn-outline-primary">English</a>
        <?php else: ?>
            <a href="?id=<?= $project_id ?>&lang=ar" class="btn btn-sm btn-outline-primary">العربية</a>
        <?php endif; ?>
    </div>

    <!-- Navigation -->
    <?php include 'includes/site/nav.php'; ?>

    <!-- Project Details -->
    <section class="project-details py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Main Project Image -->
                    <div class="main-image mb-4" data-aos="fade-up">
                        <img src="admin/uploads/projects/<?= htmlspecialchars($project['main_image']) ?>"
                             alt="<?= htmlspecialchars($project["project_title_{$lang}"]) ?>"
                             class="img-fluid rounded">
                    </div>

                    <!-- Project Title and Description -->
                    <div data-aos="fade-up">
                        <h1 class="mb-3"><?= htmlspecialchars($project["project_title_{$lang}"]) ?></h1>

                        <?php if (!empty($project["summary_{$lang}"])): ?>
                            <div class="project-summary mb-4">
                                <p class="lead"><?= nl2br(htmlspecialchars($project["summary_{$lang}"])) ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="project-content">
                            <?= nl2br(htmlspecialchars($project["description_{$lang}"] ?? '')) ?>
                        </div>
                    </div>

                    <!-- Project Gallery -->
                    <?php if (count($gallery) > 0): ?>
                        <div class="mt-5" data-aos="fade-up">
                            <h3 class="mb-3"><?= $lang === 'ar' ? 'معرض الصور' : 'Project Gallery'; ?></h3>
                            <div class="project-gallery">
                                <?php foreach ($gallery as $index => $image): ?>
                                    <div class="gallery-item" data-aos="zoom-in" onclick="openLightbox(<?= $index ?>)">
                                        <img src="admin/uploads/projects/gallery/<?= htmlspecialchars($image['image_url']) ?>"
                                             alt="<?= htmlspecialchars($project["project_title_{$lang}"]) ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Video Section (if available) -->
                    <?php if (!empty($project['video_url'])): ?>
                        <div class="mt-5" data-aos="fade-up">
                            <h3 class="mb-3"><?= $lang === 'ar' ? 'فيديو المشروع' : 'Project Video'; ?></h3>
                            <div class="ratio ratio-16x9">
                                <iframe src="<?= convertVideoUrl($project['video_url']) ?>"
                                        allowfullscreen title="<?= htmlspecialchars($project["project_title_{$lang}"]) ?>"></iframe>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-lg-4">
                    <!-- Project Meta Info -->
                    <div class="project-meta" data-aos="fade-<?= $lang === 'ar' ? 'right' : 'left' ?>">
                        <h4 class="mb-4"><?= $lang === 'ar' ? 'تفاصيل المشروع' : 'Project Details'; ?></h4>
                        <ul class="list-unstyled">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?= htmlspecialchars($project["location_{$lang}"]) ?></span>
                            </li>
                            <li>
                                <i class="fas fa-building"></i>
                                <span><?= $lang === 'ar' ? 'التصنيف:' : 'Category:'; ?>
                                    <?= $categoryMap[$project['project_category']] ?? $project['project_category'] ?>
                            </span>
                            </li>
                            <?php if (!empty($project['client'])): ?>
                                <li>
                                    <i class="fas fa-user"></i>
                                    <span><?= $lang === 'ar' ? 'العميل:' : 'Client:'; ?> <?= htmlspecialchars($project['client']) ?></span>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($project['area'])): ?>
                                <li>
                                    <i class="fas fa-ruler-combined"></i>
                                    <span><?= $lang === 'ar' ? 'المساحة:' : 'Area:'; ?> <?= htmlspecialchars($project['area']) ?> m²</span>
                                </li>
                            <?php endif; ?>
                            <li>
                                <i class="fas fa-calendar-alt"></i>
                                <span><?= $lang === 'ar' ? 'تاريخ البدء:' : 'Start Date:'; ?>
                                    <?= formatDate($project['start_date'], $lang) ?>
                            </span>
                            </li>
                            <?php if (!empty($project['end_date'])): ?>
                                <li>
                                    <i class="fas fa-flag-checkered"></i>
                                    <span><?= $lang === 'ar' ? 'تاريخ الانتهاء:' : 'Completion Date:'; ?>
                                        <?= formatDate($project['end_date'], $lang) ?>
                            </span>
                                </li>
                            <?php endif; ?>
                            <li>
                                <i class="fas fa-tasks"></i>
                                <span><?= $lang === 'ar' ? 'الحالة:' : 'Status:'; ?>
                                  <span class="badge rounded-pill bg-<?= getStatusBadgeColor($project['status']) ?>">
                                      <?= $statusMap[$project['status']] ?? $project['status'] ?>
                                  </span>
                            </span>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Info Card -->
                    <div class="contact-info p-4 bg-white rounded shadow-sm" data-aos="fade-up">
                        <h4 class="mb-3"><?= $lang === 'ar' ? 'تواصل معنا' : 'Contact Us'; ?></h4>
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
            </div>

            <!-- Back to Projects Button -->
            <div class="text-center mt-5">
                <a href="index.php#projects" class="btn btn-primary">
                    <?= $lang === 'ar' ? 'العودة إلى المشاريع' : 'Back to Projects'; ?>
                </a>
            </div>
        </div>
    </section>

    <!-- Lightbox for Gallery -->
    <div class="lightbox" id="gallery-lightbox">
        <div class="lightbox-close" onclick="closeLightbox()">
            <i class="fas fa-times"></i>
        </div>
        <div class="lightbox-prev" onclick="changeImage(-1)">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div class="lightbox-content">
            <img id="lightbox-image" src="" alt="">
        </div>
        <div class="lightbox-next" onclick="changeImage(1)">
            <i class="fas fa-chevron-right"></i>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'includes/site/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({duration: 1000, once: true});

        // Gallery lightbox functionality
        let currentImageIndex = 0;
        const galleryImages = [
            <?php foreach ($gallery as $image): ?>
            "admin/uploads/projects/gallery/<?= htmlspecialchars($image['image_url']) ?>",
            <?php endforeach; ?>
        ];

        function openLightbox(index) {
            currentImageIndex = index;
            document.getElementById('lightbox-image').src = galleryImages[index];
            document.getElementById('gallery-lightbox').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('gallery-lightbox').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function changeImage(direction) {
            currentImageIndex = (currentImageIndex + direction + galleryImages.length) % galleryImages.length;
            document.getElementById('lightbox-image').src = galleryImages[currentImageIndex];
        }

        // Close lightbox with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            } else if (e.key === 'ArrowRight') {
                changeImage(1);
            } else if (e.key === 'ArrowLeft') {
                changeImage(-1);
            }
        });
    </script>
    </body>
    </html>

<?php
// Helper function to format dates
function formatDate($dateString, $lang) {
    $date = new DateTime($dateString);
    if ($lang === 'ar') {
        // Arabic date format
        $months = [
            'يناير', 'فبراير', 'مارس', 'إبريل', 'مايو', 'يونيو',
            'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'
        ];
        return $date->format('d') . ' ' . $months[$date->format('n') - 1] . ' ' . $date->format('Y');
    } else {
        // English date format
        return $date->format('F j, Y');
    }
}

// Helper function to get status badge color
function getStatusBadgeColor($status) {
    switch ($status) {
        case 'planning':
            return 'info';
        case 'design':
            return 'primary';
        case 'execution':
            return 'warning';
        case 'completed':
            return 'success';
        default:
            return 'secondary';
    }
}

// Helper function to convert YouTube/Vimeo URLs to embed URLs
function convertVideoUrl($url) {
    // YouTube
    if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches) ||
        preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }

    // Vimeo
    if (preg_match('/vimeo\.com\/([0-9]+)/', $url, $matches)) {
        return 'https://player.vimeo.com/video/' . $matches[1];
    }

    return $url; // Return original if not YouTube or Vimeo
}
?>