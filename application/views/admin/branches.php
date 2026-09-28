<div class="main-content">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Listed Clients</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>
                            <li class="breadcrumb-item active">Clients</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Add/Edit Clients</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                    <?php if($this->uri->segment(3)){?>
                          <form action="<?php echo base_url();?>admin/update_branch" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="client_id" value="<?php echo $edit->client_id;?>" />
                              <div class="form-group "> 
                                <label for="email">Name of DDO</label>
                                <input type="text" required class="form-control" value="<?php echo $edit->ddo_name;?>" name="ddo_name">
                              </div>
                              <div class="row">
                                  <div class="form-group col-md-6">
                                    <label for="email">DDO Number</label>
                                    <input type="text" required class="form-control" value="<?php echo $edit->ddo_num;?>" name="ddo_num">
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="email">TAN Numbe</label>
                                    <input type="text"  class="form-control" value="<?php echo $edit->tan_num;?>" name="tan_num" required>
                                  </div>
                              </div>

                              <div class="form-group ">
                                <label for="email">Email Address of the DDO</label>
                                <input type="email"  class="form-control" value="<?php echo $edit->client_email;?>" name="client_email" required>
                              </div>
                              <div class="form-group"> 
                                <label for="email">Name of Pricipal Employer</label>
                                <input type="text" required class="form-control" value="<?php echo $edit->cemp_name;?>" name="cemp_name">
                              </div>
                              <div class="form-group ">
                                <label for="email">Mobile Number</label>
                                <input type="text"  class="form-control" value="<?php echo $edit->client_mob;?>" name="client_mob" required>
                              </div>
                              <div class="row">
                                  <div class="form-group col-md-6">
                                    <label for="email">PAN Number</label>
                                    <input type="text"  class="form-control" value="<?php echo $edit->cemp_pan;?>" name="cemp_pan" required>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="email">DOB of Employer</label>
                                    <input type="text"  class="form-control" value="<?php echo $edit->cemp_dob;?>" name="cemp_dob" required>
                                  </div>
                              </div>
                              <div class="form-group"> 
                                <label for="email">Name of Section Clerk</label>
                                <input type="text" required class="form-control" value="<?php echo $edit->clerk_name;?>" name="clerk_name">
                              </div>
                              <div class="form-group"> 
                                <label for="email">Mobile Number</label>
                                <input type="text" required class="form-control" value="<?php echo $edit->clerk_mob;?>" name="clerk_mob">
                              </div>
                              
                              
                              <button type="submit" class="btn btn-success">Update Client</button>
                            </form>
                        <?php }else{?>
                          <form action="<?php echo base_url();?>admin/add_branch" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="cemp_added" value="<?php echo date("Y-m-d");?>" />
                            <input type="hidden" name="cemp_pass" value="e10adc3949ba59abbe56e057f20f883e" />

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
                                    <label for="email">TAN Number</label>
                                    <input type="text"  class="form-control" name="tan_num" required>
                                  </div>
                              </div>

                              <div class="form-group ">
                                <label for="email">Email Address of the DDO</label>
                                <input type="email"  class="form-control" name="client_email" required>
                              </div>
                              <div class="form-group"> 
                                <label for="email">Name of Pricipal Employer</label>
                                <input type="text" required class="form-control" name="cemp_name">
                              </div>
                              <div class="form-group ">
                                <label for="email">Mobile Number</label>
                                <input type="text"  class="form-control" name="client_mob" required>
                              </div>
                              <div class="row">
                                  <div class="form-group col-md-6">
                                    <label for="email">PAN Number</label>
                                    <input type="text"  class="form-control" name="cemp_pan" required>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="email">DOB of Employer</label>
                                    <input type="text"  class="form-control" name="cemp_dob" required>
                                  </div>
                              </div>
                              <div class="form-group"> 
                                <label for="email">Name of Section Clerk</label>
                                <input type="text" required class="form-control" name="clerk_name">
                              </div>
                              <div class="form-group"> 
                                <label for="email">Mobile Number</label>
                                <input type="text" required class="form-control"  name="clerk_mob">
                              </div>
                              
                              
                              <button type="submit" class="btn btn-success">Add Client</button>
                            </form>
                        <?php }?>
                        <!--end row-->
                    </div>
                   
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                    <input type="text" style="width:300px;" placeholder="Search DDO Name/Number" id="search_name" class="form-control"/>
                    </div><!-- end card header -->
                    <div class="card-body">
                    <div class="table-responsive"><table class="table align-middle table-nowrap mb-0">
                        <thead><tr><th>S.No.</th><th>DDO</th><th>Pricipal Employer</th><th>Action</th></tr></thead>
                            <tbody id="branches_list">
                            <tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>
                            </tbody>
                        </table></div>
                        <div id="change_pass" class="modal fade" role="dialog">

      <div class="modal-dialog modal-sm">

        <!-- Modal content-->

        <div class="modal-content">

        <div class="modal-header">
                                                            <h5 class="modal-title">Change Password</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

          <div class="modal-body">

          	<form id="change_pass_form" action="" method="post">

            	<input type="hidden" name="client_id" value="" id="client_id" />

            	<div class="form-group">

                	<label>New Password</label>

                    <input type="password" class="form-control" name="pass" id="pass" />

                </div>

                <div class="form-group">

                	<label>New Password</label>

                    <input type="password" class="form-control" name="cpass" id="cpass" />

                </div>
<br/>
                <button type="submit" class="btn btn-warning" id="submit_btn">Change Password</button>

           	    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>

            </form>

          </div>

         

        </div>

      </div>

        </div>

       
                    </div>
                    
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

       

        

        

        
        

        <!--end row-->

    </div> <!-- container-fluid -->
</div><!-- End Page-content -->

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © Invoika.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by Themesbrand
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->




<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
<i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!--preloader-->
<div id="preloader">
<div id="status">
<div class="spinner-border text-primary avatar-sm" role="status">
    <span class="visually-hidden">Loading...</span>
</div>
</div>
</div>


</div>

<!-- JAVASCRIPT -->
<script>
	$(document).ready(function(){

    $("#search_name").keyup(function(){
      $("#branches_list").html('<tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>');

var name=$(this).val();

if(name.length>=3){

$.ajax({

     type: "POST",

     url: '<?php echo base_url();?>admin/ajax_branches_list',

     data: {name:name,limit:100},

     success: function(response){

        $("#branches_list").html(response);

     }

 });

}else{
    $.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_branches_list',
			 data: {limit:100},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#branches_list").html(res);
			 }
		 });
}

});
    $("#change_pass_form").submit(function(e){e.preventDefault();

$("#submit_btn").attr("disbled",true);

var id=$("#client_id").val();

var pass=$("#pass").val();

var cpass=$("#cpass").val();

$("#change_pass_vid").val(id);
//(id);
$.ajax({

   type: "POST",

   url: '<?php echo base_url();?>admin/change_pass_client',

   data: {id:id,pass:pass,cpass:cpass},

   success: function(res){

     $("#submit_btn").removeAttr("disbled");

     alert(res);

   }

});

});
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

<script src="<?php echo base_url();?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/feather-icons/feather.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins.js"></script>

<!-- prismjs plugin -->
<script src="<?php echo base_url();?>assets/libs/prismjs/prism.js"></script>

<script src="<?php echo base_url();?>assets/js/app.js"></script>

</body>


</html>










