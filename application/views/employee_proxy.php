<!DOCTYPE html>
<html>
<head>
    <title>Employee Data Import - DDO Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; }
        .container-fluid { max-width: 1400px; padding: 20px; }
        .main-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .iframe-container {
            height: 650px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
        }
        .iframe-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stats-card h2 { margin: 5px 0; }
        .table-container {
            max-height: 400px;
            overflow: auto;
            font-size: 13px;
        }
        .table-container th {
            position: sticky;
            top: 0;
            background: #5D7B9D;
            color: white;
            z-index: 10;
        }
        .extract-btn {
            padding: 12px 30px;
            font-weight: bold;
            font-size: 16px;
        }
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            flex-direction: column;
        }
        .loading-overlay.hidden {
            display: none;
        }
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .badge-count {
            font-size: 14px;
            padding: 8px 15px;
        }
        .instructions {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #0d6efd;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2 class="text-primary">
                    <i class="fas fa-database"></i> Employee Data Import Portal
                </h2>
                <p class="text-muted">Use the DDO portal below to search and import data directly</p>
            </div>
        </div>

        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-<?php echo $this->session->flashdata('type'); ?> alert-dismissible fade show">
                <?php echo $this->session->flashdata('msg'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Stats Row -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="stats-card">
                    <h5><i class="fas fa-users text-primary"></i> Total Records</h5>
                    <h2 id="totalRecords"><?php echo count($records ?? []); ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h5><i class="fas fa-calendar text-success"></i> Last Import</h5>
                    <h6 id="lastImport">
                        <?php 
                        if (!empty($records)) {
                            echo date('d-m-Y H:i', strtotime($records[0]->imported_at));
                        } else {
                            echo 'Never';
                        }
                        ?>
                    </h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h5><i class="fas fa-money-bill text-warning"></i> Total Basic</h5>
                    <h6 id="totalBasic">
                        <?php 
                        $total = 0;
                        foreach ($records ?? [] as $r) $total += $r->basic;
                        echo '₹ ' . number_format($total);
                        ?>
                    </h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h5><i class="fas fa-file-excel text-success"></i> Actions</h5>
                    <a href="<?php echo base_url('employee/export_csv'); ?>" class="btn btn-sm btn-success">
                        <i class="fas fa-download"></i> Export CSV
                    </a>
                    <a href="<?php echo base_url('employee/clear_data'); ?>" class="btn btn-sm btn-danger" 
                       onclick="return confirm('Clear all data?')">
                        <i class="fas fa-trash"></i> Clear
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-md-8">
                <div class="main-card">
                    <h5><i class="fas fa-globe text-primary"></i> DDO Portal (Search & View Data)</h5>
                    <div class="iframe-container">
                        <div id="loadingOverlay" class="loading-overlay">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <h5 class="mt-3">Loading DDO Portal...</h5>
                            <p class="text-muted">Please wait for the page to load completely</p>
                        </div>
                        <iframe id="ddoIframe" src="<?php echo base_url('employee/proxy'); ?>">
                        </iframe>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> Use the search form above, click "Show Report...", then click "Extract & Import" below
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="main-card">
                    <h5><i class="fas fa-cogs text-success"></i> Import Controls</h5>
                    
                    <button id="extractBtn" class="btn btn-success btn-lg w-100 extract-btn" onclick="extractData()">
                        <i class="fas fa-cloud-download-alt"></i> Extract & Import Data
                    </button>
                    <small class="text-muted d-block mt-2 text-center">
                        <i class="fas fa-info-circle"></i> Click after searching data in the iframe above
                    </small>
                    
                    <hr>
                    
                    <div id="statusMessage" class="mt-3"></div>
                    
                    <div class="instructions mt-3">
                        <h6><i class="fas fa-list-check"></i> Instructions:</h6>
                        <ol class="small mb-0">
                            <li>Enter DDO Code (e.g., 0820007)</li>
                            <li>Select PayRoll Type (PAYROLL_CPS_CGPF)</li>
                            <li>Enter Month/Year (e.g., 03/2026)</li>
                            <li>Select Financial Year (e.g., 2026_27)</li>
                            <li>Click "Show Report..." button</li>
                            <li>Click <strong>"Extract & Import Data"</strong> above</li>
                        </ol>
                    </div>
                    
                    <div class="mt-3">
                        <button class="btn btn-sm btn-outline-secondary w-100" onclick="reloadIframe()">
                            <i class="fas fa-sync"></i> Reload Iframe
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Imported Records -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="main-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-list"></i> Imported Records</h5>
                        <span class="badge bg-primary badge-count" id="recordCount"><?php echo count($records ?? []); ?></span>
                    </div>
                    <div class="table-container">
                        <table class="table table-bordered table-striped" id="employeeTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee Code</th>
                                    <th>Name</th>
                                    <th>PRAN</th>
                                    <th>Basic</th>
                                    <th>Total Deductions</th>
                                    <th>Total Dues</th>
                                    <th>Financial Year</th>
                                    <th>Imported At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($records) && !empty($records)): ?>
                                    <?php foreach($records as $key => $row): ?>
                                    <tr>
                                        <td><?php echo $key+1; ?></td>
                                        <td><?php echo $row->employee_code; ?></td>
                                        <td><?php echo $row->name; ?></td>
                                        <td><?php echo $row->pran; ?></td>
                                        <td><?php echo number_format($row->basic); ?></td>
                                        <td><?php echo number_format($row->total_deductions); ?></td>
                                        <td><?php echo number_format($row->total_dues); ?></td>
                                        <td><?php echo $row->fin_year; ?></td>
                                        <td><?php echo date('d-m-Y H:i', strtotime($row->imported_at)); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="9" class="text-center">No records imported yet</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-container">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="toastTitle">Success</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body" id="toastMessage">Data imported successfully!</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hide loading overlay when iframe loads
        document.getElementById('ddoIframe').addEventListener('load', function() {
            document.getElementById('loadingOverlay').classList.add('hidden');
        });

        // Fallback: hide after 15 seconds
        setTimeout(function() {
            document.getElementById('loadingOverlay').classList.add('hidden');
        }, 15000);

        function showToast(title, message, type = 'success') {
            const toastEl = document.getElementById('liveToast');
            const toast = new bootstrap.Toast(toastEl);
            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastMessage').textContent = message;
            
            const header = toastEl.querySelector('.toast-header');
            header.className = 'toast-header';
            if (type === 'success') {
                header.classList.add('bg-success', 'text-white');
            } else if (type === 'error') {
                header.classList.add('bg-danger', 'text-white');
            } else {
                header.classList.add('bg-warning');
            }
            
            toast.show();
        }

        function reloadIframe() {
            document.getElementById('loadingOverlay').classList.remove('hidden');
            document.getElementById('ddoIframe').src = document.getElementById('ddoIframe').src;
        }

        function extractData() {
            const extractBtn = document.getElementById('extractBtn');
            const statusMsg = document.getElementById('statusMessage');
            
            extractBtn.disabled = true;
            extractBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Extracting...';
            statusMsg.innerHTML = '<div class="alert alert-info"><i class="fas fa-spinner fa-spin"></i> Extracting data from table...</div>';
            
            try {
                const iframe = document.getElementById('ddoIframe');
                const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                
                // Get the HTML of the iframe
                const html = iframeDoc.documentElement.outerHTML;
                
                // Send to server for extraction
                fetch('<?php echo base_url("employee/extract_data"); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'html=' + encodeURIComponent(html)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Success', `✅ ${data.message}`, 'success');
                        statusMsg.innerHTML = `<div class="alert alert-success">✅ ${data.message}</div>`;
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast('Error', data.message || 'Failed to import', 'error');
                        statusMsg.innerHTML = `<div class="alert alert-danger">❌ ${data.message}</div>`;
                    }
                    resetButton();
                })
                .catch(error => {
                    showToast('Error', 'Network error: ' + error.message, 'error');
                    statusMsg.innerHTML = '<div class="alert alert-danger">❌ Network error. Please try again.</div>';
                    resetButton();
                });
                
            } catch (error) {
                showToast('Error', 'Cannot access iframe content. Please reload and try again.', 'error');
                statusMsg.innerHTML = '<div class="alert alert-danger">❌ Cannot access iframe. Please reload and try again.</div>';
                resetButton();
            }
        }

        function resetButton() {
            const extractBtn = document.getElementById('extractBtn');
            extractBtn.disabled = false;
            extractBtn.innerHTML = '<i class="fas fa-cloud-download-alt"></i> Extract & Import Data';
        }
    </script>
</body>
</html>