 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
   <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Leaves Types & Max Days</h2>
                    </div>  
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-5">
                    <div class="card">
                        <div class="header">Leaves Types & Max Days</div>
                        <div class="body">
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
                        <table class="table">
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
                <div class="col-md-7">
                    <div class="card">
                        <div class="header">Leaves Settings</div>
                        <div class="body">
                        
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
</div>

<!-- Javascript -->
<script src="<?php echo base_url();?>assets/bundles/libscripts.bundle.js"></script>
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
<script src="<?php echo base_url();?>assets/bundles/vendorscripts.bundle.js"></script>
    
<script src="<?php echo base_url();?>assets/bundles/mainscripts.bundle.js"></script>
</body>
</html>


