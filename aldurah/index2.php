<!DOCTYPE html>
<html lang="ar" dir="rtl" id="main-html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Al Durah - Advanced AI Solutions</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/0.160.0/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.3/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #0f0f1a;
            color: #ffffff;
            overflow-x: hidden;
        }

        html[dir="rtl"] body {
            direction: rtl;
        }

        html[dir="ltr"] body {
            direction: ltr;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(15, 15, 26, 0.8);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #00c6ff, #9c54ff);
            border-radius: 10px;
        }

        #music-toggle {
            position: fixed;
            bottom: 20px;
            z-index: 1000;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 1px solid rgba(156, 84, 255, 0.5);
            transition: all 0.3s ease;
        }

        html[dir="rtl"] #music-toggle {
            left: 20px;
        }

        html[dir="ltr"] #music-toggle {
            right: 20px;
        }

        #music-toggle:hover {
            transform: scale(1.1);
            background: rgba(255, 255, 255, 0.2);
        }

        #music-toggle i {
            color: #9c54ff;
            font-size: 1.5rem;
        }

        #language-toggle {
            position: fixed;
            bottom: 80px;
            z-index: 1000;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 1px solid rgba(156, 84, 255, 0.5);
            transition: all 0.3s ease;
            font-weight: bold;
        }

        html[dir="rtl"] #language-toggle {
            left: 20px;
        }

        html[dir="ltr"] #language-toggle {
            right: 20px;
        }

        #language-toggle:hover {
            transform: scale(1.1);
            background: rgba(255, 255, 255, 0.2);
        }

        #canvas-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: -1;
        }

        #lottie-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: -2;
            opacity: 0.3;
            pointer-events: none;
        }

        .nav-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1.5rem 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            transition: all 0.3s ease;
        }

        .nav-scrolled {
            background-color: rgba(15, 15, 26, 0.9);
            backdrop-filter: blur(10px);
            padding: 1rem 10%;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(90deg, #00c6ff, #9c54ff);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
        }

        html[dir="rtl"] .logo span {
            font-size: 2.2rem;
            margin-left: 5px;
        }

        html[dir="ltr"] .logo span {
            font-size: 2.2rem;
            margin-right: 5px;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: #ffffff;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a:after {
            content: '';
            position: absolute;
            bottom: -5px;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #00c6ff, #9c54ff);
            transition: width 0.3s ease;
        }

        html[dir="rtl"] .nav-links a:after {
            right: 0;
        }

        html[dir="ltr"] .nav-links a:after {
            left: 0;
        }

        .nav-links a:hover:after {
            width: 100%;
        }

        .nav-links a:hover {
            color: #9c54ff;
        }

        .mobile-menu-btn {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
            color: #ffffff;
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            width: 80%;
            height: 100vh;
            background: rgba(15, 15, 26, 0.95);
            backdrop-filter: blur(10px);
            z-index: 200;
            transition: all 0.5s ease;
            padding: 4rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        html[dir="rtl"] .mobile-menu {
            right: -100%;
        }

        html[dir="rtl"] .mobile-menu.open {
            right: 0;
        }

        html[dir="ltr"] .mobile-menu {
            left: -100%;
        }

        html[dir="ltr"] .mobile-menu.open {
            left: 0;
        }

        .mobile-menu-close {
            position: absolute;
            top: 1rem;
            font-size: 1.5rem;
            color: #ffffff;
            cursor: pointer;
        }

        html[dir="rtl"] .mobile-menu-close {
            left: 1rem;
        }

        html[dir="ltr"] .mobile-menu-close {
            right: 1rem;
        }

        .mobile-menu a {
            color: #ffffff;
            text-decoration: none;
            font-size: 1.3rem;
            font-weight: 500;
            margin: 1rem 0;
            transition: all 0.3s ease;
        }

        .mobile-menu a:hover {
            color: #9c54ff;
        }

        .cta-btn {
            background: linear-gradient(90deg, #00c6ff, #9c54ff);
            color: #ffffff;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 10%;
            position: relative;
        }

        .hero-content {
            max-width: 700px;
            z-index: 1;
            opacity: 0;
            transform: translateY(30px);
        }

        .hero h1 {
            font-size: 4rem;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            background: linear-gradient(90deg, #ffffff, #9c54ff);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.25rem;
            line-height: 1.6;
            color: #b8b8d4;
            margin-bottom: 2rem;
        }

        .hero-btns {
            display: flex;
            gap: 1rem;
        }

        .secondary-btn {
            background: transparent;
            color: #ffffff;
            border: 2px solid #9c54ff;
            padding: 0.8rem 1.5rem;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .secondary-btn:hover {
            background: rgba(156, 84, 255, 0.1);
            transform: translateY(-3px);
        }

        .ai-float {
            position: absolute;
            width: 35%;
            opacity: 0;
            transform: translateX(-50px);
        }

        html[dir="rtl"] .ai-float {
            left: 10%;
            top: 20%;
        }

        html[dir="ltr"] .ai-float {
            right: 10%;
            top: 20%;
            transform: translateX(50px);
        }

        .ai-brain {
            width: 100%;
            max-width: 400px;
            filter: drop-shadow(0 0 20px rgba(156, 84, 255, 0.5));
        }

        .section {
            padding: 8rem 10%;
            position: relative;
            z-index: 1;
        }

        .section-title {
            font-size: 2.5rem;
            margin-bottom: 3rem;
            text-align: center;
            background: linear-gradient(90deg, #00c6ff, #9c54ff);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            opacity: 0;
            transform: translateY(30px);
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #b8b8d4;
            margin-bottom: 4rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            opacity: 0;
            transform: translateY(30px);
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .service-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.5s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: scale(0.9);
            cursor: pointer;
        }

        .service-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(156, 84, 255, 0.3);
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(156, 84, 255, 0.1), transparent);
            transform: translateX(100%);
            transition: all 0.7s ease;
        }

        html[dir="rtl"] .service-card::before {
            right: 0;
        }

        html[dir="ltr"] .service-card::before {
            left: 0;
        }

        .service-card:hover::before {
            transform: translateX(-100%);
        }

        .service-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            background: linear-gradient(90deg, #00c6ff, #9c54ff);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .service-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .service-card p {
            color: #b8b8d4;
            line-height: 1.6;
        }

        .service-link {
            display: inline-block;
            margin-top: 1.5rem;
            color: #9c54ff;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .service-link:after {
            margin-right: 5px;
            transition: transform 0.3s ease;
            display: inline-block;
        }

        html[dir="rtl"] .service-link:after {
            content: '←';
        }

        html[dir="ltr"] .service-link:after {
            content: '→';
        }

        html[dir="rtl"] .service-link:hover:after {
            transform: translateX(-5px);
        }

        html[dir="ltr"] .service-link:hover:after {
            transform: translateX(5px);
        }

        .features {
            background: rgba(15, 15, 26, 0.8);
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 3rem;
            gap: 2rem;
            opacity: 0;
            transform: translateX(-30px);
        }

        html[dir="ltr"] .feature-item {
            flex-direction: row-reverse;
            transform: translateX(30px);
        }

        .feature-icon {
            min-width: 60px;
            height: 60px;
            background: linear-gradient(90deg, #00c6ff, #9c54ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .feature-icon::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
            top: -100%;
            border-radius: 50%;
            transition: all 0.5s ease;
        }

        html[dir="rtl"] .feature-icon::after {
            right: -100%;
        }

        html[dir="ltr"] .feature-icon::after {
            left: -100%;
        }

        .feature-item:hover .feature-icon::after {
            top: 0;
            right: 0;
            left: 0;
            opacity: 0;
        }

        .feature-text h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .feature-text p {
            color: #b8b8d4;
            line-height: 1.6;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .stat-item {
            text-align: center;
            opacity: 0;
            transform: translateY(30px);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(90deg, #00c6ff, #9c54ff);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        .stat-label {
            color: #b8b8d4;
            font-size: 1.1rem;
        }

        .testimonial-slider {
            max-width: 800px;
            margin: 0 auto;
            overflow: hidden;
            position: relative;
            opacity: 0;
            transform: scale(0.95);
        }

        .testimonial-slide {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .testimonial-slide::before {
            content: '"';
            position: absolute;
            top: 20px;
            font-size: 5rem;
            color: rgba(156, 84, 255, 0.2);
            font-family: serif;
        }

        html[dir="rtl"] .testimonial-slide::before {
            right: 30px;
        }

        html[dir="ltr"] .testimonial-slide::before {
            left: 30px;
        }

        .testimonial-content {
            font-size: 1.2rem;
            line-height: 1.6;
            color: #b8b8d4;
            margin-bottom: 2rem;
        }

        .testimonial-author {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .testimonial-position {
            color: #9c54ff;
            margin-top: 0.5rem;
        }

        .contact {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
        }

        .contact-form {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0;
            transform: translateX(30px);
        }

        html[dir="rtl"] .contact-form {
            transform: translateX(30px);
        }

        html[dir="ltr"] .contact-form {
            transform: translateX(-30px);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #b8b8d4;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        html[dir="rtl"] .form-group input,
        html[dir="rtl"] .form-group textarea {
            text-align: right;
        }

        html[dir="ltr"] .form-group input,
        html[dir="ltr"] .form-group textarea {
            text-align: left;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #9c54ff;
            box-shadow: 0 0 10px rgba(156, 84, 255, 0.3);
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            opacity: 0;
        }

        html[dir="rtl"] .contact-info {
            transform: translateX(-30px);
        }

        html[dir="ltr"] .contact-info {
            transform: translateX(30px);
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        html[dir="ltr"] .contact-item {
            flex-direction: row-reverse;
        }

        .contact-icon {
            font-size: 1.5rem;
            color: #9c54ff;
        }

        .contact-details h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .contact-details p {
            color: #b8b8d4;
            line-height: 1.6;
        }

        footer {
            background: rgba(10, 10, 20, 0.8);
            padding: 4rem 10%;
            text-align: center;
        }

        .footer-logo {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(90deg, #00c6ff, #9c54ff);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 2rem;
            display: inline-block;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-links a {
            color: #b8b8d4;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: #9c54ff;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: #9c54ff;
            transform: translateY(-3px);
        }

        .copyright {
            color: #b8b8d4;
            font-size: 0.9rem;
        }

        .floating-element {
            position: absolute;
            background: radial-gradient(circle, rgba(156, 84, 255, 0.2), transparent 70%);
            border-radius: 50%;
            filter: blur(60px);
            z-index: -1;
        }

        .floating-1 {
            width: 500px;
            height: 500px;
            top: 10%;
            animation: float 10s ease-in-out infinite;
        }

        html[dir="rtl"] .floating-1 {
            left: -100px;
        }

        html[dir="ltr"] .floating-1 {
            right: -100px;
        }

        .floating-2 {
            width: 400px;
            height: 400px;
            bottom: 20%;
            background: radial-gradient(circle, rgba(0, 198, 255, 0.2), transparent 70%);
            animation: float 12s ease-in-out infinite reverse;
        }

        html[dir="rtl"] .floating-2 {
            right: -100px;
        }

        html[dir="ltr"] .floating-2 {
            left: -100px;
        }

        .progress-bar {
            position: fixed;
            top: 0;
            width: 5px;
            height: 0;
            background: linear-gradient(180deg, #00c6ff, #9c54ff);
            z-index: 1000;
        }

        html[dir="rtl"] .progress-bar {
            right: 0;
        }

        html[dir="ltr"] .progress-bar {
            left: 0;
        }

        .scroll-down {
            position: absolute;
            bottom: 30px;
            right: 50%;
            transform: translateX(50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            color: #ffffff;
            opacity: 0.7;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .scroll-down:hover {
            opacity: 1;
            transform: translate(50%, -5px);
        }

        .scroll-down-text {
            font-size: 0.9rem;
        }

        .scroll-down-icon {
            width: 30px;
            height: 50px;
            border: 2px solid #ffffff;
            border-radius: 20px;
            position: relative;
            display: flex;
            justify-content: center;
        }

        .scroll-down-icon::before {
            content: '';
            position: absolute;
            top: 10px;
            width: 4px;
            height: 10px;
            background: #ffffff;
            border-radius: 2px;
            animation: scrollAnimate 2s infinite;
        }

        @keyframes scrollAnimate {
            0% { transform: translateY(0); opacity: 1; }
            50% { transform: translateY(10px); opacity: 0.5; }
            100% { transform: translateY(0); opacity: 1; }
        }

        @keyframes float {
            0% { transform: translate(0, 0); }
            50% { transform: translate(-50px, 30px); }
            100% { transform: translate(0, 0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Service Modal Styles */
        .service-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 10, 20, 0.9);
            backdrop-filter: blur(10px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.5s ease;
            overflow-y: auto;
        }

        .service-modal.active {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-content {
            background: rgba(20, 20, 35, 0.9);
            width: 90%;
            max-width: 1000px;
            max-height: 90vh;
            border-radius: 20px;
            padding: 3rem;
            position: relative;
            overflow-y: auto;
            opacity: 0;
            transform: scale(0.9);
            transition: all 0.5s ease;
        }

        .modal-content.active {
            opacity: 1;
            transform: scale(1);
        }

        .modal-close {
            position: absolute;
            top: 20px;
            font-size: 1.5rem;
            color: #ffffff;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(156, 84, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        html[dir="rtl"] .modal-close {
            left: 20px;
        }

        html[dir="ltr"] .modal-close {
            right: 20px;
        }

        .modal-close:hover {
            background: rgba(156, 84, 255, 0.4);
            transform: rotate(90deg);
        }

        .modal-header {
            margin-bottom: 2rem;
        }

        .modal-header h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(90deg, #ffffff, #9c54ff);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .modal-header p {
            color: #b8b8d4;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .modal-body {
            margin-bottom: 2rem;
        }

        .modal-body h3 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: #ffffff;
        }

        .modal-body p {
            color: #b8b8d4;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .modal-media {
            border-radius: 10px;
            overflow: hidden;
            margin: 2rem 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .modal-media img {
            width: 100%;
            height: auto;
            display: block;
        }

        .modal-features {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 2rem;
            margin: 2rem 0;
        }

        .modal-features h4 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #ffffff;
        }

        .feature-list {
            list-style: none;
        }

        .feature-list li {
            color: #b8b8d4;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .feature-list li::before {
            content: '•';
            color: #9c54ff;
            font-size: 1.5rem;
            margin-right: 0.5rem;
        }

        .modal-footer {
            margin-top: 3rem;
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        /* Service Content Styles */
        .service-content {
            display: none;
        }

        /* Mobile Responsiveness */
        @media (max-width: 992px) {
            .modal-content {
                padding: 2rem;
            }
        }

        @media (max-width: 768px) {
            .nav-container {
                padding: 1rem 5%;
            }
            
            .nav-links {
                display: none;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .section {
                padding: 4rem 5%;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .services-grid {
                grid-template-columns: 1fr;
            }
            
            .feature-item {
                flex-direction: column;
                gap: 1rem;
            }
            
            html[dir="ltr"] .feature-item {
                flex-direction: column;
            }
            
            .stats {
                grid-template-columns: 1fr;
            }
            
            .contact {
                grid-template-columns: 1fr;
            }
            
            .hero-btns {
                flex-direction: column;
                gap: 1rem;
            }
            
            .cta-btn, .secondary-btn {
                width: 100%;
                text-align: center;
            }
            
            .ai-float {
                display: none;
            }
            
            .modal-content {
                padding: 2rem 1rem;
            }
            
            .modal-header h2 {
                font-size: 2rem;
            }
            
            .modal-footer {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="progress-bar"></div>
    
    <div id="music-toggle">
        <i class="fas fa-volume-mute"></i>
    </div>
    
    <div id="language-toggle">EN</div>
    
    <div id="canvas-container"></div>
    <div id="lottie-container"></div>
    
    <nav class="nav-container">
        <div class="logo"><span>⬢</span><span class="logo-text">الدرة</span></div>
        <div class="nav-links">
            <a href="#services" class="nav-link" data-key="services"></a>
            <a href="#features" class="nav-link" data-key="features"></a>
            <a href="#about" class="nav-link" data-key="about"></a>
            <a href="#testimonials" class="nav-link" data-key="testimonials"></a>
            <a href="#contact" class="nav-link" data-key="contact"></a>
        </div>
        <button class="cta-btn" data-key="getStarted"></button>
        <div class="mobile-menu-btn">
            <i class="fas fa-bars"></i>
        </div>
    </nav>
    
    <div class="mobile-menu">
        <div class="mobile-menu-close">
            <i class="fas fa-times"></i>
        </div>
        <a href="#services" class="mobile-nav-link" data-key="services"></a>
        <a href="#features" class="mobile-nav-link" data-key="features"></a>
        <a href="#about" class="mobile-nav-link" data-key="about"></a>
        <a href="#testimonials" class="mobile-nav-link" data-key="testimonials"></a>
        <a href="#contact" class="mobile-nav-link" data-key="contact"></a>
        <button class="cta-btn" style="margin-top: 2rem;" data-key="getStarted"></button>
    </div>
    
    <section class="hero">
        <div class="floating-element floating-1"></div>
        <div class="floating-element floating-2"></div>
        <div class="hero-content">
            <h1 data-key="heroTitle"></h1>
            <p data-key="heroDescription"></p>
            <div class="hero-btns">
                <button class="cta-btn" data-key="exploreSolutions"></button>
                <button class="secondary-btn" data-key="scheduleDemo"></button>
            </div>
        </div>
        <div class="ai-float">
            <img src="/api/placeholder/500/500" alt="Brain AI" class="ai-brain">
        </div>
        <div class="scroll-down">
            <div class="scroll-down-text" data-key="scrollDown"></div>
            <div class="scroll-down-icon"></div>
        </div>
    </section>
    
    <section class="section" id="services">
        <h2 class="section-title" data-key="ourServices"></h2>
        <p class="section-subtitle" data-key="servicesSubtitle"></p>
        <div class="services-grid">
            <!-- Service cards will be generated dynamically -->
        </div>
    </section>
    
    <section class="section features" id="features">
        <h2 class="section-title" data-key="whyChooseUs"></h2>
        <div class="features-container">
            <!-- Features will be generated dynamically -->
        </div>
    </section>
    
    <section class="section" id="about">
        <h2 class="section-title" data-key="ourImpact"></h2>
        <div class="stats">
            <!-- Stats will be generated dynamically -->
        </div>
    </section>
    
    <section class="section" id="testimonials">
        <h2 class="section-title" data-key="clientTestimonials"></h2>
        <div class="testimonial-slider">
            <div class="testimonial-slide">
                <div class="testimonial-content" data-key="testimonialContent"></div>
                <div class="testimonial-author" data-key="testimonialAuthor"></div>
                <div class="testimonial-position" data-key="testimonialPosition"></div>
            </div>
        </div>
    </section>
    
    <section class="section" id="contact">
        <h2 class="section-title" data-key="contactUs"></h2>
        <div class="contact">
            <div class="contact-info">
                <!-- Contact info will be generated dynamically -->
            </div>
            <div class="contact-form">
                <div class="form-group">
                    <label for="name" data-key="fullName"></label>
                    <input type="text" id="name" data-key="enterName" data-placeholder="true">
                </div>
                <div class="form-group">
                    <label for="email" data-key="emailAddress"></label>
                    <input type="email" id="email" data-key="enterEmail" data-placeholder="true">
                </div>
                <div class="form-group">
                    <label for="company" data-key="company"></label>
                    <input type="text" id="company" data-key="enterCompany" data-placeholder="true">
                </div>
                <div class="form-group">
                    <label for="message" data-key="message"></label>
                    <textarea id="message" data-key="enterMessage" data-placeholder="true"></textarea>
                </div>
                <button class="cta-btn" data-key="sendMessage"></button>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="footer-logo"></div>
        <div class="footer-links">
            <!-- Footer links will be generated dynamically -->
        </div>
        <div class="social-links">
            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <div class="copyright" data-key="copyright"></div>
    </footer>

    <!-- Service Modal -->
    <div class="service-modal">
        <div class="modal-content">
            <div class="modal-close"><i class="fas fa-times"></i></div>
            <div class="modal-header">
                <h2 id="modal-title"></h2>
                <p id="modal-description"></p>
            </div>
            <div class="modal-body">
                <div class="modal-media">
                    <img src="/api/placeholder/900/500" alt="Service" id="modal-image">
                </div>
                <h3 id="modal-subtitle"></h3>
                <p id="modal-text"></p>
                <div class="modal-features">
                    <h4 id="modal-features-title"></h4>
                    <ul class="feature-list" id="modal-features-list">
                        <!-- Features will be inserted here -->
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button class="cta-btn" id="modal-cta"></button>
                <button class="secondary-btn" id="modal-secondary"></button>
            </div>
        </div>
    </div>

    <!-- Service content storage for modals -->
    <div class="service-content" id="ai-consulting">
        <!-- Content will be loaded dynamically -->
    </div>
    <div class="service-content" id="machine-learning">
        <!-- Content will be loaded dynamically -->
    </div>
    <div class="service-content" id="conversational-ai">
        <!-- Content will be loaded dynamically -->
    </div>
    <div class="service-content" id="predictive-analytics">
        <!-- Content will be loaded dynamically -->
    </div>
    <div class="service-content" id="computer-vision">
        <!-- Content will be loaded dynamically -->
    </div>
    <div class="service-content" id="process-automation">
        <!-- Content will be loaded dynamically -->
    </div>

    <script>
        // Language and Content Management
        const content = {
            ar: {
                // Navigation
                logo: "الدرة",
                services: "الخدمات",
                features: "المميزات",
                about: "عن الشركة",
                testimonials: "آراء العملاء",
                contact: "اتصل بنا",
                getStarted: "ابدأ الآن",
                
                // Hero Section
                heroTitle: "حوّل أعمالك بحلول الذكاء الاصطناعي المتقدمة",
                heroDescription: "استفد من قوة الذكاء الاصطناعي المتطور لتحسين العمليات، ودفع الابتكار، وفتح إمكانيات جديدة لمؤسستك.",
                exploreSolutions: "استكشف الحلول",
                scheduleDemo: "احجز عرضاً توضيحياً",
                scrollDown: "اكتشف المزيد",
                
                // Services Section
                ourServices: "خدماتنا",
                servicesSubtitle: "نقدم مجموعة متكاملة من حلول الذكاء الاصطناعي المبتكرة والمصممة خصيصاً لمساعدة مؤسستك على النمو والتطور في العصر الرقمي.",
                servicesData: [
                    {
                        id: "ai-consulting",
                        icon: "fas fa-brain",
                        title: "استشارات الذكاء الاصطناعي",
                        description: "توجيه خبير في تنفيذ استراتيجيات الذكاء الاصطناعي المصممة خصيصاً لأهداف عملك وتحديات صناعتك المحددة.",
                        link: "اكتشف المزيد",
                        modalContent: {
                            title: "استشارات الذكاء الاصطناعي",
                            description: "نساعد الشركات على اكتشاف وتنفيذ استراتيجيات ذكاء اصطناعي فعالة ومناسبة لاحتياجاتها الخاصة.",
                            subtitle: "تحويل رؤيتك إلى واقع ملموس",
                            text: "فريقنا من الخبراء يجمع بين المعرفة العميقة بتقنيات الذكاء الاصطناعي والفهم الاستراتيجي للأعمال، مما يضمن أن تكون حلولنا الاستشارية مصممة لتحقيق أهداف عملك المحددة. نحن نعمل معك جنبًا إلى جنب لتحديد الفرص، وتطوير الاستراتيجيات، ودعم التنفيذ لضمان الحصول على قيمة حقيقية من استثماراتك في الذكاء الاصطناعي.",
                            featuresTitle: "ما نقدمه",
                            features: [
                                "تقييم شامل لجاهزية الذكاء الاصطناعي والفرص المتاحة",
                                "تطوير استراتيجية ذكاء اصطناعي مخصصة لعملك",
                                "تحديد وتحليل حالات الاستخدام ذات الأولوية والعائد الاستثماري المحتمل",
                                "إنشاء خارطة طريق للتنفيذ مع مراحل واضحة",
                                "دعم إدارة التغيير وتطوير القدرات الداخلية"
                            ],
                            ctaButton: "احصل على استشارة مجانية",
                            secondaryButton: "اطلع على دراسات الحالة"
                        }
                    },
                    {
                        id: "machine-learning",
                        icon: "fas fa-robot",
                        title: "حلول تعلم الآلة",
                        description: "نماذج تعلم الآلة المخصصة لحل المشكلات المعقدة، وتحديد الأنماط، وتقديم تنبؤات بدقة لا مثيل لها.",
                        link: "اكتشف المزيد",
                        modalContent: {
                            title: "حلول تعلم الآلة",
                            description: "نطور نماذج تعلم آلة مخصصة وقوية لمعالجة تحدياتك الأكثر تعقيدًا وتقديم رؤى مبتكرة.",
                            subtitle: "قوة الذكاء التنبؤي",
                            text: "تمكّن حلول تعلم الآلة لدينا الشركات من الاستفادة من بياناتها لاكتشاف أنماط خفية، وتحسين العمليات، وتوقع النتائج المستقبلية. نحن نطور خوارزميات متقدمة مصممة خصيصًا لتلبية احتياجاتك المحددة، سواء كنت تسعى إلى تحسين تجربة العملاء، أو تحسين كفاءة سلسلة التوريد، أو تطوير منتجات مبتكرة.",
                            featuresTitle: "حلولنا تشمل",
                            features: [
                                "نماذج تعلم عميق متقدمة للمهام المعقدة",
                                "أنظمة توصية ذكية لتحسين المبيعات والمشاركة",
                                "تحليل التنبؤ بالصيانة لتقليل التوقف عن العمل",
                                "تصنيف العملاء وتحليل التسرب",
                                "اكتشاف الاحتيال وأنظمة الأمان المتقدمة"
                            ],
                            ctaButton: "استشر خبيرًا الآن",
                            secondaryButton: "استكشف حالات الاستخدام"
                        }
                    },
                    {
                        id: "conversational-ai",
                        icon: "fas fa-comments",
                        title: "الذكاء الاصطناعي التحاوري",
                        description: "روبوتات الدردشة الذكية والمساعدين الافتراضيين التي تحول تجارب العملاء وتبسط عمليات الدعم.",
                        link: "اكتشف المزيد",
                        modalContent: {
                            title: "الذكاء الاصطناعي التحاوري",
                            description: "ارتقِ بتجربة العملاء مع روبوتات المحادثة الذكية والمساعدين الافتراضيين المصممين لتقديم تفاعلات طبيعية وفعالة.",
                            subtitle: "تفاعلات محادثة طبيعية ومفيدة",
                            text: "تستخدم حلول الذكاء الاصطناعي التحاوري أحدث تقنيات معالجة اللغة الطبيعية والتعلم العميق لإنشاء تفاعلات محادثة طبيعية ومفيدة مع العملاء. نصمم روبوتات دردشة ومساعدين افتراضيين يمكنهم فهم سياق المحادثة، وتذكر التفاصيل المهمة، والإجابة على الاستفسارات المعقدة بدقة ولباقة.",
                            featuresTitle: "مزايا الذكاء الاصطناعي التحاوري",
                            features: [
                                "روبوتات دردشة ذكية متعددة القنوات تعمل على موقعك الإلكتروني وتطبيقات المراسلة ووسائل التواصل الاجتماعي",
                                "مساعدون افتراضيون مخصصون مدربون على معرفة منتجاتك وخدماتك وعمليات عملك",
                                "تكامل سلس مع أنظمة CRM وأدوات خدمة العملاء الموجودة لديك",
                                "تحليلات متقدمة لتتبع الأداء وتحسين التفاعلات باستمرار",
                                "دعم للغة العربية والإنجليزية ولغات متعددة أخرى"
                            ],
                            ctaButton: "احصل على عرض توضيحي",
                            secondaryButton: "اطلع على النماذج"
                        }
                    },
                    {
                        id: "predictive-analytics",
                        icon: "fas fa-chart-line",
                        title: "التحليلات التنبؤية",
                        description: "حوّل بياناتك إلى رؤى قابلة للتنفيذ وتوقعات دقيقة لاتخاذ قرارات أعمال مستنيرة.",
                        link: "اكتشف المزيد",
                        modalContent: {
                            title: "التحليلات التنبؤية",
                            description: "استخدم قوة البيانات لاستباق الاتجاهات المستقبلية واتخاذ قرارات أكثر ذكاءً لعملك.",
                            subtitle: "رؤى مستقبلية مدعومة بالبيانات",
                            text: "تتيح خدمات التحليلات التنبؤية لدينا للشركات تحويل كميات هائلة من البيانات إلى رؤى عملية واستراتيجية. من خلال تطبيق تقنيات إحصائية متقدمة وخوارزميات تعلم الآلة، نساعد العملاء على التنبؤ بالاتجاهات المستقبلية، وتحديد الفرص المحتملة، واستباق التحديات قبل حدوثها.",
                            featuresTitle: "قدرات التحليلات لدينا",
                            features: [
                                "التنبؤ بسلوك العملاء واتجاهات المبيعات",
                                "تحليل المخزون وتحسين سلسلة التوريد",
                                "تقييم المخاطر المالية والاحتيال",
                                "التنبؤ بالاحتياجات التشغيلية وتخطيط الموارد",
                                "لوحات معلومات تفاعلية وتقارير مخصصة"
                            ],
                            ctaButton: "احصل على تحليل مجاني",
                            secondaryButton: "شاهد العروض التوضيحية"
                        }
                    },
                    {
                        id: "computer-vision",
                        icon: "fas fa-eye",
                        title: "رؤية الحاسوب",
                        description: "حلول متقدمة للتعرف على الصور ومعالجة البيانات المرئية للأتمتة ومراقبة الجودة.",
                        link: "اكتشف المزيد",
                        modalContent: {
                            title: "رؤية الحاسوب",
                            description: "منح أنظمتك القدرة على رؤية وتفسير العالم المرئي مع حلول رؤية الحاسوب المتقدمة.",
                            subtitle: "تمكين الآلات من الرؤية",
                            text: "تقدم حلول رؤية الحاسوب لدينا تقنيات متطورة تمكن الأنظمة من تحليل وفهم المحتوى المرئي بدقة تضاهي الإنسان أو تتفوق عليه. نحن نطور أنظمة مخصصة يمكنها التعرف على الكائنات، وتحليل المشاهد، واكتشاف الأنماط، وتتبع الحركة، مما يفتح إمكانيات جديدة للأتمتة والتحليل في مختلف الصناعات.",
                            featuresTitle: "تطبيقات رؤية الحاسوب",
                            features: [
                                "فحص الجودة التلقائي وكشف العيوب",
                                "تتبع المنتجات ومراقبة المخزون",
                                "تحليل سلوك العملاء في المتاجر",
                                "أنظمة الأمان والمراقبة الذكية",
                                "التشخيص الطبي المساعد وتحليل الصور"
                            ],
                            ctaButton: "استكشف الإمكانيات",
                            secondaryButton: "طلب عرض توضيحي"
                        }
                    },
                    {
                        id: "process-automation",
                        icon: "fas fa-cogs",
                        title: "أتمتة العمليات",
                        description: "حلول الأتمتة الذكية التي تحسن سير العمل، وتقلل التكاليف، وتحرر الموارد البشرية.",
                        link: "اكتشف المزيد",
                        modalContent: {
                            title: "أتمتة العمليات",
                            description: "تحسين الكفاءة وتقليل التكاليف من خلال أتمتة العمليات التجارية المتكررة والمعقدة.",
                            subtitle: "تحرير الإمكانات البشرية",
                            text: "تمكّن حلول أتمتة العمليات لدينا الشركات من تبسيط العمليات المتكررة والمستهلكة للوقت، مما يتيح للموظفين التركيز على الأنشطة ذات القيمة المضافة العالية. من خلال الجمع بين الأتمتة الروبوتية للعمليات (RPA) والذكاء الاصطناعي، نقدم حلول أتمتة ذكية يمكنها التعامل مع المهام البسيطة والمعقدة على حد سواء.",
                            featuresTitle: "فوائد أتمتة العمليات",
                            features: [
                                "تقليل الأخطاء البشرية وزيادة الدقة",
                                "تحسين وقت المعالجة وزيادة الإنتاجية",
                                "خفض التكاليف التشغيلية",
                                "تحسين تجربة العملاء والموظفين",
                                "قابلية التوسع السريع لتلبية احتياجات العمل المتغيرة"
                            ],
                            ctaButton: "ابدأ رحلة الأتمتة",
                            secondaryButton: "تحليل عملياتك مجانًا"
                        }
                    }
                ],
                
                // Features Section
                whyChooseUs: "لماذا تختار الدرة",
                featuresData: [
                    {
                        icon: "١",
                        title: "تكنولوجيا متطورة",
                        description: "تستفيد حلولنا من أحدث التطورات في الذكاء الاصطناعي وتعلم الآلة والتعلم العميق لتقديم نتائج متفوقة والبقاء في المقدمة. نحن نستثمر باستمرار في البحث والتطوير لضمان حصول عملائنا على أكثر الحلول التكنولوجية تقدمًا وفعالية في السوق."
                    },
                    {
                        icon: "٢",
                        title: "خبرة في الصناعة",
                        description: "مع معرفة عميقة في مجالات متعددة من الصناعات، نطور حلول الذكاء الاصطناعي التي تعالج التحديات المحددة وتعظم العائد على الاستثمار. فريقنا من الخبراء لديهم سنوات من الخبرة في تطبيق الذكاء الاصطناعي في قطاعات متنوعة مثل التمويل والرعاية الصحية والتصنيع والتجزئة والخدمات اللوجستية."
                    },
                    {
                        icon: "٣",
                        title: "تكامل سلس",
                        description: "تتكامل أنظمة الذكاء الاصطناعي لدينا بسلاسة مع البنية التحتية وسير العمل الحالية، مما يقلل من الاضطرابات ويسرع الوصول إلى القيمة. نحن نتبنى نهجًا مرحليًا يسمح لك بدمج تقنيات الذكاء الاصطناعي الجديدة دون تعطيل العمليات اليومية، مما يضمن انتقالًا سلسًا وفعالًا."
                    },
                    {
                        icon: "٤",
                        title: "حلول قابلة للتوسع",
                        description: "تتيح البنية المرنة لدينا لقدرات الذكاء الاصطناعي أن تنمو جنباً إلى جنب مع عملك، من إثبات المفهوم الأولي إلى النشر على مستوى المؤسسة. تم تصميم منصتنا لتتكيف مع الاحتياجات المتغيرة والمتنامية، مما يسمح لك بالبدء بمشروع صغير ثم التوسع تدريجياً مع تطور أعمالك."
                    }
                ],
                
                // About Section (Impact/Stats)
                ourImpact: "تأثيرنا",
                statsData: [
                    {
                        number: "+٢٠٠",
                        label: "عميل عالمي"
                    },
                    {
                        number: "٪٩٢",
                        label: "معدل النجاح"
                    },
                    {
                        number: "+٥٠ مليون$",
                        label: "توفير للعملاء"
                    },
                    {
                        number: "+٤٥",
                        label: "جائزة صناعية"
                    }
                ],
                
                // Testimonials Section
                clientTestimonials: "ماذا يقول عملاؤنا",
                testimonialContent: "لقد حولت الدرة عمليات خدمة العملاء لدينا بحل الذكاء الاصطناعي التحاوري. لقد شهدنا انخفاضًا بنسبة ٤٠٪ في أوقات الاستجابة ودرجات غير مسبوقة من رضا العملاء. كما أن قدرة نظامهم على التعلم والتكيف مع احتياجاتنا المتغيرة كانت مذهلة.",
                testimonialAuthor: "سارة جونسون",
                testimonialPosition: "المدير التقني، شركة التجزئة العالمية",
                
                // Contact Section
                contactUs: "تواصل معنا",
                contactData: [
                    {
                        icon: "fas fa-map-marker-alt",
                        title: "العنوان",
                        details: "١٢٣ طريق الابتكار، حي التقنية، سان فرانسيسكو، كاليفورنيا ٩٤١٠٧، الولايات المتحدة الأمريكية"
                    },
                    {
                        icon: "fas fa-phone-alt",
                        title: "الهاتف",
                        details: "+١ (٥٥٥) ١٢٣-٤٥٦٧"
                    },
                    {
                        icon: "fas fa-envelope",
                        title: "البريد الإلكتروني",
                        details: "contact@aldurah.tech"
                    }
                ],
                fullName: "الاسم الكامل",
                enterName: "أدخل اسمك",
                emailAddress: "البريد الإلكتروني",
                enterEmail: "أدخل بريدك الإلكتروني",
                company: "الشركة",
                enterCompany: "أدخل اسم شركتك",
                message: "الرسالة",
                enterMessage: "أخبرنا عن مشروعك أو استفسارك",
                sendMessage: "إرسال الرسالة",
                
                // Footer
                copyright: "© ٢٠٢٥ الدرة. جميع الحقوق محفوظة."
            },
            en: {
                // Navigation
                logo: "Al Durah",
                services: "Services",
                features: "Features",
                about: "About",
                testimonials: "Testimonials",
                contact: "Contact",
                getStarted: "Get Started",
                
                // Hero Section
                heroTitle: "Transform Your Business With Advanced AI Solutions",
                heroDescription: "Harness the power of cutting-edge artificial intelligence to optimize operations, drive innovation, and unlock new possibilities for your organization.",
                exploreSolutions: "Explore Solutions",
                scheduleDemo: "Schedule Demo",
                scrollDown: "Discover More",
                
                // Services Section
                ourServices: "Our Services",
                servicesSubtitle: "We provide a comprehensive suite of innovative AI solutions designed to help your organization grow and evolve in the digital age.",
                servicesData: [
                    {
                        id: "ai-consulting",
                        icon: "fas fa-brain",
                        title: "AI Consulting",
                        description: "Expert guidance on implementing AI strategies tailored to your business objectives and industry-specific challenges.",
                        link: "Learn More",
                        modalContent: {
                            title: "AI Consulting",
                            description: "We help businesses discover and implement effective AI strategies tailored to their unique needs.",
                            subtitle: "Turning Your Vision into Reality",
                            text: "Our team of experts combines deep knowledge of AI technologies with strategic business understanding, ensuring our consulting solutions are crafted to achieve your specific business objectives. We work alongside you to identify opportunities, develop strategies, and support implementation to ensure you derive real value from your AI investments.",
                            featuresTitle: "What We Offer",
                            features: [
                                "Comprehensive AI readiness assessments and opportunity identification",
                                "Development of custom AI strategies for your business",
                                "Prioritization and analysis of use cases with potential ROI",
                                "Implementation roadmap creation with clear phases",
                                "Change management support and internal capability development"
                            ],
                            ctaButton: "Get Free Consultation",
                            secondaryButton: "View Case Studies"
                        }
                    },
                    {
                        id: "machine-learning",
                        icon: "fas fa-robot",
                        title: "Machine Learning Solutions",
                        description: "Custom ML models built to solve complex problems, identify patterns, and make predictions with unparalleled accuracy.",
                        link: "Learn More",
                        modalContent: {
                            title: "Machine Learning Solutions",
                            description: "We develop custom, powerful machine learning models to address your most complex challenges and deliver groundbreaking insights.",
                            subtitle: "The Power of Predictive Intelligence",
                            text: "Our machine learning solutions enable businesses to leverage their data to discover hidden patterns, optimize operations, and predict future outcomes. We develop advanced algorithms specifically designed to meet your unique needs, whether you're looking to enhance customer experiences, improve supply chain efficiency, or develop innovative products.",
                            featuresTitle: "Our Solutions Include",
                            features: [
                                "Advanced deep learning models for complex tasks",
                                "Intelligent recommendation systems to enhance sales and engagement",
                                "Predictive maintenance analysis to reduce downtime",
                                "Customer segmentation and churn analysis",
                                "Fraud detection and advanced security systems"
                            ],
                            ctaButton: "Consult an Expert Now",
                            secondaryButton: "Explore Use Cases"
                        }
                    },
                    {
                        id: "conversational-ai",
                        icon: "fas fa-comments",
                        title: "Conversational AI",
                        description: "Intelligent chatbots and virtual assistants that transform customer experiences and streamline support operations.",
                        link: "Learn More",
                        modalContent: {
                            title: "Conversational AI",
                            description: "Elevate customer experience with intelligent chatbots and virtual assistants designed to deliver natural and efficient interactions.",
                            subtitle: "Natural and Helpful Conversational Interactions",
                            text: "Our conversational AI solutions utilize the latest natural language processing and deep learning technologies to create natural and helpful conversational interactions with customers. We design chatbots and virtual assistants that can understand conversation context, remember important details, and answer complex inquiries with accuracy and politeness.",
                            featuresTitle: "Conversational AI Benefits",
                            features: [
                                "Omnichannel intelligent chatbots operating across your website, messaging apps, and social media",
                                "Custom virtual assistants trained on your products, services, and business processes",
                                "Seamless integration with your existing CRM and customer service tools",
                                "Advanced analytics to track performance and continuously improve interactions",
                                "Support for Arabic, English, and multiple other languages"
                            ],
                            ctaButton: "Get a Demonstration",
                            secondaryButton: "View Examples"
                        }
                    },
                    {
                        id: "predictive-analytics",
                        icon: "fas fa-chart-line",
                        title: "Predictive Analytics",
                        description: "Transform your data into actionable insights and accurate forecasts to drive informed business decisions.",
                        link: "Learn More",
                        modalContent: {
                            title: "Predictive Analytics",
                            description: "Harness the power of data to anticipate future trends and make smarter decisions for your business.",
                            subtitle: "Data-Driven Future Insights",
                            text: "Our predictive analytics services allow businesses to transform vast amounts of data into actionable, strategic insights. By applying advanced statistical techniques and machine learning algorithms, we help clients forecast future trends, identify potential opportunities, and anticipate challenges before they occur.",
                            featuresTitle: "Our Analytics Capabilities",
                            features: [
                                "Customer behavior prediction and sales trend forecasting",
                                "Inventory analysis and supply chain optimization",
                                "Financial risk and fraud assessment",
                                "Operational needs forecasting and resource planning",
                                "Interactive dashboards and custom reporting"
                            ],
                            ctaButton: "Get Free Analysis",
                            secondaryButton: "Watch Demos"
                        }
                    },
                    {
                        id: "computer-vision",
                        icon: "fas fa-eye",
                        title: "Computer Vision",
                        description: "Advanced image recognition and visual data processing solutions for automation and quality control.",
                        link: "Learn More",
                        modalContent: {
                            title: "Computer Vision",
                            description: "Give your systems the ability to see and interpret the visual world with advanced computer vision solutions.",
                            subtitle: "Enabling Machines to See",
                            text: "Our computer vision solutions offer cutting-edge technologies that enable systems to analyze and understand visual content with human-like or superior accuracy. We develop custom systems that can recognize objects, analyze scenes, detect patterns, and track movements, opening new possibilities for automation and analysis across various industries.",
                            featuresTitle: "Computer Vision Applications",
                            features: [
                                "Automated quality inspection and defect detection",
                                "Product tracking and inventory monitoring",
                                "In-store customer behavior analysis",
                                "Intelligent security and surveillance systems",
                                "Medical diagnostic assistance and image analysis"
                            ],
                            ctaButton: "Explore Possibilities",
                            secondaryButton: "Request a Demo"
                        }
                    },
                    {
                        id: "process-automation",
                        icon: "fas fa-cogs",
                        title: "Process Automation",
                        description: "Intelligent automation solutions that optimize workflows, reduce costs, and free up human resources.",
                        link: "Learn More",
                        modalContent: {
                            title: "Process Automation",
                            description: "Improve efficiency and reduce costs by automating repetitive and complex business processes.",
                            subtitle: "Freeing Human Potential",
                            text: "Our process automation solutions enable businesses to streamline repetitive and time-consuming processes, allowing employees to focus on high-value activities. By combining Robotic Process Automation (RPA) with artificial intelligence, we deliver intelligent automation solutions that can handle both simple and complex tasks.",
                            featuresTitle: "Process Automation Benefits",
                            features: [
                                "Reduction in human errors and increased accuracy",
                                "Improved processing times and increased productivity",
                                "Lower operational costs",
                                "Enhanced customer and employee experience",
                                "Rapid scalability to meet changing business needs"
                            ],
                            ctaButton: "Start Your Automation Journey",
                            secondaryButton: "Free Process Analysis"
                        }
                    }
                ],
                
              // Features Section (continued from previous artifact)
              whyChooseUs: "Why Choose Al Durah",
                featuresData: [
                    {
                        icon: "1",
                        title: "Cutting-Edge Technology",
                        description: "Our solutions leverage the latest advancements in artificial intelligence, machine learning, and deep learning to deliver superior results and stay ahead of the competition. We continuously invest in research and development to ensure our clients receive the most advanced and effective technology solutions in the market."
                    },
                    {
                        icon: "2",
                        title: "Industry Expertise",
                        description: "With deep domain knowledge across multiple industries, we develop AI solutions that address specific challenges and maximize return on investment. Our team of experts has years of experience applying AI in diverse sectors such as finance, healthcare, manufacturing, retail, and logistics."
                    },
                    {
                        icon: "3",
                        title: "Seamless Integration",
                        description: "Our AI systems integrate smoothly with your existing infrastructure and workflows, minimizing disruption and accelerating time to value. We take a phased approach that allows you to incorporate new AI technologies without disrupting day-to-day operations, ensuring a smooth and effective transition."
                    },
                    {
                        icon: "4",
                        title: "Scalable Solutions",
                        description: "Our flexible architecture allows your AI capabilities to grow alongside your business, from initial proof of concept to enterprise-wide deployment. Our platform is designed to adapt to changing and growing needs, enabling you to start small and scale gradually as your business evolves."
                    }
                ],
                
                // About Section (Impact/Stats)
                ourImpact: "Our Impact",
                statsData: [
                    {
                        number: "200+",
                        label: "Global Clients"
                    },
                    {
                        number: "92%",
                        label: "Success Rate"
                    },
                    {
                        number: "$50M+",
                        label: "Client Savings"
                    },
                    {
                        number: "45+",
                        label: "Industry Awards"
                    }
                ],
                
                // Testimonials Section
                clientTestimonials: "What Our Clients Say",
                testimonialContent: "Al Durah transformed our customer service operations with their conversational AI solution. We've seen a 40% reduction in response times and unprecedented customer satisfaction scores. Their system's ability to learn and adapt to our changing needs has been remarkable.",
                testimonialAuthor: "Sarah Johnson",
                testimonialPosition: "CTO, Global Retail Inc.",
                
                // Contact Section
                contactUs: "Get In Touch",
                contactData: [
                    {
                        icon: "fas fa-map-marker-alt",
                        title: "Address",
                        details: "123 Innovation Drive, Tech District, San Francisco, CA 94107, USA"
                    },
                    {
                        icon: "fas fa-phone-alt",
                        title: "Phone",
                        details: "+1 (555) 123-4567"
                    },
                    {
                        icon: "fas fa-envelope",
                        title: "Email",
                        details: "contact@aldurah.tech"
                    }
                ],
                fullName: "Full Name",
                enterName: "Enter your name",
                emailAddress: "Email Address",
                enterEmail: "Enter your email",
                company: "Company",
                enterCompany: "Enter your company name",
                message: "Message",
                enterMessage: "Tell us about your project or inquiry",
                sendMessage: "Send Message",
                
                // Footer
                copyright: "© 2025 Al Durah. All rights reserved."
            }
        };

        // Current language state
        let currentLang = 'ar';

        // Function to load content based on language
        function loadContent(lang) {
            // Update HTML direction attribute
            document.getElementById('main-html').setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
            
            // Update language toggle button
            document.getElementById('language-toggle').innerText = lang === 'ar' ? 'EN' : 'عربي';
            
            // Update logo text
            document.querySelector('.logo-text').innerText = content[lang].logo;
            document.querySelector('.footer-logo').innerText = content[lang].logo;
            
            // Update navigation links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.innerText = content[lang][link.dataset.key];
            });
            
            document.querySelectorAll('.mobile-nav-link').forEach(link => {
                link.innerText = content[lang][link.dataset.key];
            });
            
            // Update buttons
            document.querySelectorAll('.cta-btn').forEach(btn => {
                if (btn.dataset.key) {
                    btn.innerText = content[lang][btn.dataset.key];
                }
            });
            
            // Update hero section
            document.querySelector('.hero h1').innerText = content[lang].heroTitle;
            document.querySelector('.hero p').innerText = content[lang].heroDescription;
            document.querySelectorAll('.hero-btns .cta-btn')[0].innerText = content[lang].exploreSolutions;
            document.querySelector('.hero-btns .secondary-btn').innerText = content[lang].scheduleDemo;
            document.querySelector('.scroll-down-text').innerText = content[lang].scrollDown;
            
            // Update section titles
            document.querySelectorAll('[data-key]').forEach(element => {
                if (element.dataset.key && content[lang][element.dataset.key]) {
                    if (element.dataset.placeholder === "true") {
                        element.placeholder = content[lang][element.dataset.key];
                    } else {
                        element.innerText = content[lang][element.dataset.key];
                    }
                }
            });
            
            // Generate services
            const servicesGrid = document.querySelector('.services-grid');
            servicesGrid.innerHTML = '';
            
            content[lang].servicesData.forEach((service, index) => {
                const card = document.createElement('div');
                card.className = 'service-card';
                card.dataset.serviceId = service.id;
                card.innerHTML = `
                    <div class="service-icon"><i class="${service.icon}"></i></div>
                    <h3>${service.title}</h3>
                    <p>${service.description}</p>
                    <a href="#" class="service-link">${service.link}</a>
                `;
                servicesGrid.appendChild(card);
                
                // Add delay for animation
                setTimeout(() => {
                    card.style.opacity = 1;
                    card.style.transform = 'scale(1)';
                }, 100 * index);
            });
            
            // Generate features
            const featuresContainer = document.querySelector('.features-container');
            featuresContainer.innerHTML = '';
            
            content[lang].featuresData.forEach((feature, index) => {
                const featureItem = document.createElement('div');
                featureItem.className = 'feature-item';
                featureItem.innerHTML = `
                    <div class="feature-icon">${feature.icon}</div>
                    <div class="feature-text">
                        <h3>${feature.title}</h3>
                        <p>${feature.description}</p>
                    </div>
                `;
                featuresContainer.appendChild(featureItem);
                
                // Add delay for animation
                setTimeout(() => {
                    featureItem.style.opacity = 1;
                    featureItem.style.transform = 'translateX(0)';
                }, 200 * index);
            });
            
            // Generate stats
            const statsContainer = document.querySelector('.stats');
            statsContainer.innerHTML = '';
            
            content[lang].statsData.forEach((stat, index) => {
                const statItem = document.createElement('div');
                statItem.className = 'stat-item';
                statItem.innerHTML = `
                    <div class="stat-number">${stat.number}</div>
                    <div class="stat-label">${stat.label}</div>
                `;
                statsContainer.appendChild(statItem);
                
                // Add delay for animation
                setTimeout(() => {
                    statItem.style.opacity = 1;
                    statItem.style.transform = 'translateY(0)';
                }, 150 * index);
            });
            
            // Generate contact info
            const contactInfo = document.querySelector('.contact-info');
            contactInfo.innerHTML = '';
            
            content[lang].contactData.forEach(item => {
                const contactItem = document.createElement('div');
                contactItem.className = 'contact-item';
                contactItem.innerHTML = `
                    <div class="contact-details">
                        <h3>${item.title}</h3>
                        <p>${item.details}</p>
                    </div>
                    <div class="contact-icon"><i class="${item.icon}"></i></div>
                `;
                contactInfo.appendChild(contactItem);
            });
            
            // Add animation
            setTimeout(() => {
                contactInfo.style.opacity = 1;
                contactInfo.style.transform = 'translateX(0)';
                
                document.querySelector('.contact-form').style.opacity = 1;
                document.querySelector('.contact-form').style.transform = 'translateX(0)';
            }, 300);
            
            // Update footer links
            const footerLinks = document.querySelector('.footer-links');
            footerLinks.innerHTML = '';
            
            ['contact', 'testimonials', 'about', 'features', 'services'].forEach(key => {
                const link = document.createElement('a');
                link.href = `#${key}`;
                link.innerText = content[lang][key];
                footerLinks.appendChild(link);
            });
            
            // Update copyright
            document.querySelector('.copyright').innerText = content[lang].copyright;
        }

        // Function to handle service card clicks and show modals
        function setupServiceCardListeners() {
            document.querySelectorAll('.service-card').forEach(card => {
                card.addEventListener('click', function() {
                    const serviceId = this.dataset.serviceId;
                    const serviceData = content[currentLang].servicesData.find(s => s.id === serviceId);
                    
                    if (serviceData && serviceData.modalContent) {
                        const modal = document.querySelector('.service-modal');
                        const modalContent = document.querySelector('.modal-content');
                        
                        // Populate modal content
                        document.getElementById('modal-title').innerText = serviceData.modalContent.title;
                        document.getElementById('modal-description').innerText = serviceData.modalContent.description;
                        document.getElementById('modal-subtitle').innerText = serviceData.modalContent.subtitle;
                        document.getElementById('modal-text').innerText = serviceData.modalContent.text;
                        document.getElementById('modal-features-title').innerText = serviceData.modalContent.featuresTitle;
                        
                        // Populate features list
                        const featuresList = document.getElementById('modal-features-list');
                        featuresList.innerHTML = '';
                        serviceData.modalContent.features.forEach(feature => {
                            const li = document.createElement('li');
                            li.innerText = feature;
                            featuresList.appendChild(li);
                        });
                        
                        // Set buttons
                        document.getElementById('modal-cta').innerText = serviceData.modalContent.ctaButton;
                        document.getElementById('modal-secondary').innerText = serviceData.modalContent.secondaryButton;
                        
                        // Show modal
                        modal.classList.add('active');
                        setTimeout(() => {
                            modalContent.classList.add('active');
                        }, 100);
                    }
                });
            });
            
            // Setup modal close
            document.querySelector('.modal-close').addEventListener('click', function() {
                const modalContent = document.querySelector('.modal-content');
                const modal = document.querySelector('.service-modal');
                
                modalContent.classList.remove('active');
                setTimeout(() => {
                    modal.classList.remove('active');
                }, 500);
            });
        }

        // Function to toggle language
        function toggleLanguage() {
            currentLang = currentLang === 'ar' ? 'en' : 'ar';
            loadContent(currentLang);
            setupServiceCardListeners();
        }

        // Function to load content from external files (demonstration)
        function loadExternalContent() {
            // This is a demonstration of how you would load content from external files
            // In a real implementation, you would use fetch to get JSON or text files
            console.log("In a real implementation, this function would load content from:");
            console.log("- /content/ar.json for Arabic content");
            console.log("- /content/en.json for English content");
            
            // Example implementation (would be used in actual production):
            /*
            fetch(`/content/${currentLang}.json`)
                .then(response => response.json())
                .then(data => {
                    // Update content object with fetched data
                    content[currentLang] = data;
                    // Reload content with new data
                    loadContent(currentLang);
                    setupServiceCardListeners();
                })
                .catch(error => {
                    console.error("Error loading content:", error);
                });
            */
        }

        // Add event listeners
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize content
            loadContent(currentLang);
            
            // Setup language toggle
            document.getElementById('language-toggle').addEventListener('click', toggleLanguage);
            
            // Setup service card listeners
            setupServiceCardListeners();
            
            // Mobile menu toggle
            document.querySelector('.mobile-menu-btn').addEventListener('click', () => {
                document.querySelector('.mobile-menu').classList.add('open');
            });
            
            document.querySelector('.mobile-menu-close').addEventListener('click', () => {
                document.querySelector('.mobile-menu').classList.remove('open');
            });
            
            document.querySelectorAll('.mobile-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    document.querySelector('.mobile-menu').classList.remove('open');
                });
            });
            
            // Background Music Setup
            const backgroundMusic = new Howl({
                src: ['https://assets.codepen.io/39255/ai-ambient.mp3'], // Replace with your music URL
                loop: true,
                volume: 0.3,
                autoplay: false
            });
            
            const musicToggle = document.getElementById('music-toggle');
            let musicPlaying = false;
            
            musicToggle.addEventListener('click', () => {
                if (musicPlaying) {
                    backgroundMusic.pause();
                    musicToggle.innerHTML = '<i class="fas fa-volume-mute"></i>';
                } else {
                    backgroundMusic.play();
                    musicToggle.innerHTML = '<i class="fas fa-volume-up"></i>';
                }
                musicPlaying = !musicPlaying;
            });
            
            // Hero section animations
            gsap.to('.hero-content', {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power3.out'
            });
            
            gsap.to('.ai-float', {
                opacity: 1,
                x: 0,
                duration: 1,
                delay: 0.3,
                ease: 'power3.out'
            });
            
            // Section title animations
            gsap.utils.toArray('.section-title, .section-subtitle').forEach(element => {
                gsap.to(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: 'top 80%',
                        toggleActions: 'play none none none'
                    },
                    opacity: 1,
                    y: 0,
                    duration: 0.8,
                    ease: 'power3.out'
                });
            });
            
            // Testimonial animation
            gsap.to('.testimonial-slider', {
                scrollTrigger: {
                    trigger: '.testimonial-slider',
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                },
                opacity: 1,
                scale: 1,
                duration: 0.8,
                ease: 'power3.out'
            });
            
            // Three.js Particle Animation
            const canvas = document.getElementById('canvas-container');
            
            // Initialize Three.js scene
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            canvas.appendChild(renderer.domElement);
            
            // Create particles
            const particlesGeometry = new THREE.BufferGeometry();
            const particlesCount = 3000;
            
            const posArray = new Float32Array(particlesCount * 3);
            const scales = new Float32Array(particlesCount);
            const colors = new Float32Array(particlesCount * 3);
            
            for (let i = 0; i < particlesCount * 3; i += 3) {
                posArray[i] = (Math.random() - 0.5) * 10;
                posArray[i + 1] = (Math.random() - 0.5) * 10;
                posArray[i + 2] = (Math.random() - 0.5) * 10;
                
                // Add some color variation (purple to blue gradient)
                colors[i] = 0.6 + Math.random() * 0.2;     // R
                colors[i + 1] = 0.3 + Math.random() * 0.2; // G
                colors[i + 2] = 1.0;                       // B
            }
            
            for (let i = 0; i < particlesCount; i++) {
                scales[i] = Math.random();
            }
            
            particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
            particlesGeometry.setAttribute('scale', new THREE.BufferAttribute(scales, 1));
            particlesGeometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));
            
            // Particle material
            const particlesMaterial = new THREE.PointsMaterial({
                size: 0.02,
                sizeAttenuation: true,
                vertexColors: true,
                transparent: true,
                opacity: 0.8
            });
            
            // Create particles mesh
            const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
            scene.add(particlesMesh);
            
            // Position camera
            camera.position.z = 3;
            
            // Mouse movement effect
            let mouseX = 0;
            let mouseY = 0;
            
            document.addEventListener('mousemove', (event) => {
                mouseX = (event.clientX / window.innerWidth) * 2 - 1;
                mouseY = -(event.clientY / window.innerHeight) * 2 + 1;
            });
            
            // Animation loop
            const animate = () => {
                requestAnimationFrame(animate);
                
                // Rotate particles
                particlesMesh.rotation.x += 0.0005;
                particlesMesh.rotation.y += 0.0005;
                
                // Mouse interaction
                particlesMesh.rotation.x += mouseY * 0.0005;
                particlesMesh.rotation.y += mouseX * 0.0005;
                
                renderer.render(scene, camera);
            };
            
            animate();
            
            // Add Lottie animation for AI effect
            const lottieContainer = document.getElementById('lottie-container');
            const lottieAnim = lottie.loadAnimation({
                container: lottieContainer,
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: 'https://assets9.lottiefiles.com/packages/lf20_1cazwtnc.json' // AI brain animation
            });
            
            // Resize handler
            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            });
            
            // Navbar scroll effect
            const navbar = document.querySelector('.nav-container');
            const progressBar = document.querySelector('.progress-bar');
            
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    navbar.classList.add('nav-scrolled');
                } else {
                    navbar.classList.remove('nav-scrolled');
                }
                
                // Update progress bar
                const scrollPosition = window.scrollY;
                const totalHeight = document.body.scrollHeight - window.innerHeight;
                const progress = (scrollPosition / totalHeight) * 100;
                progressBar.style.height = `${progress}%`;
            });
            
            // Scroll down button
            const scrollDownBtn = document.querySelector('.scroll-down');
            
            if (scrollDownBtn) {
                scrollDownBtn.addEventListener('click', () => {
                    const servicesSection = document.getElementById('services');
                    window.scrollTo({
                        top: servicesSection.offsetTop - 80,
                        behavior: 'smooth'
                    });
                });
            }
            
            // Smooth scrolling for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
</body>
</html>
