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
            font-size: 18px;
        }
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .data-preview {
            max-height: 300px;
            overflow: auto;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
            display: none;
        }
        .step-number {
            display: inline-block;
            width: 30px;
            height: 30px;
            background: #0d6efd;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
            margin-right: 10px;
        }
        .instruction-step {
            padding: 10px;
            border-left: 3px solid #0d6efd;
            margin-bottom: 10px;
            background: #f8f9fa;
        }
        .copy-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .textarea-wrapper {
            position: relative;
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
                <p class="text-muted">Open DDO website in a new window, search data, copy table, and paste here</p>
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
            <div class="col-md-6">
                <div class="main-card">
                    <h5><i class="fas fa-window-restore text-primary"></i> Step 1: Open DDO Website</h5>
                    <p class="text-muted">Click the button below to open the DDO portal in a new window</p>
                    
                    <a href="https://ekoshonline.cg.gov.in/epayroll/frmempdetails.aspx" 
                       target="_blank" 
                       class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-external-link-alt"></i> Open DDO Portal in New Window
                    </a>
                    
                    <hr>
                    
                    <div class="mt-3">
                        <h6><i class="fas fa-list-check"></i> Instructions in the new window:</h6>
                        <div class="instruction-step">
                            <span class="step-number">1</span>
                            Enter DDO Code (e.g., 0820007)
                        </div>
                        <div class="instruction-step">
                            <span class="step-number">2</span>
                            Select PayRoll Type (PAYROLL_CPS_CGPF)
                        </div>
                        <div class="instruction-step">
                            <span class="step-number">3</span>
                            Enter Month/Year (e.g., 03/2026)
                        </div>
                        <div class="instruction-step">
                            <span class="step-number">4</span>
                            Select Financial Year (e.g., 2026_27)
                        </div>
                        <div class="instruction-step">
                            <span class="step-number">5</span>
                            Click "Show Report..." button
                        </div>
                        <div class="instruction-step">
                            <span class="step-number">6</span>
                            <strong>Copy the entire table</strong> (Ctrl+A, Ctrl+C)
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="main-card">
                    <h5><i class="fas fa-paste text-success"></i> Step 2: Paste & Import</h5>
                    
                    <div class="textarea-wrapper">
                        <textarea id="tableData" class="form-control" rows="10" 
                                  placeholder="Paste the copied table data here..."></textarea>
                        <button class="btn btn-sm btn-secondary copy-btn" onclick="copySample()">
                            <i class="fas fa-copy"></i> Sample
                        </button>
                    </div>
                    
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-success btn-lg flex-grow-1" onclick="parseAndImport()">
                            <i class="fas fa-cloud-upload-alt"></i> Parse & Import Data
                        </button>
                        <button class="btn btn-info" onclick="previewData()">
                            <i class="fas fa-eye"></i> Preview
                        </button>
                    </div>
                    
                    <div id="previewArea" class="data-preview mt-3"></div>
                    
                    <div id="statusMessage" class="mt-3"></div>
                </div>
            </div>
        </div>

        <!-- Imported Records -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="main-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-list"></i> Imported Records</h5>
                        <span class="badge bg-primary" id="recordCount"><?php echo count($records ?? []); ?></span>
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

        function copySample() {
            const sample = `95	08200070121	LALITA TARA ANANT	110052829355	9	45400	0	0	0	0	0	360	5448	0	0	0	0	0	0	0	0	0	0		...	5808	75510`;
            document.getElementById('tableData').value = sample;
            showToast('Sample Copied', 'Sample data has been pasted. Click "Parse & Import" to test.', 'info');
        }

        function previewData() {
            const data = document.getElementById('tableData').value;
            if (!data.trim()) {
                showToast('Error', 'Please paste some data first', 'error');
                return;
            }
            
            const lines = data.split('\n').filter(line => line.trim());
            const previewArea = document.getElementById('previewArea');
            
            if (lines.length === 0) {
                previewArea.style.display = 'none';
                return;
            }
            
            let html = '<h6>Preview (First 10 rows):</h6><table class="table table-bordered table-sm">';
            html += '<thead><tr><th>#</th><th>Employee Code</th><th>Name</th></tr></thead><tbody>';
            
            const maxRows = Math.min(10, lines.length);
            for (let i = 0; i < maxRows; i++) {
                const cols = lines[i].split('\t');
                if (cols.length >= 3) {
                    html += `<tr><td>${i+1}</td><td>${cols[1] || ''}</td><td>${cols[2] || ''}</td></tr>`;
                }
            }
            
            html += '</tbody></table>';
            html += `<p class="text-muted small">Total ${lines.length} rows found</p>`;
            
            previewArea.innerHTML = html;
            previewArea.style.display = 'block';
        }

        function parseAndImport() {
            const data = document.getElementById('tableData').value;
            const statusMsg = document.getElementById('statusMessage');
            
            if (!data.trim()) {
                showToast('Error', 'Please paste table data first', 'error');
                return;
            }
            
            statusMsg.innerHTML = '<div class="alert alert-info"><i class="fas fa-spinner fa-spin"></i> Parsing data...</div>';
            
            // Parse the data
            const lines = data.split('\n').filter(line => line.trim());
            const employees = [];
            
            for (let i = 0; i < lines.length; i++) {
                // Split by tabs (from copied table)
                let cols = lines[i].split('\t');
                
                // If tabs don't work, try splitting by multiple spaces
                if (cols.length < 3) {
                    cols = lines[i].split(/\s{2,}/);
                }
                
                // Clean up
                cols = cols.map(c => c.trim());
                
                // Skip header rows
                if (cols[0] === 'EMPLOYEEID' || cols[0] === '#' || cols[0] === '') {
                    continue;
                }
                
                if (cols.length >= 3) {
                    employees.push({
                        employee_id: cols[0] || '',
                        employee_code: cols[1] || '',
                        name: cols[2] || '',
                        pran: cols[3] || '',
                        basic: cols[5] || '0',
                        total_deductions: cols[92] || '0',
                        total_dues: cols[93] || '0',
                        fin_year: cols[71] || '2026_27'
                    });
                }
            }
            
            if (employees.length === 0) {
                statusMsg.innerHTML = '<div class="alert alert-warning">No data found. Please check the format.</div>';
                showToast('Error', 'No data found. Please check the format.', 'error');
                return;
            }
            
            statusMsg.innerHTML = `<div class="alert alert-info"><i class="fas fa-spinner fa-spin"></i> Found ${employees.length} records. Importing...</div>`;
            
            // Send to server
            fetch('<?php echo base_url("employee/import_data"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ employees: employees })
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
            })
            .catch(error => {
                showToast('Error', 'Network error: ' + error.message, 'error');
                statusMsg.innerHTML = `<div class="alert alert-danger">❌ Network error. Please try again.</div>`;
            });
        }

        // Auto-preview when pasting
        document.getElementById('tableData').addEventListener('paste', function() {
            setTimeout(previewData, 500);
        });
    </script>
</body>
</html>