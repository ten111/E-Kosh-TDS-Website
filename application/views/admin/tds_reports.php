
<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 text-danger">TDS REPORT <?php echo str_replace("_","-",$this->uri->segment(3));?></h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">
                            <?php if($this->uri->segment(4)){?>
     <a target="_blank" href="<?php echo base_url().'admin/export_itr/'.$this->uri->segment(3).'/'.$this->uri->segment(4);?>" class="btn-sm btn btn-info pull-right">Download TDS Report<i class="fa fa-download"></i></a>
                            <?php }else{?>
     <a target="_blank" href="<?php echo base_url().'admin/export_itr/'.$this->uri->segment(3).'?from='.$_GET['from'].'&to='.$_GET['to'];?>" class="btn-sm btn btn-info pull-right">Download TDS Report<i class="fa fa-download"></i></a>
                            <?php }?>
                    </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <style>
        .table-container {
            width: 100%;
            max-height: 700px; /* Adjust based on your needs */
            overflow: auto;
            position: relative;
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        th, td {
            white-space: nowrap;
            padding: 8px 16px;
        }

        /* Fix header */
        thead th {
            position: sticky;
            top: 0;
            background:rgb(250, 250, 248);
            z-index: 3;
        }
        .first_row th {
            position: sticky;
            top: 0;
            background: #f8f9fa;
            z-index: 3;
        }

        /* Fix the first 4 columns */
        th:nth-child(-n+3),
        td:nth-child(-n+3) {
            position: sticky;
            left: 0;
            background: white;
            z-index: 2;
        }

        /* Fix first 4 header columns above other elements */
        thead th:nth-child(-n+3) {
            z-index: 4;
        }
       
        /* Adjust the left positioning for each fixed column */
        th:nth-child(1), td:nth-child(1) { left: 0; }
        th:nth-child(2), td:nth-child(2) { left: 40px; }
        th:nth-child(3), td:nth-child(3) { left: 120px; }
    </style>
        <div class="row">    
            <div class="col-lg-12">
                <div class="card">
<div class="card-header">
    
<form class="form-inline" action="<?php echo base_url().'admin/tds_reports/'.$this->uri->segment(3);?>" method="get">
    
    <div class="row">
        <div class="col-md-7">
    <div class="btn-group" role="group">
    <a href="<?php echo base_url().'admin/tds_reports/'.$this->uri->segment(3).'/1';?>" class="btn btn-md btn-<?php if($this->uri->segment(4)==1){echo "primary";}else{echo "secondary";}?>">Q1</a>
    <a href="<?php echo base_url().'admin/tds_reports/'.$this->uri->segment(3).'/2';?>"  class="btn btn-md btn-<?php if($this->uri->segment(4)==2){echo "primary";}else{echo "secondary";}?>">Q2</a>
    <a href="<?php echo base_url().'admin/tds_reports/'.$this->uri->segment(3).'/3';?>"  class="btn btn-md btn-<?php if($this->uri->segment(4)==3){echo "primary";}else{echo "secondary";}?>">Q3</a>
    <a href="<?php echo base_url().'admin/tds_reports/'.$this->uri->segment(3).'/4';?>"  class="btn btn-md btn-<?php if($this->uri->segment(4)==4){echo "primary";}else{echo "secondary";}?>">Q4</a>
    </div>
    </div>
<div class="form-group col-md-2">
<select class="form-control" name="from" required>
<option value="">From</option>
<option value="2025-03-01" <?php if($_GET['from']=='2025-03-01'){echo "selected";}?>>March</option>
<option value="2025-04-01" <?php if($_GET['from']=='2025-04-01'){echo "selected";}?>>April</option>
<option value="2025-05-01" <?php if($_GET['from']=='2025-05-01'){echo "selected";}?>>May</option>
<option value="2025-06-01" <?php if($_GET['from']=='2025-06-01'){echo "selected";}?>>June</option>
<option value="2025-07-01" <?php if($_GET['from']=='2025-07-01'){echo "selected";}?>>July</option>
<option value="2025-08-01" <?php if($_GET['from']=='2025-08-01'){echo "selected";}?>>August</option>
<option value="2025-09-01" <?php if($_GET['from']=='2025-09-01'){echo "selected";}?>>September</option>
<option value="2025-10-01" <?php if($_GET['from']=='2025-10-01'){echo "selected";}?>>October</option>
<option value="2025-11-01" <?php if($_GET['from']=='2025-11-01'){echo "selected";}?>>November</option>
<option value="2025-12-01" <?php if($_GET['from']=='2025-12-01'){echo "selected";}?>>December</option>
<option value="2026-01-01" <?php if($_GET['from']=='2026-01-01'){echo "selected";}?>>January</option>
<option value="2026-02-01" <?php if($_GET['from']=='2026-02-01'){echo "selected";}?>>February</option>
    </select>
    </div>

    <div class="form-group col-md-2">
<select class="form-control" name="to" required>
<option value="">To</option>
<option value="2025-03-01" <?php if($_GET['to']=='2025-03-01'){echo "selected";}?>>March</option>
<option value="2025-04-01" <?php if($_GET['to']=='2025-04-01'){echo "selected";}?>>April</option>
<option value="2025-05-01" <?php if($_GET['to']=='2025-05-01'){echo "selected";}?>>May</option>
<option value="2025-06-01" <?php if($_GET['to']=='2025-06-01'){echo "selected";}?>>June</option>
<option value="2025-07-01" <?php if($_GET['to']=='2025-07-01'){echo "selected";}?>>July</option>
<option value="2025-08-01" <?php if($_GET['to']=='2025-08-01'){echo "selected";}?>>August</option>
<option value="2025-09-01" <?php if($_GET['to']=='2025-09-01'){echo "selected";}?>>September</option>
<option value="2025-10-01" <?php if($_GET['to']=='2025-10-01'){echo "selected";}?>>October</option>
<option value="2025-11-01" <?php if($_GET['to']=='2025-11-01'){echo "selected";}?>>November</option>
<option value="2025-12-01" <?php if($_GET['to']=='2025-12-01'){echo "selected";}?>>December</option>
<option value="2026-01-01" <?php if($_GET['to']=='2026-01-01'){echo "selected";}?>>January</option>
<option value="2026-02-01" <?php if($_GET['to']=='2026-02-01'){echo "selected";}?>>February</option>
    </select>
    </div>
    <div class="col-md-1">
        <button type="submit" class="btn btn-danger">FILTER</button>
    </div>
    
    </form>

</div>

<hr/>

                        <select class="form-control float-end" style="width:200px;" id="change_year">
                            <option value="">Select</option>
<?php $this->db->select("*");
		$this->db->from("emp_data");
		$this->db->group_by("emp_data.dt_fnyr");
		$this->db->where("emp_data.dt_client",$this->session->userdata("userid"));
		///$this->db->order_by("emp_data.dt_month2","asc");
		$yrs=$this->db->get()->result();foreach($yrs as $yr){?>
        <option value="<?php echo $yr->dt_fnyr;?>" <?php if($yr->dt_fnyr==$this->uri->segment(3)){echo "selected";}?>>Financial Year <?php echo $yr->dt_fnyr;?></option><?php }?>
</select>


<input type="text" style="width:300px;" placeholder="Search Name/Code/Mobile" id="search_name" class="form-control"/>
                    </div><!-- end card header -->
                    <div class="card-body">
					<div class="table-responsive table-bordered table-container">
                        <table class="table table-bordered">
                           <thead>
                            <tr bgcolor="#FFCC00">
                            <th>S.No.</th>
        <th>Employee Code</th>
        <th>Employee Name</th>
        <th>PAN Number</th>
        <th>Designation</th>
        <th>Credit Type</th>
        <?php  foreach($months as $mon){echo '<th colspan="2" align="center">'.$mon->dt_month.'</th>';}?><th colspan="2">Total</th>
                            </tr></thead>
                            <tr class="first_row">
                            <th colspan="6"></th>
        <?php  foreach($months as $mon){echo '<th bgcolor="orange">Credit Amount</th><th>Tax</th>';}?><th bgcolor="orange">Total</th><th>Total Tax</th>
                            </tr>
                                   <tbody id="leads_list">
                                       <tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>
                                   </tbody>
                        </table>
                        <!-- <button id="prev" class="btn btn-sm btn-danger">Previous</button> -->
                        <button id="next" class="btn btn-dark">Load More</button>
                    </div>



                        <div id="emp_data_box" class="modal fade" role="dialog">

      <div class="modal-dialog modal-sm">

        <div class="modal-content">

        <div class="modal-header">
                                                            <h5 class="modal-title">DATA DETAILS</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

          <div class="modal-body emp_data_box">
          <tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>

          	

          </div>

         

        </div>

      </div>

        </div>



        <div id="load_itr_box" class="modal fade" role="dialog">

<div class="modal-dialog modal-lg">

  <div class="modal-content">

  <div class="modal-header">
                                                      <h5 class="modal-title">DATA DETAILS</h5>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>

    <div class="modal-body itr_box">
    <tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>

        

    </div>

   

  </div>

</div>

  </div>
                    </div>
                    
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

       

        

        

        
        

        <!--end row-->

    </div> <!-- container-fluid -->
</div><!-- End Page-content -->

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © EKosh TDS.
            </div>
        </div>
    </div>
</footer>
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->




<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
<i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!--preloader-->
<div id="preloader">
<div id="status">
<div class="spinner-border text-primary avatar-sm" role="status">
    <span class="visually-hidden">Loading...</span>
</div>
</div>
</div>


</div>
<script>
	$(document).ready(function(){
        <?php if($this->uri->segment(4)){?>
        let qtr=<?php echo $this->uri->segment(4);?>;
        let typ="q";
        <?php }else{?>
        let qtr='<?php echo $_GET['from'].'|'.$_GET['to'];?>';
        let typ="f";
        <?php }?>
        let count = 0;
            
            $("#next").click(function() {
               // $("#leads_list").html('<tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>');
                count += 10;
                $("#value").text(count);
                $.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_emp_tds_report',
			 data: {limit:count,qtr:qtr,yr:'<?php echo $this->uri->segment(3);?>',typ:typ},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#leads_list:last").append(res);
			 }
		 });
            });
            
            $("#prev").click(function() {
                $("#leads_list").html('<tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>');
                count -= 10;
                $("#value").text(count);
                $.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_emp_tds_report',
			 data: {limit:count,qtr:qtr,yr:'<?php echo $this->uri->segment(3);?>',typ:typ},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#leads_list").html(res);
			 }
		 });
            });
    $("#change_year").change(function(){
        var yr=$(this).val();
        window.location.href="<?php echo base_url().'admin/salary/';?>"+yr+'/salary';
        return false;
        
   $("#leads_list").html('<tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>');
        
        $.ajax({

type: "POST",

url: '<?php echo base_url();?>admin/ajax_emp_tds_report',
data: {limit:0,yr:yr,qtr:qtr,typ:typ},

success: function(response){

   $("#leads_list").html(response);

}

});
});


