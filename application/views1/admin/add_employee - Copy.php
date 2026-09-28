 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
             <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Add/Edit Employees</h2>
                    </div>     
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">Add/Edit Employee Details</div>
                        <div class="body">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Home">Personal Details</a></li>
                                <?php if($this->uri->segment(3)){?>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Profile">Contact Details</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Contact">Bank Details</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#employment">Employement History/Docs</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#office">Official Status</a></li>
                                <?php }?>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="Home">
                    				<form action="<?php echo base_url().'admin/add_emp_submit';?>" method="post" enctype="multipart/form-data">
                                	<div class="row">
                                    	<div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Select Branch</label>
                                                <select class="form-control" name="branch_id" id="branch_id" required>
                                                    <?php $branch=$this->db->get("branches")->result();
		echo '<option value="">Select Branch</option>';
		foreach($branch as $d){echo '<option value="'.$d->br_id.'">'.$d->br_name.'</option>';}?>
                                                </select>
                                            </div>
                                            <?php $deps=$this->db->get("departments")->result();
//print_r($deps);exit;
foreach($deps as $dep){?>
<p class="text-danger" style="margin-bottom:5px;"><?php echo $dep->dep_name;?></p><?php 
$desg=$this->db->get_where("designations",array("dep_id"=>$dep->dep_id))->result();
foreach($desg as $des){?>
<div class="fancy-checkbox" style="margin-bottom:5px;">
    <label><input type="checkbox" name="des[]" value="<?php echo $des->des_id;?>"><span><?php echo $des->des_name;?></span></label>
</div>
<?php }?><?php }?>
                                        </div>
                                        <div class="col-md-8">
                                        	<div class="row">
                                            	<div class="form-group col-md-4">
                                                	<label>First Name</label>
                                                    <input type="text" name="firstname" required class="form-control" />
                                                </div>
                                                <div class="form-group col-md-4">
                                                	<label>Last Name</label>
                                                    <input type="text" name="lastname" required class="form-control" />
                                                </div>
                                                <div class="form-group col-md-4">
                                                	<label>Father Name</label>
                                                    <input type="text" name="father" required class="form-control" />
                                                </div>
                                                <div class="form-group col-md-3">
                                                	<label>Gender</label><br/>
      <label class="fancy-radio custom-color-green"><input name="gender" value="Male" type="radio" checked><span><i></i>Male</span></label>
    <label class="fancy-radio custom-color-green"><input name="gender" value="Female" type="radio"><span><i></i>Female</span></label>
                                                </div>
                                                <div class="form-group col-md-3">
                                                	<label>Marital Status</label><br/>
      <label class="fancy-radio custom-color-green"><input name="marital" value="Married" type="radio" checked><span><i></i>Married</span></label>
    <label class="fancy-radio custom-color-green"><input name="marital" value="Unmarried" type="radio"><span><i></i>Unmarried</span></label>
                                                </div>
                                                <div class="form-group col-md-4">
                                                	<label>Date of Birth</label>
                                                    <input type="date" name="dob" required class="form-control" />
                                                </div>
                                                <div class="form-group col-md-3">
                                                	<label>PF Number</label>
                                                    <input type="text" name="pf_number" required class="form-control" />
                                                </div>
                                                <div class="form-group col-md-3">
                                                	<label>ESIC Number</label>
                                                    <input type="text" name="esic_number" required class="form-control" />
                                                </div>
                                                <div class="form-group col-md-3">
                                                	<label>UAN  Number</label>
                                                    <input type="text" name="uan_number" required class="form-control" />
                                                </div>
                                                <div class="form-group col-md-3">
                                                	<label>Profile Photo</label>
                                                    <input type="file" name="profile_photo" required class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                        <button type="submit" class="btn btn-warning">Save Details</button>
                                     </form>
                                </div>
                                <?php if($this->uri->segment(3)){
									$emp=$this->db->get_where("employees",array("emp_id"=>$this->uri->segment(3)))->row();?>
                                <div class="tab-pane" id="Profile">
                                    <form action="<?php echo base_url().'admin/update_profile1';?>" method="post">
                                    <input type="hidden" name="emp_id" value="<?php echo $this->uri->segment(3);?>" />
                                    <div class="row">
                                    	<div class="col-md-4">
                                        	<div class="form-group">
                                               <label>Email id</label>
                                               <input type="email" value="<?php echo $emp->emp_email;?>" required class="form-control" name="emp_email" /> 
                                               <small class="text-warning">Default Login ID</small>
                                            </div>
                                        	<div class="row">
                                            	<div class="form-group col-md-6">
                                                   <label>Mobile 1 </label>
                                                   <input type="text" value="<?php echo $emp->mob1;?>" required class="form-control" name="mob1" /> 
                                                   <small class="text-warning">Default Password</small>
                                                </div>
                                                <div class="form-group col-md-6">
                                                   <label>Mobile 2</label>
                                                   <input type="text" value="<?php echo $emp->mob2;?>" class="form-control" name="mob2" /> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        	<div class="form-group">
                                        	<label>Local Address</label>
                                            <textarea class="form-control" required rows="2" name="l_add"><?php echo $emp->l_add;?></textarea>
                                            </div>
                                            <div class="row">
                                            	<div class="form-group col-md-6">
                                                   <label>State</label>
                                                   <input type="text" required value="<?php echo $emp->l_state;?>" class="form-control" name="l_state" /> 
                                                </div>
                                                <div class="form-group col-md-6">
                                                   <label>City</label>
                                                   <input type="text" required value="<?php echo $emp->l_city;?>" class="form-control" name="l_city" /> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <button type="submit" class="btn btn-warning">Save Details</button>
                                     </form>
                                </div>
                                <div class="tab-pane" id="Contact">
                                	<form action="<?php echo base_url().'admin/update_bank';?>" method="post">
                                    <input type="hidden" name="emp_id" value="<?php echo $this->uri->segment(3);?>" />
                                    <div class="row">
                                    	<div class="col-md-5">
                                            <div class="form-group">
                                            	<label>Bank Name</label>
                                                <input type="text" required value="<?php echo $emp->bank_name;?>" class="form-control" name="bank_name" /> 
                                            </div>
                                            <div class="form-group">
                                            	<label>Branch</label>
                                                <input type="text" required value="<?php echo $emp->bank_branch;?>" class="form-control" name="bank_branch" /> 
                                            </div>
                                            
                                        	<div class="row">
                                            	<div class="form-group col-md-8">
                                                    <label>Account Name</label>
                                                    <input type="text" required value="<?php echo $emp->acc_name;?>" class="form-control" name="acc_name" /> 
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label>Account Type</label>
                                                    <select class="form-control" required name="acc_type">
                                                        <option value="">Select</option>
                                                        <option value="Current" <?php if($emp->acc_type=="Current"){echo "selected";}?>>Current</option>
                                                        <option value="Savings" <?php if($emp->acc_type=="Savings"){echo "selected";}?>>Savings</option>
                                                    </select> 
                                                </div>
                                            	<div class="form-group col-md-8">
                                                   <label>Account Number</label>
                                                   <input type="text" required class="form-control" value="<?php echo $emp->acc_number;?>" name="acc_number" /> 
                                                </div>
                                                <div class="form-group col-md-4">
                                                   <label>IFSC Code</label>
                                                   <input type="text" required class="form-control" value="<?php echo $emp->ifsc_code;?>" name="ifsc_code" /> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-warning">Save Details</button>
                                    </form>
                                </div>
                                <div class="tab-pane" id="employment">
                               		<form action="<?php echo base_url().'admin/update_emp_details';?>" method="post">
                                    <input type="hidden" name="emp_id" value="<?php echo $this->uri->segment(3);?>" />
                                    <div class="row">
                                    	<div class="col-md-5">
                                            <div class="form-group">
                                            	<label>Previous Company Name(If/Any)</label>
                                                <input type="text" required value="<?php echo $emp->pre_comp;?>" class="form-control" name="pre_comp" /> 
                                            </div><div class="row">
                                            <div class="form-group col-md-6">
                                            	<label>Last Salary</label>
                                                <input type="text" required value="<?php echo $emp->last_salary;?>" class="form-control" name="last_salary" /> 
                                            </div>
                                            <div class="form-group col-md-6">
                                            	<label>Position</label>
                                                <input type="text" required value="<?php echo $emp->pre_position;?>" class="form-control" name="pre_position" /> 
                                            </div>
                                            </div>
                                            <h5 class="text-warning">Work Duration</h5>
                                        	<div class="row">
                                            	<div class="form-group col-md-6">
                                                   <label>From Date</label>
                                                   <input type="date" required value="<?php echo $emp->wfrom_date;?>" class="form-control" name="wfrom_date" /> 
                                                </div>
                                                <div class="form-group col-md-6">
                                                   <label>To Date</label>
                                                   <input type="date" required value="<?php echo $emp->wto_date;?>" class="form-control" name="wto_date" /> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-warning">Save Details</button>
                                    </form>
                                </div>
                                <div class="tab-pane" id="office">
                                </div>
                                <?php }?>
                            </div>
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
$(document).ready(function(){//alert("asdf");
	
});
</script>     
<script src="<?php echo base_url();?>assets/bundles/vendorscripts.bundle.js"></script>

<script src="<?php echo base_url();?>assets/bundles/mainscripts.bundle.js"></script>
</body>
</html>
