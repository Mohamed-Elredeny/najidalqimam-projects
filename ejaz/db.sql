-- 0) Create the database and switch to it
CREATE DATABASE IF NOT EXISTS injaz_clubs
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;
USE injaz_clubs;

-- 1) Admin users
CREATE TABLE IF NOT EXISTS admin_users (
                                           id INT AUTO_INCREMENT PRIMARY KEY,
                                           username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
INSERT INTO admin_users (username, password)
VALUES ('admin', SHA2('123456',256));

-- 2) Contact messages
CREATE TABLE IF NOT EXISTS contact_messages (
                                                id INT AUTO_INCREMENT PRIMARY KEY,
                                                name VARCHAR(100),
    email VARCHAR(100),
    subject VARCHAR(255),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- 3) Departments
CREATE TABLE IF NOT EXISTS departments (
                                           id INT AUTO_INCREMENT PRIMARY KEY,
                                           name VARCHAR(255),
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- 4) Blogs
CREATE TABLE IF NOT EXISTS blogs (
                                     id INT AUTO_INCREMENT PRIMARY KEY,
                                     title_ar VARCHAR(255),
    title_en VARCHAR(255),
    content_ar TEXT,
    content_en TEXT,
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- 5) Navigation links
CREATE TABLE IF NOT EXISTS nav_links (
                                         id INT AUTO_INCREMENT PRIMARY KEY,
                                         title_ar VARCHAR(100) NOT NULL,
    title_en VARCHAR(100) NOT NULL,
    url VARCHAR(255) NOT NULL,
    `order` TINYINT NOT NULL
    );
INSERT INTO nav_links (title_ar, title_en, url, `order`) VALUES
                                                             ('الرئيسية','Home','#hero',1),
                                                             ('خدماتنا','Services','#services',2),
                                                             ('مشاريعنا','Projects','#projects',3),
                                                             ('من نحن','About','#about',4),
                                                             ('اتصل بنا','Contact','#contact',5);

-- 6) Hero section
CREATE TABLE IF NOT EXISTS hero (
                                    id TINYINT PRIMARY KEY,
                                    title_ar VARCHAR(200),
    title_en VARCHAR(200),
    subtitle_ar TEXT,
    subtitle_en TEXT,
    btn_text_ar VARCHAR(50),
    btn_text_en VARCHAR(50),
    btn_url VARCHAR(255)
    );
INSERT INTO hero (id, title_ar, title_en, subtitle_ar, subtitle_en, btn_text_ar, btn_text_en, btn_url) VALUES
    (1,
     'شركة انجاز النوادي للمقاولات العامة',
     'Injaz Al‑Nawadi General Contracting Co.',
     'نقدم أفضل خدمات المقاولات والبناء بجودة عالية وأسعار منافسة',
     'We offer top contracting & construction services with high quality and competitive prices',
     'استكشف خدماتنا','Explore Services','#services');

-- 7) Services intro
CREATE TABLE IF NOT EXISTS services_intro (
                                              id TINYINT PRIMARY KEY,
                                              content_ar TEXT,
                                              content_en TEXT,
                                              img1 VARCHAR(255),
    img2 VARCHAR(255),
    img3 VARCHAR(255)
    );
INSERT INTO services_intro (id, content_ar, content_en, img1, img2, img3) VALUES
    (1,
     'مكتبنا فريق عمل من أصحاب الخبرات العلمية والعملية الاحترافية. هدفنا تقديم اختلاف ملموس على طراز عالمي وجودة عالية وبأسعار تنافسية.',
     'Our office is staffed with a team of highly professional engineers and supervisors. Our aim is to deliver a tangible difference with world‑class quality at competitive prices.',
     'images/intro1.jpg','images/intro2.jpg','images/intro3.jpg');

-- 8) Services grid
CREATE TABLE IF NOT EXISTS services (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        img VARCHAR(255),
    title_ar VARCHAR(100),
    title_en VARCHAR(100),
    desc_ar TEXT,
    desc_en TEXT,
    url VARCHAR(255),
    `order` TINYINT
    );
INSERT INTO services (img, title_ar, title_en, desc_ar, desc_en, url, `order`) VALUES
                                                                                   ('images/service1.jpg','تسليم المفتاح','Turnkey','نقدم خدمات متكاملة من بداية المشروع حتى تسليم المفتاح.','We provide a full turnkey service from design through to handover.','#',1),
                                                                                   ('images/service2.jpg','التنفيذ و البناء','Construction','فريق متخصص من المهندسين والفنيين لضمان تنفيذ دقيق وفقًا للمواصفات.','A specialized team of engineers and technicians guaranteeing precise execution.','#',2),
                                                                                   ('images/service3.jpg','التشطيبات','Finishing','تشطيبات داخلية وخارجية عالية الجودة لجميع أنواع المشاريع.','High‑quality interior and exterior finishes for all project types.','#',3);