$("#search_name").keyup(function(){
            
   $("#leads_list").html('<tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>');

var name=$(this).val();

if(name.length>=3){

$.ajax({

     type: "POST",

     url: '<?php echo base_url();?>admin/ajax_emp_tds_report',

     data: {limit:0,name:name,qtr:qtr,yr:'<?php echo $this->uri->segment(3);?>',typ:typ},

     success: function(response){

        $("#leads_list").html(response);

     }

 });

}else{
    $.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_emp_tds_report',
			 data: {limit:0,qtr:qtr,yr:'<?php echo $this->uri->segment(3);?>',typ:typ},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#leads_list").html(res);
			 }
		 });
}

});
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_emp_tds_report',
			 data: {limit:0,qtr:qtr,yr:'<?php echo $this->uri->segment(3);?>',typ:typ},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#leads_list").html(res);
			 }
		 });
		$("#showdata").change(function(){
			var id=$(this).val();
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/ajax_emp_tds_report',
				 data: {limit:0,qtr:qtr,yr:'<?php echo $this->uri->segment(3);?>',typ:typ},
				 success: function(res){//alert(res);
					// alert("OTP Sent Again");
					$("#leads_list").html(res);
				 }
			 });
		});
		
	});
	</script>
<script src="<?php echo base_url();?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/feather-icons/feather.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins.js"></script>

<!-- prismjs plugin -->
<script src="<?php echo base_url();?>assets/libs/prismjs/prism.js"></script>

<script src="<?php echo base_url();?>assets/js/app.js"></script>

</body>


</html>






































