	<div class="content-wrapper">
			<section class="content-header">
				<h5>My Leads</h5>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Listed All My Leads</li>
				</ol>
			</section>
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
                	<div class="col-md-3">
                    	<?php echo $this->session->flashdata("msg");
						$emp=$this->db->get_where("employees",array('emp_id'=>$this->session->userdata("user")))->row();?>
                    	<div class="panel panel-primary cardbg">
                        <div class="panel-body">
                        
                        	<form action="<?php echo base_url().'employee/newlead_submit';?>" method="post">
                                    <div class="form-group">
                                    	<label>Lead Source</label>
                                        <select class="form-control" required name="lead_src">
                                        	<option value="">Select Source</option>
                                            <option value="Campaign">Campaign</option>
                                            <option value="Cold Call">Cold Call</option>
                                            <option value="Conference">Conference</option>
                                            <option value="Data FROM TRADE INDIA">Data FROM TRADE INDIA</option>
                                            <option value="Default Lead Upload Source">Default Lead Upload Source</option>
                                            <option value="Direct Mail">Direct Mail</option>
                                            <option value="Email">Email</option>
                                            <option value="Employee">Employee</option>
                                            <option value="Existing Customer">Existing Customer</option>
                                            <option value="Other">Other</option>
                                            <option value="Public Relations">Public Relations</option>
                                            <option value="Self Generated">Self Generated</option>
                                            <option value="Trade Show">Trade Show</option>
                                            <option value="Web Site">Web Site</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label>Client Name</label>
                                        <input type="text" placeholder="" class="form-control" required name="name" />
                                    </div>
                                    <div class="form-group">
                                    	<label>Mobile</label>
                                        <input type="text" placeholder="" class="form-control" required name="mobile" />
                                    </div>
                                    <div class="form-group">
                                    	<label>Email</label>
                                        <input type="text" placeholder="" class="form-control" name="email" />
                                    </div>

                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="lead_remark" rows="3"></textarea>
                                    </div>
                                <button type="submit" class="btn btn-primary">Create Lead</button>
                            </form>
                        </div>
                        </div>
                    </div>
    	            <div class="col-md-9">
                   
                    <div class="panel panel-primary cardbg">
                        <div class="panel-body">
                    	
						<table class="table table-condensed table-striped table-bordered">
                                <thead><tr><th>S.No.</th><th>Source/Date</th><th>Name/Contact</th><th>Remarks</th><th>Action</th></tr></thead>
                                <tbody>
                                    <?php $i=1;foreach($leads as $l){?>
                <tr><td><?php echo $i;?></td>
                    <td><?php echo $l->lead_src.'<br/><span class="badge badge-dark">'.date("d M'Y",strtotime($l->lead_date)).'</span>';?></td>
                    <td><?php echo $l->contact_person.'<br/>'.$l->contact_phone1.'<br/>'.$l->email;?></td>
                    <td><?php echo $l->lead_remark;?> </td>
                    <td>
                    <a href="#" class="btn btn-danger btn-sm del_leave" id="<?php echo $l->lead_id;?>"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
                                    <?php $i++;}?>
                                </tbody>
                            </table>   
                        <div id="status_modal" class="modal fade" role="dialog" style="margin-top:80px;">
                          <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Update Leave Status</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body status_modal row">
                                <p>Loading Leave Details..</p>
                              </div>
                            </div>
                        
                          </div>
                        </div>
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
	$(".leave_status").click(function(){
			var id=$(this).attr('id');
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/leave_status',
				 data: {id:id},
				 success: function(res){
					$(".status_modal").html(res);
				 }
			});
		});
		$(".del_leave").click(function(e){e.preventDefault();
			if(!confirm("Sure you want to delete?")){
			  return false;
			}
			var id=$(this).attr("id");$(this).closest("tr").remove();
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>employee/ajax_leave_ap_delete',
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