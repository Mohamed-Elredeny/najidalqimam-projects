<?php
session_start();
require_once '../../config/db.php';

// Load email configuration
$emailConfig = require_once '../../config/email.php';

// Determine language for feedback
$lang = $_SESSION['lang'] ?? 'ar';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Collect & trim inputs
$name    = trim($_POST['name'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$email   = trim($_POST['email'] ?? '');
$service = trim($_POST['service'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validation
$errors = [];
if ($name === '') {
    $errors[] = $lang==='ar' ? 'الاسم مطلوب.' : 'Name is required.';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = $lang==='ar' ? 'بريد إلكتروني صالح مطلوب.' : 'A valid email is required.';
}
if ($service === '') {
    $errors[] = $lang==='ar' ? 'اختر نوع الخدمة.' : 'Please select a service.';
}
if ($message === '') {
    $errors[] = $lang==='ar' ? 'تفاصيل المشروع مطلوبة.' : 'Project details are required.';
}

if (empty($errors)) {
    // Prepare insert
    $stmt = $pdo->prepare("
        INSERT INTO contact_messages 
          (name, email, subject, message)
        VALUES
          (?,       ?,     ?,       ?)
    ");
    // Prepend phone and service to the message
    $fullMessage = "الخدمة المطلوبة: $service\nرقم الجوال: $phone\n\n$message";

    try {
        $stmt->execute([$name, $email, $service, $fullMessage]);
        
        // Send email notification
        $emailSent = sendEmailNotification($emailConfig, $name, $email, $phone, $service, $message, $lang);
        
        $_SESSION['flash_success'] = $lang==='ar'
            ? 'تم إرسال رسالتك بنجاح. سنتواصل معك قريباً.'
            : 'Your message has been sent successfully. We will contact you soon.';
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION['flash_error'] = $lang==='ar'
            ? 'عذراً، حدث خطأ أثناء الإرسال. حاول مجدداً لاحقاً.'
            : 'Sorry, something went wrong. Please try again later.';
    }
} else {
    $_SESSION['flash_error'] = implode('<br>', $errors);
}

// Function to send email notification
function sendEmailNotification($config, $name, $email, $phone, $service, $message, $lang) {
    $subject = $config['subject_prefix'] . $name;
    
    // Create email body
    $body = $lang === 'ar' ? 
        "رسالة جديدة من موقع الشركة\n\n" .
        "الاسم: $name\n" .
        "البريد الإلكتروني: $email\n" .
        "رقم الجوال: $phone\n" .
        "الخدمة المطلوبة: $service\n\n" .
        "تفاصيل المشروع:\n$message\n\n" .
        "تاريخ الإرسال: " . date('Y-m-d H:i:s')
        :
        "New message from company website\n\n" .
        "Name: $name\n" .
        "Email: $email\n" .
        "Phone: $phone\n" .
        "Requested Service: $service\n\n" .
        "Project Details:\n$message\n\n" .
        "Sent on: " . date('Y-m-d H:i:s');
    
    // Choose email method based on configuration
    if ($config['method'] === 'smtp') {
        return sendSMTPEmail($config, $subject, $body, $name, $email);
    } else {
        return sendBasicEmail($config, $subject, $body, $name, $email);
    }
}

// Basic mail() function
function sendBasicEmail($config, $subject, $body, $replyName, $replyEmail) {
    $headers = [
        "From: {$config['from_name']} <{$config['from_email']}>",
        "Reply-To: $replyName <$replyEmail>",
        "Content-Type: text/plain; charset=UTF-8",
        "X-Mailer: PHP/" . phpversion()
    ];
    
    return mail($config['to_email'], $subject, $body, implode("\r\n", $headers));
}

// SMTP authentication function
function sendSMTPEmail($config, $subject, $body, $replyName, $replyEmail) {
    // Connect to SMTP server
    $socket = fsockopen($config['smtp_host'], $config['smtp_port'], $errno, $errstr, 30);
    if (!$socket) {
        error_log("SMTP connection failed: $errstr ($errno)");
        return false;
    }
    
    // SMTP communication
    $commands = [
        "EHLO {$config['smtp_host']}",
        "STARTTLS",
        "AUTH LOGIN",
        base64_encode($config['smtp_username']),
        base64_encode($config['smtp_password']),
        "MAIL FROM: <{$config['from_email']}>",
        "RCPT TO: <{$config['to_email']}>",
        "DATA"
    ];
    
    // Read initial response
    fgets($socket, 512);
    
    foreach ($commands as $command) {
        fputs($socket, $command . "\r\n");
        $response = fgets($socket, 512);
        
        // Check for errors (codes starting with 4xx or 5xx indicate errors)
        if (substr($response, 0, 1) >= '4') {
            error_log("SMTP Error: $response");
            fclose($socket);
            return false;
        }
        
        // After STARTTLS, enable crypto
        if ($command === "STARTTLS") {
            stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
        }
    }
    
    // Send email content
    $email_content = "From: {$config['from_name']} <{$config['from_email']}>\r\n";
    $email_content .= "To: <{$config['to_email']}>\r\n";
    $email_content .= "Reply-To: $replyName <$replyEmail>\r\n";
    $email_content .= "Subject: $subject\r\n";
    $email_content .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $email_content .= "\r\n";
    $email_content .= $body . "\r\n";
    $email_content .= ".\r\n";
    
    fputs($socket, $email_content);
    fgets($socket, 512);
    
    // End SMTP session
    fputs($socket, "QUIT\r\n");
    fclose($socket);
    
    return true;
}

// Redirect back to home
header('Location: ../../index.php');
exit;
