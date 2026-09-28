<?php $i=$num+1;foreach($list as $c){?>
<tr <?php if($c->dt_exclude!=""){echo "bgcolor='#f59191'";}?>><td><?php echo $i;?></td>
	
    <td style="width:200px;"><?php echo $c->emp_name;?><br/>
	<label><input type="checkbox" name="in_trend" <?php if($c->dt_exclude!=""){echo "checked";}?> value="<?php echo $c->dt_id;?>" class="in_feat" /> <span class="label label-warning">Exclude</span></label></td><td>
	<?php echo $c->emp_code;?><br/>
    <a href="#" title="<?php echo $c->emp_name.'|'.$c->emp_code;?>" id="<?php echo $c->dt_id;?>" class="btn btn-sm btn-warning emp_data" 
	data-bs-toggle="modal" data-bs-target="#emp_data_box"><i class="las la-file-invoice"></i></a>
                                  
                                  <a href="#" id="<?php echo $c->dt_id; ?>" class="btn btn-sm btn-danger empd_delete"><i class="bi bi-archive"></i></a>
								<br/>
								</td>
    <td><?php //echo $c->dt_bill_no.'/'.$c->dt_btr; 
	if($c->dt_bill_no!=""){echo $c->dt_bill_no; }else{?>
    <select class="change_st" id="<?php echo $c->dt_id.'-'.$c->dt_emp_code;?>"><option value="">Select</option>
    <option value="Deceased">Deceased</option>
    <option value="Transferred">Transferred</option>
    <option value="Retired">Retired</option>
    <option value="Absent">Absent</option>
    <option value="Medical Leave">Medical Leave</option>
    <option value="Earned Leave">Earned Leave</option>
    <option value="Deputation">Deputation</option>
    <option value="Salary Released">Salary Released</option></select><?php }?></td>
    <td><?php echo $c->dt_btr;?></td>
    <td><?php echo $c->dt_basic;?></td>
    <td><?php echo $c->dt_da;?></td>
    <td><?php echo $c->dt_house;?></td>
    <td><?php echo $c->dt_city;?></td>
    <td><?php echo $c->dt_wash;?></td>
    <td><?php echo $c->dt_medical;?></td>
    <td><?php echo $c->dt_fix_ta;?></td>
    <td><?php echo $c->dt_other;?></td>
    <td><?php echo $c->dt_dues;?></td>
    <td><?php echo $c->dt_gpf;?></td>
    <td><?php echo $c->dt_gpf_recv;?></td>
    <td><?php echo $c->dt_gis;?></td>
    <td><?php echo $c->dt_fest;?></td>
    <td><?php echo $c->dt_hre_recv;?></td>
    <td><?php echo $c->dt_water;?></td>
    <td><?php echo $c->dt_tax;?></td>
    <td><?php echo $c->dt_ded;?></td>
    <td><?php echo $c->dt_dues-$c->dt_ded;?></td>
    <td><?php echo $c->dt_month;?></td>
<?php $i++;}?>
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
		//var id=$(this).attr("id");
		//var title=$(this).attr("title");
		//$(".modal-title").text(title);

		
var id=$(this).attr('id');
var p=$(this).attr('title');
var m=p.split("|");
var d='<table class="table table-condensed table-bordered"><tr><th>Employee Name</th><th>'+m[0]+'</th></tr>';
 d+='<tr><th>Employee Code</th><th>'+m[1]+'</th></tr></table>';
$(".modal-title").html(d);
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