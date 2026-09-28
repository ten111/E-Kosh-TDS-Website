   
<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Previos Employees (<?php echo $this->db->get_where("emp_history",array("emp_hddo1"=>$this->session->userdata("userid")))->num_rows();?>)</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>
                            <li class="breadcrumb-item active">Employees</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="row">
            

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                  
<input type="text" style="width:300px;" placeholder="Search Name/Code/Mobile" id="search_name" class="form-control"/>
                    </div><!-- end card header -->
                    <div class="card-body">
                   
                                          <div class="table-responsive" id="tablediv">
                                            
                                          <table class="table align-middle table-nowrap mb-0">
                                              <thead><tr><th>S.No.</th>
                                              <th>Name of Employee </th>
                                              <th>Employee Code</th>
                                              <th>Transferred To</th>
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
			 url: '<?php echo base_url();?>admin/ajax_oldemp_list',
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
			 url: '<?php echo base_url();?>admin/ajax_oldemp_list',
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
			 url: '<?php echo base_url();?>admin/ajax_oldemp_list',
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

     url: '<?php echo base_url();?>admin/ajax_oldemp_list',

     data: {name:name},

     success: function(response){

        $("#emps_list").html(response);

     }

 });

}else{
  $.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_oldemp_list',
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
			 url: '<?php echo base_url();?>admin/ajax_oldemp_list',
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










