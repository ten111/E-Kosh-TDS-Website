    <!--<style>
	.form-inline label{ display:inline;}
	</style>-->
    <div class="content-wrapper">
			<section class="content-header">
				<h5>Actioned Leads<?php //if($this->uri->segment(3)==""){echo 'New Pending Leads';}else{echo 'Leads Under Followups';}?></h5>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">List Leads</li>
				</ol>
			</section>
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
                <div class="col-md-12"><?php if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
                    <div class="panel panel-primary cardbg">
                        <div class="panel-body">
                       <!-- <div class="btn-group pull-right">
                          <button type="button" class="btn btn-danger show_more_leads" id="past_leads">All Past Leads</button>
                          <button type="button" class="btn btn-warning show_more_leads" id="all_leads">All Upcoming Leads</button>
                        </div>
                          <button type="button" id="all_leads" class="btn btn-success pull-right">View All Upcoming Leads</button>-->
                        <?php if($this->uri->segment(3)){?>
                        <form class="form-inline" action="" id="date_filter">
                          <div class="form-group">
                            <input type="date" name="date" class="form-control" id="date">
                          </div>
                          <button type="submit" class="btn btn-success">Filter</button>
                        </form>
						<?php }?>
                        <table class="table table-sm table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr bgcolor="#FFCC00"><th>S.No.</th><th>Lead ID</th><th>Lead Source/Date</th><th>Contact Details</th><th>Status/Remark</th><th>Action</th></tr></thead>
                            <tbody id="leads_list">
                            <?php if(empty($leads)){
?><tr><th colspan="7"><h3 class="text-danger text-center" style="padding:50px;">No Records Found</h3></th></tr><?php 
}else{$i=1;foreach($leads as $l){?>
<tr><td><?php echo $i;?></td>
    <td>
    <label class="badge badge-dark"><?php echo "LD".$l->lead_id;?></label></td>
    
    <td><?php echo $l->lead_src;?><br/>
	<label class="badge badge-warning"><?php echo date("d M'Y",strtotime($l->lead_date));?></label></td>
    <td><i class="fa fa-user"></i> <?php echo $l->contact_person;?><br/>
        <i class="fa fa-phone"></i> <?php echo $l->contact_phone1;?> <?php echo $l->contact_phone2;?></td>
    <td>
    <label class="badge badge-dark"><?php echo $l->lead_status;?></label><br/>
	<?php echo $l->lead_remark;?></td>
    <td>
    <a href="#" id="<?php echo $l->lead_id;?>" class="btn btn-sm btn-success lead_details"  data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i> Follow</a>                      
    <!--<a href="<?php //echo base_url().'admin/add_lead/'.$l->lead_id;?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
    <a href="#" id="<?php //echo $l->lead_id;?>" class="btn btn-sm btn-danger del_lead"><i class="fa fa-trash-o"></i></a>--></td>
</tr>
<?php $i++;}?>
<script>
$(document).ready(function(){
$(".lead_details").click(function(){
			var id=$(this).attr("id");
			$("#leadid").text("LD-"+id);
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>employee/lead_details',
				 data: {id:id},
				 success: function(res){
					$("#lead_details").html(res);
				 }
			});
		});
		$(".del_lead").click(function(e){e.preventDefault();
		if (!confirm("Sure you want to delete?")){
				  return false;
				}
			var id=$(this).attr("id");$(this).closest("tr").remove();
			$.ajax({
							 type: "POST",
							 url: '<?php echo base_url();?>employee/ajax_del_lead',
							 data: {id:id},
							 success: function(response){
								 //alert(response);
							 }
							 });
		});
});
$("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});

</script>
<?php }?></tbody>
                        </table>
                        </div>
                    </div>
                </div>
                
            </div>
			</section>
		</div>
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header" style="background:#FC0;">
                <h5 class="modal-title">Lead Followup <b id="leadid"></b></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" id="lead_details">
                <p><i class="fa fa-spin fa-spinner"></i> Loading Lead Details...</p>
              </div>
            </div>
        
          </div>
        </div>
		<!-- Page Content Ends-->
		
		<!-- Back to Top Starts -->
		<a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
		<!-- Back to Top Ends -->
		
		<!-- Footer Section Starts -->
		<footer class="main-footer">
			<div class="pull-right hidden-xs">Version 1.0.0</div>
			<p class="mb-0">Copyright © 2024 <a target="_blank" href="#">Admin</a>. All rights reserved.</p>
		</footer>
		<!-- Footer Section Ends -->
			
	</div>

	<!-- jQuery CDN - Slim version (=without AJAX) -->
	<script src="<?php echo base_url();?>adminassets/assets/js/jquery/slim.min.js"></script>
    <script>
	$(document).ready(function(){
		
	});
	</script>
	<!-- Popper.JS -->
	<script src="<?php echo base_url();?>adminassets/assets/js/jquery/popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="<?php echo base_url();?>adminassets/assets/js/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/bootstrap/bootstrap.min.js"></script>
	<!-- Theme JS -->
    
	<script src="<?php echo base_url();?>adminassets/assets/js/nanoscroller/nanoscroller.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/custom/theme.js"></script>
</body>
</html>