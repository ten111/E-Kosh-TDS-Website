	<div class="content-wrapper">
			<section class="content-header">
				<h5>Listed Applied Leaves</h5>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Listed All Applied(Pending) Leaves</li>
				</ol>
			</section>
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
    	            <div class="col-md-12">
                    <div class="panel panel-primary cardbg">
                        <div class="panel-body">
                    
						<table class="table table-condensed table-striped table-bordered">
                                <thead><tr><th>S.No.</th><th>Apply Date</th><th>Emp Name/ID</th><th>Leave Date</th>
                                       <th>Days</th><th>Leave Type</th><th>Reason</th><th>Remarks</th><th>Action</th></tr></thead>
                                <tbody>
                                    <?php $i=1;foreach($leaves as $l){?>
                <tr><td><?php echo $i;?></td>
                    <td><?php echo date("d M'Y",strtotime($l->applied_date));?></td>
                    <td><?php echo $l->firstname.' '.$l->lastname;?></td>
                    <td><?php echo date("d M'Y",strtotime($l->l_from)).'<br/>'.date("d M'Y",strtotime($l->l_to));?></td>
                    <td><?php echo $l->total_days;?></td>
                    <td><?php echo $l->leave_type;?></td><td><?php echo $l->reason.'</td><td>'.$l->l_remarks;?></td>
                    <td><a href="#" class="btn btn-danger btn-sm del_leave" id="<?php echo $l->laid;?>"><i class="fa fa-trash-o"></i></a>
                    <a href="#" class="btn btn-sm btn-success leave_status" id="<?php echo $l->laid.'-'.$l->emp_id;?>"  data-toggle="modal" data-target="#status_modal"><i class="fa fa-eye"></i></a></td>
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
				 url: '<?php echo base_url();?>admin/ajax_leave_ap_delete',
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