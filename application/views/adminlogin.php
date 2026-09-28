<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>Sign In | E-Kosh TDS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TDS Tools For Government DDOs">
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url();?>site/img/favicon.png">

    <!-- Layout config Js -->
    <script src="<?php echo base_url();?>assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url();?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo base_url();?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>

<body class="auth-bg 100-vh">
    <div class="bg-overlay bg-light"></div>

    <div class="account-pages">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="auth-full-page-content d-flex min-vh-100 py-sm-5 py-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100 py-0 py-xl-4">

                                <div class="text-center mb-5">
                                    <a href="<?php echo base_url();?>">
                                        <span class="logo-lg">
                                            <img src="<?php echo base_url();?>site/img/logo2.png" alt="" height="100">
                                        </span>
                                    </a>
                                </div>
                                
                                <?php if($_GET['msg']==1){?>
                                    <div class="alert alert-success">DDO Registered Successfully</div>
                                <?php }if($_GET['msg']==3){?>
                                    <div class="alert alert-danger">Incorrect Login Details</div>
                                <?php }?>

                                <!-- Message Div -->
                                <div id="messageDiv" class="hidden"></div>

                                <div class="card my-auto overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-lg-6">
                                            <div class="p-lg-5 p-4">
                                                <!-- Login Form -->
                                                <div id="loginForm">
                                                    <div class="text-center">
                                                        <h5 class="mb-0">Welcome Back !</h5>
                                                    </div>
                                                    
                                                    <div class="mt-4">
                                                        <form action="<?php echo base_url();?>home/adminlogin" method="post" class="auth-input">
                                                            <div class="mb-3">
                                                                <label for="username" class="form-label">Username</label>
                                                                <input type="text" class="form-control" name="username" required id="username" placeholder="Enter username">
                                                            </div>
                                                            
                                                            <div class="mb-2">
                                                                <a href="#" id="forgotpass" class="fw-medium pull-right end float-end text-danger text-decoration-underline"> Forgot Password</a>
                                                                <label for="userpassword" class="form-label">Password</label>
                                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                                    <input type="password" name="password" required class="form-control pe-5 password-input" placeholder="Enter password" id="password-input">
                                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="las la-eye align-middle fs-18"></i></button>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="mt-2">
                                                                <button class="btn btn-primary w-100" type="submit">Log In</button>
                                                            </div>
                                                            
                                                            <div class="mt-4 text-center">
                                                                <p class="mb-0">Join us ? 
                                                                    <a href="<?php echo base_url();?>home/register" class="fw-medium text-primary text-decoration-underline"> Create Account</a>
                                                                </p>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                
                                                <!-- Forgot Password Form -->
                                                <div id="forgotPasswordForm" class="hidden">
                                                    <div class="text-center">
                                                        <h5 class="mb-0">Reset Password</h5>
                                                        <p class="text-muted">Enter your email to receive reset link</p>
                                                    </div>
                                                    
                                                    <div class="mt-4">
                                                        <form id="emailForm" class="auth-input">
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Email Address</label>
                                                                <input type="email" class="form-control" name="email" required id="email" placeholder="Enter your email">
                                                            </div>
                                                            
                                                            <div class="mt-2">
                                                                <button class="btn btn-primary w-100" type="submit">Send Reset Link</button>
                                                            </div>
                                                            
                                                            <div class="mt-4 text-center">
                                                                <p class="mb-0">
                                                                    <a href="#" id="backToLogin" class="fw-medium text-primary text-decoration-underline">Back to Login</a>
                                                                </p>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                
                                                <!-- Reset Password Form -->
                                                <div id="resetPasswordForm" class="hidden">
                                                   
                                                    <div class="text-center">
                                                        <h5 class="mb-0">Create New Password</h5>
                                                        <p class="text-muted">Enter your new password</p>
                                                    </div>
                                                    
                                                    <div class="mt-4">
                                                        <form id="resetForm" class="auth-input">
                                                            <input type="hidden" id="resetemail" name="email">
                   
<div class="mb-3">
    <label for="newPassword" class="form-label">Enter OTP Sent to Your Email</label>
    <div class="position-relative auth-pass-inputgroup mb-3">
        <input type="number" name="otp" required class="form-control pe-5 password-input" placeholder="6 Digit OTP" id="otp">
    </div>
</div>

<div class="mb-3">
    <label for="newPassword" class="form-label">New Password</label>
    <div class="position-relative auth-pass-inputgroup mb-3">
        <input type="password" name="new_password" required class="form-control pe-5 password-input" placeholder="Enter new password" id="newPassword">
    </div>
</div>
                                                            
<div class="mb-3">
    <label for="confirmPassword" class="form-label">Confirm Password</label>
    <div class="position-relative auth-pass-inputgroup mb-3">
        <input type="password" name="confirm_password" required class="form-control pe-5 password-input" placeholder="Confirm password" id="confirmPassword">
    </div>
