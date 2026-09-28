    <div class="content-wrapper">
			<section class="content-header">
				<h5>List Calls</h5>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">List Calls</li>
				</ol>
			</section>
			<section class="content">
				<!-- Default box -->
				<div class="row clearfix">
                <div class="col-md-4"><?php if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
                    <div class="panel panel-primary cardbg">
                        <div class="panel-body">
                        <form action="<?php echo base_url();?>admin/post" method="post">
                        	<div class="form-group">
                            	<label>Message</label>
                                <textarea class="form-control" name="message" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">POST</button>
                        </form>  
                        </div>
                    </div>
                </div>
                <div class="col-md-8"><?php //if($this->session->flashdata("msg")!==""){echo $this->session->flashdata("msg"); }?>
                    <div class="panel panel-primary cardbg">
                        <div class="panel-body">
                        <table class="table">
                                <thead><tr><th>S.No.</th><th>Date</th><th>Call</th><th>Action</th></tr></thead>
                                <tbody>
                                    <?php $i=1;foreach($calls as $call){?>
                                    <tr><td><?php echo $i;?></td>
                                    	<td><?php echo date("d-m-Y",strtotime($call->call_date)).' '.$call->call_time;?></td>
                                        <td><?php echo $call->call_desc;?></td>
                                        <td><a href="#" id="<?php echo $call->call_id;?>" class="btn btn-sm btn-danger call_delete"><i class="fa fa-trash-o"></i></a></td></tr>
                                    <?php $i++;}?>
                                </tbody>
                            </table>   
                        </div>
                    </div>
                </div>
                
            </div>
			</section>
		</div>
        
        <div id="change_pass" class="modal fade" role="dialog">

      <div class="modal-dialog modal-sm">

        <!-- Modal content-->

        <div class="modal-content">

          <div class="modal-header">

            <h4 class="modal-title">Change Password</h4>

            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <div class="modal-body">

          	<form id="change_pass_form" action="" method="post">

            	<input type="hidden" name="vid" value="" id="change_pass_vid" />

            	<div class="form-group">

                	<label>New Password</label>

                    <input type="password" class="form-control" name="pass" id="pass" />

                </div>

                <div class="form-group">

                	<label>New Password</label>

                    <input type="password" class="form-control" name="cpass" id="cpass" />

                </div>

                <button type="submit" class="btn btn-warning" id="submit_btn">Change Password</button>

           	    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </form>

          </div>

          <div class="modal-footer">

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
		
$(".call_delete").click(function(e){e.preventDefault();
	if(!confirm("Sure you want to delete?")){
		  return false;
		}
		var id=$(this).attr("id");$(this).closest("tr").remove();
		$.ajax({
			 type: "POST",
			 url: '<?php echo base_url();?>admin/ajax_call_delete',
			 data: {id:id},
			 success: function(response){
				 //alert(response);
			 }
		});
	});
		$("#change_pass_form").submit(function(e){e.preventDefault();

			$("#submit_btn").attr("disbled",true);

			var id=$("#change_pass_vid").val();

			var pass=$("#pass").val();

			var cpass=$("#cpass").val();

			$("#change_pass_vid").val(id);
			//(id);
			$.ajax({

				 type: "POST",

				 url: '<?php echo base_url();?>admin/change_passemp1',

				 data: {id:id,pass:pass,cpass:cpass},

				 success: function(res){

					 $("#submit_btn").removeAttr("disbled");

					 alert(res);

				 }

			});

		});
	});
	</script>
	<!-- Popper.JS -->	<script src="<?php echo base_url();?>adminassets/assets/js/nanoscroller/nanoscroller.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/custom/theme.js"></script>
</body>
</html>