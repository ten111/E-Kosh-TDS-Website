<form action="<?php echo base_url().'employee/update_contract_submit';?>"  method="post">
                            	<input type="hidden" name="cont_id" value="<?php echo $edit->cont_id;?>" />
                            	<div class="row">
                                	<div class="form-group col-md-3">
                                    	<label>Lead Source</label>
                                        <select class="form-control" required name="lead_src">
                                        	<option value="">Select Source</option>
                    <option value="Campaign" <?php if($edit->c_lead_src=="Campaign"){echo "selected";}?>>Campaign</option>
                    <option value="Cold Call" <?php if($edit->c_lead_src=="Cold Call"){echo "selected";}?>>Cold Call</option>
                    <option value="Conference" <?php if($edit->c_lead_src=="Conference"){echo "selected";}?>>Conference</option>
                    <option value="Data FROM TRADE INDIA" <?php if($edit->c_lead_src=="Data FROM TRADE INDIA"){echo "selected";}?>>Data FROM TRADE INDIA</option>
                    <option value="Default Lead Upload Source" <?php if($edit->c_lead_src=="Default Lead Upload Source"){echo "selected";}?>>Default Lead Upload Source</option>
                    <option value="Direct Mail" <?php if($edit->c_lead_src=="Direct Mail"){echo "selected";}?>>Direct Mail</option>
                    <option value="Email" <?php if($edit->c_lead_src=="Email"){echo "selected";}?>>Email</option>
                    <option value="Employee" <?php if($edit->c_lead_src=="Employee"){echo "selected";}?>>Employee</option>
                    <option value="Existing Customer" <?php if($edit->c_lead_src=="Existing Customer"){echo "selected";}?>>Existing Customer</option>
                    <option value="Other" <?php if($edit->c_lead_src=="Other"){echo "selected";}?>>Other</option>
                    <option value="Public Relations" <?php if($edit->c_lead_src=="Public Relations"){echo "selected";}?>>Public Relations</option>
                    <option value="Self Generated" <?php if($edit->c_lead_src=="Self Generated"){echo "selected";}?>>Self Generated</option>
                    <option value="Trade Show" <?php if($edit->c_lead_src=="Trade Show"){echo "selected";}?>>Trade Show</option>
                    <option value="Web Site" <?php if($edit->c_lead_src=="Web Site"){echo "selected";}?>>Web Site</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                    	<label>Company/Business Name</label>
                                        <input type="text" value="<?php echo $edit->c_company;?>" class="form-control" name="company" />
                                    </div>
                                	<div class="form-group col-md-3">
                                    	<label>Contact Person</label>
                                        <input type="text" value="<?php echo $edit->c_contact_person;?>" placeholder="" class="form-control" required name="contact_person" />
                                    </div>
                                    <div class="form-group col-md-3">
                                    	<label>Nature of Business</label>
                                        <select class="form-control" required name="bs_type">
                                        	<option value="">Select Tpe</option>
                                            <option value="Manufacturur" <?php if($edit->c_bs_type=="Manufacturur"){echo "selected";}?>>Manufacturur</option>
                                            <option value="Exporter" <?php if($edit->c_bs_type=="Exporter"){echo "selected";}?>>Exporter</option>
                                            <option value="Importer" <?php if($edit->c_bs_type=="Importer"){echo "selected";}?>>Importer</option>
                                            <option value="Trader" <?php if($edit->c_bs_type=="Trader"){echo "selected";}?>>Supplier</option>
                                            <option value="Service Provider" <?php if($edit->bs_type=="Service Provider"){echo "selected";}?>>Service Provider</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                    	<label>Product/Service Title</label>
                                        <input type="text" placeholder="" value="<?php echo $edit->c_bs_title;?>" class="form-control" required name="bs_title" />
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>GST(If/Any)</label>
                                        <input type="text" class="form-control" value="<?php echo $edit->c_comp_gst;?>" name="comp_gst" />
                                    </div>
                                    <div class="form-group col-md-6">
                                    	<label>Email</label>
                                        <input type="text" value="<?php echo $edit->c_email;?>" placeholder="info@company.com" class="form-control" required name="email" />
                                    </div>
                                    <div class="form-group col-md-3">
                                    	<label>Phone 1</label>
                                        <input type="text" value="<?php echo $edit->c_contact_phone1;?>" class="form-control" required name="contact_phone1" />
                                    </div>
                                    <div class="form-group col-md-3">
                                    	<label>Phone 2</label>
                                        <input type="text" value="<?php echo $edit->c_contact_phone2;?>" class="form-control" name="contact_phone2" />
                                    </div>
                                    <div class="form-group col-md-3">
                                    	<label>City</label>
                                        <input type="text" value="<?php echo $edit->c_city;?>" class="form-control" required name="city" />
                                    </div>
                                    <div class="form-group col-md-4">
                                    	<label>State</label>
                                        <select class="form-control" required name="state">
                                        	<option value="">Select State</option>
                                            <?php $st=$this->db->get("state_list")->result();foreach($st as $s){?>
                                            <option value="<?php echo $s->state_id;?>" <?php if($edit->c_stateid==$s->state_id){echo "selected";}?>><?php echo $s->state;?></option>
                                            <?php }?></select>
                                    </div>
                                    <div class="form-group col-md-2">
                                    	<label>Pincode</label>
                                        <input type="text" class="form-control" value="<?php echo $edit->c_pincode;?>"  name="pincode" />
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-md-4">
                                    	<div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control" placeholder="Address" rows="3"  name="address"><?php echo $edit->c_address;?></textarea>
                                        </div>
                                    </div>
                                	<div class="col-md-5">
                                    	<div class="form-group">
                                        <label>Short Remark</label>
                                        <textarea class="form-control" placeholder="Short Remark" rows="3"  name="lead_remark"><?php echo $edit->c_remark;?></textarea>
                                        </div>
                                    </div>
                                    
                                </div>
                                <h5 class="text-danger">Contract Details</h5>
                                <div class="row">
                                	<div class="col-md-3">
                                        <label>Contract Value</label>
                                        <input type="number" class="form-control" value="<?php echo $edit->c_value;?>" required name="c_value" id="contract_val" />
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <label>TAX(GST)</label>
                                        <select class="form-control" name="c_gst" required id="tax">
                                        	<option value="">Select</option>
                                            <option value="5" <?php if($edit->c_gst==5){echo "selected";}?>>5%</option>
                                            <option value="12" <?php if($edit->c_gst==12){echo "selected";}?>>12%</option>
                                            <option value="18" <?php if($edit->c_gst==18){echo "selected";}?>>18%</option>
                                            <option value="28" <?php if($edit->c_gst==28){echo "selected";}?>>28%</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Total Value</label>
                                        <input type="number" readonly="readonly" value="<?php echo $edit->c_value+$edit->c_gst_percent;?>" class="form-control" required name="total_pay" id="total_pay" />
                                    </div>
                                </div><br/>
                                <?php if(!$this->session->userdata("admin")){?>
                               <button type="submit"class="btn btn-warning"><i class="fa fa-file-o"></i> Update Contract Details</button><?php }?>
                                </form>
                                <script>
								$(document).ready(function(){
									$("#contract_val").keyup(function(){
										var contract_val=parseInt($(this).val());
										var tax=parseInt($("#tax").val());
										var tot=contract_val*tax/100;
										var adv=contract_val+tot;
										$("#advance_pay").val(adv);
										$("#total_pay").val(adv);
									});
									$("#advance_pay").keyup(function(){
										var contract_val=parseInt($("#contract_val").val());
										var tax=parseInt($("#tax").val());
										var tot=contract_val*tax/100;
										var adv=contract_val+tot;
										//$("#total_pay").val(adv);
										//$("#total_pay").val(adv);
										var bal=adv-parseInt($(this).val());
										$("#balance_amt").val(bal);
									});
									$("#tax").change(function(){
										var contract_val=parseInt($("#contract_val").val());
										var tax=parseInt($("#tax").val());
										var tot=contract_val*tax/100;
										var adv=contract_val+tot;
										$("#total_pay").val(adv);
										$("#advance_pay").val(adv);
									});
								});
								</script>