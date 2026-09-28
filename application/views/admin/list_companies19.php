        <div class="section-body mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <table class="table">
                                <thead><tr><th>S.No.</th><th>Logo</th><th>Company Name</th><th>PAN</th><th>AddedDate</th>
                                       <th>Type</th><th>Contacts</th><th>Action</th></tr></thead>
                                <tbody id="companies_list">
                                    
                                </tbody>
                            </table>      
                        </div>               
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url();?>assets/bundles/lib.vendor.bundle.js"></script>
<script>
$(document).ready(function(){
	$.ajax({
		 type: "POST",
		 url: '<?php echo base_url();?>admin/ajax_company_list',
		 data: {index:1},
		 success: function(res){//alert(res);
			// alert("OTP Sent Again");
			$("#companies_list").html(res);
		 }
	 });
});
</script>
<script src="<?php echo base_url();?>assets/bundles/selectize.bundle.js"></script>

<script src="<?php echo base_url();?>assets/js/core.js"></script>
<script src="<?php echo base_url();?>js/vendors/selectize.js"></script>
</body>
</html>