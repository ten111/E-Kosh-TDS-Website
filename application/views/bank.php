<main>
    <section class="pt-18 pb-10" style="background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), rgba(0, 0, 0, 0.2)url(../assets/images/background/page-header.jpg) no-repeat center;
  background-size: cover;
">
      <div class="container">
        <div class="row">

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="bg-white p-5 rounded-top-md">
              <div class="row align-items-center">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                  <h1 class="mb-0">Bank Accouts</h1>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </section>
    <!-- content start -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="mt-n6 mb-8">
              <div class="row">
                <?php $banks=$this->db->get("banks")->result();
									foreach($banks as $b){?>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                  <div class="card mb-5 smooth-shadow-sm border-0">
                    <div class="card-body">
                      <!-- card listing -->
                     
                      <div>
                        <h3 class="mb-2">
                          <a href="#!" class="text-inherit"><?php echo $b->bank_name;?></a>
                        </h3>
                        <div>
                          <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item ps-0 fs-5"> A/c No. <strong><?php echo $b->acc_number;?></strong> </li>
                            <li class="list-group-item ps-0 fs-5"> IFSC Code. <strong><?php echo $b->ifsc_code;?></strong> </li>
                            <li class="list-group-item ps-0 fs-5"> A/c Name. <strong><?php echo $b->acc_name;?></strong> </li>
                            <li class="list-group-item ps-0 fs-5"> A/c Type. <strong><?php echo $b->acc_type;?></strong> </li>
                          </ul>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  <!-- /.card listing -->
                </div>
                 <?php }?>
                 <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                  <div class="card mb-5 smooth-shadow-sm border-0">
                    <div class="card-body">
                      <!-- card listing -->
                     
                      <img class="img" src="<?php echo base_url();?>assets/images/scan1.jpeg" width="100%" />
                    </div>
                  </div>
                  <!-- /.card listing -->
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                  <div class="card mb-5 smooth-shadow-sm border-0">
                    <div class="card-body">
                      <!-- card listing -->
                     
                      <img class="img" src="<?php echo base_url();?>assets/images/scan2.jpeg" width="100%" />
                    </div>
                  </div>
                  <!-- /.card listing -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content end -->
  </main>