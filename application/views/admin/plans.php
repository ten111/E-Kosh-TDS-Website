<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Listed Plans</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>
                            <li class="breadcrumb-item active">Plans</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Add/Edit Plan</h4>
                    </div><!-- end card header -->
                    <div class="card-body">                        
                    <?php if ($this->uri->segment(3)) {
                        $id = $this->uri->segment(3);
                        $edit = $this->db->get_where("plan", array("plan_id" => $id))->row();?>
                        <form enctype="multipart/form-data" action="<?php echo base_url() . 'admin/plan_update/'; ?>" method="post">
                            <div class='form-group'>
                            	<input type="hidden" name="plan_id" value="<?php echo $edit->plan_id;?>" />
                                <label>Plan Name</label>
                                <input type="text " name="plan_name" value="<?php echo $edit->plan_name;?>"  class="form-control" id="text" placeholder="Enter plan  name">
                            </div>
                            <div class="row">
                            <div class='form-group col-md-6'>
                                <label>Max Employees</label>
                                <input type="text " name="plan_duration" value="<?php echo $edit->plan_duration;?>"  class="form-control" id="text" placeholder="100">
                                
                            </div>
                            <div class='form-group col-md-6'>
                                <label>Plan Price</label>
                                <input type="number " name="plan_price" value="<?php echo $edit->plan_price;?>"  class="form-control" id="text" placeholder="">
                            </div>
                            </div>
                            <div class='form-group'>
                            <label>Plan Features</label>
                            <table class="table table-bordered">
                                <?php $i=0; $pfs=explode("|",$edit->plan_desc);
                                foreach($pfs as $pf){?>
                             
                                <tr id="field<?php echo $i;?>"><td><input value="<?php echo $pf;?>" type="text" class="form-control" required name="pfeatures[]"></td><td>
                                <button id="remove<?php echo $i-1;?>" class="btn float-end pull-right btn-danger btn-sm remove-me" >X</button></td></tr>
                                <?php $i++;}?>
                            </table>
                            <button id="add-more" type="button" name="add-more" class="btn btn-primary btn-sm pull-right float-end">Add More</button>
                            </div>
                            <button class="btn btn-success"> SUBMIT </button>
                        </form>
                    <?php } else { ?>
                        <form enctype="multipart/form-data" action="<?php echo base_url() . 'admin/plan_submit/'; ?>" method="post">
                            <div class='form-group'>
                                <label>Plan Title</label>
                                <input type="text " name="plan_name" class="form-control" id="text" placeholder="Enter plan  name">
                            </div>
                            <div class="row">
                            <div class='form-group col-md-6'>
                            <label>Max Employees</label>
                            <input type="text " name="plan_duration" class="form-control" id="text" placeholder="100">
                            </div>
                            <div class='form-group col-md-6'>
                                <label>Plan Price</label>
                                <input type="number " name="plan_price" class="form-control" id="text" placeholder="">
                            </div>
                            </div>
                            <div class='form-group'>
                            <label>Plan Features</label>
                            <table class="table table-bordered">
                                <tr id="field0"><td colspan="2"><input type="text" class="form-control" required name="pfeatures[]"></td></tr>
                            </table>
                            <button id="add-more" type="button" name="add-more" class="btn btn-primary btn-sm pull-right float-end">Add More</button>
                            </div>
							<br/>
                            <button class="btn btn-success"> SUBMIT </button>
                        </form>
                    <?php } ?>
                    </div>
                   
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Listed Plans</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table align-middle table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Price</th>
                              
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $data = $this->db->get("plan")->result_array();
                            foreach ($data as $c) { ?>
                                <tr>
                                    <td><?php echo $c['plan_name']; ?></td>
                                    <td><?php echo $c['plan_duration'];?> </td>
                                    <td><?php echo $c['plan_price']; ?></td>

                                   
                                    <td>
                                        <a href="<?php echo base_url().'admin/plans/'.$c['plan_id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                  
                                        <a href="#" id="<?php echo $c['plan_id']; ?>" class="btn btn-sm btn-danger plan_delete"><i class="bi bi-archive"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        </table></div>
                       
        <!--end row-->

        <div class="row">
           
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

        
        
        $(".plan_delete").click(function(e){e.preventDefault();

if (!confirm("Sure you want to delete?")){

          return false;

        }

    var id=$(this).attr("id");
    $(this).closest("tr").remove();

    $.ajax({

                     type: "POST",

                     url: '<?php echo base_url();?>admin/ajax_plan_delete',

                     data: {id:id},

                     success: function(response){

                         //alert(response);

                     }

                     });

});

        $(".remove-me").click(function(){
		$(this).closest("tr").remove();
	});
var next = 0;
    $("#add-more").click(function(e){
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = '<tr id="field'+ next +'"><td><input type="text" class="form-control" required name="pfeatures[]"></td><td><button id="remove' + (next - 1) + '" class="btn float-end pull-right btn-danger btn-sm remove-me" >X</button></td></tr>';
        var newInput = $(newIn);
        var removeBtn = '';
        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);  
        
            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
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

















