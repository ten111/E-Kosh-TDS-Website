<?php $i=1;foreach($tasks as $c){
	$t=$this->db->get_where("checklists",array("tsk_id"=>$c->tsk_id,"emp_id"=>$this->session->userdata("user")));
	$totcheck=$t->num_rows();?>
<tr><td><?php echo $i;?></td>
    <td><?php echo $c->tsk_subject;?></td>
    <td><?php echo date("D d'M",strtotime($c->tsk_start));?></td>
    <td><?php echo date("D d'M",strtotime($c->tsk_end));?></td>
    <td><?php echo $c->tsk_priority;?></td>
    <td><?php echo date("D d'M H:i a",strtotime($c->tsk_created_time));?></td>
    <td>
    <?php $parts=round(100/$totcheck);$progress=0;
	$pro=$t->result();
	foreach($pro as $pr){if($pr->chk_status=="Completed"){$progress+=$parts;}}?>
    <div class="progress">
        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $progress;?>%" aria-valuenow="<?php echo $progress;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $progress;?>%</div>
    </div>
    <label class="badge badge-success"><?php echo $c->tsk_status;?></label></td>
    <td>  <a href="#" id="<?php echo $c->tsk_id;?>" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-success view_checklist"><i class="fa fa-check"></i> <?php echo $totcheck;?> Checklist</a></td></tr>
<?php $i++;}?>
<script>
$(document).ready(function(){
$(".view_checklist").click(function(){
	var id=$(this).attr("id");
	$.ajax({
		 type: "POST",
		 url: '<?php echo base_url();?>employee/ajax_task_checklist',
		 data: {id:id},
		 success: function(res){
			 $(".load_checklist").html(res);
			 //alert(response);
		 }
	});
});
});
</script>