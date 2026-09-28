 <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f9f9f9;
        }
        
        .privacy-header {
            background-color: var(--primary-color);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
            border-bottom: 5px solid var(--secondary-color);
        }
        
        .privacy-header h1 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .last-updated {
            color: #bdc3c7;
            font-size: 1rem;
        }
        
        .privacy-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 2.5rem;
            margin-bottom: 3rem;
        }
        
        .section-title {
            color: var(--primary-color);
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .data-category {
            margin-bottom: 2rem;
            padding: 1.5rem;
            border-radius: 8px;
            background-color: var(--light-bg);
            border-left: 4px solid var(--secondary-color);
        }
        
        .data-category h5 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .data-category ul {
            padding-left: 1.2rem;
        }
        
        .data-category li {
            margin-bottom: 0.5rem;
        }
        
        .contact-box {
            background-color: var(--light-bg);
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 2rem;
            border-left: 4px solid var(--accent-color);
        }
        
        .footer-note {
            font-size: 0.9rem;
            color: #6c757d;
            text-align: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }
        
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 100;
            display: none;
        }
        
        .highlight {
            background-color: #fffacd;
            padding: 2px 5px;
            border-radius: 3px;
        }
        
        @media (max-width: 768px) {
            .privacy-container {
                padding: 1.5rem;
            }
            
            .privacy-header {
                padding: 2rem 0;
            }
            
            .privacy-header h1 {
                font-size: 1.8rem;
            }
        }
    </style>

