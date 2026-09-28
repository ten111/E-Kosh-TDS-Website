	<div class="content-wrapper">
			<section class="content-header">
				<h5>Add/Edit Employee Details</h5>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Add/Edit Employee Details</li>
				</ol>
			</section>
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
                <div class="col-md-12">
                	<?php if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
                    <div class="panel panel-primary cardbg">
                        <h6 class="title-inner text-uppercase">Add/Edit Employee Details</h6>
                        <div class="panel-body">
                        	<ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Home">Personal Details</a></li>
                                <?php if($this->uri->segment(3)){?>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Profile">Contact Details</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Contact">Bank Details</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#employment">Employement History/Docs</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#office">Official Joining Details</a></li>
                                <?php }?>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="Home">
                                <?php if($this->uri->segment(3)){
									$emp=$this->db->get_where("employees",array("emp_id"=>$this->uri->segment(3)))->row();
									$des=$this->db->get_where("emp_des",array("emp_id"=>$this->uri->segment(3)))->result();
									$dss=array();foreach($des as $dd){array_push($dss,$dd->des_id);}
									//print_r($dss);?>
                                	<form action="<?php echo base_url().'admin/update_emp_submit';?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="emp_id" value="<?php echo $emp->emp_id;?>" />
                                	<div class="row">
                                    	<div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Select Branch</label>
                                                <select class="form-control" name="branch_id" id="branch_id" required>
                                                    <?php $branch=$this->db->get("branches")->result();
		echo '<option value="">Select Branch</option>';
		foreach($branch as $d){?><option value="<?php echo $d->br_id;?>" <?php if($d->br_id==$emp->branch_id){echo "selected";}?>><?php echo $d->br_name;?></option><?php }?>
                                                </select>
                                            </div>
                                            <?php $deps=$this->db->get("departments")->result();
//print_r($deps);exit;
foreach($deps as $dep){?>
<p class="text-danger" style="margin-bottom:5px;"><?php echo $dep->dep_name;?></p><?php 
$desg=$this->db->get_where("designations",array("dep_id"=>$dep->dep_id))->result();
foreach($desg as $des){?>
<div class="checkbox">
    <input name="des[]" value="<?php echo $des->des_id;?>" <?php if(in_array($des->des_id,$dss)){echo "checked";}?> id="checkbox<?php echo $des->des_id;?>" type="checkbox">
    <label for="checkbox<?php echo $des->des_id;?>"><?php echo $des->des_name;?></label>
</div>
<?php }?><?php }?>
                                        </div>
                                        <div class="col-md-8">
                                        	<div class="row">
                                            	<div class="form-group col-md-4">
                                                	<label>First Name</label>
                                                    <input type="text" value="<?php echo $emp->firstname;?>" name="firstname" required class="form-control" />
                                                </div>
                                                <div class="form-group col-md-4">
                                                	<label>Last Name</label>
                                                    <input type="text" value="<?php echo $emp->lastname;?>" name="lastname" required class="form-control" />
                                                </div>
                                                <div class="form-group col-md-4">
                                                	<label>Father Name</label>
                                                    <input type="text" value="<?php echo $emp->father;?>" name="father" required class="form-control" />
                                                </div>
                                                <div class="form-group col-md-3">
                                                	<label>Gender</label><br/>
                                                    <div class="radio radio-info radio-inline">
                                                        <input name="gender" <?php if($emp->gender=="Male"){echo "selected";}?> value="Male" id="Male" type="radio" checked>
                                                        <label for="Male"> Male</label>
                                                    </div>
                                                    <div class="radio radio-info radio-inline">
                                                        <input name="gender" <?php if($emp->gender=="Female"){echo "selected";}?> value="Female" id="Female" type="radio">
                                                        <label for="Female"> Female</label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                	<label>Marital Status</label><br/>
                                                    <div class="radio radio-info radio-inline">
                                                        <input name="marital" value="Married" <?php if($emp->marital=="Married"){echo "selected";}?> id="Married" type="radio" checked>
                                                        <label for="Married"> Married</label>
                                                    </div>
                                                    <div class="radio radio-info radio-inline">
                                                        <input name="marital" value="Unmarried" <?php if($emp->marital=="Unmarried"){echo "selected";}?> id="Unmarried" type="radio">
                                                        <label for="Unmarried"> Unmarried</label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                	<label>Date of Birth</label>
                                                    <input type="date" name="dob" value="<?php echo $emp->dob;?>"  required class="form-control" />
                                                </div>
                                                <!--<div class="form-group col-md-3">
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
                                                </div>-->
                                                <div class="form-group col-md-4">
                                                	<label>Profile Photo</label>
                                                    <input type="file" name="profile_photo" class="form-control" id="fileUpload" />
                                           
                                                    <input type="hidden" name="oldphoto" value="<?php echo $emp->profile_photo;?>" class="form-control" />
                                                     <div id="image-container">
                                                    <img width="100%" class="img img-responsive" src="<?php echo base_url().'assets/images/emps/'.$emp->profile_photo;?>" /></div>
                                                </div>
                                                <div class="col-md-8">
                                        <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>PAN Number</label>
                                        <input type="text" name="pan_number" value="<?php echo $emp->pan_number;?>" required class="form-control" />
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label>Aadhar Number</label>
                                        <input type="text" name="aadhar_number" value="<?php echo $emp->aadhar_number;?>" required class="form-control" />
                                    </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Job Responsibilities</label>
                                            <textarea class="form-control" name="job_desc" rows="3"><?php echo $emp->job_desc;?></textarea>
                                        </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                     </div>
                        <button type="submit" class="btn btn-warning">Save Details</button>
                                     </form>
                                <?php }else{?>
                    				<form action="<?php echo base_url().'admin/add_emp_submit';?>" method="post" enctype="multipart/form-data">
                                	<div class="row">
                                    	<div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Select Branch</label>
                                                <select class="form-control" name="branch_id" id="branch_id" required>
                                                    <?php $branch=$this->db->get("branches")->result();
													echo '<option value="">Select Branch</option>';
													foreach($branch as $d){echo '<option value="'.$d->br_id.'">'.$d->br_name.' '.$d->br_code.'</option>';}?>
                                                </select>
                                            </div>
                                            <?php $deps=$this->db->get("departments")->result();
//print_r($deps);exit;
foreach($deps as $dep){?>
<p class="text-danger" style="margin-bottom:5px;"><?php echo $dep->dep_name;?></p><?php 
$desg=$this->db->get_where("designations",array("dep_id"=>$dep->dep_id))->result();
foreach($desg as $des){?>
<div class="checkbox">
    <input name="des[]" value="<?php echo $des->des_id;?>" id="checkbox<?php echo $des->des_id;?>" type="checkbox">
    <label for="checkbox<?php echo $des->des_id;?>"><?php echo $des->des_name;?></label>
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
                                                    <div class="radio radio-info radio-inline">
                                                        <input name="gender" value="Male" id="Male" type="radio" checked>
                                                        <label for="Male"> Male</label>
                                                    </div>
                                                    <div class="radio radio-info radio-inline">
                                                        <input name="gender" value="Female" id="Female" type="radio">
                                                        <label for="Female"> Female</label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                	<label>Marital Status</label><br/>
                                                    <div class="radio radio-info radio-inline">
                                                        <input name="marital" value="Married" id="Married" type="radio" checked>
                                                        <label for="Married"> Married</label>
                                                    </div>
                                                    <div class="radio radio-info radio-inline">
                                                        <input name="marital" value="Unmarried" id="Unmarried" type="radio">
                                                        <label for="Unmarried"> Unmarried</label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                	<label>Date of Birth</label>
                                                    <input type="date" name="dob" required class="form-control" />
                                                </div>
                                                <!--<div class="form-group col-md-3">
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
                                                </div>-->
                                                <div class="form-group col-md-4">
                                            <label>Profile Photo</label>
                                            <input type="file" name="profile_photo"  id="fileUpload" class="form-control" />
                                            <div id="image-container">
                                            <img width="100%" class="img img-responsive"  src="<?php echo base_url().'assets/images/emps/male_emp.jpg';?>" />
                                                </div></div>
                                                <div class="col-md-8">
                                        <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>PAN Number</label>
                                        <input type="text" name="pan_number"  required class="form-control" />
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label>Aadhar Number</label>
                                        <input type="text" name="aadhar_number" required class="form-control" />
                                    </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Job Responsibilities</label>
                                            <textarea class="form-control" name="job_desc" rows="3"></textarea>
                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                        <button type="submit" class="btn btn-warning">Save Details</button>
                                     </form>
                                <?php }?>
                                </div>
                                <?php if($this->uri->segment(3)){
									?>
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
                                                   <?php if($emp->emp_password==""){?>
                                                   <small class="text-warning">Default Password</small>
                                                   <input type="hidden" name="oldpass" value="" />
                                                   <?php }else{?>
                                                   <input type="hidden" name="oldpass" value="<?php echo $emp->emp_password;?>" />
                                                   <?php }?>
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
                                	<form method="post" action="<?php echo base_url().'admin/update_emp_details2';?>">
                                    <input type="hidden" name="emp_id" value="<?php echo $this->uri->segment(3);?>" />
                                	<div class="row">
                                        	<div class="form-group col-md-3">
                                            	<label>Date of Joining</label>
                                                <input type="date" name="joining_date" value="<?php echo $emp->joining_date;?>" class="form-control" required />
                                            </div>	
                <div class="form-group col-md-2">
                    <label>Net Salary</label>
                    <input type="text" name="salary" value="<?php echo $emp->salary;?>" id="salary" class="form-control net_salary" required />
                </div>	
                <div class="form-group col-md-2">
                    <label>PF Deduction</label>
                    <input type="text" name="pf_ded" value="<?php echo $emp->pf_ded;?>" id="pf_ded" class="form-control net_salary" required />
                </div>
                <div class="form-group col-md-2">
                    <label>Gross Salary</label>
                    <input type="text" readonly="readonly" name="tot_salary" id="tot_salary" value="<?php echo $emp->tot_salary;?>"  class="form-control" required />
                </div>
                </div>
                <div class="checkbox" style="padding-left:5px;">
                    <input name="probation" <?php if($emp->prob_from!=""){echo "checked";}?> value="" id="probation" type="checkbox">
                    <label for="probation" class="text-warning">In Probation</label>
                </div>
                <div class="row  probation"<?php if($emp->prob_from==""){echo 'style="display:none;"';}?>>
                <div class="form-group col-md-3">
                    <label>Probation Start Date</label>
                    <input type="date" name="prob_from" value="<?php echo $emp->prob_from;?>" class="form-control" />
                </div>
                <div class="form-group col-md-3">
                    <label>Probation End Date</label>
                    <input type="date" name="prob_to" value="<?php echo $emp->prob_to;?>" class="form-control" />
                </div>	
                </div>
                <div class="row">
                <div class="form-group col-md-5">
                    <label>Education</label>
                    <input type="text" name="education" value="<?php echo $emp->education;?>"  class="form-control" required />
                </div>	
                                    </div>
                                    <?php $reporting=$rid="";
										if($emp->reporting_emp!=""){
										$remp=$this->db->get_where("employees",array("emp_id"=>$emp->reporting_emp))->row();
										$reporting=$remp->firstname.' '.$remp->lastname.' EMP'.$remp->emp_id;
										$rid=$remp->emp_id;}?>
                                    <h6 class="text-danger">Reporting Senior <b class="text-success"><?php echo $reporting;?></b></h6>
                                    <input type="hidden" name="old_report_user" value="<?php echo $rid;?>" />
                                    <div class="row">
                                          <div class="form-group col-md-3">
                                            <select class="form-control" name="dept" id="dept">
                                                <?php $dept=$this->db->get("departments")->result();
                                                echo '<option value="">Select Dept.</option>';
                                                foreach($dept as $d){echo '<option value="'.$d->dep_id.'">'.$d->dep_name.'</option>';}?>
                                            </select>	
                                          </div>
                                          <div class="form-group col-md-3">
                                            <select class="form-control" name="desg" id="desg">
                                                <option value="">Select Designation</option>
                                            </select>	
                                          </div>
                                          <div class="form-group col-md-4">
                                            <select class="form-control" name="reporting_emp" id="emps">
                                                <option value="">Select Employee</option>
                                            </select>	
                                          </div>
                                    </div>
                        <button type="submit" class="btn btn-warning">Save Details</button>
                                    </form>
                                </div>
                                <?php }?>
                            </div>
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
	$("#probation").click(function(){
		if($('#probation').is(":checked")){
		$(".probation").show();
		}else{$(".probation").hide();}
	});
	$("#dept").change(function(){
			var id=$(this).val();
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/ajax_designation',
				 data: {id:id},
				 success: function(res){//alert(res);
					// alert("OTP Sent Again");
					$("#desg").html(res);
				 }
			 });
			 
		});
		$("#desg").change(function(){
			var br=$("#branch_id").val();
			var des=$(this).val();
			if(br!=""){
			 $.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/ajax_emps',
				 data: {des:des,br:br,emp:<?php echo $this->uri->segment(3);?>},
				 success: function(res){
					 console.log(res);
					// alert("OTP Sent Again");
					$("#emps").html(res);
				 }
			 });}
		});
	$("#fileUpload").on('change', function() {

  if (typeof(FileReader) == "undefined") {
    alert("Your browser doesn't support HTML5, Please upgrade your browser");
  } else {

    var container = $("#image-container");

    //remove all previous selected files
    container.empty();

    //create instance of FileReader
    var reader = new FileReader();
    reader.onload = function(e) {
      $("<img />", {
        "src": e.target.result,"style": 'width:100%;'
      }).appendTo(container);
    }
    
    reader.readAsDataURL($(this)[0].files[0]);
  }});
$(document).ready(function(){
	$(".net_salary").keyup(function(){
		var net_salary=$("#salary").val();
		var pf_ded=$("#pf_ded").val();
		console.log(net_salary);
		var tot_salary=parseInt(net_salary)-parseInt(pf_ded);
		$("#tot_salary").val(tot_salary);
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