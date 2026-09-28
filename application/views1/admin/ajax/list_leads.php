<?php $i=1;foreach($leads as $l){?>
<tr><td><div class="checkbox">
<input type="checkbox" name="leads[]" id="check<?php echo $l->lead_id;?>" value="<?php echo $l->lead_id;?>" /> <label for="check<?php echo $l->lead_id;?>"><?php echo $i;?></label></div></td>
    <td><b class="text-danger"><?php echo $l->company;?></b><br/>
    <?php echo $l->address.'<br/>'.$l->city.' '.$l->state.' '.$l->pincode;?><br/>
    <label class="badge badge-dark">LeadID - <?php echo "LD".$l->lead_id;?></label></td>
    <td><?php echo $l->bs_title;?><br/>
    <label class="badge badge-success"><?php echo $l->bs_type;?></label></td>
    <td><?php echo $l->lead_src;?><br/>
	<label class="badge badge-warning"><?php echo date("d M'Y",strtotime($l->lead_date));?></label></td>
    <td><i class="fa fa-user"></i> <?php echo $l->contact_person;?><br/>
        <i class="fa fa-envelope"></i> <?php echo $l->email;?><br/>
        <i class="fa fa-phone"></i> <?php echo $l->contact_phone1;?> <?php echo $l->contact_phone2;?></td>
    <td><?php echo $l->lead_remark;if(isset($l->emp_id)){?>
    <label class="badge badge-info"><?php echo $l->firstname.' '.$l->lastname;?></label><?php }?></td>
    <td>
    <a href="#" id="<?php echo $l->lead_id;?>" class="btn btn-sm btn-success lead_details"  data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i> Follow</a>                      
    <a href="<?php echo base_url().'admin/add_lead/'.$l->lead_id;?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
    <a href="#" id="<?php echo $l->lead_id;?>" class="btn btn-sm btn-danger del_lead"><i class="fa fa-trash-o"></i></a></td>
</tr>
<?php $i++;}?>
<script>
$(document).ready(function(){
$(".lead_details").click(function(){
			var id=$(this).attr("id");
			$("#leadid").text("LD-"+id);
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/lead_details',
				 data: {id:id},
				 success: function(res){
					$("#lead_details").html(res);
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
$("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});

</script>