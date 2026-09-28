<style>.active_month{background:#FFF;color:#06F;}</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
   <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Manage Holidays</h2>
                    </div>  
                </div>
            </div>
           
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="card">
                        <div class="header">Add/Edit Holidays</div>
                        <div class="body">
                        <?php if(isset($_GET['hid'])){
						$edit=$this->db->get_where("holidays",array("hid"=>$_GET['hid']))->row();?>
                        <form class="form-inline" action="<?php echo base_url();?>admin/update_leave" method="post">
                            <input type="hidden" name="leave_id" value="<?php echo $edit->leave_id;?>" />
                              <div class="form-group "> 
                                <input type="text" required class="form-control" value="<?php echo $edit->leave_type;?>"  name="leave_type">
                              </div>
                              <div class="form-group "> 
                                <input type="number" required class="form-control" style="width:80px;" value="<?php echo $edit->max_days;?>"  name="max_days">
                              </div>
                              <button type="submit" class="btn btn-success">Update</button>
                            </form>
                        <?php }else{?>
                        <form  action="<?php echo base_url();?>admin/add_holiday" method="post">
                              <div class="form-group "> 
                                <input type="text" required placeholder="Title" class="form-control" name="htitle">
                              </div>
                              <div class="form-group "> 
                                <textarea rows="3" name="hdesc" required class="form-control"></textarea>
                              </div>
                              <div class="form-group">
                              	<label>Default</label>
                                <div class="input-group mb-3">                                        
                                    <input data-provide="datepicker" name="start" required data-date-autoclose="true" class="form-control">
                                </div>
                              </div>
                              <div class="form-group">
                              	<label>Default</label>
                                <div class="input-group mb-3">                                        
                                    <input data-provide="datepicker" required name="end" data-date-autoclose="true" class="form-control">
                                </div>
                              </div>
                              <button type="submit" class="btn btn-success">Add Holidays</button>
                            </form>
                        <?php }?><hr/>
                        
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="header">List Holidays</div>
                        <div class="body row">
                        	<div class="col-md-3">
                            <div class="btn-group-vertical">
                            <?php for($i=1;$i<=12;$i++){
								$monthName = date("F", mktime(0, 0, 0, $i, 10));
								$mm = date("M", mktime(0, 0, 0, $i, 10));?>
                              <button id="<?php echo $mm.date("-Y");?>" type="button"  class="btn btn-primary change_month <?php if(date("F")==$monthName){echo 'active_month';}?>"><?php echo $monthName;?></button>
                            <?php }?>
                            </div>
                            </div>
                            <div class="col-md-9">
                            <table class="table table-condensed table-striped table-bordered">
                            <thead><tr><th>S.No.</th><th>Dates</th><th>Title</th><th>Action</th></tr></thead>
                            <tbody id="holidays_list">
                            	<?php $cur=date("M-Y"); $hlist=$this->db->get_where("holidays",array("hmonth"=>$cur))->result();
								$i=1;foreach($hlist as $h){?>
                                <tr><td><?php echo $i;?></td>
                                	<td><?php echo date("D d M",strtotime($h->hfrom_date)).'-'.date("D d M",strtotime($h->hto_date));?></td>
                                    <td><?php echo $h->htitle;?></td>
                                    <td><a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a></td></tr>
                                <?php $i++;}?>
                            </tbody></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
</div>

<!-- Javascript -->
<script src="<?php echo base_url();?>assets/bundles/libscripts.bundle.js"></script>

<script src="<?php echo base_url();?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script>
$(document).ready(function(){
	$(".change_month").click(function(){
		$('.change_month').removeClass("active_month");
		$(this).addClass("active_month");
		//alert("sadf");
		var id=$(this).attr("id");
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/change_month',
			 data: {id:id},
			 success: function(res){
				// alert(res);
				 $("#holidays_list").html(res);
			 }
		});
	});
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


