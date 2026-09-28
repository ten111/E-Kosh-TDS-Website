 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
   <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Departments/Designations</h2>
                    </div>  
                </div>
            </div>
           
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="card">
                        <div class="header">Add/Edit Departments</div>
                        <div class="body">
                        <?php if(isset($_GET['depid'])){
						$edit=$this->db->get_where("departments",array("dep_id"=>$_GET['depid']))->row();?>
                        <form class="form-inline" action="<?php echo base_url();?>admin/update_dept" method="post" enctype="multipart/form-data">
                            
                            <input type="hidden" name="dep_id" value="<?php echo $edit->dep_id;?>" />
                             
                              <div class="form-group "> 
                                <input type="text" required class="form-control" value="<?php echo $edit->dep_name;?>"  name="dep_name">
                              </div>
                              <button type="submit" class="btn btn-success">Update</button>
                            </form>
                        <?php }else{?>
                        <form class="form-inline" action="<?php echo base_url();?>admin/add_dept" method="post" enctype="multipart/form-data">
                             
                              <div class="form-group "> 
                                <input type="text" required class="form-control" name="dep_name">
                              </div>
                              <button type="submit" class="btn btn-success">Add</button>
                            </form>
                        <?php }?><hr/>
                        <table class="table">
                            <thead><tr><th>S.No.</th><th>Department</th><th>Action</th></tr></thead>
                            <tbody>
                                <?php $i=1;foreach($deps as $dep){?>
                                <tr><td><?php echo $i;?></td>
                                    <td><?php echo $dep->dep_name;?><br/>
                                    </td>
                                    <td><a href="<?php echo base_url().'admin/departments?depid='.$dep->dep_id;?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
        <a href="#" id="<?php echo $dep->dep_id;?>" class="btn btn-sm btn-danger dept_delete"><i class="fa fa-trash-o"></i></a></td></tr><?php $i++;}?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="header">Add/Edit Designations</div>
                        <div class="body">
                        <?php if(isset($_GET['des_id'])){
						$edit=$this->db->get_where("designations",array("des_id"=>$_GET['des_id']))->row();?>
                        <form class="form-inline"  action="<?php echo base_url();?>admin/update_desg" method="post">
                          <input type="hidden" name="des_id" value="<?php echo $edit->des_id;?>" />
                          
                          <div class="form-group">
                            <select class="form-control" name="dep_id" id="dep_id" required>
                                <option value="">Select Department</option>
                                <?php $deps=$this->db->get("departments")->result();
                                foreach($deps as $d){?>
                                <option value="<?php echo $d->dep_id;?>" <?php if($d->dep_id==$edit->dep_id){echo "selected";}?>>
                                <?php echo $d->dep_name;?></option><?php }?>
                            </select>
                          </div>
                          <div class="form-group">
                            <input type="text" placeholder="Designation Name" value="<?php echo $edit->des_name;?>" name="des_name" required class="form-control">
                          </div>
                          <button type="submit" class="btn btn-warning">Update</button>
                        </form>
                        <?php }else{?>
                        <form class="form-inline"  action="<?php echo base_url();?>admin/add_desg" method="post">
                          
                          <div class="form-group">
                            <select class="form-control" name="dep_id" id="dep_id" required>
                                <option value="">Select Department</option>
                                <?php $deps=$this->db->get("departments")->result();
                                foreach($deps as $d){?>
                                <option value="<?php echo $d->dep_id;?>" >
                                <?php echo $d->dep_name;?></option><?php }?>
                            </select>
                          </div>
                          <div class="form-group">
                            <input type="text" placeholder="Designation Name" name="des_name" required class="form-control">
                          </div>
                          <button type="submit" class="btn btn-warning">Add</button>
                        </form>
                        <?php }?><hr/>
                        <table class="table">
                            <thead><tr><th>S.No.</th><th>Designation</th><th>Department</th><th>Action</th></tr></thead>
                            <tbody>
                                <?php $i=1;foreach($des as $des){?>
                                <tr><td><?php echo $i;?></td>
                                    <td><b class="text-danger"><?php echo $des->des_name;?></b></td><td><?php echo $des->dep_name;?></td>
                                    <td><a href="<?php echo base_url().'admin/departments?des_id='.$des->des_id;?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
        <a href="#" id="<?php echo $des->des_id;?>" class="btn btn-sm btn-danger desg_delete"><i class="fa fa-trash-o"></i></a></td></tr><?php $i++;}?>
                            </tbody>
                        </table>
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
	$("#comp_id").change(function(){
		var comp_id=$(this).val();
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_comp_dept',
			 data: {id:comp_id},
			 success: function(res){
				 $("#dep_id").html(res);
			 }
		});
	});
	$(".desg_delete").click(function(e){e.preventDefault();
	if(!confirm("Sure you want to delete?")){
		  return false;
		}
		var id=$(this).attr("id");$(this).closest("tr").remove();
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_desg_delete',
			 data: {id:id},
			 success: function(response){
				 //alert(response);
			 }
		});
	});
	$(".dept_delete").click(function(e){e.preventDefault();
	if(!confirm("Sure you want to delete?")){
		  return false;
		}
		var id=$(this).attr("id");$(this).closest("tr").remove();
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_dept_delete',
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


