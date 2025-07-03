<?php
// Environment variables for email configuration
$smtp_email = $_ENV['SMTP_EMAIL'] ?? getenv('SMTP_EMAIL') ?? '';
$smtp_password = $_ENV['SMTP_PASSWORD'] ?? getenv('SMTP_PASSWORD') ?? '';
$recipient_email = $_ENV['RECIPIENT_EMAIL'] ?? getenv('RECIPIENT_EMAIL') ?? '';

// Fallback configuration (for testing only - remove in production)
// Uncomment and set these values for testing, then comment them out and use environment variables
/*
$smtp_email = 'your-email@gmail.com';
$smtp_password = 'your-app-password';
$recipient_email = 'info@najidalqimam.sa';
*/

// Initialize response variables
$success_message = '';
$error_message = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_quote'])) {
    // Sanitize and validate input data
    $full_name = filter_var(trim($_POST['full_name'] ?? ''), FILTER_SANITIZE_STRING);
    $phone = filter_var(trim($_POST['phone'] ?? ''), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $location = filter_var(trim($_POST['location'] ?? ''), FILTER_SANITIZE_STRING);
    $project_area = filter_var(trim($_POST['project_area'] ?? ''), FILTER_SANITIZE_STRING);
    $start_date = filter_var(trim($_POST['start_date'] ?? ''), FILTER_SANITIZE_STRING);
    $additional_details = filter_var(trim($_POST['additional_details'] ?? ''), FILTER_SANITIZE_STRING);
    
    // Handle project types (checkboxes)
    $project_types = [];
    if (isset($_POST['project_type'])) {
        foreach ($_POST['project_type'] as $type) {
            $project_types[] = filter_var($type, FILTER_SANITIZE_STRING);
        }
    }
    $project_types_str = implode(', ', $project_types);
    
    // Basic validation
    $errors = [];
    if (empty($full_name)) $errors[] = 'الاسم الكامل مطلوب';
    if (empty($phone)) $errors[] = 'رقم الجوال مطلوب';
    if (empty($email)) $errors[] = 'البريد الإلكتروني غير صحيح';
    if (empty($location)) $errors[] = 'المدينة / الموقع مطلوب';
    if (empty($recipient_email)) $errors[] = 'خطأ في إعدادات النظام - البريد المستقبل غير محدد';
    
    if (empty($errors)) {
        // Prepare email content
        $subject = "طلب عرض سعر جديد من موقع نجد القمم - " . $full_name;
        
        $message = "
        <html dir='rtl'>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Tahoma, Arial, sans-serif; line-height: 1.6; color: #333; }
                .header { background-color: #12758a; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; }
                .field { margin-bottom: 15px; }
                .label { font-weight: bold; color: #12758a; }
                .value { margin-top: 5px; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h2>طلب عرض سعر جديد</h2>
                <p>مؤسسة نجد القمم للمقاولات</p>
            </div>
            <div class='content'>
                <div class='field'>
                    <div class='label'>الاسم الكامل:</div>
                    <div class='value'>" . htmlspecialchars($full_name) . "</div>
                </div>
                
                <div class='field'>
                    <div class='label'>رقم الجوال:</div>
                    <div class='value'>" . htmlspecialchars($phone) . "</div>
                </div>
                
                <div class='field'>
                    <div class='label'>البريد الإلكتروني:</div>
                    <div class='value'>" . htmlspecialchars($email) . "</div>
                </div>
                
                <div class='field'>
                    <div class='label'>المدينة / الموقع:</div>
                    <div class='value'>" . htmlspecialchars($location) . "</div>
                </div>
                
                <div class='field'>
                    <div class='label'>نوع المشروع:</div>
                    <div class='value'>" . htmlspecialchars($project_types_str ?: 'غير محدد') . "</div>
                </div>
                
                <div class='field'>
                    <div class='label'>مساحة المشروع:</div>
                    <div class='value'>" . htmlspecialchars($project_area ?: 'غير محدد') . "</div>
                </div>
                
                <div class='field'>
                    <div class='label'>تاريخ البدء المتوقع:</div>
                    <div class='value'>" . htmlspecialchars($start_date ?: 'غير محدد') . "</div>
                </div>
                
                <div class='field'>
                    <div class='label'>تفاصيل إضافية:</div>
                    <div class='value'>" . nl2br(htmlspecialchars($additional_details ?: 'لا توجد تفاصيل إضافية')) . "</div>
                </div>
                
                <hr style='margin: 20px 0;'>
                <p style='color: #666; font-size: 12px;'>تم إرسال هذا الطلب من موقع نجد القمم للمقاولات<br>
                تاريخ الإرسال: " . date('Y-m-d H:i:s') . "</p>
            </div>
        </body>
        </html>";
        
        // Email headers
        $headers = array(
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: ' . $smtp_email,
            'Reply-To: ' . $email,
            'X-Mailer: PHP/' . phpversion()
        );
        
        // Send email
        if (mail($recipient_email, $subject, $message, implode("\r\n", $headers))) {
            $success_message = 'تم إرسال طلبك بنجاح! سنتواصل معك قريباً.';
            // Clear form data on success
            $_POST = array();
        } else {
            $error_message = 'حدث خطأ في إرسال الطلب. يرجى المحاولة مرة أخرى أو التواصل معنا مباشرة.';
        }
    } else {
        $error_message = implode('<br>', $errors);
    }
}
?>
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
                <img src="static/top_logo.png" alt="نجد القمم" class="h-12 object-contain">
            </a>
            <div class="hidden md:flex items-center space-x-4">
                <a href="#" class="mx-2 text-gray-700 hover:text-teal-600 transition-colors">الرئيسية</a>
                <a href="#about" class="mx-2 text-gray-700 hover:text-teal-600 transition-colors">من نحن</a>
                <a href="#services" class="mx-2 text-gray-700 hover:text-teal-600 transition-colors">خدمات المقاولات</a>
                <a href="#projects" class="mx-2 text-gray-700 hover:text-teal-600 transition-colors">مشاريعنا</a>
                <a href="#jobs" class="mx-2 text-gray-700 hover:text-teal-600 transition-colors">فرص العمل</a>
                <a href="#gallery" class="mx-2 text-gray-700 hover:text-teal-600 transition-colors">معرض الصور</a>
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
                    <img src="static/3.png" alt="عن نجد القمم" class="rounded-lg shadow-lg">
                </div>
                <div class="md:w-1/2 md:pr-12">
                    <h2 class="text-3xl font-bold mb-6 text-gray-800">عن مؤسسة نجد القمم للمقاولات</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        نحن مؤسسة سعودية متخصصة في تقديم خدمات المقاولات العامة والتشطيبات الداخلية والخارجية، مع توفير حلول مبتكرة للمشاريع الكبيرة والصغيرة على حد سواء. نتميز بخبرة واسعة واهتمام عميق بالتفاصيل، مما يضمن تنفيذ المشاريع وفق أعلى معايير الجودة والمهنية.
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

    <!-- Vision and Mission Section -->
    <section class="py-20 px-4 bg-white">
        <div class="container mx-auto">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2">
                    <img src="static/1.png" alt="رؤيتنا ورسالتنا" class="rounded-lg shadow-lg">
                </div>
                <div class="lg:w-1/2">
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold mb-6 text-gray-800">رؤيتنا</h2>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            أن نكون رائدين في مجال المقاولات بالمملكة، حيث نساهم في تطوير البنية التحتية وتعزيز التجربة العمرانية من خلال تقديم خدمات متكاملة تحقق تطلعات عملائنا.
                        </p>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold mb-6 text-gray-800">رسالتنا</h2>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            تحقيق التميز في تنفيذ المشاريع على اختلاف أنواعها، وضمان الجودة العالية والتسليم في الوقت المحدد، مع الاهتمام البالغ بكل التفاصيل لضمان رضا عملائنا.
                        </p>
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
                    <h3 class="text-xl font-bold mb-4 text-center text-gray-800">مقاولات عامة</h3>
                    <p class="text-gray-600 text-center">تنفيذ مشاريع سكنية وتجارية وصناعية بأعلى معايير الجودة والمهنية.</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 service-card transition-all duration-300">
                    <div class="bg-teal-100 text-teal-700 w-16 h-16 flex items-center justify-center rounded-full mb-6 mx-auto">
                        <i class="fas fa-paint-roller text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-center text-gray-800">تشطيبات داخلية وخارجية</h3>
                    <p class="text-gray-600 text-center">تلبية كافة احتياجات التشطيب للمباني بجودة عالية ودقة في التنفيذ.</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 service-card transition-all duration-300">
                    <div class="bg-teal-100 text-teal-700 w-16 h-16 flex items-center justify-center rounded-full mb-6 mx-auto">
                        <i class="fas fa-home text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-center text-gray-800">واجهات معمارية</h3>
                    <p class="text-gray-600 text-center">تصميم وتنفيذ واجهات مبتكرة وجذابة تعكس الذوق الرفيع والطابع المعماري المميز.</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 service-card transition-all duration-300">
                    <div class="bg-teal-100 text-teal-700 w-16 h-16 flex items-center justify-center rounded-full mb-6 mx-auto">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-center text-gray-800">عزل حراري ومائي</h3>
                    <p class="text-gray-600 text-center">توفير حلول فعّالة للعزل لضمان توفير الطاقة وحماية المباني من العوامل الجوية.</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 service-card transition-all duration-300">
                    <div class="bg-teal-100 text-teal-700 w-16 h-16 flex items-center justify-center rounded-full mb-6 mx-auto">
                        <i class="fas fa-hammer text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-center text-gray-800">ترميم وصيانة</h3>
                    <p class="text-gray-600 text-center">أعمال صيانة شاملة لجميع أنواع المنشآت مع ضمان الجودة والمتانة.</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 service-card transition-all duration-300">
                    <div class="bg-teal-100 text-teal-700 w-16 h-16 flex items-center justify-center rounded-full mb-6 mx-auto">
                        <i class="fas fa-project-diagram text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-center text-gray-800">إدارة وتنفيذ مشاريع</h3>
                    <p class="text-gray-600 text-center">التخطيط والتنفيذ الفعّال للمشاريع بأعلى مستوى من الاحترافية والخبرة.</p>
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
                        <img src="static/3.png" alt="مشروع 1" class="w-full h-full object-cover">
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
                        <img src="static/7.png" alt="مشروع 2" class="w-full h-full object-cover">
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
                        <img src="static/5.png" alt="مشروع 3" class="w-full h-full object-cover">
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

    <!-- Jobs Section -->
    <section id="jobs" class="py-20 px-4 bg-white">
        <div class="container mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4 text-gray-800">فرص العمل</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">نحن دائماً نبحث عن كفاءات جديدة للانضمام إلى فريقنا المتميز</p>
            </div>
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-10 lg:mb-0">
                    <img src="static/2.png" alt="فرص العمل" class="rounded-lg shadow-lg">
                </div>
                <div class="lg:w-1/2 lg:pr-12">
                    <p class="text-gray-600 mb-8 leading-relaxed text-lg">
                        انضم إلينا لتكون جزءاً من فريق متميز يقدم خدمات مهنية عالية ويساهم في بناء مستقبل المملكة.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <div class="flex items-center mb-4">
                                <div class="bg-teal-100 text-teal-700 w-12 h-12 flex items-center justify-center rounded-full mr-4">
                                    <i class="fas fa-hard-hat text-xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800">مهندس موقع</h3>
                            </div>
                            <p class="text-gray-600">إشراف وإدارة المشاريع الإنشائية</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <div class="flex items-center mb-4">
                                <div class="bg-teal-100 text-teal-700 w-12 h-12 flex items-center justify-center rounded-full mr-4">
                                    <i class="fas fa-paint-brush text-xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800">مشرف تشطيبات</h3>
                            </div>
                            <p class="text-gray-600">إشراف على أعمال التشطيب والديكور</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <div class="flex items-center mb-4">
                                <div class="bg-teal-100 text-teal-700 w-12 h-12 flex items-center justify-center rounded-full mr-4">
                                    <i class="fas fa-paint-roller text-xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800">فني دهانات</h3>
                            </div>
                            <p class="text-gray-600">تنفيذ أعمال الدهان بمهارة عالية</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <div class="flex items-center mb-4">
                                <div class="bg-teal-100 text-teal-700 w-12 h-12 flex items-center justify-center rounded-full mr-4">
                                    <i class="fas fa-handshake text-xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800">موظفو علاقات عملاء</h3>
                            </div>
                            <p class="text-gray-600">خدمة العملاء والتواصل الفعال</p>
                        </div>
                    </div>
                    <div class="mt-8">
                        <a href="#contact" class="inline-block bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-8 rounded-full transition-colors">تقدم للوظيفة</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Responsibility Section -->
    <section class="py-16 px-4 bg-gray-50">
        <div class="container mx-auto">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 lg:pl-12 mb-10 lg:mb-0">
                    <h2 class="text-3xl font-bold mb-6 text-gray-800">المسؤولية الاجتماعية</h2>
                    <p class="text-gray-600 leading-relaxed text-lg mb-6">
                        نلتزم في "نجد القمم" بمسؤوليتنا الاجتماعية من خلال دعم مشاريع بيئية وتنموية محليًا، بالإضافة إلى البرامج التدريبية التي تساهم في تطوير الشباب السعودي وتوفير فرص العمل.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <i class="fas fa-leaf text-teal-600 mt-2 ml-3"></i>
                            <span class="text-gray-600">دعم المشاريع البيئية والاستدامة</span>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-graduation-cap text-teal-600 mt-2 ml-3"></i>
                            <span class="text-gray-600">برامج تدريبية لتطوير الشباب السعودي</span>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-briefcase text-teal-600 mt-2 ml-3"></i>
                            <span class="text-gray-600">توفير فرص عمل للمجتمع المحلي</span>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <img src="static/4.png" alt="المسؤولية الاجتماعية" class="rounded-lg shadow-lg">
                </div>
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

    <!-- Gallery Section -->
    <section id="gallery" class="py-20 px-4 bg-gray-50">
        <div class="container mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4 text-gray-800">معرض الصور</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">تعرف على مشاريعنا السابقة من خلال معارض الصور التي تبرز عملنا المتميز في تنفيذ المشاريع المتنوعة</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="group relative overflow-hidden rounded-lg shadow-lg">
                    <img src="static/6.png" alt="مشروع 1" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">مشروع سكني</h3>
                            <p class="text-sm">تنفيذ متكامل وتشطيبات عالية الجودة</p>
                        </div>
                    </div>
                </div>
                <div class="group relative overflow-hidden rounded-lg shadow-lg">
                    <img src="static/8.png" alt="مشروع 2" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">مشروع تجاري</h3>
                            <p class="text-sm">تصميم عصري ومساحات مُحسنة</p>
                        </div>
                    </div>
                </div>
                <div class="group relative overflow-hidden rounded-lg shadow-lg">
                    <img src="static/9.png" alt="مشروع 3" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">واجهات معمارية</h3>
                            <p class="text-sm">إبداع في التصميم ودقة في التنفيذ</p>
                        </div>
                    </div>
                </div>
                <div class="group relative overflow-hidden rounded-lg shadow-lg">
                    <img src="static/1.png" alt="مشروع 4" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">تشطيبات داخلية</h3>
                            <p class="text-sm">لمسات فنية وجودة استثنائية</p>
                        </div>
                    </div>
                </div>
                <div class="group relative overflow-hidden rounded-lg shadow-lg">
                    <img src="static/2.png" alt="مشروع 5" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">مشروع صناعي</h3>
                            <p class="text-sm">حلول متقدمة للمنشآت الصناعية</p>
                        </div>
                    </div>
                </div>
                <div class="group relative overflow-hidden rounded-lg shadow-lg">
                    <img src="static/4.png" alt="مشروع 6" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">أعمال الترميم</h3>
                            <p class="text-sm">إعادة إحياء المباني بمعايير حديثة</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-12">
                <a href="#contact" class="inline-block border-2 border-teal-600 text-teal-600 hover:bg-teal-600 hover:text-white font-bold py-3 px-8 rounded-full transition-colors">طلب عرض سعر لمشروعك</a>
            </div>
        </div>
    </section>

    <!-- Customer Reviews Section -->
    <section class="py-16 px-4 bg-white">
        <div class="container mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4 text-gray-800">آراء العملاء</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">ما يقوله عملاؤنا عن خدماتنا وجودة عملنا</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="bg-gray-50 p-8 rounded-lg shadow-md">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-teal-600 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">عبدالله العتيبي</h4>
                            <div class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic leading-relaxed">
                        "احترافية وجودة تنفيذ ممتازة… سعدت بالتعامل مع نجد القمم. فريق محترف والتزام رائع بالمواعيد."
                    </p>
                </div>
                <div class="bg-gray-50 p-8 rounded-lg shadow-md">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-teal-600 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">محمد السبيعي</h4>
                            <div class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic leading-relaxed">
                        "تنظيم ودقة في التسليم والتزام رائع… شكراً لكم. أنصح بالتعامل معهم لأي مشروع إنشائي."
                    </p>
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
    <section id="contact" class="py-20 px-4 bg-gray-50">
        <div class="container mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4 text-gray-800">تواصل معنا</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">نحن هنا لخدمتك، تواصل معنا للحصول على استشارة مجانية أو لطلب عرض سعر</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">معلومات التواصل</h3>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-teal-600 text-white w-12 h-12 flex items-center justify-center rounded-full mr-4">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-2">رقم الجوال</h4>
                                <p class="text-gray-600">0553038352</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-teal-600 text-white w-12 h-12 flex items-center justify-center rounded-full mr-4">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-2">البريد الإلكتروني</h4>
                                <p class="text-gray-600">ahmed@najidalqimam.sa</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-teal-600 text-white w-12 h-12 flex items-center justify-center rounded-full mr-4">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-2">الموقع</h4>
                                <p class="text-gray-600">المملكة العربية السعودية</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-teal-600 text-white w-12 h-12 flex items-center justify-center rounded-full mr-4">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-2">واتساب</h4>
                                <a href="https://wa.me/966553038352" class="text-gray-600 hover:text-teal-600">0553038352</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">طلب عرض سعر</h3>
                    
                    <?php if (!empty($success_message)): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>
                            <?php echo $success_message; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($error_message)): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form class="contact-form" method="POST" action="">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <input type="text" name="full_name" placeholder="الاسم الكامل" value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" class="border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-teal-600" required>
                            <input type="tel" name="phone" placeholder="رقم الجوال" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" class="border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-teal-600" required>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <input type="email" name="email" placeholder="البريد الإلكتروني" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" class="border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-teal-600" required>
                            <input type="text" name="location" placeholder="المدينة / الموقع" value="<?php echo htmlspecialchars($_POST['location'] ?? ''); ?>" class="border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-teal-600" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">نوع المشروع:</label>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <label class="flex items-center">
                                    <input type="checkbox" name="project_type[]" value="سكني" <?php echo (isset($_POST['project_type']) && in_array('سكني', $_POST['project_type'])) ? 'checked' : ''; ?> class="mr-2"> سكني
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="project_type[]" value="تجاري" <?php echo (isset($_POST['project_type']) && in_array('تجاري', $_POST['project_type'])) ? 'checked' : ''; ?> class="mr-2"> تجاري
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="project_type[]" value="صناعي" <?php echo (isset($_POST['project_type']) && in_array('صناعي', $_POST['project_type'])) ? 'checked' : ''; ?> class="mr-2"> صناعي
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="project_type[]" value="ترميم / صيانة" <?php echo (isset($_POST['project_type']) && in_array('ترميم / صيانة', $_POST['project_type'])) ? 'checked' : ''; ?> class="mr-2"> ترميم / صيانة
                                </label>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <input type="text" name="project_area" placeholder="مساحة المشروع (م²)" value="<?php echo htmlspecialchars($_POST['project_area'] ?? ''); ?>" class="border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-teal-600">
                            <input type="date" name="start_date" placeholder="تاريخ البدء المتوقع" value="<?php echo htmlspecialchars($_POST['start_date'] ?? ''); ?>" class="border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-teal-600">
                        </div>
                        <textarea name="additional_details" rows="4" placeholder="تفاصيل إضافية أو متطلبات خاصة" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-teal-600 mb-4"><?php echo htmlspecialchars($_POST['additional_details'] ?? ''); ?></textarea>
                        <button type="submit" name="submit_quote" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">إرسال طلب العرض</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12 px-4">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="mb-4">
                        <img src="static/bot_logo.png" alt="نجد القمم" class="h-16 object-contain filter invert">
                    </div>
                    <p class="text-gray-300 mb-4">مؤسسة سعودية متخصصة في تقديم خدمات المقاولات العامة والتشطيبات بأعلى معايير الجودة والمهنية.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">روابط سريعة</h4>
                    <ul class="space-y-2">
                        <li><a href="#about" class="text-gray-300 hover:text-white">من نحن</a></li>
                        <li><a href="#services" class="text-gray-300 hover:text-white">خدماتنا</a></li>
                        <li><a href="#projects" class="text-gray-300 hover:text-white">مشاريعنا</a></li>
                        <li><a href="#jobs" class="text-gray-300 hover:text-white">فرص العمل</a></li>
                        <li><a href="#gallery" class="text-gray-300 hover:text-white">معرض الصور</a></li>
                        <li><a href="#contact" class="text-gray-300 hover:text-white">تواصل معنا</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">معلومات التواصل</h4>
                    <div class="space-y-2">
                        <p class="text-gray-300"><i class="fas fa-phone ml-2"></i> 0553038352</p>
                        <p class="text-gray-300"><i class="fas fa-envelope ml-2"></i> ahmed@najidalqimam.sa</p>
                        <p class="text-gray-300"><i class="fas fa-map-marker-alt ml-2"></i> المملكة العربية السعودية</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; 2024 مؤسسة نجد القمم للمقاولات. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>
</body>
</html>