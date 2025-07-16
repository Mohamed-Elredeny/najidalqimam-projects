<?php
// Enhanced Arabic 3D Chat Avatar with ChatGPT + Voice Response + File Upload
// =========================================================================

session_start();

// Load environment variables
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        return;
    }
    
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Skip comments
        }
        
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            
            if (!array_key_exists($name, $_ENV)) {
                $_ENV[$name] = $value;
            }
        }
    }
}

// Load .env file
loadEnv(__DIR__ . '/.env');

// Handle file uploads
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    header('Content-Type: application/json');
    
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $file = $_FILES['file'];
    $fileName = time() . '_' . $file['name'];
    $filePath = $uploadDir . $fileName;
    
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        // Process file content based on type
        $fileContent = '';
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        switch ($fileType) {
            case 'txt':
                $fileContent = file_get_contents($filePath);
                break;
            case 'pdf':
                // You can add PDF processing here using libraries like PDFParser
                $fileContent = "PDF file uploaded: " . $fileName;
                break;
            case 'docx':
                // You can add DOCX processing here
                $fileContent = "DOCX file uploaded: " . $fileName;
                break;
            default:
                $fileContent = "File uploaded: " . $fileName;
        }
        
        // Store file info in session for context
        if (!isset($_SESSION['uploaded_files'])) {
            $_SESSION['uploaded_files'] = [];
        }
        $_SESSION['uploaded_files'][] = [
            'name' => $file['name'],
            'path' => $filePath,
            'content' => $fileContent,
            'type' => $fileType
        ];
        
        echo json_encode(['success' => true, 'message' => 'تم رفع الملف بنجاح', 'filename' => $file['name']]);
    } else {
        echo json_encode(['error' => 'فشل في رفع الملف']);
    }
    exit;
}

