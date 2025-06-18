<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نجد القمم | خدمات المقاولات</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap');
        
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8f9fa;
        }
        
        .hero-section {
            background-image: linear-gradient(rgba(0, 56, 56, 0.7), rgba(0, 56, 56, 0.9)), url('/api/placeholder/1200/600');
            background-size: cover;
            background-position: center;
        }
        
        .teal-gradient {
            background: linear-gradient(135deg, #12758a 0%, #003838 100%);
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .project-card:hover img {
            transform: scale(1.05);
        }

        .project-card img {
            transition: transform 0.5s ease;
        }
        
        .contact-form input, .contact-form textarea {
            border: 1px solid #e2e8f0;
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        
        .counter-box {
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .counter-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="bg-white shadow-md py-4">
        <div class="container mx-auto px-4 md:px-6 flex justify-between items-center">
            <a href="#" class="flex items-center">
                <img src="/api/placeholder/250/81" alt="نجد القمم" class="h-12">
            </a>
            <div class="hidden md:flex items-center space-x-4">
                <a href="#" class="mx-2 text-gray-700 hover:text-teal-600 transition-colors">الرئيسية</a>
                <a href="#about" class="mx-2 text-gray-700 hover:text-teal-600 transition-colors">من نحن</a>
                <a href="#services" class="mx-2 text-teal-600 font-bold">خدمات المقاولات</a>
                <a href="#projects" class="mx-2 text-gray-700 hover:text-teal-600 transition-colors">مشاريعنا</a>
                <a href="#contact" class="mx-2 text-gray-700 hover:text-teal-600 transition-colors">اتصل بنا</a>
            </div>
            <button class="block md:hidden focus:outline-none">
                <i class="fas fa-bars text-gray-700 text-xl"></i>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-white py-24 px-4">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">خدمات المقاولات من نجد القمم</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">نحول رؤيتك إلى واقع ملموس مع أكثر من 10 سنوات من الخبرة في مجال المقاولات العامة</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#services" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full transition-colors">خدماتنا</a>
                <a href="#contact" class="bg-transparent hover:bg-white hover:text-teal-800 text-white font-bold py-3 px-8 border-2 border-white rounded-full transition-colors">تواصل معنا</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 px-4 bg-white">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <img src="/api/placeholder/600/400" alt="عن نجد القمم" class="rounded-lg shadow-lg">
                </div>
                <div class="md:w-1/2 md:pr-12">
                    <h2 class="text-3xl font-bold mb-6 text-gray-800">عن شركة إنجاز البوادي للمقاولات</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        تأسست في تبوك مع أكثر من 10 سنوات من الخبرة في المقاولات العامة وتنفيذ المشاريع. نمتلك سجل حافل من المشاريع الناجحة في جميع أنحاء المملكة، ونتوافق مع رؤية 2030 من خلال الجودة والسرعة والابتكار.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div class="flex items-start">
                            <div class="text-teal-600 mr-4">
                                <i class="fas fa-building text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">البناء المتكامل</h3>
                                <p class="text-gray-600">تنفيذ مشاريع البناء بجودة عالية وفي الوقت المحدد</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="text-teal-600 mr-4">
                                <i class="fas fa-road text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">البنية التحتية</h3>
                                <p class="text-gray-600">تطوير وتنفيذ مشاريع البنية التحتية المتكاملة</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="text-teal-600 mr-4">
                                <i class="fas fa-hammer text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">التجديد</h3>
                                <p class="text-gray-600">خدمات التجديد والترميم للمباني القائمة</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="text-teal-600 mr-4">
                                <i class="fas fa-paint-roller text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">التشطيبات</h3>
                                <p class="text-gray-600">تشطيبات داخلية وخارجية بأعلى مستويات الجودة</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="teal-gradient text-white py-16 px-4">
        <div class="container mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">أرقام تتحدث عن إنجازاتنا</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white bg-opacity-10 counter-box">
                    <div class="text-4xl font-bold mb-2">+10</div>
                    <div class="text-lg">سنوات من الخبرة</div>
                </div>
                <div class="bg-white bg-opacity-10 counter-box">
                    <div class="text-4xl font-bold mb-2">+50</div>
                    <div class="text-lg">مشروع منجز</div>
                </div>
                <div class="bg-white bg-opacity-10 counter-box">
                    <div class="text-4xl font-bold mb-2">+30</div>
                    <div class="text-lg">عميل راضٍ</div>
                </div>
                <div class="bg-white bg-opacity-10 counter-box">
                    <div class="text-4xl font-bold mb-2">+100</div>
                    <div class="text-lg">موظف محترف</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 px-4 bg-gray-50">
        <div class="container mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4 text-gray-800">خدمات المقاولات</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">نقدم مجموعة متكاملة من خدمات المقاولات العامة لتلبية احتياجات عملائنا في القطاعين العام والخاص</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-md p-6 service-card transition-all duration-300">
                    <div class="bg-teal-100 text-teal-700 w-16 h-16 flex items-center justify-center rounded-full mb-6 mx-auto">
                        <i class="fas fa-building text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-center text-gray-800">البناء المتكامل</h3>
                    <p class="text-gray-600 text-center">تنفيذ مشاريع البناء السكنية والتجارية والصناعية بمختلف أحجامها، مع الالتزام بأعلى معايير الجودة والسلامة.</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 service-card transition-all duration-300">
                    <div class="bg-teal-100 text-teal-700 w-16 h-16 flex items-center justify-center rounded-full mb-6 mx-auto">
                        <i class="fas fa-road text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-center text-gray-800">البنية التحتية</h3>
                    <p class="text-gray-600 text-center">تنفيذ مشاريع البنية التحتية بما في ذلك الطرق والجسور وشبكات المياه والصرف الصحي وأعمال الحفر والردم.</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 service-card transition-all duration-300">
                    <div class="bg-teal-100 text-teal-700 w-16 h-16 flex items-center justify-center rounded-full mb-6 mx-auto">
                        <i class="fas fa-hotel text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-center text-gray-800">المشاريع السياحية</h3>
                    <p class="text-gray-600 text-center">تطوير وتنفيذ المشاريع السياحية مثل الفنادق والمنتجعات والشاليهات بتصاميم عصرية ومواصفات عالمية.</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 service-card transition-all duration-300">
                    <div class="bg-teal-100 text-teal-700 w-16 h-16 flex items-center justify-center rounded-full mb-6 mx-auto">
                        <i class="fas fa-hammer text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-center text-gray-800">التجديد والترميم</h3>
                    <p class="text-gray-600 text-center">خدمات التجديد والترميم للمباني القائمة، مع الحفاظ على الطابع المعماري الأصلي وتحسين كفاءة المبنى.</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 service-card transition-all duration-300">
                    <div class="bg-teal-100 text-teal-700 w-16 h-16 flex items-center justify-center rounded-full mb-6 mx-auto">
                        <i class="fas fa-paint-roller text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-center text-gray-800">التشطيبات</h3>
                    <p class="text-gray-600 text-center">تنفيذ أعمال التشطيبات الداخلية والخارجية بمختلف أنواعها، بما في ذلك الدهانات والديكورات والأرضيات.</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 service-card transition-all duration-300">
                    <div class="bg-teal-100 text-teal-700 w-16 h-16 flex items-center justify-center rounded-full mb-6 mx-auto">
                        <i class="fas fa-project-diagram text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-center text-gray-800">إدارة المشاريع</h3>
                    <p class="text-gray-600 text-center">خدمات إدارة المشاريع الإنشائية المتكاملة، بدءًا من مرحلة التخطيط وحتى التسليم النهائي.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Project -->
    <section class="py-16 px-4 bg-white">
        <div class="container mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4 text-gray-800">مشاريع استثمارية مميزة</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">نقدم فرص استثمارية مميزة في محافظة حقل على ساحل البحر الأحمر</p>
            </div>
            <div class="flex flex-col lg:flex-row items-center bg-gray-50 rounded-xl overflow-hidden">
                <div class="lg:w-1/2">
                    <img src="/api/placeholder/600/400" alt="مشروع فندق حقل" class="w-full h-full object-cover">
                </div>
                <div class="lg:w-1/2 p-8">
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">فرصة استثمارية: فندق 4 نجوم على ساحل البحر الأحمر</h3>
                    <div class="mb-6">
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-teal-600 mt-1 ml-2"></i>
                                <span>مبنى فندقي شبه مكتمل بمساحة 16,910 م² على الواجهة البحرية</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-teal-600 mt-1 ml-2"></i>
                                <span>146 غرفة فندقية جاهزة تحتاج فقط للتشطيبات النهائية والتجهيز</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-teal-600 mt-1 ml-2"></i>
                                <span>عائد استثماري متوقع 20-25% سنوياً بعد الاستقرار</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-teal-600 mt-1 ml-2"></i>
                                <span>معدل إشغال متوقع 70-80% مع دعم السياحة في المنطقة</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-teal-600 mt-1 ml-2"></i>
                                <span>موقع استراتيجي في قلب مثلث السياحة المستقبلي بالقرب من نيوم وتبوك</span>
                            </li>
                        </ul>
                    </div>
                    <a href="#contact" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full transition-colors">طلب مزيد من المعلومات</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="py-20 px-4 bg-gray-50">
        <div class="container mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4 text-gray-800">مشاريعنا السابقة</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">نفخر بتنفيذ العديد من المشاريع الناجحة في مختلف مناطق المملكة</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden project-card">
                    <div class="h-60 overflow-hidden">
                        <img src="/api/placeholder/400/300" alt="مشروع 1" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-gray-800">مشروع إسكان حكومي</h3>
                        <p class="text-gray-600 mb-4">تنفيذ 50 وحدة سكنية متكاملة مع البنية التحتية في منطقة تبوك.</p>
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>المدة: 18 شهر</span>
                            <span>الموقع: تبوك</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md overflow-hidden project-card">
                    <div class="h-60 overflow-hidden">
                        <img src="/api/placeholder/400/300" alt="مشروع 2" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-gray-800">مجمع تجاري</h3>
                        <p class="text-gray-600 mb-4">تصميم وتنفيذ مجمع تجاري على مساحة 5000 م² في مدينة حقل.</p>
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>المدة: 12 شهر</span>
                            <span>الموقع: حقل</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md overflow-hidden project-card">
                    <div class="h-60 overflow-hidden">
                        <img src="/api/placeholder/400/300" alt="مشروع 3" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-gray-800">مشروع بنية تحتية</h3>
                        <p class="text-gray-600 mb-4">تنفيذ أعمال الطرق والبنية التحتية لحي سكني جديد بطول 15 كم.</p>
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>المدة: 24 شهر</span>
                            <span>الموقع: المدينة المنورة</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-12">
                <a href="#" class="inline-block border-2 border-teal-600 text-teal-600 hover:bg-teal-600 hover:text-white font-bold py-3 px-8 rounded-full transition-colors">عرض المزيد من المشاريع</a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 px-4 teal-gradient text-white">
        <div class="container mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">لماذا تختار نجد القمم للمقاولات؟</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-white bg-opacity-10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-medal text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">الجودة العالية</h3>
                    <p class="opacity-80">نلتزم بأعلى معايير الجودة في جميع مراحل المشروع من التصميم إلى التنفيذ.</p>
                </div>
                <div class="text-center">
                    <div class="bg-white bg-opacity-10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-clock text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">الالتزام بالمواعيد</h3>
                    <p class="opacity-80">نحرص على تسليم المشاريع في الوقت المحدد دون تأخير مع الحفاظ على الجودة.</p>
                </div>
                <div class="text-center">
                    <div class="bg-white bg-opacity-10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">فريق محترف</h3>
                    <p class="opacity-80">نمتلك فريق عمل من المهندسين والفنيين المؤهلين وذوي الخبرة العالية.</p>
                </div>
                <div class="text-center">
                    <div class="bg-white bg-opacity-10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-handshake text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">الشفافية والمصداقية</h3>
                    <p class="opacity-80">نؤمن بأهمية الشفافية والمصداقية في التعامل مع عملائنا طوال مراحل المشروع.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Clients -->
    <section class="py-16 px-4 bg-white">
        <div class="container mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4 text-gray-800">عملاؤنا</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">نفتخر بثقة العديد من الجهات الحكومية والشركات الخاصة في خدماتنا</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <div class="flex items-center justify-center p-4 border rounded-lg">
                    <img src="/api/placeholder/120/60" alt="عميل 1" class="grayscale hover:grayscale-0 transition-all">
                </div>
                <div class="flex items-center justify-center p-4 border rounded-lg">
                    <img src="/api/placeholder/120/60" alt="عميل 2" class="grayscale hover:grayscale-0 transition-all">
                </div>
                <div class="flex items-center justify-center p-4 border rounded-lg">
                    <img src="/api/placeholder/120/60" alt="عميل 3" class="grayscale hover:grayscale-0 transition-all">
                </div>
                <div class="flex items-center justify-center p-4 border rounded-lg">
                    <img src="/api/placeholder/120/60" alt="عميل 4" class="grayscale hover:grayscale-0 transition-all">
                </div>
                <div class="flex items-center justify-center p-4 border rounded-lg">
                    <img src="/api/placeholder/120/60" alt="عميل 5" class="grayscale hover:grayscale-0 transition-all">
                </div>
                <div class="flex items-center justify-center p-4 border rounded-lg">
                    <img src="/api/placeholder/120/60" alt="عميل 6" class="grayscale hover:grayscale-0 transition-all">
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 px-4 bg-yellow-500 text-white">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-6">جاهزون لتحويل أفكارك إلى واقع ملموس</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">تواصل معنا اليوم لمناقشة مشروعك والحصول على استشارة مجانية</p>
            <a href="#contact" class="inline-block bg-white text-yellow-600 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition-colors">تواصل معنا الآن</a>
        </div>
    </section>

    <!-- Contact -->