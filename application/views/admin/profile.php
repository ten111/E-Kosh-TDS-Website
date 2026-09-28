<div class="main-content">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"><?php echo $edit->ddo_name.' '.$edit->ddo_num;?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
      
        <div class="row">
          <?php if($this->session->userdata("type")!="admin"){?>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 text-primary">DDO Details</h4>
                    </div><!-- end card header -->
                    <div class="card-body">

                          
                    <form action="<?php echo base_url();?>admin/update_branch2" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="client_id" value="<?php echo $edit->client_id;?>" />
                              <div class="form-group "> 
                                <label>Name of DDO</label>
                                <input type="text" required class="form-control" value="<?php echo $edit->ddo_name;?>" name="ddo_name">
                              </div>
                              <div class="row">
                                  <div class="form-group col-md-6">
                                    <label>DDO Number</label>
                                    <input type="text" required class="form-control" value="<?php echo $edit->ddo_num;?>" name="ddo_num">
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label>DDO TAN</label>
                                    <input type="text"  class="form-control" value="<?php echo $edit->tan_num;?>" name="tan_num" required>
                                  </div>

                                  <div class="form-group col-md-12"> 
                                <label>Name of Pricipal Employer</label>
                                <input type="text" required class="form-control" value="<?php echo $edit->cemp_name;?>" name="cemp_name">
                              </div>
                              <div class="form-group col-md-6">
                                    <label>PAN of Employer</label>
                                    <input type="text"  class="form-control" value="<?php echo $edit->cemp_pan;?>" name="cemp_pan" required>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label>DOB of Employer</label>
                                    <input type="text"  class="form-control" value="<?php echo $edit->cemp_dob;?>" name="cemp_dob" required>
                                  </div>
                              <div class="form-group col-md-4">
                                <label>Phone</label>
                                <input type="text"  class="form-control" value="<?php echo $edit->client_mob;?>" name="client_mob" required>
                              </div>
                              <div class="form-group col-md-8">
                                <label>Email</label>
                                <input type="email"  class="form-control" value="<?php echo $edit->client_email;?>" name="client_email" required>
                              </div>
                              <div class="form-group col-md-6"> 
                                <label>Clerk Name</label>
                                <input type="text" required class="form-control" value="<?php echo $edit->clerk_name;?>" name="clerk_name">
                              </div>
                              <div class="form-group col-md-6"> 
                                <label>Clerk Phone</label>
                                <input type="text" required class="form-control" value="<?php echo $edit->clerk_mob;?>" name="clerk_mob">
                              </div>

<div class="form-group  col-md-6">

  <label for="new">DDO Seal/Sign</label>

  <input type="file" class="form-control" name="ddo_sign" />
  <img width="100px" id="ddo_sign1" src="<?php echo base_url().'assets/images/signs/'.$edit->ddo_sign;?>" />
  <?php if($edit->ddo_sign){?>
  <button type="button" class="btn btn-danger btn-sm" id="ddo_sign">DELETE</button>
  <?php }?>
</div> 
<div class="form-group  col-md-6">

<input type="hidden" name="oldddo_sign" id="ddo_sign2" value="<?php echo $edit->ddo_sign;?>" />
<input type="hidden" name="oldddo_img" id="ddo_img2" value="<?php echo $edit->ddo_img;?>" />
<label for="new">DDO Profile</label>

<input type="file" class="form-control" name="ddo_img" />
<img width="100px" id="ddo_img1" src="<?php echo base_url().'assets/images/signs/'.$edit->ddo_img;?>" />
<?php if($edit->ddo_img){?>
<button type="button" class="btn btn-danger btn-sm" id="ddo_img">DELETE</button>
<?php }?>
</div> 
                              </div>
                              
                              <button type="submit" class="btn btn-success">Update Details</button>
                            </form>

                    </div>
                   
                </div>
            </div><?php }?>
            <div class="col-lg-4">

		
<div class="card">

           <div class="card-header"><h4 class="card-title mb-0 text-primary">Change Password</h4></div>

     <div class="card-body">

           <form class="form-horizontal" action="" method="post" id="changepass">

               

         <div class="form-group">

                 <input type="password"  name="npass" required class="form-control" id="inputPassword3" placeholder="New Password">

             

         </div>

         <div class="form-group mt-2">

                 <input type="password"  name="cpass" required class="form-control" id="inputPassword3" placeholder="Confirm Password">

                  <b class="text-warning" id="passch"></b>

             

             

         </div>

         <button type="submit" class="btn btn-primary mt-2">Change Password</button>

     </form>

     </div>

     

</div>                  




<div class="card">

           <div class="card-header"><h4 class="card-title mb-0 text-primary">Settings</h4></div>

     <div class="card-body">

     <?php  $admin = $this->db->get("admin")->row();?>
                                <label>Standard Deduction(%)</label>
                                <input type="text " id="stn_ded" value="<?php echo $admin->stn_ded;?>"  class="form-control"
                                 placeholder="Enter Value">
           <hr/>
     <a class="btn btn-sm btn-danger" 
   href="<?php echo base_url().'admin/delete_all_emp';?>" 
   onclick="return confirm('Are you sure you want to delete ALL employees? This action cannot be undone.');">
   DELETE ALL EMPLOYEES DATA (RESET)
</a>                 
     </div>

     

     

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
                <script>document.write(new Date().getFullYear())</script> © EKosh TDS.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by Vibeapps
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
    $("#changepass").submit(function(e){e.preventDefault();
      var formdata=$(this).serialize();
        $.ajax({

                     type: "POST",

                     url: '<?php echo base_url();?>admin/change_pass',

                     data: {formdata:formdata},

                     success: function(response){

                         alert(response);

                     }

                     });   
    });
    $("#ddo_img").click(function(){
      $(this).remove();
      $("#ddo_img1").attr("src","");
      $("#ddo_img2").val("");
    });
    $("#ddo_sign").click(function(){
      $(this).remove();
      $("#ddo_sign1").attr("src","");
      $("#ddo_sign2").val("");
    });
    $("#stn_ded").keyup(function(){
            var v=$(this).val();

    $.ajax({

                     type: "POST",

                     url: '<?php echo base_url();?>admin/ajax_stn_ded',

                     data: {v:v},

                     success: function(response){

                         //alert(response);

                     }

                     });   
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










