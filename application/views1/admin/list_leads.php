    <!--<style>
	.form-inline label{ display:inline;}
	</style>-->
    <div class="content-wrapper">
			<section class="content-header">
				<h5>List Leads</h5>
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
                        
                        <form class="form-inline" action="<?php echo base_url().'admin/assign_leads';?>" method="post">
                          <?php if(!$this->uri->segment(3)){?>
                          <div class="form-group">
                            <select class="form-control" name="branch_id" id="branch_id" required>
                                <?php $branch=$this->db->get("branches")->result();
                                echo '<option value="">Select Branch</option>';
                                foreach($branch as $d){echo '<option value="'.$d->br_id.'">'.$d->br_name.' '.$d->br_code.'</option>';}?>
                            </select>
                          </div>
                          <div class="form-group">
                          	<select class="form-control" name="dept" id="dept" required>
                                <?php $dept=$this->db->get("departments")->result();
                                echo '<option value="">Select Dept.</option>';
                                foreach($dept as $d){echo '<option value="'.$d->dep_id.'">'.$d->dep_name.'</option>';}?>
                            </select>	
                          </div>
                          <div class="form-group">
                          	<select class="form-control" name="desg" id="desg" required>
                            	<option value="">Select Designation</option>
                            </select>	
                          </div>
                          <div class="form-group">
                          	<select class="form-control" name="emp" id="emps" required>
                            	<option value="">Select Employee</option>
                            </select>	
                          </div>
                          <button type="submit" class="btn btn-success">Assign</button>
                          <?php }?>
                        <table class="table table-sm table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr bgcolor="#CCCCCC"><th><div class="checkbox">
                            <input type="checkbox" id="checkAll" value="checkall" /> <label for="checkAll">All</label></div></th>
                            	<th><select class="form-control" style="width:80px;" id="showdata">
                                	<option value="10">10</option>
                                	<option value="25">25</option>
                                	<option value="100">100</option>
                                	<option value="200">200</option>
                                	<option value="500">500</option>
                                	</select></th><th colspan="5"></th></tr>
                            <tr bgcolor="#FFCC00"><th>S.No.</th><th>Company/Business</th><th>BusinessType</th><th>Lead Source/Date</th><th>Contact Details</th>
                                   	   <th>Remark</th><th>Action</th></tr></thead>
                                   <tbody id="leads_list">
                                       
                                   </tbody>
                        </table>
                        </form>
                        </div>
                    </div>
                </div>
                
            </div>
			</section>
		</div>
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header" style="background:#FC0;">
                <h5 class="modal-title">Lead Followup <b id="leadid"></b></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" id="lead_details">
                <p><i class="fa fa-spin fa-spinner"></i> Loading Lead Details...</p>
              </div>
            </div>
        
          </div>
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
		$("#dept").change(function(){
			var id=$(this).val();
			
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/ajax_designation',
				 data: {id:id},
				 success: function(res){//alert(res);
					// alert("OTP Sent Again");
					$("#desg").html(res);
				 }
			 });
			 
		});
		$("#desg").change(function(){
			var br=$("#branch_id").val();
			var des=$(this).val();
			if(br!=""){
			 $.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/ajax_emps',
				 data: {des:des,br:br},
				 success: function(res){
					 console.log(res);
					// alert("OTP Sent Again");
					$("#emps").html(res);
				 }
			 });}
		});
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_lead_list',
			 data: {limit:10,assign:"<?php echo $this->uri->segment(3);?>"},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#leads_list").html(res);
			 }
		 });
		$("#showdata").change(function(){
			var id=$(this).val();
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/ajax_lead_list',
				 data: {limit:id,assign:"<?php echo $this->uri->segment(3);?>"},
				 success: function(res){//alert(res);
					// alert("OTP Sent Again");
					$("#leads_list").html(res);
				 }
			 });
		});
		$(".del_lead").click(function(e){e.preventDefault();
		if (!confirm("Sure you want to delete?")){
				  return false;
				}
			var id=$(this).attr("id");$(this).closest("tr").remove();
			$.ajax({
							 type: "POST",
							 url: '<?php echo base_url();?>admin/ajax_del_lead',
							 data: {id:id},
							 success: function(response){
								 //alert(response);
							 }
							 });
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