</div>
                                                            
                                                            <div class="mt-2">
                                                                <button class="btn btn-primary w-100" type="submit">Reset Password</button>
                                                            </div>
                                                            
                                                            <div class="mt-4 text-center">
                                                                <p class="mb-0">
                                                                    <a href="#" id="backToLogin2" class="fw-medium text-primary text-decoration-underline">Back to Login</a>
                                                                </p>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Right Side Carousel -->
                                        <div class="col-lg-6">
                                            <div class="d-flex h-100 bg-auth align-items-end">
                                                <div class="p-lg-5 p-4">
                                                    <div class="bg-overlay bg-primary"></div>
                                                    <div class="p-0 p-sm-4 px-xl-0 py-5">
                                                        <div id="reviewcarouselIndicators" class="carousel slide auth-carousel" data-bs-ride="carousel">
                                                            <div class="carousel-indicators carousel-indicators-rounded">
                                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                            </div>
                                                            
                                                            <div class="carousel-inner mx-auto">
                                                                <div class="carousel-item active">
                                                                    <div class="testi-contain text-center">
                                                                        <h5 class="fs-20 text-white mb-0">"I feel confident imposing on myself"</h5>
                                                                        <p class="fs-15 text-white-50 mb-0">Vestibulum auctor orci in risus iaculis consequat suscipit felis rutrum aliquet iaculis augue sed tempus In elementum ullamcorper lectus vitae pretium Nullam ultricies diam eu ultrices sagittis.</p>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="carousel-item">
                                                                    <div class="testi-contain text-center">
                                                                        <h5 class="fs-20 text-white mb-0">"Our task must be to free widening circle"</h5>
                                                                        <p class="fs-15 text-white-50 mb-0">Curabitur eget nulla eget augue dignissim condintum Nunc imperdiet ligula porttitor commodo elementum Vivamus justo risus fringilla suscipit faucibus orci luctus ultrices posuere cubilia curae ultricies cursus.</p>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="carousel-item">
                                                                    <div class="testi-contain text-center">
                                                                        <h5 class="fs-20 text-white mb-0">"I've learned that people forget what you"</h5>
                                                                        <p class="fs-15 text-white-50 mb-0">Pellentesque lacinia scelerisque arcu in aliquam augue molestie rutrum Fusce dignissim dolor id auctor accumsan vehicula dolor vivamus feugiat odio erat sed quis Donec nec scelerisque magna</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="<?php echo base_url();?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url();?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?php echo base_url();?>assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/plugins.js"></script>
    <script src="<?php echo base_url();?>assets/js/pages/password-addon.init.js"></script>

    <script>
    $(document).ready(function() {
        // Show forgot password form
        $('#forgotpass').click(function(e) {
            e.preventDefault();
            $('#loginForm').addClass('hidden');
            $('#forgotPasswordForm').removeClass('hidden');
        });
        
        // Back to login from forgot password
        $('#backToLogin, #backToLogin2').click(function(e) {
            e.preventDefault();
            $('#forgotPasswordForm').addClass('hidden');
            $('#resetPasswordForm').addClass('hidden');
            $('#loginForm').removeClass('hidden');
            clearMessages();
        });
        
        // Submit email for password reset
        $('#emailForm').submit(function(e) {
            e.preventDefault();
            
            var email = $('#email').val();
            
            if (!email) {
                showMessage('Please enter your email address', 'danger');
                return;
            }
            
            // Show loading
            showMessage('Sending reset link...', 'info');
           
            // AJAX call to send reset email
            $.ajax({
                url: '<?php echo base_url();?>home/reset_password', // Update with your actual API endpoint
                type: 'POST',
                data: { email: email },
                success: function(response) {
                   // alert(response);
                    if (response!=0) {
                        // Show reset password form
                        $('#forgotPasswordForm').addClass('hidden');
                        $('#resetPasswordForm').removeClass('hidden');
                        $('#resetemail').val(email); // Use token or email as identifier
                        showMessage(response.message || 'Reset Code Sent to your email.', 'success');
                    } else {
                        showMessage(response.message || 'Email ID Not Registered', 'danger');
                    }
                },
                error: function() {
                    showMessage('Network error. Please try again.', 'danger');
                }
            });
        });
        
        // Submit new password
        $('#resetForm').submit(function(e) {
            e.preventDefault();
            
            var newPassword = $('#newPassword').val();
            var confirmPassword = $('#confirmPassword').val();
            var token = $('#resetemail').val();
            var otp = $('#otp').val();
            
            if (!newPassword || !confirmPassword) {
                showMessage('Please fill all password fields', 'danger');
                return;
            }
            
            if (newPassword !== confirmPassword) {
                showMessage('Passwords do not match', 'danger');
                return;
            }
            
            // Show loading
            showMessage('Resetting password...', 'info');
            
            // AJAX call to reset password
            $.ajax({
                url: '<?php echo base_url();?>home/reset_password2', // Update with your actual API endpoint
                type: 'POST',
                data: {
                    email: token,otp:otp,
                    new_password: newPassword,
                    confirm_password: confirmPassword
                },
                success: function(response) {
                    if (response==0) {
                        showMessage(response.message || 'Password reset successfully!', 'success');
                        
                        // Auto redirect to login after 2 seconds
                        setTimeout(function() {
                            $('#resetPasswordForm').addClass('hidden');
                            $('#loginForm').removeClass('hidden');
                            clearMessages();
                            // Clear form
                            $('#resetForm')[0].reset();
                        }, 2000);
                    } else {
                        alert(response);
                    }
                },
                error: function() {
                    showMessage('Network error. Please try again.', 'danger');
                }
            });
        });
        
        // Function to show messages
        function showMessage(message, type) {
            var messageDiv = $('#messageDiv');
            messageDiv.removeClass('hidden alert-success alert-danger alert-info')
                     .addClass('alert alert-' + type)
                     .html(message);
        }
        
        // Function to clear messages
        function clearMessages() {
            $('#messageDiv').addClass('hidden').removeClass('alert-success alert-danger alert-info').html('');
        }
        
        // Toggle password visibility
        $(document).on('click', '.password-addon', function() {
            var input = $(this).closest('.auth-pass-inputgroup').find('.password-input');
            var icon = $(this).find('i');
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('la-eye').addClass('la-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('la-eye-slash').addClass('la-eye');
            }
        });
    });
    </script>
</body>
</html>