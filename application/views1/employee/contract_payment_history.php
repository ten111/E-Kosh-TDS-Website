<table class="table table-bordered"><tr bgcolor="#CCCCCC"><th>Contract Value</th><th>GST</th><th>Total Value</th><th>Total Paid</th><th>Total Due</th></tr><tr><th class="text-primary"><?php echo $cont->c_value;?>/-</th>
    <th  class="text-info"><?php echo $cont->c_gst_percent;?>/- (<?php echo $cont->c_gst;?>%)</th>
    <th  class="text-success"><?php echo $cont->c_value+$cont->c_gst_percent;?>/-</th>
    <?php if(empty($total_paid)){$total_paid=0;}else{$total_paid=$total_paid->total_paid;}?>
    <th  class="text-warning"><?php echo $total_paid;?>/-</th>
    <th  class="text-danger"><?php echo $cont->c_value+$cont->c_gst_percent-$total_paid;?>/-</th></tr></table>
<form action="" method="post" id="add_payment">
                                    <div class="row">
                                    <div class="col-md-3">
                                        <label>Payment</label>
                                        <input type="number" class="form-control" required name="paid_amt" />
                                    </div>
                                    <input type="hidden" name="contid" value="<?php echo $cont->cont_id;?>" />
                                    <div class="col-md-3">
                                        <label>Payment Mode</label>
                                        <select class="form-control" name="pay_mode">
                                        	<option value="">Select</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="Online Transfer">Online Transfer</option>
                                            <option value="DD">DD</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Cheque/Transaction/DD</label>
                                        <input type="text" class="form-control" name="trans_id"  />
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Dated</label>
                                        <input type="date" class="form-control"  name="paid_date" />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Bank Name</label>
                                        <input type="text" class="form-control"  name="bank_name" />
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label>Payment Recd Remarks</label>
                                        <input type="text" class="form-control"  name="pay_remarks" />
                                    </div>
                                </div>
                                
                                    
                                <button type="submit"class="btn btn-warning"><i class="fa fa-inr"></i> Add Payment</button>
                                
</form>
<br/>
<table class="table table-condensed table-striped table-bordered">
<thead><tr><th>S.No.</th><th>Date</th><th>Amount</th><th>Total Paid</th><th>Mode</th><th>TransID/Cheque/DD</th><th>Remark</th></tr></thead>
<tbody>
	<?php $i=1;foreach($payment as $p){?>
    <tr><td><?php echo $i;?></td>
    	<td><?php echo $p->paid_date;?></td>
    	<td><?php echo $p->paid_amt;?></td>
    	<td><?php echo $p->total_paid;?></td>
    	<td><?php echo $p->pay_mode;?></td>
    	<td><?php echo $p->trans_id;?></td>
    	<td><?php echo $p->pay_remarks;?></td>
    <?php $i++;}?>
</tbody>
</table>
<script>
$("#add_payment").submit(function(e){e.preventDefault();
	var formdata=$(this).serialize();
	$.ajax({
		 type: "POST",
		 url: '<?php echo base_url();?>employee/ajax_add_paymemt',
		 data: {formdata:formdata},
		 success: function(res){//alert(res);
		 if(res!=0){$("#payment_history").html(res);alert("Payment added successfully.");}else{alert("Payment Couldnot be added.");}
			// alert("OTP Sent Again");
			//$("#leads_list").html(res);
		 }
	 });
});
</script>