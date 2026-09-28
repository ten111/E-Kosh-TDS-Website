    <!--<style>
	.form-inline label{ display:inline;}
	</style>-->
    <div class="content-wrapper">
			<section class="content-header">
				<h5> Clients List</h5>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active"> Clients List</li>
				</ol>
			</section>
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
                <div class="col-md-12">
                <!--<button type="button" id="new_contract" data-toggle="modal" data-target="#myModal" class="btn btn-warning pull-right lead_details2">New Contract</button>-->
				<?php if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
                    <div class="panel panel-primary cardbg">
                        <div class="panel-body">
                        
                        <table class="table table-sm table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr bgcolor="#FFCC00"><th>S.No.</th><th>Lead Source/Date</th><th>Contact Details</th>
                                   	   <th>Remark</th><th>Action</th></tr></thead>
                                   <tbody>
                                       <?php if(empty($contracts)){
?><tr><th colspan="7"><h3 class="text-danger text-center" style="padding:50px;">No Records Found</h3></th></tr><?php 
}else{$i=1;foreach($contracts as $l){?>
<tr><td><?php echo $i;?></td>
    <td><?php echo $l->lead_src;?><br/>
	<label class="badge badge-warning"><?php echo date("d M'Y",strtotime($l->lead_date));?></label></td>
    <td><i class="fa fa-user"></i> <?php echo $l->contact_person;?><br/>
        <i class="fa fa-envelope"></i> <?php echo $l->email;?><br/>
        <i class="fa fa-phone"></i> <?php echo $l->contact_phone1;?> <?php echo $l->contact_phone2;?></td>
    <td><?php echo $l->lead_remark;?></td>
    <td>
    <a href="#" id="<?php echo $l->lead_id;?>" class="btn btn-sm btn-success payment_history" data-toggle="modal" data-target="#myModal2"><i class="fa fa-inr"></i> Payment</a>
    <a href="#" id="<?php echo $l->lead_id;?>" class="btn btn-sm btn-warning lead_details"  data-toggle="modal" data-target="#myModal"><i class="fa fa-edit"></i></a>                      
    <a href="#" id="<?php echo $l->lead_id;?>" class="btn btn-sm btn-danger contract_delete"><i class="fa fa-trash-o"></i></a></td>
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
        <div id="myModal2" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header" style="background:#FC0;">
                <h5 class="modal-title">Payment History</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" id="payment_history">
                <p><i class="fa fa-spin fa-spinner"></i> Loading Payment History...</p>
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
			<p class="mb-0">Copyright © 2024<a target="_blank" href="#">Admin</a>. All rights reserved.</p>
		</footer>
		<!-- Footer Section Ends -->
			
	</div>

	<!-- jQuery CDN - Slim version (=without AJAX) -->
	<script src="<?php echo base_url();?>adminassets/assets/js/jquery/slim.min.js"></script>
    <script>
	$(document).ready(function(){
		$(".payment_history").click(function(){
			var id=$(this).attr("id");
			//alert(id);
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>employee/contract_payment_history',
				 data: {id:id},
				 success: function(res){
					$("#payment_history").html(res);
				 }
			});
		});
		$(".lead_details2").click(function(){
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
		$(".lead_details").click(function(){
			var id=$(this).attr("id");
			$("#leadid").text("LD-"+id);
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>employee/clead_details_edit',
				 data: {id:id},
				 success: function(res){
					$("#lead_details").html(res);
				 }
			});
		});
		
		$(".contract_delete").click(function(e){e.preventDefault();
		if(!confirm("Sure you want to delete?")){
			  return false;
			}
			var id=$(this).attr("id");$(this).closest("tr").remove();
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>employee/contract_delete',
				 data: {id:id},
				 success: function(response){
					 //alert(response);
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