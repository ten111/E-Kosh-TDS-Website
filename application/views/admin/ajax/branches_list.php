<?php $i=1;foreach($brs as $c){?>
<tr><td><?php echo $i;?></td>
	
    <td><?php echo $c->ddo_name;?><br/><label class="badge bg-warning"> <?php echo $c->ddo_num;?></label> &nbsp;
	<a target="_blank" href="<?php echo base_url().'admin/switch_client/'.$c->client_id;?>" class="btn btn-sm btn-primary"><i class="bi bi-login"></i> Login</a>	
	</td>
    <td><?php echo $c->cemp_name;?><br/><label class="badge bg-warning"> <?php echo $c->client_mob;?></label> 
	<label class="badge bg-success"> <?php echo $c->clerk_name;?></label><br/>
	    <i class="fa fa-envelope"></i> <?php echo $c->client_email;?></td>
    <td>
	
	<a id="<?php echo $c->client_id;?>" class="btn btn-sm btn-light change_pass" data-bs-toggle="modal" data-bs-target="#change_pass"><i class="bi bi-unlock"></i></a>	
	<a href="<?php echo base_url().'admin/branches/'.$c->client_id;?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
    <a href="#" id="<?php echo $c->client_id;?>" class="btn btn-sm btn-danger comp_delete"><i class="bi bi-archive"></i></a></td></tr>
<?php $i++;}?>
<script>
$(document).ready(function(){
	$(".change_pass").click(function(e){e.preventDefault();
		var id=$(this).attr("id");
		$("#client_id").val(id);
	});
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