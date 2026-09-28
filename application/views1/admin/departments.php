<div class="content-wrapper">
    <section class="content-header">
        <h5>Departments/Designations</h5>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Departments/Designations</li>
        </ol>
    </section>
    <section class="content">
        <!-- Default box -->
        <div class="row clearfix">
        <div class="col-md-5">
            <?php if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
            <div class="panel panel-primary cardbg">
                <h6 class="title-inner text-uppercase">Add/Edit Departments</h6>
                <div class="panel-body">
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
                        <input type="text" required placeholder="Department Title" class="form-control" name="dep_name">
                      </div>
                      <button type="submit" class="btn btn-success">Add</button>
                    </form>
                <?php }?><hr/>
                <table class="table table-sm table-bordered table-condensed table-striped">
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
        <div class="col-md-7">
            <div class="panel panel-primary cardbg">
                <h6 class="title-inner text-uppercase">Add/Edit Designations</h6>
                <div class="panel-body">
                <?php if(isset($_GET['des_id'])){
                $edit=$this->db->get_where("designations",array("des_id"=>$_GET['des_id']))->row();?>
                <form   action="<?php echo base_url();?>admin/update_desg" method="post">
                  <input type="hidden" name="des_id" value="<?php echo $edit->des_id;?>" />
                  <div class="row"><div class="col-md-5">
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
                  </div>
                  <?php $roles=explode(",",$edit->roles);?>
                  <div class="col-md-7"><div class="row">
                <div class="checkbox col-md-6">
                    <input name="roles[]" <?php if(in_array("Manage HR",$roles)){echo 'checked';}?> value="Manage HR" id="Manage HR" type="checkbox">
                    <label for="Manage HR"> Manage HR</label>
                </div>
                <div class="checkbox col-md-6">
                    <input name="roles[]" <?php if(in_array("Co-Ordinator",$roles)){echo 'checked';}?> value="Co-Ordinator" id="Co-Ordinator" type="checkbox">
                    <label for="Co-Ordinator"> Co-Ordinator</label>
                </div>
                <div class="checkbox col-md-6">
                    <input name="roles[]" <?php if(in_array("Manage Leads",$roles)){echo 'checked';}?> value="Manage Leads" id="Manage Leads" type="checkbox">
                    <label for="Manage Leads"> Manage Leads</label>
                </div>
                <div class="checkbox col-md-6">
                    <input name="roles[]" <?php if(in_array("Manage Tasks",$roles)){echo 'checked';}?> value="Manage Tasks" id="Manage Tasks" type="checkbox">
                    <label for="Manage Tasks"> Manage Tasks</label>
                </div></div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-warning">Update</button>
                </form>
                <?php }else{?>
                <form action="<?php echo base_url();?>admin/add_desg" method="post">
                  <div class="row">
                  	<div class="col-md-5">
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
                    </div>
                    <div class="col-md-7"><div class="row">
                            <div class="checkbox col-md-6">
                                <input name="roles[]" value="Manage HR" id="Manage HR" type="checkbox">
                                <label for="Manage HR"> Manage HR</label>
                            </div>
                            <div class="checkbox col-md-6">
                                <input name="roles[]" value="Co-Ordinator" id="Co-Ordinator" type="checkbox">
                                <label for="Co-Ordinator"> Co-Ordinator</label>
                            </div>
                            <div class="checkbox col-md-6">
                                <input name="roles[]" value="Manage Leads" id="Manage Leads" type="checkbox">
                                <label for="Manage Leads"> Manage Leads</label>
                            </div>
                            <div class="checkbox col-md-6">
                                <input name="roles[]" value="Manage Tasks" id="Manage Tasks" type="checkbox">
                                <label for="Manage Tasks"> Manage Tasks</label>
                            </div></div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-warning">Add</button>
                </form>
                <?php }?><hr/>
                <table class="table table-sm table-bordered table-condensed table-striped">
                    <thead><tr><th>S.No.</th><th>Designation</th><th>Department</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php $i=1;foreach($des as $des){?>
                        <tr><td><?php echo $i;?></td>
                            <td><b class="text-danger"><?php echo $des->des_name;?></b><br/>
                            <small><?php echo $des->roles;?></small></td><td><?php echo $des->dep_name;?></td>
                            <td><a href="<?php echo base_url().'admin/departments?des_id='.$des->des_id;?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
<a href="#" id="<?php echo $des->des_id;?>" class="btn btn-sm btn-danger desg_delete"><i class="fa fa-trash-o"></i></a></td></tr><?php $i++;}?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>
    <a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
          Version 1.0.0
        </div>
        <p class="mb-0">Copyright © 2019 <a target="_blank" href="#">Admin</a>. All rights reserved.</p>
    </footer>
</div>

<script src="<?php echo base_url();?>adminassets/assets/js/jquery/slim.min.js"></script>
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