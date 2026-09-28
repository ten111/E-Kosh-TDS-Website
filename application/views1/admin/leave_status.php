<div class="col-md-3">
<form action="" method="post" id="leave_status_update">
<input type="hidden" name="laid" value="<?php echo $leave->laid;?>" />
    	<div class="form-group">
            <label>Start Date</label>
            <input type="date" name="l_from" class="form-control" required value="<?php echo $leave->l_from;?>" />
        </div>
        <div class="form-group">
            <label>End Date</label>
            <input type="date" name="l_to" class="form-control"  required value="<?php echo $leave->l_to;?>" />
        </div>
    <div class="form-group">
    	<label>Status</label>
        <select class="form-control" name="l_status">
        	<option value="">Pending</option>
            <option value="Approve" <?php if($leave->l_status=="Approve"){echo "selected";}?>>Approve</option>
            <option value="Reject" <?php if($leave->l_status=="Reject"){echo "selected";}?>>Reject</option>
        </select>
    </div>
    <div class="form-group">
    	<label>Remarks</label>
        <textarea class="form-control" name="l_remarks" rows="3"><?php echo $leave->l_remarks;?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update Status</button>
</form>
</div>
<div class="col-md-9">
<h5 class="text-warning text-center">Previous Leave History</h5>
<table class="table table-condensed table-striped table-bordered">
    <thead><tr><th>S.No.</th><th>Apply Date</th><th>Leaves Date</th>
           <th>Days</th><th>Leave Type</th><th>Action</th></tr></thead>
    <tbody>
        <?php $i=1;foreach($pleaves as $l){?>
<tr><td><?php echo $i;?></td>
<td><?php echo date("d M'Y",strtotime($l->applied_date));?></td>
<td><?php echo date("d M'Y",strtotime($l->l_from)).'<br/>'.date("d M'Y",strtotime($l->l_to));?></td>
<td><?php echo $l->total_days;?></td>
<td><?php echo $l->leave_type;?></td>
<td><a href="#" class="btn btn-danger btn-sm del_leave" id="<?php echo $l->laid;?>"><i class="fa fa-trash-o"></i></a>
<a href="#" class="btn btn-sm btn-success leave_status" id="<?php echo $l->laid;?>"  data-toggle="modal" data-target="#status_modal"><i class="fa fa-eye"></i></a></td>
</tr>
        <?php $i++;}?>
    </tbody>
</table>
</div>
<script>
$(document).ready(function(){
	$("#leave_status_update").submit(function(e){e.preventDefault();
		var formdata=$(this).serialize();
		$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/leave_status_update',
				 data: {formdata:formdata},
				 success: function(res){
					alert(res);
					//$(".status_modal").html(res);
				 }
			});
	});
	$(".leave_status").click(function(){
			var id=$(this).attr('id');
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/leave_status',
				 data: {id:id},
				 success: function(res){
					$(".status_modal").html(res);
				 }
			});
		});
		$(".leave_ap_delete").click(function(e){e.preventDefault();
		if(!confirm("Sure you want to delete?")){
			  return false;
			}
			var id=$(this).attr("id");$(this).closest("tr").remove();
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/ajax_leave_ap_delete',
				 data: {id:id},
				 success: function(response){
					 //alert(response);
				 }
			});
		});
});
</script>
