<div class="well">
<label class="badge badge-success pull-right"><?php echo $task->tsk_priority;?></label>
<h4 class="text-danger"><?php echo $task->tsk_subject;?></h4>
<p><?php echo $task->tsk_title;?></p>
</div>
<table class="table table-bordered table-striped table-condensed">
<thead><tr><th>S.No.</th><th>Checklist/Remark</th><th>Status</th></tr></thead>
<tbody>
<?php $i=1;foreach($checklist as $c){?>


<tr><td><?php echo $i;?></td>
    <td><?php echo $c->checklist;?></td>
    <td><form class="save_remark" method="post" action="">
		<input type="hidden" name="chklid" value="<?php echo $c->chklid;?>" />
        <textarea class="form-control" placeholder="Remark" name="chk_remark" rows="2"><?php echo $c->chk_remark;?></textarea>
        <div class="row">
        	<div class="col-md-9">
            <select class="form-control"  name="chk_status">
                <option value="">Select Status</option>
                <option value="Pending" <?php if($c->chk_status=="Pending"){echo "selected";}?>>Pending</option>
                <option value="Completed" <?php if($c->chk_status=="Completed"){echo "selected";}?>>Completed</option>
            </select>
            </div>
            <div class="col-md-3">
        <button type="submit" class="btn btn-warning pull-right">Save</button></div>
        </div></form>	</td></tr><?php $i++;}?>
</tbody></table>



<script>
$(document).ready(function(){
$(".save_remark").submit(function(e){e.preventDefault();
		//alert("asdf");
		var formdata=$(this).serialize();
		//alert(formdata);
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>employee/save_checklist',
			 data: {formdata:formdata},
			 success: function(res){
				 alert(res);
				 //$(".load_checklist").html(res);
				 //alert(response);
			 }
		});
	});
});
</script>