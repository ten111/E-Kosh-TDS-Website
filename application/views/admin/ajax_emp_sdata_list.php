<?php $i=$num+1;foreach($list as $c){
	$tot=0;$atot=0;$ptot=0;?>
<tr>
	
<td><?php echo $i;?></td>
    <td><?php echo $c->dt_emp_code;?></td>
	
    <td><?php echo $c->emp_name;?></td>
    <td><?php echo $c->emp_pan;?></td>
    <td><?php echo $c->emp_desg;?></td>
    <?php  foreach($months as $mon){
        $sal=$this->db->get_where("emp_data",array("dt_emp_code"=>$c->dt_emp_code,"dt_month"=>$mon->dt_month,"dt_type"=>"Salary"))->row();
		$tot=$tot+$sal->dt_dues;
        ?><td><button title="<?php echo $c->emp_name.'|'.$c->emp_code.'|'.$mon->dt_month.'|'.$c->dt_type;?>" id="<?php echo $sal->dt_id;?>" class="btn btn-sm btn-success load_emp_data" data-bs-toggle="modal" data-bs-target="#emp_data_box"><?php echo $sal->dt_dues;?></button></td>
		<?php 
		$sal = $this->db->select_sum('dt_dues')
                ->get_where("emp_data", 
                            array(
                                "dt_emp_code" => $c->dt_emp_code,
                                "dt_month" => $mon->dt_month,
                                "dt_type" => "Arear"
                            ))
                ->row();
		$sal2=$this->db->get_where("emp_data",array("dt_emp_code"=>$c->dt_emp_code,"dt_month"=>$mon->dt_month,"dt_type"=>"Arear"))->row();
		$atot=$atot+$sal->dt_dues;
        ?><td><button title="<?php echo $sal2->emp_name.'|'.$sal2->emp_code.'|'.$sal2->dt_month.'|'.$sal2->dt_type;?>" id="<?php echo $sal2->dt_id;?>" class="btn btn-sm btn-warning load_emp_data" data-bs-toggle="modal" data-bs-target="#emp_data_box"><?php echo $sal->dt_dues;//.' '.$mon->dt_month;?></button></td>
		<?php 
		$sal = $this->db->select_sum('dt_dues')
                ->get_where("emp_data", 
                            array(
                                "dt_emp_code" => $c->dt_emp_code,
                                "dt_month" => $mon->dt_month,
                                "dt_type" => "PayArear"
                            ))
                ->row();
		//$sal=$this->db->get_where("emp_data",array("dt_emp_code"=>$c->dt_emp_code,"dt_month"=>$mon->dt_month,"dt_type"=>"PayArear"))->row();?><td><button title="<?php echo $c->emp_name.'|'.$c->emp_code.'|'.$c->dt_month.'|'.$c->dt_type;?>" id="<?php echo $sal->dt_id;?>" class="btn btn-sm btn-info load_emp_data" data-bs-toggle="modal" data-bs-target="#emp_data_box"><?php echo $sal->dt_dues;?></button>
		</td>
		<?php }?>
    <th bgcolor="orange"><?php echo $tot;?></th>
    <th bgcolor="orange"><?php echo $atot;?></th>
    <th bgcolor="orange">
	<button title="<?php echo $c->emp_name.' '.$c->emp_code.' <br/>ITR Calculation '.$c->dt_fnyr;?>" id="<?php echo $c->emp_id.'-'.$c->dt_fnyr;?>" class="btn btn-sm btn-danger load_itr_box" data-bs-toggle="modal" data-bs-target="#load_itr_box">Computation</button>
		
	<?php //echo $tot+$atot;?></th>
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
var p=$(this).attr('title');
var m=p.split("|");
var d='<table class="table table-condensed table-bordered"><tr><th>Employee Name</th><th>'+m[0]+'</th></tr>';
 d+='<tr><th>Employee Code</th><th>'+m[1]+'</th></tr>';
d+='<tr><th>Salary Month</th><th>'+m[2]+'</th></tr></table>';

$(".modal-title").html(d);



$.ajax({



 type: "POST",



 url: '<?php echo base_url();?>admin/ajax_load_emp_data',



 data: {id:id,dt_type:m[3]},



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