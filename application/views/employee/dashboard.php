<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Dashboard
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="#">Dashboard</a></li>
				</ol>
			</section>
			<!-- Counters Section Starts -->
			<div class="dashboard1">
				<div class="row">
					<div class="col-xl-3 col-lg-6 col-12">
						<div class="counter-box">
							<div class="shadow bg1">	
								<div class="text-white text-center">
									<i class="fa fa-user-o fa-2x"></i>
									<div class="mt-2">New Leads</div>
									<h3 class="mt-1 count"><?php echo $this->db->get_where("leads",array("lead_status"=>"","lead_emp"=>$this->session->userdata("user")))->num_rows();?></h3>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-12">
						<div class="counter-box">
							<div class="shadow bg2">
								<div class="text-white text-center">
									<i class="fa fa-user-o fa-2x"></i>
									<div class="mt-2">Follow Up</div>
									<h3 class="mt-1 count"><?php echo $this->db->get_where("leads",array("lead_status"=>"Follow Up","lead_emp"=>$this->session->userdata("user")))->num_rows();?></h3>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-12">
						<div class="counter-box">
							<div class="shadow bg3">
								<div class="text-white text-center">
									<i class="fa fa-user-o fa-2x"></i>
									<div class="mt-2">Free Trials</div>
									<h3 class="mt-1 count"><?php echo $this->db->get_where("leads",array("lead_status"=>"Free Trial","lead_emp"=>$this->session->userdata("user")))->num_rows();?></h3>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-12">
						<div class="counter-box">
							<div class="shadow bg4">
								<div class="text-white text-center">
									<i class="fa fa-user-o fa-2x"></i>
									<div class="mt-2">Switch Off</div>
									<h3 class="mt-1 count"><?php echo $this->db->get_where("leads",array("lead_status"=>"Switch Off","lead_emp"=>$this->session->userdata("user")))->num_rows();?></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Counters Section Ends -->
				<!-- Chart Section Starts -->
				<div class="row chartjs">
					<div class="col-xl-12 col-lg-12 col-12">
						<div class="cardbg">
							<h6 class="title-inner text-uppercase">This Week Calling</h6>
							<div class="chart-wrapper">
								<canvas id="grouped-bar-chart"></canvas>
							</div>
						</div>
					</div>
					
				</div>
				<!-- Chart Section Ends -->
				<!-- Client Section Starts -->
				<div class="row">
					<div class="col-xl-6 col-lg-7 col-7">
						<div class="cardbg">
							<h6 class="title-inner text-uppercase">Today Follow Ups</h6>
							<div class="table-responsive">
								<table class="table m-0 table-striped">
									<thead>
										<tr>
											<th>Name</th>
											<th>Contact</th>
										</tr>
									</thead>
									<tbody>
                                    	<?php $this->db->select("*");
		$this->db->from("leads");
		//$this->db->join("employees","leads.lead_emp=employees.emp_id","left");
		$this->db->join("followups","leads.lead_id=followups.lead_id");
		$this->db->where("leads.lead_emp",$this->session->userdata("user"));
		$this->db->where("followups.next_date",date("Y-m-d"));
		$this->db->where("leads.lead_status","Follow Up");
		$this->db->order_by("leads.lead_id","desc");
		$leads=$this->db->get()->result();
		foreach($leads as $l){?>
										<tr>
											<td><?php echo $l->contact_person;?></td>
											<td><?php echo $l->contact_phone1;?> <?php echo $l->contact_phone2;?></td>
											
										</tr>
									<?php }?>
                                    </tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- Client Section Ends -->
					<!-- Profile Section Starts -->
					<div class="col-xl-6 col-lg-5 col-5">
						<div class="cardbg">
                        	<?php $total=$this->db->get_where("leads",array("last_update_mon"=>date("M-Y"),"lead_status!="=>"","lead_emp"=>$this->session->userdata("user")))->num_rows();?>
							<h6 class="title-inner text-uppercase">This Month Calling Data (<?php echo $total;?>)</h6>
							<canvas id="pie-chart"></canvas>
						</div>
					</div>
					<!-- Profile Section Ends -->
				</div>
				
			</div>
		</div>
		<!-- Page Content Ends -->
		
		<!-- Back to Top Starts -->
		<a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
		<!-- Back to Top Ends -->
		
		<!-- Footer Section Starts -->
		<footer class="main-footer">
			<div class="pull-right hidden-xs">
			  Version 1.0.0
			</div>
			<p class="mb-0">Copyright © 2024 <a target="_blank" href="#">Admin</a>. All rights reserved.
            <?php  $start = date('Y-m-d',strtotime('last monday'));?>
            </p>
		</footer>
		<!-- Footer Section Ends -->
		
	</div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
	<!-- Page JS -->
	<script src="<?php echo base_url();?>adminassets/assets/js/charts/Chart.bundle.min.js"></script>
    <script>
	<?php 
	if($total>0) {?>
	
	$count1=$this->db->get_where("leads",array("last_update_mon"=>date("M-Y"),"lead_status"=>"Switch Off","lead_emp"=>$this->session->userdata("user")))->num_rows(); 
	$count2=$this->db->get_where("leads",array("last_update_mon"=>date("M-Y"),"lead_status"=>"Not Interested","lead_emp"=>$this->session->userdata("user")))->num_rows(); 
	$count3=$this->db->get_where("leads",array("last_update_mon"=>date("M-Y"),"lead_status"=>"Follow Up","lead_emp"=>$this->session->userdata("user")))->num_rows(); 
	$count5=$this->db->get_where("leads",array("last_update_mon"=>date("M-Y"),"lead_status"=>"Free Trial","lead_emp"=>$this->session->userdata("user")))->num_rows(); 
	$count4=$this->db->get_where("leads",array("last_update_mon"=>date("M-Y"),"lead_status"=>"Interested","lead_emp"=>$this->session->userdata("user")))->num_rows();?> 
	new Chart(document.getElementById("pie-chart"), {
		type: 'pie',
		data: {
		  labels: ["Switch Off", "NPC", "Follow Up","Free Trial", "Converted"],
		  datasets: [{
			label: "Monthly Calling Ratio",
			backgroundColor: ["orange", "red","green","blue","pink"],
			data: [<?php  echo $count1*100/$total;?>,<?php  echo $count2*100/$total;?>,<?php  echo $count3*100/$total;?>,<?php  echo $count5*100/$total;?>,<?php  echo $count4*100/$total;?>]
		  }]
		},options: {
		 // maintainAspectRatio: false,
		  responsive: true,
		  title: {
			display: true,
			text: 'Predicted world population (millions) in 2050'
		  }
		}
	});		

	new Chart(document.getElementById("grouped-bar-chart"), {
    type: 'bar',
    data: {
      labels: ["Mon", "Tue", "Wed", "Thu","Fri","Sat","Sun"],
      datasets: [
        {
          label: "Switch Off",
          backgroundColor: "orange",
          data: [<?php for($i=0;$i<7;$i++){
			  $d=date('Y-m-d',strtotime($start.' '.+$i.' day'));
			  echo $this->db->get_where("leads",array("last_update"=>$d,"lead_status"=>"Switch Off","lead_emp"=>$this->session->userdata("user")))->num_rows().',';
			  //echo rand(222,9999).',';
			   }?>]
        }, {
          label: "NPC",
          backgroundColor: "red",
          data: [<?php for($i=0;$i<7;$i++){
			  $d=date('Y-m-d',strtotime($start.' '.+$i.' day'));
			  echo $this->db->get_where("leads",array("last_update"=>$d,"lead_status"=>"Not Interested","lead_emp"=>$this->session->userdata("user")))->num_rows().',';
			  //echo rand(222,9999).',';
			   }?>]
        }, {
          label: "Follow Up",
          backgroundColor: "green",
          data: [<?php for($i=0;$i<7;$i++){
			  $d=date('Y-m-d',strtotime($start.' '.+$i.' day'));
			  $fr=$this->db->get_where("leads",array("last_update"=>$d,"lead_status"=>"Free Trial","lead_emp"=>$this->session->userdata("user")))->num_rows();
			  echo $fr+$this->db->get_where("leads",array("last_update"=>$d,"lead_status"=>"Follow Up","lead_emp"=>$this->session->userdata("user")))->num_rows().',';
			  //echo rand(222,9999).',';
			   }?>]
        }, {
          label: "Converted",
          backgroundColor: "blue",
          data: [<?php for($i=0;$i<7;$i++){
			  $d=date('Y-m-d',strtotime($start.' '.+$i.' day'));
			  echo $this->db->get_where("leads",array("last_update"=>$d,"lead_status"=>"Interested","lead_emp"=>$this->session->userdata("user")))->num_rows().',';
			  //echo rand(222,9999).',';
			   }?>]
        }
      ]
    },
    options: {
	  maintainAspectRatio: false,
	  responsive:true,
      title: {
        display: true,
        text: 'No of Calls'
      }
    }
});
<?php }?>
	</script>
	<script src="<?php echo base_url();?>adminassets/assets/js/charts/pie/doughnut-chart-multiline.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/dashboard/dashboard1.js"></script>
	<!-- Theme JS -->
	<script src="<?php echo base_url();?>adminassets/assets/js/nanoscroller/nanoscroller.js"></script>
	<script src="<?php echo base_url();?>adminassets/assets/js/custom/theme.js"></script>
</body>
</html>