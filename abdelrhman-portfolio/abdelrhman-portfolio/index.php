<?php
// Default language is Arabic
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'ar';

// Content arrays for both languages
$content = [
    'ar' => [
        'name' => 'م. عبدالرحمن الهجلة',
        'title' => 'ماجستير ادارة هندسية',
        'subtitle' => 'خبرة مهنية احترافية',
        'nav' => [
            'home' => 'الرئيسية',
            'expertise' => 'الخبرات',
            'cv' => 'السيرة الذاتية',
            'contact' => 'اتصل بي'
        ],
        'areas' => 'مجالات الاعمال',
        'expertiseAreas' => [
            [
                'title' => 'ادارة المشاريع',
                'icon' => 'project-management',
                'description' => 'خبرة واسعة في إدارة المشاريع الهندسية من التخطيط إلى التنفيذ'
            ],
            [
                'title' => 'التطوير والتدريب',
                'icon' => 'development',
                'description' => 'تطوير وتنفيذ برامج تدريبية متخصصة لرفع كفاءة فرق العمل'
            ],
            [
                'title' => 'ادارة العمليات',
                'icon' => 'operations',
                'description' => 'تحسين كفاءة العمليات التشغيلية وتطبيق أفضل الممارسات'
            ],
            [
                'title' => 'دراسات المقارنات',
                'icon' => 'analysis',
                'description' => 'إجراء دراسات مقارنة شاملة لتحسين الأداء واتخاذ القرارات'
            ]
        ],
        'highlights' => [
            'ماجستير في الادارة الهندسية',
            'تطوير اعمال - ادارة مشاريع',
            'استشارات استثماريه - استشارات تقنية - استشارات تطوير'
        ],
        'foundEverything' => 'هنا ستجد كل ما تحتاجه بسهولة!',
        'interested' => 'اذا مهتم؟ تواصل وابشر بالخير',
        'contactInfo' => [
            'title' => 'بيانات الاتصال',
            'phone' => 'الهاتف:',
            'email' => 'البريد الالكتروني:',
            'address' => 'العنوان:',
            'addressText' => 'الرياض، المملكة العربية السعودية',
            'follow' => 'تابعني:'
        ],
        'visitors' => 'الزوار',
        'visitorCount' => '63',
        'footer' => 'حقوق النشر والتصميم © 2024 - جميع الحقوق محفوظة',
        'langToggle' => 'English',
        'contactTitle' => 'اتصل بي',
        'contactSubtitle' => 'تحتاج الى المساعدة!؟',
        'formLabels' => [
            'name' => 'الاسم',
            'email' => 'البريد الالكتروني*',
            'message' => 'الرسالة',
            'send' => 'ارسال'
        ]
    ],
    'en' => [
        'name' => 'Eng. Abdulrahman Almutairi',
        'title' => 'Master of Engineering Management',
        'subtitle' => 'Professional Expertise',
        'nav' => [
            'home' => 'Home',
            'expertise' => 'Expertise',
            'cv' => 'CV',
            'contact' => 'Contact'
        ],
        'areas' => 'Business Areas',
        'expertiseAreas' => [
            [
                'title' => 'Project Management',
                'icon' => 'project-management',
                'description' => 'Extensive experience in managing engineering projects from planning to execution'
            ],
            [
                'title' => 'Development & Training',
                'icon' => 'development',
                'description' => 'Developing and implementing specialized training programs to enhance team efficiency'
            ],
            [
                'title' => 'Operations Management',
                'icon' => 'operations',
                'description' => 'Improving operational efficiency and implementing best practices'
            ],
            [
                'title' => 'Comparative Studies',
                'icon' => 'analysis',
                'description' => 'Conducting comprehensive comparative studies to improve performance and decision-making'
            ]
        ],
        'highlights' => [
            'Master\'s degree in Engineering Management',
            'Business Development - Project Management',
            'Investment Consulting - Technical Consulting - Development Consulting'
        ],
        'foundEverything' => 'Here you will find everything you need easily!',
        'interested' => 'Interested? Contact me and I\'ll help you',
        'contactInfo' => [
            'title' => 'Contact Information',
            'phone' => 'Phone:',
            'email' => 'Email:',
            'address' => 'Address:',
            'addressText' => 'Riyadh, Saudi Arabia',
            'follow' => 'Follow me:'
        ],
        'visitors' => 'Visitors',
        'visitorCount' => '63',
        'footer' => 'Copyright © 2024 - All Rights Reserved',
        'langToggle' => 'العربية',
        'contactTitle' => 'Contact Me',
        'contactSubtitle' => 'Need assistance?',
        'formLabels' => [
            'name' => 'Name',
            'email' => 'Email*',
            'message' => 'Message',
            'send' => 'Send'
        ]
    ]
];

