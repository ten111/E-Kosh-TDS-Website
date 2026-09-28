<div class="section-body mt-3">
    <div class="container-fluid">
        <div class="row">
        	<div class="col-md-4">
            	<div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add/Edit Company Branches</h3>
                    </div>
                    <div class="card-body">
                	<?php if($this->uri->segment(3)){?>
                    <form action="<?php echo base_url();?>admin/update_branch" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" name="br_id" value="<?php echo $edit->br_id;?>" />
                         <div class="form-group">
                            <label for="email">Select Company</label>
                            <select class="form-control" name="comp_id" required>
                                <option value="">Select Company</option>
                                <?php foreach($comps as $cat){?>
                                <option value="<?php echo $cat->comp_id;?>" <?php if($edit->comp_id==$cat->comp_id){echo "selected";}?>><?php echo $cat->comp_name;?></option>
                                <?php }?>
                            </select>
                          </div>
                          <div class="form-group "> <label for="email">Branch Name</label>
                            <input type="text" required class="form-control" value="<?php echo $edit->br_name;?>"  name="br_name">
                          </div>
                          <div class="form-group ">
                            <label for="email">Branch Code</label>
                            <input type="text"  class="form-control" value="<?php echo $edit->br_code;?>"  name="br_code" required>
                          </div>
                          <div class="form-group ">
                            <label for="email">Branch Email</label>
                            <input type="email"  class="form-control" value="<?php echo $edit->br_mail;?>"  name="br_mail" required>
                          </div>
                          <div class="row">
                              <div class="form-group col-md-6">
                                <label for="email">Phone 1</label>
                                <input type="text"  class="form-control"  value="<?php echo $edit->br_phone1;?>"  name="br_phone1" required>
                              </div>
                              <div class="form-group col-md-6">
                                <label for="email">Phone 2</label>
                                <input type="text"  class="form-control"  value="<?php echo $edit->br_phone2;?>" name="br_phone2">
                              </div>
                          </div>
                          <div class="form-group">
                            <label for="email">Address</label>
                            <textarea class="form-control" rows="3"  name="br_address" required><?php echo $edit->br_address;?></textarea>
                          </div>
                          <div class="row">
                              <div class="form-group col-md-7">
                                <label for="email">State</label>
                                <select class="form-control" name="br_state" required>
                                <option value="">Select State</option>
                                <?php foreach($states as $st){?>
                                <option value="<?php echo $st->state_id;?>" <?php if($edit->br_state==$st->state_id){echo "selected";}?>><?php echo $st->state_name;?></option>
                                <?php }?>
                            	</select>
                              </div>
                              <div class="form-group col-md-5">
                                <label for="email">City</label>
                                <input type="text"  class="form-control" value="<?php echo $edit->br_city;?>" name="br_city" required>
                              </div>
                          </div>
                          <button type="submit" class="btn btn-success">Update Branch</button>
                        </form>
                    <?php }else{?>
                    <form action="<?php echo base_url();?>admin/add_branch" method="post" enctype="multipart/form-data">
                    	<input type="hidden" name="br_added_date" value="<?php echo date("Y-m-d");?>" />
                        <input type="hidden" name="br_status" value="" />
                         <div class="form-group">
                            <label for="email">Select Company</label>
                            <select class="form-control" name="comp_id" required>
                                <option value="">Select Company</option>
                                <?php foreach($comps as $cat){?>
                                <option value="<?php echo $cat->comp_id;?>"><?php echo $cat->comp_name;?></option>
                                <?php }?>
                            </select>
                          </div>
                          <div class="form-group "> <label for="email">Branch Name</label>
                            <input type="text" required class="form-control" name="br_name">
                          </div>
                          <div class="form-group ">
                            <label for="email">Branch Code</label>
                            <input type="text"  class="form-control" name="br_code" required>
                          </div>
                          <div class="form-group ">
                            <label for="email">Branch Email</label>
                            <input type="email"  class="form-control" name="br_mail" required>
                          </div>
                          <div class="row">
                              <div class="form-group col-md-6">
                                <label for="email">Phone 1</label>
                                <input type="text"  class="form-control" name="br_phone1" required>
                              </div>
                              <div class="form-group col-md-6">
                                <label for="email">Phone 2</label>
                                <input type="text"  class="form-control" name="br_phone2">
                              </div>
                          </div>
                          <div class="form-group">
                            <label for="email">Address</label>
                            <textarea class="form-control" rows="3" name="br_address" required></textarea>
                          </div>
                          <div class="row">
                              <div class="form-group col-md-7">
                                <label for="email">State</label>
                                <select class="form-control" name="br_state" required>
                                <option value="">Select State</option>
                                <?php foreach($states as $st){?>
                                <option value="<?php echo $st->state_id;?>"><?php echo $st->state_name;?></option>
                                <?php }?>
                            	</select>
                              </div>
                              <div class="form-group col-md-5">
                                <label for="email">City</label>
                                <input type="text"  class="form-control" name="br_city" required>
                              </div>
                          </div>
                          <button type="submit" class="btn btn-success">Add Branch</button>
                        </form>
                    <?php }?>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <table class="table">
                        <thead><tr><th>S.No.</th><th>Company</th><th>Branch</th><th>Contact</th><th>Address</th><th>Action</th></tr></thead>
                        <tbody id="branches_list">
                            
                        </tbody>
                    </table>      
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
<script src="<?php echo base_url();?>assets/bundles/selectize.bundle.js"></script>

<script src="<?php echo base_url();?>assets/js/core.js"></script>
<script src="<?php echo base_url();?>js/vendors/selectize.js"></script>
</body>
</html>