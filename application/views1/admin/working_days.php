 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
   <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Manage Working Days</h2>
                    </div>  
                </div>
            </div>
           
            <div class="row clearfix">
                <div class="col-md-3">
                    <div class="card">
                        <div class="header">Update Working Days</div>
                        <div class="body">
                        <form action="<?php echo base_url();?>admin/update_workdays" method="post">
            <div class="fancy-checkbox" style="margin-bottom:5px;">
                <label><input type="checkbox" name="sunday" value="yes" <?php if($admin->sunday!=""){echo "checked";}?>><span>Sunday</span></label>
            </div>
            <div class="fancy-checkbox" style="margin-bottom:5px;">
                <label><input type="checkbox" name="monday" value="yes" <?php if($admin->monday!=""){echo "checked";}?>><span>Monday</span></label>
            </div>
            <div class="fancy-checkbox" style="margin-bottom:5px;">
                <label><input type="checkbox" name="tuesday" value="yes" <?php if($admin->tuesday!=""){echo "checked";}?>><span>Tuesday</span></label>
            </div>
            <div class="fancy-checkbox" style="margin-bottom:5px;">
                <label><input type="checkbox" name="wednesday" value="yes" <?php if($admin->wednesday!=""){echo "checked";}?>><span>Wednesday</span></label>
            </div>
            <div class="fancy-checkbox" style="margin-bottom:5px;">
                <label><input type="checkbox" name="thursday" value="yes" <?php if($admin->thursday!=""){echo "checked";}?>><span>Thursday</span></label>
            </div>
            <div class="fancy-checkbox" style="margin-bottom:5px;">
                <label><input type="checkbox" name="friday" value="yes" <?php if($admin->friday!=""){echo "checked";}?>><span>Friday</span></label>
            </div>
            <div class="fancy-checkbox" style="margin-bottom:5px;">
                <label><input type="checkbox" name="saturday" value="yes" <?php if($admin->saturday!=""){echo "checked";}?>><span>Saturday</span></label>
            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form><hr/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="header">Set Financial Year</div>
                        <div class="body">
                        <form action="<?php echo base_url();?>admin/fin_yr" method="post">
            				<div class="form-group">
                            	<label>Start Date</label>
                                <input type="date" name="fin_yr_start" class="form-control" required value="<?php echo $admin->fin_yr_start;?>" />
                            </div>
                            <div class="form-group">
                            	<label>End Date</label>
                                <input type="date" name="fin_yr_end" class="form-control"  required value="<?php echo $admin->fin_yr_end;?>" />
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form><hr/>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
</div>

<!-- Javascript -->
<script src="<?php echo base_url();?>assets/bundles/libscripts.bundle.js"></script>
<script>
$(document).ready(function(){
	$(".leaves_delete").click(function(e){e.preventDefault();
	if(!confirm("Sure you want to delete?")){
		  return false;
		}
		var id=$(this).attr("id");$(this).closest("tr").remove();
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_leaves_delete',
			 data: {id:id},
			 success: function(response){
				 //alert(response);
			 }
		});
	});
});
</script>    
<script src="<?php echo base_url();?>assets/bundles/vendorscripts.bundle.js"></script>
    
<script src="<?php echo base_url();?>assets/bundles/mainscripts.bundle.js"></script>
</body>
</html>


