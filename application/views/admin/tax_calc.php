<ul class="nav nav-tabs mb-3" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link "  data-bs-toggle="tab" href="#home" role="tab" aria-selected="false">
                                            TAX COMPUTATION
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#product1" role="tab" aria-selected="false">
                                                EDIT TAX COMPUATION
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content  text-muted">
                                        <div class="tab-pane " id="home" role="tabpanel">

                                        <?php 
                                        //echo "<pre>";print_r($empd);exit; 
                                        $this->db->select("*");
            $this->db->from("emp_itr");
			$this->db->where("itr_client",$this->session->userdata("userid"));  
            $this->db->where("itr_emp",$empd->emp_id);
			$this->db->where("itr_yr",str_replace("_","-",$fnyr));
            $chk=$this->db->get();
            //echo $chk->num_rows();exit; 
            if($chk->num_rows()>0){
                $other=$chk->row_array();
           
          //  exit;
            ?>
                                        <div class="section-title table-responsive" id="tablediv">Income Details</div>
                                   


<table class="table table-bordered align-middle table-nowrap mb-0 table-responsive">
            <tr>
                <th>Particulars</th>
                <th>Bill Unit - <?php echo $empd->emp_bill;?></th>
                <th style="text-align:right;">Amount</th>
            </tr>
            <tr>
                <td colspan="2">Type of Tax Regime</td>
                <td style="text-align:right;">New</td>
            </tr>
            <tr>
                <td colspan="2">Income From Salary Head <br/>(Salary, Allowances, Arriar, Including CSP Employer contribution)</td>              
                <td style="text-align:right;"> <?php  
                                      $admin = $this->db->get("admin")->row();
	                                  $this->db->select_sum('dt_dues');  
                                      if($empd->emp_client!=$this->session->userdata("userid")){
					$this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
                                      }
									  $this->db->where("dt_emp_id",$empd->emp_id); 
									  $this->db->where("dt_fnyr",$fnyr);
$this->db->where("dt_type!=",'PayArear'); 
									  $lll=$this->db->get('emp_data')->row();
									  echo $lll->dt_dues;
                                       ?></td>
            </tr>

            <tr>
                <td colspan="2">Less-Standard Deduction (u/s Section-19)</td>
                <td style="text-align:right;"><?php echo $admin->stn_ded;?></td>
            </tr>

            <tr>
                <td colspan="2">Net Income From Salary Head</td>
                <td style="text-align:right;"><?php echo $total_dues-$admin->stn_ded;?></td>
            </tr>
        
            <tr>
                <td colspan="2">House Property Type (Self Occupied Or Rented)</td>
                <td style="text-align:right;"><?php echo $other['house_status'];?></td>
            </tr>

            <tr>
                <td colspan="2">If House Property (Net Annual Value)</td>
                <td style="text-align:right;"><?php if($other['income_house']){echo $other['income_house'];}else{echo 0;}?></td>
            </tr>

            <tr>
                <td colspan="2">Less - Exemptions u/s 22 (30%)</td>
                <td style="text-align:right;"><?php if($other['income_house']){echo $other['less'];}else{echo 0;}?></td>
            </tr>            
            <tr>
                <td colspan="2">Add - Net Income From House Property</td>
                <td style="text-align:right;"><?php if($other['income_house']){echo $other['income_house']-$other['less'];}else{echo 0;}?></td>
            </tr>
            <tr>
                <td colspan="2">Exemptions u/s 22 (Home Loan Interest)</td>
                <td style="text-align:right;"><?php if($other['home_loan_int']){echo $other['home_loan_int'];}else{echo 0;}?></td>
            </tr>
            <tr>
                <td colspan="2">Add - Net Income From House Property Head</td>
                <td style="text-align:right;"><?php echo $other['net_hincome'];?></td>
            </tr>

            <tr>
                <td colspan="2">Add-Income From Other Sources</td>
                <td style="text-align:right;"><?php echo $other['other_sources'];?></td>
            </tr>

            <tr>
                <td colspan="2"><strong>Gross Total Income</strong></td>
                <td style="text-align:right;"><strong><?php echo $other['gross_total'];?></strong></td>
            </tr>

        </table>

        <div class="section-title text-danger">Deductions</div>
        <table>
            <tr>
                <th>Deduction Type</th>
                <th>Section</th>
                <th style="text-align:right;">Amount</th>
            </tr>
            
            <tr>
                <td>Deductions u/s 124<br/> (Employer's Contr. To Pension Scheme Of Central Govt. (NPS))</td>
                <td>Sec.124</td>
                <td style="text-align:right;"><?php echo $other['nps_80ccd2'];?></td>
            </tr>
            <tr>
                <td>Deductions u/s 125 <br/>(Agniveer Corpus Fund Received or Deposit)</td>
                <td>Sec.125</td>
                <td style="text-align:right;"><?php echo $other['agniveer_80cch2'];?></td>
            </tr>
            
            <tr class="total-row">
                <td><strong>Total Deductions/Benefits</strong></td>
                <td></td>
                <td style="text-align:right;"><strong><?php echo $other['nps_80ccd2']+$other['agniveer_80cch2'];?></strong></td>
            </tr>
            <tr class="total-row">
                <td><strong>Taxable Income (Tax payable on this income)</strong></td>
                <td></td>
                <td style="text-align:right;"><strong><?php echo $other['taxable'];?></strong></td>
            </tr>
        </table>

        <div class="section-title text-primary">Tax Calculation</div>
        <table>
            <tr>
                <th>Tax Slab</th>
                <th>Taxable Amount</th>
                <th>Tax Rate</th>
                <th style="text-align:right;">Tax Amount</th>
            </tr>
            <?php $i=0; 
            
            $slabs=explode("|",$other['slabs']);
            $slab_income=explode("|",$other['slab_income']);
            $rates=explode("|",$other['rates']);
            $slab_tax=explode("|",$other['slab_tax']);
            foreach($slabs as $slab){?>
            <tr>
                <td><?php echo $slab;?></td>
                <td><?php echo $slab_income[$i];?></td>
                <td><?php echo $rates[$i];?></td>
                <td style="text-align:right;"><?php echo $slab_tax[$i];?></td>
            </tr>
            <?php $i++;}?>
            
            <tr class="total-row">
                <td colspan="3"><strong>Tax on Total Income</strong></td>
                
                <td style="text-align:right;"><strong><?php echo $other['totalTax'];?></strong></td>
            </tr>
            <tr>
                <td colspan="3">Relief u/s Section 125</td>
                <td style="text-align:right;"><?php echo $other['rebate87A'];?></td>
            </tr>
            <tr>
                <td colspan="3">Tax after Marginal Relief of Section 156</td>
                <td style="text-align:right;"><?php echo $tot=$other['totalTax']-$other['rebate87A'];?></td>
            </tr>
            <tr>
                <td colspan="3">Surcharge </td>
                <td style="text-align:right;"><?php echo $other['surcharge'];?></td>
            </tr>
            <tr>
                <td colspan="3">Tax With Surcharge </td>
                <td style="text-align:right;"><?php echo $tot+$other['surcharge'];?></td>
            </tr>
            <tr>
                <td colspan="3">Education Cess (4%)</td>
                <td style="text-align:right;"><?php echo $other['cess'];?></td>
            </tr>
            <tr class="total-row">
                <td colspan="3"><strong>Tax with Cess</strong></td>
                <td style="text-align:right;"><strong><?php echo $tot=$tot+$other['surcharge']+$other['cess'];?></strong></td>
            </tr>
            <tr>
                <td colspan="3">Advance Tax Paid</td>
                <td style="text-align:right;"><?php echo $other['advanceTax'];?></td>
            </tr>
            <tr>
                <td colspan="3">Tax After Advance Tax Paid</td>
                <td style="text-align:right;"><?php echo $tot=$tot-$other['advanceTax'];?></td>
            </tr>            
            <tr>
                <td colspan="3">Rebate u/s Section 158	</td>
                <td style="text-align:right;"><?php echo $other['rebate_89'];?></td>
            </tr>
            <tr>
                <td colspan="3">Tax After Rebate u/s Section 158</td>
                <td style="text-align:right;"><?php echo $tot=$tot-$other['rebate_89'];?></td>
            </tr>
            <tr class="total-row">
                <td colspan="3">Total Tax Liability <strong>(<?php echo $other['paytype'];?>)</strong></td>
                <td style="text-align:right;"><strong><?php echo $other['finalTaxLiability'];?></strong></td>
            </tr>
        </table>

        <input type="hidden" name="empid" value="<?php echo $empd->emp_id.'-'.$fnyr;?>" />
<a target="_blank" href="<?php echo base_url().'admin/itr_pdf?empid='.$empd->emp_id.'-'.$fnyr;?>" class="btn btn-danger btn-sm">GENERATE PDF</a>

<?php }else{echo "<h1>ITR Not Generated Yet";}?>
</div>

<div class="tab-pane active" id="product1" role="tabpanel">
<form action="<?php echo base_url().'admin/itr_pdf';?>" method="post">
    <div class="row">
	<div class="col-4">
        <table class="table table-bordered">
            <tbody>
<tr><th colspan="2" class="text-warning">DUES</th></tr>
<tr><th>Basic</th><th><?php 
$this->db->select_sum('dt_basic');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $dt_basic=$lll->dt_basic; ?></th></tr>

<tr><th>DA</th><th><?php  
$this->db->select_sum('dt_da');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $dt_da=$lll->dt_da;?></th></tr>

<tr><th>HOUSE ALLOW</th><th><?php 
$this->db->select_sum('dt_house');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
$this->db->where("dt_type!=",'PayArear'); 
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$lll=$this->db->get('emp_data')->row();
echo $total_dues=$lll->dt_house;?></th></tr>

<tr><th>CITY COMP ALLOW.</th><th><?php //echo $empd->dt_city;
$this->db->select_sum('dt_city');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $total_dues=$lll->dt_city;?></th></tr>

<tr><th>WASHING ALLOW.</th><th><?php // echo $empd->dt_wash;
$this->db->select_sum('dt_wash');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $total_dues=$lll->dt_wash;?></th></tr>






<tr><th>MEDICAL</th><th><?php //echo $empd->dt_medical;
$this->db->select_sum('dt_medical');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $total_dues=$lll->dt_medical;?></th></tr>

<tr><th>OTHER</th><th><?php // echo $empd->other;
$this->db->select_sum('dt_other');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $total_dues=$lll->dt_other;?></th></tr>

<?php //exit;?>
<tr><th>FIX TRAVEL ALLOWANCE</th><th><?php //echo $empd->dt_fix_ta;
$this->db->select_sum('dt_fix_ta');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $total_dues=$lll->dt_fix_ta;?></th></tr>


<tr style="background:#2ecc71;"><th>TOTAL DUES</th><th><?php //echo $empd->dt_dues;
$this->db->select_sum('dt_dues');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $total_dues=$lll->dt_dues;?></th></tr>

<tr><th colspan="2" class="text-danger">DEDUCTIONS</th></tr>

<tr><th>HOUSE RENT</th><th><?php //echo $empd->dt_hre_recv;
$this->db->select_sum('dt_hre_recv');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $total_dues=$lll->dt_hre_recv;?></th></tr>

<tr><th>WATER CHARGES</th><th><?php //echo $empd->dt_water;
$this->db->select_sum('dt_water');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $total_dues=$lll->dt_water;?></th></tr>

<tr><th>GPF SUBS</th><th><?php //echo $empd->dt_gpf;
$this->db->select_sum('dt_gpf');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $total_dues=$lll->dt_gpf;?></th></tr>


<tr><th>GPF REC</th><th><?php //echo $empd->dt_gpf_recv;
$this->db->select_sum('dt_gpf_recv');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $total_dues=$lll->dt_gpf_recv;?></th></tr>

<tr><th>FESTIVAL</th><th><?php //echo $empd->dt_fest;
$this->db->select_sum('dt_fest');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $total_dues=$lll->dt_fest;?></th></tr>

<tr><th>GIS</th><th><?php //echo $empd->dt_gis;
$this->db->select_sum('dt_gis');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $total_dues=$lll->dt_gis;?></th></tr>

<tr><th>INCOME TAX</th><th><?php echo $empd->emp_id.'<br/>';
$this->db->select_sum('dt_tax');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $total_adv=$lll->dt_tax;?></th></tr>

<tr><th>TOTAL DED</th><th><?php //echo $empd->dt_ded;
$this->db->select_sum('dt_ded');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $total_dues=$lll->dt_ded;?></th></tr>

<tr><th class="text-info">NET SALARY</th><th><?php //echo $empd->dt_net_salary;
$this->db->select_sum('dt_net_salary');  
$this->db->where("dt_emp_id",$empd->emp_id); 
$this->db->where("dt_fnyr",$fnyr);
if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
$this->db->where("dt_type!=",'PayArear'); 
$lll=$this->db->get('emp_data')->row();
echo $total_dues=$lll->dt_net_salary;?></th></tr>
</tbody>
</table>

</div>

<div class="col-8">
<h4>Tax Computation</h4>
<table class="table table-bordered">
            <tbody>

<tr><th>Tax Regime Type</th><th><?php echo $empd->emp_tax;?></th></tr>
<tr><th>Annual Salary</th><th>
    <?php $admin = $this->db->get("admin")->row();
	$this->db->select_sum('dt_dues');  
    $this->db->where("dt_emp_id",$empd->emp_id); 
    $this->db->where("dt_fnyr",$fnyr);
    if($empd->emp_client!=$this->session->userdata("userid")){
        $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
    }
    $this->db->where("dt_type!=",'PayArear'); 
    $lll=$this->db->get('emp_data')->row();
    echo $total_dues=$lll->dt_dues; ?></th></tr><tr>
                                     

<input type="hidden" id="sal_head" name="sal_head" value="<?php echo $total_dues;?>"/>
<input type="hidden" id="less_stn_ded" name="less_stn_ded" value="<?php echo $stn_ded;?>"/>
									 
<tr><th>Standard Deduction</th><th class="text-danger"><?php echo $admin->stn_ded;?></th></tr>
<tr><th>Net Income From Salary Head</th><th  id="net_sal_head"><?php echo $total_dues-$admin->stn_ded;?><th></tr>


<!-- <tr><th>GPF/CPS Type</th>
<th><?php 
// if($empd->emp_gpf=='GPF'){
// echo 'GPF <b  class="text-success">'.$empd->emp_gpf.'</b><br/>CPS1 0 <br/>CPS2 0';
// }
// else{
// 	$this->db->select_sum('dt_basic');  
// 									  $this->db->where("dt_emp_id",$empd->emp_id); 
// 									  $this->db->where("dt_fnyr",$fnyr);
$this->db->where("dt_type!=",'PayArear'); 
// 									  $lll=$this->db->get('emp_data')->row();
// 									  $dt_basic=$lll->dt_basic;
// 									  $this->db->select_sum('dt_da');  
// 									  $this->db->where("dt_emp_id",$empd->emp_id); 
// 									  $this->db->where("dt_fnyr",$fnyr);
$this->db->where("dt_type!=",'PayArear'); 
// 									  $lll=$this->db->get('emp_data')->row();
// 									  $dt_da=$lll->dt_da;
// 									  $totc=$dt_basic+$dt_da;
// 	$cps=$totc*10/100;
// 	echo 'GPF 0<br/>CPS1 <b class="text-success">'.$cps.'</b><br/>CPS2 <b  class="text-success">'.$cps.'</b>';
// }
	?></th></tr>

<tr><th>Rent Paid</th><th><input type="number"  id="rent" name="rent"/><th></tr> -->

<tr><th>House Property Type</th><th><select id="house_status" name="house_status">
<option value="Self">Self Occupied</option>
<option value="Rent">Let Out (Rented)</option>
</select><th></tr>
<tr><th>Income From House Property</th><th><input type="number"  disabled id="income_house" name="income_house"/>
<th></tr>
<tr><th>Less-Standard Deduction@30%</th><th  id="less">0<th></tr>
<tr><th>Net Income From Home Property</th><th  id="net_hincome0"><th></tr>
<tr><th>Interest Payment of Home Loan</th><th><input type="number" value="0"  id="home_loan_int" disabled name="home_loan_int"/><br/>
<small  class="text-danger">Max 200000</small><th></tr>

<tr><th>Net Income From Home Property Head</th><th  id="net_hincome"><th></tr>
<?php if($total_dues>=$admin->stn_ded){
		$less=$admin->stn_ded;
	}else{
		$less=$total_dues;
	}?>
<input type="hidden" id="lesss" name="less" value="<?php echo $less;?>"/>
<input type="hidden"  name="itr_client" value="<?php echo $this->session->userdata("userid");?>"/>
<input type="hidden" id="net_hincomee" name="net_hincome"/>
<tr><th>Net Income From Other Sources</th><th><input type="number"  id="other_sources" name="other_sources"/><th></tr>

<tr><th>Gross Total Income</th><th id="gross_total"><th></tr>
<input type="hidden"  id="gross_totall" name="gross_total"/>
<tr><th>Deduction u/s 124 <br/><small> Employer’s NPS Contribution</small></th>

<input type="hidden" value="<?php if($empd->emp_gpf=='CPS'){$totc=$dt_basic+$dt_da;echo $cps=$totc*10/100;} else{echo 0;}?>" name="nps_80ccd2"/>
<th id="nps_80ccd2"><?php  if($empd->emp_gpf=='CPS'){$totc=$dt_basic+$dt_da;echo $cps=$totc*10/100;}
 else{echo 0;}?></th></tr>
<tr><th>Deduction u/s 125 <br/><small>  Agniveer Corpus Fund</small></th>
<th><input type="number" id="agniveer_80cch2" name="agniveer_80cch2" value="0"/></th></tr>
<tr><th>Taxable Income</th><th id="taxable"><th></tr>
<input type="hidden" id="taxablee" name="taxable"/>
</tbody>
</table>
<hr/>
<h5 class="mt-3 text-success">Tax Computation Summary</h5>
<table class="table table-bordered" id="tax_summary_table">
  <thead class="table-info">
    <tr>
      <th>Slab Income Range</th>
      <th>Taxable Amount</th>
      <th>Tax Rate %</th>
      <th>Tax Amount</th>
    </tr>
  </thead>
  <tbody id="tax_summary_body">
  </tbody>
</table>
<!-- 
<div class="text-center my-3">
  <button class="btn btn-primary" id="calculate_tax_btn">Calculate Tax</button>
</div>

<table class="table table-bordered">
  <tbody>
    <tr><th>Total Tax Payable</th><th id="tax_payable"></th></tr>
  </tbody>
</table> -->
</div>
</div>


<script>
$(document).ready(function () {

    $("#calculate_tax_btn").click(function () {
    var gross = parseInt($("#gross_total").text()) || 0;
    var nps =parseInt($("#nps_80ccd2").text()) || 0;
   // alert(nps)
    var agniveer =parseInt($("#agniveer_80cch2").val()) || 0;

    var taxable = gross - (nps + agniveer);
    $("#taxable").text(taxable);
    $("#taxablee").val(taxable);
    calculateTax(); 
    });
    function calculateTax() {
    var income = parseInt($("#taxable").text()) || 0;
    var tax = 0;

    if (income > 2400000) {
        tax += (income - 2400000) * 0.30;
        income = 2400000;
    }
    if (income > 2000000) {
        tax += (income - 2000000) * 0.25;
        income = 2000000;
    }
    if (income > 1600000) {
        tax += (income - 1600000) * 0.20;
        income = 1600000;
    }
    if (income > 1200000) {
        tax += (income - 1200000) * 0.15;
        income = 1200000;
    }
    if (income > 800000) {
        tax += (income - 800000) * 0.10;
        income = 800000;
    }
    if (income > 400000) {
        tax += (income - 400000) * 0.05;
        income = 400000;
    }

    $("#tax_payable").text(Math.round(tax));
}









    ////////////////////////////////////











    function calculateGrossTotal() {
    // Get and parse values
    var salary = parseInt($("#net_sal_head").text()) || 0;
    var homeIncome = parseInt($("#net_hincome").text()) || 0;
    var otherSources = parseInt($("#other_sources").val()) || 0;

    var grossTotal = salary + homeIncome + otherSources;
    $("#gross_total").text(grossTotal);
    $("#gross_totall").val(grossTotal);

    calculateTaxableIncome(); // 🔄 Call here
}

$('#agniveer_80cch2').keyup(function () {
    calculateTaxableIncome();
});


$('#income_house, #home_loan_int').keyup(function () {
    if($('#house_status').val()=='Rent'){
        var tot = parseInt($('#income_house').val()) - (parseInt($("#less").text()) + parseInt($("#home_loan_int").val()));
       
        $("#net_hincome").text(tot < 0 ? 0 : tot);
        $("#net_hincomee").val(tot < 0 ? 0 : tot);


        calculateGrossTotal();
    }        
});

$('#other_sources').keyup(function () {
    calculateGrossTotal();
});

$('#house_status').change(function () {
    var v = $(this).val();
    if(v=='Rent'){
        $("#home_loan_int").attr('disabled', false);
        $("#income_house").attr('disabled', false);
    } else {
        $("#home_loan_int").val(0).attr('disabled', true);
        $("#income_house").val(0).attr('disabled', true);
        $("#net_hincome").text(0);
        $("#net_hincomee").val(0);
        $("#less").text(0);
        $("#lesss").val(0);
        $("#income_house").val(0);
    }
    calculateGrossTotal();
});

// Run on load to initialize values
calculateGrossTotal();
$('#income_house').keyup(function () {
    // Get rent value
    var v = $(this).val();

    // Calculate 30% deduction and round to nearest integer
    var exemp = Math.round(v * 0.30);
    $("#less").text(exemp);
    $("#lesss").val(exemp);
    
    if($('#house_status').val()=='Rent'){
        var tot = parseInt($('#income_house').val()) - (exemp + parseInt($("#home_loan_int").val()));
        $("#net_hincome").text(tot < 0 ? 0 : tot);
        $("#net_hincomee").val(tot < 0 ? 0 : tot);

        var tot0 = parseInt($('#income_house').val()) - exemp;
        $("#net_hincome0").text(tot0);
    }  calculateTaxableIncome();
});
    $('#house_status').change(function () {
        var v = $(this).val();
        if(v=='Rent'){
           $("#home_loan_int").attr('disabled',false);
        }else{
           $("#home_loan_int").val(0);
           $("#home_loan_int").attr('disabled',true);
           $("#net_hincome").text(0);
           $("#net_hincomee").val(0);
           $("#net_hincome0").text(0);
        }
    });


// Add event listeners for the new fields
$('#nps_80ccd2, #agniveer_80cch2').keyup(function() {
    calculateTaxableIncome();
});

    
function calculateTaxableIncome() {
    let netSalary = parseInt($('#net_sal_head').text()) || 0;
    let grossHouseIncome = parseInt($('#income_house').val()) || 0;
    const focusedElement = document.activeElement;
    const isRebateInputFocused = focusedElement && focusedElement.id === 'rebate_89_input';
    const cursorPosition = isRebateInputFocused ? focusedElement.selectionStart : null;
    
    let interestPaidRaw = parseInt($('#home_loan_int').val()) || 0;
    if (interestPaidRaw > 200000) {
        alert("Interest Payment of Home Loan cannot exceed ₹2,00,000.");
        $('#home_loan_int').val(200000);
        interestPaidRaw = 200000;
    }
    let interestPaid = interestPaidRaw;

    let otherSources = parseInt($('#other_sources').val()) || 0;

    // Step 3: Standard deduction @30%
    let stdDeduction = Math.round(grossHouseIncome * 0.3);
    $("#less").text(stdDeduction);
   // $("#lesss").val(stdDeduction);

    // Step 4: Net income from house property
    let netHouseIncome = grossHouseIncome - stdDeduction;

    // Step 5: Allowed interest (min of netHouseIncome or ₹2,00,000)
    let allowedInterest = Math.min(Math.abs(netHouseIncome), 200000, interestPaid);

    // Step 6: Net income from house property head
    let netHouseIncomeHead = netHouseIncome - allowedInterest;
    $("#net_hincome").text(netHouseIncomeHead < 0 ? 0 : netHouseIncomeHead);
    $("#net_hincomee").val(netHouseIncomeHead < 0 ? 0 : netHouseIncomeHead);

    // Gross total income
    let grossTotalIncome = netSalary + netHouseIncomeHead + otherSources;

    // Get deductions
    let nps = parseInt($('#nps_80ccd2').text()) || 0; // Employer's NPS Contribution u/s 80CCD(2)
    let agniveer = parseInt($('#agniveer_80cch2').val()) || 0;
    let deductions = nps + agniveer;

    // Validate NPS deduction (max 10% of salary)
    let maxNPS = Math.round(netSalary * 0.10);
    //if (nps > maxNPS) {
    //    alert(`Employer's NPS Contribution u/s 80CCD(2) cannot exceed 10% of salary (Max: ₹${maxNPS})`);
    //   $('#nps_80ccd2').text(maxNPS);
    //    nps = maxNPS;
    //}

    let taxableIncome = grossTotalIncome - deductions;
    if (taxableIncome < 0) taxableIncome = 0;

    // Update the taxable field
    $("#taxable").text(taxableIncome);
    $("#taxablee").val(taxableIncome);

    // Rest of your tax calculation code remains the same...
    let slabs = [
        { from: 0, to: 400000, rate: 0 },
        { from: 400000, to: 800000, rate: 5 },
        { from: 800000, to: 1200000, rate: 10 },
        { from: 1200000, to: 1600000, rate: 15 },
        { from: 1600000, to: 2000000, rate: 20 },
        { from: 2000000, to: 2400000, rate: 25 },
        { from: 2400000, to: Infinity, rate: 30 },
    ];

    let remaining = taxableIncome;
    let totalTax = 0;
    let tableRows = "";

    for (let slab of slabs) {
        if (remaining <= 0) break;
        let slabStart = slab.from;
        let slabEnd = Math.min(slab.to, taxableIncome);
        let slabIncome = Math.max(0, slabEnd - slabStart);
        let slabTax = (slabIncome * slab.rate) / 100;
        totalTax += slabTax;
        

        if (slabIncome > 0) {
            tableRows += `<tr>
                <td>₹${(slabStart / 100000).toFixed()}L - ₹${slab.to === Infinity ? '∞' : (slab.to / 100000).toFixed() + 'L'}</td>
                <td>₹${slabIncome.toLocaleString()}</td>
                <td>${slab.rate}%</td>
                <td>₹${slabTax.toFixed()}</td>
                <input type="hidden" name="slabs[]" value="${(slabStart / 100000).toFixed()}L - ${slab.to === Infinity ? '∞' : (slab.to / 100000).toFixed() + 'L'}"/>
                <input type="hidden" name="rates[]" value="${slab.rate}%"/>
                <input type="hidden" name="slab_income[]" value="${slabIncome.toLocaleString()}"/>
                <input type="hidden" name="slab_tax[]" value="${slabTax.toFixed()}"/>
            </tr>`;
        }
        remaining -= slabIncome;
    }
    tableRows += `<input type="hidden" name="totalTax" value="${totalTax.toFixed()}"/><tr class="table-warning"><th colspan="3">Tax On Total Income</th><th>₹${totalTax.toFixed()}</th></tr>`;

    // Rebate under Section 87A
let rebate87A = 0;
let marginalRelief = 0;
let taxAfterRebate = totalTax;

// Apply Rebate u/s 87A if applicable (for income up to ₹12L under new regime)
if (taxableIncome <= 1200000 && totalTax <= 60000) {
    rebate87A = totalTax;
    taxAfterRebate = 0;
    
    // Add row for Rebate u/s 87A
    tableRows += `<tr>
        <td colspan="3">Rebate u/s 156</td>
        <td>₹${rebate87A.toFixed()}</td>
        <input type="hidden" name="rebate87A" value="${rebate87A.toFixed()}"/>
    </tr>`;
    
    // Add row for Tax After Rebate u/s 87A
    tableRows += `<tr>
        <th colspan="3">Tax After Rebate u/s 156</th>
        <th>₹${taxAfterRebate.toFixed()}</th>
    </tr>`;
} else {
    // No rebate applicable
    tableRows += `<tr>
        <td colspan="3">Rebate u/s 156</td>
        <td>₹0</td>
        <input type="hidden" name="rebate87A" value="0"/>
    </tr>`;
    
    tableRows += `<tr>
        <th colspan="3">Tax After Rebate u/s 156</th>
        <th>₹${taxAfterRebate.toFixed()}</th>
    </tr>`;
}

// Apply Marginal Relief for income between ₹12L and ₹12.75L (or up to ₹12.45588L as per your condition)
let taxAfterMarginalRelief = taxAfterRebate;

if (taxableIncome > 1200000 && taxableIncome <= 1275000 && taxAfterRebate > 0) {
    let excess = taxableIncome - 1200000;
    let marginalReliefAmount = Math.max(0, taxAfterRebate - excess);
    
    if (marginalReliefAmount > 0) {
        marginalRelief = marginalReliefAmount;
        taxAfterMarginalRelief = taxAfterRebate - marginalRelief;
        
        // Add row for Marginal Relief
        tableRows += `<tr>
            <td colspan="3">Marginal Relief</td>
            <td>₹${marginalRelief.toFixed()}</td>
        </tr>`;
    } else {
        // No marginal relief applicable
        tableRows += `<tr>
            <td colspan="3">Marginal Relief</td>
            <td>₹0</td>
        </tr>`;
    }
} else {
    // Not in marginal relief range or tax is already zero
    tableRows += `<tr>
        <td colspan="3">Marginal Relief</td>
        <td>₹0</td>
    </tr>`;
}

// Final Tax After Marginal Relief
totalTax = taxAfterMarginalRelief;
tableRows += `<tr class="table-info">
    <th colspan="3">Tax After Marginal Relief</th>
    <th>₹${totalTax.toFixed()}</th>
</tr>`;

    // Surcharge (10% if tax >= ₹50L)
    let surcharge = 0;
    if (taxableIncome >= 5000000) {
        surcharge = totalTax * 0.1;
    }
    tableRows += `<tr>
        <td colspan="3">Surcharge (${taxableIncome >= 5000000 ? '10%' : '0%'})</td>
        <td>₹${surcharge.toFixed()}</td><input type="hidden" name="surcharge" value="${surcharge.toFixed()}"/>
    </tr>`;
    //totalTax += surcharge;

      // Add new row for Tax With Surcharge
      let taxWithSurcharge = totalTax + surcharge;
    tableRows += `<tr class="table-info">
        <th colspan="3">Tax With Surcharge</th>
        <th>₹${taxWithSurcharge.toFixed()}</th>
    </tr>`;


    totalTax = taxWithSurcharge;
    // Education Cess @4%
    let cess = Math.round(totalTax * 0.04);
    totalTax += parseInt(cess);

    tableRows += `<tr><td colspan="3">Education Cess (4%)</td><td>₹${cess.toFixed()}</td><input type="hidden" name="cess" value="${cess.toFixed()}"/></tr>`;

    let taxWithCess = totalTax ;//+ cess;
    tableRows += `<tr class="table-info">
        <th colspan="3">Tax With Cess</th>
        <th>₹${totalTax.toFixed()} </th>
    </tr>`;

    totalTax = taxWithCess; 

    // Advance tax & Section 158
    let advanceTax = parseInt(<?php echo $total_adv;?>) || 0;

    
   // alert(rebate89)
    tableRows += `<tr><td colspan="3">Less: Advance Tax Paid</td><td>₹${advanceTax}</td><input type="hidden" name="advanceTax" value="${advanceTax}"/></tr>`;

    let taxAfterAdvance = totalTax - advanceTax;
    tableRows += `<tr class="table-info">
        <th colspan="3">Tax After Advance Tax Paid</th>
        <th>₹${taxAfterAdvance.toFixed()}</th>
    </tr>`;

 let currentRebate89 = parseFloat($('#rebate_89_input').val()) || 0;
    let taxAfterRebate89 = taxAfterAdvance - currentRebate89;
    if(taxAfterAdvance>0){
    tableRows += `<tr>
        <td colspan="3">Rebate u/s 158</td>
        <td>
            ₹<input type="number" id="rebate_89_input" name="rebate_89" value="${currentRebate89.toFixed()}"  style="width: 80px; text-align: right">
        </td>
    </tr>`;

    // Calculate Tax After Rebate (allowing negative values)
    tableRows += `<tr class="table-info">
        <th colspan="3">Tax After Rebate u/s 158</th>
        <th>₹${taxAfterRebate89.toFixed()}</th>
    </tr>`;
}
    // Final Tax Liability (can be negative for refund)
    let finalTaxLiability = Math.round(taxAfterRebate89.toFixed());
    let status = '';
    if(finalTaxLiability>0){status='Payable';}
    if(finalTaxLiability<0){status='Refundable';}
    if(finalTaxLiability==0){status='Nil';}
  
    tableRows += `<tr><th colspan="3">Total Tax Liability (${status})</th><th>₹${Math.abs(finalTaxLiability)}</th><input type="hidden" name="finalTaxLiability" value="${Math.abs(finalTaxLiability)}"/><input type="hidden" name="paytype" value="${finalTaxLiability > 0 ? 'Payable' : (finalTaxLiability < 0 ? 'Refundable' : 'Nil')}"/></tr>`;
    
    // Update display
    $("#tax_summary_body").html(tableRows);
    $("#gross_total").text(grossTotalIncome);
    $("#gross_totall").val(grossTotalIncome);
    $("#taxable").text(taxableIncome);
    $("#taxablee").val(taxableIncome);
    $("#tax_payable").text(Math.round(totalTax));
    
    // Add event listener to the dynamically created input
    $('#rebate_89_input').off('input').on('input', function() {
        calculateTaxableIncome();
    });

    if (isRebateInputFocused) {
        const rebateInput = document.getElementById('rebate_89_input');
        rebateInput.focus();
        
        // Restore cursor position
        if (cursorPosition !== null) {
            rebateInput.setSelectionRange(cursorPosition, cursorPosition);
        }
    }
}
    
    $('#home_loan_int').keyup(function () {
        // Get rent value
        if($('#house_status').val()=='Rent'){
        var tot = parseInt($('#income_house').val())-(parseInt($("#less").text())+parseInt($(this).val()));
        $("#net_hincome").text(tot < 0 ? 0 : tot);
        $("#net_hincomee").val(tot < 0 ? 0 : tot);

        }        
    });
    $('#rebate_89').on('input', function() {
    calculateTaxableIncome();
    });
});
</script>
<input type="hidden" name="empid" value="<?php echo $empd->emp_id.'-'.$fnyr;?>" />
<button type="submit" class="btn btn-danger btn-sm">SUBMIT & SAVE</button>
</form>
</div>
</div>