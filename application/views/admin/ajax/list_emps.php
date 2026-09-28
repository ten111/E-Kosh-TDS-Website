<?php $i=$num+1;foreach($comps as $c){?>
<tr><td><?php echo $i;?></td>
	
    <td><?php echo $c->emp_name;?><br/>
	<?php echo $c->emp_mob;?></td>
    <td><?php echo $c->emp_code;?></td>
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
    <a href="<?php echo base_url().'admin/list_employees/'.$c->emp_id;?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
    <a href="#" id="<?php echo $c->emp_id;?>" class="btn btn-sm btn-danger comp_delete1"><i class="bi bi-archive"></i></a>
</td></tr>
<?php $i++;}?>
<script>
	$(".change_pass").click(function(){

			var id=$(this).attr("id");
			//alert(id);
			$("#change_pass_vid").val(id);

		});
	
$(".comp_delete1").off('click').on('click', function(e) {
    e.preventDefault();
    
    if (!confirm("Sure you want to delete?")) {
        return false;
    }
    
    var id = $(this).attr("id");
    var $row = $(this).closest("tr");
    
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>admin/ajax_emp_delete',
        data: {id: id},
        success: function(response) {
            $row.remove();
        }
    });
});
</script>