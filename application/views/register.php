<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>New Account E Kosh TDS</title>
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
    <?php if($_GET['msg'] && $_GET['msg']==0){?>
                        <div class="alert alert-danger">DDO Number Already Registered</div>
                        <?php }?>
                                    <div class="card my-auto overflow-hidden">
                                            <div class="row g-0">
                                                <div class="col-lg-6">
                                                    <div class="p-lg-5 p-4">
                                                        <div class="text-center">
                                                            <h5 class="mb-0">Welcome Back !</h5>
                                                            <p class="text-muted mt-2">Sign in to continue to Your EKosh Account</p>
                                                        </div>
                                                    
                                                        <div class="mt-4">
                                                        <form action="<?php echo base_url();?>home/register_client" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="cemp_added" value="<?php echo date("Y-m-d");?>" />
                            <div class="form-group "> 
                                <label for="email">Select Plan</label>
                              
                            <select required name="client_plan" class="form-control">
                                  <?php $data = $this->db->get("plan")->result_array();
                            foreach ($data as $c) {?>
                                <option value="<?php echo $c['plan_id'];?>"><?php echo $c['plan_name'];?></option>
                               <?php  }?>
                            </select>
                              </div> 
                            <div class="form-group "> 
                                <label for="email">Name of DDO</label>
                                <input type="text" required class="form-control" name="ddo_name">
                              </div>
                              <div class="row">
                                  <div class="form-group col-md-6">
                                    <label for="email">DDO Number</label>
                                    <input type="text" required class="form-control" name="ddo_num">
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="email">DDO TAN</label>
                                    <input type="text"  class="form-control" name="tan_num" required>
                                  </div>
                              </div>

                              <div class="form-group ">
                                <label for="email">Phone</label>
                                <input type="text"  class="form-control" name="client_mob" required>
                              </div>
                              <div class="form-group ">
                                <label for="email">Email</label>
                                <input type="email"  class="form-control" name="client_email" required>
                              </div>
                              <div class="form-group ">
                                <label for="email">Account Password</label>
                                <input type="text"  class="form-control" name="cemp_pass" required>
                              </div>

                              <div class="form-group"> 
                                <label for="email">Name of Pricipal Employer</label>
                                <input type="text" required class="form-control" name="cemp_name">
                              </div>
                              
                              <div class="form-group"> 
                                <label for="email">Clerk Name</label>
                                <input type="text" required class="form-control" name="clerk_name">
                              </div>
                              <div class="form-group"> 
                                <label for="email">Clerk Phone</label>
                                <input type="text" required class="form-control"  name="clerk_mob">
                              </div>
                              <div class="row">
                                  <div class="form-group col-md-6">
                                    <label for="email">PAN of Employer</label>
                                    <input type="text"  class="form-control" name="cemp_pan" required>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="email">DOB of Employer</label>
                                    <input type="text"  class="form-control" name="cemp_dob" required>
                                  </div>
                              </div>
                              <div class="mt-2">
                                                                    <button class="btn btn-primary w-100" type="submit">SUBMIT</button>
                                                                </div>
                                                                <div class="mt-4 text-center">
                                                                    <p class="mb-0">Back to 
                                                                        <a href="<?php echo base_url();?>home/admin" class="fw-medium text-primary text-decoration-underline"> Login</a> </p>
                                                                </div>
                            </form>

                                                        </div>
                                    
                                                    </div>
                                                </div>
                    
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
                                                                
                                                                    <!-- end carouselIndicators -->
                                                                    <div class="carousel-inner mx-auto">
                                                                        <div class="carousel-item active">
                                                                            <div class="testi-contain text-center">
                                                                                <h5 class="fs-20 text-white mb-0">“I feel confident
                                                                                    imposing
                                                                                    on myself”
                                                                                </h5>
                                                                                <p class="fs-15 text-white-50 mt-2 mb-0">Vestibulum auctor orci in risus iaculis consequat suscipit felis rutrum aliquet iaculis
                                                                                    augue sed tempus In elementum ullamcorper lectus vitae pretium Nullam ultricies diam
                                                                                    eu ultrices sagittis.</p>
                                                                            </div>
                                                                        </div>
                        
                                                                        <div class="carousel-item">
                                                                            <div class="testi-contain text-center">
                                                                                <h5 class="fs-20 text-white mb-0">“Our task must be to
                                                                                    free widening circle”</h5>
                                                                                <p class="fs-15 text-white-50 mt-2 mb-0">
                                                                                    Curabitur eget nulla eget augue dignissim condintum Nunc imperdiet ligula porttitor commodo elementum
                                                                                    Vivamus justo risus fringilla suscipit faucibus orci luctus
                                                                                    ultrices posuere cubilia curae ultricies cursus.
                                                                                </p>
                                                                            </div>
                                                                        </div>
                        
                                                                        <div class="carousel-item">
                                                                            <div class="testi-contain text-center">
                                                                                <h5 class="fs-20 text-white mb-0">“I've learned that
                                                                                    people forget what you”</h5>
                                                                                <p class="fs-15 text-white-50 mt-2 mb-0">
                                                                                    Pellentesque lacinia scelerisque arcu in aliquam augue molestie rutrum Fusce dignissim dolor id auctor accumsan
                                                                                    vehicula dolor
                                                                                    vivamus feugiat odio erat sed  quis Donec nec scelerisque magna
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end carousel-inner -->
                                                                </div>
                                                                <!-- end review carousel -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                        </div>
                                    </div>
                                    <!-- end card -->
                                    
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>

    <!-- JAVASCRIPT -->
    <script src="<?php echo base_url();?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url();?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?php echo base_url();?>assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/plugins.js"></script>

    <!-- password-addon init -->
    <script src="<?php echo base_url();?>assets/js/pages/password-addon.init.js"></script>

</body>
</html>