// Handle ChatGPT requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'chat') {
    header('Content-Type: application/json');
    
    // 🔑 GET OPENAI API KEY FROM ENVIRONMENT VARIABLE
    $OPENAI_API_KEY = $_ENV['OPENAI_API_KEY'] ?? '';
    $userMessage = $_POST['message'] ?? '';
    
    if (empty($userMessage)) {
        echo json_encode(['error' => 'No message provided']);
        exit;
    }
    
    // Load company training data
    $companyContext = '';
    if (file_exists('company_data.txt')) {
        $companyContext = file_get_contents('company_data.txt');
    }
    
    // Add uploaded files context
    $filesContext = '';
    if (isset($_SESSION['uploaded_files']) && !empty($_SESSION['uploaded_files'])) {
        $filesContext = "\n\nالملفات المرفوعة:\n";
        foreach ($_SESSION['uploaded_files'] as $file) {
            $filesContext .= "- " . $file['name'] . ": " . substr($file['content'], 0, 500) . "\n";
        }
    }
    
    // System prompt with company data
    $systemPrompt = 'أنت مساعد ذكي يتحدث العربية بطلاقة. كن مفيداً ومهذباً وودوداً. أجب باللغة العربية دائماً.';
    
    if (!empty($companyContext)) {
        $systemPrompt .= "\n\nلديك معلومات عن الشركة التالية:\n" . $companyContext;
    }
    
    if (!empty($filesContext)) {
        $systemPrompt .= $filesContext;
    }
    
    // ChatGPT API Request
    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            [
                'role' => 'system',
                'content' => $systemPrompt
            ],
            [
                'role' => 'user',
                'content' => $userMessage
            ]
        ],
        'max_tokens' => 1000,
        'temperature' => 0.7
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $OPENAI_API_KEY
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $result = json_decode($response, true);
        if (isset($result['choices'][0]['message']['content'])) {
            echo json_encode([
                'success' => true,
                'response' => $result['choices'][0]['message']['content']
            ]);
        } else {
            echo json_encode(['error' => 'Invalid response from ChatGPT']);
        }
    } else {
        echo json_encode(['error' => 'ChatGPT API error: ' . $response]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
      

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-link {
            text-decoration: none;
            color: #333;
            padding: 8px 16px;
            border-radius: 20px;
            transition: all 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            background: #667eea;
            color: white;
        }

        /* 3D Avatar Container */
        .avatar-3d-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            transition: all 0.3s ease;
        }

        .avatar-3d {
            width: 80px;
            height: 80px;
            background: linear-gradient(145deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 
                0 15px 35px rgba(102, 126, 234, 0.3),
                inset 0 2px 10px rgba(255, 255, 255, 0.2),
                inset 0 -2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
            animation: float 3s ease-in-out infinite;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotateY(0deg); }
            50% { transform: translateY(-10px) rotateY(5deg); }
        }

        .avatar-3d:hover {
            transform: scale(1.1) rotateY(15deg);
            box-shadow: 
                0 20px 50px rgba(102, 126, 234, 0.4),
                inset 0 3px 15px rgba(255, 255, 255, 0.3);
            animation-play-state: paused;
        }

        .avatar-3d.speaking {
            animation: speak 0.5s infinite alternate;
        }

        @keyframes speak {
            0% { transform: scale(1) rotateY(0deg); }
            100% { transform: scale(1.05) rotateY(3deg); }
        }

        /* 3D Avatar Face */
        .avatar-face-3d {
            width: 50px;
            height: 50px;
            background: radial-gradient(circle at 30% 30%, #ffffff, #f0f0f0);
            border-radius: 50%;
            position: relative;
            transform: translateZ(5px);
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .avatar-eyes-3d {
            position: absolute;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 12px;
        }

        .eye-3d {
            width: 6px;
            height: 6px;
            background: #2c3e50;
            border-radius: 50%;
            position: relative;
            animation: blink3d 4s infinite;
        }

        .eye-3d:before {
            content: '';
            position: absolute;
            top: -1px;
            left: 1px;
            width: 2px;
            height: 2px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
        }

        @keyframes blink3d {
            0%, 90%, 100% { transform: scaleY(1); }
            95% { transform: scaleY(0.1); }
        }

        .avatar-mouth-3d {
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
            width: 16px;
            height: 8px;
            border: 2px solid #e74c3c;
            border-top: none;
            border-radius: 0 0 16px 16px;
            background: rgba(231, 76, 60, 0.1);
        }

        .talking .avatar-mouth-3d {
            animation: talk 0.3s infinite alternate;
        }

        @keyframes talk {
            0% { transform: translateX(-50%) scaleY(1); }
            100% { transform: translateX(-50%) scaleY(1.5); }
        }

        /* Chat Window */
        .chat-window {
            position: fixed;
            bottom: 130px;
            right: 30px;
            width: 450px;
            height: 700px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);
            display: none;
            z-index: 9998;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .chat-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .chat-avatar-small {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .chat-title {
            font-weight: bold;
            font-size: 18px;
            flex-grow: 1;
        }

        .chat-status {
            font-size: 12px;
            opacity: 0.9;
            margin-top: 2px;
        }

        .header-controls {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .volume-btn, .close-chat {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.3s;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .volume-btn:hover, .close-chat:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .close-chat:hover {
            transform: rotate(90deg);
        }

        /* Chat Messages Area */
        .chat-messages {
            height: 450px;
            overflow-y: auto;
            padding: 20px;
            background: linear-gradient(to bottom, #fafbfc, #f8f9fa);
        }

        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .message {
            margin-bottom: 20px;
            display: flex;
            animation: messageSlide 0.4s ease-out;
        }

        @keyframes messageSlide {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .message.user {
            justify-content: flex-start;
        }

        .message.ai {
            justify-content: flex-end;
        }

        .message-content {
            max-width: 75%;
            padding: 15px 20px;
            border-radius: 20px;
            font-size: 14px;
            line-height: 1.5;
            position: relative;
            word-wrap: break-word;
        }

        .message.user .message-content {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-bottom-right-radius: 5px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .message.ai .message-content {
            background: white;
            color: #333;
            border: 1px solid #e1e8ed;
            border-bottom-left-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .message-time {
            font-size: 11px;
            opacity: 0.7;
            margin-top: 5px;
        }

        /* File Upload Area */
        .file-upload-area {
            padding: 15px 20px;
            border-top: 1px solid #e1e8ed;
            background: #f8f9fa;
        }

        .file-drop-zone {
            border: 2px dashed #667eea;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s;
            background: white;
            margin-bottom: 10px;
        }

        .file-drop-zone:hover {
            border-color: #764ba2;
            background: rgba(102, 126, 234, 0.05);
        }

        .file-drop-zone.dragover {
            border-color: #764ba2;
            background: rgba(102, 126, 234, 0.1);
        }

        .file-input {
            display: none;
        }

        .file-upload-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
        }

        .file-upload-btn:hover {
            background: #764ba2;
        }

        .uploaded-files {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .file-tag {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .file-tag .remove-file {
            cursor: pointer;
            color: #e74c3c;
        }

        /* Chat Input Area */
        .chat-input-area {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #e1e8ed;
            padding: 20px;
        }

        .input-container {
            display: flex;
            align-items: flex-end;
            background: #f8f9fa;
            border-radius: 25px;
            padding: 10px 15px;
            border: 2px solid #e1e8ed;
            transition: border-color 0.3s;
        }

        .input-container:focus-within {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .chat-input {
            flex-grow: 1;
            border: none;
            background: none;
            padding: 10px 12px;
            font-size: 14px;
            outline: none;
            resize: none;
            font-family: inherit;
            direction: rtl;
            max-height: 80px;
            min-height: 20px;
        }

        .chat-input::placeholder {
            color: #999;
        }

        .voice-btn, .send-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 50%;
            transition: all 0.3s;
            margin: 0 3px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .voice-btn {
            color: #667eea;
            font-size: 18px;
        }

        .voice-btn:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: scale(1.1);
        }

        .voice-btn.recording {
            color: #e74c3c;
            background: rgba(231, 76, 60, 0.1);
            animation: recordPulse 1s infinite;
        }

        @keyframes recordPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .send-btn {
            color: #667eea;
            font-size: 16px;
        }

        .send-btn:hover:not(:disabled) {
            background: rgba(102, 126, 234, 0.1);
            transform: scale(1.1);
        }

        .send-btn:disabled {
            color: #ccc;
            cursor: not-allowed;
        }

        /* Typing Indicator */
        .typing-indicator {
            display: none;
            padding: 15px 20px;
            text-align: center;
            color: #666;
            font-size: 13px;
            background: rgba(102, 126, 234, 0.05);
            margin: 0 20px;
            border-radius: 15px;
        }

        .typing-dots {
            display: inline-block;
            margin-right: 5px;
        }

        .typing-dots span {
            opacity: 0.4;
            animation: typing 1.4s infinite;
        }

        .typing-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dots span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {
            0%, 60%, 100% { opacity: 0.4; }
            30% { opacity: 1; }
        }

        /* Status Indicators */
        .online-indicator {
            position: absolute;
            bottom: 8px;
            right: 8px;
            width: 20px;
            height: 20px;
            background: #4CAF50;
            border: 3px solid white;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(76, 175, 80, 0); }
            100% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0); }
        }

        /* Loading State */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .error-message {
            color: #e74c3c;
            background: rgba(231, 76, 60, 0.1);
            padding: 10px 15px;
            border-radius: 10px;
            margin: 10px 20px;
            font-size: 12px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            padding: 100px 50px 50px;
            text-align: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .chat-window {
                width: calc(100vw - 20px);
                right: 10px;
                height: calc(100vh - 120px);
                bottom: 110px;
            }
            
            .avatar-3d-container {
                bottom: 20px;
                right: 20px;
            }

            .avatar-3d {
                width: 65px;
                height: 65px;
            }

            .avatar-face-3d {
                width: 40px;
                height: 40px;
            }

            .main-content {
                padding: 80px 20px 20px;
            }

            .nav-links {
                display: none;
            }
        }

        /* Animations */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        @keyframes slideDown {
            from {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            to {
                opacity: 0;
                transform: translateY(30px) scale(0.9);
            }
        }
    </style>
</head>
<body>
    <!-- Header Navigation -->
 


    <!-- 3D Avatar -->
    <div class="avatar-3d-container" id="avatarContainer">
        <div class="avatar-3d" onclick="toggleChat()" id="avatar3d">
            <div class="avatar-face-3d">
                <div class="avatar-eyes-3d">
                    <div class="eye-3d"></div>
                    <div class="eye-3d"></div>
                </div>
                <div class="avatar-mouth-3d"></div>
            </div>
        </div>
        <div class="online-indicator"></div>
    </div>

    <!-- Chat Window -->
    <div class="chat-window" id="chatWindow">
        <div class="chat-header">
            <div class="chat-avatar-small">
                <div style="width: 25px; height: 25px; background: white; border-radius: 50%; opacity: 0.9;"></div>
            </div>
            <div>
                <div class="chat-title">المساعد الذكي</div>
                <div class="chat-status" id="chatStatus">متصل الآن • مدعوم بـ ChatGPT</div>
            </div>
            <div class="header-controls">
                <button class="volume-btn" id="volumeBtn" onclick="toggleSound()" title="تشغيل/إيقاف الصوت">
                    🔊
                </button>
                <button class="close-chat" onclick="toggleChat()">×</button>
            </div>
        </div>

        <div class="chat-messages" id="chatMessages">
            <div class="message ai">
                <div class="message-content">
                    مرحباً! أنا مساعدك الذكي ثلاثي الأبعاد المدعوم بتقنية ChatGPT 🤖<br><br>
                    يمكنني مساعدتك في أي موضوع تريده. يمكنك:<br>
                    • الكتابة معي مباشرة ✍️<br>
                    • استخدام الصوت للمحادثة 🎤<br>
                    • رفع الملفات لتحليلها 📁<br>
                    • طرح أي سؤال تريده 💭<br><br>
                    كيف يمكنني مساعدتك اليوم؟
                </div>
            </div>
        </div>

        <div class="typing-indicator" id="typingIndicator">
            المساعد يفكر
            <span class="typing-dots">
                <span>.</span><span>.</span><span>.</span>
            </span>
        </div>

        <!-- File Upload Area -->
        <div class="file-upload-area">
            <div class="file-drop-zone" id="fileDropZone" onclick="document.getElementById('fileInput').click()">
                <div style="font-size: 24px; margin-bottom: 8px;">📁</div>
                <div style="font-size: 12px; color: #666;">اسحب الملفات هنا أو اضغط للاختيار</div>
                <button class="file-upload-btn">اختر ملف</button>
            </div>
            <input type="file" id="fileInput" class="file-input" multiple accept=".txt,.pdf,.docx,.doc,.xlsx,.csv,.jpg,.png">
            <div class="uploaded-files" id="uploadedFiles"></div>
        </div>

        <div class="chat-input-area">
            <div class="input-container">
                <button class="voice-btn" id="voiceBtn" onclick="toggleVoice()" title="اضغط للتحدث">
                    🎤
                </button>
                <textarea 
                    class="chat-input" 
                    id="chatInput" 
                    placeholder="اكتب رسالتك هنا..."
                    rows="1"
                    onkeydown="handleKeyDown(event)"
                    oninput="autoResize(this)"
                ></textarea>
                <button class="send-btn" id="sendBtn" onclick="sendMessage()" title="إرسال الرسالة">
                    ➤
                </button>
            </div>
        </div>
    </div>

    <script>
        let chatOpen = false;
        let isRecording = false;
        let recognition = null;
        let isLoading = false;
        let soundEnabled = true;
        let speechSynthesis = window.speechSynthesis;
        let uploadedFiles = [];

        // Initialize Speech Recognition
        if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            recognition = new SpeechRecognition();
            recognition.lang = 'ar-SA';
            recognition.continuous = false;
            recognition.interimResults = false;

            recognition.onresult = function(event) {
                const speechResult = event.results[0][0].transcript;
                document.getElementById('chatInput').value = speechResult;
                autoResize(document.getElementById('chatInput'));
                stopRecording();
            };

            recognition.onerror = function(event) {
                console.error('Speech recognition error:', event.error);
                showError('حدث خطأ في التعرف على الصوت. حاول مرة أخرى.');
                stopRecording();
            };

            recognition.onend = function() {
                stopRecording();
            };
        }

        // File Upload Functionality
        function initFileUpload() {
            const fileInput = document.getElementById('fileInput');
            const fileDropZone = document.getElementById('fileDropZone');

            fileInput.addEventListener('change', handleFileSelect);

            // Drag and drop functionality
            fileDropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                fileDropZone.classList.add('dragover');
            });

            fileDropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                fileDropZone.classList.remove('dragover');
            });

            fileDropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                fileDropZone.classList.remove('dragover');
                const files = e.dataTransfer.files;
                handleFileUpload(files);
            });
        }

        function handleFileSelect(event) {
            const files = event.target.files;
            handleFileUpload(files);
        }

        function handleFileUpload(files) {
            for (let file of files) {
                const formData = new FormData();
                formData.append('file', file);

                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        addFileTag(data.filename);
                        addMessage(`تم رفع الملف: ${data.filename} ✅`, 'system');
                    } else {
                        showError(data.error || 'فشل في رفع الملف');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('حدث خطأ في رفع الملف');
                });
            }
        }

        function addFileTag(filename) {
            const uploadedFilesContainer = document.getElementById('uploadedFiles');
            const fileTag = document.createElement('div');
            fileTag.className = 'file-tag';
            fileTag.innerHTML = `
                📄 ${filename}
                <span class="remove-file" onclick="removeFile(this, '${filename}')">×</span>
            `;
            uploadedFilesContainer.appendChild(fileTag);
            uploadedFiles.push(filename);
        }

        function removeFile(element, filename) {
            element.parentElement.remove();
            uploadedFiles = uploadedFiles.filter(f => f !== filename);
        }

        // Text-to-Speech Function
        function speakText(text) {
            if (!soundEnabled || !speechSynthesis) return;

            // Cancel any ongoing speech
            speechSynthesis.cancel();

            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'ar-SA';
            utterance.rate = 0.9;
            utterance.pitch = 1;
            utterance.volume = 0.8;

            // Visual feedback during speech
            utterance.onstart = function() {
                const avatar = document.getElementById('avatar3d');
                avatar.classList.add('speaking', 'talking');
            };

            utterance.onend = function() {
                const avatar = document.getElementById('avatar3d');
                avatar.classList.remove('speaking', 'talking');
            };

            speechSynthesis.speak(utterance);
        }

        function toggleSound() {
            soundEnabled = !soundEnabled;
            const volumeBtn = document.getElementById('volumeBtn');
            volumeBtn.textContent = soundEnabled ? '🔊' : '🔇';
            
            if (!soundEnabled) {
                speechSynthesis.cancel();
                const avatar = document.getElementById('avatar3d');
                avatar.classList.remove('speaking', 'talking');
            }
        }

        function toggleChat() {
            const chatWindow = document.getElementById('chatWindow');
            const avatar = document.getElementById('avatar3d');
            
            chatOpen = !chatOpen;
            
            if (chatOpen) {
                chatWindow.style.display = 'block';
                chatWindow.style.animation = 'slideUp 0.4s ease-out forwards';
                avatar.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    document.getElementById('chatInput').focus();
                }, 500);
            } else {
                chatWindow.style.animation = 'slideDown 0.4s ease-out forwards';
                avatar.style.transform = 'scale(1)';
                setTimeout(() => {
                    chatWindow.style.display = 'none';
                }, 400);
            }
        }

        function toggleVoice() {
            if (!recognition) {
                showError('متصفحك لا يدعم التعرف على الصوت. استخدم Chrome أو Safari.');
                return;
            }

            if (isRecording) {
                recognition.stop();
            } else {
                recognition.start();
                startRecording();
            }
        }

        function startRecording() {
            isRecording = true;
            const voiceBtn = document.getElementById('voiceBtn');
            const avatar = document.getElementById('avatar3d');
            
            voiceBtn.classList.add('recording');
            voiceBtn.innerHTML = '🔴';
            avatar.classList.add('talking');
            
            updateChatStatus('يستمع...');
        }

        function stopRecording() {
            isRecording = false;
            const voiceBtn = document.getElementById('voiceBtn');
            const avatar = document.getElementById('avatar3d');
            
            voiceBtn.classList.remove('recording');
            voiceBtn.innerHTML = '🎤';
            avatar.classList.remove('talking');
            
            updateChatStatus('متصل الآن • مدعوم بـ ChatGPT');
        }

        function handleKeyDown(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = Math.min(textarea.scrollHeight, 80) + 'px';
        }

        function sendMessage() {
            if (isLoading) return;
            
            const input = document.getElementById('chatInput');
            const message = input.value.trim();
            
            if (!message) return;

            // Add user message
            addMessage(message, 'user');
            input.value = '';
            input.style.height = 'auto';
            
            // Show loading state
            setLoadingState(true);
            showTypingIndicator();
            
            // Send to ChatGPT
            sendToChatGPT(message);
        }

        function sendToChatGPT(message) {
            const formData = new FormData();
            formData.append('action', 'chat');
            formData.append('message', message);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                hideTypingIndicator();
                setLoadingState(false);
                
                if (data.success) {
                    addMessage(data.response, 'ai');
                    
                    // Speak the response if sound is enabled
                    if (soundEnabled) {
                        speakText(data.response);
                    }
                } else {
                    showError(data.error || 'حدث خطأ في الاتصال بـ ChatGPT');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                hideTypingIndicator();
                setLoadingState(false);
                showError('حدث خطأ في الشبكة. تحقق من اتصالك بالإنترنت.');
            });
        }

        function addMessage(content, sender) {
            const messagesContainer = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('message', sender);
            
            const now = new Date();
            const timeString = now.toLocaleTimeString('ar-SA', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            
            messageDiv.innerHTML = `
                <div class="message-content">
                    ${content.replace(/\n/g, '<br>')}
                    <div class="message-time">${timeString}</div>
                </div>
            `;
            
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function showTypingIndicator() {
            document.getElementById('typingIndicator').style.display = 'block';
            const messagesContainer = document.getElementById('chatMessages');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            updateChatStatus('يكتب...');
        }

        function hideTypingIndicator() {
            document.getElementById('typingIndicator').style.display = 'none';
            updateChatStatus('متصل الآن • مدعوم بـ ChatGPT');
        }

        function setLoadingState(loading) {
            isLoading = loading;
            const sendBtn = document.getElementById('sendBtn');
            const chatInput = document.getElementById('chatInput');
            
            sendBtn.disabled = loading;
            chatInput.disabled = loading;
            
            if (loading) {
                document.getElementById('chatWindow').classList.add('loading');
            } else {
                document.getElementById('chatWindow').classList.remove('loading');
            }
        }

        function updateChatStatus(status) {
            document.getElementById('chatStatus').textContent = status;
        }

        function showError(message) {
            const messagesContainer = document.getElementById('chatMessages');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = message;
            messagesContainer.appendChild(errorDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            
            // Remove error after 5 seconds
            setTimeout(() => {
                if (errorDiv.parentNode) {
                    errorDiv.parentNode.removeChild(errorDiv);
                }
            }, 5000);
        }

        // Initialize everything
        document.addEventListener('DOMContentLoaded', function() {
            initFileUpload();
            
            document.getElementById('chatInput').addEventListener('focus', function() {
                setTimeout(() => {
                    const messagesContainer = document.getElementById('chatMessages');
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }, 300);
            });
        });
    </script>
</body>
</html>