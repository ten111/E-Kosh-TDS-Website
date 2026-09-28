
	<div class="col-4">
        <table class="table table-bordered">
            <tbody>
<tr><th>Bill/BTR</th><th><?php echo $empd->dt_bill_no.'/'.$empd->dt_btr;?></th></tr>
<tr><th colspan="2" class="text-success">DUES</th></tr>
<tr><th>Basic</th><th><?php echo $empd->dt_basic;?></th></tr>
<tr><th>DA</th><th><?php echo $empd->dt_da;?></th></tr>
<tr><th>HOUSE ALLOW</th><th><?php echo $empd->dt_house;?></th></tr>
<tr><th>CITY COMP ALLOW.</th><th><?php echo $empd->dt_city;?></th></tr>
<tr><th>WASHING ALLOW.</th><th><?php echo $empd->dt_wash;?></th></tr>
<tr><th>MEDICAL</th><th><?php echo $empd->dt_medical;?></th></tr>
<tr><th>OTHER</th><th><?php echo $empd->other;?></th></tr>
<tr><th>FIX TRAVEL ALLOWANCE</th><th><?php echo $empd->dt_fix_ta;?></th></tr>

<tr style="background:#2ecc71;"><th>TOTAL DUES</th><th><?php echo $empd->dt_dues;?></th></tr>

<tr><th colspan="2" class="text-danger">DEDUCTIONS</th></tr>

<tr><th>HOUSE RENT</th><th><?php echo $empd->dt_hre_recv;?></th></tr>
<tr><th>WATER CHARGES</th><th><?php echo $empd->dt_water;?></th></tr>
<tr><th>GPF SUBS</th><th><?php echo $empd->dt_gpf;?></th></tr>
<tr><th>GPF REC</th><th><?php echo $empd->dt_gpf_recv;?></th></tr>
<tr><th>FESTIVAL</th><th><?php echo $empd->dt_fest;?></th></tr>
<tr><th>GIS</th><th><?php echo $empd->dt_gis;?></th></tr>
<tr><th>INCOME TAX</th><th><?php echo $empd->dt_tax;?></th></tr>
<tr><th>TOTAL DED</th><th><?php echo $empd->dt_ded;?></th></tr>
<tr><th class="text-info">NET SALARY</th><th><?php echo $empd->dt_net_salary;?></th></tr>
</tbody>
</table>
