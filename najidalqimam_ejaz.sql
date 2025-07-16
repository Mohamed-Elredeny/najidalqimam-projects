-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2025 at 07:15 PM
-- Server version: 8.0.42
-- PHP Version: 8.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `najidalqimam_ejaz`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_texts`
--

CREATE TABLE `about_texts` (
  `id` int NOT NULL,
  `paragraph_ar` text COLLATE utf8mb4_general_ci,
  `paragraph_en` text COLLATE utf8mb4_general_ci,
  `order` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_texts`
--

INSERT INTO `about_texts` (`id`, `paragraph_ar`, `paragraph_en`, `order`) VALUES
(1, '\"نبني المستقبل بأصالة واحتراف\"', '\"Building the Future with Authenticity and Professionalism\"', 1),
(2, 'تُعد شركة إيجاز البوادي للمقاولات العامة إحدى الشركات السعودية الرائدة في قطاع التشييد والبناء والمقاولات العامة، بخبرة تمتد لأكثر من 20 عامًا من الإنجازات والتميز.', 'Ejaz Al-Bawadi General Contracting Company is a leading Saudi company in the field of construction and general contracting, with over 20 years of experience marked by success, excellence, and trusted partnerships with our clients.', 2),
(3, 'منذ انطلاقتنا الأولى، حرصنا على بناء علاقة ثقة متينة مع عملائنا من خلال تنفيذ مجموعة واسعة من المشاريع المتنوعة داخل المملكة. وقد حظينا بمكانة مميزة في السوق بفضل التزامنا بأعلى معايير الجودة والمصداقية.', 'Since our inception, we have delivered a wide range of diverse projects across the Kingdom, earning a distinguished position in the market through our commitment to the highest standards of quality and integrity.', 3),
(4, 'نمتلك فريق إدارة يتمتع برؤية واضحة ومحترفة، يسعى دائمًا لتشييد منشآت ومباني حديثة ومتينة، تُلبي احتياجات المستقبل وتُرسخ وجودنا في سوق المقاولات كخيار أول لكل من يبحث عن الجودة والاحتراف.', 'Our management team is driven by a clear and visionary approach, dedicated to constructing modern and durable buildings that meet future needs and solidify our presence in the contracting sector as the first choice for those seeking quality and professionalism.', 4),
(5, 'من فكرة بسيطة ورؤية طموحة، انطلقت شركة إيجاز البوادي للمقاولات العامة لتضع بصمتها في عالم التشييد والبناء داخل المملكة العربية السعودية.', 'From a simple idea and an ambitious vision, Ejaz Al-Bawadi General Contracting Company emerged to leave its mark in the world of construction and development across the Kingdom of Saudi Arabia.', 5),
(6, 'بدأنا من الميدان، وسط التحديات، نحمل شغف الإنجاز، وإرادة لا تعرف المستحيل. لم تكن رحلتنا سهلة، لكننا اخترنا طريق التميز، فبنينا الثقة قبل أن نبني الجدران، وشيّدنا السمعة قبل أن نرفع الأسقف.', 'We started on the ground, facing challenges head-on, driven by a passion for achievement and an unwavering determination. Our journey wasn\'t easy, but we chose the path of excellence - building trust before we built walls, and earning reputation before raising roofs.', 6),
(7, 'اليوم، وبعد أكثر من عقدين من العمل المتواصل، نفخر بما حققناه من مشاريع ناجحة في مختلف أنحاء المملكة — من المدارس والمساجد إلى المصانع والمستشفيات، ومن الطرق والمنشآت العامة إلى مشاريع تسليم المفتاح.', 'Today, after more than two decades of continuous work, we take pride in our successful projects across the Kingdom - from schools and mosques to factories and hospitals, and from roads and public facilities to turnkey delivery projects.', 7),
(8, 'نجاحنا لم يكن صدفة، بل نتيجة التزام، تخطيط، وإيمان بأن الجودة ليست خيارًا، بل هوية.', 'Our success wasn\'t by chance. It was the result of commitment, planning, and the belief that quality is not an option - it\'s our identity.', 8),
(9, 'نحن لا نبني فقط… بل نصنع مستقبلًا يستحق الثقة.', 'We don\'t just build... We shape a future that earns trust.', 9);

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2025-04-17 00:07:21');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `excerpt_ar` text COLLATE utf8mb4_general_ci,
  `excerpt_en` text COLLATE utf8mb4_general_ci,
  `content_ar` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `content_en` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('draft','published','scheduled') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `schedule_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_page`
