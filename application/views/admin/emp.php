<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"><?php echo $emp->emp_name.' '.$emp->emp_code;?></h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>
                            <li class="breadcrumb-item active">Employee Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <style>
        .table-container {
            width: 100%;
            max-height: 900px; /* Adjust based on your needs */
            overflow: auto;
            position: relative;
        }

        .table-container {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        th, td {
            white-space: nowrap;
            padding: 8px 16px;
            border: 1px solid #ddd;
        }

        /* Fix header */
        thead th {
            position: sticky;
            top: 0;
            background: #f8f9fa;
            z-index: 3;
        }

        /* Fix the first 4 columns */
        th:nth-child(-n+2),
        td:nth-child(-n+2) {
            position: sticky;
            left: 0;
            background: white;
            z-index: 2;
            border-right: 2px solid #ddd;
        }

        /* Fix first 4 header columns above other elements */
        thead th:nth-child(-n+3) {
            z-index: 4;
        }

        /* Adjust the left positioning for each fixed column */
        th:nth-child(1), td:nth-child(1) { left: 0; }
        th:nth-child(2), td:nth-child(2) { left: 30px; }
    </style>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <a href="#" id="<?php echo $emp->emp_id;?>" class="btn float-end btn-sm btn-danger comp_delete"><i class="bi bi-archive"></i></a>
                        <h4 class="card-title mb-0">Profile Details</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                    <table class="table align-middle  table-bordered">
                    <tr><th>Phone</th><td><?php echo $emp->emp_mob;?></td></tr>
<tr><th>PAN</th><td><?php echo $emp->emp_pan;?></td></tr>
<tr><th>Office</th><td><?php echo $emp->emp_school;?></td></tr>
<tr><th>SubOffice</th><td><?php echo $emp->emp_sankul;?></td></tr>
<tr><th>Designation</th><td><?php echo $emp->emp_desg;?></td></tr>
</table>

<hr/>
<form action="" method="post" id="trns_form">
    <h4 class="text-danger">Transfer to New DDO</h4>
<div class="form-group">
<lable>Enter DDO Number</label>
<input type="hidden"  required name="emp_id" value="<?php echo $emp->emp_id;?>"/>
<input type="hidden"  required name="emp_code" value="<?php echo $emp->emp_code;?>"/>
<input type="number" class="form-control" id="ddo" required name="ddo"/>
<small class="text-success" id="ddo_name"></small>
    </div>
    <div class="form-group">
<lable>Remark</label>
<textarea name="emp_hrem" class="form-control" rows="4"></textarea>
    </div>
     <button type="submit" class="btn btn-danger btn-block">SUBMIT</button>
    </form>
                    </div>
                   
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                    <select class="form-control float-end" style="width:200px;" id="change_year">
<?php $this->db->select("*");
		$this->db->from("emp_data");
		$this->db->group_by("emp_data.dt_fnyr");
		$this->db->where("emp_data.dt_emp_id",$emp->emp_id);
		//$this->db->like("emp_data.dt_type_mon",$year);
		$yrs=$this->db->get()->result();
        foreach($yrs as $yr){?>
        <option value="<?php echo $yr->dt_fnyr;?>">FN YEAR <?php echo $yr->dt_fnyr;?></option><?php }?>
</select>
                    </div><!-- end card header -->
                    <div class="card-body">
                    <div class="table-responsive"><table class="table table-container table-bordered">
                            <thead>
                            <tr bgcolor="#FFCC00">
                            <th>SN</th>
                            <th>Month</th>
                            <th>DDO CODE</th>
                            <th>BILLNO</th>
        <th>BTRNO</th>
        <th>BASIC</th>
        <th>DA</th>
        <th>HOUSE RENT</th>
        <th>CITY COMPENSATORY</th>
        <th>WASHING ALLOWANCE</th>
        <th>MEDICAL ALLOWANCE</th>
        <th>FIX TA</th>
        <th>OTHER ALLOWANCE 1</th>
        <th>TOTAL DUES</th>
        <th>GPF SUBSCRIPTION</th>
        <th>GPF RECOVERY</th>
        <th>GIS</th>
        <th>FESTIVAL RECOVERY</th>
        <th>HOUSE RENT	</th>
        <th>WATER CHARGES	</th>
        <th>INCOME TAX</th>
        <th>TOTAL DEDUCTIONS</th>
        <th>NET SALARY</th>
        <th>Action</th>
                            </tr></thead>
                                   <tbody id="leads_list">
                                   <tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>
                                   </tbody>
                                   
                        </table>
                      
                      </div>
                       
                      <div id="emp_data_box" class="modal fade" role="dialog">

<div class="modal-dialog modal-md">

  <div class="modal-content">

  <div class="modal-header">
                                                      <h5 class="modal-title">DATA DETAILS</h5>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>

    <div class="modal-body" id="emp_data_div">

        

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
                <script>document.write(new Date().getFullYear())</script> © Ekosh TDS.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by Vibeapps
                </div>
            </div>
        </div>
    </div>
</footer>
</div>

</div>

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

<!-- JAVASCRIPT -->
<script>
	$(document).ready(function(){

        $("#ddo").keyup(function(){
            var code=$(this).val();
            if(code.length>3){
                $.ajax({
                  type: "POST",
                  url: '<?php echo base_url();?>admin/ajax_chk_ddo2',
                  data: {code:code},
                  success: function(res){
                            if(res!=0){
                                $("#ddo_name").text(res);            
                            }
                            else{
                                $("#ddo_name").text("Invalid DDO");
                            }
                      }
                });
            }
      });

        $("#trns_form").submit(function(e){e.preventDefault();
            var formdata=$(this).serialize();
            $.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_trns_form',
			 data: {formdata:formdata},
			 success: function(res){
                alert(res);
			 }
		 });
        });
        var id=$("#change_year").val();
        //alert(id);
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_emp_data',
			 data: {yr:id,emp:<?php echo $emp->emp_id;?>},
			 success: function(res){
               // alert(res);
				$("#leads_list").html(res);
			 }
		 });
		$("#change_year").change(function(){
			var id=$(this).val();
			$.ajax({
				 type: "POST",
				 url: '<?php //echo base_url();?>admin/ajax_emp_data',
				 data: {yr:id,emp:<?php echo $emp->emp_id;?>},
				 success: function(res){
					$("#leads_list").html(res);
				 }
			});
		});
        
$(".comp_delete").click(function(e){e.preventDefault();
	if (!confirm("Sure you want to delete?")){
			  return false;
			}
		var id=$(this).attr("id");$(this).closest("tr").remove();
		$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/ajax_emp_delete',
				 data: {id:id,code:<?php echo $emp->emp_code;?>},
				 success: function(response){
					 //alert(response);
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