-- 9) Service types
CREATE TABLE IF NOT EXISTS service_types (
                                             id INT AUTO_INCREMENT PRIMARY KEY,
                                             img VARCHAR(255),
    title_ar VARCHAR(100),
    title_en VARCHAR(100),
    `order` TINYINT
    );
INSERT INTO service_types (img, title_ar, title_en, `order`) VALUES
                                                                 ('images/type1.jpg','تسليم المفتاح','Turnkey',1),
                                                                 ('images/type2.jpg','المستودعات','Warehouses',2),
                                                                 ('images/type3.jpg','المرافق','Utilities',3),
                                                                 ('images/type4.jpg','تصميم الطرق','Road Design',4),
                                                                 ('images/type5.jpg','الترميم','Renovation',5);

-- 10) About texts
CREATE TABLE IF NOT EXISTS about_texts (
                                           id INT AUTO_INCREMENT PRIMARY KEY,
                                           paragraph_ar TEXT,
                                           paragraph_en TEXT,
                                           `order` TINYINT
);
INSERT INTO about_texts (paragraph_ar, paragraph_en, `order`) VALUES
                                                                  ('تأسست شركة انجاز النوادي للمقاولات العامة منذ أكثر من 15 عامًا وتطورت لتصبح من الشركات الرائدة في المملكة.','Injaz Al‑Nawadi was founded over 15 years ago and has grown into one of the leading contractors in Saudi Arabia.',1),
                                                                  ('نفخر بإتمام أكثر من 150 مشروعًا ناجحًا بشتى أنواع البناء السكني والتجاري والحكومي.','We take pride in completing over 150 successful residential, commercial, and governmental projects.',2),
                                                                  ('فلسفتنا مبنية على الجودة والالتزام بالوقت والشفافية في التعامل مع عملائنا.','Our philosophy is built on quality, timeliness, and transparency in all client interactions.',3);

-- 11) Counters
CREATE TABLE IF NOT EXISTS counters (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        icon VARCHAR(50),
    value INT,
    label_ar VARCHAR(50),
    label_en VARCHAR(50),
    `order` TINYINT
    );
INSERT INTO counters (icon, value, label_ar, label_en, `order`) VALUES
                                                                    ('fa-project-diagram',150,'مشروع منجز','Projects Completed',1),
                                                                    ('fa-user-tie',50,'عميل راضٍ','Satisfied Clients',2),
                                                                    ('fa-award',25,'جوائز','Awards',3),
                                                                    ('fa-hard-hat',100,'موظف محترف','Professional Staff',4);

-- 12) Equipment (placeholder)
CREATE TABLE IF NOT EXISTS equipment (
     id INT AUTO_INCREMENT PRIMARY KEY,
     img VARCHAR(255),
    `order` TINYINT
    );
-- INSERT into equipment (...) VALUES (...);

-- 13) Partners (placeholder)
CREATE TABLE IF NOT EXISTS partners (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        img VARCHAR(255),
    alt VARCHAR(100),
    `order` TINYINT
    );
-- INSERT into partners (...) VALUES (...);

-- 14) Contact info
CREATE TABLE IF NOT EXISTS contact_info (
                                            id INT AUTO_INCREMENT PRIMARY KEY,
                                            type ENUM('address','phone','email','hours'),
    label_ar VARCHAR(50),
    label_en VARCHAR(50),
    value VARCHAR(255),
    icon VARCHAR(50)
    );
INSERT INTO contact_info (type,label_ar,label_en,value,icon) VALUES
                                                                 ('address','العنوان','Address','الدمام، طريق الملك سعود…','fa-map-marker-alt'),
                                                                 ('phone','رقم الجوال','Phone','+966599912030','fa-phone-alt'),
                                                                 ('email','البريد الإلكتروني','Email','mkld1397@gmail.com','fa-envelope'),
                                                                 ('hours','ساعات العمل','Hours','Sun–Thu: 8:00–17:00','fa-clock');

-- 15) Service options
CREATE TABLE IF NOT EXISTS service_options (
                                               id INT AUTO_INCREMENT PRIMARY KEY,
                                               value VARCHAR(50),
    label_ar VARCHAR(100),
    label_en VARCHAR(100)
    );
