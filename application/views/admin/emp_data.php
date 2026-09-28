<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 style="color:#0033ff;margin-left:10px;" class="mb-sm-0">DDO NAME - <?php echo $this->session->userdata("loggeduser");?>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b class="text-dark"> |</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>DDO CODE - <?php echo $this->session->userdata("ddo_num");?></b></h4>
                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>
                            <li class="breadcrumb-item active">Employee Data</li>
                        </ol> -->

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div >
                <div>
                    <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-sm btn-info showonline pull-right right float-end end float-right">   Instruction for Salary Data Import</button>
                     
                        <h4 class="card-title mb-0"><i class="bi bi-info-circle-fill text-info me-1"></i> Import Salary Online 
                    </h4>
                    </div>
                    
                        <div class="import-guide m-2 row" id="iframe-container" style="display:none;">
                            <div class="col-md-12"><h5>How to Import Salary</h5>
                                <p> Please follow the instructions and enter the details in DDO Wise Employee Details frame.</p></div>
                            <div class="guide-section col-md-6">
                                
                                <h6 class="fw-bold text-primary">1. Import Salary Data for GPF / GEN Employees</h6>
                                <ol class="mb-3">
                                    <li>Enter the <strong>7-digit DDO Code</strong>.</li>
                                    <li>Select <strong>Payroll Type ID</strong> → <span class="badge bg-info">PAYROLL_GEN</span>.</li>
                                    <li>Enter <strong>Month/Year in MM/YYYY format</strong>.</li>
                                    <li>Select the appropriate <strong>Financial Year (e.g. 2026_27)</strong>.</li>
                                    <li>Click <strong>Show Report</strong>.</li>
                                    <li>Wait for the salary data to load completely in the frame.</li>
                                    <li>Click <strong>Extract & Import Data</strong>.</li>
                                </ol>
                            </div>

                            <div class="guide-section col-md-6">
                                <h6 class="fw-bold text-success">2. Import Salary Data for CPS / CGPF Employees</h6>
                                <ol class="mb-3">
                                    <li>Enter the <strong>7-digit DDO Code</strong>.</li>
                                    <li>Select <strong>Payroll Type ID</strong> → <span class="badge bg-warning">PAYROLL_CPS_CGPF</span>.</li>
                                    <li>Enter <strong>Month/Year in MM/YYYY format</strong>.</li>
                                    <li>Select the appropriate <strong>Financial Year (e.g. 2026_27)</strong>.</li>
                                    <li>Click <strong>Show Report</strong>.</li>
                                    <li>Wait for the salary data to load completely in the frame.</li>
                                    <li>Click <strong>Extract & Import Data</strong>.</li>
                                </ol>
                            </div>

                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                <strong>Important:</strong> If the DDO has both GPF/GEN and CPS/CGPF employees, perform the salary import for both Payroll Types.
                            </div>

                            <div class="alert alert-info mt-2">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                After completing the required salary imports, the page will refresh and the imported records will appear in the <strong>Listed Data</strong> → <strong>Salary table</strong>. Verify the <strong>Month and Total Record</strong> before proceeding.
                            </div>
                        </div>
                       
                           
                                    <div class="iframe-container" >
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

                           <div class="action-bar">
                                        <!-- Hidden Financial Year (will be sent to backend) -->
                                        <input type="hidden" id="finYear" value="2026_27">

                                        <!-- Fallback manual inputs (hidden by default) -->
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

                                        <!-- Progress Bar -->
                                        <div id="progressContainer" style="display:none; flex:1;">
                                            <div class="progress progress-bar-custom">
                                                <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" 
                                                     role="progressbar" style="width: 0%;">0%</div>
                                            </div>
                                            <small class="text-muted" id="progressText">Processing...</small>
                                        </div>

                                        <!-- Buttons -->
                                        <button id="extractBtn" class="btn btn-success  pull-right right float-end end float-right" onclick="extractData()">
                                            <i class="fas fa-cloud-download-alt"></i> Extract & Import Data
                                        </button>
                                        
                                      
                                        <!-- Status Message -->
                                        <div id="statusMessage" class="alert alert-info" style="display:none; margin:0; font-size:0.9rem; flex:1;">
                                            <i class="fas fa-spinner fa-spin"></i> Processing...
                                        </div>
                                    </div>
                </div>
                  
                </div> <!-- end col -->
            </div>
                <div class="card">
                    <div class="card-header">    
                        
					<h4 class="card-title mb-0">Upload Data</h4>
                <br/>
              
                    <div class="hstack flex-wrap gap-2 mb-3 mb-lg-0">
                          <a download href="<?php echo base_url().'assets/Setup_E_Kosh_TDS_Payroll_Tool.exe';?>" class="btn btn-sm btn-outline-primary btn-border pull-right right float-end end float-right">   Download E Kosh TDS Payroll Tool </a>
                    <a download href="<?php echo base_url().'assets/salary_data_import_template.csv';?>" class="btn btn-sm btn-outline-primary btn-border"><i class="fa bi-download"></i> Salary Data Import Template</a>
                    <a download href="<?php echo base_url().'assets/arrear_data_import_template.csv';?>"  class="btn btn-sm btn-outline-secondary btn-border"><i class="bi bi-download"></i> Arrear/Pay Arrear Data Import Template</a></div>
                </div>
                    
                    <div class="card-body">
                                            					      
								  <form  method="post" enctype="multipart/form-data" action="<?php echo base_url().'admin/upload_excel';?>">
															   <input type="hidden" name="finyr" value="<?php echo str_replace("-","_",$this->uri->segment(3));?>"/>
															   <div class="form-group">
																
					<label for="email">CSV Excel File</label>
															   <select class="form-control"  required name="dt_month">
															   <option>Month/Year</option>
                                                               <?php if($this->uri->segment(3)=="2025-26"){?>
								  <option value="Mar-2025">Mar-2025</option>
								  <option value="Apr-2025">Apr-2025</option>
								  <option value="May-2025">May-2025</option>
								  <option value="Jun-2025">Jun-2025</option>
								  <option value="Jul-2025">Jul-2025</option>
								  <option value="Aug-2025">Aug-2025</option>
								  <option value="Sep-2025">Sep-2025</option>
								  <option value="Oct-2025">Oct-2025</option>
								  <option value="Nov-2025">Nov-2025</option>
								  <option value="Dec-2025">Dec-2025</option>
								  <option value="Jan-2026">Jan-2026</option>
								  <option value="Feb-2026">Feb-2026</option>
                                  <?php } if($this->uri->segment(3)=="2026-27"){?>
								  
								  <option value="Mar-2026">Mar-2026</option>
								  <option value="Apr-2026">Apr-2026</option>
								  <option value="May-2026">May-2026</option>
								  <option value="Jun-2026">Jun-2026</option>
								  <option value="Jul-2026">Jul-2026</option>
								  <option value="Aug-2026">Aug-2026</option>
								  <option value="Sep-2026">Sep-2026</option>
								  <option value="Oct-2026">Oct-2026</option>
								  <option value="Nov-2026">Nov-2026</option>
								  <option value="Dec-2026">Dec-2026</option>
								  <option value="Jan-2027">Jan-2027</option>
								  <option value="Feb-2027">Feb-2027</option>
                                  <?php }?>
								  </select>
															   </div> 
															   <div class="form-group">
															   <label for="email">Payment Type</label>
																  <select class="form-control" required name="dt_type">
																	  <option>Type</option>
								  <option value="Salary">Salary</option>
								  <option value="Arear">Arrear</option>
								  <option value="PayArear">Pay Arrear</option>
								  </select>
															   </div> 
															   
															   <div class="form-group">
															   <label for="email">CSV File </label>
								<input type="file" accept=".csv" name="pfile" required class="form-control">
								<input type="hidden" name="syr" value="<?php echo $this->uri->segment(3);?>"/>
																</div>
																<br/>
																<button type="submit" class="btn btn-success  pull-right right float-end end float-right">Upload Data</button>
															  </form>
								  
                    </div>                   
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <select class="form-control pull-right float-end float-right" style="width:200px;" required="" id="fnyr_change">
																	  <option>Select Tax Year</option>
								  <option value="2025-26" <?php if($this->uri->segment(3)=="2025-26"){echo "selected";}?>>2025-26</option>
								  <option value="2026-27" <?php if($this->uri->segment(3)=="2026-27"){echo "selected";}?>>2026-27</option>
								  </select>
                        <h4 class="card-title mb-0">Listed Data</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
					<div class="table-responsive table-bordered table-condensed">
						<table class="table align-middle table-nowrap mb-0">
                            <thead>
                            <!-- <tr bgcolor="#CCCCCC"><th><div class="checkbox">
                            <input type="checkbox" id="checkAll" value="checkall" /> <label for="checkAll">All</label></div></th>
                            	<th><select class="form-control" style="width:80px;" id="showdata">
                                	<option value="10">10</option>
                                	<option value="25">25</option>
                                	<option value="100">100</option>
                                	<option value="200">200</option>
                                	<option value="500">500</option>
                                	</select></th><th colspan="5"></th></tr> -->
                            <tr bgcolor="#FFCC00">
                            <th>S.No.</th>
							<th>Type</th>
        <th>Month</th>
        <th>Total Record</th>
        <th>Action</th>
                            </tr></thead>
                                   <tbody>
                                        <tr><th colspan="5" style="background:#6689ab; color:#fff;">Salary</th></tr>
                                     <?php $i=1;foreach($salary as $r) {?>
										<tr><td><?php echo $i;?></td>
										<td><?php echo $r->dt_type;?></td>
										<td><?php echo $r->dt_month;?></td>
		<td><?php echo $this->db->get_where("emp_data",array("dt_type_mon"=>$r->dt_type_mon,"dt_client"=>$this->session->userdata("userid")))->num_rows();?></td>
										<td><a target="_blank" href="<?php echo base_url().'admin/datalist/'.$r->dt_type_mon;?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> VIEW</a>
                                    
    <a href="#" id="<?php echo $r->dt_type_mon;?>" class="btn btn-sm btn-danger empd_delete"><i class="bi bi-archive"></i></a></td></tr>
										<?php $i++;}?>

                                        <tr><th colspan="5" style="background:#6689ab; color:#fff;">Arear</th></tr>
                                        <?php $i=1;foreach($arear as $r) {?>
										<tr><td><?php echo $i;?></td>
										<td><?php echo $r->dt_type;?></td>
										<td><?php echo $r->dt_month;?></td>
		<td><?php echo $this->db->get_where("emp_data",array("dt_type_mon"=>$r->dt_type_mon,"dt_client"=>$this->session->userdata("userid")))->num_rows();?></td>
										<td><a target="_blank" href="<?php echo base_url().'admin/datalist/'.$r->dt_type_mon;?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> VIEW</a>
                                    
    <a href="#" id="<?php echo $r->dt_type_mon;?>" class="btn btn-sm btn-danger empd_delete"><i class="bi bi-archive"></i></a></td></tr>
										<?php $i++;}?>

                                        <tr><th colspan="5" style="background:#6689ab; color:#fff;">PayArear</th></tr>
                                        <?php $i=1;foreach($parear as $r) {?>
										<tr><td><?php echo $i;?></td>
										<td><?php echo $r->dt_type;?></td>
										<td><?php echo $r->dt_month;?></td>
		<td><?php echo $this->db->get_where("emp_data",array("dt_type_mon"=>$r->dt_type_mon,"dt_client"=>$this->session->userdata("userid")))->num_rows();?></td>
										<td><a target="_blank" href="<?php echo base_url().'admin/datalist/'.$r->dt_type_mon;?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> VIEW</a>
                                    
    <a href="#" id="<?php echo $r->dt_type_mon;?>" class="btn btn-sm btn-danger empd_delete"><i class="bi bi-archive"></i></a></td></tr>
										<?php $i++;}?>
                                   </tbody>
                        </table>
									 </div>
                    </div>
                    
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

       

        

        

        
        

        <!--end row-->

    </div> <!-- container-fluid -->
