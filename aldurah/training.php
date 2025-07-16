<?php
// AI Training Page - Company Data Management
// ========================================

session_start();

// Handle training data uploads and management
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'upload_training_data':
                if (isset($_FILES['training_file'])) {
                    $uploadDir = 'training_data/';
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    
                    $file = $_FILES['training_file'];
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
                                $fileContent = "PDF file: " . $fileName . " (content extraction would require PDF library)";
                                break;
                            case 'docx':
                                $fileContent = "DOCX file: " . $fileName . " (content extraction would require DOCX library)";
                                break;
                            default:
                                $fileContent = file_get_contents($filePath);
                        }
                        
                        // Append to company data file
                        $companyDataFile = 'company_data.txt';
                        $trainingEntry = "\n\n=== " . $file['name'] . " ===\n" . $fileContent . "\n";
                        file_put_contents($companyDataFile, $trainingEntry, FILE_APPEND);
                        
                        // Log training entry
                        $logEntry = [
                            'timestamp' => date('Y-m-d H:i:s'),
                            'filename' => $file['name'],
                            'size' => $file['size'],
                            'type' => $fileType,
                            'status' => 'processed'
                        ];
                        
                        $logFile = 'training_log.json';
                        $logs = [];
                        if (file_exists($logFile)) {
                            $logs = json_decode(file_get_contents($logFile), true) ?: [];
                        }
                        $logs[] = $logEntry;
                        file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT));
                        
                        echo json_encode([
                            'success' => true, 
                            'message' => 'تم رفع وتدريب البيانات بنجاح',
                            'filename' => $file['name']
                        ]);
                    } else {
                        echo json_encode(['error' => 'فشل في رفع الملف']);
                    }
                } else {
                    echo json_encode(['error' => 'لم يتم تحديد ملف']);
                }
                break;
                
            case 'add_text_data':
                $text = $_POST['text_data'] ?? '';
                $title = $_POST['data_title'] ?? 'بيانات نصية';
                
                if (!empty($text)) {
                    $companyDataFile = 'company_data.txt';
                    $trainingEntry = "\n\n=== " . $title . " ===\n" . $text . "\n";
                    file_put_contents($companyDataFile, $trainingEntry, FILE_APPEND);
                    
                    // Log entry
                    $logEntry = [
                        'timestamp' => date('Y-m-d H:i:s'),
                        'filename' => $title,
                        'size' => strlen($text),
                        'type' => 'text',
                        'status' => 'processed'
                    ];
                    
                    $logFile = 'training_log.json';
                    $logs = [];
                    if (file_exists($logFile)) {
                        $logs = json_decode(file_get_contents($logFile), true) ?: [];
                    }
                    $logs[] = $logEntry;
                    file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT));
                    
                    echo json_encode(['success' => true, 'message' => 'تم إضافة البيانات النصية بنجاح']);
                } else {
                    echo json_encode(['error' => 'لا يمكن إضافة نص فارغ']);
                }
                break;
                
            case 'clear_training_data':
                file_put_contents('company_data.txt', '');
                file_put_contents('training_log.json', '[]');
                echo json_encode(['success' => true, 'message' => 'تم مسح جميع بيانات التدريب']);
                break;
                
            case 'get_training_stats':
                $stats = getTrainingStats();
                echo json_encode($stats);
                break;
        }
    }
    exit;
}

