<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && hash('sha256', $_POST['password']) === $user['password']) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_name'] = $user['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'اسم المستخدم أو كلمة المرور غير صحيحة';
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | لوحة تحكم شركة ايجاز البوادي للمقاولات العامة</title>

    <!-- Bootstrap RTL CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.rtl.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #ffc107;
            --primary-dark: #e0a800;
            --secondary-color: #3f51b5;
            --text-color: #333;
            --bg-color: #f8f9fa;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(120deg, #eee 0%, #fff 100%);
            clip-path: polygon(0 0, 100% 0, 100% 80%, 0 100%);
            z-index: -1;
        }

        .login-container {
            display: flex;
            width: 900px;
            max-width: 100%;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            position: relative;
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .login-container::before {
            content: "";
            position: absolute;
            top: -10px;
            right: -10px;
            bottom: -10px;
            left: -10px;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            z-index: -1;
            border-radius: 20px;
            transform: translateZ(-10px);
            filter: blur(20px);
            opacity: 0.6;
        }

        .login-image-container {
            flex: 1;
            background: linear-gradient(to left, rgba(63, 81, 181, 0.8), rgba(63, 81, 181, 0.9)), url('../assets/img/construction.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: #fff;
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
        }

        .login-image-container::after {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: linear-gradient(0deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.2) 100%);
            transform: rotate(35deg);
        }

        .company-logo {
            max-width: 200px;
            margin-bottom: 30px;
            filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.5));
            transform: translateZ(20px);
            transition: all 0.3s ease;
        }

        .company-logo:hover {
            transform: translateZ(30px) scale(1.05);
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 20px;
            transform: translateZ(15px);
        }

        .welcome-text h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .welcome-text p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .login-form-container {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h3 {
            color: var(--secondary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #666;
            font-size: 0.95rem;
        }

        .form-floating {
            margin-bottom: 20px;
            position: relative;
        }

        .form-control {
            border: none;
            border-bottom: 2px solid #e0e0e0;
            border-radius: 0;
            padding: 12px 15px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            background-color: #fff;
        }

        .form-floating label {
            padding: 12px 15px;
            color: #666;
        }

        .input-group-text {
            background: transparent;
            border: none;
            border-bottom: 2px solid #e0e0e0;
            border-radius: 0;
        }

        .input-icon {
            color: var(--secondary-color);
        }

        .btn-login {
            padding: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            color: #333;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
            transition: all 0.3s ease;
            margin-top: 15px;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-login:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
            z-index: -1;
        }

        .btn-login:hover:before {
            left: 100%;
        }

        .btn-login:hover, .btn-login:focus {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 193, 7, 0.4);
            background: linear-gradient(90deg, var(--primary-dark) 0%, var(--primary-color) 100%);
        }

        .alert {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            position: relative;
            transform: translateZ(5px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        }

        .alert-danger {
            background-color: #fff;
            border-right: 5px solid #dc3545;
            color: #dc3545;
        }

        .floating-shapes div {
            position: absolute;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 15s infinite linear;
        }

        .floating-shapes div:nth-child(1) {
            top: 20%;
            left: 20%;
            animation-duration: 20s;
        }

        .floating-shapes div:nth-child(2) {
            top: 60%;
            left: 60%;
            width: 80px;
            height: 80px;
            animation-duration: 18s;
            animation-delay: 1s;
        }

        .floating-shapes div:nth-child(3) {
            top: 40%;
            left: 30%;
            width: 40px;
            height: 40px;
            animation-duration: 15s;
            animation-delay: 2s;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.8;
            }
            50% {
                transform: translateY(-60px) rotate(180deg);
                opacity: 0.2;
            }
            100% {
                transform: translateY(0) rotate(360deg);
                opacity: 0.8;
            }
        }

        /* 3D movement effect */
        .login-container {
            transition: transform 0.5s ease;
        }

        /* Responsive */
        @media (max-width: 767px) {
            .login-container {
                flex-direction: column;
                width: 100%;
            }

            .login-image-container {
                display: none;
            }

            .login-form-container {
                padding: 30px 20px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .login-container {
                width: 90%;
            }

            .login-image-container, .login-form-container {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
<div class="login-container" id="loginContainer">
    <div class="login-image-container">
        <div class="floating-shapes">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <img src="../assets/img/logo-white.png" alt="شركة انجاز النوادي للمقاولات" class="company-logo">
        <div class="welcome-text">
            <h2>مرحباً بكم</h2>
            <p>في لوحة تحكم شركة انجاز النوادي للمقاولات العامة</p>
        </div>
    </div>

    <div class="login-form-container">
        <div class="login-header">
            <h3>تسجيل الدخول</h3>
            <p>قم بتسجيل الدخول للوصول إلى لوحة التحكم</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" id="loginForm">
            <div class="form-floating mb-3">
                <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-user input-icon"></i>
            </span>
                    <input type="text" class="form-control" id="username" name="username" placeholder="اسم المستخدم" required>
                </div>
            </div>

            <div class="form-floating mb-4">
                <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-lock input-icon"></i>
            </span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="كلمة المرور" required>
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100">
                <i class="fas fa-sign-in-alt me-2"></i> تسجيل الدخول
            </button>
        </form>
    </div>
</div>

<!-- JavaScript for 3D effect -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('loginContainer');

        document.addEventListener('mousemove', function(e) {
            if (window.innerWidth > 767) { // Only apply effect on larger screens
                const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
                const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
                container.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
            }
        });

        // Reset position when mouse leaves
        document.addEventListener('mouseleave', function() {
            container.style.transform = 'rotateY(0deg) rotateX(0deg)';
        });

        // Form validation animation
        const loginForm = document.getElementById('loginForm');
        loginForm.addEventListener('submit', function(e) {
            // Animation can be added here if needed
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (!username || !password) {
                e.preventDefault();
                container.classList.add('shake');
                setTimeout(() => {
                    container.classList.remove('shake');
                }, 500);
            }
        });
    });
</script>
</body>
</html>