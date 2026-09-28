<?php $i=1;foreach($comps as $c){?>
<tr><td><?php echo $i;?></td>
	<td width="100px"><img width="100%" class="img img-responsive" src="<?php echo base_url().'assets/images/emps/'.$c->profile_photo;?>" /></td>
    <td><h6 class="text-success"><?php echo $c->firstname.' '.$c->lastname;?></h6><br/>
    <label class="badge badge-danger"><?php echo $c->gender;?></label>
    <label class="badge badge-warning"><i class="fa fa-ring"></i> <?php echo $c->marital;?></label></td>
    <td><i class="fa fa-mobile"></i> <?php echo $c->mob1;?><br/><i class="fa fa-mobile"></i> <?php echo $c->mob2;?><br/></td>
    <td><?php echo $c->br_name.'-'.$c->br_code;?></td>
    <td><?php echo $c->dob;?></td>
    <td>
    <a href="#" class="btn btn-sm btn-success" id="<?php echo $c->emp_id;?>"><i class="fa fa-eye"></i></a>
    <a href="<?php echo base_url().'admin/add_employee/'.$c->emp_id;?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
    <a href="#" id="<?php echo $c->emp_id;?>" class="btn btn-sm btn-danger comp_delete"><i class="fa fa-trash-o"></i></a></td></tr>
<?php $i++;}?>
<script>
$(document).ready(function(){
$(".comp_delete").click(function(e){e.preventDefault();
		if (!confirm("Sure you want to delete?")){
				  return false;
				}
			var id=$(this).attr("id");$(this).closest("tr").remove();
			$.ajax({
							 type: "POST",
							 url: '<?php echo base_url();?>admin/ajax_emp_delete',
							 data: {id:id},
							 success: function(response){
								 //alert(response);
							 }
							 });
		});
});
</script>