// Get content based on language
$c = $content[$lang];
$dir = $lang === 'ar' ? 'rtl' : 'ltr';
$align = $lang === 'ar' ? 'right' : 'left';
$font = $lang === 'ar' ? '"Cairo", "Tajawal", Arial, sans-serif' : '"Poppins", Arial, sans-serif';
?>

<!DOCTYPE html>
<html dir="<?php echo $dir; ?>" lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $c['name']; ?> - <?php echo $c['title']; ?></title>
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&family=Tajawal:wght@400;500;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Three.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/controls/OrbitControls.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/loaders/FontLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/geometries/TextGeometry.js"></script>
    
    <!-- Particles -->
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.9.3/tsparticles.bundle.min.js"></script>
    
    <!-- GSAP for advanced animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>
    
    <style>
        :root {
            --primary-color: #0070f3;
            --secondary-color: #6d28d9;
            --accent-color: #00c4ff;
            --dark-color: #111827;
            --light-color: #f3f4f6;
            --text-color: #374151;
            --light-text: #f9fafb;
            --transition-speed: 0.5s;
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.18);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            --gradient-accent: linear-gradient(135deg, var(--accent-color), var(--primary-color));
        }
        
        .dark-mode {
            --primary-color: #3b82f6;
            --secondary-color: #7c3aed;
            --accent-color: #00d8ff;
            --dark-color: #0f172a;
            --light-color: #1e293b;
            --text-color: #e2e8f0;
            --light-text: #f1f5f9;
            --glass-bg: rgba(15, 23, 42, 0.7);
            --glass-border: rgba(255, 255, 255, 0.08);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }
        
        body {
            font-family: <?php echo $font; ?>;
            background: var(--dark-color);
            color: var(--light-text);
            transition: all var(--transition-speed) ease;
            overflow-x: hidden;
            text-align: <?php echo $align; ?>;
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 5px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--dark-color);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }
        
        canvas#scene {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        
        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 1rem 0;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 1000;
            background: var(--glass-bg);
            border-bottom: 1px solid var(--glass-border);
            transition: all var(--transition-speed) ease;
        }
        
        .header.scrolled {
            padding: 0.7rem 0;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        
        .container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 2px solid var(--primary-color);
            object-fit: cover;
            transition: all 0.3s ease;
        }
        
        .logo:hover img {
            transform: scale(1.1);
            border-color: var(--accent-color);
        }
        
        .logo-text {
            font-size: 1.2rem;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: all 0.3s ease;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }
        
        .nav-item .nav-link {
            position: relative;
            color: var(--light-text);
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            padding: 0.5rem 0;
            transition: all 0.3s ease;
        }
        
        .nav-item .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient-primary);
            transition: width 0.3s ease;
        }
        
        .nav-item .nav-link:hover::after,
        .nav-item .nav-link.active::after {
            width: 100%;
        }
        
        .nav-item .nav-link:hover,
        .nav-item .nav-link.active {
            color: var(--accent-color);
        }
        
        .nav-controls {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .lang-toggle {
            background: none;
            border: 1px solid var(--glass-border);
            color: var(--light-text);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            background: var(--glass-bg);
        }
        
        .lang-toggle:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-3px);
        }
        
        .theme-toggle {
            background: none;
            border: none;
            color: var(--light-text);
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .theme-toggle:hover {
            color: var(--accent-color);
            transform: rotate(30deg);
        }
        
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--light-text);
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .mobile-menu-btn:hover {
            color: var(--accent-color);
            transform: rotate(90deg);
        }
        
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 400px;
            height: 100vh;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            z-index: 9999;
            padding: 2rem;
            transition: right 0.5s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .mobile-menu.open {
            right: 0;
        }
        
        .close-menu {
            position: absolute;
            top: 2rem;
            right: 2rem;
            background: none;
            border: none;
            color: var(--light-text);
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        .mobile-nav-links {
            list-style: none;
            margin-top: 2rem;
        }
        
        .mobile-nav-item {
            margin-bottom: 1.5rem;
        }
        
        .mobile-nav-link {
            color: var(--light-text);
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: block;
            padding: 0.5rem 0;
        }
        
        .mobile-nav-link:hover {
            color: var(--accent-color);
            transform: translateX(10px);
        }
        
        .main {
            min-height: 100vh;
            padding-top: 80px;
            position: relative;
            z-index: 1;
        }
        
        .section {
            padding: 6rem 0;
            position: relative;
        }
        
        .hero {
            display: flex;
            align-items: center;
            min-height: calc(100vh - 80px);
            padding: 0;
        }
        
        .hero-content {
            max-width: 800px;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUpIn 1s forwards 0.5s;
        }
        
        .hero-subtitle {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 2rem;
            color: var(--accent-color);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUpIn 1s forwards 0.8s;
        }
        
        .hero-description {
            font-size: 1.2rem;
            line-height: 1.8;
            margin-bottom: 3rem;
            max-width: 600px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUpIn 1s forwards 1.1s;
        }
        
        .btn {
            display: inline-block;
            padding: 0.8rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-size: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            z-index: -1;
        }
        
        .btn:hover::before {
            width: 100%;
        }
        
        .btn-primary {
            background: var(--gradient-primary);
            color: var(--light-text);
        }
        
        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(108, 99, 255, 0.4);
        }
        
        .btn-outline {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }
        
        .btn-outline:hover {
            background: var(--primary-color);
            color: var(--light-text);
            transform: translateY(-5px);
        }
        
        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUpIn 1s forwards 1.4s;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            position: relative;
            display: inline-block;
            margin-bottom: 1rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--gradient-primary);
            border-radius: 10px;
        }
        
        .section-title p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
            opacity: 0.8;
        }
        
        .expertise-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .expertise-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            padding: 2.5rem 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: var(--glass-shadow);
            z-index: 1;
        }
        
        .expertise-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--gradient-primary);
            opacity: 0;
            transition: all 0.5s ease;
            z-index: -1;
            transform: translateY(100%);
        }
        
        .expertise-card:hover {
            transform: translateY(-15px);
        }
        
        .expertise-card:hover::before {
            opacity: 0.08;
            transform: translateY(0);
        }
        
        .expertise-icon {
            width: 80px;
            height: 80px;
            background: var(--glass-bg);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 2.5rem;
            color: var(--primary-color);
            transition: all 0.3s ease;
            border: 1px solid var(--glass-border);
        }
        
        .expertise-card:hover .expertise-icon {
            background: var(--primary-color);
            color: var(--light-text);
            transform: rotateY(180deg);
        }
        
        .expertise-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .expertise-description {
            font-size: 1rem;
            line-height: 1.7;
            opacity: 0.8;
        }
        
        .contact-section {
            position: relative;
        }
        
        .contact-wrapper {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 4rem;
        }
        
        .contact-info h3 {
            font-size: 2rem;
            margin-bottom: 2rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .info-item {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .info-icon {
            min-width: 60px;
            height: 60px;
            background: var(--glass-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary-color);
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }
        
        .info-content h4 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
        
        .info-content p {
            font-size: 1rem;
            opacity: 0.8;
        }
        
        .info-item:hover .info-icon {
            background: var(--primary-color);
            color: var(--light-text);
            transform: rotateY(180deg);
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 3rem;
        }
        
        .social-link {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--light-text);
            text-decoration: none;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            border: 1px solid var(--glass-border);
            background: var(--glass-bg);
        }
        
        .social-link.facebook:hover {
            background: #1877f2;
            transform: translateY(-5px);
        }
        
        .social-link.twitter:hover {
            background: #000000;
            transform: translateY(-5px);
        }
        
        .social-link.linkedin:hover {
            background: #0a66c2;
            transform: translateY(-5px);
        }
        
        .social-link.instagram:hover {
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
            transform: translateY(-5px);
        }
        
        .contact-form {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            padding: 3rem;
            box-shadow: var(--glass-shadow);
        }
        
        .form-group {
            margin-bottom: 2rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.8rem;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            border: 1px solid var(--glass-border);
            background: rgba(255, 255, 255, 0.05);
            color: var(--light-text);
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.1);
        }
        
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
        
        .visitor-count {
            display: flex;
            align-items: center;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid var(--glass-border);
            padding: 1.5rem;
            margin-top: 3rem;
            box-shadow: var(--glass-shadow);
            transition: all 0.3s ease;
        }
        
        .visitor-count:hover {
            transform: translateY(-5px);
        }
        
        .visitor-icon {
            min-width: 60px;
            height: 60px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: var(--light-text);
            margin-right: 1.5rem;
            margin-left: 1.5rem;
        }
        
        .visitor-content {
            flex-grow: 1;
        }
        
        .visitor-title {
            font-size: 1.2rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .visitor-number {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .footer {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 2rem 0;
            border-top: 1px solid var(--glass-border);
            text-align: center;
        }
        
        .floating-shape {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--primary-color) 0%, rgba(108, 99, 255, 0) 70%);
            opacity: 0.1;
            filter: blur(80px);
            animation: floatAnimation 15s infinite alternate ease-in-out;
        }
        
        .shape-1 {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .shape-2 {
            bottom: 20%;
            right: 10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, var(--accent-color) 0%, rgba(0, 196, 255, 0) 70%);
            animation-delay: 5s;
        }
        
        .shape-3 {
            top: 40%;
            right: 30%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, var(--secondary-color) 0%, rgba(109, 40, 217, 0) 70%);
            animation-delay: 10s;
        }
        
        @keyframes floatAnimation {
            0% {
                transform: translate(0, 0) scale(1);
            }
            50% {
                transform: translate(50px, 20px) scale(1.1);
            }
            100% {
                transform: translate(-30px, -20px) scale(0.9);
            }
        }
        
        @keyframes fadeUpIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .scroll-down {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--light-text);
            opacity: 0;
            animation: fadeUpIn 1s forwards 1.7s;
        }
        
        .scroll-down span {
            font-size: 0.9rem;
            font-weight: 500;
            letter-spacing: 1px;
        }
        
        .scroll-down .mouse {
            width: 30px;
            height: 50px;
            border: 2px solid var(--light-text);
            border-radius: 20px;
            display: flex;
            justify-content: center;
            padding-top: 10px;
        }
        
        .scroll-down .mouse .wheel {
            width: 4px;
            height: 10px;
            background: var(--primary-color);
            border-radius: 2px;
            animation: scrollWheel 1.5s infinite;
        }
        
        @keyframes scrollWheel {
            0% {
                transform: translateY(0);
                opacity: 1;
            }
            100% {
                transform: translateY(15px);
                opacity: 0;
            }
        }
        
        .animated-text {
            display: inline-block;
            position: relative;
        }
        
        .animated-text::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background: var(--dark-color);
            animation: textReveal 1.5s forwards;
        }
        
        @keyframes textReveal {
            0% {
                transform: scaleX(0);
                transform-origin: left;
            }
            45% {
                transform: scaleX(1);
                transform-origin: left;
            }
            55% {
                transform: scaleX(1);
                transform-origin: right;
            }
            100% {
                transform: scaleX(0);
                transform-origin: right;
            }
        }
        
        @media (max-width: 992px) {
            .hero-title {
                font-size: 3.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.5rem;
            }
            
            .contact-wrapper {
                grid-template-columns: 1fr;
            }
            
            .contact-info {
                order: 2;
            }
            
            .contact-form {
                order: 1;
                margin-bottom: 2rem;
            }
        }
        
        @media (max-width: 768px) {
            .nav-links, .nav-controls {
                display: none;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .hero-title {
                font-size: 2.8rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                gap: 1rem;
            }
            
            .hero-buttons .btn {
                width: 100%;
                text-align: center;
            }
            
            .section {
                padding: 4rem 0;
            }
            
            .expertise-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Three.js Canvas -->
    <canvas id="scene"></canvas>
    
    <!-- Particles Background -->
    <div id="particles-js"></div>
    
    <!-- Floating Shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>
    
    <!-- Header -->
    <header class="header" id="header">
        <div class="container">
            <div class="navbar">
                <a href="#" class="logo">
                    <img src="images/profile/pro.jpeg" alt="<?php echo $c['name']; ?>" onerror="this.src='https://via.placeholder.com/48'">
                    <div class="logo-text"><?php echo $c['name']; ?></div>
                </a>
                
                <ul class="nav-links">
                    <li class="nav-item">
                        <a href="#home" class="nav-link active" data-section="home"><?php echo $c['nav']['home']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="#expertise" class="nav-link" data-section="expertise"><?php echo $c['nav']['expertise']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="cv/cv.pdf" target="_blank" class="nav-link"><?php echo $c['nav']['cv']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" class="nav-link" data-section="contact"><?php echo $c['nav']['contact']; ?></a>
                    </li>
                </ul>
                
                <div class="nav-controls">
                    <a href="?lang=<?php echo $lang === 'ar' ? 'en' : 'ar'; ?>" class="lang-toggle">
                        <?php echo $c['langToggle']; ?>
                    </a>
                    
                    <button id="theme-toggle" class="theme-toggle">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>
                
                <button class="mobile-menu-btn" id="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobile-menu">
        <button class="close-menu" id="close-menu">
            <i class="fas fa-times"></i>
        </button>
        
        <ul class="mobile-nav-links">
            <li class="mobile-nav-item">
                <a href="#home" class="mobile-nav-link" data-section="home"><?php echo $c['nav']['home']; ?></a>
            </li>
            <li class="mobile-nav-item">
                <a href="#expertise" class="mobile-nav-link" data-section="expertise"><?php echo $c['nav']['expertise']; ?></a>
            </li>
            <li class="mobile-nav-item">
                <a href="cv/cv.pdf" target="_blank" class="mobile-nav-link"><?php echo $c['nav']['cv']; ?></a>
            </li>
            <li class="mobile-nav-item">
                <a href="#contact" class="mobile-nav-link" data-section="contact"><?php echo $c['nav']['contact']; ?></a>
            </li>
            <li class="mobile-nav-item">
                <a href="?lang=<?php echo $lang === 'ar' ? 'en' : 'ar'; ?>" class="mobile-nav-link">
                    <?php echo $c['langToggle']; ?>
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <main class="main">
        <!-- Hero Section -->
        <section id="home" class="section hero">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">
                        <span class="animated-text"><?php echo $c['name']; ?></span>
                    </h1>
                    <h2 class="hero-subtitle"><?php echo $c['title']; ?></h2>
                    <p class="hero-description"><?php echo $c['areas']; ?> - <?php echo $c['subtitle']; ?></p>
                    
                    <div class="hero-buttons">
                        <a href="#contact" class="btn btn-primary"><?php echo $c['nav']['contact']; ?></a>
                        <a href="cv/cv.pdf" target="_blank" class="btn btn-outline"><?php echo $c['nav']['cv']; ?></a>
                    </div>
                </div>
            </div>
            
            <a href="#expertise" class="scroll-down">
                <span><?php echo $lang === 'ar' ? 'اسحب للأسفل' : 'Scroll Down'; ?></span>
                <div class="mouse">
                    <div class="wheel"></div>
                </div>
            </a>
        </section>
        
        <!-- Expertise Section -->
        <section id="expertise" class="section">
            <div class="container">
                <div class="section-title">
                    <h2><?php echo $c['nav']['expertise']; ?></h2>
                    <p><?php echo $c['foundEverything']; ?></p>
                </div>
                
                <div class="expertise-grid">
                    <?php foreach ($c['expertiseAreas'] as $area): ?>
                        <div class="expertise-card" data-aos="fade-up">
                            <div class="expertise-icon">
                                <?php 
                                    $icon = '';
                                    switch($area['icon']) {
                                        case 'project-management':
                                            $icon = 'fas fa-tasks';
                                            break;
                                        case 'development':
                                            $icon = 'fas fa-laptop-code';
                                            break;
                                        case 'operations':
                                            $icon = 'fas fa-cogs';
                                            break;
                                        case 'analysis':
                                            $icon = 'fas fa-chart-line';
                                            break;
                                        default:
                                            $icon = 'fas fa-star';
                                    }
                                ?>
                                <i class="<?php echo $icon; ?>"></i>
                            </div>
                            <h3 class="expertise-title"><?php echo $area['title']; ?></h3>
                            <p class="expertise-description"><?php echo $area['description']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="visitor-count" data-aos="fade-up">
                    <div class="visitor-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="visitor-content">
                        <div class="visitor-title"><?php echo $c['visitors']; ?></div>
                        <div class="visitor-number"><?php echo $c['visitorCount']; ?></div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Contact Section -->
        <section id="contact" class="section contact-section">
            <div class="container">
                <div class="section-title">
                    <h2><?php echo $c['contactTitle']; ?></h2>
                    <p><?php echo $c['contactSubtitle']; ?></p>
                </div>
                
                <div class="contact-wrapper">
                    <div class="contact-info" data-aos="fade-right">
                        <h3><?php echo $c['contactInfo']['title']; ?></h3>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="info-content">
                                <h4><?php echo $c['contactInfo']['phone']; ?></h4>
                                <p dir="ltr">+966557704697</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-content">
                                <h4><?php echo $c['contactInfo']['email']; ?></h4>
                                <p>engr.aalmutairi@gmail.com</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="info-content">
                                <h4><?php echo $c['contactInfo']['address']; ?></h4>
                                <p><?php echo $c['contactInfo']['addressText']; ?></p>
                            </div>
                        </div>
                        
                        <h4><?php echo $c['contactInfo']['follow']; ?></h4>
                        <div class="social-links">
                            <a href="#" class="social-link facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link twitter">
                                <i class="fab fa-x-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/abdulrahman-almutairi/" target="_blank" class="social-link linkedin">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="contact-form" data-aos="fade-left">
                        <form id="contactForm" method="POST" action="">
                            <div class="form-group">
                                <label for="name"><?php echo $c['formLabels']['name']; ?></label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email"><?php echo $c['formLabels']['email']; ?></label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="message"><?php echo $c['formLabels']['message']; ?></label>
                                <textarea id="message" name="message" class="form-control" required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary"><?php echo $c['formLabels']['send']; ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p><?php echo $c['footer']; ?></p>
        </div>
    </footer>
    
    <script>
        // Initialize Three.js Scene
        const initThreeScene = () => {
            const canvas = document.getElementById('scene');
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            
            const renderer = new THREE.WebGLRenderer({
                canvas: canvas,
                antialias: true,
                alpha: true
            });
            
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
            scene.add(ambientLight);
            
            const pointLight = new THREE.PointLight(0x6d28d9, 1);
            pointLight.position.set(5, 5, 5);
            scene.add(pointLight);
            
            const pointLight2 = new THREE.PointLight(0x0070f3, 1);
            pointLight2.position.set(-5, -5, -5);
            scene.add(pointLight2);
            
            // Create geometric shapes
            const createObject = (geometry, material, position, rotation = { x: 0, y: 0, z: 0 }) => {
                const mesh = new THREE.Mesh(geometry, material);
                mesh.position.set(position.x, position.y, position.z);
                mesh.rotation.set(rotation.x, rotation.y, rotation.z);
                scene.add(mesh);
                return mesh;
            };
            
            const objects = [];
            
            // Create materials
            const createMaterial = (color, metalness = 0.2, roughness = 0.5) => {
                return new THREE.MeshStandardMaterial({
                    color: color,
                    metalness: metalness,
                    roughness: roughness,
                    transparent: true,
                    opacity: 0.7
                });
            };
            
            const material1 = createMaterial(0x0070f3);
            const material2 = createMaterial(0x6d28d9);
            const material3 = createMaterial(0x00c4ff);
            
            // Create different geometries
            const boxGeometry = new THREE.BoxGeometry(1, 1, 1);
            const sphereGeometry = new THREE.SphereGeometry(0.7, 32, 32);
            const torusGeometry = new THREE.TorusGeometry(0.7, 0.3, 16, 32);
            const octahedronGeometry = new THREE.OctahedronGeometry(0.7);
            const icosahedronGeometry = new THREE.IcosahedronGeometry(0.7);
            
            // Add meshes
            objects.push(createObject(boxGeometry, material1, { x: 2, y: 2, z: -5 }));
            objects.push(createObject(sphereGeometry, material2, { x: -2, y: -1, z: -4 }));
            objects.push(createObject(torusGeometry, material3, { x: 3, y: -2, z: -6 }));
            objects.push(createObject(octahedronGeometry, material1, { x: -3, y: 2, z: -7 }));
            objects.push(createObject(icosahedronGeometry, material2, { x: 0, y: 3, z: -8 }));
            
            // Add more shapes randomly in the background
            for (let i = 0; i < 15; i++) {
                const geometries = [
                    new THREE.TetrahedronGeometry(0.5),
                    new THREE.DodecahedronGeometry(0.5),
                    new THREE.OctahedronGeometry(0.5),
                    new THREE.IcosahedronGeometry(0.5)
                ];
                
                const materials = [material1, material2, material3];
                
                const geometry = geometries[Math.floor(Math.random() * geometries.length)];
                const material = materials[Math.floor(Math.random() * materials.length)];
                
                const x = (Math.random() - 0.5) * 20;
                const y = (Math.random() - 0.5) * 20;
                const z = Math.random() * -15 - 10;
                
                objects.push(createObject(geometry, material, { x, y, z }));
            }
            
            camera.position.z = 5;
            
            // Animate
            const animate = () => {
                requestAnimationFrame(animate);
                
                objects.forEach((object, index) => {
                    object.rotation.x += 0.003 + (index * 0.001);
                    object.rotation.y += 0.005 + (index * 0.001);
                    
                    // Make objects float
                    const time = Date.now() * 0.001;
                    object.position.y += Math.sin(time + index) * 0.003;
                });
                
                renderer.render(scene, camera);
            };
            
            // Handle window resize
            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            });
            
            animate();
        };
        
        // Initialize Particles.js
        const initParticles = () => {
            tsParticles.load("particles-js", {
                fpsLimit: 60,
                particles: {
                    number: {
                        value: 80,
                        density: {
                            enable: true,
                            value_area: 800
                        }
                    },
                    color: {
                        value: "#ffffff"
                    },
                    shape: {
                        type: "circle"
                    },
                    opacity: {
                        value: 0.5,
                        random: true,
                        anim: {
                            enable: true,
                            speed: 1,
                            opacity_min: 0.1,
                            sync: false
                        }
                    },
                    size: {
                        value: 3,
                        random: true,
                        anim: {
                            enable: true,
                            speed: 2,
                            size_min: 0.1,
                            sync: false
                        }
                    },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: "#0070f3",
                        opacity: 0.2,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 1,
                        direction: "none",
                        random: true,
                        straight: false,
                        out_mode: "out",
                        bounce: false,
                        attract: {
                            enable: true,
                            rotateX: 600,
                            rotateY: 1200
                        }
                    }
                },
                interactivity: {
                    detect_on: "canvas",
                    events: {
                        onhover: {
                            enable: true,
                            mode: "grab"
                        },
                        onclick: {
                            enable: true,
                            mode: "push"
                        },
                        resize: true
                    },
                    modes: {
                        grab: {
                            distance: 140,
                            line_linked: {
                                opacity: 0.8
                            }
                        },
                        push: {
                            particles_nb: 4
                        }
                    }
                },
                retina_detect: true
            });
        };
        
        // Initialize GSAP animations
        const initGSAP = () => {
            // Scroll animations for expertise cards
            gsap.registerPlugin(ScrollTrigger);
            
            gsap.utils.toArray('.expertise-card').forEach((card, i) => {
                gsap.from(card, {
                    opacity: 0,
                    y: 50,
                    duration: 1,
                    scrollTrigger: {
                        trigger: card,
                        start: "top 80%",
                        toggleActions: "play none none none"
                    },
                    delay: i * 0.2
                });
            });
            
            gsap.from('.contact-info', {
                opacity: 0,
                x: -50,
                duration: 1,
                scrollTrigger: {
                    trigger: '.contact-info',
                    start: "top 70%",
                    toggleActions: "play none none none"
                }
            });
            
            gsap.from('.contact-form', {
                opacity: 0,
                x: 50,
                duration: 1,
                scrollTrigger: {
                    trigger: '.contact-form',
                    start: "top 70%",
                    toggleActions: "play none none none"
                }
            });
            
            gsap.from('.visitor-count', {
                opacity: 0,
                scale: 0.8,
                duration: 1,
                scrollTrigger: {
                    trigger: '.visitor-count',
                    start: "top 80%",
                    toggleActions: "play none none none"
                }
            });
        };
        
        // Initialize header scroll effects
        const initHeaderScroll = () => {
            const header = document.querySelector('.header');
            
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });
        };
        
        // Initialize navigation active states
        const initNavigation = () => {
            const sections = document.querySelectorAll('.section');
            const navLinks = document.querySelectorAll('.nav-link');
            const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
            
            const activateNavByScrollPosition = () => {
                const scrollPosition = window.scrollY + 300;
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    const sectionId = section.getAttribute('id');
                    
                    if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                        navLinks.forEach(link => {
                            link.classList.remove('active');
                            if (link.getAttribute('href') === `#${sectionId}`) {
                                link.classList.add('active');
                            }
                        });
                        
                        mobileNavLinks.forEach(link => {
                            link.classList.remove('active');
                            if (link.getAttribute('href') === `#${sectionId}`) {
                                link.classList.add('active');
                            }
                        });
                    }
                });
            };
            
            window.addEventListener('scroll', activateNavByScrollPosition);
            
            // Smooth scrolling
            const scrollToSection = (e) => {
                e.preventDefault();
                
                const href = e.currentTarget.getAttribute('href');
                
                if (href.startsWith('#')) {
                    const targetSection = document.querySelector(href);
                    
                    if (targetSection) {
                        window.scrollTo({
                            top: targetSection.offsetTop - 80,
                            behavior: 'smooth'
                        });
                        
                        // Close mobile menu if open
                        mobileMenu.classList.remove('open');
                    }
                }
            };
            
            navLinks.forEach(link => {
                if (link.getAttribute('href').startsWith('#')) {
                    link.addEventListener('click', scrollToSection);
                }
            });
            
            mobileNavLinks.forEach(link => {
                if (link.getAttribute('href').startsWith('#')) {
                    link.addEventListener('click', scrollToSection);
                }
            });
        };
        
        // Initialize mobile menu
        const initMobileMenu = () => {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const closeMenuBtn = document.getElementById('close-menu');
            const mobileMenu = document.getElementById('mobile-menu');
            
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.add('open');
            });
            
            closeMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.remove('open');
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (
                    !e.target.closest('#mobile-menu') && 
                    !e.target.closest('#mobile-menu-btn') && 
                    mobileMenu.classList.contains('open')
                ) {
                    mobileMenu.classList.remove('open');
                }
            });
        };
        
        // Initialize theme toggle
        const initThemeToggle = () => {
            const themeToggle = document.getElementById('theme-toggle');
            let darkMode = true; // Default is already dark
            
            themeToggle.addEventListener('click', () => {
                darkMode = !darkMode;
                
                if (darkMode) {
                    document.body.classList.remove('light-mode');
                    themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                } else {
                    document.body.classList.add('light-mode');
                    themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                }
            });
        };
        
        // Initialize form submission
        const initContactForm = () => {
            const contactForm = document.getElementById('contactForm');
            
            contactForm.addEventListener('submit', (e) => {
                e.preventDefault();
                // Here you would typically add AJAX form submission
                
                // Simple form validation feedback
                alert('Thank you for your message! This is a demo form without backend processing.');
                contactForm.reset();
            });
        };
        
        // Initialize everything when DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            initThreeScene();
            initParticles();
            initGSAP();
            initHeaderScroll();
            initNavigation();
            initMobileMenu();
            initThemeToggle();
            initContactForm();
        });
    </script>
</body>
</html>
