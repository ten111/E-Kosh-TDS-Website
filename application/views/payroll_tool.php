<!DOCTYPE html>
<html>
<head>
    <title>E Kosh TDS Payroll Tool</title>
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
            height: 600px;
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
        .stats-card h2 { margin: 5px 0; color: #1f4be3; }
        .table-container {
            max-height: 400px;
            overflow: auto;
            font-size: 13px;
        }
        .table-container th {
            position: sticky;
            top: 0;
            background: #1f4be3;
            color: white;
            z-index: 10;
        }
        .logo-text {
            font-size: 28px;
            font-weight: bold;
            color: #1f4be3;
        }
        .logo-sub {
            color: #6c757d;
            font-size: 14px;
        }
        .btn-download {
            background: #1f4be3;
            color: white;
            font-weight: bold;
            padding: 12px 30px;
            border-radius: 30px;
            border: none;
            transition: all 0.3s;
        }
        .btn-download:hover {
            background: #0d2b9e;
            transform: scale(1.02);
            color: white;
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
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            color: #6c757d;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="logo-text">E-KOSH TDS</h1>
                <p class="logo-sub">TDS TOOLS FOR GOVT DDO</p>
                <h5>Payroll Downloader</h5>
            </div>
        </div>

        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-<?php echo $this->session->flashdata('type'); ?> alert-dismissible fade show">
                <?php echo $this->session->flashdata('msg'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="stats-card">
                    <h6><i class="fas fa-users text-primary"></i> Total Records</h6>
                    <h2><?php echo count($records ?? []); ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h6><i class="fas fa-calendar text-success"></i> Last Import</h6>
                    <h6 style="font-size:14px;">
                        <?php 
                        if (!empty($records)) {
                            echo date('d-m-Y H:i', strtotime($records[0]->created_at));
                        } else {
                            echo 'Never';
                        }
                        ?>
                    </h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h6><i class="fas fa-file-excel text-success"></i> Actions</h6>
                    <a href="<?php echo base_url('payroll/export_db'); ?>" class="btn btn-sm btn-success">
                        <i class="fas fa-download"></i> Export DB
                    </a>
                    <a href="<?php echo base_url('payroll/clear_data'); ?>" class="btn btn-sm btn-danger" 
                       onclick="return confirm('Clear all data?')">
                        <i class="fas fa-trash"></i> Clear
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h6><i class="fas fa-info-circle text-info"></i> Status</h6>
                    <h6 id="statusText" style="color:#1f4be3;font-weight:500;">Ready</h6>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="main-card">
                    <h6><i class="fas fa-globe text-primary"></i> DDO Portal</h6>
                    <div class="iframe-container">
                        <div id="loadingOverlay" class="loading-overlay">
                            <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <h5 class="mt-3">Loading DDO Portal...</h5>
                            <p class="text-muted">Please wait for the page to load completely</p>
                        </div>
                        <iframe id="ddoIframe" src="<?php echo base_url('payroll/proxy'); ?>">
                        </iframe>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-info-circle"></i> Fill the form, click "Show Report...", then click "Extract & Import"
                    </small>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="main-card">
                    <h6><i class="fas fa-cogs text-success"></i> Controls</h6>
                    
                    <form id="extractForm">
                        <div class="mb-3">
                            <label class="fw-bold">DDO Code</label>
                            <input type="text" name="ddo_code" id="ddo_code" class="form-control" value="0820007">
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Month (MM/YYYY)</label>
                            <input type="text" name="month" id="month" class="form-control" value="03/2026">
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Financial Year</label>
                            <select name="fin_year" id="fin_year" class="form-control">
                                <?php for($y = 2026; $y >= 2010; $y--): ?>
                                    <?php $next = $y + 1; ?>
                                    <option value="<?php echo $y . '_' . substr($next, -2); ?>" 
                                            <?php echo ($y == 2026) ? 'selected' : ''; ?>>
                                        <?php echo $y . '_' . substr($next, -2); ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Payroll Type</label>
                            <select name="payroll_type" id="payroll_type" class="form-control">
                                <option value="PAYROLL_GEN">PAYROLL_GEN</option>
                                <option value="PAYROLL_CPS_CGPF" selected>PAYROLL_CPS_CGPF</option>
                            </select>
                        </div>
                        
                        <button type="button" id="extractBtn" class="btn btn-success w-100" onclick="extractData()">
                            <i class="fas fa-cloud-download-alt"></i> Extract & Import Data
                        </button>
                    </form>
                    
                    <div id="statusMessage" class="mt-3"></div>
                    
                    <div class="mt-3">
                        <button class="btn btn-sm btn-outline-secondary w-100" onclick="reloadIframe()">
                            <i class="fas fa-sync"></i> Reload Iframe
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Records -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="main-card">
                    <h6><i class="fas fa-list"></i> Imported Records</h6>
                    <div class="table-container">
                        <table class="table table-bordered table-striped" id="payrollTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee Code</th>
                                    <th>Name</th>
                                    <th>PRAN</th>
                                    <th>Basic</th>
                                    <th>Payroll Type</th>
                                    <th>Total Deductions</th>
                                    <th>Total Dues</th>
                                    <th>Month</th>
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
                                        <td><?php echo $row->payroll_type; ?></td>
                                        <td><?php echo number_format($row->total_deductions); ?></td>
                                        <td><?php echo number_format($row->total_dues); ?></td>
                                        <td><?php echo $row->month; ?></td>
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

        <div class="footer">
            <p>© <?php echo date('Y'); ?> E KOSH TECH SOLUTIONS | All Rights Reserved</p>
            <p><a href="https://www.ekoshtds.com" target="_blank">www.ekoshtds.com</a></p>
        </div>
    </div>

    <script>
        // Hide loading overlay when iframe loads
        document.getElementById('ddoIframe').addEventListener('load', function() {
            document.getElementById('loadingOverlay').classList.add('hidden');
        });

        setTimeout(function() {
            document.getElementById('loadingOverlay').classList.add('hidden');
        }, 15000);

        function reloadIframe() {
            document.getElementById('loadingOverlay').classList.remove('hidden');
            document.getElementById('ddoIframe').src = document.getElementById('ddoIframe').src;
        }

        function extractData() {
            const extractBtn = document.getElementById('extractBtn');
            const statusMsg = document.getElementById('statusMessage');
            
            extractBtn.disabled = true;
            extractBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Extracting...';
            statusMsg.innerHTML = '<div class="alert alert-info"><i class="fas fa-spinner fa-spin"></i> Extracting data...</div>';
            
            try {
                const iframe = document.getElementById('ddoIframe');
                const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                const html = iframeDoc.documentElement.outerHTML;
                
                // Get form values
                const ddo_code = document.getElementById('ddo_code').value;
                const month = document.getElementById('month').value;
                const fin_year = document.getElementById('fin_year').value;
                const payroll_type = document.getElementById('payroll_type').value;
                
                // Send to server
                fetch('<?php echo base_url("payroll/extract_data"); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'html=' + encodeURIComponent(html) + 
                          '&ddo_code=' + encodeURIComponent(ddo_code) +
                          '&month=' + encodeURIComponent(month) +
                          '&fin_year=' + encodeURIComponent(fin_year) +
                          '&payroll_type=' + encodeURIComponent(payroll_type)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        statusMsg.innerHTML = `<div class="alert alert-success">✅ ${data.message}</div>`;
                        if (data.filename) {
                            statusMsg.innerHTML += `<div class="mt-2">
                                <a href="<?php echo base_url('payroll/download_csv/'); ?>${data.filename}" 
                                   class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i> Download CSV
                                </a>
                            </div>`;
                        }
                        setTimeout(() => location.reload(), 3000);
                    } else {
                        statusMsg.innerHTML = `<div class="alert alert-danger">❌ ${data.message}</div>`;
                    }
                    resetButton();
                })
                .catch(error => {
                    statusMsg.innerHTML = `<div class="alert alert-danger">❌ Network error: ${error.message}</div>`;
                    resetButton();
                });
                
            } catch (error) {
                statusMsg.innerHTML = `<div class="alert alert-danger">❌ Cannot access iframe. Please reload.</div>`;
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