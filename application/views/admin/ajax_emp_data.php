
<?php $i=1;
$dt_basic=$dt_da=$dt_house=$dt_city=$dt_wash=$dt_medical=$dt_fix_ta=$dt_other=$dt_dues=$dt_gpf=$dt_gpf_recv=$dt_gis=$dt_fest=$dt_hre_recv=$dt_water=$dt_tax=0;
$dt_ded=$netsal=0;
//exit;
//echo "<pre>";print_r($empdata);exit;
foreach($empdata as $c){?>
<tr <?php if($c->dt_exclude!=""){echo "bgcolor='#f59191'";}?>><td><?php echo $i;?></td>
	
    <td><?php echo $c->dt_type_mon;?></td>
    <td bgcolor="orange" title="<?php echo $c->ddo_name;?>" <?php if($c->ddo_num!=$this->session->userdata("ddo_num")){echo 'class="text-danger"';}?>><?php echo $c->ddo_num;?></td>
    <td><?php echo $c->dt_bill_no; ?></td>
	<td><?php echo $c->dt_btr;?></td>
    <td><?php echo $c->dt_basic;$dt_basic=$dt_basic+$c->dt_basic;?></td>
    <td><?php echo $c->dt_da;$dt_da=$dt_da+$c->dt_da;?></td>
    <td><?php echo $c->dt_house;$dt_house=$dt_house+$c->dt_house;?></td>
    <td><?php echo $c->dt_city;$dt_city=$dt_city+$c->dt_city;?></td>
    <td><?php echo $c->dt_wash;$dt_wash=$dt_wash+$c->dt_wash;?></td>
    <td><?php echo $c->dt_medical;$dt_medical=$dt_medical+$c->dt_medical;?></td>
    <td><?php echo $c->dt_fix_ta; 
    if (is_numeric($c->dt_fix_ta)) {
        $dt_fix_ta += $c->dt_fix_ta;
    }?></td>
    <td><?php echo $c->dt_other;$dt_other=$dt_other+$c->dt_other;?></td>
    <td><?php echo $c->dt_dues;$dt_dues=$dt_dues+$c->dt_dues;?></td>
    <td><?php echo $c->dt_gpf;$dt_gpf=$dt_gpf+$c->dt_gpf;?></td>
    <td><?php echo $c->dt_gpf_recv;$dt_gpf_recv=$dt_gpf_recv+$c->dt_gpf_recv;?></td>
    <td><?php echo $c->dt_gis;$dt_gis=$dt_gis+$c->dt_gis;?></td>
    <td><?php echo $c->dt_fest;$dt_fest=$dt_fest+$c->dt_fest;?></td>
    <td><?php echo $c->dt_hre_recv;$dt_hre_recv=$dt_hre_recv+$c->dt_hre_recv;?></td>
    <td><?php echo $c->dt_water;$dt_water=$dt_water+$c->dt_water;?></td>
    <td><?php echo $c->dt_tax;$dt_tax=$dt_tax+$c->dt_tax;?></td>
    <td><?php echo $c->dt_ded;$dt_ded=$dt_ded+$c->dt_ded;?></td>
    <td><?php echo $c->dt_dues-$c->dt_ded;$netsal=$netsal+($c->dt_dues-$c->dt_ded);?></td>
    <td>
  
    <a href="#" id="<?php echo $c->dt_id;?>" class="btn btn-sm btn-warning emp_data" data-bs-toggle="modal" data-bs-target="#emp_data_box"><i class="bi bi-pencil-square"></i></a>
 <a href="#" id="<?php echo $c->dt_id; ?>" class="btn btn-sm btn-danger empd_delete"><i class="bi bi-archive"></i></a></td></tr>
<?php $i++;}
?>
<tr>
<td colspan="5">Total</td>
<td><?php echo $dt_basic;?></td>
<td><?php echo $dt_da;?></td>
<td><?php echo $dt_house;?></td>
<td><?php echo $dt_city;?></td>
<td><?php echo $dt_wash;?></td>
<td><?php echo $dt_medical;?></td>
<td><?php echo $dt_fix_ta;?></td>
<td><?php echo $dt_other;?></td>
<td><?php echo $dt_dues;?></td>
<td><?php echo $dt_gpf;?></td>
<td><?php echo $dt_gpf_recv;?></td>
<td><?php echo $dt_gis;?></td>
<td><?php echo $dt_fest;?></td>
<td><?php echo $dt_hre_recv;?></td>
<td><?php echo $dt_water;?></td>
<td><?php echo $dt_tax;?></td>
<td><?php echo $dt_ded;?></td>
<td><?php echo $netsal;?></td>
</tr>
<script>
$(document).ready(function(){
	$(".in_feat").click(function(){



var id=$(this).val();



var v="";



if ($(this).is(':checked')) {



	var v='yes';



}



//alert(v);



$.ajax({



 type: "POST",



 url: '<?php echo base_url();?>admin/ajax_exclude_data',



 data: {v:v,id:id},



 success: function(response){



	// alert(response);



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