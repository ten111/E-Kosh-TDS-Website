<?php $i=$num+1;foreach($comps as $c){?>
<tr><td><?php echo $i;?></td>
	
    <td><?php echo $c->emp_name;?><br/><?php echo $c->emp_mob;?></td>
    <td><?php echo $c->emp_code;?></td>
	<td>
<?php $trto=$this->db->get_where("clients",array("client_id"=>$c->emp_hddo2))->row();
echo $trto->ddo_name.'<br/><span class="badge bg-dark">'.$trto->ddo_num.'</span>';?>
</td>
    <td><?php echo $c->emp_bill;?></td>
    <td><?php echo $c->emp_pan;?></td>
    <td><?php echo $c->emp_mob;?></td>
    <td><?php echo $c->emp_email;?></td>
    <td><?php echo $c->emp_school.'</td><td>'.$c->emp_sankul;?></td>
    <td><?php echo $c->emp_desg;?></td>
    <td><?php echo $c->emp_gpf.'/'.$c->emp_tax;?></td>
    <td><?php echo $c->emp_status;?></td>
    <td>
    <a title="View Deatails" href="<?php echo base_url().'admin/emp_details/'.$c->emp_id;?>" class="btn btn-sm btn-success"><i class="bi bi-eye"></i></a>
<?php $i++;}?>
<script>
$(document).ready(function(){
	$(".change_pass").click(function(){

			var id=$(this).attr("id");
			//alert(id);
			$("#change_pass_vid").val(id);

		});
	$(".in_trend").click(function(){
							var id=$(this).val();
							//alert(id);
							var v="";
							if ($(this).is(':checked')) {
								var v=$(this).val();
							}
							//alert(v);
							$.ajax({
							 type: "POST",
							 url: '<?php echo base_url();?>admin/in_calling',
							 data: {v:v,id:id},
							 success: function(response){
								// alert(response);
							 }
							 });
						});
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