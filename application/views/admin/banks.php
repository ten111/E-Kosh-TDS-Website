    <script src="//cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
    <div class="content-wrapper">
			
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
                <div class="col-md-4" id="addtaskform">
                	<div class="panel panel-primary cardbg">
                        <div class="panel-body">
                        <form action="<?php echo base_url();?>admin/admin_banking" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Bank Name</label>
                                    <input type="text" name="bank_name"  required class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>A/c Holder Name</label>
                                    <input type="text" name="acc_holder"  required class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>A/c  Number</label>
                                    <input type="number" name="acc_no"  required class="form-control" />
                                </div>
                                
                                <div class="form-group">
                                    <label>IFSC Code</label>
                                    <input type="text" name="ifsc"  required class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>A/c  Type</label>
                                    <select class="form-control" name="acc_type">
                                        <option value="">Select Type</option>
                                        <option value="Current Account">Current Account</option>
                                        <option value="Savings Account">Savings Account</option>
                                    </select>	
                                </div>
                                <button class="btn btn-warning btn-block" type="submit">ADD BANK</button>
                            </form>
                       	</div>
                    </div>
                </div>
                <div class="col-md-8"><?php if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
                    <div class="panel panel-primary cardbg">
                        <div class="panel-body">
                        
                        <h3>List Bank Accounts</h3>
                            	<table class="table table-bordered">
                                	<thead><tr><th>Bank Name</th><th>A/c. Details</th></tr></thead>
                                    <tbody>
                                    <?php $banks=$this->db->get("banks")->result();
									foreach($banks as $b){?>
                                    <tr><td><?php echo $b->bank_name;?></td>
                                    	<td><?php echo 'A/c. Name - '.$b->acc_name.'<br/>A/c. Number - '.$b->acc_number.'<br/>IFSC - '.$b->ifsc_code.'<br/>A/c. Type - '.$b->acc_type;?><br/><a class="btn btn-xs btn-danger bankdelete" title="delete"  href="#" id="<?php echo $b->bid;?>"><i class="fa fa-trash"></i> Remove</a></td></tr>
                                    <?php }?>
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
	$(document).ready(function(){
		$(".bankdelete").click(function(e){e.preventDefault();
			if (!confirm("Sure you want to delete?")){
					  return false;
					}
				var id=$(this).attr("id");
				$(this).closest("tr").remove();
				$.ajax({
								 type: "POST",
								 url: '<?php echo base_url();?>admin/bankdelete',
								 data: {id:id},
								 success: function(response){
									 //alert(response);
								 }
								 });
			});});
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