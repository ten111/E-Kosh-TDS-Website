    <!--<style>
	.form-inline label{ display:inline;}
	</style>-->
    <div class="content-wrapper">
			<section class="content-header">
				<h5>List Leads</h5>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">List Leads</li>
				</ol>
			</section>
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
                <div class="col-md-12">
                	<div class="panel-body">
                     <label for="email">CSV Excel File</label>
                              <button type="button" id="lead_dmodal" class="btn btn-dark  pull-right" data-toggle="modal" data-target="#myModald">Distribute Data</button>                            
                     <form class="form-inline" method="post" enctype="multipart/form-data" action="<?php echo base_url().'admin/upload_lead_excel';?>">
                              <div class="form-group">
                             <select class="form-control" name="lead_type">
                             	<option value="Fresh Leads">Fresh Leads</option>
                             	<option value="Web Leads">Web Leads</option>
                             	<option value="HNI Leads">HNI Leads</option>
                             	<option value="Premium Leads">Premium Leads</option>
                             </select>
                             </div> <div class="form-group">
                                
                                <input type="file" name="excel" required class="form-control">
                              </div>
                              <button type="submit" class="btn btn-success">Import Data</button>
                            </form>
                                <a download class="btn btn-sm btn-warning" href="<?php echo base_url().'assets/sample_leads.csv';?>">Download Sample</a>

                            <hr/>
                    </div>
                </div>
                
                <div class="col-md-4"><?php if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
                    <div class="panel panel-primary cardbg">
                        <div class="panel-body"> 
                                       
                        <?php if(is_numeric($this->uri->segment(3))){
							$edit=$this->db->get_where("leads",array("lead_id"=>$this->uri->segment(3)))->row();?>
                        	<form action="<?php echo base_url().'admin/newlead_update';?>" method="post">
                            		<input type="hidden" name="lead_id" value="<?php echo $edit->lead_id;?>" />
                                    <div class="form-group">
                             <select class="form-control" name="lead_type">
                             	<option value="Fresh Leads">Fresh Leads</option>
                             	<option value="Web Leads">Web Leads</option>
                             	<option value="HNI Leads">HNI Leads</option>
                             	<option value="Premium Leads">Premium Leads</option>
                             </select>
                             </div> 
                                    <div class="form-group">
                                    	<label>Lead Source</label>
                                        <select class="form-control" required name="lead_src">
                                        	<option value="">Select Source</option>
                                              <option value="Campaign" <?php if($edit->lead_src=="Campaign"){echo "selected";}?>>Campaign</option>
                    <option value="Cold Call" <?php if($edit->lead_src=="Cold Call"){echo "selected";}?>>Cold Call</option>
                    <option value="Conference" <?php if($edit->lead_src=="Conference"){echo "selected";}?>>Conference</option>
                    <option value="Data FROM TRADE INDIA" <?php if($edit->lead_src=="Data FROM TRADE INDIA"){echo "selected";}?>>Data FROM TRADE INDIA</option>
                    <option value="Default Lead Upload Source" <?php if($edit->lead_src=="Default Lead Upload Source"){echo "selected";}?>>Default Lead Upload Source</option>
                    <option value="Direct Mail" <?php if($edit->lead_src=="Direct Mail"){echo "selected";}?>>Direct Mail</option>
                    <option value="Email" <?php if($edit->lead_src=="Email"){echo "selected";}?>>Email</option>
                    <option value="Employee" <?php if($edit->lead_src=="Employee"){echo "selected";}?>>Employee</option>
                    <option value="Existing Customer" <?php if($edit->lead_src=="Existing Customer"){echo "selected";}?>>Existing Customer</option>
                    <option value="Other" <?php if($edit->lead_src=="Other"){echo "selected";}?>>Other</option>
                    <option value="Public Relations" <?php if($edit->lead_src=="Public Relations"){echo "selected";}?>>Public Relations</option>
                    <option value="Self Generated" <?php if($edit->lead_src=="Self Generated"){echo "selected";}?>>Self Generated</option>
                    <option value="Trade Show" <?php if($edit->lead_src=="Trade Show"){echo "selected";}?>>Trade Show</option>
                    <option value="Web Site" <?php if($edit->lead_src=="Web Site"){echo "selected";}?>>Web Site</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label>Client Name</label>
                                        <input type="text" placeholder="" value="<?php echo $edit->contact_person;?>" class="form-control" required name="name" />
                                    </div>
                                    <div class="form-group">
                                    	<label>Mobile</label>
                                        <input type="text" placeholder="" value="<?php echo $edit->contact_phone1;?>" class="form-control" required name="mobile" />
                                    </div>
                                    <div class="form-group">
                                    	<label>Email</label>
                                        <input type="text" placeholder="" value="<?php echo $edit->email;?>" class="form-control" name="email" />
                                    </div>
									<div class="form-group">
                                    	<label>Assign Employee</label>
                                        <select class="form-control" required name="state">
                                        	<option value="">Select Employee</option>
                                            <?php $st=$this->db->get_where("employees",array("emp_call!="=>""))->result();foreach($st as $s){?>
                                            <option value="<?php echo $s->emp_id;?>" <?php if($edit->lead_emp==$s->emp_id){echo "selected";}?>><?php echo $s->firstname.' '.$s->lastname;?></option>
                                            <?php }?></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="lead_remark" rows="3"><?php echo $edit->lead_remark;?></textarea>
                                    </div>
                                <button type="submit" class="btn btn-primary">Update Lead</button>
                            </form>
                            <?php }else{?>                            
                            <form action="<?php echo base_url().'admin/newlead_submit';?>" method="post">
                            <div class="form-group">
                             <select class="form-control"   name="lead_type" required>
                             	<option value="Fresh Leads">Fresh Leads</option>
                             	<option value="Web Leads">Web Leads</option>
                             	<option value="HNI Leads">HNI Leads</option>
                             	<option value="Premium Leads">Premium Leads</option>
                             </select>
                             </div> 
                                    <div class="form-group">
                                    	<label>Lead Source</label>
                                        <select class="form-control" required name="lead_src">
                                        	<option value="">Select Source</option>
                                            <option value="Campaign">Campaign</option>
                                            <option value="Cold Call">Cold Call</option>
                                            <option value="Conference">Conference</option>
                                            <option value="Data FROM TRADE INDIA">Data FROM TRADE INDIA</option>
                                            <option value="Default Lead Upload Source">Default Lead Upload Source</option>
                                            <option value="Direct Mail">Direct Mail</option>
                                            <option value="Email">Email</option>
                                            <option value="Employee">Employee</option>
                                            <option value="Existing Customer">Existing Customer</option>
                                            <option value="Other">Other</option>
                                            <option value="Public Relations">Public Relations</option>
                                            <option value="Self Generated">Self Generated</option>
                                            <option value="Trade Show">Trade Show</option>
                                            <option value="Web Site">Web Site</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label>Client Name</label>
                                        <input type="text" placeholder="" class="form-control" required name="name" />
                                    </div>
                                    <div class="form-group">
                                    	<label>Mobile</label>
                                        <input type="text" placeholder="" class="form-control" required name="mobile" />
                                    </div>
                                    <div class="form-group">
                                    	<label>Email</label>
                                        <input type="text" placeholder="" class="form-control" name="email" />
                                    </div>
									<div class="form-group">
                                    	<label>Assign Employee</label>
                                        <select class="form-control" required name="state">
                                        	<option value="">Select Employee</option>
                                            <?php $st=$this->db->get_where("employees",array("emp_call!="=>""))->result();foreach($st as $s){?>
                                            <option value="<?php echo $s->emp_id;?>" <?php //if($edit->lead_emp==$s->emp_id){echo "selected";}?>><?php echo $s->firstname.' '.$s->lastname;?></option>
                                            <?php }?></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="lead_remark" rows="3"></textarea>
                                    </div>
                                <button type="submit" class="btn btn-primary">Create Lead</button>
                            </form>
                            <?php }?>
                            </div>
                            </div>
                            </div>
                            
                <div class="col-md-8"><?php if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
                    <div class="panel panel-primary cardbg">
                        <div class="panel-body">
                        
                        <form class="form-inline"  action="<?php echo base_url().'admin/assign_leads';?>" method="post" >
                          <?php if(!$this->uri->segment(3)){?>
                          <div class="form-group">
                            <select class="form-control" name="branch_id" id="branch_id" required>
                                <?php $branch=$this->db->get("branches")->result();
                                echo '<option value="">Select Branch</option>';
                                foreach($branch as $d){echo '<option value="'.$d->br_id.'">'.$d->br_name.' '.$d->br_code.'</option>';}?>
                            </select>
                          </div>
                          <div class="form-group">
                          	<select class="form-control" name="dept" id="dept" required>
                                <?php $dept=$this->db->get("departments")->result();
                                echo '<option value="">Select Dept.</option>';
                                foreach($dept as $d){echo '<option value="'.$d->dep_id.'">'.$d->dep_name.'</option>';}?>
                            </select>	
                          </div>
                          <div class="form-group">
                          	<select class="form-control" name="desg" id="desg" required>
                            	<option value="">Designation</option>
                            </select>	
                          </div>
                          <div class="form-group">
                          	<select class="form-control" name="emp" id="emps" required>
                            	<option value="">Employee</option>
                            </select>	
                          </div>
                          <button type="submit" class="btn btn-success">Assign</button>
                          <?php }?><hr/>
                        <table class="table table-sm table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr bgcolor="#CCCCCC"><th><div class="checkbox">
                            <input type="checkbox" id="checkAll" value="checkall" /> <label for="checkAll">All</label></div></th>
                            	<th><select class="form-control" style="width:80px;" id="showdata">
                                	<option value="10">10</option>
                                	<option value="25">25</option>
                                	<option value="100">100</option>
                                	<option value="200">200</option>
                                	<option value="500">500</option>
                                	</select></th><th colspan="5"></th></tr>
                            <tr bgcolor="#FFCC00"><th>S.No.</th><th>Lead Source/Date</th><th>Contact Details</th>
                                   	   <th>Remark</th><th>Action</th></tr></thead>
                                   <tbody id="leads_list">
                                       
                                   </tbody>
                        </table>
                        </form>
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
              <div class="modal-header" style="background:#FC0;">
                <h5 class="modal-title">Lead Followup <b id="leadid"></b></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" id="lead_details">
                <p><i class="fa fa-spin fa-spinner"></i> Loading Lead Details...</p>
              </div>
            </div>
        
          </div>
        </div>
        
        <div id="myModald" class="modal fade" role="dialog">
          <div class="modal-dialog">        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header" style="background:#FC0;">
                <h5 class="modal-title">Distribute</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" id="lead_dist">
                <p><i class="fa fa-spin fa-spinner"></i> Loading...</p>
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
	$(document).ready(function(){
		$("#lead_dmodal").click(function(){
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/ajax_lead_dmodal',
				 data: {show:'yes'},
				 success: function(res){//alert(res);
					 $("#lead_dist").html(res);
					 //$("#desg").html(res);
				 }
			 });
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
				 data: {des:des,br:br},
				 success: function(res){
					 console.log(res);
					// alert("OTP Sent Again");
					$("#emps").html(res);
				 }
			 });}
		});
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_lead_list',
			 data: {limit:10,assign:"<?php echo $this->uri->segment(3);?>"},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#leads_list").html(res);
			 }
		 });
		$("#showdata").change(function(){
			var id=$(this).val();
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/ajax_lead_list',
				 data: {limit:id,assign:"<?php echo $this->uri->segment(3);?>"},
				 success: function(res){//alert(res);
					// alert("OTP Sent Again");
					$("#leads_list").html(res);
				 }
			 });
		});
		$(".del_lead").click(function(e){e.preventDefault();
		if (!confirm("Sure you want to delete?")){
				  return false;
				}
			var id=$(this).attr("id");$(this).closest("tr").remove();
			$.ajax({
							 type: "POST",
							 url: '<?php echo base_url();?>admin/ajax_del_lead',
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