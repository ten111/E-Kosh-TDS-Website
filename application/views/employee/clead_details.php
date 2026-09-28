<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#home">Contract Details</a>
    </li>
    <li class="nav-item">
        <a class="nav-link followuptab" data-toggle="tab" href="#menu1">Follow Up History</a>
    </li>
</ul>
<div class="tab-content">
    <div id="home" class="tab-pane active">
    <form action="<?php echo base_url().'employee/new_contract_add';?>"  method="post">
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
                                    <div class="form-group col-md-6">
                                    	<label>Product/Service Title</label>
                                        <input type="text" placeholder="" value="<?php echo $edit->bs_title;?>" class="form-control" required name="bs_title" />
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>GST(If/Any)</label>
                                        <input type="text" class="form-control" value="<?php echo $edit->comp_gst;?>" name="comp_gst" />
                                    </div>
                                    <div class="form-group col-md-6">
                                    	<label>Email</label>
                                        <input type="text" value="<?php echo $edit->email;?>" placeholder="info@company.com" class="form-control" required name="email" />
                                    </div>
                                    <div class="form-group col-md-3">
                                    	<label>Phone 1</label>
                                        <input type="text" value="<?php echo $edit->contact_phone1;?>" class="form-control" required name="contact_phone1" />
                                    </div>
                                    <div class="form-group col-md-3">
                                    	<label>Phone 2</label>
                                        <input type="text" value="<?php echo $edit->contact_phone2;?>" class="form-control" name="contact_phone2" />
                                    </div>
                                    <div class="form-group col-md-3">
                                    	<label>City</label>
                                        <input type="text" value="<?php echo $edit->city;?>" class="form-control" required name="city" />
                                    </div>
                                    <div class="form-group col-md-4">
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
                                        <textarea class="form-control" placeholder="Address" rows="2"  name="address"><?php echo $edit->address;?></textarea>
                                        </div>
                                    </div>
                                	<div class="col-md-5">
                                    	<div class="form-group">
                                        <label>Short Remark</label>
                                        <textarea class="form-control" placeholder="Short Remark" rows="2"  name="lead_remark"><?php echo $edit->lead_remark;?></textarea>
                                        </div>
                                    </div>
                                    
                                </div>
                                <h6 class="text-danger">Contract Value</h6>
                                <div class="row">
                                	<div class="col-md-3">
                                        <label>Contract Value</label>
                                        <input type="number" class="form-control" required name="c_value" id="contract_val" />
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <label>TAX(GST)</label>
                                        <select class="form-control" name="c_gst" required id="tax">
                                        	<option value="">Select</option>
                                            <option value="5">5%</option>
                                            <option value="12">12%</option>
                                            <option value="18">18%</option>
                                            <option value="28">28%</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Total Value</label>
                                        <input type="number" readonly="readonly" class="form-control" required name="total_pay" id="total_pay" />
                                    </div>
                                    </div><hr/>
                               	    <h6 class="text-success">Payment Details</h6>
                                    <div class="row">
                                    <div class="col-md-3">
                                        <label>Advance Payment</label>
                                        <input type="number" class="form-control" required name="c_advance" id="advance_pay" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Balance Amount</label>
                                        <input type="number" class="form-control" readonly="readonly" name="c_balance" id="balance_amt" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Payment Mode</label>
                                        <select class="form-control" name="c_paymode">
                                        	<option value="">Select</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="Online Transfer">Online Transfer</option>
                                            <option value="DD">DD</option>
                                        </select>
                                    </div></div><div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Cheque/Transaction/DD</label>
                                        <input type="text" class="form-control" name="trans_id"  />
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Dated</label>
                                        <input type="date" class="form-control"  name="paid_date" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Bank Name</label>
                                        <input type="text" class="form-control"  name="bank_name" />
                                    </div>
                                </div>
                                
                                    <div class="form-group">
                                        <label>Payment Recd Remarks</label>
                                        <textarea  class="form-control" name="pay_remarks" rows="2"></textarea>
                                    </div>
                                <button type="submit"class="btn btn-warning"><i class="fa fa-file-o"></i> Create New Contract</button>
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
    </div>
    <div id="menu1" class="tab-pane fade">
    	<?php if(empty($history)){?>
        <div class="alert alert-danger"><h3>No Previous History.</h3></div>
        <?php }else{?>
        <table class="table table-sm table-bordered">
        	<thead><tr><th>S.No.</th><th>Remark</th><th>Next Date/Remark</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
            	<?php $i=1;foreach($history as $h){?>
                <tr><td><?php echo $i;?></td>
                	<td><?php echo $h->lremark;?><br/>
                    <label class="badge badge-warning"><?php echo $h->action_date;?></label></td>
                	<td><?php echo $h->next_remark;?><br/>
                    <label class="badge badge-warning"><?php echo $h->next_date;?></label></td>
                    <td><?php echo $h->f_status;?></td>
                    <td><a href="#" id="<?php echo $h->foid;?>" class="btn btn-sm btn-danger fdelete"><i class="fa fa-trash-o"></i></a></td></tr>
                <?php $i++;}?>
            </tbody>
        </table>	<?php }?>
    </div>
</div>