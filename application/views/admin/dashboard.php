<div class="main-content">

<div class="page-content">
	<div class="container-fluid">

		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0">Dashboard</h4>
						<a href="<?php echo base_url().'admin/download_database';?>" class="btn btn-warning btn-sm pull-right float-end end">Download DB Backup</a>
				

				</div>
			</div>
		</div>
		<!-- end page title -->

		<div class="row">

			<div class="col-xl-12">
				<div class="card dash-mini">
					<div class="card-header border-0 align-items-center d-flex">
						<h4 class="card-title mb-0 flex-grow-1">Overview</h4>
						
					</div><!-- end card header -->

					<div class="card-body pt-1">
					<?php if($this->session->userdata("type")=="admin"){?>
					<div class="row">
							<div class="col-lg-3 mini-widget pb-3 pb-lg-0">
								<div class="d-flex align-items-end">
									<div class="flex-grow-1">
										<h2 class="mb-0 fs-24"><span class="counter-value" data-target="<?php echo $this->db->get("emps")->num_rows();?>">0</span></h2>
										<h5 class="text-muted fs-16 mt-2 mb-0">Employees Added</h5>
									</div>
								</div>
							</div>

							<div class="col-lg-3 mini-widget py-3 py-lg-0">
								<div class="d-flex align-items-end">
									<div class="flex-grow-1">
										<h2 class="mb-0 fs-24"><span class="counter-value" data-target="<?php echo $this->db->get("clients")->num_rows();?>">0</span></h2>
										<h5 class="text-muted fs-16 mt-2 mb-0">Clients</h5>
									</div>
								</div>
							</div>

							<div class="col-lg-3 mini-widget pt-3 pt-lg-0">
								<div class="d-flex align-items-end">
									<div class="flex-grow-1">
										<h2 class="mb-0 fs-24"><span class="counter-value" data-target="<?php echo $this->db->get("emp_itr")->num_rows();?>">0</span></h2>
										<h5 class="text-muted fs-16 mt-2 mb-0">ITR Generated</h5>
									</div>
								</div>
							</div>
							
							<div class="col-lg-3 mini-widget pt-3 pt-lg-0">
								<div class="d-flex align-items-end">
									<div class="flex-grow-1">
										<h2 class="mb-0 fs-24"><span class="counter-value" data-target="0">0</span></h2>
										<h5 class="text-muted fs-16 mt-2 mb-0">Active Subscription</h5>
									</div>
								</div>
							</div><!-- end col -->
						</div>
						<?php }else{?>
						<div class="row">
							<div class="col-lg-3 mini-widget pb-3 pb-lg-0">
								<div class="d-flex align-items-end">
									<div class="flex-grow-1">
										<h2 class="mb-0 fs-24"><span class="counter-value" data-target="<?php echo $this->db->get_where("emps",array("emp_client"=>$this->session->userdata("userid")))->num_rows();?>">0</span></h2>
										<h5 class="text-muted fs-16 mt-2 mb-0">Employees Added</h5>
									</div>
								</div>
							</div>


							<div class="col-lg-3 mini-widget pt-3 pt-lg-0">
								<div class="d-flex align-items-end">
									<div class="flex-grow-1">
										<h2 class="mb-0 fs-24"><span class="counter-value" data-target="<?php echo $this->db->get_where("emp_itr",array("itr_client"=>$this->session->userdata("userid")))->num_rows();?>">0</span></h2>
										<h5 class="text-muted fs-16 mt-2 mb-0">ITR Generated</h5>
									</div>
								</div>
							</div>
							<?php 
							$this->db->select('COUNT(*) AS total');
							$this->db->from('emp_itr');
							$this->db->where('paytype', 'Nil');
							$this->db->where("itr_client",$this->session->userdata("userid"));
							$this->db->where('itr_yr', '2026-27');
							$nil_total = $this->db->get()->row()->total;?>
							<div class="col-lg-3 mini-widget pt-3 pt-lg-0">
								<div class="d-flex align-items-end">
									<div class="flex-grow-1">
										<h2 class="mb-0 fs-24"><span class="counter-value" data-target="<?php echo $nil_total;?>"><?php echo $nil_total;?></span></h2>
										<h5 class="text-muted fs-16 mt-2 mb-0">ITR Nil</h5> 
									</div>
								</div>
							</div>

							<?php 
							$this->db->select('COUNT(*) AS total');
							$this->db->from('emp_itr');
							$this->db->where('paytype', 'Payable');
							$this->db->where('itr_yr', '2026-27');
							$this->db->where("itr_client",$this->session->userdata("userid"));
							$payy = $this->db->get()->row()->total;?>
							<div class="col-lg-3 mini-widget pt-3 pt-lg-0">
								<div class="d-flex align-items-end">
									<div class="flex-grow-1">
										<h2 class="mb-0 fs-24"><span class="counter-value" data-target="<?php echo $payy;?>"><?php echo $payy;?></span></h2>
										<h5 class="text-muted fs-16 mt-2 mb-0">ITR Payable</h5> 
									</div>
								</div>
							</div>
							

							<?php 
							$this->db->select('COUNT(*) AS total');
							$this->db->from('emp_itr');
							$this->db->where('paytype', 'Refundable');
							$this->db->where('itr_yr', '2026-27');
							$this->db->where("itr_client",$this->session->userdata("userid"));
							$reff = $this->db->get()->row()->total;?>
							<div class="col-lg-3 mini-widget pt-3 pt-lg-0 mt-2">
								<div class="d-flex align-items-end">
									<div class="flex-grow-1">
										<h2 class="mb-0 fs-24"><span class="counter-value" data-target="<?php echo $reff;?>"><?php echo $reff;?></span></h2>
										<h5 class="text-muted fs-16 mt-2 mb-0">ITR Refundable</h5> 
									</div>
								</div>
							</div>
						</div>
						
						<?php }?>
					</div>
				</div>
			</div>
		</div>
		<!-- end row -->

		<?php
		// ============================================================
		// Final Tax Liability Distribution (2026-27)
		// Buckets: 0-10k, 10k-20k, 20k-50k, 50k-100k, 100k+
		// Applies to both admin (all clients) and client (own data)
		// ============================================================
		$isAdmin    = ($this->session->userdata("type") == "admin");
		$clientId   = $this->session->userdata("userid");

		// Helper function to get count for a bucket
		if (!function_exists('getLiabilityCount')) {
			function getLiabilityCount($CI, $isAdmin, $clientId, $min, $max = null) {
				$CI->db->select('COUNT(*) AS total');
				$CI->db->from('emp_itr');
				$CI->db->where('itr_yr', '2026-27');
				$CI->db->where('paytype', 'Payable');

				// Only filter by client if NOT admin
			//	if (!$isAdmin) {
					$CI->db->where('itr_client', $clientId);
			//	}

				// Only positive amounts (cast varchar to decimal)
				$CI->db->where('CAST(finalTaxLiability AS DECIMAL(10,2)) >', 0);
				$CI->db->where('CAST(finalTaxLiability AS DECIMAL(10,2)) >=', $min);
				if ($max !== null) {
					$CI->db->where('CAST(finalTaxLiability AS DECIMAL(10,2)) <', $max);
				}
				return (int) $CI->db->get()->row()->total;
			}
		}

		// Fetch counts for each bucket
		$b1 = getLiabilityCount($this, $isAdmin, $clientId, 0.01, 10000);   // 0 - 10K
		$b2 = getLiabilityCount($this, $isAdmin, $clientId, 10000, 20000);  // 10K - 20K
		$b3 = getLiabilityCount($this, $isAdmin, $clientId, 20000, 50000);  // 20K - 50K
		$b4 = getLiabilityCount($this, $isAdmin, $clientId, 50000, 100000); // 50K - 100K
		$b5 = getLiabilityCount($this, $isAdmin, $clientId, 100000, null);  // 100K+

		$grandTotal = $b1 + $b2 + $b3 + $b4 + $b5;
		?>

		<!-- Final Tax Liability Distribution Chart -->
		<div class="row mt-3">
			<div class="col-xl-12">
				<div class="card">
					<div class="card-header border-0 align-items-center d-flex">
						<h4 class="card-title mb-0 flex-grow-1">Final Tax Liability Distribution (2026-27)</h4>
						<span class="badge bg-primary fs-12">Total: <?php echo $grandTotal; ?></span>
					</div>
					<div class="card-body">
						<div id="taxLiabilityChart" style="width: 100%; height: 350px;"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- end row -->


	</div>
	<!-- container-fluid -->
