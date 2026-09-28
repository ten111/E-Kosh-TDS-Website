	<div class="content-wrapper">
			<section class="content-header">
				<h5> Listed Branches</h5>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">  Listed Branches</li>
				</ol>
			</section>
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
                <div class="col-md-4">
                	<?php if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
                    <div class="panel panel-primary cardbg">
                        <h6 class="title-inner text-uppercase">Add/Edit Branches</h6>
                        <div class="panel-body">
                        <?php if($this->uri->segment(3)){?>
                        <form action="<?php echo base_url();?>admin/update_branch" method="post" enctype="multipart/form-data">
                            
                            <input type="hidden" name="br_id" value="<?php echo $edit->br_id;?>" />
                             
                              <div class="form-group "> <label for="email">Branch Name</label>
                                <input type="text" required class="form-control" value="<?php echo $edit->br_name;?>"  name="br_name">
                              </div>
                              <div class="form-group ">
                                <label for="email">Branch Code</label>
                                <input type="text"  class="form-control" value="<?php echo $edit->br_code;?>"  name="br_code" required>
                              </div>
                              <div class="form-group ">
                                <label for="email">Branch Email</label>
                                <input type="email"  class="form-control" value="<?php echo $edit->br_mail;?>"  name="br_mail" required>
                              </div>
                              <div class="row">
                                  <div class="form-group col-md-6">
                                    <label for="email">Phone 1</label>
                                    <input type="text"  class="form-control"  value="<?php echo $edit->br_phone1;?>"  name="br_phone1" required>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="email">Phone 2</label>
                                    <input type="text"  class="form-control"  value="<?php echo $edit->br_phone2;?>" name="br_phone2">
                                  </div>
                              </div>
                              <div class="form-group">
                                <label for="email">Address</label>
                                <textarea class="form-control" rows="3"  name="br_address" required><?php echo $edit->br_address;?></textarea>
                              </div>
                              <div class="row">
                                  <div class="form-group col-md-7">
                                    <label for="email">State</label>
                                    <select class="form-control" name="br_state" required>
                                    <option value="">Select State</option>
                                    <?php foreach($states as $st){?>
                                    <option value="<?php echo $st->state_id;?>" <?php if($edit->br_state==$st->state_id){echo "selected";}?>><?php echo $st->state;?></option>
                                    <?php }?>
                                    </select>
                                  </div>
                                  <div class="form-group col-md-5">
                                    <label for="email">City</label>
                                    <input type="text"  class="form-control" value="<?php echo $edit->br_city;?>" name="br_city" required>
                                  </div>
                              </div>
                              <button type="submit" class="btn btn-success">Update Branch</button>
                            </form>
                        <?php }else{?>
                        <form action="<?php echo base_url();?>admin/add_branch" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="br_added_date" value="<?php echo date("Y-m-d");?>" />
                            <input type="hidden" name="br_status" value="" />
                             
                              <div class="form-group "> <label for="email">Branch Name</label>
                                <input type="text" required class="form-control" name="br_name">
                              </div>
                              <div class="form-group ">
                                <label for="email">Branch Code</label>
                                <input type="text"  class="form-control" name="br_code" required>
                              </div>
                              <div class="form-group ">
                                <label for="email">Branch Email</label>
                                <input type="email"  class="form-control" name="br_mail" required>
                              </div>
                              <div class="row">
                                  <div class="form-group col-md-6">
                                    <label for="email">Phone 1</label>
                                    <input type="text"  class="form-control" name="br_phone1" required>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="email">Phone 2</label>
                                    <input type="text"  class="form-control" name="br_phone2">
                                  </div>
                              </div>
                              <div class="form-group">
                                <label for="email">Address</label>
                                <textarea class="form-control" rows="3" name="br_address" required></textarea>
                              </div>
                              <div class="row">
                                  <div class="form-group col-md-7">
                                    <label for="email">State</label>
                                    <select class="form-control" name="br_state" required>
                                    <option value="">Select State</option>
                                    <?php foreach($states as $st){?>
                                    <option value="<?php echo $st->state_id;?>"><?php echo $st->state;?></option>
                                    <?php }?>
                                    </select>
                                  </div>
                                  <div class="form-group col-md-5">
                                    <label for="email">City</label>
                                    <input type="text"  class="form-control" name="br_city" required>
                                  </div>
                              </div>
                              <button type="submit" class="btn btn-success">Add Branch</button>
                            </form>
                        <?php }?>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="panel panel-primary cardbg">
                        <h6 class="title-inner text-uppercase">Add/Edit Designations</h6>
                        <div class="panel-body">
                        <table class="table">
                        <thead><tr><th>S.No.</th><th>Branch</th><th>Contact/Address</th><th>Action</th></tr></thead>
                            <tbody id="branches_list">
                                
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
			</section>
		</div>
		<!-- Page Content Ends-->
		
		<!-- Back to Top Starts -->
		<a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
		<!-- Back to Top Ends -->
		
		<!-- Footer Section Starts -->
		<footer class="main-footer">
			<div class="pull-right hidden-xs">
			  Version 1.0.0
			</div>
			<p class="mb-0">Copyright © 2019 <a target="_blank" href="#">Admin</a>. All rights reserved.</p>
		</footer>
		<!-- Footer Section Ends -->
			
	</div>

	<!-- jQuery CDN - Slim version (=without AJAX) -->
	<script src="<?php echo base_url();?>adminassets/assets/js/jquery/slim.min.js"></script>
    <script>
	$(document).ready(function(){
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_branches_list',
			 data: {index:1},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#branches_list").html(res);
			 }
		 });
	});
	</script>    

	<!-- Popper.JS -->
	<script src="<?php echo base_url();?>adminassets/assets/js/jquery/popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="<?php echo base_url();?>adminassets/assets/js/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/bootstrap/bootstrap.min.js"></script>
	<!-- Theme JS -->
	<script src="<?php echo base_url();?>adminassets/assets/js/nanoscroller/nanoscroller.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/custom/theme.js"></script>
</body>
</html>