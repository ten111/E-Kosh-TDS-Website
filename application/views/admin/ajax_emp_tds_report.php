<?php //echo "<pre>";print_r($months);exit;
$i=$num+1;foreach($list as $c){
	$tot=0;$ptot=0;$tax_tot=0;?>
<tr>
	
<td><?php echo $i;?></td>
    <td><?php echo $c->dt_emp_code;?></td>
    <td><?php echo $c->emp_name;?></td>
    <td><?php echo $c->emp_pan;?></td>
    <td><?php echo $c->emp_desg;?></td>
    <td><?php echo $c->dt_type;?></td>
	
    <?php  foreach($months as $mon){
        if($c->dt_type=="Salary"){
        $sal=$this->db->get_where("emp_data",array("dt_emp_code"=>$c->dt_emp_code,"dt_month"=>$mon->dt_month,"dt_type"=>"Salary","dt_bill_no!="=>""));
        }else{
        $sal=$this->db->get_where("emp_data",array("dt_emp_code"=>$c->dt_emp_code,"dt_month"=>$mon->dt_month,"dt_type"=>$c->dt_type));
        }
        if($sal->num_rows()>0){
            $sal=$sal->row();
		echo '<td>'.$sal->dt_dues.'</td>';
		$tot=$tot+$sal->dt_dues;
        ?>
        <td><?php echo $tax=$sal->dt_tax;?></td>
		<?php }else{echo '<td></td><td></td>';}  $tax_tot=$tax+$tax_tot; }?>
    <th bgcolor="orange"><?php echo $tot;?></th>
    <th bgcolor="orange"><?php echo $tax_tot;?></th>
</tr>
<?php $i++;}?>
<script>
$(document).ready(function(){
	$(".load_itr_box").click(function(){



var id=$(this).attr('id');
var m=$(this).attr('title');
$(".modal-title").html(m);



$.ajax({



 type: "POST",



 url: '<?php echo base_url();?>admin/ajax_load_tax',



 data: {id:id},



 success: function(response){



	$(".itr_box").html(response);



 }



 });



});



	$(".load_emp_data").click(function(){



var id=$(this).attr('id');
var m=$(this).attr('title');
$(".modal-title").html(m);



$.ajax({



 type: "POST",



 url: '<?php echo base_url();?>admin/ajax_load_emp_data',



 data: {id:id},



 success: function(response){



	$(".emp_data_box").html(response);



 }



 });



});
  $(".emp_data").click(function(e){e.preventDefault();
		var id=$(this).attr("id");
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_edit_emp_data',
			 data: {id:id},
			 success: function(res){
				 $("#emp_data_div").html(res);
			 }
		});
	});
$(".change_st").change(function(e){e.preventDefault();
		var id=$(this).attr("id");
		var st=$(this).val();
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_update_emp',
			 data: {id:id,st:st},
			 success: function(response){
				 //alert(response);
			 }
		});
	});

  $(".empd_delete").click(function(e){e.preventDefault();
	if(!confirm("Sure you want to delete?")){
		  return false;
		}
		var id=$(this).attr("id");$(this).closest("tr").remove();
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_empd_delete',
			 data: {id:id},
			 success: function(response){
				 //alert(response);
			 }
		});
	});
});
</script>