INSERT INTO service_options (value,label_ar,label_en) VALUES
                                                          ('turnkey','تسليم المفتاح','Turnkey'),
                                                          ('construction','التنفيذ و البناء','Construction'),
                                                          ('finishing','التشطيبات','Finishing'),
                                                          ('renovation','الترميم','Renovation'),
                                                          ('roads','تصميم الطرق','Road Design');

USE injaz_clubs;
CREATE TABLE IF NOT EXISTS projects (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        project_title_ar VARCHAR(255),
    project_title_en VARCHAR(255),
    project_category VARCHAR(100),
    department_id INT,
    location_ar VARCHAR(255),
    location_en VARCHAR(255),
    client VARCHAR(255),
    area FLOAT,
    start_date DATE,
    end_date DATE,
    status VARCHAR(100),
    is_featured TINYINT(1) DEFAULT 0,
    main_image VARCHAR(255),
    summary_ar TEXT,
    summary_en TEXT,
    description_ar TEXT,
    description_en TEXT,
    video_url VARCHAR(255),
    meta_title_ar VARCHAR(255),
    meta_title_en VARCHAR(255),
    meta_description_ar TEXT,
    meta_description_en TEXT,
    meta_keywords TEXT,
    publish_status ENUM('published','draft','scheduled') DEFAULT 'draft',
    schedule_date DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
INSERT INTO projects (
    project_title_ar,
    project_title_en,
    project_category,
    department_id,
    location_ar,
    location_en,
    client,
    area,
    start_date,
    end_date,
    status,
    is_featured,
    main_image,
    summary_ar,
    summary_en,
    description_ar,
    description_en,
    video_url,
    meta_title_ar,
    meta_title_en,
    meta_description_ar,
    meta_description_en,
    meta_keywords,
    publish_status,
    schedule_date
) VALUES
      ('مبنى سكني فخم',
       'Luxury Residential Building',
       'turnkey',
       1,
       'الرياض، السعودية',
       'Riyadh, Saudi Arabia',
       'شركة الدار العقارية',
       3500.50,
       '2022-01-10',
       '2023-05-20',
       'Completed',
       1,
       'images/projects/residential1.jpg',
       'مشروع سكني فخم يوفر كافة وسائل الراحة.',
       'A luxury residential project offering all modern comforts.',
       'هذا المشروع يتضمن 50 شقة سكنية فاخرة بمساحات مختلفة.',
       'This project comprises 50 luxury residential apartments of various sizes.',
       'https://youtu.be/example1',
       'مبنى سكني فخم – إنجاز',
       'Luxury Residential Building – Injaz',
       'تفاصيل عن المشروع السكني الفخم ومميزاته.',
       'Details about the luxury residential project and its features.',
       'مباني سكنية,سكني,Luxury,Residential',
       'published',
       NULL
      ),
      ('مجمع تجاري متكامل',
       'Integrated Commercial Complex',
       'construction',
       2,
       'جدة، السعودية',
       'Jeddah, Saudi Arabia',
       'مجموعة المطورون',
       5500.75,
       '2023-02-01',
       '2024-08-31',
       'In Progress',
       0,
       'images/projects/commercial1.jpg',
       'مجمع تجاري حديث يضم متاجر ومطاعم.',
       'A modern commercial complex featuring shops and restaurants.',
       'المجمع يضم أكثر من 100 محل تجاري ومطعم فاخر.',
       'The complex includes over 100 retail outlets and fine dining restaurants.',
       '',
       'مجمع تجاري متكامل – إنجاز',
       'Integrated Commercial Complex – Injaz',
       'تفاصيل مجمعنا التجاري المتكامل.',
       'Details of our integrated commercial complex.',
       'تسوق,تجارة,Commercial,Complex',
       'draft',
       NULL
      ),
      ('مركز صحي حكومي',
       'Government Health Center',
       'finishing',
       3,
       'الدمام، السعودية',
       'Dammam, Saudi Arabia',
       'وزارة الصحة',
       4200.00,
       '2021-06-01',
       '2022-02-15',
       'Completed',
       0,
       'images/projects/health1.jpg',
       'مركز صحي مجهز بأحدث التقنيات الطبية.',
       'A health center equipped with the latest medical technologies.',
       'تم إنجاز كافة أعمال التشطيبات الداخلية والخارجية للمركز.',
       'All interior and exterior finishing works of the center have been completed.',
       'https://youtu.be/example2',
       'مركز صحي حكومي – إنجاز',
       'Government Health Center – Injaz',
       'وصف تفصيلي للمركز الصحي ومنشآته.',
       'A detailed description of the health center and its facilities.',
       'صحة,مركز طبي,Health,Center',
       'scheduled',
       '2025-05-01 09:00:00'
      ),
      ('تطوير طرق رئيسية',
       'Main Roads Development',
       'roads',
       4,
       'الطائف، السعودية',
       'Taif, Saudi Arabia',
       'أمانة الطائف',
       12000.00,
       '2023-03-15',
       '2024-12-31',
       'In Progress',
       1,
       'images/projects/roads1.jpg',
       'مشروع تطوير شبكة الطرق الرئيسية.',
       'Development of the main road network project.',
       'يشمل المشروع توسيع وإعادة تأهيل 25 كم من الطرق.',
       'The project includes widening and rehabilitating 25 km of roads.',
       '',
       'تطوير طرق رئيسية – إنجاز',
       'Main Roads Development – Injaz',
       'تفاصيل مشروع تطوير الطرق الرئيسية.',
       'Details of the main roads development project.',
       'طرق,بنية تحتية,Roads,Infrastructure',
       'published',
       NULL
      ),
      ('مشروع ترميم مبنى أثري',
       'Historic Building Restoration',
       'renovation',
       5,
       'المدينة المنورة، السعودية',
       'Medina, Saudi Arabia',
       'هيئة التراث',
       1800.25,
       '2024-05-01',
       '2025-11-30',
       'Planned',
       0,
       'images/projects/renovation1.jpg',
       'ترميم مبنى أثري يعود للقرن الثامن عشر.',
       'Restoration of an 18th-century historic building.',
       'يشمل ترميم الجدران الخارجية والأسقف والديكورات الداخلية.',
       'Includes restoration of external walls, ceilings, and interior décor.',
       '',
       'ترميم مبنى أثري – إنجاز',
       'Historic Building Restoration – Injaz',
       'وصف مشروع الترميم الأثري.',
       'Description of the historic restoration project.',
       'ترميم,تاريخي,Renovation,Historic',
       'draft',
       NULL
      );
-- 1) Slider images
CREATE TABLE IF NOT EXISTS homepage_slider (
                                               id INT AUTO_INCREMENT PRIMARY KEY,
                                               img     VARCHAR(255) NOT NULL,
    link    VARCHAR(255) NOT NULL DEFAULT '#',
    `order` TINYINT       NOT NULL DEFAULT 0
    );