</div><!-- End Page-content -->

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © Invoika.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by Themesbrand
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<!-- end main content-->
<div class="toast-container">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto" id="toastTitle">Success</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" id="toastMessage">Data imported successfully!</div>
    </div>
</div>

<!-- CSRF Meta Tags -->
<meta name="csrf-token-name" content="<?php echo $this->security->get_csrf_token_name(); ?>">
<meta name="csrf-token-value" content="<?php echo $this->security->get_csrf_hash(); ?>">

<!-- ==================== Custom CSS ==================== -->
<style>
    .iframe-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 15px;
        height: 500px;
        position: relative;
    }
    .iframe-container iframe {
        width: 100%;
        height: 500px;
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

<!-- ==================== Custom JavaScript ==================== -->
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

    // Fallback timeout
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

            const ddoInput = iframeDoc.getElementById('txtDDOCode');
            const fnYear = iframeDoc.getElementById('ddlFin_Year');
            const txtMonth = iframeDoc.getElementById('txtMon_Year');

            let ddo = ddoInput ? ddoInput.value.trim() : '';
            let fnyr = fnYear ? fnYear.value : '';
            let month = txtMonth ? txtMonth.value.trim() : '';

            if (ddo && fnyr && month) {
                return { ddo, fnyr, month, source: 'iframe' };
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

            // const ddo1 = document.getElementById("txtDDOCode").value;
            // const txmyr = document.getElementById("txtMon_Year").value;
            // const txyr = document.getElementById("ddlFin_Year").value;

        if (!finYear) {
            showToast('Error', 'Financial Year is missing.', 'error');
            return;
        }

        const formVals = getFormValues();
        if (!formVals) {
            showToast('Error', 'Please fill DDO, Payroll Type, Month/Year either in iframe or in manual fields.', 'error');
            return;
        }

        const { ddo, fnyr, month, source } = formVals;
        console.log(`Using ${source} values:`, { ddo, fnyr, month });

        extractBtn.disabled = true;
        extractBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Extracting...';
        statusMsg.style.display = 'block';
        statusMsg.className = 'alert alert-info';
        statusMsg.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Extracting data...';
        updateProgress(10, 'Reading iframe data...');

        try {
            const iframe = document.getElementById('ddoIframe');
            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

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
                        emp_bill: cellValues[4] || '0',
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

            updateProgress(50, `Found ${employees.length} records. Sending to server...`);
            statusMsg.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Sending ${employees.length} records...`;

            const csrfTokenName = document.querySelector('meta[name="csrf-token-name"]').content;
            const csrfTokenValue = document.querySelector('meta[name="csrf-token-value"]').content;
            
            const postData = {
                employees: employees,
                //payroll_type: payroll,
                ddo_num: ddo,
                month_year: month,
                fin_year: fnyr
            };
            postData[csrfTokenName] = csrfTokenValue;

            $.ajax({
    url: '<?php echo base_url("employee/import_data"); ?>',
    type: 'POST',
    data: JSON.stringify(postData),
    contentType: 'application/json',
    dataType: 'json',
    success: function(response) {
        console.log(response);
        if (response.success) {
            showToast('Success', response.message, 'success');
            statusMsg.className = 'alert alert-success';
            statusMsg.innerHTML = '✅ ' + response.message;
            updateProgress(100, 'Done!');
            setTimeout(function() {
                window.location.href = "<?php echo $current_url;?>";
            }, 3000);
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
<script>
	$(document).ready(function(){
        $("#fnyr_change").change(function(){
        var v=$(this).val();
        if(v!=''){
        window.location.href="<?php echo base_url().'admin/empdata/';?>"+v;
        }
    });
        $(".empd_delete").click(function(e){e.preventDefault();

if (!confirm("Sure you want to delete?")){

          return false;

        }

    var id=$(this).attr("id");
    $(this).closest("tr").remove();

    $.ajax({

                     type: "POST",

                     url: '<?php echo base_url();?>admin/ajax_empd_delete2',

                     data: {id:id},

                     success: function(response){

                         //alert(response);

                     }

                     });

});

        $(".remove-me").click(function(){
		$(this).closest("tr").remove();
	});
var next = 0;
    $("#add-more").click(function(e){
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = '<tr id="field'+ next +'"><td><input type="text" class="form-control" required name="pfeatures[]"></td><td><button id="remove' + (next - 1) + '" class="btn float-end pull-right btn-danger btn-sm remove-me" >X</button></td></tr>';
        var newInput = $(newIn);
        var removeBtn = '';
        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);  
        
            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
    });
    $(".showonline").click(function(){
        $("#iframe-container").slideToggle();
    });
	});
	</script>    

<script src="<?php echo base_url();?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/feather-icons/feather.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins.js"></script>

<!-- prismjs plugin -->
<script src="<?php echo base_url();?>assets/libs/prismjs/prism.js"></script>

<script src="<?php echo base_url();?>assets/js/app.js"></script>
</body>
</html>












