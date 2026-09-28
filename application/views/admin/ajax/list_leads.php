<?php $i=1;foreach($leads as $l){?>
<tr><td><div class="checkbox">
<input type="checkbox" name="leads[]" id="check<?php echo $l->lead_id;?>" value="<?php echo $l->lead_id;?>" /> 
<label for="check<?php echo $l->lead_id;?>"><?php echo $i;?></label></div></td>
    <td><?php echo '<span class="badge badge-dark">'.date("d M'Y",strtotime($l->lead_date)).'</span><br/><span class="badge badge-primary">'.$l->lead_type.'</span><br/>'.$l->lead_src;?></td>
                    <td><?php echo '<span class="badge badge-dark">'.$l->firstname.' '.$l->last_name.'</span><br/>'.$l->contact_person.'<br/>'.$l->contact_phone1.'<br/>'.$l->email;?></td>
                    <td><?php echo $l->lead_remark;?> </td><td>
    <a href="#" id="<?php echo $l->lead_id;?>" class="btn btn-sm btn-success lead_details"  data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i> Follow</a>                      
    <a href="<?php echo base_url().'admin/list_leads/'.$l->lead_id;?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
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