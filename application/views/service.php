<main>
			<section
				class="pt-18 pb-10"
				style="background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), rgba(0, 0, 0, 0.2) url(<?php echo base_url();?>assets/images/background/page-header.jpg) no-repeat center; background-size: cover"
			>
				<div class="container">
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="bg-white p-5 rounded-top-md">
								<div class="row align-items-center">
									<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
										<h1 class="mb-0"><?php echo $service->serv_title;?></h1>
									</div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
										<div class="text-md-end mt-3 mt-md-0">
											<a href="#!" class="btn btn-primary">Start From ₹<?php echo $service->serv_price;?></a>
										</div>
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
					<div class="mt-n6 bg-white mb-10 rounded-3 shadow-sm p-5">
						<div class="row">
							<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 mb-8 mb-lg-0">
								<div class="panel panel-primary">
                                <div class="panel-header"><?php echo $service->serv_title;?> Tips & Recommendation</div>
                                <div class="panel-body">
                               <?php echo $service->serv_desc;?> 
                                </div>
                                </div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
								<div class="card mb-4">
									<div class="card-body">
										<h3 class="mb-3">Ask an Expert Right Now</h3>
                                       
										<form method="post" action="" id="freetrial">
                <input type="hidden" name="enq_date" value="<?php echo date("Y-m-d");?>" />
                <div class="row">
                  <!-- Text input-->
                  <div class="mb-2 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <label class="form-label sr-only" for="name">Name</label>
                    <input id="name" name="name" type="text" placeholder="Name" class="form-control" required="">
                  </div>
                  <!-- Text input-->
                  <div class="mb-2  col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <label class="form-label sr-only" for="email">E-Mail</label>
                    <input id="email" name="email" type="text" placeholder="E-mail" class="form-control" required="">
                  </div>
                  <!-- Text input-->
                  <div class="mb-2  col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <label class="form-label sr-only" for="phone">Phone</label>
                    <input id="phone" name="phone" type="text" placeholder="Phone" class="form-control" required="">
                  </div>
                  <!-- Select Basic -->
                  <div class="mb-3  col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <label class="form-label sr-only" for="city">Service</label>
                    <select id="city" name="service" class="form-select">
                      <option value="">Select Services</option>
                      <?php $servs=$this->db->get("services")->result();foreach($servs as $serv){?>
						<option value="<?php echo $serv->serv_title;?>" <?php if($serv->serv_id==$service->serv_id){echo 'selected'; }?>><?php echo $serv->serv_title;?></option>
          <?php }?>
                    </select>
                  </div>
                  
                  <!-- Button -->
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="d-grid">
                      <button type="submit" class="btn btn-primary">Ask an Expert</button>
                    </div>
                  </div>
                </div>
              </form>
									</div>
									<!-- /input-group -->
								</div>
								<!-- /.widget well bg -->
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- /.content end -->
		</main>