-- 2) Welcome text
CREATE TABLE IF NOT EXISTS homepage_welcome (
                                                id          TINYINT        PRIMARY KEY DEFAULT 1,
                                                title_ar    VARCHAR(255)   NOT NULL,
    title_en    VARCHAR(255)   NOT NULL,
    text_ar     TEXT           NOT NULL,
    text_en     TEXT           NOT NULL
    );

-- 3) Featured services on homepage
CREATE TABLE IF NOT EXISTS homepage_featured (
                                                 id          INT AUTO_INCREMENT PRIMARY KEY,
                                                 icon        VARCHAR(50)       NOT NULL,   -- e.g. 'fa-star'
    title_ar    VARCHAR(100)      NOT NULL,
    title_en    VARCHAR(100)      NOT NULL,
    `order`     TINYINT           NOT NULL     DEFAULT 0
    );
INSERT INTO homepage_slider (img,link,`order`) VALUES
                                                   ('/uploads/slider1.jpg','#',1),
                                                   ('/uploads/slider2.jpg','#',2),
                                                   ('/uploads/slider3.jpg','#',3);

INSERT INTO homepage_welcome (id,title_ar,title_en,text_ar,text_en)
VALUES
    (1,
     'مرحباً بكم في موقعنا',
     'Welcome to Our Site',
     'هذا نص ترحيبي يظهر أسفل السلايدر.',
     'This is the welcome text shown under the slider.'
    );

INSERT INTO homepage_featured (icon,title_ar,title_en,`order`) VALUES
                                                                   ('fa-star','خدمة مميزة 1','Featured Service 1',1),
                                                                   ('fa-cog','خدمة مميزة 2','Featured Service 2',2),
                                                                   ('fa-heart','خدمة مميزة 3','Featured Service 3',3);
-- About texts table
CREATE TABLE `about_texts` (
                               `id` int(11) NOT NULL AUTO_INCREMENT,
                               `paragraph_ar` text NOT NULL,
                               `paragraph_en` text NOT NULL,
                               `order` int(11) NOT NULL DEFAULT 0,
                               PRIMARY KEY (`id`)
);

-- Company vision, mission and values
CREATE TABLE `company_vmv` (
                               `id` int(11) NOT NULL AUTO_INCREMENT,
                               `vision_ar` text NOT NULL,
                               `vision_en` text NOT NULL,
                               `mission_ar` text NOT NULL,
                               `mission_en` text NOT NULL,
                               `values_ar` text NOT NULL,
                               `values_en` text NOT NULL,
                               PRIMARY KEY (`id`)
);

