<main>
        <!-- page-title-area start -->
        <div class="page-title-area d-flex align-items-center" data-background="<?php echo base_url();?>site/img/bg/breadcrumb.jpg">
            <div class="container text-center">
                <div class="page-title">
                    <h2>Contact</h2>
                   
                </div>
            </div>
        </div>
        <!-- page-title-area start -->

        <!-- contact-area-start -->
        <section class="contact-area pt-125 pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-4 col-xl-4 col-lg-6">
                        <div class="feature_wrapper_02 mb-30">
                            <div class="section-title text-left mb-40">
                                <h5>Contact Us</h5>
                                <h2>Let’s start talk
                                    about your project</h2>
                            </div>
                            <ul class="features_list contact-list mb-40">
                                <li><i class="fal fa-map-marker-alt"></i><span>120, Laxmi Chowk, Bodla, Kabirdham, Chhattisgarh</span></li>
                                <li><i class="fal fa-phone"></i>08770163693</li>
                                <li><i class="fal fa-envelope-open"></i>support@gmail.com</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xxl-6 offset-xxl-2 col-lg-6">
                        <div class="contact-form">
                            
                <form method="post" action="#" id="freetrial">
                            <div class="form">
                                <div class="row">
                                    <div class="col-xl-6">
                <input type="hidden" name="enq_date" value="<?php echo date("Y-m-d");?>" />
                                        <input class="contact__input" name="name" required type="text" placeholder="Full Your Name">
                                    </div>
                                    <div class="col-xl-6">
                                        <input class="contact__input" name="phone" required type="text" placeholder="Phone Number">
                                    </div>
                                    
                                    <div class="col-xl-12">
                                    <select name="service" class="form-control contact__input" required >
                                    <option value="income-tax-return-filing" <?php echo (isset($_GET['service']) && $_GET['service'] == 'income-tax-return-filing') ? 'selected' : ''; ?>>Income Tax Return Filing</option>
  <option value="tds-return-filing" <?php echo (isset($_GET['service']) && $_GET['service'] == 'tds-return-filing') ? 'selected' : ''; ?>>TDS Return Filing</option>
  <option value="gst-registration-and-return-filing" <?php echo (isset($_GET['service']) && $_GET['service'] == 'gst-registration-and-return-filing') ? 'selected' : ''; ?>>GST Registration and Return Filing</option>
  <option value="epf-esic-registration-and-return-filing" <?php echo (isset($_GET['service']) && $_GET['service'] == 'epf-esic-registration-and-return-filing') ? 'selected' : ''; ?>>EPF/ESIC Registration and Return Filing</option>
  <option value="new-pan-card-and-correction" <?php echo (isset($_GET['service']) && $_GET['service'] == 'new-pan-card-and-correction') ? 'selected' : ''; ?>>New PAN card and Correction</option>
  <option value="tan-registration" <?php echo (isset($_GET['service']) && $_GET['service'] == 'tan-registration') ? 'selected' : ''; ?>>TAN registration</option>
  <option value="udyam-registration" <?php echo (isset($_GET['service']) && $_GET['service'] == 'udyam-registration') ? 'selected' : ''; ?>>UDYAM Registration</option>
  <option value="P&L Statment and Balance Sheet" <?php echo (isset($_GET['service']) && $_GET['service'] == 'P&L Statment and Balance Sheet') ? 'selected' : ''; ?>>P&L Statment and Balance Sheet</option>
  <option value="cma-report" <?php echo (isset($_GET['service']) && $_GET['service'] == 'cma-report') ? 'selected' : ''; ?>>CMA Report</option>
  <option value="labour-licence" <?php echo (isset($_GET['service']) && $_GET['service'] == 'labour-licence') ? 'selected' : ''; ?>>Labour Licence</option>
  <option value="digital-signature" <?php echo (isset($_GET['service']) && $_GET['service'] == 'digital-signature') ? 'selected' : ''; ?>>Digital Signature</option>
</select>
                                    </div>
                                    <div class="col-xl-12">
                                        <input class="contact__input" name="name" required type="email" placeholder="Email Address">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea class="contact__input contact__input-messege" name="message" required
                                            placeholder="Write Message"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="subs-btn">
                                            <button class="theme_btn theme_btn_bg" type="submit">send message <i
                                                    class="fas fa-chevron-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
</form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact-area-end -->

        <div class="google-map contact-map">
            <iframe class="w-100"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.91477055202!2d-74.11976321327155!3d40.69740344214894!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1612427122501!5m2!1sen!2sbd"></iframe>
        </div>

        

    </main>


