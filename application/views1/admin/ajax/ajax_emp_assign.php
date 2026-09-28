<div class="col-md-5">
<form  action="" id="assign_task" method="post">
	<input type="hidden" name="task_id" value="<?php echo $id;?>" />
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
        <option value="">Select Designation</option>
    </select>	
  </div>
  <div class="form-group">
    <select class="form-control" name="emp" id="emps" required>
        <option value="">Select Employee</option>
    </select>	
  </div>
  <h6 class="text-danger">Task Checklist</h6>
    <div class="input-group control-group after-add-more">
      <input type="text" name="checklist[]" required class="form-control" placeholder="Checklist Item">
      <div class="input-group-btn"> 
        <button class="btn btn-success add-more" type="button"><i class="fa fa-plus"></i></button>
      </div>
    </div>
  <button style="margin-top:5px;" type="submit" class="btn btn-success"><i class="fa fa-check"></i> Assign</button>
  <!--<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>-->
</form></div>
<div class="col-md-7">
<table class="table table-bordered table-condensed">
<tr><th>S.No.</th><th>Photo</th><th>Name/ID</th><th>Action</th></tr>
<?php $i=1;foreach($emps as $emp){?>
<tr><td><?php echo $i;?></td>
    <td width="50px"><img width="100%" class="img img-responsive" src="<?php echo base_url().'assets/images/emps/'.$emp->profile_photo;?>" /></td>
    <td><?php echo $emp->firstname.' '.$emp->lastname;?>
    <br/><label class="badge badge-success">#EMP-<?php echo $emp->emp_id;?></label>
    <input style="width:80px;" value="<?php echo $emp->tsk_wt;?>" type="number" name="tsk_wt" class="tsk_wt" id="<?php echo $emp->tsk_emp_id;?>" /></td>
    <td>
    <a href="#" id="<?php echo $emp->tsk_emp_id;?>" class="btn btn-sm btn-success edit_checklist"><i class="fa fa-check"></i> <?php echo $this->db->get_where("checklists",array("tsk_emp_id"=>$emp->tsk_emp_id))->num_rows();?> Checklist</a>
    <a href="#" id="<?php echo $emp->tsk_emp_id;?>" class="btn btn-sm btn-danger delemp_task"><i class="fa fa-trash-o"></i></a></td></tr>
<?php $i++;}?>
</table>
</div>
</div>

<div class="copy" style="display:none;">
  <div class="control-group input-group" style="margin-top:10px">
    <input type="text" name="checklist[]" required class="form-control" placeholder="Checklist Item">
    <div class="input-group-btn"> 
      <button class="btn btn-danger remove" type="button"><i class="fa fa-times"></i></button>
    </div>
  </div>
</div>
<script>
	$(document).ready(function(){
		$(".tsk_wt").keyup(function(){
			var wt=$(this).val();
			var id=$(this).attr('id');
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/ajax_tsk_wt',
				 data: {id:id,wt:wt},
				 success: function(res){//alert(res);
					// alert("OTP Sent Again");
					//$("#desg").html(res);
				 }
			 });
		});
		
		$(".add-more").click(function(){ 
			  var html = $(".copy").html();
			  $(".after-add-more").after(html);
		});
		
		$("body").on("click",".remove",function(){ 
			  $(this).parents(".control-group").remove();
		});
		
		$("#assign_task").submit(function(e){e.preventDefault();
			var formdata=$(this).serialize();
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/assign_task_emp',
				 data: {formdata:formdata},
				 success: function(res){//alert(res);
					 if(res==0){
					 alert("Employee Already Assigned.");
					 }else{
						 $(".load_form").html(res);
						//$("#<?php //echo $linkid;?>").text(res); 
					 }
					// alert("OTP Sent Again");
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
		$(".delemp_task").click(function(){
			var id=$(this).attr("id");
			$(this).closest("tr").remove();
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/delemp_task',
				 data: {id:id},
				 success: function(res){//alert(res);
					// alert("OTP Sent Again");
					//$("#desg").html(res);
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
	});
	</script>