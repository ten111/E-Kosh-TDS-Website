    <div class="content-wrapper">
			<section class="content-header">
				<h5>List Employees</h5>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">List Leads</li>
				</ol>
			</section>
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
                <div class="col-md-12"><?php if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
                    <div class="panel panel-primary cardbg">
                        <div class="panel-body">
                        <table class="table">
                                <thead><tr><th>S.No.</th><th>Photo</th><th>Name/Basic Details</th><th>Contact</th>
                                       <th>Branch/Departments</th><th>DOB</th><th>Action</th></tr></thead>
                                <tbody id="emps_list">
                                    
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
			<div class="pull-right hidden-xs">Version 1.0.0</div>
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
			 url: '<?php echo base_url();?>admin/ajax_emp_list',
			 data: {index:1},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#emps_list").html(res);
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
    
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/datatables.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/dataTables.buttons.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/jszip.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/pdfmake.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/vfs_fonts.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/buttons.html5.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/buttons.print.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/datatable.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/nanoscroller/nanoscroller.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/custom/theme.js"></script>
</body>
</html>