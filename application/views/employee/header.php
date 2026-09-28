<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Employee Dashboard</title>
	<meta name="keywords" content="ADMIN" />
	<meta name="description" content="ADMIN">
	<meta name="author" content="satishlodhi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Google Web Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"> 
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="<?php echo base_url();?>adminassets/assets/css/bootstrap/bootstrap.min.css">
    <!-- Custom CSS Starts -->
    	
	<link rel="stylesheet" href="<?php echo base_url();?>adminassets/assets/css/tables/datatables.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>adminassets/assets/css/tables/buttons.dataTables.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>adminassets/assets/css/skin/all-skins.css">
	<link rel="stylesheet" href="<?php echo base_url();?>adminassets/assets/css/general/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>adminassets/assets/css/sidebar/side-nav.css">
	<link rel="stylesheet" href="<?php echo base_url();?>adminassets/assets/css/fonts/fonts-style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>adminassets/assets/css/nanoscroller/nanoscroller.css">
    <!-- Page CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>adminassets/assets/css/dashboard/dashboard1.css">
    <script src="<?php echo base_url();?>adminassets/assets/js/jquery/slim.min.js"></script>
    <!-- Popper.JS -->
    <script src="<?php echo base_url();?>adminassets/assets/js/jquery/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="<?php echo base_url();?>adminassets/assets/js/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>adminassets/assets/js/jquery/jquery.min.js"></script>
    <style>
	.tab-pane {background:#fafafa; padding:10px;}
	.nav-item{ border:1px solid grey;}
	</style>
</head>

<body class="sidebar-mini fixed skin-blue">
    <div class="wrapper">
		<!-- Header Section Starts -->
		<header class="main-header">
			<!-- Logo -->
			<a href="<?php echo base_url();?>admin" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><b>E</b>RP</span>
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg">Employee</span>
			</a>
			<nav class="navbar navbar-static-top">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<!-- Messages Section Starts-->
						<li class="dropdown messages-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-envelope-o"></i>
								<span class="label label-success">4</span>
							</a>
							<ul class="dropdown-menu">
								<li class="header">You have 4 messages</li>
								<li>
									<!-- Inner Menu Starts -->
									<ul class="menu">
										<!-- Message Area Starts -->
										<li>
											<a href="#">
												<h4>
													Support Team
													<small><i class="fa fa-clock-o"></i> 5 mins</small>
												</h4>
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
										<li>
											<a href="#">
												<h4>
													Perfectus Design Team
													<small><i class="fa fa-clock-o"></i> 2 hours</small>
												</h4>
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
										<li>
											<a href="#">
												<h4>
													Developers
													<small><i class="fa fa-clock-o"></i> Today</small>
												</h4>
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
										<li>
											<a href="#">
												<h4>
													Sales Department
													<small><i class="fa fa-clock-o"></i> Yesterday</small>
												</h4>
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
										<li>
											<a href="#">
												<h4>
													Reviewers
													<small><i class="fa fa-clock-o"></i> 2 days</small>
												</h4>
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
										<!-- Message Area Ends -->
									</ul>
								</li>
								<li class="footer"><a href="#">See All Messages</a></li>
							</ul>
						</li>
						<!-- Messages Section Ends -->
						<!-- Notifications Section Starts -->
						<li class="dropdown notifications-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-bell-o"></i>
								<span class="label label-warning">10</span>
							</a>
							<ul class="dropdown-menu">
								<li class="header">You have 10 notifications</li>
								<li>
									<!-- Inner Menu Starts -->
									<ul class="menu">
										<li>
											<a href="#">
												<i class="fa fa-users text-aqua"></i> 5 new members joined today
											</a>
										</li>
										<li>
											<a href="#">
												<i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
											</a>
										</li>
										<li>
											<a href="#">
												<i class="fa fa-users text-red"></i> 5 new members joined
											</a>
										</li>
										<li>
											<a href="#">
												<i class="fa fa-shopping-cart text-green"></i> 25 sales made
											</a>
										</li>
										<li>
											<a href="#">
												<i class="fa fa-user text-red"></i> You changed your username
											</a>
										</li>
									</ul>
								</li>
								<li class="footer"><a href="#">View all</a></li>
							</ul>
						</li>
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?php echo base_url().'assets/images/emps/'.$this->session->userdata("img");?>" class="user-image" alt="User Image">
								<span class="d-none d-sm-block"><?php echo $this->session->userdata("loggeduser");?></span>
							</a>
							<ul class="dropdown-menu">
								<!-- User Image Starts -->
								
								<!-- Menu Body Ends -->
								<!-- Menu Footer Starts -->
								<li class="user-footer">
									<div class="pull-left">
										<a href="#" class="btn btn-default btn-flat">Profile</a>
									</div>
									<div class="pull-right">
										<a href="<?php echo base_url().'employee/logout';?>" class="btn btn-default btn-flat">Sign out</a>
									</div>
								</li>
								<!-- Menu Footer Ends -->
							</ul>
						</li>
						<!-- User Account Section Ends -->
					</ul>
				</div>
			</nav>
		</header>
		<!-- Header Section Ends -->
		
		<!-- Sidebar Section Starts -->
		<aside class="main-sidebar">
			<div class="nano">
				<div class="nano-content">
					<ul class="sidebar-menu" data-widget="tree">
						<li class="header">MAIN NAVIGATION</li>
						
						<li>
							<a href="<?php echo base_url();?>employee">
								<i class="fa fa-dashboard"></i> <span>Dashboard</span>
							</a>
						</li>
                        
						<li class="treeview">
							<a href="#">
								<i class="fa fa-building"></i> <span>Manage Leads</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li><a href="<?php echo base_url().'employee/newlead';?>"><i class="fa fa-edit"></i> New Lead</a></li>
								<li><a href="<?php echo base_url().'employee/myleads';?>"><i class="fa fa-sitemap"></i> New Assigned Lead</a></li>
                        		<li><a href="<?php echo base_url().'employee/myleads/followups';?>"><i class="fa fa-list"></i> Follow Ups/Free Trials</a></li>
                        		<!--<li><a href="<?php // echo base_url().'employee/myleads/freetrials';?>"><i class="fa fa-list"></i> Free Trials</a></li>-->
                        		<li><a href="<?php echo base_url().'employee/oldleads';?>"><i class="fa fa-list"></i> Old Leads</a></li>
							</ul>
						</li>
                        <li>
							<a href="<?php echo base_url();?>employee/contracts">
								<i class="fa fa-inr"></i> <span>Trader Clients</span>
							</a>
						</li>
                        
                        <li>
							<a href="<?php echo base_url();?>employee/calls">
								<i class="fa fa-calendar"></i> <span>Calls</span>
							</a>
						</li>
                        
                        <li>
							<a href="<?php echo base_url();?>employee/report">
								<i class="fa fa-file-o"></i> <span>Report</span>
							</a>
						</li>
                        <!--<li class="treeview">
							<a href="#">
								<i class="fa fa-list"></i> <span>Manage Tasks</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li><a href="<?php // echo base_url().'employee/list_tasks';?>"><i class="fa fa-list"></i> Create/List All Tasks</a></li>
								<li><a href="<?php //echo base_url().'employee/tasks/new';?>"><i class="fa fa-list"></i> New Assigned</a></li>
								<li><a href="<?php //echo base_url().'employee/tasks/running';?>"><i class="fa fa-list"></i> Running Tasks</a></li>
								<li><a href="<?php //echo base_url().'employee/tasks/completed';?>"><i class="fa fa-list"></i> Completed Tasks</a></li>
							</ul>
						</li>
                        <li class="treeview">
							<a href="#">
								<i class="fa fa-calendar"></i> <span>My Leaves</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
                                <li><a href="<?php // base_url().'employee/applied_leaves/Pending';?>"><i class="fa fa-list"></i> Pending Leaves</a></li>
                        		<li><a href="<?php // base_url().'employee/applied_leaves';?>"><i class="fa fa-list"></i> Approved/Rejected Leaves</a></li>
							</ul>
						</li>
						<!--<li class="header">LABELS</li>
						<li><a href="#"><i class="fa fa-circle-o text-danger"></i> <span>Important</span></a></li>
						<li><a href="#"><i class="fa fa-circle-o text-warning"></i> <span>Warning</span></a></li>
						<li><a href="#"><i class="fa fa-circle-o text-info"></i> <span>Information</span></a></li>-->
					</ul>
				</div>
			</div>
		</aside>    