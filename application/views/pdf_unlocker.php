<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Unlocker - Free Tool</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-card {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 650px;
            width: 100%;
            background: white;
            overflow: hidden;
        }
        
        .card-header-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .card-header-custom i {
            font-size: 50px;
            margin-bottom: 10px;
        }
        
        .card-header-custom h2 {
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .card-header-custom p {
            opacity: 0.9;
            margin-bottom: 0;
        }
        
        .card-body-custom {
            padding: 40px;
        }
        
        .drop-zone {
            border: 3px dashed #dee2e6;
            border-radius: 15px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
            position: relative;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .drop-zone:hover {
            border-color: #667eea;
            background: #f0f2ff;
            transform: translateY(-2px);
        }
        
        .drop-zone.dragover {
            border-color: #667eea;
            background: #e8edff;
            transform: scale(1.02);
        }
        
        .drop-zone .upload-icon {
            font-size: 60px;
            color: #667eea;
            margin-bottom: 15px;
        }
        
        .drop-zone input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        
        .file-info {
            display: none;
            margin-top: 15px;
            padding: 15px 20px;
            background: #e7f3ff;
            border-radius: 10px;
            border-left: 4px solid #667eea;
            width: 100%;
            animation: slideDown 0.3s ease;
        }
        
        .file-info.show {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .file-info i {
            font-size: 30px;
            color: #dc3545;
        }
        
        .file-info .file-details {
            flex: 1;
            text-align: left;
        }
        
        .file-info .file-details .name {
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }
        
        .file-info .file-details .size {
            color: #6c757d;
            font-size: 14px;
        }
        
        .file-info .remove-file {
            cursor: pointer;
            color: #dc3545;
            font-size: 20px;
            transition: transform 0.2s;
        }
        
        .file-info .remove-file:hover {
            transform: scale(1.2);
        }
        
        .password-input-group {
            position: relative;
        }
        
        .password-input-group .form-control {
            padding-right: 45px;
            height: 50px;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .password-input-group .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            background: white;
            padding: 5px 8px;
            border-radius: 5px;
            transition: color 0.3s;
        }
        
        .password-toggle:hover {
            color: #667eea;
        }
        
        .btn-unlock {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 14px 30px;
            color: white;
            font-weight: 600;
            border-radius: 50px;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 18px;
        }
        
        .btn-unlock:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .btn-unlock:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .btn-unlock .spinner-border {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
        
        .progress-container {
            display: none;
            margin-top: 20px;
        }
        
        .progress-container.show {
            display: block;
        }
        
        .progress {
            height: 8px;
            border-radius: 10px;
        }
        
        .progress-bar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: width 0.5s ease;
        }
        
        .result-container {
            display: none;
            margin-top: 20px;
            padding: 20px;
            border-radius: 12px;
            animation: slideDown 0.5s ease;
        }
        
        .result-container.show {
            display: block;
        }
        
        .result-container.success {
            background: #d4edda;
            border: 2px solid #c3e6cb;
            color: #155724;
        }
        
        .result-container.error {
            background: #f8d7da;
            border: 2px solid #f5c6cb;
            color: #721c24;
        }
        
        .result-container .result-icon {
            font-size: 40px;
            margin-right: 15px;
        }
        
        .btn-download {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-download:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(40, 167, 69, 0.3);
            color: white;
        }
        
        .btn-download i {
            margin-right: 8px;
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }
        
        .feature-item {
            text-align: center;
        }
        
        .feature-item i {
            font-size: 24px;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .feature-item .label {
            font-size: 12px;
            color: #6c757d;
            display: block;
        }
        
        .info-text {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
            color: #6c757d;
        }
        
        @media (max-width: 576px) {
            .card-body-custom {
                padding: 25px 20px;
            }
            
            .drop-zone {
                padding: 25px 15px;
                min-height: 140px;
            }
            
            .drop-zone .upload-icon {
                font-size: 40px;
            }
            
            .features {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="main-card">
        <div class="card-header-custom">
            <i class="fas fa-unlock-alt"></i>
            <h2>PDF Unlocker</h2>
            <p>Remove password protection from your PDF files</p>
        </div>
        
        <div class="card-body-custom">
            <form id="unlockForm" enctype="multipart/form-data">
                <!-- Drop Zone -->
                <div class="drop-zone" id="dropZone">
                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                    <h5>Drag & Drop your PDF here</h5>
                    <p>or click to browse</p>
                    <input type="file" name="pdf_file" id="pdfFile" accept=".pdf" required>
                    
                    <!-- File Info -->
                    <div class="file-info" id="fileInfo">
                        <i class="fas fa-file-pdf"></i>
                        <div class="file-details">
                            <div class="name" id="fileName">document.pdf</div>
                            <div class="size" id="fileSize">2.5 MB</div>
                        </div>
                        <span class="remove-file" id="removeFile">
                            <i class="fas fa-times-circle"></i>
                        </span>
                    </div>
                </div>
                
                <!-- Password Input -->
                <div class="mb-3 mt-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-key me-1"></i> PDF Password
                    </label>
                    <div class="password-input-group">
                        <input type="password" class="form-control form-control-lg" 
                               id="password" name="password" 
                               placeholder="Enter your PDF password" required>
                        <span class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
                
                <!-- Unlock Button -->
                <button type="submit" class="btn btn-unlock" id="unlockBtn">
                    <i class="fas fa-unlock-alt me-2"></i> Unlock PDF
                </button>
                
                <!-- Progress -->
                <div class="progress-container" id="progressContainer">
                    <div class="text-center mb-2">
                        <span class="text-muted">Processing your PDF...</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                             style="width: 100%"></div>
                    </div>
                </div>
                
                <!-- Result -->
                <div class="result-container" id="resultContainer">
                    <div class="d-flex align-items-center">
                        <div class="result-icon" id="resultIcon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div id="resultMessage" class="fw-bold mb-1"></div>
                            <div id="resultDetails" class="small"></div>
                        </div>
                    </div>
                    <div id="resultActions" class="mt-2"></div>
                </div>
                
                <!-- Features -->
                <div class="features">
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span class="label">Secure Processing</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-trash-alt"></i>
                        <span class="label">Auto Deletion</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-bolt"></i>
                        <span class="label">Fast & Free</span>
                    </div>
                </div>
                
                <div class="info-text">
                    <i class="fas fa-info-circle me-1"></i>
                    Your files are automatically deleted after download
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            const dropZone = $('#dropZone');
            const fileInput = $('#pdfFile');
            const fileInfo = $('#fileInfo');
            const fileName = $('#fileName');
            const fileSize = $('#fileSize');
            const removeFile = $('#removeFile');
            const passwordInput = $('#password');
            const togglePassword = $('#togglePassword');
            const unlockBtn = $('#unlockBtn');
            const progressContainer = $('#progressContainer');
            const resultContainer = $('#resultContainer');
            const resultMessage = $('#resultMessage');
            const resultDetails = $('#resultDetails');
            const resultIcon = $('#resultIcon');
            const resultActions = $('#resultActions');
            const form = $('#unlockForm');
            
            let selectedFile = null;
            
            // File input change
            fileInput.on('change', function() {
                if (this.files && this.files[0]) {
                    handleFile(this.files[0]);
                }
            });
            
            // Drag and drop
            dropZone.on('dragover', function(e) {
                e.preventDefault();
                $(this).addClass('dragover');
            });
            
            dropZone.on('dragleave', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');
            });
            
            dropZone.on('drop', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');
                
                const files = e.originalEvent.dataTransfer.files;
                if (files && files[0]) {
                    handleFile(files[0]);
                    const dt = new DataTransfer();
                    dt.items.add(files[0]);
                    fileInput[0].files = dt.files;
                }
            });
            
            function handleFile(file) {
                if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                    showResult(false, 'Please select a valid PDF file');
                    return;
                }
                
                selectedFile = file;
                fileName.text(file.name);
                fileSize.text(formatFileSize(file.size));
                fileInfo.addClass('show');
                dropZone.find('.upload-icon').hide();
                dropZone.find('h5').hide();
                dropZone.find('p').hide();
                resultContainer.removeClass('show');
            }
            
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
            
            removeFile.on('click', function() {
                selectedFile = null;
                fileInput.val('');
                fileInfo.removeClass('show');
                dropZone.find('.upload-icon').show();
                dropZone.find('h5').show();
                dropZone.find('p').show();
                resultContainer.removeClass('show');
                passwordInput.val('');
            });
            
            togglePassword.on('click', function() {
                const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            });
            
            function showResult(success, message, details = '', downloadUrl = '', filesize = '') {
                resultContainer.removeClass('success error');
                resultContainer.addClass(success ? 'success' : 'error');
                resultContainer.addClass('show');
                
                if (success) {
                    resultIcon.html('<i class="fas fa-check-circle"></i>');
                    resultMessage.text('✅ ' + message);
                    if (details) resultDetails.text(details);
                    if (downloadUrl) {
                        resultActions.html(`
                            <a href="${downloadUrl}" class="btn btn-download" id="downloadBtn">
                                <i class="fas fa-download"></i> Download Unlocked PDF
                            </a>
                            <div class="mt-2 small text-muted">File size: ${filesize}</div>
                        `);
                    }
                } else {
                    resultIcon.html('<i class="fas fa-times-circle"></i>');
                    resultMessage.text('❌ ' + message);
                    resultDetails.text(details || 'Please check the password and try again.');
                    resultActions.empty();
                }
            }
            
            form.on('submit', function(e) {
                e.preventDefault();
                
                if (!selectedFile) {
                    showResult(false, 'Please select a PDF file');
                    return;
                }
                
                const password = passwordInput.val().trim();
                if (!password) {
                    showResult(false, 'Please enter the PDF password');
                    return;
                }
                
                const formData = new FormData();
                formData.append('pdf_file', selectedFile);
                formData.append('password', password);
                
                unlockBtn.prop('disabled', true);
                unlockBtn.html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing...');
                progressContainer.addClass('show');
                resultContainer.removeClass('show');
                
                $.ajax({
                    url: '<?php echo base_url("index.php/pdfcontroller/unlock_pdf"); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    timeout: 60000,
                    success: function(response) {
                        progressContainer.removeClass('show');
                        unlockBtn.prop('disabled', false);
                        unlockBtn.html('<i class="fas fa-unlock-alt me-2"></i> Unlock PDF');
                        
                        if (response.success) {
                            showResult(
                                true,
                                response.message,
                                'Your PDF has been unlocked successfully!',
                                response.download_url,
                                response.filesize || ''
                            );
                        } else {
                            showResult(false, response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        progressContainer.removeClass('show');
                        unlockBtn.prop('disabled', false);
                        unlockBtn.html('<i class="fas fa-unlock-alt me-2"></i> Unlock PDF');
                        
                        let errorMsg = 'An error occurred. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showResult(false, errorMsg);
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
</body>
</html>