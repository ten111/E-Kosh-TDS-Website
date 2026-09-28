<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin Login</title>
	<meta name="keywords" content="ERP" />
	<meta name="description" content="ERP">
	<meta name="author" content="satish lodhi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Google Web Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"> 
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="<?php echo base_url();?>adminassets/assets/css/bootstrap/bootstrap.min.css">
	<!-- Page CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>adminassets/assets/css/custompages/login1.css">
	<!-- Fonts CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>adminassets/assets/css/fonts/fonts-style.css">
</head>

<body class="bg-login">
    <div class="wrapper">
		<!-- Page Content Starts-->
		<div class="content-wrapper">
			<div class="mx-auto login">
				<a href="#"><img src="<?php echo base_url();?>adminassets/assets/images/logo-signin.png" class="img-circle" alt="Logo Image"></a>
				<div class="card card-signin mt-4">
					<div class="card-body">
						<h5 class="card-title text-center">Employee Login</h5>
						<?php  if($this->session->flashdata("msg")){?>
                          <div class="alert alert-danger alert-bordered">
                                <strong><?php echo $this->session->flashdata("msg");?>!</strong> 
                            </div>
						  	<?php }?>
                           <form class="form-horizontal" action="<?php echo base_url();?>home/emplogin" method="post">
                                <div class="form-label-group">
                                    <input type="text" class="form-control" name="username" required placeholder="Email/Mobile">
                                </div>
                                <div class="form-label-group">
                                    <input type="password" class="form-control" name="password" required placeholder="Password">
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Sign In</button>
							</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Page Content Ends-->
	</div>

	<!-- Bootstrap JS -->
	<script src="<?php echo base_url();?>adminassets/assets/js/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/bootstrap/bootstrap.min.js"></script>
</body>
</html>