--

CREATE TABLE `business_page` (
  `id` int NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `benefits_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `benefits_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `features_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `features_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hero_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_keywords` text COLLATE utf8mb4_unicode_ci,
  `seo_description_ar` text COLLATE utf8mb4_unicode_ci,
  `seo_description_en` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_page`
--

INSERT INTO `business_page` (`id`, `title_ar`, `title_en`, `subtitle_ar`, `subtitle_en`, `content_ar`, `content_en`, `benefits_ar`, `benefits_en`, `features_ar`, `features_en`, `hero_image`, `content_image`, `seo_keywords`, `seo_description_ar`, `seo_description_en`, `created_at`, `updated_at`) VALUES
(1, 'قسم أعمال الطرق والجسور', 'Roads and Bridges Department', 'خبرة واسعة في تنفيذ مشاريع الطرق والبنية التحتية', 'Extensive experience in road and infrastructure projects', 'تقدم شركة إيجاز البوادي للمقاولات العامة خدمات متكاملة في مجال تنفيذ مشاريع الطرق والجسور بأعلى معايير الجودة والسلامة. نمتلك فريقاً من المهندسين والفنيين ذوي الخبرة الواسعة في هذا المجال، بالإضافة إلى أحدث المعدات والتقنيات التي تمكننا من تنفيذ المشاريع بكفاءة عالية وضمن الجداول الزمنية المحددة.', 'Ejaz Al-Bawadi General Contracting Company provides integrated services in the field of implementing road and bridge projects with the highest standards of quality and safety. We have a team of engineers and technicians with extensive experience in this field, in addition to the latest equipment and technologies that enable us to implement projects efficiently and within the specified timeframes.', 'الالتزام بالمواعيد|التنفيذ بأعلى معايير الجودة|استخدام أحدث التقنيات|فريق هندسي متخصص|معدات متطورة', 'Commitment to deadlines|Implementation with the highest quality standards|Use of the latest technologies|Specialized engineering team|Advanced equipment', 'خبرة في تنفيذ مشاريع الطرق السريعة والجسور|استخدام أفضل المواد والتقنيات|الالتزام بمعايير السلامة العالمية|حلول مبتكرة للتحديات الهندسية|صيانة ما بعد التنفيذ', 'Experience in implementing highway and bridge projects|Using the best materials and technologies|Commitment to international safety standards|Innovative solutions for engineering challenges|Post-implementation maintenance', 'uploads/business/roads_hero.jpg', 'uploads/business/roads_content.jpg', NULL, NULL, NULL, '2025-05-13 19:52:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description_ar` text COLLATE utf8mb4_general_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `order` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_timeline`
--

CREATE TABLE `company_timeline` (
  `id` int NOT NULL,
  `year` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description_ar` text COLLATE utf8mb4_general_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'fas fa-star'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_vmv`
--

CREATE TABLE `company_vmv` (
  `id` int NOT NULL,
  `vision_ar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `vision_en` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mission_en` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mission_ar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `values_ar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `values_eb` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `id` int NOT NULL,
  `type` enum('address','phone','email','hours') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `label_ar` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `label_en` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`id`, `type`, `label_ar`, `label_en`, `value`, `icon`) VALUES
(1, 'address', 'العنوان', 'Address', 'تبوك طريق الملك فيصل', 'fa-map-marker-alt'),
(2, 'phone', 'رقم الجوال', 'Phone', '+966599912030', 'fa-phone-alt'),
(3, 'email', 'البريد الإلكتروني', 'Email', 'ej@ej.najidalqimam.sa', 'fa-envelope'),
(4, 'hours', 'ساعات العمل', 'Hours', 'Sun–Thu: 8:00–17:00', 'fa-clock');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(2, '123', 'admin@example.com', 'turnkey', 'الخدمة المطلوبة: turnkey\nرقم الجوال: 123\n\n12312', '2025-04-17 02:38:32'),
(3, '123', 'admin@example.com', 'turnkey', 'الخدمة المطلوبة: turnkey\nرقم الجوال: 123\n\n12', '2025-04-17 02:39:31'),
(4, '12', 'admin@example.com', 'turnkey', 'الخدمة المطلوبة: turnkey\nرقم الجوال: 12\n\n1212', '2025-04-17 03:56:24'),
(5, 'دينا محمد', 'dina1997mohamed@gmail.com', 'finishing', 'الخدمة المطلوبة: finishing\nرقم الجوال: 01275267180\n\nننن', '2025-05-17 19:26:09');

-- --------------------------------------------------------

--
-- Table structure for table `counters`
--

CREATE TABLE `counters` (
  `id` int NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `value` int DEFAULT NULL,
  `label_ar` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `label_en` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `counters`
--

INSERT INTO `counters` (`id`, `icon`, `value`, `label_ar`, `label_en`, `order`) VALUES
(1, 'fa-project-diagram', 150, 'مشروع منجز', 'Projects Completed', 1),
(2, 'fa-user-tie', 50, 'عميل راضٍ', 'Satisfied Clients', 2),
(3, 'fa-award', 25, 'جوائز', 'Awards', 3),
(4, 'fa-hard-hat', 100, 'موظف محترف', 'Professional Staff', 4);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description_ar` text COLLATE utf8mb4_general_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image_overlay_1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image_overlay_2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `content_design_ar` text COLLATE utf8mb4_general_ci,
  `content_design_en` text COLLATE utf8mb4_general_ci,
  `content_construction_ar` text COLLATE utf8mb4_general_ci,
  `content_construction_en` text COLLATE utf8mb4_general_ci,
  `content_maintenance_ar` text COLLATE utf8mb4_general_ci,
  `content_maintenance_en` text COLLATE utf8mb4_general_ci,
  `content_quality_ar` text COLLATE utf8mb4_general_ci,
  `content_quality_en` text COLLATE utf8mb4_general_ci,
  `content_technology_ar` text COLLATE utf8mb4_general_ci,
  `content_technology_en` text COLLATE utf8mb4_general_ci,
  `content_analysis_ar` text COLLATE utf8mb4_general_ci,
  `content_analysis_en` text COLLATE utf8mb4_general_ci,
  `content_extra_ar` text COLLATE utf8mb4_general_ci,
  `content_extra_en` text COLLATE utf8mb4_general_ci,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name_ar`, `name_en`, `description_ar`, `description_en`, `image`, `banner_image`, `image_overlay_1`, `image_overlay_2`, `content_design_ar`, `content_design_en`, `content_construction_ar`, `content_construction_en`, `content_maintenance_ar`, `content_maintenance_en`, `content_quality_ar`, `content_quality_en`, `content_technology_ar`, `content_technology_en`, `content_analysis_ar`, `content_analysis_en`, `content_extra_ar`, `content_extra_en`, `order`, `is_active`) VALUES
(1, 'تسليم المفتاح', 'Turnkey Delivery', 'نقدم خدمات متكاملة من بداية المشروع وحتى تسليم المفتاح للعميل', 'We provide integrated services from project start to final turnkey delivery to the client', '/uploads/departments/turnkey.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(2, 'المستودعات', 'Warehouses', 'تصميم وبناء المستودعات بمختلف المساحات والمواصفات', 'Design and construction of warehouses of various sizes and specifications', '/uploads/departments/warehouses.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1),
(3, 'المرافق', 'Facilities', 'إنشاء وصيانة المرافق العامة والخاصة بكفاءة عالية', 'Construction and maintenance of public and private facilities with high efficiency', '/uploads/departments/facilities.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1),
(4, 'تصميم الطرق', 'Road Design', 'تصميم وتنفيذ مشاريع الطرق وفق أحدث المعايير الهندسية', 'Design and implementation of road projects according to the latest engineering standards', '/uploads/departments/road_design.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1),
(5, 'الترميم', 'Renovation', 'خدمات ترميم المباني وإعادة تأهيلها بأحدث التقنيات', 'Building renovation and rehabilitation services with the latest technologies', '/uploads/departments/renovation.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 1),
(6, 'قسم المشاريع السكنية', 'Residential Projects Department', 'نقدم خدمات متكاملة في مجال بناء المشاريع السكنية، من الفلل الفاخرة إلى المجمعات السكنية، مع الالتزام بأعلى معايير الجودة والتنفيذ المتميز.', 'We provide integrated services in the field of building residential projects, from luxury villas to residential complexes, with a commitment to the highest quality standards and excellent execution.', 'residential.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(7, 'قسم المشاريع التجارية', 'Commercial Projects Department', 'متخصصون في تنفيذ مشاريع المباني التجارية بمختلف أنواعها وأحجامها، بما في ذلك المكاتب والمجمعات التجارية والمراكز التسوقية.', 'We specialize in implementing commercial building projects of various types and sizes, including offices, commercial complexes, and shopping centers.', 'commercial.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1),
(8, 'قسم البنية التحتية والطرق', 'Infrastructure & Roads Department', 'نتخصص في تنفيذ مشاريع البنية التحتية المتكاملة والطرق والجسور، من خلال فريق متخصص من المهندسين والفنيين وأحدث المعدات.', 'We specialize in implementing integrated infrastructure, roads and bridges projects, through a specialized team of engineers and technicians and the latest equipment.', 'infrastructure.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `department_benefits`
--

CREATE TABLE `department_benefits` (
  `id` int NOT NULL,
  `department_id` int NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description_ar` text COLLATE utf8mb4_general_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_general_ci NOT NULL,
  `order` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department_features`
--

CREATE TABLE `department_features` (
  `id` int NOT NULL,
  `department_id` int NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description_ar` text COLLATE utf8mb4_general_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'fas fa-check',
  `order` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_features`
--

INSERT INTO `department_features` (`id`, `department_id`, `title_ar`, `title_en`, `description_ar`, `description_en`, `icon`, `order`) VALUES
(1, 6, 'تصميم داخلي متميز', 'Distinctive Interior Design', 'نوفر خدمات التصميم الداخلي المتميز للمشاريع السكنية', 'We provide distinctive interior design services for residential projects', 'fas fa-paint-roller', 1),
(2, 6, 'تصميمات معمارية مبتكرة', 'Innovative Architectural Designs', 'نصمم ونبني مشاريع سكنية بتصاميم حديثة ومبتكرة', 'We design and build residential projects with modern and innovative designs', 'fas fa-drafting-compass', 2),
(3, 7, 'مساحات عمل فعالة', 'Efficient Workspaces', 'تصميم وتنفيذ مساحات عمل فعالة تزيد من الإنتاجية', 'Designing and implementing efficient workspaces that increase productivity', 'fas fa-building', 1),
(4, 7, 'أنظمة أمان متطورة', 'Advanced Security Systems', 'تركيب أنظمة أمان وسلامة متطورة في المباني التجارية', 'Installation of advanced security and safety systems in commercial buildings', 'fas fa-shield-alt', 2),
(5, 8, 'جودة التنفيذ', 'Quality Implementation', 'نلتزم بأعلى معايير الجودة في تنفيذ مشاريع البنية التحتية', 'We adhere to the highest quality standards in implementing infrastructure projects', 'fas fa-certificate', 1),
(6, 8, 'استخدام أحدث التقنيات', 'Using Latest Technologies', 'نستخدم أحدث التقنيات والمعدات في تنفيذ مشاريع البنية التحتية والطرق', 'We use the latest technologies and equipment in implementing infrastructure and road projects', 'fas fa-cogs', 2);

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` int NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `img`, `order`) VALUES
(1, '1', NULL),
(2, '1', NULL),
(3, '1', NULL),
(4, '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hero`
--

CREATE TABLE `hero` (
  `id` tinyint NOT NULL,
  `title_ar` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title_en` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subtitle_ar` text COLLATE utf8mb4_general_ci,
  `subtitle_en` text COLLATE utf8mb4_general_ci,
  `btn_text_ar` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `btn_text_en` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `btn_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero`
--

INSERT INTO `hero` (`id`, `title_ar`, `title_en`, `subtitle_ar`, `subtitle_en`, `btn_text_ar`, `btn_text_en`, `btn_url`) VALUES
(1, 'شركة ايجاز البوادي للمقاولات العامة', 'Ejaz Al-Bawadi General Contracting Co.', 'نقدم أفضل خدمات المقاولات والبناء بجودة عالية وأسعار منافسة', 'We offer top contracting & construction services with high quality and competitive prices', 'استكشف خدماتنا', 'Explore Services', '#services');

-- --------------------------------------------------------

--
-- Table structure for table `homepage_featured`
--

CREATE TABLE `homepage_featured` (
  `id` int NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `title_ar` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `title_en` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `order` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homepage_featured`
--

INSERT INTO `homepage_featured` (`id`, `icon`, `title_ar`, `title_en`, `order`) VALUES
(1, 'fa-star', 'خدمة مميزة 1', 'Featured Service 1', 1),
(2, 'fa-cog', 'خدمة مميزة 2', 'Featured Service 2', 2),
(3, 'fa-heart', 'خدمة مميزة 3', 'Featured Service 3', 3);

-- --------------------------------------------------------

--
-- Table structure for table `homepage_slider`
--

CREATE TABLE `homepage_slider` (
  `id` int NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '#',
  `order` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homepage_slider`
--

INSERT INTO `homepage_slider` (`id`, `img`, `link`, `order`) VALUES
(1, '/uploads/slider1.jpg', '#122222222', 127),
(2, '/uploads/slider2.jpg', '#', 2),
(3, '/uploads/slider3.jpg', '#', 3);

-- --------------------------------------------------------

--
-- Table structure for table `homepage_welcome`
--

CREATE TABLE `homepage_welcome` (
  `id` tinyint NOT NULL DEFAULT '1',
  `title_ar` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `text_ar` text COLLATE utf8mb4_general_ci NOT NULL,
  `text_en` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homepage_welcome`
--

INSERT INTO `homepage_welcome` (`id`, `title_ar`, `title_en`, `text_ar`, `text_en`) VALUES
(1, 'نبني المستقبل بأصالة واحتراف', 'Building the Future with Authenticity and Professionalism', 'تُعد شركة إيجاز البوادي للمقاولات العامة إحدى الشركات السعودية الرائدة في قطاع التشييد والبناء والمقاولات العامة، بخبرة تمتد لأكثر من 20 عامًا من الإنجازات والتميز.', 'Ejaz Al-Bawadi General Contracting Company is a leading Saudi company in the field of construction and general contracting, with over 20 years of experience marked by success, excellence, and trusted partnerships with our clients.');

-- --------------------------------------------------------

--
-- Table structure for table `nav_links`
--

CREATE TABLE `nav_links` (
  `id` int NOT NULL,
  `title_ar` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `title_en` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `order` tinyint NOT NULL,
  `parent_id` int DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nav_links`
--

INSERT INTO `nav_links` (`id`, `title_ar`, `title_en`, `url`, `order`, `parent_id`, `is_active`) VALUES
(1, 'الرئيسية', 'Home', 'index.php', 1, NULL, 1),
(2, 'خدماتنا', 'Services', '#services', 2, NULL, 1),
(3, 'مشاريعنا', 'Projects', '#projects', 3, NULL, 1),
(4, 'من نحن', 'About Us', '#about', 4, NULL, 1),
(5, 'اتصل بنا', 'Contact Us', '#contact', 5, NULL, 1),
(6, 'تسليم مفتاح', 'Turnkey Projects', 'service_details.php?id=1', 1, 2, 1),
(7, 'التنفيذ و البناء', 'Construction', 'service_details.php?id=2', 2, 2, 1),
(8, 'التشطيبات', 'Finishing Works', 'service_details.php?id=3', 3, 2, 1),
(9, 'أعمال الطرق والجسور', 'Roads & Bridges', 'business.php', 4, 2, 1),
(10, 'الخدمات الإستشارية', 'Consulting Services', 'service_details.php?id=4', 5, 2, 1),
(16, 'المدونة', 'Blog', 'blogs.php', 6, NULL, 1),
(20, 'الأسئلة الشائعة', 'FAQ', 'faq.php', 4, NULL, 1),
(23, 'ادارة الاعمال', 'Business', 'business.php', 6, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alt` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `img`, `alt`, `order`) VALUES
(1, '1', NULL, NULL),
(2, '1', NULL, NULL),
(3, '1', NULL, NULL),
(4, '1', NULL, NULL),
(5, '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int NOT NULL,
  `project_title_ar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `project_title_en` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `project_category` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `location_ar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `location_en` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `client` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `area` float DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT '0',
  `main_image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `summary_ar` text COLLATE utf8mb4_general_ci,
  `summary_en` text COLLATE utf8mb4_general_ci,
  `description_ar` text COLLATE utf8mb4_general_ci,
  `description_en` text COLLATE utf8mb4_general_ci,
  `video_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_title_ar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_title_en` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_description_ar` text COLLATE utf8mb4_general_ci,
  `meta_description_en` text COLLATE utf8mb4_general_ci,
  `meta_keywords` text COLLATE utf8mb4_general_ci,
  `publish_status` enum('published','draft','scheduled') COLLATE utf8mb4_general_ci DEFAULT 'draft',
  `schedule_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_title_ar`, `project_title_en`, `project_category`, `department_id`, `location_ar`, `location_en`, `client`, `area`, `start_date`, `end_date`, `status`, `is_featured`, `main_image`, `summary_ar`, `summary_en`, `description_ar`, `description_en`, `video_url`, `meta_title_ar`, `meta_title_en`, `meta_description_ar`, `meta_description_en`, `meta_keywords`, `publish_status`, `schedule_date`, `created_at`) VALUES
(3, 'مركز صحي حكومي', 'Government Health Center', 'finishing', 3, 'الدمام، السعودية', 'Dammam, Saudi Arabia', 'وزارة الصحة', 4200, '2021-06-01', '2022-02-15', 'Completed', 0, 'uploads/projects/facilities.jpg', 'مركز صحي مجهز بأحدث التقنيات الطبية.', 'A health center equipped with the latest medical technologies.', 'تم إنجاز كافة أعمال التشطيبات الداخلية والخارجية للمركز.', 'All interior and exterior finishing works of the center have been completed.', 'https://youtu.be/example2', 'مركز صحي حكومي – إنجاز', 'Government Health Center – Injaz', 'وصف تفصيلي للمركز الصحي ومنشآته.', 'A detailed description of the health center and its facilities.', 'صحة,مركز طبي,Health,Center', 'scheduled', '2025-05-01 09:00:00', '2025-04-17 00:07:26'),
(4, 'تطوير طرق رئيسية', 'Main Roads Development', 'roads', 4, 'الطائف، السعودية', 'Taif, Saudi Arabia', 'أمانة الطائف', 12000, '2023-03-15', '2024-12-31', 'In Progress', 1, 'uploads/projects/renovation.jpg', 'مشروع تطوير شبكة الطرق الرئيسية.', 'Development of the main road network project.', 'يشمل المشروع توسيع وإعادة تأهيل 25 كم من الطرق.', 'The project includes widening and rehabilitating 25 km of roads.', '', 'تطوير طرق رئيسية – إنجاز', 'Main Roads Development – Injaz', 'تفاصيل مشروع تطوير الطرق الرئيسية.', 'Details of the main roads development project.', 'طرق,بنية تحتية,Roads,Infrastructure', 'published', NULL, '2025-04-17 00:07:26'),
(5, 'مشروع ترميم مبنى أثري', 'Historic Building Restoration', 'renovation', 5, 'المدينة المنورة، السعودية', 'Medina, Saudi Arabia', 'هيئة التراث', 1800.25, '2024-05-01', '2025-11-30', 'Planned', 0, 'uploads/projects/public.jpg', 'ترميم مبنى أثري يعود للقرن الثامن عشر.', 'Restoration of an 18th-century historic building.', 'يشمل ترميم الجدران الخارجية والأسقف والديكورات الداخلية.', 'Includes restoration of external walls, ceilings, and interior décor.', '', 'ترميم مبنى أثري – إنجاز', 'Historic Building Restoration – Injaz', 'وصف مشروع الترميم الأثري.', 'Description of the historic restoration project.', 'ترميم,تاريخي,Renovation,Historic', 'draft', NULL, '2025-04-17 00:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title_ar` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title_en` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `desc_ar` text COLLATE utf8mb4_general_ci,
  `desc_en` text COLLATE utf8mb4_general_ci,
  `url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `img`, `title_ar`, `title_en`, `desc_ar`, `desc_en`, `url`, `order`) VALUES
(1, '/uploads/services/design.jpg', 'دراسة وتقديم التصاميم', 'Design Studies and Proposals', 'نقدم خدمات دراسة وتصميم المشاريع بأعلى معايير الجودة', 'We provide project study and design services with the highest quality standards', 'service_details.php?id=1', 1),
(2, '/uploads/services/roads.jpg', 'الإنارة وصيانة الطرق', 'Public Lighting and Road Maintenance', 'تنفيذ مشاريع إنارة الطرق وخدمات صيانة الطرق العامة بأحدث التقنيات', 'Implementation of road lighting projects and public road maintenance services with the latest technologies', 'service_details.php?id=2', 2),
(3, '/uploads/services/mosques.jpg', 'إنشاء وصيانة المساجد', 'Mosque Construction and Maintenance', 'بناء وصيانة المساجد والمآذن بأنواعها المختلفة', 'Construction and maintenance of mosques and minarets of all types', 'service_details.php?id=3', 3),
(4, '/uploads/services/schools.jpg', 'إنشاء وصيانة المدارس', 'School Construction and Maintenance', 'تنفيذ مشاريع بناء وصيانة المدارس الحكومية والخاصة', 'Construction and maintenance of public and private schools', 'service_details.php?id=4', 4),
(5, '/uploads/services/mining.jpg', 'الاستثمار في المناجم', 'Mining Investment', 'خدمات الاستثمار في المناجم بما يشمل المحاجر والكسارات', 'Investment services in mining, including quarries and crushers', 'service_details.php?id=5', 5),
(6, '/uploads/services/commercial.jpg', 'المؤسسات التجارية والصناعية', 'Commercial and Industrial Facilities', 'إنشاء وصيانة المؤسسات التجارية والصناعية والاستثمارية', 'Construction and maintenance of commercial, industrial, and investment institutions', 'service_details.php?id=6', 6),
(7, '/uploads/services/residential.jpg', 'المباني السكنية', 'Residential Buildings', 'إنشاء وصيانة المباني السكنية بمختلف أنواعها', 'Construction and maintenance of residential buildings of various types', 'service_details.php?id=7', 7),
(8, '/uploads/services/public.jpg', 'المنشآت العامة', 'Public Facilities', 'إنشاء وصيانة المنشآت العامة بكفاءة عالية', 'Construction and maintenance of public facilities with high efficiency', 'service_details.php?id=8', 8);

-- --------------------------------------------------------

--
-- Table structure for table `services_intro`
--

CREATE TABLE `services_intro` (
  `id` tinyint NOT NULL,
  `content_ar` text COLLATE utf8mb4_general_ci,
  `content_en` text COLLATE utf8mb4_general_ci,
  `img1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `img2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `img3` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services_intro`
--

INSERT INTO `services_intro` (`id`, `content_ar`, `content_en`, `img1`, `img2`, `img3`) VALUES
(1, 'مكتبنا فريق عمل من أصحاب الخبرات العلمية والعملية الاحترافية. هدفنا تقديم اختلاف ملموس على طراز عالمي وجودة عالية وبأسعار تنافسية.', 'Our office is staffed with a team of highly professional engineers and supervisors. Our aim is to deliver a tangible difference with world-class quality at competitive prices.', 'images/intro1.jpg', 'images/intro2.jpg', 'images/intro3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `service_options`
--

CREATE TABLE `service_options` (
  `id` int NOT NULL,
  `value` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `label_ar` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `label_en` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_options`
--

INSERT INTO `service_options` (`id`, `value`, `label_ar`, `label_en`) VALUES
(1, 'turnkey', 'تسليم المفتاح', 'Turnkey Delivery'),
(2, 'construction', 'المستودعات', 'Warehouses'),
(3, 'finishing', 'المرافق', 'Facilities'),
(4, 'renovation', 'الترميم', 'Renovation'),
(5, 'roads', 'تصميم الطرق', 'Road Design');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` int NOT NULL,
  `service_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','processing','completed','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `service_id`, `name`, `email`, `phone`, `details`, `status`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 2, '1', 'mohamedelredeny1@gmail.com', '3', '4', 'pending', NULL, '2025-05-13 22:49:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_types`
--

CREATE TABLE `service_types` (
  `id` int NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title_ar` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title_en` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_types`
--

INSERT INTO `service_types` (`id`, `img`, `title_ar`, `title_en`, `order`) VALUES
(1, '/uploads/service_types/turnkey.jpg', 'تسليم المفتاح', 'Turnkey Delivery', 1),
(2, '/uploads/service_types/warehouses.jpg', 'المستودعات', 'Warehouses', 2),
(3, '/uploads/service_types/facilities.jpg', 'المرافق', 'Facilities', 3),
(4, '/uploads/service_types/road_design.jpg', 'تصميم الطرق', 'Road Design', 4),
(5, '/uploads/service_types/renovation.jpg', 'الترميم', 'Renovation', 5);

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `position_ar` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `position_en` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `bio_ar` text COLLATE utf8mb4_general_ci,
  `bio_en` text COLLATE utf8mb4_general_ci,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_texts`
--
ALTER TABLE `about_texts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_page`
--
ALTER TABLE `business_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_timeline`
--
ALTER TABLE `company_timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_vmv`
--
ALTER TABLE `company_vmv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `counters`
--
ALTER TABLE `counters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_benefits`
--
ALTER TABLE `department_benefits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `department_features`
--
ALTER TABLE `department_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero`
--
ALTER TABLE `hero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homepage_featured`
--
ALTER TABLE `homepage_featured`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homepage_slider`
--
ALTER TABLE `homepage_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homepage_welcome`
--
ALTER TABLE `homepage_welcome`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nav_links`
--
ALTER TABLE `nav_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services_intro`
--
ALTER TABLE `services_intro`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_options`
--
ALTER TABLE `service_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `service_types`
--
ALTER TABLE `service_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_texts`
--
ALTER TABLE `about_texts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_page`
--
ALTER TABLE `business_page`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_timeline`
--
ALTER TABLE `company_timeline`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_vmv`
--
ALTER TABLE `company_vmv`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `counters`
--
ALTER TABLE `counters`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `department_benefits`
--
ALTER TABLE `department_benefits`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department_features`
--
ALTER TABLE `department_features`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `homepage_featured`
--
ALTER TABLE `homepage_featured`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `homepage_slider`
--
ALTER TABLE `homepage_slider`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nav_links`
--
ALTER TABLE `nav_links`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `service_options`
--
ALTER TABLE `service_options`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_types`
--
ALTER TABLE `service_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `department_benefits`
--
ALTER TABLE `department_benefits`
  ADD CONSTRAINT `fk_benefit_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `department_features`
--
ALTER TABLE `department_features`
  ADD CONSTRAINT `fk_feature_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD CONSTRAINT `service_requests_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
