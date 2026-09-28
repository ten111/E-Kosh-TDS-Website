    <!--<style>
	.form-inline label{ display:inline;}
	</style>-->
    <div class="content-wrapper">
			<section class="content-header">
				<h5>New To be Created Contracts/Leads List</h5>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">New To be Created Contracts/Leads List</li>
				</ol>
			</section>
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
                <div class="col-md-12">
                <button type="button" id="new_contract" data-toggle="modal" data-target="#myModal" class="btn btn-warning pull-right lead_details">New Contract</button>
				<?php if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
                    <div class="panel panel-primary cardbg">
                        <div class="panel-body">
                        
                        <table class="table table-sm table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr bgcolor="#FFCC00"><th>S.No.</th><th>Company/Business</th><th>BusinessType</th><th>Lead Source/Date</th><th>Contact Details</th>
                                   	   <th>Action</th><th>Remark</th></tr></thead>
                                   <tbody>
                                       <?php if(empty($leads)){
?><tr><th colspan="7"><h3 class="text-danger text-center" style="padding:50px;">No Records Found</h3></th></tr><?php 
}else{$i=1;foreach($leads as $l){?>
<tr><td><?php echo $i;?></td>
    <td><b class="text-danger"><?php echo $l->company;?></b><br/>
    <?php echo $l->address.'<br/>'.$l->city.' '.$l->state.' '.$l->pincode;?><br/>
    <label class="badge badge-dark">LeadID - <?php echo "LD".$l->lead_id;?></label></td>
    <td><?php echo $l->bs_title;?><br/>
    <label class="badge badge-success"><?php echo $l->bs_type;?></label></td>
    <td><?php echo $l->lead_src;?><br/>
	<label class="badge badge-warning"><?php echo date("d M'Y",strtotime($l->lead_date));?></label></td>
    <td><i class="fa fa-user"></i> <?php echo $l->contact_person;?><br/>
        <i class="fa fa-envelope"></i> <?php echo $l->email;?><br/>
        <i class="fa fa-phone"></i> <?php echo $l->contact_phone1;?> <?php echo $l->contact_phone2;?></td>
    <td><?php echo $l->lead_remark;?></td>
    <td>
    <a href="#" id="<?php echo $l->lead_id;?>" class="btn btn-sm btn-warning lead_details"  data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i> Create Contract</a>                      
    <!--<a href="<?php //echo base_url().'admin/add_lead/'.$l->lead_id;?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
    <a href="#" id="<?php //echo $l->lead_id;?>" class="btn btn-sm btn-danger del_lead"><i class="fa fa-trash-o"></i></a>--></td>
</tr>
<?php $i++;}?>

<?php }?>
                                   </tbody>
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
                <h5 class="modal-title">New Contract Creation <b id="leadid"></b></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" id="lead_details">
                <p><i class="fa fa-spin fa-spinner"></i> Loading Lead/Contract Details...</p>
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
			<p class="mb-0">Copyright © 2019 <a target="_blank" href="#">Admin</a>. All rights reserved.</p>
		</footer>
		<!-- Footer Section Ends -->
			
	</div>

	<!-- jQuery CDN - Slim version (=without AJAX) -->
	<script src="<?php echo base_url();?>adminassets/assets/js/jquery/slim.min.js"></script>
    <script>
	$(document).ready(function(){
		$(".lead_details").click(function(){
			var id=$(this).attr("id");
			$("#leadid").text("LD-"+id);
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>employee/clead_details',
				 data: {id:id},
				 success: function(res){
					$("#lead_details").html(res);
				 }
			});
		});
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