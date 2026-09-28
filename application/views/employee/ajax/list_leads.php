<?php if(empty($leads)){
?><tr><th colspan="7"><h3 class="text-danger text-center" style="padding:50px;">No Records Found</h3></th></tr><?php 
}else{$i=1;foreach($leads as $l){?>
<tr id="tr<?php echo $l->lead_id;?>"><td><?php echo $i;?></td>
    <td><label class="badge badge-dark"><?php echo "LD".$l->lead_id;?></label></td>
    <td><?php echo $l->lead_src;?><br/>
	<label class="badge badge-warning"><?php echo date("d M'Y",strtotime($l->lead_date));?></label></td>
    <td><i class="fa fa-user"></i> <?php echo $l->contact_person;?><br/>
        <i class="fa fa-envelope"></i> <?php echo $l->email;?><br/>
        <i class="fa fa-phone"></i> <?php echo $l->contact_phone1;?> <?php echo $l->contact_phone2;?></td>
    <td><label class="badge badge-dark"><?php echo $l->lead_status ;?></label>
    <?php if($l->lead_status=='Follow Up' || $l->lead_status=='Free Trial'){
		$tom=date("Y-m-d", time() + 86400);?>
    <br/><label><?php if(date("Y-m-d")==$l->next_date){echo 'Today ';}else if($tom==$l->next_date){echo 'Tomorrow ';}else{echo date("M d D",strtotime($l->next_date));} echo ' '.$l->next_time;?></label>
    <?php }?>
    <br/><?php echo $l->lead_remark;?></td>
    <td>
    <a href="#" id="<?php echo $l->lead_id;?>" class="btn btn-sm btn-success lead_details"  data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i> Follow</a>                      
    <!--<a href="<?php //echo base_url().'admin/add_lead/'.$l->lead_id;?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
    <a href="#" id="<?php //echo $l->lead_id;?>" class="btn btn-sm btn-danger del_lead"><i class="fa fa-trash-o"></i></a>--></td>
</tr>
<?php $i++;}?>
<script>
$(document).ready(function(){
$(".lead_details").click(function(){
			var id=$(this).attr("id");
			$("#leadid").text("LD-"+id);
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>employee/lead_details',
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
							 url: '<?php echo base_url();?>employee/ajax_del_lead',
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
<?php }?>