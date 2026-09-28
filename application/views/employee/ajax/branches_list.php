<?php $i=1;foreach($brs as $c){?>
<tr><td><?php echo $i;?></td>
	
    <td><?php echo $c->br_name;?><br/><label class="badge badge-warning">CODE - <?php echo $c->br_code;?></label></td>
    <td><i class="fa fa-envelope"></i> <?php echo $c->br_mail;?><br/>
    	<i class="fa fa-phone"></i> <?php echo $c->br_phone1;?><br/>
        <i class="fa fa-phone"></i> <?php echo $c->br_phone2;?><br/>
        <i class="fa fa-map-marker"></i> <?php echo $c->br_address.'<br/>'.$c->br_city.' '.$c->state;?></td>
    <td><a href="<?php echo base_url().'admin/branches/'.$c->br_id;?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
    <a href="#" id="<?php echo $c->br_id;?>" class="btn btn-sm btn-danger comp_delete"><i class="fa fa-trash-o"></i></a></td></tr>
<?php $i++;}?>
<script>
$(document).ready(function(){
$(".comp_delete").click(function(e){e.preventDefault();
	if(!confirm("Sure you want to delete?")){
		  return false;
		}
		var id=$(this).attr("id");$(this).closest("tr").remove();
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_branch_delete',
			 data: {id:id},
			 success: function(response){
				 //alert(response);
			 }
		});
	});
});
</script>