<div class="section-body mt-3">
    <div class="container-fluid">
        <div class="row">
        	<div class="col-md-4">
            	<div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add/Edit Departments</h3>
                    </div>
                    <div class="card-body">
                	<?php if(isset($_GET['depid'])){
						$edit=$this->db->get_where("departments",array("dep_id"=>$_GET['depid']))->row();?>
                    <form action="<?php echo base_url();?>admin/update_dept" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" name="dep_id" value="<?php echo $edit->dep_id;?>" />
                         <div class="form-group">
                            <label for="email">Select Company</label>
                            <select class="form-control" name="comp_id" required>
                                <option value="">Select Company</option>
                                <?php foreach($comps as $cat){?>
                                <option value="<?php echo $cat->comp_id;?>" <?php if($edit->comp_id==$cat->comp_id){echo "selected";}?>><?php echo $cat->comp_name;?></option>
                                <?php }?>
                            </select>
                          </div>
                          <div class="form-group "> <label for="email">Department Name</label>
                            <input type="text" required class="form-control" value="<?php echo $edit->dep_name;?>"  name="dep_name">
                          </div>
                          <button type="submit" class="btn btn-success">Update Department</button>
                        </form>
                    <?php }else{?>
                    <form action="<?php echo base_url();?>admin/add_dept" method="post" enctype="multipart/form-data">
                         <div class="form-group">
                            <label for="email">Select Company</label>
                            <select class="form-control" name="comp_id" required>
                                <option value="">Select Company</option>
                                <?php foreach($comps as $cat){?>
                                <option value="<?php echo $cat->comp_id;?>"><?php echo $cat->comp_name;?></option>
                                <?php }?>
                            </select>
                          </div>
                          <div class="form-group "> <label for="email">Department Name</label>
                            <input type="text" required class="form-control" name="dep_name">
                          </div>
                          <button type="submit" class="btn btn-success">Add Department</button>
                        </form>
                    <?php }?><hr/>
                    <table class="table">
                    	<thead><tr><th>S.No.</th><th>Department</th><th>Action</th></tr></thead>
                        <tbody>
                        	<?php $i=1;foreach($deps as $dep){?>
                            <tr><td><?php echo $i;?></td>
                            	<td><?php echo $dep->dep_name;?><br/>
                                <label class="badge badge-success"><?php echo $dep->comp_name;?></label></td>
                                <td><a href="<?php echo base_url().'admin/departments?depid='.$dep->dep_id;?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
    <a href="#" id="<?php echo $dep->dep_id;?>" class="btn btn-sm btn-danger dept_delete"><i class="fa fa-trash-o"></i></a></td></tr><?php $i++;}?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
            	<div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add/Edit Designations</h3>
                    </div>
                    <div class="card-body">
                	<?php if(isset($_GET['des_id'])){
						$edit=$this->db->get_where("designations",array("des_id"=>$_GET['des_id']))->row();?>
                    <form class="form-inline"  action="<?php echo base_url();?>admin/update_desg" method="post">
                      <input type="hidden" name="des_id" value="<?php echo $edit->des_id;?>" />
                      <div class="form-group">
                        <select class="form-control" name="comp_id" id="comp_id" required>
                            <option value="">Select Company</option>
                            <?php foreach($comps as $cat){?>
                            <option value="<?php echo $cat->comp_id;?>"  <?php if($cat->comp_id==$edit->comp_id){echo "selected";}?>><?php echo $cat->comp_name;?></option>
                            <?php }?>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="dep_id" id="dep_id" required>
                        	<option value="">Select Dept</option>
                            <?php $deps=$this->db->get_where("departments",array("comp_id"=>$cat->comp_id))->result();
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
                        <select class="form-control" name="comp_id" id="comp_id" required>
                            <option value="">Select Company</option>
                            <?php foreach($comps as $cat){?>
                            <option value="<?php echo $cat->comp_id;?>"><?php echo $cat->comp_name;?></option>
                            <?php }?>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control" name="dep_id" id="dep_id" required>
                        	<option value="">Select Dept</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <input type="text" placeholder="Designation Name" name="des_name" required class="form-control">
                      </div>
                      <button type="submit" class="btn btn-warning">Add</button>
                    </form>
                    <?php }?><hr/>
                    <table class="table">
                    	<thead><tr><th>S.No.</th><th>Department/Designation</th><th>Action</th></tr></thead>
                        <tbody>
                        	<?php $i=1;foreach($des as $des){?>
                            <tr><td><?php echo $i;?></td>
                            	<td><b class="text-danger"><?php echo $des->des_name;?></b> - <?php echo $des->dep_name;?><br/>
                                <label class="badge badge-success"><?php echo $des->comp_name;?></label></td>
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
</div>
<script src="<?php echo base_url();?>assets/bundles/lib.vendor.bundle.js"></script>
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
});
</script>
<script src="<?php echo base_url();?>assets/bundles/selectize.bundle.js"></script>

<script src="<?php echo base_url();?>assets/js/core.js"></script>
<script src="<?php echo base_url();?>js/vendors/selectize.js"></script>
</body>
</html>