<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قسم أعمال الطرق والجسور - شركة انجاز النوادي للمقاولات العامة</title>
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
            --bg-color: #f8f9fa;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--bg-color);
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
            height: 50px;
        }
        
        .nav-link {
            color: var(--dark-color);
            font-weight: 600;
            margin: 0 10px;
            position: relative;
            transition: all 0.3s ease;
            font-size: 0.9rem;
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
        .hero-section {
            position: relative;
            height: 40vh;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1470&auto=format&fit=crop') center/cover no-repeat;
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
            padding-right: 15px;
        }
        
        .content-title::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
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
            right: 0;
            bottom: -10px;
            width: 40px;
            height: 3px;
            background-color: var(--primary-color);
        }
        
        .benefit-card p {
            color: #666;
            line-height: 1.7;
        }
        
        /* Call to Action */
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
            height: 60px;
            margin-bottom: 20px;
        }
        
        .footer-about p {
            color: #bbb;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .footer h4 {
            position: relative;
            margin-bottom: 30px;
            font-weight: 600;
            display: inline-block;
            font-size: 1.2rem;
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
            font-size: 0.9rem;
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
            align-items: flex-start;
            font-size: 0.9rem;
        }
        
        .footer-contact li i {
            color: var(--primary-color);
            margin-left: 15px;
            margin-top: 5px;
        }
        
        .social-links {
            display: flex;
            margin-top: 20px;
        }
        
        .social-links a {
            width: 35px;
            height: 35px;
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
            font-size: 0.9rem;
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
        <button class="btn btn-sm btn-outline-primary lang-switch" onclick="toggleLanguage()">English</button>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="https://placeholder.pics/svg/200x80/DEDEDE/555555/LOGO" alt="شركة انجاز النوادي للمقاولات">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">عن الشركة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.html">خدماتنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="departments.html">أقسامنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="projects.html">المشاريع</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.html">المدونة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">اتصل بنا</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="login.html" class="btn btn-outline-primary btn-sm mx-2">تسجيل دخول</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>مجال الأعمال</h1>
                    <p>الإحترافية - كفاءة الأداء</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Icons -->
    <section class="service-icons py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                    <div class="service-icon-box">
                        <img src="https://images.unsplash.com/photo-1541976498300-868a21d95d4b?q=80&w=1000&auto=format&fit=crop" alt="خدمة">
                    </div>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                    <div class="service-icon-box">
                        <img src="https://images.unsplash.com/photo-1513507661152-e2d87578a6c6?q=80&w=1000&auto=format&fit=crop" alt="خدمة">
                    </div>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                    <div class="service-icon-box">
                        <img src="https://images.unsplash.com/photo-1533094602577-94c73840129d?q=80&w=1000&auto=format&fit=crop" alt="خدمة">
                    </div>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                    <div class="service-icon-box">
                        <img src="https://images.unsplash.com/photo-1588499756884-d72584d84df5?q=80&w=1000&auto=format&fit=crop" alt="خدمة">
                    </div>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                    <div class="service-icon-box">
                        <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=1000&auto=format&fit=crop" alt="خدمة">
                    </div>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                    <div class="service-icon-box">
                        <img src="https://images.unsplash.com/photo-1606836576983-8b458e75221d?q=80&w=1000&auto=format&fit=crop" alt="خدمة">
                    </div>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                    <div class="service-icon-box">
                        <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1000&auto=format&fit=crop" alt="خدمة">
                    </div>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                    <div class="service-icon-box">
                        <img src="https://images.unsplash.com/photo-1501004318641-b39e6451bec6?q=80&w=1000&auto=format&fit=crop" alt="خدمة">
                    </div>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                    <div class="service-icon-box">
                        <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?q=80&w=1000&auto=format&fit=crop" alt="خدمة">
                    </div>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                    <div class="service-icon-box">
                        <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1000&auto=format&fit=crop" alt="خدمة">
                    </div>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                    <div class="service-icon-box">
                        <img src="https://images.unsplash.com/photo-1519811190311-175ea2d6ba1b?q=80&w=1000&auto=format&fit=crop" alt="خدمة">
                    </div>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                    <div class="service-icon-box">
                        <img src="https://images.unsplash.com/photo-1517996864627-2062e08e3aae?q=80&w=1000&auto=format&fit=crop" alt="خدمة">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Section -->
    <section class="featured-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <img src="https://images.unsplash.com/photo-1489619243109-4e0ea59cfe10?q=80&w=1000&auto=format&fit=crop" alt="صورة المدينة" class="featured-img">
                </div>
            </div>
        </div>
    </section>

    <!-- Department Title -->
    <div class="department-title">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>قسم أعمال الطرق والجسور</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Department Content -->
    <section class="department-content">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <h3 class="content-title">التصميم:</h3>
                    <p>يعتبر قسم الطرق يشمل تصميم الحلول الهندسية والبنية التحتية للجسور والطرق والخدمات العامة. يتميز القسم بالخبرة الفنية المتخصصة بالإضافة إلى استخدام أحدث التقنيات والخوارزميات الفنية. المصممون الهندسيون لدينا على قدر كبير من الخبرة التصميمية في مجال الطرق والجسور.</p>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <h3 class="content-title">البناء:</h3>
                    <p>يعتبر قسم الطرق يشمل تصميم الحلول الهندسية والبنية التحتية للجسور والطرق والخدمات العامة. يتميز القسم بالخبرة الفنية المتخصصة بالإضافة إلى استخدام أحدث التقنيات والخوارزميات الفنية. المصممون الهندسيون لدينا على قدر كبير من الخبرة التصميمية في مجال الطرق والجسور.</p>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <h3 class="content-title">الصيانة:</h3>
                    <p>يعتبر قسم الطرق يشمل تصميم الحلول الهندسية والبنية التحتية للجسور والطرق والخدمات العامة. يتميز القسم بالخبرة الفنية المتخصصة بالإضافة إلى استخدام أحدث التقنيات والخوارزميات الفنية. المصممون الهندسيون لدينا على قدر كبير من الخبرة التصميمية في مجال الطرق والجسور.</p>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <h3 class="content-title">معايير الجودة والسلامة:</h3>
                    <p>يعتبر قسم الطرق يشمل تصميم الحلول الهندسية والبنية التحتية للجسور والطرق والخدمات العامة. يتميز القسم بالخبرة الفنية المتخصصة بالإضافة إلى استخدام أحدث التقنيات والخوارزميات الفنية. المصممون الهندسيون لدينا على قدر كبير من الخبرة التصميمية في مجال الطرق والجسور.</p>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <h3 class="content-title">التقنيات الحديثة:</h3>
                    <p>يعتبر قسم الطرق يشمل تصميم الحلول الهندسية والبنية التحتية للجسور والطرق والخدمات العامة. يتميز القسم بالخبرة الفنية المتخصصة بالإضافة إلى استخدام أحدث التقنيات والخوارزميات الفنية. المصممون الهندسيون لدينا على قدر كبير من الخبرة التصميمية في مجال الطرق والجسور.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h3 class="content-title">التحليل الاقتصادي والمالي:</h3>
                    <p>يعتبر قسم الطرق يشمل تصميم الحلول الهندسية والبنية التحتية للجسور والطرق والخدمات العامة. يتميز القسم بالخبرة الفنية المتخصصة بالإضافة إلى استخدام أحدث التقنيات والخوارزميات الفنية. المصممون الهندسيون لدينا على قدر كبير من الخبرة التصميمية في مجال الطرق والجسور.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Department Benefits -->
    <section class="benefits-section">
        <div class="container">
            <h2 class="benefits-title mb-5">فوائد القسم</h2>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="benefit-card">
                        <h3 class="benefit-title">تحسين وسائل النقل:</h3>
                        <p>تلعب المشروعات الهندسية الناجحة والمصممة جيداً وخاصية وبناء الإمكانيات العامة للطرق على الوصول إلى المناطق الريفية بسهولة وأمان. تنفيذ إجراءات متطورة تضمن SEO لتحسين تصور الجهاز للمستخدم.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="benefit-card">
                        <h3 class="benefit-title">تعزيز الترابط الاجتماعي:</h3>
                        <p>تلعب المشروعات الهندسية الناجحة والمصممة جيداً وخاصية وبناء الإمكانيات العامة للطرق على الوصول إلى المناطق الريفية بسهولة وأمان. تنفيذ إجراءات متطورة تضمن SEO لتحسين تصور الجهاز للمستخدم.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="benefit-card">
                        <h3 class="benefit-title">معايير الجودة والسلامة:</h3>
                        <p>تلعب المشروعات الهندسية الناجحة والمصممة جيداً وخاصية وبناء الإمكانيات العامة للطرق على الوصول إلى المناطق الريفية بسهولة وأمان. تنفيذ إجراءات متطورة تضمن SEO لتحسين تصور الجهاز للمستخدم.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="benefit-card">
                        <h3 class="benefit-title">التقنيات الحديثة:</h3>
                        <p>تلعب المشروعات الهندسية الناجحة والمصممة جيداً وخاصية وبناء الإمكانيات العامة للطرق على الوصول إلى المناطق الريفية بسهولة وأمان. تنفيذ إجراءات متطورة تضمن SEO لتحسين تصور الجهاز للمستخدم.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="benefit-card">
                        <h3 class="benefit-title">التحليل الاقتصادي والمالي:</h3>
                        <p>تلعب المشروعات الهندسية الناجحة والمصممة جيداً وخاصية وبناء الإمكانيات العامة للطرق على الوصول إلى المناطق الريفية بسهولة وأمان. تنفيذ إجراءات متطورة تضمن SEO لتحسين تصور الجهاز للمستخدم.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="benefit-card">
                        <h3 class="benefit-title">دعم التنمية الاقتصادية:</h3>
                        <p>تلعب المشروعات الهندسية الناجحة والمصممة جيداً وخاصية وبناء الإمكانيات العامة للطرق على الوصول إلى المناطق الريفية بسهولة وأمان. تنفيذ إجراءات متطورة تضمن SE</p>
                    </div>
                    </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>هل تبحث عن شريك موثوق لتنفيذ مشروعك؟</h2>
                    <p>نحن هنا لتنفيذ مشروعك بأعلى معايير الجودة وبأسعار منافسة. تواصل معنا الآن للحصول على استشارة مجانية ودراسة أولية لمشروعك.</p>
                    <a href="contact.html" class="btn btn-cta">تواصل معنا الآن</a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-about">
                        <div class="footer-logo">
                            <img src="https://placeholder.pics/svg/200x80/FFFFFF/555555/LOGO" alt="شركة انجاز النوادي للمقاولات">
                        </div>
                        <p>شركة انجاز النوادي للمقاولات العامة هي واحدة من الشركات الرائدة في مجال المقاولات والبناء في المملكة العربية السعودية، وتتميز بخبرة تمتد لأكثر من 15 عاماً في تنفيذ مشاريع متنوعة.</p>
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
                        <li><a href="about.html">عن الشركة</a></li>
                        <li><a href="services.html">خدماتنا</a></li>
                        <li><a href="projects.html">المشاريع</a></li>
                        <li><a href="blog.html">المدونة</a></li>
                        <li><a href="contact.html">اتصل بنا</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h4>روابط مفيدة</h4>
                    <ul class="footer-links">
                        <li><a href="terms.html">الشروط والأحكام</a></li>
                        <li><a href="privacy.html">سياسة الخصوصية</a></li>
                        <li><a href="faq.html">الأسئلة الشائعة</a></li>
                        <li><a href="career.html">الوظائف</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <h4>وسائل التواصل</h4>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> الدمام، طريق الملك سعود، حي العنود، مبنى راحتي، الطابق الثاني</li>
                        <li><i class="fas fa-phone-alt"></i> <span dir="ltr">+966 59 991 2030</span></li>
                        <li><i class="fas fa-envelope"></i> <span>info@company.com</span></li>
                        <li><i class="fas fa-clock"></i> <span>الأحد - الخميس: 8:00 صباحاً - 5:00 مساءً</span></li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2025 شركة انجاز النوادي للمقاولات العامة. جميع الحقوق محفوظة.</p>
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
