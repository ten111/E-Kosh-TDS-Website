<?php $i=1;foreach($tasks as $c){?>
<tr><td><?php echo $i;?></td>
    <td><?php echo $c->tsk_subject;?></td>
    <td><?php echo date("D d'M",strtotime($c->tsk_start));?></td>
    <td><?php echo date("D d'M",strtotime($c->tsk_end));?></td>
    <td><?php echo $c->tsk_priority;?></td>
    <td><?php echo date("D d'M H:i a",strtotime($c->tsk_created_time));?></td>
    <td><label class="badge badge-success"><?php echo $c->tsk_status;?></label><br/>
    <?php //$parts=round(100/$totcheck);
	$progress=0;$prog=0;
	$emps=$this->db->get_where("task_emps",array("tsk_id"=>$c->tsk_id))->result();
	foreach($emps as $pr){//echo $pr->tsk_wt;
		
		$t=$this->db->get_where("checklists",array("tsk_id"=>$c->tsk_id,"emp_id"=>$pr->emp_id));
		$totcheck=$t->num_rows();
		$parts=round($pr->tsk_wt/$totcheck);$progress=0;
		$pro=$t->result();
		foreach($pro as $prr){if($prr->chk_status=="Completed"){$prog+=$parts;}}
		
	    //$prog+=$prr->tsk_wt;
		//$progress=$prog+=$pr->tsk_wt;
	}//echo $prog;?>
    <div class="progress">
        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $prog;?>%" aria-valuenow="<?php echo $prog;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $prog;?>%</div>
    </div></td>
    <td> <?php //if($c->tsk_emp==""){$as="assign";}else{$as=$c->emp_id.'-'.$c->firstname.' '.$c->lastname;}?>
    <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-info btn-sm ajax_emp_assign" id="<?php echo $c->tsk_id;//.'-'.$c->tsk_emp;?>"><?php echo $this->db->get_where("task_emps",array("tsk_id"=>$c->tsk_id))->num_rows();?> Users Assigned</button>
    <a href="#" class="btn btn-sm btn-success" id="<?php echo $c->tsk_id;?>"><i class="fa fa-eye"></i></a>
    <a href="<?php echo base_url().'employee/list_tasks/'.$c->tsk_id;?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
    <a href="#" id="<?php echo $c->tsk_id;?>" class="btn btn-sm btn-danger task_delete"><i class="fa fa-trash-o"></i></a></td></tr>
<?php $i++;}?>
<script>
$(document).ready(function(){
$(".task_delete").click(function(e){e.preventDefault();
if (!confirm("Sure you want to delete?")){
		  return false;
		}
	var id=$(this).attr("id");$(this).closest("tr").remove();
	$.ajax({
		 type: "POST",
		 url: '<?php echo base_url();?>employee/task_delete',
		 data: {id:id},
		 success: function(response){
			 //alert(response);
		 }
	});
});
$(".ajax_emp_assign").click(function(){
	var id=$(this).attr("id");
	$.ajax({
		 type: "POST",
		 url: '<?php echo base_url();?>employee/ajax_emp_assign',
		 data: {id:id},
		 success: function(res){
			 $(".load_form").html(res);
			 //alert(response);
		 }
	});
});
});
</script>