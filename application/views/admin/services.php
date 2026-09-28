    <script src="//cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
    <div class="content-wrapper">
			<section class="content-header">
                <button type="button" id="addtask" class="btn btn-warning pull-right">Add New Service</button>
				<h5>List Services</h5>
			</section>
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
                <div class="col-md-12" <?php if(!$this->uri->segment(3)){?> style="display:none;" <?php }?> id="addtaskform">
                	<div class="panel panel-primary cardbg">
                        <div class="panel-body">
                        <?php if($this->uri->segment(3)){?>
                			<form action="<?php echo base_url().'admin/update_service';?>" method="post" enctype="multipart/form-data">
                        	<input type="hidden" name="serv_id" value="<?php echo $edit->serv_id;?>" />
                            <div class="row">
                            	<div class="form-group col-md-6">
                                	<label>Title</label>
                                    <input type="text" name="serv_title" required class="form-control" value="<?php echo $edit->serv_title;?>" />
                                </div>
                                <div class="form-group col-md-4">
                                	<label>Price</label>
                                    <input type="text" name="serv_price" required class="form-control" value="<?php echo $edit->serv_price;?>" />
                                </div>
                                <div class="form-group col-md-12">
                                	<label>Short Description</label>
                                    <textarea class="form-control" name="serv_sdesc" required rows="2"><?php echo $edit->serv_sdesc;?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                            	<label>Page Description</label>
                                <textarea class="form-control" name="serv_desc" required><?php echo $edit->serv_desc;?></textarea>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-4">
                            	<label>Feature</label>
                                <textarea class="form-control" name="serv_tab1"><?php echo $edit->serv_tab1;?></textarea>
                            </div>
                            <div class="form-group  col-md-4">
                            	<label>Carrier</label>
                                <textarea class="form-control" name="serv_tab2"><?php echo $edit->serv_tab2;?></textarea>
                            </div>
                            <div class="form-group  col-md-4">
                            	<label>Sample</label>
                                <textarea class="form-control" name="serv_tab3"><?php echo $edit->serv_tab3;?></textarea>
                            </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Service</button>
                        </form>
                        <?php }else{?>
                        	<form action="<?php echo base_url().'admin/add_service';?>"  method="post" enctype="multipart/form-data">
                            
                        	<div class="row">
                            	<div class="form-group col-md-6">
                                	<label>Title</label>
                                    <input type="text" name="serv_title" required class="form-control" />
                                </div>
                                <div class="form-group col-md-4">
                                	<label>Price</label>
                                    <input type="text" name="serv_price" required class="form-control" />
                                </div>
                                <div class="form-group col-md-12">
                                	<label>Short Description</label>
                                    <textarea class="form-control" name="serv_sdesc" required rows="2"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                            	<label>Page Description</label>
                                <textarea class="form-control" name="serv_desc" required></textarea>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-4">
                            	<label>Feature</label>
                                <textarea class="form-control" name="serv_tab1"></textarea>
                            </div>
                            <div class="form-group  col-md-4">
                            	<label>Carrier</label>
                                <textarea class="form-control" name="serv_tab2"></textarea>
                            </div>
                            <div class="form-group  col-md-4">
                            	<label>Sample</label>
                                <textarea class="form-control" name="serv_tab3"></textarea>
                            </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Service</button>
                        </form>
                        <?php }?>
                       	</div>
                    </div>
                </div>
                <div class="col-md-12"><?php if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
                    <div class="panel panel-primary cardbg">
                        <div class="panel-body">
                        
                        <table class="table">
                                <thead><tr><th>S.No.</th><th>Title</th><th>Starting Price</th><th>Short Desc</th><th>Action</th></tr></thead>
                                <tbody>
                                    <?php $i=1; foreach($services as $serv){?>
                                    <tr><td><?php echo $i;?></td>
                                        <td><?php echo $serv->serv_title;?></td>
                                        <td><?php echo $serv->serv_price;?></td>
                                        <td><?php echo $serv->serv_sdesc;?></td>
                                        <td><a href="<?php echo base_url().'admin/services/'.$serv->serv_id;?>" class="btn btn-sm bg-warning"><i class="fa fa-edit"></i></a>
                                        <a href="#" id="<?php echo $serv->serv_id;?>" class="btn btn-sm bg-danger"><i class="fa fa-trash"></i></a></td>
                                        </tr>
		                            <?php $i++;}?>
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
	
		CKEDITOR.replace( 'serv_desc' );
		CKEDITOR.replace( 'serv_tab1' );
		CKEDITOR.replace( 'serv_tab2' );
		CKEDITOR.replace( 'serv_tab3' );
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