<h4>Total Leads - <b><?php echo $unlead;?></b> - <b id="assdone"><?php echo $unlead;?></b></h4>
<form action="" method="post" id="dform">
<table class="table table-striped table-bordered">
	<thead><tr><th>Employee</th><th>Data</th></tr></thead>
    <tbody>
    <?php $query=$this->db->get_where("employees",array("emp_call!="=>""));
	$dnum=$unlead/$query->num_rows();
	$emps=$query->result();
	//$start=0;
	foreach($emps as $emp){?>
    <tr><td><?php echo $emp->firstname.' '.$emp->lastname;?></td>
    	<input type="hidden" name="emps[]" value="<?php echo $emp->emp_id;?>" />
    	<td><input type="text" class="form-control leadsbox" name="data[]" value="<?php echo round($dnum);?>" placeholder="" /></td></tr>
    <?php }?>
    </tbody>
</table>	
<button type="submit" class="btn btn-primary pull-right">SUBMIT</button>
</form>
<div id="result"></div>
<script>

var t=0;
		
		$(".leadsbox").keyup(function(){
			//alert("dsfasF");
			var t=0;
			//var qt=[];
			///var idd=$(this).attr("id").split("-");;
			//var v=$(this).val();//.split("-");
			//var vv=v[1];
			//$("#subt"+idd[1]).text(vv);
			$(".leadsbox").each(function(){
			
			///if (this.checked) {
			  // var id=$(this).attr("id").split("-");
			  // var qtyt=$("#select-"+id[1]).val().split("-");
			   //alert(qtyt[1]);
			   var v=$(this).val();
			   //$("#check-"+id[1]).attr("qty",qtyt[0]);
			   //alert(v);
			   //var vv=v.split("-");
			   //alert(vv[2]);
			   if(parseInt(v)>0){
			   t=t+parseInt(v);//+parseInt(qtyt[1]);
			   //qt.push(qtyt[0]);
			   }
			//$("#qtyss").val(qt.toString());
			//alert(t);
			//$("#total").text(t);
			//$("#addon_total").val(t);
		});	
			   $("#assdone").text(t);
	  });
	$("#dform").submit(function(e){e.preventDefault();
			var formdata=$(this).serialize();
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/dist_form_submit',
				 data: {formdata:formdata},
				 success: function(res){
					 //console.log(res);
					 $("#result").html(res);
				 }
			 });	
		});
</script>