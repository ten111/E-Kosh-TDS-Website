
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>Dashboard <?php echo $this->session->userdata("userid");?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TDS Tools For Government DDOs">
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico">
    <link href="<?php echo base_url();?>assets/libs/jsvectormap/jsvectormap.min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url();?>assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url();?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo base_url();?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url();?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    $(document).ready(function(){
        <?php if($this->uri->segment(2)=='empdata'){?>
            $("#topnav-hamburger-icon").trigger("click");
        <?php }?>
    });
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/6849e5b500b313190f832321/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="<?php echo base_url();?>admin" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?php echo base_url();?>site/img/logo2.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo base_url();?>site/img/logo2.png" alt="" height="21">
                        </span>
                    </a>

                    <a href="<?php echo base_url();?>admin" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?php echo base_url();?>site/img/logo2.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo base_url();?>site/img/logo2.png" alt="" height="21">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>


            </div>

            <div class="d-flex align-items-center">

                 


               

                

                <div style="display:none;" class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-primary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class='las la-bell fs-24'></i>
                        <span class="position-absolute topbar-badge fs-9 translate-middle badge rounded-pill bg-danger">3<span class="visually-hidden">unread messages</span></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head rounded-top">
                            <div class="p-3 bg-primary bg-pattern">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge bg-light-subtle text-light  fs-13"> 4 New</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2">
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-info-subtle text-info   text-info rounded-circle fs-16">
                                                    <i class="bx bx-badge-check"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 fs-14 mb-2 lh-base">Your <b>Elite</b> author Graphic
                                                        Optimization <span class="text-secondary">reward</span> is
                                                        ready!
                                                    </h6>
                                                </a>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> Just 30 sec ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="all-notification-check01">
                                                    <label class="form-check-label" for="all-notification-check01"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                            <img src="<?php echo base_url();?>assets/images/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-14 fw-semibold">Angela Bernier</h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">Answered to your comment on the cash flow forecast's
                                                        graph 🔔.</p>
                                                </div>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 48 min ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="all-notification-check02">
                                                    <label class="form-check-label" for="all-notification-check02"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-danger-subtle text-danger  text-danger rounded-circle fs-16">
                                                    <i class='bx bx-message-square-dots'></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-2 fs-13 lh-base">You have received <b class="text-success">20</b> new messages in the conversation
                                                    </h6>
                                                </a>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 2 hrs ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="all-notification-check03">
                                                    <label class="form-check-label" for="all-notification-check03"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                            <img src="<?php echo base_url();?>assets/images/users/avatar-8.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-14 fw-semibold">Maureen Gibson</h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">We talked about a project on linkedin.</p>
                                                </div>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 4 hrs ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="all-notification-check04">
                                                    <label class="form-check-label" for="all-notification-check04"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="my-3 text-center view-all">
                                        <button type="button" class="btn btn-soft-success btn-sm waves-effect waves-light">View
                                            All Notifications <i class="ri-arrow-right-line align-middle"></i></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="dropdown header-item">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <?php if($this->session->userdata("type")=='admin'){?>
                            <img class="rounded-circle header-profile-user" 
                            src="<?php echo base_url().'assets/images/users/user-dummy-img.jpg';?>" alt="Image">
                            <?php }else{?>
                            <img class="rounded-circle header-profile-user" 
                            src="<?php echo base_url().'assets/images/signs/'.$this->session->userdata("img");?>" alt="Image"><?php }?>
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block fw-medium user-name-text fs-16"><?php echo ucfirst($this->session->userdata("loggeduser")).'-'.$this->session->userdata("ddo_num");?> <i class="las la-angle-down fs-12 ms-1"></i></span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a class="dropdown-item" href="<?php echo base_url();?>admin/profile"><i class="bx bx-user fs-15 align-middle me-1"></i> <span key="t-profile">Profile Settings</span></a>
                        <!-- <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">11</span><i class="bx bx-wrench fs-15 align-middle me-1"></i> <span key="t-settings">Settings</span></a> -->
                        
                        <div class="dropdown-divider"></div>
                        
						<?php if($this->session->userdata("type2")=='admin'){?>
                            <a class="dropdown-item text-danger" href="<?php echo base_url().'admin/switch_admin';?>"><i class="bx bx-switch fs-15 align-middle me-1 text-danger"></i> <span key="t-logout">Switch to Admin</span></a><?php }?>
                        <a class="dropdown-item text-danger" href="<?php echo base_url().'admin/logout';?>"><i class="bx bx-power-off fs-15 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="<?php echo base_url();?>admin" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?php echo base_url();?>site/img/logo2.png" alt="" height="70">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo base_url();?>site/img/logo2.png" alt="" height="70">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="<?php echo base_url();?>admin" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?php echo base_url();?>site/img/logo2.png" alt="" height="70">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo base_url();?>site/img/logo2.png" alt="" height="70">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        
						<li  class="nav-item">
							<a class="nav-link menu-link"  href="<?php echo base_url();?>admin">
								<i class="las la-home"></i> <span>Dashboard</span>
							</a>
						</li>
						<?php if($this->session->userdata("type")=='admin'){?>
						<li  class="nav-item">
							<a  class="nav-link menu-link" href="<?php echo base_url();?>admin/branches">
								<i class="las la-list"></i> <span>Clients</span>
							</a>
						</li>
						<li class="nav-item">
							<a  class="nav-link menu-link" href="<?php echo base_url();?>admin/plans">
								<i class="las la-table"></i> <span>Subscription Plans</span>
							</a>
						</li>
						<?php }else{?>
						
						<li class="nav-item">
							<a class="nav-link menu-link" href="<?php echo base_url();?>admin/empdata/2026-27">
								<i class="las la-calendar"></i> <span>Monthly Salary Data</span>
							</a>
						</li>
                        <li class="nav-item">
							<a class="nav-link menu-link" href="<?php echo base_url().'admin/salary/2026_27/salary';?>">
								<i class="las la-file-invoice"></i> <span>Annual Salary</span>
							</a>
						</li>
						<li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarInvoiceManagement" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarInvoiceManagement">
                                <i class="las la-file-invoice"></i> <span data-key="t-invoices">Tax Computation Reports</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarInvoiceManagement">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <?php 
                                        $this->db->select("dt_fnyr,dt_client");
                                        $this->db->group_by("dt_fnyr");
                                        $this->db->from("emp_data");
                                        $this->db->where("dt_client",$this->session->userdata("userid"));
                                        $this->db->order_by("emp_data.dt_id","desc");
                                        $fnyrs=$this->db->get()->result();
                                        foreach($fnyrs as $fn){?>
                                        <a href="<?php echo base_url().'admin/itr1/'.$fn->dt_fnyr;?>" class="nav-link" data-key="t-invoice">Tax Computation Report (<?php echo str_replace("_","-",$fn->dt_fnyr);?>)</a>
                                        <?php }?>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarInvoiceManagement2" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarInvoiceManagement">
                                <i class="las la-file-invoice"></i> <span data-key="t-invoices">TDS Reports</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarInvoiceManagement2">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <?php 
                                        
                                        foreach($fnyrs as $fn){?>
                                        <a href="<?php echo base_url().'admin/tds_reports/'.$fn->dt_fnyr.'/1';?>" class="nav-link" data-key="t-invoice"> TDS REPORT (<?php echo str_replace("_","-",$fn->dt_fnyr);?>)</a>
                                        <?php }?>
                                    </li>
                                    
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
							<a  class="nav-link menu-link" href="<?php echo base_url();?>admin/list_employees">
								<i class="las la-users"></i> <span>Employee Details Reports (<?php echo $this->db->get_where("emps",array("emp_client"=>$this->session->userdata("userid")))->num_rows();?>)</span>
							</a>
						</li>
                        <li class="nav-item">
							<a  class="nav-link menu-link" href="<?php echo base_url();?>admin/old_employees">
								<i class="las la-users"></i> <span>Old Employee (<?php echo $this->db->get_where("emp_history",array("emp_hddo1"=>$this->session->userdata("userid")))->num_rows();?>)</span>
							</a>
						</li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarInvoiceManagement1" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarInvoiceManagement">
                                <i class="las la-file-invoice"></i> <span data-key="t-invoices">Important Links</span>
                            </a>
                            <div class="collapse menu-dropdown show" id="sidebarInvoiceManagement1">
                                <ul class="nav nav-sm flex-column">
         <!-- <li class="nav-item"><a  href="<?php //echo base_url().'admin/importdata';?>" class="nav-link" data-key="t-invoice"> Import Employee</a></li> -->
         <li class="nav-item"><a target="_blank" href="https://ekoshonline.cg.gov.in/newepayroll" class="nav-link" data-key="t-invoice"> E-Payroll</a></li>
         <li class="nav-item"><a target="_blank" href="https://ekoshonline.cg.gov.in" class="nav-link" data-key="t-invoice"> E-Kosh Online</a></li>
         <li class="nav-item"><a target="_blank" href="https://onlineservices.tin.egov.proteantech.in/TIN/JSP/etbaf/ViewBIN.jsp" class="nav-link" data-key="t-invoice"> BIN View</a></li>
         <li class="nav-item"><a target="_blank" href="https://ekoshonline.cg.gov.in/eBill" class="nav-link" data-key="t-invoice"> E-Bill</a></li>     
         <li class="nav-item"><a download href="<?php echo base_url().'assets/Smart_PDF_Page_Merger_Setup_v1_0.exe';?>" class="nav-link" data-key="t-invoice"> Pdf Merge Tool</a></li>        
         <li class="nav-item"><a download href="<?php echo base_url().'assets/Setup_E_Kosh_TDS_Payroll_Tool.exe';?>" class="nav-link" data-key="t-invoice">  Download E Kosh TDS Payroll Tool </a></li>                                
                                </ul>
                            </div>
                        </li>

                        <?php }?>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>


