   
<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Listed Employees (<?php echo $this->db->get_where("emps",array("emp_client"=>$this->session->userdata("userid")))->num_rows();?>)</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>
                            <li class="breadcrumb-item active">Employees</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
         <?php if($_GET['msg']){echo '<div class="alert alert-warning">'.$_GET['msg'].'</div>';}?>
        <div id="empmodal" class="modal fade" role="dialog">

<div class="modal-dialog">

  <!-- Modal content-->

  <div class="modal-content">

  <div class="modal-header">
                                                      <h5 class="modal-title">Add/Edit Employee</h5>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>

    <div class="modal-body">
    <?php if($this->uri->segment(3)){
							$edit=$this->db->get_where("emps",array("emp_id"=>$this->uri->segment(3)))->row();?>
                        
							<form action="<?php echo base_url();?>admin/update_emp" method="post" enctype="multipart/form-data">
							<input type="hidden"  class="form-control" name="emp_id" value="<?php echo $edit->emp_id;?>"/>
                              <div class="form-group "> 
                                <label for="email">Employee Name</label>
                                <input type="text" required class="form-control"  value="<?php echo $edit->emp_name;?>" name="emp_name"/>
                              </div>
                              <div class="row">
							  <div class="form-group col-md-6"> 
                                <label for="email">Employee Code</label>
                                <input type="text" required class="form-control"  value="<?php echo $edit->emp_code;?>" name="emp_code"/>
                              </div>
							  <div class="form-group col-md-6"> 
                                <label for="email">Bill Unit</label>
                                <input type="text"  class="form-control"  value="<?php echo $edit->emp_bill;?>" name="emp_bill"/>
                              </div>
                                  <div class="form-group col-md-6">
                                    <label for="email">PAN Number</label>
                                    <input type="text"  class="form-control"  value="<?php echo $edit->emp_pan;?>" name="emp_pan"/>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="email">Phone</label>
                                    <input type="text"  class="form-control"  value="<?php echo $edit->emp_mob;?>" name="emp_mob" />
                                  </div>
                              </div>

                              <div class="form-group ">
                                <label for="email">Email</label>
                                <input type="text"  class="form-control" name="emp_email"  value="<?php echo $edit->emp_email;?>" />
                              </div>
                              <div class="form-group ">
                                <label for="email">School</label>
                                <input type="text"  class="form-control" name="emp_school"  value="<?php echo $edit->emp_school;?>" />
                              </div>
                              <div class="form-group ">
                                <label for="email">Sankul</label>
                                <input type="text"  class="form-control" name="emp_sankul"  value="<?php echo $edit->emp_sankul;?>" />
                              </div>
                              <div class="form-group ">
                                <label for="email">Designation</label>
                                <input type="text"  class="form-control" name="emp_desg"  value="<?php echo $edit->emp_desg;?>" />
                              </div>
                              <div class="row">
                                  <div class="form-group col-md-6">
                                    <label for="email">GPF Type</label>
									<select class="form-control" required name="emp_gpf">
<option value="GPF" <?php if($edit->emp_gpf=='GPF'){echo "selected";}?>>GPF</option>
<option value="CPS" <?php if($edit->emp_gpf=='CPS'){echo "selected";}?>>CPS</option>
						</select>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="email">Tax Regime Type</label>
                                    <select class="form-control" required name="emp_tax">
<option value="Old" <?php if($edit->emp_tax=='Old'){echo "selected";}?>>Old</option>
<option value="New" <?php if($edit->emp_tax=='New'){echo "selected";}?>>New</option>
						</select>
                                  </div>
                              </div>
                              
                              <button type="submit" class="btn btn-success">Update Employee</button>
                            </form>
							<?php }else{?>
                          <form action="<?php echo base_url();?>admin/add_emp" method="post" enctype="multipart/form-data">
						  <input type="hidden"  class="form-control" name="emp_added" value="<?php echo date("Y-m-d");?>">
						  <input type="hidden"  class="form-control" name="emp_client" value="<?php echo $this->session->userdata("userid");?>">
                              <div class="form-group "> 
                                <label for="email">Employee Name</label>
                                <input type="text" required class="form-control" name="emp_name">
                              </div>
                              <div class="row">
                                
							  <div class="form-group col-md-6"> 
                                <label for="email">Employee Code</label>
                                <input type="text" required class="form-control" name="emp_code"/>
                              </div>
							  <div class="form-group col-md-6"> 
                                <label for="email">Bill Unit</label>
                                <input type="text"  class="form-control" name="emp_bill"/>
                              </div>
                                  <div class="form-group col-md-6">
                                    <label for="email">PAN Number</label>
                                    <input type="text"  class="form-control" name="emp_pan"/>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="email">Phone</label>
                                    <input type="text"  class="form-control" name="emp_mob"/>
                                  </div>
                              </div>

                              <div class="form-group ">
                                <label for="email">Email</label>
                                <input type="text"  class="form-control" name="emp_email" />
                              </div>
                              <div class="form-group ">
                                <label for="email">School</label>
                                <input type="text"  class="form-control" name="emp_school" >
                              </div>
                              <div class="form-group ">
                                <label for="email">Sankul</label>
                                <input type="text"  class="form-control" name="emp_sankul" >
                              </div>
                              <div class="form-group ">
                                <label for="email">Designation</label>
                                <input type="text"  class="form-control" name="emp_desg" >
                              </div>
                              <div class="row">
                                  <div class="form-group col-md-6">
                                    <label for="email">GPF Type</label>
									<select class="form-control" required name="emp_gpf">
<option value="GPF">GPF</option>
<option value="CPS">CPS</option>
						</select>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="email">Tax Regime Type</label>
                                    <select class="form-control" required name="emp_tax">
<option value="Old">Old</option>
<option value="New">New</option>
						</select>
                                  </div>
                              </div>
                              
                              <button type="submit" class="btn btn-success">Add Employee</button>
                            </form>
                        <?php }?>
    </div>

    </div>
    </div>
    </div>




        <div class="row">
            

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <a href="<?php echo base_url().'admin/reset_emps';?>" onclick="return confirm('This will Delete all Employee, Salary Data & ITRs? This action cannot be undone.');" class="btn btn-sm float-end btn-danger">DELETE ALL</a>
                    &nbsp;&nbsp;<a id="<?php echo $c->client_id;?>" class="btn btn-sm  btn-dark float-end" data-bs-toggle="modal" data-bs-target="#empmodal">ADD NEW</a>	
	
