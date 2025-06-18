<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اتصل بنا - شركة انجاز النوادي للمقاولات العامة</title>
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
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1470&auto=format&fit=crop') center/cover no-repeat;
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
        
        /* Contact Section */
        .contact-section {
            padding: 70px 0;
        }
        
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
        
        .contact-info {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            height: 100%;
            position: relative;
            z-index: 2;
        }
        
        .contact-info h3 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
            display: inline-block;
        }
        
        .contact-info h3::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: -10px;
            width: 50px;
            height: 3px;
            background-color: var(--primary-color);
        }
        
        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 20px;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 3px 10px rgba(243, 156, 18, 0.3);
        }
        
        .contact-icon i {
            font-size: 1.3rem;
        }
        
        .contact-text {
            flex-grow: 1;
        }
        
        .contact-text h5 {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--dark-color);
        }
        
        .contact-text p {
            margin-bottom: 0;
            color: #666;
            line-height: 1.6;
        }
        
        .social-links-contact {
            display: flex;
            margin-top: 30px;
        }
        
        .social-links-contact a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-color);
            margin-left: 15px;
            transition: all 0.3s ease;
        }
        
        .social-links-contact a:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .contact-form {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 2;
        }
        
        .contact-form h3 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
            display: inline-block;
        }
        
        .contact-form h3::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: -10px;
            width: 50px;
            height: 3px;
            background-color: var(--primary-color);
        }
        
        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }
        
        .form-control {
            height: 50px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            padding: 10px 15px;
            color: #333;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 10px rgba(243, 156, 18, 0.1);
            background-color: white;
        }
        
        textarea.form-control {
            height: 150px;
            resize: none;
        }
        
        .btn-submit {
            background-color: var(--primary-color);
            border: none;
            color: white;
            border-radius: 30px;
            padding: 12px 35px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(243, 156, 18, 0.3);
        }
        
        .btn-submit:hover {
            background-color: #e67e22;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(243, 156, 18, 0.4);
        }
        
        /* Map Section */
        .map-section {
            padding-bottom: 70px;
        }
        
        .map-container {
            position: relative;
            height: 400px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Office Section */
        .offices-section {
            padding: 70px 0;
            background-color: #f5f5f5;
        }
        
        .office-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .office-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .office-img {
            height: 200px;
            position: relative;
            overflow: hidden;
        }
        
        .office-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }
        
        .office-card:hover .office-img img {
            transform: scale(1.1);
        }
        
        .office-info {
            padding: 20px;
        }
        
        .office-info h4 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }
        
        .office-info h4::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: -5px;
            width: 30px;
            height: 2px;
            background-color: var(--primary-color);
        }
        
        .office-address {
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        
        .office-address i {
            color: var(--primary-color);
            margin-left: 10px;
            font-size: 0.9rem;
            margin-top: 3px;
        }
        
        .office-address p {
            margin-bottom: 0;
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
        }
        
        .office-contact {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        
        .office-contact i {
            color: var(--primary-color);
            margin-left: 10px;
            font-size: 0.9rem;
        }
        
        .office-contact p, .office-contact a {
            margin-bottom: 0;
            color: #666;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .office-contact a:hover {
            color: var(--primary-color);
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
            
            .contact-info {
                margin-bottom: 30px;
            }
            
            .map-container {
                height: 350px;
            }
        }
        
        @media (max-width: 767px) {
            .hero-section h1 {
                font-size: 1.8rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .contact-icon {
                width: 40px;
                height: 40px;
                margin-left: 15px;
            }
            
            .contact-icon i {
                font-size: 1.1rem;
            }
            
            .map-container {
                height: 300px;
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
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>تواصل معنا</h1>
                    <p>نحن هنا للإجابة على جميع استفساراتك</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-section">
        <div class="container">
            <div class="section-title">
                <h2>اتصل بنا</h2>
                <p>يمكنك التواصل معنا عبر المعلومات التالية أو من خلال نموذج الاتصال</p>
            </div>
            
            <div class="row">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="contact-info" data-aos="fade-up">
                        <h3>معلومات الاتصال</h3>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-text">
                                <h5>العنوان</h5>
                                <p>الدمام، طريق الملك سعود، حي العنود، مبنى راحتي، الطابق الثاني</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="contact-text">
                                <h5>رقم الهاتف</h5>
                                <p dir="ltr">+966 59 991 2030</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-text">
                                <h5>البريد الإلكتروني</h5>
                                <p>info@company.com</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-text">
                                <h5>ساعات العمل</h5>
                                <p>الأحد - الخميس: 8:00 صباحاً - 5:00 مساءً</p>
                            </div>
                        </div>
                        
                        <div class="social-links-contact">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-7">
                    <div class="contact-form" data-aos="fade-up" data-aos-delay="100">
                        <h3>أرسل رسالة</h3>
                        <form id="contactForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">الاسم الكامل</label>
                                        <input type="text" class="form-control" id="name" placeholder="أدخل الاسم الكامل" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">رقم الجوال</label>
                                        <input type="tel" class="form-control" id="phone" placeholder="05xxxxxxxx" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control" id="email" placeholder="email@example.com" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="subject" class="form-label">الموضوع</label>
                                <input type="text" class="form-control" id="subject" placeholder="موضوع الرسالة">
                            </div>
                            
                            <div class="mb-4">
                                <label for="message" class="form-label">الرسالة</label>
                                <textarea class="form-control" id="message" rows="5" placeholder="اكتب رسالتك هنا..." required></textarea>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-submit">إرسال الرسالة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="map-container" data-aos="fade-up">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d230602.45478554277!2d49.95126270089393!3d26.40478299459096!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e49ef85c961baef%3A0xc433ddcc93240a6f!2sDammam%20Saudi%20Arabia!5e0!3m2!1sen!2s!4v1633008924582!5m2!1sen!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <!-- Offices Section -->
    <section class="offices-section">
        <div class="container">
            <div class="section-title">
                <h2>فروعنا</h2>
                <p>يمكنك زيارة أحد فروعنا في المدن التالية</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="office-card">
                        <div class="office-img">
                            <img src="https://images.unsplash.com/photo-1603417406253-4c65c06974c2?q=80&w=1000&auto=format&fit=crop" alt="مكتب الدمام">
                        </div>
                        <div class="office-info">
                            <h4>فرع الدمام (المقر الرئيسي)</h4>
                            <div class="office-address">
                                <i class="fas fa-map-marker-alt"></i>
                                <p>طريق الملك سعود، حي العنود، مبنى راحتي، الطابق الثاني</p>
                            </div>
                            <div class="office-contact">
                                <i class="fas fa-phone-alt"></i>
                                <p dir="ltr">+966 59 991 2030</p>
                            </div>
                            <div class="office-contact">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:dammam@company.com">dammam@company.com</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="office-card">
                        <div class="office-img">
                            <img src="https://images.unsplash.com/photo-1566159196870-3243b33668ed?q=80&w=1000&auto=format&fit=crop" alt="مكتب الرياض">
                        </div>
                        <div class="office-info">
                            <h4>فرع الرياض</h4>
                            <div class="office-address">
                                <i class="fas fa-map-marker-alt"></i>
                                <p>طريق الملك فهد، حي العليا، برج المملكة، الطابق 15</p>
                            </div>
                            <div class="office-contact">
                                <i class="fas fa-phone-alt"></i>
                                <p dir="ltr">+966 59 991 2031</p>
                            </div>
                            <div class="office-contact">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:riyadh@company.com">riyadh@company.com</a>
                            </div>
                        </div>
                            </div>
                            <div class="office-contact">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:riyadh@company.com">riyadh@company.com</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Office: Jeddah -->
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="office-card">
                        <div class="office-img">
                            <img src="https://images.unsplash.com/photo-1581091012184-5c64c13049f7?q=80&w=1000&auto=format&fit=crop" alt="مكتب جدة">
                        </div>
                        <div class="office-info">
                            <h4>فرع جدة</h4>
                            <div class="office-address">
                                <i class="fas fa-map-marker-alt"></i>
                                <p>شارع الأمير سلطان، حي الزهراء، مركز الأعمال، الطابق الثالث</p>
                            </div>
                            <div class="office-contact">
                                <i class="fas fa-phone-alt"></i>
                                <p dir="ltr">+966 59 991 2032</p>
                            </div>
                            <div class="office-contact">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:jeddah@company.com">jeddah@company.com</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- About -->
                <div class="col-md-4">
                    <div class="footer-logo">
                        <img src="https://placeholder.pics/svg/150x50/333333/ffffff/LOGO" alt="Logo">
                    </div>
                    <div class="footer-about">
                        <p>شركة انجاز النوادي للمقاولات العامة تقدم حلولاً هندسية متكاملة في مجالات المقاولات والبناء والتطوير العقاري.</p>
                    </div>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Links -->
                <div class="col-md-4">
                    <h4>روابط مهمة</h4>
                    <ul class="footer-links">
                        <li><a href="index.html">الرئيسية</a></li>
                        <li><a href="about.html">عن الشركة</a></li>
                        <li><a href="services.html">خدماتنا</a></li>
                        <li><a href="projects.html">مشاريعنا</a></li>
                        <li><a href="contact.html">اتصل بنا</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-md-4">
                    <h4>تواصل معنا</h4>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> الدمام، طريق الملك سعود، مبنى راحتي</li>
                        <li><i class="fas fa-phone-alt"></i> +966 59 991 2030</li>
                        <li><i class="fas fa-envelope"></i> info@company.com</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                &copy; 2025 <a href="#">شركة انجاز النوادي</a>. جميع الحقوق محفوظة.
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <div class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init();

        // Back to top functionality
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTop.classList.add('active');
            } else {
                backToTop.classList.remove('active');
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Language toggle placeholder
        function toggleLanguage() {
            window.location.href = "contact-en.html";
        }
    </script>
</body>
</html>
                                    