</div>
<!-- End Page-content -->

<footer class="footer">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-6">
				<script>document.write(new Date().getFullYear())</script> © EKosh.
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

<div id="preloader">
<div id="status">
<div class="spinner-border text-primary avatar-sm" role="status">
	<span class="visually-hidden">Loading...</span>
</div>
</div>
</div>

<!-- ============================================================ -->
<!-- amCharts 5 CDN                                                -->
<!-- ============================================================ -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<script src="<?php echo base_url();?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/feather-icons/feather.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins.js"></script>

<!-- prismjs plugin -->
<script src="<?php echo base_url();?>assets/libs/prismjs/prism.js"></script>

<script src="<?php echo base_url();?>assets/js/app.js"></script>

<!-- ============================================================ -->
<!-- amCharts 5 - Final Tax Liability Distribution                  -->
<!-- ============================================================ -->
<!-- ============================================================ -->
<!-- amCharts 5 - Final Tax Liability Distribution                  -->
<!-- ============================================================ -->
<script>
am5.ready(function() {

    // Create root element
    var root = am5.Root.new("taxLiabilityChart");

    // Apply animated theme
    root.setThemes([am5themes_Animated.new(root)]);

    // Create XY chart
    var chart = root.container.children.push(
        am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            wheelX: "none",
            wheelY: "none",
            paddingLeft: 0
        })
    );

    // ============================================================
    // Y-Axis (categories / buckets)
    // ============================================================
    var yAxis = chart.yAxes.push(
        am5xy.CategoryAxis.new(root, {
            categoryField: "range",
            renderer: am5xy.AxisRendererY.new(root, {
                inversed: true,
                cellStartLocation: 0.1,
                cellEndLocation: 0.9
            })
        })
    );

    // ============================================================
    // X-Axis (integer values only)
    // ============================================================
    var xAxis = chart.xAxes.push(
        am5xy.ValueAxis.new(root, {
            min: 0,
            strictMinMax: false,
            // Force integer-only ticks (no 0.5, 1.5, etc.)
            numberFormat: "#",
            // Show ticks at whole numbers only
            renderer: am5xy.AxisRendererX.new(root, {
                strokeOpacity: 0.1,
                minGridDistance: 40
            })
        })
    );

    // Force the axis to use integer steps only
    xAxis.set("extraMin", 0);
    xAxis.set("extraMax", 0.1);
    xAxis.set("maxPrecision", 0);
    xAxis.set("treatZeroAs", 0);
    xAxis.set("numberFormat", "#");

    // ============================================================
    // Series (bars)
    // ============================================================
    var series = chart.series.push(
        am5xy.ColumnSeries.new(root, {
            name: "Employees",
            xAxis: xAxis,
            yAxis: yAxis,
            valueXField: "count",
            categoryYField: "range",
            tooltip: am5.Tooltip.new(root, {
                labelText: "{categoryY}: {valueX} employees"
            })
        })
    );

    // Style columns
    series.columns.template.setAll({
        height: am5.percent(70),
        tooltipY: 0,
        strokeOpacity: 0
    });

    // Gradient fill
    series.columns.template.set("fillGradient", am5.LinearGradient.new(root, {
        stops: [
            { color: am5.color(0x405189) },
            { color: am5.color(0x0ab39c) }
        ],
        rotation: 90
    }));

    // ============================================================
    // Labels on every bar (always visible, even when count = 0)
    // ============================================================
    series.bullets.push(function() {
        return am5.Bullet.new(root, {
            locationX: 1,
            sprite: am5.Label.new(root, {
                text: "{valueX}",
                fill: am5.color(0x000000),
                centerY: am5.percent(50),
                centerX: am5.percent(0),
                populateText: true,
                fontSize: 13,
                fontWeight: "600",
                paddingLeft: 6
            })
        });
    });

    // ============================================================
    // DATA - from PHP
    // ============================================================
    var data = [
        { range: "0 - 10K",        count: <?php echo $b1; ?> },
        { range: "10K - 20K",      count: <?php echo $b2; ?> },
        { range: "20K - 50K",      count: <?php echo $b3; ?> },
        { range: "50K - 100K",     count: <?php echo $b4; ?> },
        { range: "More than 100K", count: <?php echo $b5; ?> }
    ];

    // Set data
    yAxis.data.setAll(data);
    series.data.setAll(data);

    // Animate on load
    series.appear(1000);
    chart.appear(1000, 100);

});
</script>

</body>


</html>