 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
   <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Listed All Employees
</h2>
                    </div>  
                </div>
            </div>
           
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header"> Listed All Employees</div>
                        <div class="body">
                        <table class="table">
                                <thead><tr><th>S.No.</th><th>Photo</th><th>Name/Basic Details</th><th>Contact</th>
                                       <th>Departments</th><th>DOB</th><th>Action</th></tr></thead>
                                <tbody id="emps_list">
                                    
                                </tbody>
                            </table>   
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
    
</div>

<!-- Javascript -->
<script src="<?php echo base_url();?>assets/bundles/libscripts.bundle.js"></script>    
<script>
$(document).ready(function(){
	$.ajax({
		 type: "POST",
		 url: '<?php echo base_url();?>admin/ajax_emp_list',
		 data: {index:1},
		 success: function(res){//alert(res);
			// alert("OTP Sent Again");
			$("#emps_list").html(res);
		 }
	 });
});
</script>
<script src="<?php echo base_url();?>assets/bundles/vendorscripts.bundle.js"></script>
    
<script src="<?php echo base_url();?>assets/bundles/mainscripts.bundle.js"></script>
</body>
</html>


