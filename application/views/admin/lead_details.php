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
        <tr><td>Client Name</td><td><?php echo $lead->contact_person;?></td></tr>
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
    }else{
    $pro_type="";
    $next_date="";
    $lremark="";
    $next_remark="";
    $f_status="";
    }
    ?>
    <div class="col-md-6" style="display:none;">
        <form action="" method="post" id="lead_update">
            <input type="hidden" name="lead_id" value="<?php echo $lead->lead_id;?>" />
            <div class="form-group">
                <label>Product/Service</label>
                <select class="form-control" name="pro_type" required>
                    <option value="">Select Type</option>
                    <option value="Product" <?php if($pro_type=="Product"){echo "selected";}?>>Product</option>
                    <option value="Service" <?php if($pro_type=="Service"){echo "selected";}?>>Service</option>
                </select>
            </div>
            <div class="form-group">
                <label>Select Status</label>
                <select class="form-control" name="f_status" required>
                    <option value="">Select Type</option>
                    <option value="Status A"  <?php if($f_status=="Status A"){echo "selected";}?>>Status A</option>
                    <option value="Status B"  <?php if($f_status=="Status B"){echo "selected";}?>>Status B</option>
                </select>
            </div>
            <div class="form-group">
                <label>Description/Remark</label>
                <textarea class="form-control" placeholder="Short Remark" rows="2"  name="lremark"><?php echo $lremark;?></textarea>
            </div>
            <div class="form-group">
                <label>Next/Close Followup Date</label>
                <input type="date" class="form-control" name="next_date" value="<?php echo $next_date;?>" required />
            </div>
            <div class="form-group">
                <label>Next Followup Description/Remark</label>
                <textarea class="form-control" placeholder="Short Remark" rows="2"  name="next_remark"><?php echo $next_remark;?></textarea>
            </div>
            <div class="res_msg"></div>
            <button type="submit" class="btn btn-success">Add</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </form>
    </div>
    <script>
    $(document).ready(function(){
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
                 url: '<?php echo base_url();?>admin/ajax_lead_update',
                 data: {formdata:formdata},
                 success: function(res){
                     $(".res_msg").html(res);
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
					 url: '<?php echo base_url();?>admin/ajax_fdelete',
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
        </table>	
    </div>
</div>