       <!-- Datatable Dependency start -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>

    <div class="content-wrapper">
			<section class="content-header">
				<h5>Actioned Leads<?php //if($this->uri->segment(3)==""){echo 'New Pending Leads';}else{echo 'Leads Under Followups';}?></h5>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">List Leads Report</li>
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
                        <table class="table table-sm table-striped table-bordered" style="width:100%" id="example">
                            <thead>
                            <tr bgcolor="#FFCC00"><th>S.No.</th><th>Lead ID</th><th>Client</th><th>Contact</th><th>Employee</th><th>Status</th><th>Remark</th><th>Action</th></tr></thead>
                            <tbody id="leads_list">
                            <?php if(empty($leads)){
?><tr><th colspan="7"><h3 class="text-danger text-center" style="padding:50px;">No Records Found</h3></th></tr><?php 
}else{$i=1;foreach($leads as $l){?>
<tr><td><?php echo $i;?></td>
    <td><?php echo "LD".$l->lead_id.'/'.date("d M'Y",strtotime($l->last_update));?></td>
      <td> <?php echo $l->contact_person;?></td><td><?php echo $l->contact_phone1.' '.$l->contact_phone2;?></td>
    <td><?php echo $l->firstname.' '.$l->lastname;?></td>
  
    <td><?php echo $l->lead_status;?></td><td><?php echo $l->lead_remark;?></td>
    <td></td>
    <!--<a href="#" id="<?php //echo $l->lead_id;?>" class="btn btn-sm btn-success lead_details"  data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i> Follow</a>                      
    <a href="<?php //echo base_url().'admin/add_lead/'.$l->lead_id;?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
    <a href="#" id="<?php //echo $l->lead_id;?>" class="btn btn-sm btn-danger del_lead"><i class="fa fa-trash-o"></i></a>-->
</tr>
<?php $i++;}?>
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
    <script>
	$(document).ready(function(){
		$('#example').DataTable({

                dom: 'Bfrtip',
                responsive: true,
                pageLength: 25,
                // lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],

                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]

            });
	});
	</script>
	<!-- Popper.JS -->
	<!-- Theme JS -->
	
    
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/datatables.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/dataTables.buttons.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/jszip.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/pdfmake.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/vfs_fonts.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/buttons.html5.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/buttons.print.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/tables/datatable.js"></script>
	<!-- Theme JS -->
	<script src="<?php echo base_url();?>adminassets/assets/js/nanoscroller/nanoscroller.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/custom/theme.js"></script>
</body>
</html>