-- Team members
CREATE TABLE `team_members` (
                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                `name_ar` varchar(255) NOT NULL,
                                `name_en` varchar(255) NOT NULL,
                                `position_ar` varchar(255) NOT NULL,
                                `position_en` varchar(255) NOT NULL,
                                `bio_ar` text DEFAULT NULL,
                                `bio_en` text DEFAULT NULL,
                                `image` varchar(255) NOT NULL,
                                `email` varchar(255) DEFAULT NULL,
                                `linkedin` varchar(255) DEFAULT NULL,
                                `twitter` varchar(255) DEFAULT NULL,
                                `order` int(11) NOT NULL DEFAULT 0,
                                PRIMARY KEY (`id`)
);

-- Company timeline
CREATE TABLE `company_timeline` (
                                    `id` int(11) NOT NULL AUTO_INCREMENT,
                                    `year` varchar(10) NOT NULL,
                                    `title_ar` varchar(255) NOT NULL,
                                    `title_en` varchar(255) NOT NULL,
                                    `description_ar` text NOT NULL,
                                    `description_en` text NOT NULL,
                                    `icon` varchar(50) DEFAULT 'fas fa-star',
                                    PRIMARY KEY (`id`)
);

-- Certificates
CREATE TABLE `certificates` (
                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                `title_ar` varchar(255) NOT NULL,
                                `title_en` varchar(255) NOT NULL,
                                `description_ar` text NOT NULL,
                                `description_en` text NOT NULL,
                                `image` varchar(255) NOT NULL,
                                `order` int(11) NOT NULL DEFAULT 0,
                                PRIMARY KEY (`id`)
);
-- Departments table
CREATE TABLE `departments` (
                               `id` int(11) NOT NULL AUTO_INCREMENT,
                               `name_ar` varchar(255) NOT NULL,
                               `name_en` varchar(255) NOT NULL,
                               `description_ar` text NOT NULL,
                               `description_en` text NOT NULL,
                               `image` varchar(255) NOT NULL,
                               `banner_image` varchar(255) DEFAULT NULL,
                               `image_overlay_1` varchar(255) DEFAULT NULL,
                               `image_overlay_2` varchar(255) DEFAULT NULL,
                               `content_design_ar` text DEFAULT NULL,
                               `content_design_en` text DEFAULT NULL,
                               `content_construction_ar` text DEFAULT NULL,
                               `content_construction_en` text DEFAULT NULL,
                               `content_maintenance_ar` text DEFAULT NULL,
                               `content_maintenance_en` text DEFAULT NULL,
                               `content_quality_ar` text DEFAULT NULL,
                               `content_quality_en` text DEFAULT NULL,
                               `content_technology_ar` text DEFAULT NULL,
                               `content_technology_en` text DEFAULT NULL,
                               `content_analysis_ar` text DEFAULT NULL,
                               `content_analysis_en` text DEFAULT NULL,
                               `content_extra_ar` text DEFAULT NULL,
                               `content_extra_en` text DEFAULT NULL,
                               `order` int(11) NOT NULL DEFAULT 0,
                               PRIMARY KEY (`id`)
);

-- Department features
CREATE TABLE `department_features` (
                                       `id` int(11) NOT NULL AUTO_INCREMENT,
                                       `department_id` int(11) NOT NULL,
                                       `title_ar` varchar(255) NOT NULL,
                                       `title_en` varchar(255) NOT NULL,
                                       `description_ar` text NOT NULL,
                                       `description_en` text NOT NULL,
                                       `icon` varchar(50) DEFAULT 'fas fa-check',
                                       `order` int(11) NOT NULL DEFAULT 0,
                                       PRIMARY KEY (`id`),
                                       KEY `department_id` (`department_id`),
                                       CONSTRAINT `fk_feature_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
);

-- Department benefits
CREATE TABLE `department_benefits` (
                                       `id` int(11) NOT NULL AUTO_INCREMENT,
                                       `department_id` int(11) NOT NULL,
                                       `title_ar` varchar(255) NOT NULL,
                                       `title_en` varchar(255) NOT NULL,
                                       `description_ar` text NOT NULL,
                                       `description_en` text NOT NULL,
                                       `order` int(11) NOT NULL DEFAULT 0,
                                       PRIMARY KEY (`id`),
                                       KEY `department_id` (`department_id`),
                                       CONSTRAINT `fk_benefit_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
);