    <script src="//cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
    <div class="content-wrapper">
			<section class="content-header">
                        <button type="button" id="addtask" class="btn btn-warning pull-right">Add New Task</button>
				<h5>List Tasks</h5>
			</section>
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
                <div class="col-md-9" <?php if(!$this->uri->segment(3)){?> style="display:none;" <?php }?> id="addtaskform">
                	<div class="panel panel-primary cardbg">
                        <div class="panel-body">
	                	<h5 class="text-danger">Add/Edit New Task</h5>
                        <?php if($this->uri->segment(3)){?>
                			<form action="<?php echo base_url().'admin/update_task';?>" method="post" enctype="multipart/form-data">
                        	<input type="hidden" name="tsk_id" value="<?php echo $edit->tsk_id;?>" />
                            <div class="row">
                            	<div class="col-md-4">
                                	<label class="text-warning">Search for a Contract ID</label>
                                    <input type="text" id="contract" value="<?php echo $edit->tsk_contract;?>" name="contract" class="form-control" />
                                </div>
                                <ul id="search_contract_result">
                                
                                </ul>
                            </div>
                            <div class="row">
                            	<div class="form-group col-md-4">
                                	<label>Subject</label>
                                    <input type="text" name="tsk_subject" value="<?php echo $edit->tsk_subject;?>" required class="form-control" />
                                </div>
                                <div class="form-group col-md-8">
                                	<label>Task Title</label>
                                    <input type="text" name="tsk_title" value="<?php echo $edit->tsk_title;?>" required class="form-control" />
                                </div>
                                <div class="form-group col-md-3">
                                	<label>Start Date</label>
                                    <input type="date" name="tsk_start" value="<?php echo $edit->tsk_start;?>" required class="form-control" />
                                </div>
                                <div class="form-group col-md-3">
                                	<label>End Date</label>
                                    <input type="date" name="tsk_end" value="<?php echo $edit->tsk_end;?>" required class="form-control" />
                                </div>
                                <div class="form-group col-md-3">
                                	<label>Priority</label>
                                    <select class="form-control" name="tsk_priority" required>
                                    	<option value="">Select</option>
                                        <option value="Low" <?php if($edit->tsk_priority=="Low"){echo "selected";}?>>Low</option>
                                        <option value="Medium" <?php if($edit->tsk_priority=="Medium"){echo "selected";}?>>Medium</option>
                                        <option value="High" <?php if($edit->tsk_priority=="High"){echo "selected";}?>>High</option>
                                        <option value="Urgent" <?php if($edit->tsk_priority=="Urgent"){echo "selected";}?>>Urgent</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                	<label>Attach File</label>
                                    <input type="file" name="tsk_files[]" multiple class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                            	<label>Task Description</label>
                                <textarea class="form-control" name="tsk_desc" required><?php echo $edit->tsk_desc;?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Task</button>
                        </form>
                        <?php }else{?>
                        	<form action="<?php echo base_url().'admin/add_task';?>"  method="post" enctype="multipart/form-data">
                            <div class="row">
                            	<div class="col-md-4">
                                	<label class="text-warning">Search for a Contract ID</label>
                                    <input type="text" id="contract" name="contract" class="form-control" />
                                </div>
                                <ul id="search_contract_result">
                                
                                </ul>
                            </div>
                        	<div class="row">
                            	<div class="form-group col-md-4">
                                	<label>Subject</label>
                                    <input type="text" name="tsk_subject" required class="form-control" />
                                </div>
                                <div class="form-group col-md-8">
                                	<label>Task Title</label>
                                    <input type="text" name="tsk_title" required class="form-control" />
                                </div>
                                <div class="form-group col-md-3">
                                	<label>Start Date</label>
                                    <input type="date" name="tsk_start" required class="form-control" />
                                </div>
                                <div class="form-group col-md-3">
                                	<label>End Date</label>
                                    <input type="date" name="tsk_end" required class="form-control" />
                                </div>
                                <div class="form-group col-md-3">
                                	<label>Priority</label>
                                    <select class="form-control" name="tsk_priority" required>
                                    	<option value="">Select</option>
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                                        <option value="Urgent">Urgent</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                	<label>Attach File</label>
                                    <input type="file" name="tsk_files[]" multiple class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                            	<label>Task Description</label>
                                <textarea class="form-control" name="tsk_desc" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Task</button>
                        </form>
                        <?php }?>
                       	</div>
                    </div>
                </div>
                <div class="col-md-12"><?php if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
                    <div class="panel panel-primary cardbg">
                        <div class="panel-body">
                        
                        <table class="table">
                                <thead><tr><th>S.No.</th><th>Subject</th><th>Start</th><th>End</th>
                                       <th>Priority</th><th>Created Date</th><th>Status</th><th>Action</th></tr></thead>
                                <tbody id="tasks_list">
                                    
                                </tbody>
                            </table>   
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
              <div class="modal-header">
                <h4 class="modal-title">Assign Task</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body load_form row">
                <p>Loading Employees..</p>
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
	
		CKEDITOR.replace( 'tsk_desc' );
	$(document).ready(function(){
		$("#contract").keyup(function(){
			var id=$(this).val();
			if(id!=""){
				$.ajax({
					 type: "POST",
					 url: '<?php echo base_url();?>admin/search_contract',
					 data: {id:id},
					 success: function(res){//alert(res);
						// alert("OTP Sent Again");
						$("#search_contract_result").html(res);
					 }
				 });	
			}
		});
		$("#addtask").click(function(){
			$("#addtaskform").slideToggle();
		});
		var type="";
		<?php if(isset($_GET['type'])){?> type="Assigned";<?php }?>
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_tasks_list',
			 data: {index:1,type:type},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#tasks_list").html(res);
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