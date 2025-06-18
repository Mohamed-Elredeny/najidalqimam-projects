<?php
session_start();
require_once '../../config/db.php';

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

// Redirect back to home
header('Location: ../../index.php');
exit;
