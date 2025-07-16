<?php
// Email Configuration Example
// Copy this file to email.php and modify the values according to your setup

return [
    // SMTP Settings (for authenticated email sending)
    'smtp_host' => 'smtp.gmail.com',           // Gmail: smtp.gmail.com, Outlook: smtp-mail.outlook.com
    'smtp_port' => 587,                        // 587 for TLS, 465 for SSL, 25 for no encryption
    'smtp_username' => 'your-email@gmail.com', // Your email address
    'smtp_password' => 'your-app-password',    // App password (not regular password!)
    'smtp_secure' => 'tls',                    // 'tls', 'ssl', or false for no encryption
    
    // Email Content Settings
    'from_email' => 'noreply@yourdomain.com',
    'from_name' => 'Your Company Name',
    'to_email' => 'admin@yourdomain.com',
    'subject_prefix' => '[Website Contact] New message from: ',
    
    // Email Method: 'mail' for basic mail() function, 'smtp' for authenticated SMTP
    'method' => 'smtp'
];
?> 