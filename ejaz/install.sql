
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects (
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
    is_featured BOOLEAN DEFAULT FALSE,
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
    schedule_date DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title_ar VARCHAR(255),
    title_en VARCHAR(255),
    content_ar TEXT,
    content_en TEXT,
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    subject VARCHAR(255),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin
INSERT INTO admin_users (username, password) VALUES ('admin', SHA2('123456', 256));
