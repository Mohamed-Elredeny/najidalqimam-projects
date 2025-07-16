<?php
// Email Configuration
return [
    // SMTP Settings
    'smtp_host' => 'smtp.gmail.com',           // SMTP server
    'smtp_port' => 587,                        // SMTP port (587 for TLS, 465 for SSL)
    'smtp_username' => 'your-email@gmail.com', // SMTP username
    'smtp_password' => 'your-app-password',    // SMTP password or app password
    'smtp_secure' => 'tls',                    // 'tls' or 'ssl'
    
    // Email Content Settings
    'from_email' => 'noreply@injaz-alnawadi.com',
    'from_name' => 'شركة انجاز النوادي للمقاولات',
    'to_email' => 'info@injaz-alnawadi.com',
    'subject_prefix' => '[موقع الشركة] رسالة جديدة من: ',
    
    // Email Method: 'mail' for basic mail() function, 'smtp' for authenticated SMTP
    'method' => 'smtp'
];
?> 