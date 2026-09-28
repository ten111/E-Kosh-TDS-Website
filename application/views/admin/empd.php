
<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 text-danger"><?php echo $this->uri->segment(3);?></h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active"><?php echo $this->db->get_where("emp_data",array("dt_client"=>$this->session->userdata("userid"),"dt_type_mon"=>$this->uri->segment(3)))->num_rows();?> Records</li>
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

        table {
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
        th:nth-child(-n+3),
        td:nth-child(-n+3) {
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
        th:nth-child(3), td:nth-child(3) { left: 200px; }
    </style>
        <div class="row">           
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <button type="button" class="btn btn-warning float-end btn-sm" data-bs-toggle="modal" data-bs-target="#new_data_box">ADD NEW</button>
                       
                    <input type="text" style="width:300px;" placeholder="Search Name/Code/Mobile" id="search_name" class="form-control"/>
                    </div><!-- end card header -->
                    <div class="card-body">
					<div class="table-responsive table-container">
            <table class="table table-bordered align-middle table-nowrap mb-0">
                            <thead>
                            <!-- <tr bgcolor="#CCCCCC"><th><div class="checkbox">
                            <input type="checkbox" id="checkAll" value="checkall" /> <label for="checkAll">All</label></div></th>
                            	<th><select class="form-control" style="width:80px;" id="showdata">
                                	<option value="10">10</option>
                                	<option value="25">25</option>
                                	<option value="100">100</option>
                                	<option value="200">200</option>
                                	<option value="500">500</option>
                                	</select></th><th colspan="5"></th></tr> -->
                            <tr bgcolor="#FFCC00">
                            <th>SN</th><th>NAME</th>
        <th>EMPCODE</th>
        <th>BILLNO</th>
        <th>BTRNO</th>
        <th>BASIC</th>
        <th>DEARNESS ALLOWANCE</th>
        <th>HOUSE RENT ALLOWANCE</th>
        <th>CITY COMPENSATORY ALLOWANCE</th>
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
        <th>Month</th>
                            </tr></thead>
                                   <tbody id="leads_list">
                                   <tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>
                                   </tbody>
                        </table>
                        <!-- <button id="prev" class="btn btn-sm btn-danger">Previous</button> -->
                        <button id="next" class="btn btn-dark">Load More</button>
                      
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
            <!--end col-->
        </div>
        <!--end row-->

       

        

        

        
        

        <!--end row-->

    </div> <!-- container-fluid -->
    <div id="new_data_box" class="modal fade" role="dialog">

<div class="modal-dialog modal-md">

  <div class="modal-content">

  <div class="modal-header">
                                                      <h5 class="modal-title">ADD/UPDATE RECORD</h5>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>

    <div class="modal-body">
        <?php $m=explode("-",$this->uri->segment(3));?>
    <form action="" method="post" id="add_form">
<input type="hidden" name="dt_emp_id" id="dt_emp_id"/>
<input type="hidden" name="dt_client"  value="<?php echo $this->session->userdata("userid");?>"/>
<input type="hidden" name="dt_month" value="<?php echo $m[1].'-'.$m[2];?>"/>
<input type="hidden" name="dt_type_mon" id="dt_type_mon" value=""/>
<div class="row">
    <div class="form-group  col-md-4"> 
															   <label for="email">Tax Year</label>
																  <select class="form-control" required="" name="dt_fnyr">
																	  <option>Select</option>
								  <option value="2026_27">2026-27</option>
								  <option value="2025_26">2025-26</option>
								  </select>
															   </div> 
<div class="form-group  col-md-4"> 
															   <label for="email">Payment Type</label>
																  <select class="form-control" required="" name="dt_type" id="dt_type">
																	  <option>Select</option>
								  <option value="Salary">Salary</option>
								  <option value="Arear">Arear</option>
								  <option value="PayArear">Pay Arear</option>
								  </select>
															   </div> 
<div class="form-group col-md-4"> 
                                <label for="email">Employee Code</label>
                                <input type="text"  class="form-control" name="dt_emp_code"  id="emp_code"/>
                                <b id="search_res"></b>
                              </div></div>
<div id="newform" style="display:none;">
         
<div class="row">
  
  <div class="form-group col-md-4"> 
                                <label for="email">Salary DDO</label>
  <input type="text" value="<?php echo $this->session->userdata("ddo_num");?>"  class="form-control" id="dt_sal_ddo" name="dt_sal_ddo_code"/>
  <input type="hidden" value="<?php echo $this->session->userdata("userid");?>"  id="ddoid" name="dt_sal_ddo"/>
  <small id="ddo_error"></small>

                              </div>
  <div class="form-group col-md-4"> 
                                <label for="email">Bill No</label>
                                <input type="text"  class="form-control"   name="dt_bill_no"/>
                              </div>

                              <div class="form-group  col-md-4"> 
                                <label for="email">BTR No</label>
                                <input type="text" class="form-control"   name="dt_btr"/>
                              </div>
                              </div>
                              
<div class="row mt-2">

<div class="col-md-6">
  <h5 class="text-success">Dues</h5>
                              

                              <div class="form-group"> 
                                <label for="email">Basic</label>
                                <input type="text" required class="form-control input-classs"  name="dt_basic"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">DA</label>
                                <input type="text" required class="form-control input-classs"  name="dt_da"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">House Allowance</label>
                                <input type="text" required class="form-control input-classs" name="dt_house"/>
                              </div>


                              <div class="form-group"> 
                                <label for="email">CITY ALLOWANCE</label>
                                <input type="text" required class="form-control input-classs" name="dt_city"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">WASHING ALLOWANCE	</label>
                                <input type="text" required class="form-control input-classs"   name="dt_wash"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">MEDICAL ALLOWANCE</label>
                                <input type="text" required class="form-control input-classs"  name="dt_medical"/>
                              </div>


                              <div class="form-group"> 
                                <label for="email">OTHER </label>
                                <input type="text" required class="form-control input-classs"  name="dt_other"/>
                              </div>

                              
                              <div class="form-group"> 
                                <label for="email">FIX TRAVEL ALLOWANCE	</label>
                                <input type="text" required class="form-control input-classs"  name="dt_fix_ta"/>
                              </div>

                              
                              <div class="form-group"> 
                                <label for="email">TOTAL DUES	</label>
                                <input type="text" realonly class="form-control input-classs1"   name="dt_dues"/>
                              </div>

      </div>
      <div class="col-md-6">

      <h5 class="text-danger">Deduction</h5>
      <div class="form-group"> 
                                <label for="email">GPF SUBSCRIPTION	</label>
                                <input type="text" required class="form-control input-classs2" name="dt_gpf"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">GPF RECOVERY	</label>
                                <input type="text" required class="form-control input-classs2" name="dt_gpf_recv"/>
                              </div>

                              
                              <div class="form-group"> 
                                <label for="email">GIS	</label>
                                <input type="text" required class="form-control input-classs2" name="dt_gis"/>
                              </div>


                              <div class="form-group"> 
                                <label for="email">FESTIVAL RECOVERY</label>
                                <input type="text" required class="form-control input-classs2"  name="dt_fest"/>
                              </div>
                              <div class="form-group"> 
                                <label for="email">HOUSE RENT</label>
                                <input type="text" required class="form-control input-classs2" name="dt_hre_recv"/>
                              </div>

                              <div class="form-group"> 
                                <label for="email">WATER CHARGES</label>
                                <input type="text" required class="form-control input-classs2" name="dt_water"/>
                              </div>


                              <div class="form-group"> 
                                <label for="email">INCOME TAX		</label>
                                <input type="text" required class="form-control input-classs2"   name="dt_tax"/>
                              </div>

                              




                              <div class="form-group"> 
                                <label for="email">TOTAL DEDUCTIONS	</label>
                                <input type="text" realonly class="form-control input-classs22"  name="dt_ded"/>
                              </div>

                              
                              <div class="form-group"> 
                                <label for="email">NET SALARY	</label>
                                <input type="text" realonly name="dt_net_salary" class="form-control" id="netsall"/>
                              </div>
                              </div></div>

<button type="submit" class="btn btn-success mt-2">ADD DATA</button>
</div>
</form>
        

    </div>

   

  </div>

</div>
</div><!-- End Page-content -->

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © Invoika.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by Themesbrand
                </div>
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
    $("#dt_type").change(function(){
var m  = $(this).val();
$("#dt_type_mon").val(m+'-'+"<?php echo $m[1].'-'.$m[2];?>")
    });
    $(".input-classs").keyup(function () {
        var sum = 0;
        $(".input-classs").each(function () {
            var value = parseFloat($(this).val()) || 0; // Convert to number, default to 0 if empty
            sum += value;
        });
        $(".input-classs1").val(sum);
        var net=$(".input-classs1").val()-$(".input-classs22").val();
        $("#netsall").val(net);
    });

    $(".input-classs2").keyup(function () {
        var sum = 0;
        $(".input-classs2").each(function () {
            var value = parseFloat($(this).val()) || 0; // Convert to number, default to 0 if empty
            sum += value;
        });
        $(".input-classs22").val(sum);
        
        var net=$(".input-classs1").val()-$(".input-classs22").val();
        $("#netsall").val(net);
    });
    let count = 0;
            
            $("#next").click(function() {
              //  $("#leads_list").html('<tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>');
                count += 10;
                $("#value").text(count);
                $.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_emp_data_list',
			 data: {limit:count,month:"<?php echo $this->uri->segment(3);?>"},
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
			 url: '<?php echo base_url();?>admin/ajax_emp_data_list',
			 data: {limit:count,month:"<?php echo $this->uri->segment(3);?>"},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#leads_list").html(res);
			 }
		 });
            });
    $("#search_name").keyup(function(){
      $("#leads_list").html('<tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>');

var name=$(this).val();

if(name.length>=3){

$.ajax({

     type: "POST",

     url: '<?php echo base_url();?>admin/ajax_emp_data_list',

     data: {name:name,limit:count,month:"<?php echo $this->uri->segment(3);?>"},

     success: function(response){

        $("#leads_list").html(response);

     }

 });

}else{
    $.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_emp_data_list',
			 data: {limit:count,month:"<?php echo $this->uri->segment(3);?>"},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#leads_list").html(res);
			 }
		 });
}

});

        $("#add_form").submit(function(e){e.preventDefault();
            var formdata=$(this).serialize();
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/ajax_submit_add',
				 data: {formdata:formdata},
				 success: function(res){
         // console.log(res);return false;
          if(res==1){
            alert("Record Added Successfully");
            window.location.href="<?php echo current_url();?>";
          }else{
            alert(res);
          }
				 }
			 });
		});
    $("#dt_sal_ddo").keyup(function(){
            var code=$(this).val();
            if(code.length>3){
                $.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_chk_ddo',
			 data: {code:code},
			 success: function(res){
                if(res>0){
                    $("#ddoid").val(res); 
                    $("#ddo_error").text("");             
                }
                else{
                    $("#ddo_error").text("External DDO");
                    $("#ddoid").val("");  
                }
			    }
		 });
        }
        });


		$("#emp_code").keyup(function(){
            var code=$(this).val();
            var type=$("#dt_type").val();
            
            if(code.length>3){
                $.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_search_emp',
			 data: {code:code,month:'<?php echo $m[1].'-'.$m[2];?>',type:type},
			 success: function(res){//alert(res);
				console.log(res);
                if(res!=0){
                    var id=res.split('-');
                    $("#dt_emp_id").val(id[0]);
                    if(id[2]==0){
                      $("#search_res").text(id[1]);
                    } else if(type=='Salary'){
                    $("#search_res").text(id[1]+' Data Already Exist, Fill New will OverWrite old');
                    }
				    $("#newform").show(); 
                }
                else{
                    $("#dt_emp_id").val('');
                    $("#search_res").text('Employee Not Found');
                    $("#newform").hide(); }
			    }
		 });
        }
        });
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_emp_data_list',
			 data: {limit:0,month:"<?php echo $this->uri->segment(3);?>"},
			 success: function(res){//alert(res);
				// alert("OTP Sent Again");
				$("#leads_list").html(res);
			 }
		 });
		$("#showdata").change(function(){
			var id=$(this).val();
			$.ajax({
				 type: "POST",
				 url: '<?php echo base_url();?>admin/ajax_emp_data_list',
				 data: {limit:0,month:"<?php echo $this->uri->segment(3);?>"},
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






