function getTrainingStats() {
    $stats = [
        'total_entries' => 0,
        'total_size' => 0,
        'file_types' => [],
        'recent_uploads' => []
    ];
    
    if (file_exists('training_log.json')) {
        $logs = json_decode(file_get_contents('training_log.json'), true) ?: [];
        $stats['total_entries'] = count($logs);
        $stats['recent_uploads'] = array_slice(array_reverse($logs), 0, 5);
        
        foreach ($logs as $log) {
            $stats['total_size'] += $log['size'];
            $type = $log['type'];
            $stats['file_types'][$type] = ($stats['file_types'][$type] ?? 0) + 1;
        }
    }
    
    return $stats;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تدريب المساعد الذكي - بيانات الشركة</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Arial', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            direction: rtl;
            min-height: 100vh;
        }

        /* Header Navigation */
        .header-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 30px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

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

        /* Main Container */
        .main-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-title {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 15px;
        }

        .page-subtitle {
            font-size: 18px;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-icon {
            font-size: 2em;
            margin-left: 15px;
        }

        .card-title {
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
        }

        .card-description {
            color: #666;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        /* File Upload Area */
        .upload-area {
            border: 3px dashed #667eea;
            border-radius: 15px;
            padding: 40px 20px;
            text-align: center;
            transition: all 0.3s;
            background: #f8f9ff;
            margin-bottom: 20px;
        }

        .upload-area:hover, .upload-area.dragover {
            border-color: #764ba2;
            background: rgba(102, 126, 234, 0.1);
        }

        .upload-icon {
            font-size: 3em;
            margin-bottom: 15px;
            color: #667eea;
        }

        .upload-text {
            font-size: 16px;
            color: #333;
            margin-bottom: 15px;
        }

        .upload-hint {
            font-size: 12px;
            color: #666;
            margin-bottom: 20px;
        }

        .file-input {
            display: none;
        }

        .upload-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s;
        }

        .upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        /* Text Input Area */
        .text-input-area {
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .text-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        .text-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .text-area {
            min-height: 120px;
            resize: vertical;
        }

        .submit-btn {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
        }

        /* Stats Area */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
        }

        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }

        /* Recent Uploads */
        .recent-uploads {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-top: 20px;
        }

        .upload-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .upload-item:last-child {
            border-bottom: none;
        }

        .upload-info {
            flex-grow: 1;
        }

        .upload-name {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .upload-meta {
            font-size: 12px;
            color: #666;
        }

        .upload-status {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
            background: #e8f5e8;
            color: #4CAF50;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            justify-content: center;
        }

        .danger-btn {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }

        .danger-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(231, 76, 60, 0.3);
        }

        /* Loading States */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Notifications */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            z-index: 10000;
            animation: slideIn 0.3s ease-out;
        }

        .notification.success {
            background: linear-gradient(135deg, #4CAF50, #45a049);
        }

        .notification.error {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .cards-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .main-container {
                padding: 0 15px;
            }
            
            .nav-links {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Header Navigation -->
    <div class="header-nav">
        <div class="nav-container">
            <div class="logo">🤖 تدريب المساعد الذكي</div>
            <div class="nav-links">
                <a href="index.php" class="nav-link">المحادثة</a>
                <a href="#" class="nav-link active">تدريب النموذج</a>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">تدريب المساعد الذكي</h1>
            <p class="page-subtitle">
                قم برفع بيانات شركتك ومعلوماتها لتدريب المساعد الذكي<br>
                سيتمكن المساعد من الإجابة على أسئلة العملاء حول شركتك بدقة
            </p>
        </div>

        <!-- Training Stats -->
        <div class="stats-grid" id="statsGrid">
            <div class="stat-card">
                <div class="stat-number" id="totalEntries">0</div>
                <div class="stat-label">إجمالي الملفات</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="totalSize">0 KB</div>
                <div class="stat-label">حجم البيانات</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="fileTypes">0</div>
                <div class="stat-label">أنواع الملفات</div>
            </div>
        </div>

        <!-- Training Cards -->
        <div class="cards-grid">
            <!-- File Upload Card -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">📁</div>
                    <div class="card-title">رفع ملفات الشركة</div>
                </div>
                <div class="card-description">
                    قم برفع ملفات تحتوي على معلومات شركتك مثل:
                    الخدمات، المنتجات، السياسات، الأسعار، معلومات الاتصال
                </div>
                
                <div class="upload-area" id="fileUploadArea">
                    <div class="upload-icon">📤</div>
                    <div class="upload-text">اسحب الملفات هنا أو اضغط للاختيار</div>
                    <div class="upload-hint">يدعم: TXT, PDF, DOCX, CSV, XLSX</div>
                    <button class="upload-btn" onclick="document.getElementById('trainingFileInput').click()">
                        اختيار الملفات
                    </button>
                </div>
                
                <input type="file" id="trainingFileInput" class="file-input" multiple 
                       accept=".txt,.pdf,.docx,.doc,.xlsx,.csv,.json">
            </div>

            <!-- Text Input Card -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">✍️</div>
                    <div class="card-title">إضافة نص مباشر</div>
                </div>
                <div class="card-description">
                    أضف معلومات نصية مباشرة عن شركتك
                    مثل الوصف، الرؤية، الرسالة، أو أي معلومات مهمة
                </div>
                
                <div class="text-input-area">
                    <div class="input-group">
                        <label class="input-label">عنوان البيانات</label>
                        <input type="text" class="text-input" id="dataTitle" 
                               placeholder="مثال: معلومات عن الشركة">
                    </div>
                    
                    <div class="input-group">
                        <label class="input-label">النص</label>
                        <textarea class="text-input text-area" id="textData" 
                                  placeholder="اكتب معلومات شركتك هنا..."></textarea>
                    </div>
                    
                    <button class="submit-btn" onclick="addTextData()">
                        إضافة البيانات
                    </button>
                </div>
            </div>
        </div>

        <!-- Recent Uploads -->
        <div class="recent-uploads">
            <h3 style="margin-bottom: 20px; color: #333;">آخر الرفوعات</h3>
            <div id="recentUploads">
                <div style="text-align: center; color: #666; padding: 20px;">
                    لا توجد رفوعات حتى الآن
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="danger-btn" onclick="clearTrainingData()">
                🗑️ مسح جميع البيانات
            </button>
            <button class="upload-btn" onclick="refreshStats()">
                🔄 تحديث الإحصائيات
            </button>
        </div>
    </div>

    <script>
        let isUploading = false;

        // Initialize file upload functionality
        function initFileUpload() {
            const fileInput = document.getElementById('trainingFileInput');
            const uploadArea = document.getElementById('fileUploadArea');

            fileInput.addEventListener('change', handleFileSelect);

            // Drag and drop functionality
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
                const files = e.dataTransfer.files;
                handleFileUpload(files);
            });
        }

        function handleFileSelect(event) {
            const files = event.target.files;
            handleFileUpload(files);
        }

        function handleFileUpload(files) {
            if (isUploading) return;

            for (let file of files) {
                uploadFile(file);
            }
        }

        function uploadFile(file) {
            isUploading = true;
            
            const formData = new FormData();
            formData.append('action', 'upload_training_data');
            formData.append('training_file', file);

            // Show loading state
            showNotification('جاري رفع الملف...', 'info');

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                isUploading = false;
                
                if (data.success) {
                    showNotification(data.message, 'success');
                    refreshStats();
                } else {
                    showNotification(data.error || 'فشل في رفع الملف', 'error');
                }
            })
            .catch(error => {
                isUploading = false;
                console.error('Error:', error);
                showNotification('حدث خطأ في رفع الملف', 'error');
            });
        }

        function addTextData() {
            const title = document.getElementById('dataTitle').value.trim();
            const text = document.getElementById('textData').value.trim();

            if (!title || !text) {
                showNotification('يرجى ملء جميع الحقول', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('action', 'add_text_data');
            formData.append('data_title', title);
            formData.append('text_data', text);

            showNotification('جاري إضافة البيانات...', 'info');

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    document.getElementById('dataTitle').value = '';
                    document.getElementById('textData').value = '';
                    refreshStats();
                } else {
                    showNotification(data.error || 'فشل في إضافة البيانات', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('حدث خطأ في إضافة البيانات', 'error');
            });
        }

        function clearTrainingData() {
            if (!confirm('هل أنت متأكد من حذف جميع بيانات التدريب؟ هذا الإجراء لا يمكن التراجع عنه.')) {
                return;
            }

            const formData = new FormData();
            formData.append('action', 'clear_training_data');

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    refreshStats();
                } else {
                    showNotification(data.error || 'فشل في مسح البيانات', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('حدث خطأ في مسح البيانات', 'error');
            });
        }

        function refreshStats() {
            const formData = new FormData();
            formData.append('action', 'get_training_stats');

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                updateStats(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function updateStats(stats) {
            document.getElementById('totalEntries').textContent = stats.total_entries;
            document.getElementById('totalSize').textContent = formatFileSize(stats.total_size);
            document.getElementById('fileTypes').textContent = Object.keys(stats.file_types).length;

            // Update recent uploads
            const recentUploadsContainer = document.getElementById('recentUploads');
            
            if (stats.recent_uploads.length === 0) {
                recentUploadsContainer.innerHTML = `
                    <div style="text-align: center; color: #666; padding: 20px;">
                        لا توجد رفوعات حتى الآن
                    </div>
                `;
            } else {
                recentUploadsContainer.innerHTML = stats.recent_uploads.map(upload => `
                    <div class="upload-item">
                        <div class="upload-info">
                            <div class="upload-name">${upload.filename}</div>
                            <div class="upload-meta">
                                ${upload.timestamp} • ${formatFileSize(upload.size)} • ${upload.type.toUpperCase()}
                            </div>
                        </div>
                        <div class="upload-status">معالج</div>
                    </div>
                `).join('');
            }
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 B';
            const k = 1024;
            const sizes = ['B', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
        }

        function showNotification(message, type) {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.notification');
            existingNotifications.forEach(n => n.remove());

            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            document.body.appendChild(notification);

            // Auto remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Initialize everything
        document.addEventListener('DOMContentLoaded', function() {
            initFileUpload();
            refreshStats();
        });
    </script>
</body>
</html>