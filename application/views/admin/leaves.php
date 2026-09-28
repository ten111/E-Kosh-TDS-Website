	<div class="content-wrapper">
			<section class="content-header">
				<h5>Leaves Types & Max Days</h5>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Leaves Types & Max Days</li>
				</ol>
			</section>
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
                <div class="col-md-6">
                	<?php if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
                    <div class="panel panel-primary cardbg">
                        <h6 class="title-inner text-uppercase">Add/Edit Leaves</h6>
                        <div class="panel-body">
                        <?php if(isset($_GET['leave_id'])){
						$edit=$this->db->get_where("leaves",array("leave_id"=>$_GET['leave_id']))->row();?>
                        <form class="form-inline" action="<?php echo base_url();?>admin/update_leave" method="post">
                            <input type="hidden" name="leave_id" value="<?php echo $edit->leave_id;?>" />
                              <div class="form-group "> 
                                <input type="text" required class="form-control" value="<?php echo $edit->leave_type;?>"  name="leave_type">
                              </div>
                              <div class="form-group "> 
                                <input type="number" required class="form-control" style="width:80px;" value="<?php echo $edit->max_days;?>"  name="max_days">
                              </div>
                              <button type="submit" class="btn btn-success">Update</button>
                            </form>
                        <?php }else{?>
                        <form class="form-inline" action="<?php echo base_url();?>admin/add_leave" method="post">
                              <div class="form-group "> 
                                <input type="text" required placeholder="Title" class="form-control" name="leave_type">
                              </div>
                              <div class="form-group "> 
                                <input type="number" required placeholder="Max Days" style="width:120px;" class="form-control"  name="max_days">
                              </div>
                              <button type="submit" class="btn btn-success">Add</button>
                            </form>
                        <?php }?><hr/>
                        <table class="table table-sm table-bordered">
                            <thead><tr><th>S.No.</th><th>Leave Title</th><th>Max Days</th><th>Action</th></tr></thead>
                            <tbody>
                                <?php $i=1;foreach($leaves as $dep){?>
                                <tr><td><?php echo $i;?></td>
                                    <td><?php echo $dep->leave_type;?></td>
                                    <td><?php echo $dep->max_days;?></td>
                                    <td><a href="<?php echo base_url().'admin/leaves?leave_id='.$dep->leave_id;?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
        <a href="#" id="<?php echo $dep->leave_id;?>" class="btn btn-sm btn-danger leaves_delete"><i class="fa fa-trash-o"></i></a></td></tr><?php $i++;}?>
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
		$(".leaves_delete").click(function(e){e.preventDefault();
	if(!confirm("Sure you want to delete?")){
		  return false;
		}
		var id=$(this).attr("id");$(this).closest("tr").remove();
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_leaves_delete',
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