<input type="text" style="width:300px;" placeholder="Search Name/Code/Mobile" id="search_name" class="form-control"/>
                    </div><!-- end card header -->
                    <div class="card-body">
                    <form class="form-inline" method="post" enctype="multipart/form-data" action="<?php echo base_url().'admin/upload_empexcel';?>">
                             
							 
                     
                    <a download class="btn btn-sm btn-warning float-end" href="<?php echo base_url().'assets/employee_data_template.csv';?>">Download - Employee Data Template</a>
                     <a class="btn btn-sm btn-dark float-end" href="<?php echo base_url().'admin/export_csv_emp';?>">Download - Employee Data</a>
                             <div class="form-group">
                                        <input type="file" style="width:200px;" name="pfile" required class="form-control" accept=".csv, text/csv, application/csv, text/comma-separated-values, application/vnd.ms-excel"/>
                                        <button type="submit" class="btn btn-success">Import/Update Employee</button>
                                            </div>
                                          </form>
                                          <div class="table-responsive" id="tablediv">
                                            
                                          <table class="table align-middle table-nowrap mb-0">
                                              <thead><tr><th>S.No.</th><th>Name of Employee </th>
                                              <th>Employee Code</th>
                                              <th>Bill Unit</th>
                                              <th>PAN</th>
                                              <th>Phone</th>
                                              <th>Email</th>
                                              <th>Office</th>
                                              <th>Sub-Office</th>
                                              <th>Designation</th>
                                              <th>GPF/CPS</th>
                                              <th>Status</th>
                                              <th>Action</th></tr></thead>
                                              <tbody id="emps_list">
                                              <tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>
                                              </tbody>
                                          </table>
                                        
                        <!-- <button id="prev" class="btn btn-sm btn-danger">Previous</button> -->
                        <button id="next" class="btn btn-dark text-center">Load More</button>
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
                <script>document.write(new Date().getFullYear())</script> © Ekosh TDS.
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


</div>  <script>
	$(document).ready(function(){
    
    let count = 0;

    $("#tablediv").on("scroll", function () {
      
        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
          
            // Trigger event when scrolled to bottom
            $("#leads_list").html('<tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>');
                count += 10;
                $("#value").text(count);
                $.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_emp_list',
			 data: {limit:count},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#emps_list:last").append(res);
			 }
		 });
        }
    });
            
            $("#next").click(function() {
                $("#leads_list").html('<tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>');
                count += 10;
                //$("#value").text(count);
                $.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_emp_list',
			 data: {limit:count},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#emps_list:last").append(res);
			 }
		 });
            });
            
            $("#prev").click(function() {
                $("#leads_list").html('<tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>');
                count -= 10;
                $("#value").text(count);
                $.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_emp_list',
			 data: {limit:count},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#emps_list").html(res);
			 }
		 });
            });
    <?php if($this->uri->segment(3)){?>
    $('#empmodal').modal('show');
    <?php }?> 
    $("#search_name").keyup(function(){

var name=$(this).val();

if(name.length>=3){

$.ajax({

     type: "POST",

     url: '<?php echo base_url();?>admin/ajax_emp_list',

     data: {name:name},

     success: function(response){

        $("#emps_list").html(response);

     }

 });

}else{
  $.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_emp_list',
			 data: {limit:count},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#emps_list").html(res);
			 }
		 });
}

});
	
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_emp_list',
			 data: {limit:count},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#emps_list").html(res);
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










