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
                	<?php if($this->session->flashdata("ticketshistory")!==""){echo $this->session->flashdata("ticketshistory"); }?>
                    <div class="panel panel-primary cardbg">
                        <h6 class="title-inner text-uppercase">Add/Edit Tickets history</h6>
                        <div class="panel-body">
                        <?php if($this->uri->segment(3)){
                          $id=$this->uri->segment(3);
                          $edit=$this->db->get_where("ticketshistory",array("tkh_id"=>$id))->row();
                ?>
                        <form action="<?php echo base_url();?>admin/ticketshistory_update" method="post" enctype="multipart/form-data">
                            
                            <input type="hidden" name="tkh_id" value="<?php echo $edit->tkh_id;?>" />
                             
                              <div class="form-group "> <label for="email">Tickets History</label>
                                <input type="text" required class="form-control" value="<?php echo $edit->tkh_history;?>"  name="tkh_history">
                              </div>
        
                              </div>
                              <div class="form-group col-md-5">
                                    <label for="email">Tickets  id</label>
                                    <input type="text"  class="form-control" value="<?php echo $edit->tkh_tkid;?>" name="tkh_tkid" required>
                                  </div>
                            
                                  <div class="form-group col-md-5">
                                    <label for="email">Tickets  Remark</label>
                                    <input type="text"  class="form-control" value="<?php echo $edit->tkh_remark;?>" name="tkh_remark" required>
                                  </div>  
                                  <div class="row">
                                  <div class="form-group col-md-7">
                                    <label for="email">Tickets Status</label>
                                    <select class="form-control"  value="<?php echo $edit->tkh_status;?>" name="tkh_status" required>
                                    <option value="open">open</option>
                                    <option value="in process">in process</option>
                                    <option value="close">close</option>
                                    <option value="cancelled">cancelled</option>                                    
                                    </select>
                                  </div>

                                  <div class="form-group col-md-5">
                                    <label for="email">Tickets  user</label>
                                    <input type="text"  class="form-control" value="<?php echo $edit->tkh_user;?>" name="tkh_user" required>
                                  </div>  

                                  <div class="form-group col-md-5">
                                    <label for="email">Tickets date</label>
                                    <input type="date"  class="form-control" value="<?php echo $edit->tkh_date;?>" name="tkh_date" required>
                                  </div>
                              </div>
                              <button type="submit" class="btn btn-success">Update tickets history</button>
                            </form>
                        <?php }else{?>
                        <form action="<?php echo base_url();?>admin/ticketshistory_submit" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="br_added_date" value="<?php echo date("Y-m-d");?>"/>
                            <input type="hidden" name="br_status" value=""/>
                             
                              <div class="form-group "> <label for="email">Tickets History</label>
                                <input type="text" required class="form-control" name="tkh_history">
                              </div>

                              
                              <div class="form-group "> <label for="email">Tickets Id</label>
                                <input type="text" required class="form-control" name="tkh_tkid">
                              </div>
                              
                              <div class="form-group "> <label for="email">Tickets remark</label>
                                <input type="text" required class="form-control" name="tkh_remark">
                              </div>
                           

                              <div class="row">
                                  <div class="form-group col-md-7">
                                    <label for="email">Tickets Status</label>
                                    <select class="form-control"  name="tkh_status" required>
                                    <option value="open">open</option>
                                    <option value="in process">in process</option>
                                    <option value="close">close</option>
                                    <option value="cancelled">cancelled</option>                                    
                                    </select>
                                  </div>

                                <div class="form-group "> <label for="email">Tickets user</label>
                                <input type="text" required class="form-control" name="tkh_user">
                                </div>

                                  <div class="form-group col-md-5">
                                    <label for="email">Tckets date</label>
                                    <input type="date"  class="form-control" name="tkh_date" required>
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
													<th>Tickets history</th>
                                                    <th>Tickets id</th>
                                                    <th>Tickets remark</th>
                                                    <th>Tickets user</th>
													<th>Tickets status</th>
													<th>Tickets date </th>
													
													
												</tr>
											</thead>
											<tbody>
                                            <?php
                              $data=$this->db->get("ticketshistory")->result_array();
                              foreach($data as $d){
                          ?> 
                          <tr>
                  
                              <td><?php echo $d['tkh_history'];?></td>
                              <td><?php echo $d['tkh_tkid'];?></td>
                              <td><?php echo $d['tkh_remark'];?></td>
                              <td><?php echo $d['tkh_status'];?></td>
                              <td><?php echo $d['tkh_user'];?></td>
                              <td><?php echo $d['tkh_date'];?></td>
                            
                              
                             
                             

                                                    <td>
                                <a href="<?php echo base_url().'index.php/Admin/ticketshistory_delete/'.$d['tkh_id'];?>"class="btn btn-danger">DELETE</a>
                              </td>
							  <td>
                                <a href="<?php echo base_url().'index.php/Admin/ticketshistory/'.$d['tkh_id'];?>"class="btn btn-danger">edit</a>
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