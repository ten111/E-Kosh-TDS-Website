	<div class="content-wrapper">
			<section class="content-header">
				<h5>Add Edit Lead/Company/Party Details</h5>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Add/Edit Lead/Company/Party Details</li>
				</ol>
			</section>
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
                <div class="col-md-12">
                	<?php if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
                    <div class="panel panel-primary cardbg">
                        <h6 class="title-inner text-uppercase">Add/Edit Lead/Company/Party Details</h6>
                        <div class="panel-body">
                        	<?php if($this->uri->segment(3)){?>
                            <form action="<?php echo base_url().'admin/update_lead_submit';?>"  method="post">
                            	<input type="hidden" name="lead_id" value="<?php echo $edit->lead_id;?>" />
                            	<div class="row">
                                	<div class="form-group col-md-3">
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
                                    <div class="form-group col-md-6">
                                    	<label>Company/Business Name</label>
                                        <input type="text" value="<?php echo $edit->company;?>" class="form-control" name="company" />
                                    </div>
                                	<div class="form-group col-md-3">
                                    	<label>Contact Person</label>
                                        <input type="text" value="<?php echo $edit->contact_person;?>" placeholder="" class="form-control" required name="contact_person" />
                                    </div>
                                    <div class="form-group col-md-3">
                                    	<label>Nature of Business</label>
                                        <select class="form-control" required name="bs_type">
                                        	<option value="">Select Tpe</option>
                                            <option value="Manufacturur" <?php if($edit->bs_type=="Manufacturur"){echo "selected";}?>>Manufacturur</option>
                                            <option value="Exporter" <?php if($edit->bs_type=="Exporter"){echo "selected";}?>>Exporter</option>
                                            <option value="Importer" <?php if($edit->bs_type=="Importer"){echo "selected";}?>>Importer</option>
                                            <option value="Trader" <?php if($edit->bs_type=="Trader"){echo "selected";}?>>Supplier</option>
                                            <option value="Service Provider" <?php if($edit->bs_type=="Service Provider"){echo "selected";}?>>Service Provider</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                    	<label>Product/Service Title</label>
                                        <input type="text" placeholder="" value="<?php echo $edit->bs_title;?>" class="form-control" required name="bs_title" />
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>GST(If/Any)</label>
                                        <input type="text" class="form-control" value="<?php echo $edit->comp_gst;?>" name="comp_gst" />
                                    </div>
                                    <div class="form-group col-md-3">
                                    	<label>Email</label>
                                        <input type="text" value="<?php echo $edit->email;?>" placeholder="info@company.com" class="form-control" required name="email" />
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>Phone 1</label>
                                        <input type="text" value="<?php echo $edit->contact_phone1;?>" class="form-control" required name="contact_phone1" />
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>Phone 2</label>
                                        <input type="text" value="<?php echo $edit->contact_phone2;?>" class="form-control" name="contact_phone2" />
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>City</label>
                                        <input type="text" value="<?php echo $edit->city;?>" class="form-control" required name="city" />
                                    </div>
                                    <div class="form-group col-md-3">
                                    	<label>State</label>
                                        <select class="form-control" required name="state">
                                        	<option value="">Select State</option>
                                            <?php $st=$this->db->get("state_list")->result();foreach($st as $s){?>
                                            <option value="<?php echo $s->state_id;?>" <?php if($edit->stateid==$s->state_id){echo "selected";}?>><?php echo $s->state;?></option>
                                            <?php }?></select>
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>Pincode</label>
                                        <input type="text" class="form-control" value="<?php echo $edit->pincode;?>"  name="pincode" />
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-md-4">
                                    	<div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control" placeholder="Address" rows="3"  name="address"><?php echo $edit->address;?></textarea>
                                        </div>
                                    </div>
                                	<div class="col-md-5">
                                    	<div class="form-group">
                                        <label>Short Remark</label>
                                        <textarea class="form-control" placeholder="Short Remark" rows="3"  name="lead_remark"><?php echo $edit->lead_remark;?></textarea>
                                        </div>
                                    </div>
                                    
                                </div>
                               <button type="submit"class="btn btn-warning"><i class="fa fa-plus"></i> Update Lead Details</button>
                                </form>
                            <?php }else{?>
                            
                                <label for="email">CSV Excel File</label>
                                <a download class="btn btn-sm btn-warning" href="<?php echo base_url().'assets/sample_leads.csv';?>">Download Sample</a>
                            <form class="form-inline" method="post" enctype="multipart/form-data" action="<?php echo base_url().'admin/upload_lead_excel';?>">
                              <div class="form-group">
                                
                                <input type="file" name="excel" required class="form-control">
                              </div>
                              <button type="submit" class="btn btn-success">Import Data</button>
                            </form>
                            <hr/>
                            <form action="<?php echo base_url().'admin/add_lead_submit';?>"  method="post">
                            	<input type="hidden" name="lead_date" value="<?php echo date("Y-m-d");?>" />
                            	<div class="row">
                                	<div class="form-group col-md-3">
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
                                    <div class="form-group col-md-6">
                                    	<label>Company/Business Name</label>
                                        <input type="text"  class="form-control" name="company" />
                                    </div>
                                	<div class="form-group col-md-3">
                                    	<label>Contact Person</label>
                                        <input type="text" placeholder="" class="form-control" required name="contact_person" />
                                    </div>
                                    <div class="form-group col-md-3">
                                    	<label>Nature of Business</label>
                                        <select class="form-control" required name="bs_type">
                                        	<option value="">Select Tpe</option>
                                            <option value="Manufacturur">Manufacturur</option>
                                            <option value="Exporter">Exporter</option>
                                            <option value="Importer">Importer</option>
                                            <option value="Trader">Supplier</option>
                                            <option value="Service Provider">Service Provider</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                    	<label>Product/Service Title</label>
                                        <input type="text" placeholder="" class="form-control" required name="bs_title" />
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>GST(If/Any)</label>
                                        <input type="text" class="form-control" name="comp_gst" />
                                    </div>
                                    <div class="form-group col-md-3">
                                    	<label>Email</label>
                                        <input type="text" placeholder="" class="form-control" required name="email" />
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>Phone 1</label>
                                        <input type="text"  class="form-control" required name="contact_phone1" />
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>Phone 2</label>
                                        <input type="text"  class="form-control" name="contact_phone2" />
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>City</label>
                                        <input type="text" class="form-control" required name="city" />
                                    </div>
                                    <div class="form-group col-md-3">
                                    	<label>State</label>
                                        <select class="form-control" required name="state">
                                        	<option value="">Select State</option>
                                            <?php $st=$this->db->get("state_list")->result();foreach($st as $s){?>
                                            <option value="<?php echo $s->state_id;?>"><?php echo $s->state;?></option>
                                            <?php }?></select>
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>Pincode</label>
                                        <input type="text" class="form-control" name="pincode" />
                                    </div>
                                </div>
                                <div class="row">
                                	
                                    <div class="col-md-4">
                                    	<div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control" placeholder="Address" rows="3"  name="address"></textarea>
                                        </div>
                                    </div>
                                	<div class="col-md-5">
                                    	<div class="form-group">
                                        <label>Short Remark</label>
                                        <textarea class="form-control" placeholder="Short Remark" rows="3"  name="lead_remark"></textarea>
                                        </div>
                                    </div>
                                    
                                </div>
                               <button type="submit"class="btn btn-warning"><i class="fa fa-plus"></i> Add Lead</button>
                                </form>
                            <?php }?>
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
			<p class="mb-0">Copyright © 2024 <a target="_blank" href="#">Admin</a>. All rights reserved.</p>
		</footer>
		<!-- Footer Section Ends -->
			
	</div>

	<!-- jQuery CDN - Slim version (=without AJAX) -->
	<script src="<?php echo base_url();?>adminassets/assets/js/jquery/slim.min.js"></script>
    <script>
$(document).ready(function(){
	
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