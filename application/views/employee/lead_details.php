<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#home">Lead Details</a>
    </li>
    <li class="nav-item">
        <a class="nav-link followuptab" data-toggle="tab" href="#menu1">Follow Up History</a>
    </li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <div id="home" class="tab-pane active">
    <div class="row">
    <div class="col-md-6">
	<table class="table table-sm table-bordered" style="background:#f9f9f9;">
    	<tr  bgcolor="#666666" style="color:#fff;"><th colspan="2">Lead Details</th></tr>
        
        <tr><td>Contact Person</td><td><?php echo $lead->contact_person;?></td></tr>
        <tr><td>Email</td><td><?php echo $lead->email;?></td></tr>
        <tr><td>Phone</td><td><?php echo $lead->contact_phone1. ' '.$lead->contact_phone2;?></td></tr>
        <tr><td>Lead Source</td><td><?php echo $lead->lead_src;?></td></tr>
        <tr><td>Current Status</td><td><?php echo $lead->lead_status;?></td></tr>
        <tr><td>Created</td><td><?php echo $lead->lead_date;?></td></tr>
        <tr><td>Created By</td><td><?php echo $lead->lead_by;?></td></tr>
        <tr><td>Remark</td><td><?php echo $lead->lead_remark;?></td></tr>
    </table>
</div>
	<?php $chk=$this->db->get_where("followups",array("action_date"=>date("Y-m-d"),"lead_id"=>$lead->lead_id));
    if($chk->num_rows()>0){
    $last=$chk->row();
    $pro_type=$last->pro_type;
    $next_date=$last->next_date;
    $lremark=$last->lremark;
    $next_remark=$last->next_remark;
    $f_status=$last->f_status;
	$next_time=$last->next_time;
    }else{
    $pro_type="";
    $next_date=date("Y-m-d");
    $lremark="";
    $next_remark="";
    $f_status="";
	$next_time=date("H:i",time()+7200);
    }
    ?>
    <div class="col-md-6">
        <form action="" method="post" id="lead_update">
            <input type="hidden" name="lead_id" value="<?php echo $lead->lead_id;?>" />
            <div class="form-group">
                <label>Select Status</label>
                <select class="form-control" name="f_status" required>
                    <option value="">Select Type</option>
                    <option value="Switch Off"  <?php if($f_status=="Switch Off"){echo "selected";}?>>Switch Off/Not Connected</option>
                    <option value="Not Interested"  <?php if($f_status=="Not Interested"){echo "selected";}?>>NPC</option>
                    <option value="Follow Up"  <?php if($f_status=="Follow Up"){echo "selected";}?>>Follow Up</option>
                    <option value="Free Trial"  <?php if($f_status=="Free Trial"){echo "selected";}?>>Free Trial</option>
                    <option value="Interested"  <?php if($f_status=="Interested"){echo "selected";}?>>Interested</option>
                </select>
            </div>
            <div class="form-group">
                <label>Interested In</label>
                <select class="form-control" name="pro_type">
                    <option value="">Select</option>
                    <option value="Forex" <?php if($pro_type=="Forex"){echo "selected";}?>>Forex</option>
                    <option value="BSE/NSE" <?php if($pro_type=="BSE/NSE"){echo "selected";}?>>BSE/NSE</option>
                    <option value="Commodity" <?php if($pro_type=="Commodity"){echo "selected";}?>>Commodity</option>
                    <option value="Other" <?php if($pro_type=="Other"){echo "selected";}?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Description/Remark</label>
                <textarea class="form-control" placeholder="Short Remark" rows="2"  name="lremark"><?php echo $lremark;?></textarea>
            </div>
            <label class="text-danger"><input type="checkbox" name="nextcall" id="nextcall" value="nextcall"  /> Set Reminder</label>
            <div class="row">
            <div class="form-group col-md-7">
                <label>Next/Close Followup Date</label>
                <input type="date" class="form-control remind" disabled="disabled" name="next_date" value="<?php echo $next_date;?>" />
            </div>
            <div class="form-group col-md-5">
                <label>Reminder Time</label>
                <input type="time" class="form-control remind" disabled="disabled" name="next_time" value="<?php echo $next_time;?>" />
            </div>
            </div>
            <div class="form-group">
                <label>Next Followup Description/Remark</label>
                <textarea class="form-control" placeholder="Short Remark" rows="2"  name="next_remark"><?php echo $next_remark;?></textarea>
            </div>
            <div class="res_msg"></div>
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          	<button type="submit" name="convert" id="<?php echo $lead->lead_id;?>" class="btn btn-warning float-right convert_sale">Convert to Sale</button>
        </form>
    </div>
    <script>
    $(document).ready(function(){
		$("#nextcall").click(function(){
		if ($(this).is(':checked')) {
			$(".remind").removeAttr("disabled");
		}else{
			$(".remind").attr("disabled",true);
		}
		});

		
		$(".convert_sale").click(function(){
			var id=$(this).attr("id");
			if (!confirm("Sure you want to convert this to Sale?")){
			  return false;
			}
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>employee/convert_sale',
				 data: {id:id},
				 success: function(res){
					 alert(res);
					 //$(".res_msg").html(res);
					// $(".followuptab").trigger("click");
				 }
			});
		});
		//$(".followuptab").click(function(){
//			$.ajax({
//				 type: "POST",
//				 url: '<?php echo base_url();?>admin/lead_details',
//				 data: {id:<?php echo $lead->lead_id;?>},
//				 success: function(res){
//					$("#lead_details").html(res);
//				 }
//			});
//		});
        $("#lead_update").submit(function(e){e.preventDefault();
            var formdata=$(this).serialize();
			
            $.ajax({
                 type: "POST",
                 url: '<?php echo base_url();?>employee/ajax_lead_update',
                 data: {formdata:formdata},
                 success: function(res){
                     $(".res_msg").html(res);
					 $("#tr<?php echo $lead->lead_id;?>").remove();
                    // $(".followuptab").trigger("click");
                 }
            });
        });
		$(".fdelete").click(function(e){e.preventDefault();
			if(!confirm("Sure you want to delete?")){
				  return false;
				}
				var id=$(this).attr("id");$(this).closest("tr").remove();
				$.ajax({
					 type: "POST",
					 url: '<?php echo base_url();?>employee/ajax_fdelete',
					 data: {id:id},
					 success: function(response){
						 //alert(response);
					 }
				});
		});
    });
    </script>
    </div>
    </div>
    <div id="menu1" class="tab-pane fade">
    	<?php if(empty($history)){?>
        <div class="alert alert-danger"><h3>No Previous History.</h3></div>
        <?php }else{?>
        <table class="table table-sm table-bordered">
        	<thead><tr><th>S.No.</th><th>Remark</th><th>Next Date/Remark</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
            	<?php $i=1;foreach($history as $h){?>
                <tr><td><?php echo $i;?></td>
                	<td><?php echo $h->lremark;?><br/>
                    <label class="badge badge-warning"><?php echo $h->action_date;?></label></td>
                	<td><?php echo $h->next_remark;?><br/>
                    <label class="badge badge-warning"><?php echo $h->next_date;?></label></td>
                    <td><?php echo $h->f_status;?></td>
                    <td><a href="#" id="<?php echo $h->foid;?>" class="btn btn-sm btn-danger fdelete"><i class="fa fa-trash-o"></i></a></td></tr>
                <?php $i++;}?>
            </tbody>
        </table>	<?php }?>
    </div>
</div>