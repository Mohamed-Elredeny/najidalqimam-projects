<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أقسامنا - شركة ايجاز البوادي للمقاولات العامة</title>
    <!-- Bootstrap RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap');
        
        :root {
            --primary-color: #f39c12;
            --secondary-color: #3498db;
            --dark-color: #333;
            --light-color: #f4f4f4;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            overflow-x: hidden;
        }
        
        .lang-switcher {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
        }
        
        /* Header & Navigation */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand img {
            height: 60px;
        }
        
        .nav-link {
            color: var(--dark-color);
            font-weight: 600;
            margin: 0 10px;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-color);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background-color: var(--primary-color);
            bottom: 0;
            right: 0;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after, .nav-link.active::after {
            width: 100%;
        }
        
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
        
        .breadcrumb-item {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .breadcrumb-item.active {
            color: white;
        }
        
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        /* Section Title */
        .section-title {
            position: relative;
            margin-bottom: 60px;
            text-align: center;
        }
        
        .section-title h2 {
            display: inline-block;
            font-weight: 700;
            position: relative;
            margin-bottom: 15px;
            font-size: 2.5rem;
        }
        
        .section-title h2::before {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -10px;
            transform: translateX(-50%);
            width: 70px;
            height: 3px;
            background-color: var(--primary-color);
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
            align-items: center;
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
            margin-left: 15px;
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
        
        .department-section .btn-primary {
            border-radius: 30px;
            padding: 10px 25px;
            font-weight: 600;
            align-self: flex-start;
            margin-top: 20px;
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
        
        /* CTA Section */
        .cta-section {
            padding: 80px 0;
            background-color: var(--primary-color);
            color: white;
            text-align: center;
        }
        
        .cta-section h2 {
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .cta-section p {
            max-width: 800px;
            margin: 0 auto 30px;
            font-size: 1.1rem;
        }
        
        .btn-cta {
            background-color: white;
            color: var(--primary-color);
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        
        .btn-cta:hover {
            background-color: var(--dark-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        
        /* Footer */
        .footer {
            padding: 60px 0 30px;
            background-color: #222;
            color: white;
            position: relative;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--primary-color);
        }
        
        .footer-logo img {
            height: 80px;
            margin-bottom: 20px;
        }
        
        .footer-about p {
            color: #bbb;
            margin-bottom: 20px;
        }
        
        .footer h4 {
            position: relative;
            margin-bottom: 30px;
            font-weight: 600;
            display: inline-block;
        }
        
        .footer h4::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: -10px;
            width: 40px;
            height: 3px;
            background-color: var(--primary-color);
        }
        
        .footer-links {
            list-style: none;
            padding-right: 0;
        }
        
        .footer-links li {
            margin-bottom: 15px;
        }
        
        .footer-links a {
            color: #bbb;
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
            position: relative;
            padding-right: 15px;
        }
        
        .footer-links a::before {
            content: "\f105";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
        }
        
        .footer-links a:hover {
            color: white;
            transform: translateX(-5px);
        }
        
        .footer-contact li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .footer-contact li i {
            color: var(--primary-color);
            margin-left: 15px;
        }
        
        .social-links {
            display: flex;
            margin-top: 20px;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-left: 10px;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background-color: var(--primary-color);
            transform: translateY(-3px);
        }
        
        .copyright {
            text-align: center;
            padding-top: 30px;
            margin-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #bbb;
        }
        
        .copyright a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        /* Back to Top */
        .back-to-top {
            position: fixed;
            right: 20px;
            bottom: 20px;
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .back-to-top.active {
            opacity: 1;
            visibility: visible;
        }
        
        .back-to-top:hover {
            background-color: #e67e22;
            transform: translateY(-3px);
        }
        
        /* Responsive */
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
        <button class="btn btn-sm btn-outline-primary lang-switch" onclick="toggleLanguage()">English</button>
    </div>

    <?php include 'includes/site/nav.php'; ?>

    <!-- Hero Section -->
    <section class="hero-departments">
        <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
            <h1>أقسامنا</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">أقسامنا</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Department Circles Section -->
    <section class="department-circles">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>مجالات عملنا وأقسام المشاريع</h2>
                <p>نتميز بتغطية شاملة لكافة مجالات المقاولات العامة</p>
            </div>
            
            <div class="circle-container">
                <div class="department-circle" data-aos="zoom-in" data-aos-delay="100">
                    <img src="https://images.unsplash.com/photo-1582139329536-e7284fece509?q=80&w=1000&auto=format&fit=crop" alt="تسليم المفتاح">
                    <div class="department-circle-content">
                        <h3>تسليم المفتاح</h3>
                    </div>
                </div>
                
                <div class="department-circle" data-aos="zoom-in" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=1000&auto=format&fit=crop" alt="التنفيذ والبناء">
                    <div class="department-circle-content">
                        <h3>التنفيذ والبناء</h3>
                    </div>
                </div>
                
                <div class="department-circle" data-aos="zoom-in" data-aos-delay="300">
                    <img src="https://images.unsplash.com/photo-1588012886079-d31308fcafd6?q=80&w=1000&auto=format&fit=crop" alt="التشطيبات">
                    <div class="department-circle-content">
                        <h3>التشطيبات</h3>
                    </div>
                </div>
                
                <div class="department-circle" data-aos="zoom-in" data-aos-delay="400">
                    <img src="https://images.unsplash.com/photo-1541123437800-1bb1317badc2?q=80&w=1000&auto=format&fit=crop" alt="الترميم">
                    <div class="department-circle-content">
                        <h3>الترميم</h3>
                    </div>
                </div>
                
                <div class="department-circle" data-aos="zoom-in" data-aos-delay="500">
                    <img src="https://images.unsplash.com/photo-1523529738216-242467d60007?q=80&w=1000&auto=format&fit=crop" alt="تصميم الطرق">
                    <div class="department-circle-content">
                        <h3>تصميم الطرق</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Department 1: Construction -->
    <section id="construction" class="department-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="department-img">
                        <img src="https://images.unsplash.com/photo-1560749003-f4b1e17e2dfd?q=80&w=1000&auto=format&fit=crop" alt="التنفيذ والبناء">
                        <img src="https://images.unsplash.com/photo-1580893246395-52aead8960dc?q=80&w=1000&auto=format&fit=crop" alt="عمال بناء" class="overlay-image top-right">
                        <img src="https://images.unsplash.com/photo-1523726491678-bf852e717f6a?q=80&w=1000&auto=format&fit=crop" alt="أدوات بناء" class="overlay-image bottom-left">
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="department-content">
                        <h2>التنفيذ والبناء</h2>
                        <p>نقدم خدمات شاملة في مجال تنفيذ وبناء المشاريع السكنية والتجارية والصناعية، اعتماداً على فريق متخصص من المهندسين والفنيين ذوي الخبرة الطويلة. نستخدم أحدث التقنيات والمعدات لضمان تنفيذ المشاريع بأعلى معايير الجودة والسلامة وفي الإطار الزمني المحدد.</p>
                        
                        <div class="department-features">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="feature-text">
                                    <h5>مباني سكنية وتجارية</h5>
                                    <p>تنفيذ الفلل والعمائر السكنية والمجمعات التجارية بمختلف المساحات والتصاميم.</p>
                                </div>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-industry"></i>
                                </div>
                                <div class="feature-text">
                                    <h5>منشآت صناعية</h5>
                                    <p>بناء المصانع والمستودعات والهناجر الصناعية وفق أحدث المواصفات العالمية.</p>
                                </div>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-hard-hat"></i>
                                </div>
                                <div class="feature-text">
                                    <h5>إشراف هندسي متكامل</h5>
                                    <p>إدارة كاملة للمشروع من مرحلة التخطيط وحتى التسليم النهائي بأعلى معايير الجودة.</p>
                                </div>
                            </div>
                        </div>
                        
                        <a href="#contact" class="btn btn-primary">طلب استشارة</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Department 2: Renovation -->
    <section id="renovation" class="department-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="department-content">
                        <h2>الترميم وإعادة التأهيل</h2>
                        <p>متخصصون في ترميم وإعادة تأهيل المباني القديمة والمتضررة باستخدام أحدث التقنيات والحلول الهندسية. نقوم بمعالجة مشاكل الرطوبة والتشققات وإصلاح الأضرار الإنشائية وتجديد الواجهات والمرافق مع الحفاظ على الطابع المعماري الأصلي للمبنى.</p>
                        
                        <div class="department-features">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <div class="feature-text">
                                    <h5>معالجة العيوب الإنشائية</h5>
                                    <p>تشخيص وإصلاح التشققات والهبوط وتقوية العناصر الإنشائية الضعيفة.</p>
                                </div>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-tint-slash"></i>
                                </div>
                                <div class="feature-text">
                                    <h5>معالجة تسربات المياه</h5>
                                    <p>حلول متكاملة لمشاكل الرطوبة والعزل المائي للأسطح والجدران والأساسات.</p>
                                </div>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-pencil-ruler"></i>
                                </div>
                                <div class="feature-text">
                                    <h5>تحديث المباني</h5>
                                    <p>تجديد وتحديث المباني القديمة لتتناسب مع المتطلبات العصرية مع الحفاظ على طابعها.</p>
                                </div>
                            </div>
                        </div>
                        
                        <a href="#contact" class="btn btn-primary">طلب استشارة</a>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="department-img">
                        <img src="https://images.unsplash.com/photo-1590986313277-47d15d3fe7b2?q=80&w=1000&auto=format&fit=crop" alt="الترميم">
                        <img src="https://images.unsplash.com/photo-1632904243171-a5c4941c6788?q=80&w=1000&auto=format&fit=crop" alt="معدات ترميم" class="overlay-image top-right">
                        <img src="https://images.unsplash.com/photo-1577152005000-5ae752601637?q=80&w=1000&auto=format&fit=crop" alt="عامل ترميم" class="overlay-image bottom-left">
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Department 3: Finishing -->
    <section id="finishing" class="department-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="department-img">
                        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1000&auto=format&fit=crop" alt="التشطيبات">
                        <img src="https://images.unsplash.com/photo-1578554819102-ae49d08c1047?q=80&w=1000&auto=format&fit=crop" alt="تشطيبات داخلية" class="overlay-image top-right">
                        <img src="https://images.unsplash.com/photo-1594760467013-64ac2b80b7d3?q=80&w=1000&auto=format&fit=crop" alt="أعمال دهانات" class="overlay-image bottom-left">
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="department-content">
                        <h2>التشطيبات</h2>
                        <p>نقدم خدمات متميزة في مجال التشطيبات الداخلية والخارجية للمباني، ونهتم بأدق التفاصيل لإضفاء لمسة جمالية وعملية على المشروع. فريقنا المتخصص في أعمال التشطيب يجمع بين الإبداع والاحترافية لتلبية تطلعات العملاء وتقديم نتائج مبهرة.</p>
                        
                        <div class="department-features">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-paint-roller"></i>
                                </div>
                                <div class="feature-text">
                                    <h5>أعمال الدهانات والديكور</h5>
                                    <p>تنفيذ كافة أنواع الدهانات الداخلية والخارجية والديكورات الجبسية بأحدث التقنيات.</p>
                                </div>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-toilet"></i>
                                </div>
                                <div class="feature-text">
                                    <h5>أعمال السباكة والكهرباء</h5>
                                    <p>تركيب وصيانة شبكات المياه والصرف الصحي والأنظمة الكهربائية بمستوى عالٍ من الدقة.</p>
                                </div>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-th-large"></i>
                                </div>
                                <div class="feature-text">
                                    <h5>تركيب السيراميك والرخام</h5>
                                    <p>تنفيذ أعمال تركيب البلاط والسيراميك والرخام والجرانيت للأرضيات والجدران.</p>
                                </div>
                            </div>
                        </div>
                        
                        <a href="#contact" class="btn btn-primary">طلب استشارة</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Department 4: Turnkey Projects -->
    <section id="turnkey" class="department-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="department-content">
                        <h2>تسليم المفتاح</h2>
                        <p>نوفر خدمات متكاملة لمشاريع تسليم المفتاح حيث نتولى المشروع من مرحلة التصميم والتخطيط إلى مرحلة التنفيذ والتشطيب والتسليم النهائي. نهتم بكافة التفاصيل الفنية والإدارية للمشروع لنضمن تسليمه بأعلى معايير الجودة وضمن الميزانية والوقت المحدد.</p>
                        
                        <div class="department-features">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-drafting-compass"></i>
                                </div>
                                <div class="feature-text">
                                    <h5>التصميم والتخطيط</h5>
                                    <p>إعداد التصاميم المعمارية والإنشائية والميكانيكية والكهربائية وفق احتياجات العميل.</p>
                                </div>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <div class="feature-text">
                                    <h5>إدارة المشروع</h5>
                                    <p>إدارة كاملة للمشروع تشمل جدولة العمل وإدارة الموارد ومتابعة الجودة والتكلفة.</p>
                                </div>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-key"></i>
                                </div>
                                <div class="feature-text">
                                    <h5>التسليم الشامل</h5>
                                    <p>تجهيز المبنى بشكل كامل وتسليمه جاهزاً للاستخدام مع ضمان الجودة والصيانة.</p>
                                </div>
                            </div>
                        </div>
                        
                        <a href="#contact" class="btn btn-primary">طلب استشارة</a>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="department-img">
                        <img src="https://images.unsplash.com/photo-1531834685032-c34bf0d84c77?q=80&w=1000&auto=format&fit=crop" alt="تسليم المفتاح">
                        <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1000&auto=format&fit=crop" alt="منزل جاهز" class="overlay-image top-right">
                        <img src="https://images.unsplash.com/photo-1617870352493-3991d88d7e1f?q=80&w=1000&auto=format&fit=crop" alt="تسليم مفتاح" class="overlay-image bottom-left">
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Department 5: Road Design -->
    <section id="roads" class="department-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="department-img">
                        <img src="https://images.unsplash.com/photo-1586996292898-71f4036c4e07?q=80&w=1000&auto=format&fit=crop" alt="تصميم الطرق">
                        <img src="https://images.unsplash.com/photo-1595842936720-e4f9cc4337f5?q=80&w=1000&auto=format&fit=crop" alt="طريق" class="overlay-image top-right">
                        <img src="https://images.unsplash.com/photo-1546518071-fddcdda7580a?q=80&w=1000&auto=format&fit=crop" alt="معدات طرق" class="overlay-image bottom-left">
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="department-content">
                        <h2>تصميم وتنفيذ الطرق</h2>
                        <p>نقدم خدمات متخصصة في مجال تصميم وتنفيذ الطرق والجسور وأعمال البنية التحتية. نمتلك فريقاً متخصصاً من المهندسين وأحدث المعدات لتنفيذ مشاريع الطرق بمختلف أنواعها وفق أعلى معايير الجودة والسلامة المرورية.</p>
                        
                        <div class="department-features">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-road"></i>
                                </div>
                                <div class="feature-text">
                                    <h5>إنشاء الطرق</h5>
                                    <p>تنفيذ الطرق الرئيسية والفرعية والحضرية والريفية بمختلف المواصفات والمقاييس.</p>
                                </div>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-archway"></i>
                                </div>
                                <div class="feature-text">
                                    <h5>الجسور والأنفاق</h5>
                                    <p>تصميم وتنفيذ الجسور والعبارات والأنفاق وفق أحدث التقنيات الهندسية.</p>
                                </div>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-water"></i>
                                </div>
                                <div class="feature-text">
                                    <h5>البنية التحتية</h5>
                                    <p>تنفيذ شبكات الصرف الصحي ومياه الأمطار وأنظمة التصريف للطرق.</p>
                                </div>
                            </div>
                        </div>
                        
                        <a href="#contact" class="btn btn-primary">طلب استشارة</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 data-aos="fade-up">هل تبحث عن شريك موثوق لتنفيذ مشروعك؟</h2>
            <p data-aos="fade-up" data-aos-delay="100">نحن هنا لتنفيذ مشروعك بأعلى معايير الجودة وبأسعار منافسة. تواصل معنا الآن للحصول على استشارة مجانية ودراسة أولية لمشروعك.</p>
            <a href="#contact" class="btn btn-cta" data-aos="fade-up" data-aos-delay="200">تواصل معنا الآن</a>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-about">
                        <div class="footer-logo">
                            <img src="https://placeholder.pics/svg/200x80/FFFFFF/555555/LOGO" alt="شركة ايجاز البوادي للمقاولات">
                        </div>
                        <p>شركة ايجاز البوادي للمقاولات العامة هي واحدة من الشركات الرائدة في مجال المقاولات والبناء في المملكة العربية السعودية.</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h4>روابط سريعة</h4>
                    <ul class="footer-links">
                        <li><a href="index.html">الرئيسية</a></li>
                        <li><a href="about.html">من نحن</a></li>
                        <li><a href="departments.html">أقسامنا</a></li>
                        <li><a href="#projects">مشاريعنا</a></li>
                        <li><a href="#contact">اتصل بنا</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h4>خدماتنا</h4>
                    <ul class="footer-links">
                        <li><a href="#turnkey">تسليم المفتاح</a></li>
                        <li><a href="#construction">التنفيذ و البناء</a></li>
                        <li><a href="#finishing">التشطيبات</a></li>
                        <li><a href="#renovation">الترميم</a></li>
                        <li><a href="#roads">تصميم الطرق</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h4>اتصل بنا</h4>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> الدمام، طريق الملك سعود، حي العنود</li>
                        <li><i class="fas fa-phone-alt"></i> <span dir="ltr">+966 59 991 2030</span></li>
                        <li><i class="fas fa-envelope"></i> mkld1397@gmail.com</li>
                        <li><i class="fas fa-clock"></i> الأحد - الخميس: 8:00 - 17:00</li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2025 شركة ايجاز البوادي للمقاولات العامة. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>
    
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
                    });
                }
            });
        });
        
        // Language switching functionality
        function toggleLanguage() {
            const htmlElement = document.documentElement;
            const langButton = document.querySelector('.lang-switch');
            
            if (htmlElement.getAttribute('lang') === 'ar') {
                // Switch to English
                htmlElement.setAttribute('lang', 'en');
                htmlElement.setAttribute('dir', 'ltr');
                langButton.textContent = 'العربية';
                
                // Load English content (this would typically fetch translations)
                console.log("Switching to English");
            } else {
                // Switch to Arabic
                htmlElement.setAttribute('lang', 'ar');
                htmlElement.setAttribute('dir', 'rtl');
                langButton.textContent = 'English';
                
                // Load Arabic content
                console.log("Switching to Arabic");
            }
        }
    </script>
</body>
</html>