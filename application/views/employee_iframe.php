<!DOCTYPE html>
<html>
<head>
    <title>Employee Data Import - DDO Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; }
        .container-fluid { max-width: 1400px; padding: 20px; }
        .iframe-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px;
            height: 700px;
            position: relative;
        }
        .iframe-container iframe {
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 5px;
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
            z-index: 1000;
            border-radius: 10px;
        }
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .action-bar {
            background: white;
            border-radius: 10px;
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-top: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        .action-bar label {
            font-weight: bold;
            margin: 0;
            font-size: 0.9rem;
        }
        .action-bar input, .action-bar select {
            width: 120px;
            display: inline-block;
        }
        .progress-bar-custom {
            height: 20px;
            border-radius: 10px;
        }
        .fallback-note {
            font-size: 0.75rem;
            color: #6c757d;
            cursor: pointer;
        }
        .fallback-note:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2 class="text-primary">
                    <i class="fas fa-database"></i> Employee Data Import Portal
                </h2>
                <p class="text-muted">Fill the form in the iframe, click "Show Report", then click "Extract & Import".</p>
            </div>
        </div>

        <!-- Iframe -->
        <div class="row">
            <div class="col-12">
                <div class="iframe-container">
                    <div id="loadingOverlay" class="loading-overlay">
                        <div class="text-center">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <h5 class="mt-3">Loading DDO Portal...</h5>
                            <p class="text-muted">Please wait for the page to load completely</p>
                        </div>
                    </div>
                    <iframe id="ddoIframe" 
                            src="<?php echo base_url('employee/proxy'); ?>"
                            sandbox="allow-same-origin allow-scripts allow-forms allow-popups allow-modals">
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="row">
            <div class="col-12">
                <div class="action-bar">
                    <!-- Fallback manual inputs (hidden by default, shown if iframe fails) -->
                    <div id="fallbackInputs" style="display:none; width:100%;">
                        <div class="row g-2">
                            <div class="col-auto">
                                <label>DDO Code</label>
                                <input type="text" class="form-control form-control-sm" id="fallbackDdo" value="0820007">
                            </div>
                            <div class="col-auto">
                                <label>Payroll Type</label>
                                <select class="form-select form-select-sm" id="fallbackPayroll">
                                    <option value="PAYROLL_CPS_CGPF">PAYROLL_CPS_CGPF</option>
                                    <option value="PAYROLL_CGPF">PAYROLL_CGPF</option>
                                    <option value="PAYROLL_CPS">PAYROLL_CPS</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <label>Month/Year</label>
                                <input type="text" class="form-control form-control-sm" id="fallbackMonth" value="03/2026">
                            </div>
                        </div>
                        <hr>
                    </div>

                    

                    <div id="progressContainer" style="display:none; flex:1;">
                        <div class="progress progress-bar-custom">
                            <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" 
                                 role="progressbar" style="width: 0%;">0%</div>
                        </div>
                        <small class="text-muted" id="progressText">Processing...</small>
                    </div>

                    <button id="extractBtn" class="btn btn-success" onclick="extractData()">
                        <i class="fas fa-cloud-download-alt"></i> Extract & Import Data
                    </button>
                    
                    <div id="statusMessage" class="alert alert-info" style="display:none; margin:0; font-size:0.9rem; flex:1;">
                        <i class="fas fa-spinner fa-spin"></i> Processing...
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
    </div>

    <!-- CSRF Token Meta Tag -->
    <meta name="csrf-token-name" content="<?php echo $this->security->get_csrf_token_name(); ?>">
    <meta name="csrf-token-value" content="<?php echo $this->security->get_csrf_hash(); ?>">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let fallbackVisible = false;

        function toggleFallback() {
            fallbackVisible = !fallbackVisible;
            document.getElementById('fallbackInputs').style.display = fallbackVisible ? 'block' : 'none';
        }

        // Hide loading overlay when iframe loads
        document.getElementById('ddoIframe').addEventListener('load', function() {
            document.getElementById('loadingOverlay').style.display = 'none';
        });

        setTimeout(function() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }, 15000);

        function showToast(title, message, type = 'success') {
            const toastEl = document.getElementById('liveToast');
            const toast = new bootstrap.Toast(toastEl);
            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastMessage').textContent = message;
            const header = toastEl.querySelector('.toast-header');
            header.className = 'toast-header bg-' + (type === 'success' ? 'success' : type === 'error' ? 'danger' : 'warning') + ' text-white';
            toast.show();
        }

        function updateProgress(percent, text) {
            const container = document.getElementById('progressContainer');
            const bar = document.getElementById('progressBar');
            const textEl = document.getElementById('progressText');
            container.style.display = 'block';
            bar.style.width = percent + '%';
            bar.textContent = percent + '%';
            textEl.textContent = text;
        }

        function getFormValues() {
            try {
                const iframe = document.getElementById('ddoIframe');
                const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

                const ddoInput = iframeDoc.getElementById('txtDDO');
                const ddlType = iframeDoc.getElementById('ddlType');
                const txtMonth = iframeDoc.getElementById('txtMonth');

                let ddo = ddoInput ? ddoInput.value.trim() : '';
                let payroll = ddlType ? ddlType.value : '';
                let month = txtMonth ? txtMonth.value.trim() : '';

                if (ddo && payroll && month) {
                    return { ddo, payroll, month, source: 'iframe' };
                }
            } catch(e) {
                console.warn('Cannot access iframe fields:', e);
            }

            // Fallback to manual inputs
            const fallbackDdo = document.getElementById('fallbackDdo').value.trim();
            const fallbackPayroll = document.getElementById('fallbackPayroll').value;
            const fallbackMonth = document.getElementById('fallbackMonth').value.trim();

            if (fallbackDdo && fallbackPayroll && fallbackMonth) {
                return { ddo: fallbackDdo, payroll: fallbackPayroll, month: fallbackMonth, source: 'manual' };
            }

            return null;
        }

        function extractData() {
            const extractBtn = document.getElementById('extractBtn');
            const statusMsg = document.getElementById('statusMessage');
            const finYear = document.getElementById('finYear').value.trim();

            if (!finYear) {
                showToast('Error', 'Please enter Financial Year.', 'error');
                return;
            }

            // Get form values (iframe or manual)
            const formVals = getFormValues();
            if (!formVals) {
                showToast('Error', 'Please fill DDO, Payroll Type, Month/Year either in iframe or in manual fields.', 'error');
                return;
            }

            const { ddo, payroll, month, source } = formVals;
            console.log(`Using ${source} values:`, { ddo, payroll, month });

            // Show loading
            extractBtn.disabled = true;
            extractBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Extracting...';
            statusMsg.style.display = 'block';
            statusMsg.className = 'alert alert-info';
            statusMsg.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Extracting data...';
            updateProgress(10, 'Reading iframe data...');

            try {
                const iframe = document.getElementById('ddoIframe');
                const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

                // ----- Extract table data -----
                const table = iframeDoc.getElementById('GridView1');
                if (!table) {
                    showToast('Error', 'Table not found. Please click "Show Report" in the iframe first.', 'error');
                    resetButton();
                    return;
                }

                updateProgress(30, 'Parsing table rows...');
                const rows = table.getElementsByTagName('tr');
                const employees = [];

                for (let i = 1; i < rows.length; i++) {
                    const cols = rows[i].getElementsByTagName('td');
                    if (cols.length > 0) {
                        const cellValues = [];
                        for (let j = 0; j < cols.length; j++) {
                            let text = cols[j].textContent.trim();
                            text = text.replace(/\s+/g, ' ').trim();
                            text = text.replace(/,/g, '');
                            cellValues.push(text);
                        }
                        if (!cellValues[0] || cellValues[0] === '' || cellValues[0] === 'SNo') continue;
                        employees.push({
                            emp_code: cellValues[1] || '',
                            emp_name: cellValues[2] || '',
                            dt_bill_no: cellValues[4] || '0',
                            dt_btr: cellValues[75] || '0',
                            dt_basic: cellValues[5] || '0',
                            dt_da: cellValues[41] || '0',
                            dt_fix_ta: cellValues[40] || '0',
                            dt_house: cellValues[43] || '0',
                            dt_hre_recv: cellValues[14] || '0',
                            dt_city: cellValues[45] || '0',
                            dt_wash: cellValues[48] || '0',
                            dt_medical: cellValues[71] || '0',
                            dt_other: cellValues[59] || '0',
                            dt_dues: cellValues[88] || '0',
                            dt_gpf: cellValues[12] || '0',
                            dt_water: cellValues[15] || '0',
                            dt_gpf_recv: cellValues[21] || '0',
                            dt_fest: cellValues[26] || '0',
                            dt_gis: cellValues[11] || '0',
                            dt_tax: cellValues[9] || '0',
                            dt_ded: cellValues[87] || '0'
                        });
                    }
                }

                if (employees.length === 0) {
                    showToast('Warning', 'No employee data found in table.', 'warning');
                    resetButton();
                    return;
                }

                console.log('Form Data:', { ddo, payroll, month });
                console.log('Employees:', employees.length);

                updateProgress(50, `Found ${employees.length} records. Sending to server...`);
                statusMsg.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Sending ${employees.length} records...`;

                // CSRF token
                const csrfTokenName = document.querySelector('meta[name="csrf-token-name"]').content;
                const csrfTokenValue = document.querySelector('meta[name="csrf-token-value"]').content;

                const postData = {
                    employees: employees,
                    payroll_type: payroll,
                    month_year: month,
                    fin_year: finYear
                };
                postData[csrfTokenName] = csrfTokenValue;

                $.ajax({
                    url: '<?php echo base_url("employee/import_data"); ?>',
                    type: 'POST',
                    data: JSON.stringify(postData),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        console.log('Response:', response);
                        if (response.success) {
                            showToast('Success', response.message, 'success');
                            statusMsg.className = 'alert alert-success';
                            statusMsg.innerHTML = '✅ ' + response.message;
                            updateProgress(100, 'Done!');
                            setTimeout(() => { resetButton(); }, 3000);
                        } else {
                            showToast('Error', response.message || 'Failed', 'error');
                            statusMsg.className = 'alert alert-danger';
                            statusMsg.innerHTML = '❌ ' + response.message;
                            updateProgress(100, 'Failed!');
                            setTimeout(resetButton, 3000);
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMsg = 'Network error: ' + error;
                        try {
                            const resp = JSON.parse(xhr.responseText);
                            if (resp.message) errorMsg = resp.message;
                        } catch(e) {}
                        showToast('Error', errorMsg, 'error');
                        statusMsg.className = 'alert alert-danger';
                        statusMsg.innerHTML = '❌ ' + errorMsg;
                        updateProgress(100, 'Error!');
                        setTimeout(resetButton, 3000);
                    }
                });

            } catch (error) {
                showToast('Error', 'Cannot access iframe. Please reload.', 'error');
                statusMsg.className = 'alert alert-danger';
                statusMsg.innerHTML = '❌ ' + error.message;
                resetButton();
            }
        }

        function resetButton() {
            const extractBtn = document.getElementById('extractBtn');
            extractBtn.disabled = false;
            extractBtn.innerHTML = '<i class="fas fa-cloud-download-alt"></i> Extract & Import Data';
            setTimeout(() => {
                document.getElementById('progressContainer').style.display = 'none';
                document.getElementById('statusMessage').style.display = 'none';
            }, 2000);
        }
    </script>
</body>
</html>