<main>
        <!-- page-title-area start -->
        <div id="top-menu" class="page-title-area d-flex align-items-center"
            data-background="<?php echo base_url();?>site/img/bg/breadcrumb.jpg">
            <div class="container text-center">
                <div class="page-title">
                    <h2>Privacy Policy</h2>
                    
                </div>
            </div>
        </div>
    
    <!-- Main Content -->
       <section class="feature-area fe-about pos-rel pt-130 pb-95">
        <div class="privacy-container">
            <!-- Introduction -->
            <div class="mb-5">
                <p class="lead">
                    <span class="fw-bold">E KOSH TECH SOLUTIONS</span> is committed to protecting the privacy and security of the data handled through the E-KOSH TDS portal. This policy explains how we collect, use, and safeguard information provided by Drawing and Disbursing Officers (DDOs) and their respective departments.
                </p>
            </div>
            
            <!-- 1. DATA WE COLLECT -->
            <section class="mb-5">
                <h2 class="section-title">1. DATA WE COLLECT</h2>
                <p>To provide our services, we collect two categories of information:</p>
                
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="data-category h-100">
                            <h5><i class="fas fa-user-tie me-2"></i> A. DDO / Administrative Data</h5>
                            <ul>
                                <li><span class="fw-bold">Identity Info:</span> DDO Name, Designation, PAN, and Date of Birth.</li>
                                <li><span class="fw-bold">Office Info:</span> DDO Code, TAN, Office Name, and Principal Employer Name.</li>
                                <li><span class="fw-bold">Contact Info:</span> Mobile numbers and email addresses of the DDO and the In-charge Clerk.</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 mb-4">
                        <div class="data-category h-100">
                            <h5><i class="fas fa-users me-2"></i> B. Employee Payroll Data (Uploaded by the DDO)</h5>
                            <ul>
                                <li><span class="fw-bold">Identity:</span> Employee Name, Employee Code, Designation, and PAN.</li>
                                <li><span class="fw-bold">Financials:</span> Salary breakdown, allowances, and perquisites.</li>
                                <li><span class="fw-bold">Exemptions:</span> Investment declarations and proofs (under Section 80C, 80D, etc.).</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- 2. PURPOSE OF DATA PROCESSING -->
            <section class="mb-5">
                <h2 class="section-title">2. PURPOSE OF DATA PROCESSING</h2>
                <p>We process this data strictly for the following purposes:</p>
                
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item d-flex align-items-start">
                                <i class="fas fa-calculator text-primary me-3 mt-1"></i>
                                <div>To compute accurate Income Tax liability for employees.</div>
                            </li>
                            <li class="list-group-item d-flex align-items-start">
                                <i class="fas fa-file-invoice text-primary me-3 mt-1"></i>
                                <div>To generate data files required for filing TDS Returns (Form 24Q, 26Q, etc.).</div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-start">
                                <i class="fas fa-user-shield text-primary me-3 mt-1"></i>
                                <div>To verify the identity of the DDO for account security and recovery.</div>
                            </li>
                            <li class="list-group-item d-flex align-items-start">
                                <i class="fas fa-headset text-primary me-3 mt-1"></i>
                                <div>To provide technical support and statutory updates.</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            
            <!-- 3. DATA STORAGE AND SECURITY -->
            <section class="mb-5">
                <h2 class="section-title">3. DATA STORAGE AND SECURITY</h2>
                <p>As a <span class="highlight">"Data Processor"</span> for government departments, we implement high-level security:</p>
                
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-lock fa-3x mb-3 text-primary"></i>
                                <h5 class="card-title">Encryption</h5>
                                <p class="card-text">All sensitive data (PAN, Salary, DOB) is encrypted using 256-bit SSL encryption both at rest and during transit.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-server fa-3x mb-3 text-primary"></i>
                                <h5 class="card-title">Data Residency</h5>
                                <p class="card-text">All data is hosted on secure servers located within the territory of India, in compliance with local data sovereignty laws.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-user-lock fa-3x mb-3 text-primary"></i>
                                <h5 class="card-title">Access Control</h5>
                                <p class="card-text">Access to employee data is restricted to the registered DDO and authorized office staff only.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- 4. DATA SHARING AND DISCLOSURE -->
            <section class="mb-5">
                <h2 class="section-title">4. DATA SHARING AND DISCLOSURE</h2>
                
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-ban me-2"></i>
                    <strong>No Commercial Sharing:</strong> We do not sell, rent, or trade any personal or payroll data to third-party marketing or insurance firms.
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="border rounded p-3 h-100">
                            <h5><i class="fas fa-external-link-alt me-2"></i> Third-Party Filing</h5>
                            <p>Data is exported only upon the DDO's command for use in third-party software (e.g., ClearTDS, CompuTDS) or sharing with authorized Tax Consultants/CAs.</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="border rounded p-3 h-100">
                            <h5><i class="fas fa-gavel me-2"></i> Legal Requirement</h5>
                            <p>We may disclose information only if required by law or a valid government order (e.g., from the Income Tax Department).</p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- 5. DATA RETENTION & DELETION -->
            <section class="mb-5">
                <h2 class="section-title">5. DATA RETENTION & DELETION</h2>
                
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="text-center p-3">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-database fa-lg"></i>
                            </div>
                            <h5>Retention</h5>
                            <p>We retain data only as long as the DDO's account is active or as required for statutory audit purposes.</p>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="text-center p-3">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-user-edit fa-lg"></i>
                            </div>
                            <h5>User Control</h5>
                            <p>DDOs have the right to edit or delete employee records within the portal.</p>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="text-center p-3">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-trash-alt fa-lg"></i>
                            </div>
                            <h5>Purge Policy</h5>
                            <p>Upon formal request for account termination, all associated data will be permanently deleted from our servers within 90 days, subject to legal record-keeping requirements.</p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- 6. RIGHTS OF DATA PRINCIPALS -->
            <section class="mb-5">
                <h2 class="section-title">6. RIGHTS OF DATA PRINCIPALS</h2>
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Under the <strong>DPDP Act 2023</strong>, individuals (employees) have the right to seek correction or erasure of their data. Since the DDO is the primary "Data Fiduciary," employees should approach their respective DDO office for such requests, which we will then facilitate through our platform.
                </div>
            </section>
            
            <!-- 7. CONTACT OUR GRIEVANCE OFFICER -->
            <section class="mb-5">
                <h2 class="section-title">7. CONTACT OUR GRIEVANCE OFFICER</h2>
                <p>For any privacy concerns or data-related queries, please contact:</p>
                
                <div class="contact-box">
                    <h4><i class="fas fa-user-headset me-2"></i> Grievance Officer</h4>
                    <p class="fw-bold mb-1">E KOSH TECH SOLUTIONS</p>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                <strong>Email:</strong> <a href="mailto:info@ekoshtds.com">info@ekoshtds.com</a>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                <strong>Address:</strong>
                            </p>
                            <p class="ms-4 mb-0">
                                House Number 120, Ward Number 8,<br>
                                Bodla, District - KABIRDHAM,<br>
                                Chhattisgarh.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            
          
            
            <!-- Footer Note -->
            <div class="footer-note">
                <p>This Privacy Policy is effective as of January 26, 2026. E KOSH TECH SOLUTIONS reserves the right to update this policy periodically. Users will be notified of any significant changes.</p>
                <p class="mb-0">© 2026 E KOSH TECH SOLUTIONS. All rights reserved.</p>
            </div>
        </div>
    </main>
    