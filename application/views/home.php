<main>
        <!--hero-area start-->
        <div class="hero-area hero-area-03 pos-rel black-bg3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xxl-5 col-xl-6 col-lg-6">
                        <div class="hero__content hero__content__03 text-left mb-30">
                            <h2 class="mb-30 wow fadeInUp2 animated text-white" data-wow-delay=".2s">Organize your employee's tax liability easily</h2>
                            <p style="text-align:justify;" class="wow fadeInUp2" data-wow-delay=".4s"> Organize your employee's tax liability easily.
E-Kosh TDS software simplifies tax management for your DDO by providing accurate estimates of your employees' tax liabilities throughout the year. With intelligent automation, it not only helps in tracking monthly deductions but also calculates the final tax liability at the end of the financial year—ensuring compliance, efficiency, and peace of mind.</p>
                            <ul class="btn-list mt-40 wow fadeInUp2 animated" data-wow-delay=".6s">
                                <li><a class="theme_btn theme_btn_03 theme_btn_bg" href="<?php echo base_url();?>register">start free trial <i
                                            class="fas fa-chevron-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xxl-7 col-xl-6 col-lg-6">
                        <div class="hero_right_img_03 wow zoomIn animated" data-wow-delay="0.3s">
                            <img src="<?php echo base_url();?>site/img/slider/slider3.png" alt="">
                        </div>
                    </div>%20
                </div>
            </div>
        </div>


        <section class="what-we-do-area pa-bottom pt-125 pb-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-7 col-xl-7">
                        <div class="section-title text-center pr-50 pl-50 mb-80">
                            <h5>Core Features</h5>
                            <h2>Built for Simplicity, Powered by Accuracy</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
                        <div class="do_box text-center mb-30">
                            <div class="do_box__icon mb-25">
                                <i class="flaticon-layers-1"></i>
                            </div>
                            <h4>Data Import & Validation</h4>
                            
                            <a href="#"><i class="far fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
                        <div class="do_box text-center mb-30">
                            <div class="do_box__icon mb-25">
                                <i class="flaticon-chart"></i>
                            </div>
                            <h4>ITR 1 Calculation Engine</h4>
                            <a href="#"><i class="far fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
                        <div class="do_box text-center mb-30">
                            <div class="do_box__icon mb-25">
                                <i class="flaticon-pie-chart"></i>
                            </div>
                            <h4>PDF Generation</h4>
                            <a href="#"><i class="far fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
                        <div class="do_box text-center mb-30">
                            <div class="do_box__icon mb-25">
                                <i class="fal fa-user-circle"></i>
                            </div>
                            <h4>User Access & Control</h4>
                            <a href="#"><i class="far fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--hero-area end-->
        <!--feature-area-02 start-->
        <section class="feature-area-03 pt-125 pb-65">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                        <div class="feature_img_03 mb-30">
                            <img class="img-fluid" src="<?php echo base_url();?>site/img/feature/04.png" alt="">
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                        <div class="feature_wrapper_03 mb-30 pl-100 pr-100">
                            <div class="section-title blue-title text-left mb-45 wow fadeInUp2 animated"
                                data-wow-delay="0.1s">
                                <h5 class="wow fadeInUp2 animated" data-wow-delay="0.1s">Admin Panel Section</h5>
                                <h2 class="wow fadeInUp2 animated" data-wow-delay="0.1s">Streamlined Experience for End Users</h2>
                                <p class="mt-30 wow fadeInUp2 animated" data-wow-delay="0.1s">Everything a user needs—intuitive, accessible, and secure.</p>
                            </div>
                            <ul class="features_list mb-40 wow fadeInUp2 animated" data-wow-delay="0.1s">
                                <li>Upload data files and validate them in real-time</li>
                                <li>Run ITR-1 calculations with detailed results</li>
                                <li>Download personalized tax PDFs instantly</li>
                                <li>Access help resources and get support when needed</li>
                                <li>Manage subscriptions and payments in one place</li>
                            </ul>
                            <a href="<?php echo base_url();?>contact" class="theme_btn theme_btn_03 theme_btn_bg wow fadeInUp2 animated"
                                data-wow-delay="0.1s">Learn more <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="plan-area pt-125">
            <div class="container">
                <div class="plan-wrapper">
                            <div class="section-title pt-185 mb-30">
                                <h5>Our Pricing Plan</h5>
                                <h2>Simple, Scalable Pricing for Every DDO</h2>
                                <p class="pt-30">Choose a yearly plan designed to match the size of your Drawing and Disbursing Office (DDO). Whether you're managing a small team or a large workforce, our flexible pricing ensures you only pay for what you need — no hidden fees, just transparent value.</p>
                            </div>

                            <div class="row pb-100">
                            <?php $data = $this->db->get("plan")->result_array();
                            foreach ($data as $c) { ?>
                                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
                                                <div class="plan pos-rel actives text-center mb-30">
                                                    <!-- <div class="plan__tag">popular</div> -->
                                                    <div class="pr_head">
                                                        <h3><?php echo $c['plan_name']; ?></h3>
                                                        <h2><sup>₹</sup><?php echo $c['plan_price']; ?></h2>
                                                        <span>1 Year</span>
                                                    </div>
                                                    <div class="pr_body mb-30">
                                                        <ul class="pr_list">
                                                        <?php $i=0; $pfs=explode("|",$c['plan_desc']);
                                foreach($pfs as $pf){?>
                             <li><?php echo $pf;?></li>

                                                            <?php }?>
                                                        </ul>
                                                    </div>
                                                    <div class="pr_footer">
                                                        <a href="#" class="theme_btn pr_btn">try this package
                                                            <i class="fas fa-chevron-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }?>
                                        </div>
                </div>
                <div class="has-plan-border">
                    <div class="border-bottom"></div>
                </div>
            </div>
        </section>
        <!--feature-area-02 end-->
        <!--services-area start-->
        <section class="services-area services-area-pb grey-bg pt-125 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-6 offset-xxl-3 col-xl-8 offset-xl-2">
                        <div class="section-title blue-title text-center mb-30">
                            <h5>Core Features</h5>
                            <h2>We create software for your
                                business solutions</h2>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs kw-services-nav" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true"><i class="flaticon-product"></i> Easy coding </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false"><i class="flaticon-product-release"></i>
                            Multiple index</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab"
                            aria-controls="contact" aria-selected="false"><i class="flaticon-web-programming"></i>
                            Customize & maintenance</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="customize-tab" data-bs-toggle="tab" href="#customize" role="tab"
                            aria-controls="contact" aria-selected="false"><i class="flaticon-solutions"></i> Creative &
                            unique</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row align-items-center mt-55">
                            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-12">
                                <div class="feature_wrapper_02 mb-30">
                                    <div class="section-title text-left mb-35">
                                        <h5>Progress & Customizations</h5>
                                        <h2>Discover & growth
                                            with analysis</h2>
                                        <p class="mt-30">But must explain to you how all this mistaken denouncing
                                            praising pain was born and I will give complete </p>
                                    </div>
                                    <a href="<?php echo base_url();?>contact" class="theme_btn theme_btn_03 theme_btn_bg">Learn more <i
                                            class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                            <div class="col-xxl-8 col-xl-7 col-lg-6 col-md-12">
                                <div class="feature_img_02 f-padding text-end mb-30">
                                    <img class="img-fluid" src="<?php echo base_url();?>site/img/feature/02.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row align-items-center mt-55">
                            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-12">
                                <div class="feature_wrapper_02 mb-30">
                                    <div class="section-title text-left mb-35">
                                        <h5>Progress & Customizations</h5>
                                        <h2>Discover & growth
                                            with analysis</h2>
                                        <p class="mt-30">But must explain to you how all this mistaken denouncing
                                            praising pain was born and I will give complete </p>
                                    </div>
                                    <a href="<?php echo base_url();?>contact" class="theme_btn theme_btn_03 theme_btn_bg">Learn more <i
                                            class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                            <div class="col-xxl-8 col-xl-7 col-lg-6 col-md-12">
                                <div class="feature_img_02 text-end mb-30">
                                    <img class="img-fluid" src="<?php echo base_url();?>site/img/feature/02.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="row align-items-center mt-55">
                            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-12">
                                <div class="feature_wrapper_02 mb-30">
                                    <div class="section-title text-left mb-35">
                                        <h5>Progress & Customizations</h5>
                                        <h2>Discover & growth
                                            with analysis</h2>
                                        <p class="mt-30">But must explain to you how all this mistaken denouncing
                                            praising pain was born and I will give complete </p>
                                    </div>
                                    <a href="<?php echo base_url();?>contact" class="theme_btn theme_btn_03 theme_btn_bg">Learn more <i
                                            class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                            <div class="col-xxl-8 col-xl-7 col-lg-6 col-md-12">
                                <div class="feature_img_02 text-end mb-30">
                                    <img class="img-fluid" src="<?php echo base_url();?>site/img/feature/02.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="customize" role="tabpanel" aria-labelledby="customize-tab">
                        <div class="row align-items-center mt-55">
                            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-12">
                                <div class="feature_wrapper_02 mb-30">
                                    <div class="section-title text-left mb-35">
                                        <h5>Progress & Customizations</h5>
                                        <h2>Discover & growth
                                            with analysis</h2>
                                        <p class="mt-30">But must explain to you how all this mistaken denouncing
                                            praising pain was born and I will give complete </p>
                                    </div>
                                    <a href="<?php echo base_url();?>contact" class="theme_btn theme_btn_03 theme_btn_bg">Learn more <i
                                            class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                            <div class="col-xxl-8 col-xl-7 col-lg-6 col-md-12">
                                <div class="feature_img_02 text-end mb-30">
                                    <img class="img-fluid" src="<?php echo base_url();?>site/img/feature/02.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--services-area end-->
        <!--process-area start-->
        <section class="process-area pt-125 pb-55">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-6 offset-xxl-3 col-xl-8 offset-xl-2">
                        <div class="section-title blue-title text-center mb-70">
                            <h5>Working Process</h5>
                            <h2>Manage software solutions
                                about some steps</h2>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                        <div class="process_02 text-center mb-30">
                            <div class="process_02__icon mb-55 wow zoomIn animated" data-wow-delay="0.1">
                                <i class="flaticon-booking"></i>
                            </div>
                            <h4 class="mb-20">Install apps for desktop</h4>
                            <p>Quis autem vel eum iure reprehenderit quinea voluptate velit</p>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                        <div class="process_02 text-center mb-30">
                            <div class="process_02__icon mb-55 wow zoomIn animated" data-wow-delay="0.1">
                                <i class="flaticon-booking"></i>
                            </div>
                            <h4 class="mb-20">Analysis for solutions</h4>
                            <p>Quis autem vel eum iure reprehenderit quinea voluptate velit</p>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                        <div class="process_02 text-center mb-30">
                            <div class="process_02__icon mb-55  wow zoomIn animated" data-wow-delay="0.1">
                                <i class="flaticon-booking"></i>
                            </div>
                            <h4 class="mb-20">Get final result</h4>
                            <p>Quis autem vel eum iure reprehenderit quinea voluptate velit</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--process-area end-->
        <!--benefit-area start-->
        <section class="benefit-area pos-rel pb-75">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xxl-7 col-xl-6 col-lg-6 col-md-12">
                        <div class="benefit-img mb-30 wow fadeInLeft animated" data-wow-delay="0.2s">
                            <img src="<?php echo base_url();?>site/img/feature/05.png" alt="">
                        </div>
                    </div>
                    <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-12">
                        <div class="benefit-wrapper mb-30">
                            <div class="section-title blue-title mb-30 wow fadeInUp2 animated" data-wow-delay="0.1s">
                                <h5>Benefit Our Software</h5>
                                <h2 class="mb-40">Design & development
                                    so much easier</h2>
                                <p>Sed perspiciatis unde omnis iste natus error sit voluptatem tium
                                    doloremque laudantium, totam rem aperiam, eaque ipsa quae abillo inventore
                                    architecto beatae</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--benefit-area end-->
        <!--download-area start-->
        <section class="download-area pos-rel pt-125 pb-130">
            <div class="download-shape d-none d-sm-inline-block"></div>
            <img class="shape-two d-none d-sm-inline-block" src="<?php echo base_url();?>site/img/shape/10.png" alt="">
            <img class="shape-three d-none d-sm-inline-block" src="<?php echo base_url();?>site/img/shape/06.png" alt="">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-8 col-xl-8 offset-xxl-2 offset-xl-2 wow fadeInUp2 animated"
                        data-wow-delay="0.1s">
                        <div class="download_wrapper">
                            <div class="section-title white-title text-center mb-50">
                                <h5 class="wow fadeInUp2 animated" data-wow-delay="0.1s">Available On Mobile Apps</h5>
                                <h2 class="wow fadeInUp2 animated" data-wow-delay="0.1s">Avaiable on Play Store,
                                    download easily</h2>
                            </div>
                            <ul class="btn-list download_btn d-sm-flex justify-content-center mt-35 wow fadeInUp2 animated"
                                data-wow-delay=".1s">
                                <li><a class="theme_btn theme_btn_03 theme_btn_bg" href="<?php echo base_url();?>about"><i
                                            class="fab fa-google-play"></i> Play Store</a></li>
                            
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="dashbord_img-02 pos-rel pt-120 text-center wow fadeInUp2 animated"
                            data-wow-delay="0.3s">
                            <img src="<?php echo base_url();?>site/img/bg/04.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--download-area end-->
        <!--what-we-do-area start-->
        <section class="what-do-area-03 pb-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xxl-6 col-xl-6 mb-30">
                        <div class="row gx-3">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 wow fadeInUp2 animated"
                                data-wow-delay="0.2s">
                                <div class="do_box do_box_03 mt-30">
                                    <div class="do_box__icon mb-40">
                                        <img src="<?php echo base_url();?>site/img/icon/04.png" alt="">
                                    </div>
                                    <h4>Multiple managers</h4>
                                    <p>Sed ut perspiciatis unde omnis natus error sit volupta</p>
                                    <a href="<?php echo base_url();?>contact"><i class="far fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 wow fadeInUp2 animated"
                                data-wow-delay="0.2s">
                                <div class="do_box do_box_03">
                                    <div class="do_box__icon icon_02 mb-40">
                                        <img src="<?php echo base_url();?>site/img/icon/05.png" alt="">
                                    </div>
                                    <h4>Customization</h4>
                                    <p>Sed ut perspiciatis unde omnis natus error sit volupta</p>
                                    <a href="<?php echo base_url();?>contact"><i class="far fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 wow fadeInUp2 animated"
                                data-wow-delay="0.2s">
                                <div class="do_box do_box_03 mt-30">
                                    <div class="do_box__icon icon_03 mb-40">
                                        <img src="<?php echo base_url();?>site/img/icon/06.png" alt="">
                                    </div>
                                    <h4>Software strategy</h4>
                                    <p>Sed ut perspiciatis unde omnis natus error sit volupta</p>
                                    <a href="<?php echo base_url();?>contact"><i class="far fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 wow fadeInUp2 animated"
                                data-wow-delay="0.2s">
                                <div class="do_box do_box_03">
                                    <div class="do_box__icon icon_04 mb-40">
                                        <img src="<?php echo base_url();?>site/img/icon/07.png" alt="">
                                    </div>
                                    <h4>Processors</h4>
                                    <p>Sed ut perspiciatis unde omnis natus error sit volupta</p>
                                    <a href="<?php echo base_url();?>contact"><i class="far fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 wow fadeInUp2 animated" data-wow-delay="0.1s">
                        <div class=" we_wrapper_03 we_wrapper_03_pd pl-100 pr-50 mb-30">
                            <div class="section-title blue-title text-left mb-40">
                                <h5>Why Choose Us</h5>
                                <h2 class="mb-35">Analysis & monitoring
                                    your software</h2>
                                <p>Must explain to you how all this mistaken idea denouncing
                                    and praising pain was born and will give you complete account
                                    system, and expound actual teachings</p>
                            </div>
                            <ul class="features_list features_list_02 mb-45">
                                <li>Understanding CSS Grid</li>
                                <li>Appointments Events WordPress</li>
                                <li>Understanding Syatems</li>
                            </ul>
                            <a class="theme_btn theme_btn_03 theme_btn_bg" href="<?php echo base_url();?>about">learn more <i
                                    class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--what-we-do-area end-->
        <!--testimonial-area start-->
        <section class="testimonial-area testimonial-bg-03 pos-rel grey-bg pt-125 pb-215">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-6 offset-xxl-3 wow fadeInUp2" data-wow-delay=".2s">
                        <div class="section-title white-title text-center pr-20 pl-20 mb-80">
                            <h5>Customer Reviews</h5>
                            <h2>2356+ customer say about
                                our support</h2>
                        </div>
                    </div>
                </div>
                <div class="row gx-0 testimonial-active-03 wow fadeInUp2" data-wow-delay=".4s">
                    <div class="col-xxl-4 testimonial-item">
                        <div class="text_inner text_inner_03 pos-rel clearfix white-bg">
                            <div class="text_inner__icon">
                                <i class="fal fa-quote-right"></i>
                            </div>
                            <div class="text_inner__content overflow-hidden">
                                <p class="test-title">On the other hand denoun with righteous
                                    and disliks men who are beguiled demorae
                                    momentc blinded by desire that can</p>
                                <div class="testimonial-author d-flex mt-25">
                                    <div class="testimonial-author__img mr-20">
                                        <img src="<?php echo base_url();?>site/img/testimonial/01.png" alt="">
                                    </div>
                                    <div class="testimonial-author__content">
                                        <h4>David Warner</h4>
                                        <span>Web Developer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 testimonial-item">
                        <div class="text_inner text_inner_03 pos-rel clearfix white-bg">
                            <div class="text_inner__icon">
                                <i class="fal fa-quote-right"></i>
                            </div>
                            <div class="text_inner__content overflow-hidden">
                                <p class="test-title">On the other hand denoun with righteous
                                    and disliks men who are beguiled demorae
                                    momentc blinded by desire that can</p>
                                <div class="testimonial-author d-flex mt-25">
                                    <div class="testimonial-author__img mr-20">
                                        <img src="<?php echo base_url();?>site/img/testimonial/02.png" alt="">
                                    </div>
                                    <div class="testimonial-author__content">
                                        <h4>Somalia D Silva</h4>
                                        <span>Business Manager</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 testimonial-item">
                        <div class="text_inner text_inner_03 pos-rel clearfix white-bg">
                            <div class="text_inner__icon">
                                <i class="fal fa-quote-right"></i>
                            </div>
                            <div class="text_inner__content overflow-hidden">
                                <p class="test-title">On the other hand denoun with righteous
                                    and disliks men who are beguiled demorae
                                    momentc blinded by desire that can</p>
                                <div class="testimonial-author d-flex mt-25">
                                    <div class="testimonial-author__img mr-20">
                                        <img src="<?php echo base_url();?>site/img/testimonial/01.png" alt="">
                                    </div>
                                    <div class="testimonial-author__content">
                                        <h4>David Warner</h4>
                                        <span>Web Developer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 testimonial-item">
                        <div class="text_inner text_inner_03 pos-rel clearfix white-bg">
                            <div class="text_inner__icon">
                                <i class="fal fa-quote-right"></i>
                            </div>
                            <div class="text_inner__content overflow-hidden">
                                <p class="test-title">On the other hand denoun with righteous
                                    and disliks men who are beguiled demorae
                                    momentc blinded by desire that can</p>
                                <div class="testimonial-author d-flex mt-25">
                                    <div class="testimonial-author__img mr-20">
                                        <img src="<?php echo base_url();?>site/img/testimonial/02.png" alt="">
                                    </div>
                                    <div class="testimonial-author__content">
                                        <h4>Somalia D Silva</h4>
                                        <span>Business Manager</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 testimonial-item">
                        <div class="text_inner text_inner_03 pos-rel clearfix white-bg">
                            <div class="text_inner__icon">
                                <i class="fal fa-quote-right"></i>
                            </div>
                            <div class="text_inner__content overflow-hidden">
                                <p class="test-title">On the other hand denoun with righteous
                                    and disliks men who are beguiled demorae
                                    momentc blinded by desire that can</p>
                                <div class="testimonial-author d-flex mt-25">
                                    <div class="testimonial-author__img mr-20">
                                        <img src="<?php echo base_url();?>site/img/testimonial/01.png" alt="">
                                    </div>
                                    <div class="testimonial-author__content">
                                        <h4>David Warner</h4>
                                        <span>Web Developer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 testimonial-item">
                        <div class="text_inner text_inner_03 pos-rel clearfix white-bg">
                            <div class="text_inner__icon">
                                <i class="fal fa-quote-right"></i>
                            </div>
                            <div class="text_inner__content overflow-hidden">
                                <p class="test-title">On the other hand denoun with righteous
                                    and disliks men who are beguiled demorae
                                    momentc blinded by desire that can</p>
                                <div class="testimonial-author d-flex mt-25">
                                    <div class="testimonial-author__img mr-20">
                                        <img src="<?php echo base_url();?>site/img/testimonial/02.png" alt="">
                                    </div>
                                    <div class="testimonial-author__content">
                                        <h4>Somalia D Silva</h4>
                                        <span>Business Manager</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--testimonial-area end-->

    </main>