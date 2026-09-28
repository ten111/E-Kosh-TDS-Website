<div class="content-wrapper">
			<section class="content-header">
				<h5> Listed Branches</h5>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">  Listed Branches</li>
				</ol>
			</section>
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
                <div class="col-md-4">
                	<?php if($this->session->flashdata("tickets")!==""){echo $this->session->flashdata("tickets"); }?>
                    <div class="panel panel-primary cardbg">
                        <h6 class="title-inner text-uppercase">Add/Edit Tickets</h6>
                        <div class="panel-body">
                        <?php if($this->uri->segment(3)){
                          $id=$this->uri->segment(3);
                          $edit=$this->db->get_where("tickets",array("tk_id"=>$id))->row();
                ?>
                        <form action="<?php echo base_url();?>admin/tickets_update" method="post" enctype="multipart/form-data">
                            
                            <input type="hidden" name="tk_id" value="<?php echo $edit->tk_id;?>" />
                             
                              <div class="form-group "> <label for="email">Tickets Tittle</label>
                                <input type="text" required class="form-control" value="<?php echo $edit->tk_tittle;?>"  name="tk_tittle">
                              </div>
        
                              </div>
                              <div class="form-group">
                                <label for="email">Tickets Description</label>
                                <textarea class="form-control" rows="3"  name="tk_des" required><?php echo $edit->tk_des;?></textarea>
                              </div>
                              <div class="row">
                                  <div class="form-group col-md-7">
                                    <label for="email">Tickets Status</label>
                                    <select class="form-control"  value="<?php echo $edit->tk_status;?>" name="tk_status" required>
                                    <option value="">open</option>
                                    <option value="">in process</option>
                                    <option value="">close</option>
                                    <option value="">cancelled</option>
                                    
                                    </select>
                                  </div>
                                  <div class="form-group col-md-5">
                                    <label for="email">Tickets date</label>
                                    <input type="date"  class="form-control" value="<?php echo $edit->tk_date;?>" name="tk_date" required>
                                  </div>
                              </div>
                              <button type="submit" class="btn btn-success">Update tickets</button>
                            </form>
                        <?php }else{?>
                        <form action="<?php echo base_url();?>admin/tickets_submit" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="br_added_date" value="<?php echo date("Y-m-d");?>" />
                            <input type="hidden" name="br_status" value="" />
                             
                              <div class="form-group "> <label for="email">Tickets Tittle</label>
                                <input type="text" required class="form-control" name="tk_tittle">
                              </div>
                              
                              <div class="form-group">
                                <label for="email">Tickets description</label>
                                <textarea class="form-control" rows="3" name="tk_des" required></textarea>
                              </div>
                              <div class="row">
                                  <div class="form-group col-md-7">
                                    <label for="email">Tickets Status</label>
                                    <select class="form-control"  name="tk_status" required>
                                    <option value="open">open</option>
                                    <option value="in process">in process</option>
                                    <option value="close">close</option>
                                    <option value="cancelled">cancelled</option>

                                    
                                    
                                    </select>
                                  </div>
                                  <div class="form-group col-md-5">
                                    <label for="email">Tckets date</label>
                                    <input type="date"  class="form-control" name="tk_date" required>
                                  </div>
                              </div>
                              <button type="submit" class="btn btn-success">Add Tickets</button>
                            </form>
                        <?php }?>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="panel panel-primary cardbg">
                        <h6 class="title-inner text-uppercase">Add/Edit Tickets</h6>
                        <div class="panel-body">
                        <table class="datatable table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>Tickets tittle</th>
                          <th>Tickets description</th>
													<th>Tickets status</th>
													<th>Tickets date </th>
													
													
												</tr>
											</thead>
											<tbody>
                                            <?php
                              $data=$this->db->get("tickets")->result_array();
                              foreach($data as $d){
                          ?> 
                          <tr>
                  
                              <td><?php echo $d['tk_tittle'];?></td>
                              <td><?php echo $d['tk_des'];?></td>
                              <td><?php echo $d['tk_status'];?></td>
                              <td><?php echo $d['tk_date'];?></td>
                            
                              
                             
                             

                                                    <td>
                                <a href="<?php echo base_url().'index.php/Admin/tickets_delete/'.$d['tk_id'];?>"class="btn btn-danger">DELETE</a>
                              </td>
							  <td>
                                <a href="<?php echo base_url().'index.php/Admin/tickets/'.$d['tk_id'];?>"class="btn btn-danger">edit</a>
                              </td>
													<?php }?>	
													
												</tr>
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
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_branches_list',
			 data: {index:1},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#branches_list").html(res);
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
	<script src="<?php echo base_url();?>adminassets/assets/js/nanoscroller/nanoscroller.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/custom/theme.js"></script>
</body>
</html>