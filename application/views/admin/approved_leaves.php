 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
   <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Dashboard
</h2>
                    </div>  
                </div>
            </div>
           
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header"> Listed All Applied(Pending) Leaves</div>
                        <div class="body">
<table class="table table-condensed table-striped table-bordered">
                                <thead><tr><th>S.No.</th><th>Apply Date</th><th>Emp Name/ID</th><th>Leave Date</th>
                                       <th>Days</th><th>Leave Type</th><th>Remarks</th><th>Action</th></tr></thead>
                                <tbody>
                                    <?php $i=1;foreach($leaves as $l){?>
                <tr><td><?php echo $i;?></td>
                    <td><?php echo date("d M'Y",strtotime($l->applied_date));?></td>
                    <td><?php echo $l->firstname.' '.$l->lastname;?></td>
                    <td><?php echo date("d M'Y",strtotime($l->l_from)).'<br/>'.date("d M'Y",strtotime($l->l_to));?></td>
                    <td><?php echo $l->total_days;?></td>
                    <td><?php echo $l->leave_type;?></td><td><?php echo $l->l_remarks;?></td>
                    <td><a href="#" class="btn btn-danger btn-sm del_leave" id="<?php echo $l->laid;?>"><i class="fa fa-trash-o"></i></a>
                    <a href="#" class="btn btn-sm btn-success leave_status" id="<?php echo $l->laid.'-'.$l->emp_id;?>"  data-toggle="modal" data-target="#status_modal"><i class="fa fa-eye"></i></a></td>
                </tr>
                                    <?php $i++;}?>
                                </tbody>
                            </table>   
                        <div id="status_modal" class="modal fade" role="dialog" style="margin-top:80px;">
                          <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Update Leave Status</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body status_modal row">
                                <p>Loading Leave Details..</p>
                              </div>
                            </div>
                        
                          </div>
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
<script>
$(document).ready(function(){
	$(".leave_status").click(function(){
			var id=$(this).attr('id');
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/leave_status',
				 data: {id:id},
				 success: function(res){
					$(".status_modal").html(res);
				 }
			});
		});
		$(".del_leave").click(function(e){e.preventDefault();
			if(!confirm("Sure you want to delete?")){
			  return false;
			}
			var id=$(this).attr("id");$(this).closest("tr").remove();
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/ajax_leave_ap_delete',
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


