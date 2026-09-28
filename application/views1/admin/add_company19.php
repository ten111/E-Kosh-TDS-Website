        <div class="section-body mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-default"><i class="fa fa-building"></i> Add/Edit Company Details</h5>
                            </div>
                            <div class="card-body">
                            <?php if($this->uri->segment(3)){?>
                            <form action="<?php echo base_url().'admin/update_company_submit';?>" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="comp_id" value="<?php echo $edit->comp_id;?>" />
                            	<div class="row">
                                	<div class="form-group col-md-3">
                                    	<label>Company Code</label>
                                        <input type="text" placeholder="ABC123-141AC" value="<?php echo $edit->comp_code;?>" class="form-control" required name="comp_code" />
                                    </div>
                                    <div class="form-group col-md-6">
                                    	<label>Company Name</label>
                                        <input type="text" placeholder="Mahindra Finance Pvt. Ltd." value="<?php echo $edit->comp_name;?>" class="form-control" required name="comp_name" />
                                    </div>
                                    <div class="form-group col-md-3">
                                    	<label>Company Type</label>
                                        <input type="text" placeholder="PVT LTD" value="<?php echo $edit->comp_type;?>" class="form-control" required name="comp_type" />
                                    </div>
                                    <div class="form-group col-md-4">
                                    	<label>Email</label>
                                        <input type="text" placeholder="info@company.com" value="<?php echo $edit->comp_email;?>" class="form-control" required name="comp_email" />
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>Phone 1</label>
                                        <input type="text" placeholder="Phone 1" value="<?php echo $edit->comp_phone1;?>" class="form-control" required name="comp_phone1" />
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>Phone 2</label>
                                        <input type="text" placeholder="Phone 2" value="<?php echo $edit->comp_phone2;?>" class="form-control" name="comp_phone2" />
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>PAN Number</label>
                                        <input type="text" placeholder="AFEPL1212E" value="<?php echo $edit->comp_pan;?>" class="form-control" required name="comp_pan" />
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>Begin Date</label>
                                        <input type="date" class="form-control" value="<?php echo $edit->comp_start_date;?>" required name="comp_start_date" />
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-md-5">
                                    	<div class="form-group">
                                        <label>Short About Company</label>
                                        <textarea class="form-control" placeholder="Brief About Company" rows="5"  name="comp_details"><?php echo $edit->comp_details;?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-7"><div class="row">
                                    	<div class="form-group col-md-8">
                                        <label><i class="fa fa-globe"></i> Company Website</label>
                                        <input type="url" name="comp_website" value="<?php echo $edit->comp_website;?>" placeholder="http://www.company-name.com" class="form-control" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Logo</label>
                                            <input type="file" class="form-control" name="comp_logo" />
                                            <input type="hidden" name="oldimg" value="<?php echo $edit->comp_logo;?>" />
                                        </div></div>
                                        <div class="row">
                                        <div class="col-md-4">
                                        	<button type="submit" style="margin-top:25px;" class="btn btn-warning"><i class="fa fa-edit"></i> Update Company</button>
                                        </div>
                                        <div class="col-md-4 offset-md-4">
                <img width="100%" class="img img-responsive" src="<?php echo base_url().'assets/images/logos/'.$edit->comp_logo;?>" />
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            <?php }else{?>
                            <form action="<?php echo base_url().'admin/add_company_submit';?>" enctype="multipart/form-data" method="post">
                            	<div class="row">
                                	<div class="form-group col-md-3">
                                    	<label>Company Code</label>
                                        <input type="text" placeholder="ABC123-141AC" class="form-control" required name="comp_code" />
                                    </div>
                                    <div class="form-group col-md-6">
                                    	<label>Company Name</label>
                                        <input type="text" placeholder="Mahindra Finance Pvt. Ltd." class="form-control" required name="comp_name" />
                                    </div>
                                    <div class="form-group col-md-3">
                                    	<label>Company Type</label>
                                        <input type="text" placeholder="PVT LTD" class="form-control" required name="comp_type" />
                                    </div>
                                    <div class="form-group col-md-4">
                                    	<label>Email</label>
                                        <input type="text" placeholder="info@company.com" class="form-control" required name="comp_email" />
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>Phone 1</label>
                                        <input type="text" placeholder="Phone 1" class="form-control" required name="comp_phone1" />
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>Phone 2</label>
                                        <input type="text" placeholder="Phone 2" class="form-control" name="comp_phone2" />
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>PAN Number</label>
                                        <input type="text" placeholder="AFEPL1212E" class="form-control" required name="comp_pan" />
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>Begin Date</label>
                                        <input type="date" class="form-control" required name="comp_start_date" />
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-md-5">
                                    	<div class="form-group">
                                        <label>Short About Company</label>
                                        <textarea class="form-control" placeholder="Brief About Company" rows="5"  name="comp_details"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-7"><div class="row">
                                    	<div class="form-group col-md-8">
                                        <label><i class="fa fa-globe"></i> Company Website</label>
                                        <input type="url" name="comp_website" placeholder="http://www.company-name.com" class="form-control" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Logo</label>
                                            <input type="file" class="form-control" name="comp_logo" />
                                        </div></div>
                                        <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Login Username</label>
                                            <input type="text" placeholder="Username" class="form-control" required name="comp_username" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Password</label>
                                            <input type="password" placeholder="Password" class="form-control" required name="comp_password" />
                                        </div>
                                        <div class="col-md-4">
                                        	<button type="submit" style="margin-top:30px;" class="btn btn-warning"><i class="fa fa-plus"></i> Add Company</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            <?php }?>
                            </div>
                        </div>                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/bundles/lib.vendor.bundle.js"></script>
<script src="<?php echo base_url();?>assets/bundles/selectize.bundle.js"></script>

<script src="<?php echo base_url();?>assets/js/core.js"></script>
<script src="<?php echo base_url();?>js/vendors/selectize.js"></script>
</body>
</html>