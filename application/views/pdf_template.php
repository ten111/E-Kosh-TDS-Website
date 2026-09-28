<style>
    body {
        margin: 0;
        padding: 0;
        font-size: 10px;
    }

    .container {
        max-width: 1000px;
        margin: 0;
        padding: 2px;
    }

    .header {
        text-align: center;
        margin-bottom: 2px;
        padding-bottom: 2px;
        border-bottom: 1px solid #ddd;
    }

    .header h1 {
        color: #2c3e50;
        margin: 2px 0;
        font-size: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 5px;
        font-size: 9px;
    }

    table th {
        background-color: #f1f1f1;
        color: #333;
        font-weight: 600;
        text-align: left;
        padding: 5px;
        border: 1px solid #ddd;
    }

    table td th {
        padding: 5px;
        border: 1px solid #ddd;
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .salary-table th,
    .salary-table td {
        padding: 5px;
        font-size: 6px;
    }

    .total-row {
        font-weight: bold;
        background-color: #f1f1f1 !important;
    }

    .footer {
        text-align: center;
        padding-top: 100px;
        margin-top: 100px;
        border-top: 1px solid #ddd;
        font-size: 10px;
        color: #666;
    }

    .section-title {
        padding: 2px;
        background-color: #f1f1f1;
        margin: 2px 0;
        border-left: 2px solid #2c3e50;
        font-weight: 600;
        color: #2c3e50;
        font-size: 12px;
    }

    .compact-row {
        margin: 5px 0;
    }

    /* Signature section spacing */
    .signature-section {
        margin-top: 80px;
        padding-top: 50px;
        border-top: 2px solid #ddd;
    }

    .signature-box {
        padding: 30px 20px;
        min-height: 150px;
    }

    .signature-box table {
        border: none !important;
    }

    .signature-box table th {
        border: none !important;
        background: #fff !important;
        padding: 20px 10px;
    }

    .signature-box img {
        width: 100px;
        height: auto;
        display: block;
        margin: 0 auto;
    }

    .signature-label {
        font-size: 11px;
        font-weight: 600;
        margin-top: 10px;
        color: #333;
    }

    /* Page break for annual salary sheet */
    .page-break {
        page-break-before: always;
        margin-top: 50px;
        padding-top: 30px;
        border-top: 3px double #ccc;
    }

    .page-break-label {
        text-align: center;
        font-size: 9px;
        color: #999;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    /* Annual salary sheet header */
    .annual-salary-header {
        margin-top: 30px;
        padding-top: 20px;
    }

    .annual-salary-header h1 {
        text-align: center;
        color: #2c3e50;
        margin: 10px 0 5px 0;
        font-size: 18px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .annual-salary-header p {
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        color: #555;
        margin-bottom: 15px;
    }

    /* Employee info in annual sheet */
    .annual-employee-info {
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .annual-employee-info table {
        font-size: 9px;
    }

    .annual-employee-info table th {
        background-color: #f5f5f5;
        padding: 4px 8px;
    }

    /* Print-specific styles */
    @media print {
        .page-break {
            page-break-before: always;
            border-top: none;
            margin-top: 0;
            padding-top: 0;
        }

        .page-break-label {
            display: none;
        }

        .signature-section {
            margin-top: 100px;
            padding-top: 60px;
        }

        .signature-box {
            min-height: 200px;
            padding: 40px 20px;
        }

        .signature-box img {
            width: 120px;
        }

        body {
            font-size: 10px;
        }

        .annual-salary-header {
            margin-top: 10px;
        }

        .annual-salary-header h1 {
            font-size: 16px;
        }
    }

    /* Footer with proper spacing */
    .footer-signature {
        margin-top: 150px;
        padding-top: 80px;
        border-top: 2px solid #ddd;
    }

    .footer-signature table {
        border: none;
    }

    .footer-signature table th {
        border: none;
        background: #fff;
        padding: 30px 10px;
        vertical-align: bottom;
    }

    .footer-signature img {
        width: 100px;
        height: auto;
        margin-bottom: 10px;
    }
</style>

<!-- ============================================================ -->
<!-- PAGE 1 - INCOME TAX COMPUTATION -->
<!-- ============================================================ -->

<p style="font-size:12px; margin:2px 0;text-align:center;"><b>Income Tax Computation Sheet</b></p>
<p style="font-size:10px; margin:2px 0;text-align:center;">
    <b><?php echo ucfirst($this->session->userdata("loggeduser")) . ' (DDO- ' . $this->session->userdata("ddo_num"); ?>)</b>
</p>

<!-- Employee Info -->
<div class="school-info">
    <table>
        <?php 
            $as = explode("_", $fnyr);
            $asyr = $as[0] + 1 . '-' . $as[1] + 1;
        ?>
        <tr>
            <th>TAX YEAR:</th>
            <th colspan="3"><?php echo str_replace("_", "-", $fnyr); ?></th>
        </tr>
        <tr>
            <th>EMPLOYEE NAME</th>
            <th><b><?php echo $empd->emp_name; ?></b></th>
            <th>DESIGNATION</th>
            <th><?php echo $empd->emp_desg; ?></th>
        </tr>
        <tr>
            <th>PENSION TYPE</th>
            <th><?php echo $empd->emp_gpf; ?></th>
            <th>BILL UNIT</th>
            <th><?php echo $empd->emp_bill; ?></th>
        </tr>
        <tr>
            <th>OFFICE</th>
            <th><?php echo $empd->emp_school; ?></th>
            <th>SUB-OFFICE</th>
            <th><?php echo $empd->emp_sankul; ?></th>
        </tr>
        <tr>
            <th>PAN:</th>
            <th><?php echo $empd->emp_pan; ?></th>
            <th>EMPLOYEE CODE:</th>
            <th><?php echo $empd->emp_code; ?></th>
        </tr>
    </table>
</div>

<!-- Income Details -->
<div class="section-title">Income Details</div>
<table>
    <tr>
        <th>Particulars</th>
        <th style="text-align:right;">Amount</th>
    </tr>
    <tr>
        <td>Type of Tax Regime</td>
        <td style="text-align:right;">New</td>
    </tr>
    <tr>
        <td>Income From Salary Head</td>
        <td style="text-align:right;">
            <?php echo $total_dues=$other['sal_head'];
                 $admin = $this->db->get("admin")->row();
                // $this->db->select_sum('dt_dues');
                // $this->db->where("dt_emp_id", $empd->emp_id);
                // $this->db->where("dt_fnyr", $fnyr);
                // if($empd->emp_client!=$this->session->userdata("userid")){
                //     $this->db->where("dt_sal_ddo",$this->session->userdata("userid"));  
                // }
                // $this->db->where("dt_type!=",'PayArear');
                // $lll = $this->db->get('emp_data')->row();
                // echo $total_dues = $lll->dt_dues;
            ?>
        </td>
    </tr>
    <tr>
        <td>Standard Deduction (u/s Section-19)</td>
        <td style="text-align:right;"><?php echo $admin->stn_ded; ?></td>
    </tr>
    <tr>
        <td>Net Income From Salary Head</td>
        <td style="text-align:right;"><?php echo $total_dues - $admin->stn_ded; ?></td>
    </tr>
    <tr>
        <td>House Property Type</td>
        <td style="text-align:right;">
            <?php 
                if ($other['house_status'] == 'Self') {
                    echo 'Self Occupied';
                } else {
                    echo 'Let Out (Rented)';
                }
            ?>
        </td>
    </tr>
    <tr>
        <td>Income from House Property (Net Annual Value)</td>
        <td style="text-align:right;"><?php echo $other['income_house'] ?: 0; ?></td>
    </tr>
    <tr>
        <td>Exemptions u/s 22 (30%)</td>
        <td style="text-align:right;"><?php if($other['income_house']!=0){echo $other['less'];}else{echo 0;}?></td>
    </tr>
    <tr>
        <td>Add - Net Income From House Property</td>
        <td style="text-align:right;"><?php if($other['income_house']!=0){ echo $other['income_house'] - $other['less']; }else{echo 0;}?></td>
    </tr>
    <tr>
        <td>Exemptions u/s 22 (Home Loan Interest)</td>
        <td style="text-align:right;"><?php echo $other['home_loan_int'] ?: 0; ?></td>
    </tr>
    <tr>
        <td>Add - Net Income From House Property Head</td>
        <td style="text-align:right;"><?php echo $other['net_hincome']; ?></td>
    </tr>
    <tr>
        <td>Add - Income From Other Sources</td>
        <td style="text-align:right;"><?php echo $other['other_sources']; ?></td>
    </tr>
    <tr>
        <td><strong>Gross Total Income</strong></td>
        <td style="text-align:right;"><strong><?php echo $other['gross_total']; ?></strong></td>
    </tr>
</table>

<div class="section-title">Deductions</div>
<table>
    <tr>
        <th>Deduction Type</th>
        <th>Section</th>
        <th style="text-align:right;">Amount</th>
    </tr>
    <tr>
        <td>1. Employer's Contr. To Pension Scheme Of Central Govt. (NPS)</td>
        <td>u/s Section 124</td>
        <td style="text-align:right;"><?php echo $other['nps_80ccd2']; ?></td>
    </tr>
    <tr>
        <td>2. Agniveer Corpus Fund Received or Deposit</td>
        <td>u/s Section 125</td>
        <td style="text-align:right;"><?php echo $other['agniveer_80cch2']; ?></td>
    </tr>
    <tr class="total-row">
        <td colspan="2" style="color:#fff;"><strong>Total Deductions/Benefits</strong></td>
        <td style="text-align:right;color:#fff;">
            <strong><?php echo $other['nps_80ccd2'] + $other['agniveer_80cch2']; ?></strong>
        </td>
    </tr>
    <tr class="total-row">
        <td colspan="2" style="color:#fff;"><strong>Taxable Income</strong></td>
        <td style="text-align:right;color:#fff;"><strong><?php echo $other['taxable']; ?></strong></td>
    </tr>
</table>

<div class="section-title">Tax Calculation</div>
<table>
    <tr>
        <th>Tax Slab</th>
        <th>Taxable Amount</th>
        <th>Tax Rate</th>
        <th style="text-align:right;">Tax Amount</th>
    </tr>
    <?php
        $i = 0;
        if ($other['slabs'] && strpos($other['slabs'], '|') !== false) {
            $slabs = explode("|", $other['slabs']);
            $income = explode("|", $other['slab_income']);
            $rates = explode("|", $other['rates']);
            $slab_tax = explode("|", $other['slab_tax']);
            $max = count($slabs);
            for ($i = 0; $i < $max; $i++) {
    ?>
        <tr>
            <td><?php echo $slabs[$i]; ?></td>
            <td><?php echo $income[$i]; ?></td>
            <td><?php echo $rates[$i]; ?></td>
            <td style="text-align:right;"><?php echo $slab_tax[$i]; ?></td>
        </tr>
    <?php
            }
        } else {
    ?>
        <tr>
            <td><?php echo $other['slabs']; ?></td>
            <td><?php echo $other['slab_income']; ?></td>
            <td><?php echo $other['rates']; ?></td>
            <td style="text-align:right;"><?php echo $other['slab_tax']; ?></td>
        </tr>
    <?php
            $i++;
        }
    ?>
    <tr class="total-row">
        <td colspan="3" style="color:#fff;"><strong>Tax on Total Income</strong></td>
        <td style="text-align:right;color:#fff;"><strong><?php echo $other['totalTax']; ?></strong></td>
    </tr>
    <tr>
        <td colspan="3">Relief U/S Section 156</td>
        <td style="text-align:right;"><?php echo $other['rebate87A']; ?></td>
    </tr>
    <tr>
        <td colspan="3">Tax after Marginal Relief of Sec.156</td>
        <td style="text-align:right;"><?php echo $tot = $other['totalTax'] - $other['rebate87A']; ?></td>
    </tr>
    <tr>
        <td colspan="3">Surcharge</td>
        <td style="text-align:right;"><?php echo $other['surcharge']; ?></td>
    </tr>
    <tr>
        <td colspan="3">Tax With Surcharge</td>
        <td style="text-align:right;"><?php echo $tot + $other['surcharge']; ?></td>
    </tr>
    <tr>
        <td colspan="3">Education Cess (4%)</td>
        <td style="text-align:right;"><?php echo $other['cess']; ?></td>
    </tr>
    <tr class="total-row">
        <td colspan="3" style="color:#fff;"><strong>Tax with Cess</strong></td>
        <td style="text-align:right;color:#fff;">
            <strong><?php echo $tot = $tot + $other['surcharge'] + $other['cess']; ?></strong>
        </td>
    </tr>
    <tr>
        <td colspan="3">Advance Tax Paid</td>
        <td style="text-align:right;"><?php echo $other['advanceTax']; ?></td>
    </tr>
    <tr>
        <td colspan="3">Tax After Advance Tax</td>
        <td style="text-align:right;"><?php echo $tot = $tot - $other['advanceTax']; ?></td>
    </tr>
    <tr>
        <td colspan="3">Rebate u/s SECTION 158</td>
        <td style="text-align:right;"><?php echo $other['rebate_89']; ?></td>
    </tr>
    <tr>
        <td colspan="3">Tax After Rebate u/s Section 158</td>
        <td style="text-align:right;"><?php echo $tot = $tot - $other['rebate_89']; ?></td>
    </tr>
    <tr class="total-row">
        <td colspan="3" style="color:#fff;">Total Tax Liability <strong>(<?php echo $other['paytype']; ?>)</strong></td>
        <td style="text-align:right;color:#fff;">
            <strong><?php echo $other['finalTaxLiability']; ?></strong>
        </td>
    </tr>
</table>

<!-- ============================================================ -->
<!-- SIGNATURE SECTION WITH SPACE (PAGE 1) -->
<!-- ============================================================ -->
<div class="signature-section" style="width:100%; background:#fff; margin:0; padding:0; border:none;">
    <table style="width:100%; background:#fff; border:none; border-collapse:collapse; table-layout:fixed;">
        <tbody>
            <tr style="background:#fff; border:none;">
                <!-- LEFT CELL: Employee signature (left aligned) -->
                <td style="background:#fff; text-align:left; padding:30px 20px 30px 20px; border:none; width:50%; vertical-align:bottom;">
                    <div style="min-height:120px; display:flex; flex-direction:column; justify-content:flex-end; align-items:flex-start; text-align:left;">
                        <img style="width:100px; height:auto; margin:0 0 10px 0; display:block;" 
                             src="<?php echo base_url().'assets/images/signs/user_sign.png';?>" 
                             alt="Employee Signature" />
                        <p style="margin:0; padding:0; text-align:left; font-size:9px; color:#666; width:100%;">Signature Of Employee</p>
                    </div>
                </td>

                <!-- RIGHT CELL: Authority Officer signature (right aligned) -->
                <td style="background:#fff; text-align:right; padding:30px 20px 30px 20px; border:none; width:50%; vertical-align:bottom;">
                    <div style="min-height:120px; display:flex; flex-direction:column; justify-content:flex-end; align-items:flex-end; text-align:right;">
                        <?php if($ddo->ddo_sign!=''){?>
                            <img style="width:100px; height:auto; margin:0 0 10px 0; display:block;" 
                                 src="<?php echo base_url().'assets/images/signs/'.$ddo->ddo_sign;?>" 
                                 alt="Authority Signature" />
                        <?php }else{?>
                            <img style="width:100px; height:auto; margin:0 0 10px 0; display:block;" 
                                 src="<?php echo base_url().'assets/images/signs/user_sign.png';?>" 
                                 alt="Default Signature" />
                        <?php }?>
                        <p style="margin:0; padding:0; text-align:right; font-size:10px; font-weight:600; color:#333; width:100%;">
                            Signature Of Authority Officer<br/>
                            <b><?php echo ucfirst($this->session->userdata("loggeduser")) . ' (DDO-' . $this->session->userdata("ddo_num"); ?>)</b>
                        </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- ============================================================ -->
<!-- PAGE BREAK - ANNUAL SALARY SHEET ON NEXT PAGE -->
<!-- ============================================================ -->
<div class="page-break">
    <div class="page-break-label">--- Continued on Next Page ---</div>
</div>

<!-- ============================================================ -->
<!-- PAGE 2 - ANNUAL SALARY SHEET -->
<!-- ============================================================ -->
<div class="annual-salary-header">
    <h1 style="text-align:center;">Annual Salary Sheet</h1>
    <p><strong>Tax Year: <?php echo str_replace("_", "-", $fnyr); ?></strong></p>
</div>

<div class="annual-employee-info">
    <p style="font-size:10px; margin:2px 0;text-align:center;">
        <b><?php echo ucfirst($this->session->userdata("loggeduser")).' (DDO-'.$this->session->userdata("ddo_num");?>)</b>
    </p>
    <table>
        <?php
            $asyr = $as[0] + 1 . '-' . $as[1] + 1;
        ?>
        <tr>
            <th>TAX YEAR:</th>
            <th colspan="3"><?php echo str_replace("_","-",$fnyr);?></th>
        </tr>
        <tr>
            <th>EMPLOYEE NAME</th>
            <th><?php echo $empd->emp_name;?></th>
            <th>DESIGNATION</th>
            <th><?php echo $empd->emp_desg;?></th>
        </tr>
        <tr>
            <th>PENSION TYPE</th>
            <th><?php echo $empd->emp_gpf;?></th>
            <th>BILL UNIT</th>
            <th><?php echo $empd->emp_bill;?></th>
        </tr>
        <tr>
            <th>OFFICE</th>
            <th><?php echo $empd->emp_school;?></th>
            <th>SUB-OFFICE</th>
            <th><?php echo $empd->emp_sankul;?></th>
        </tr>
        <tr>
            <th>PAN: </th>
            <th><?php echo $empd->emp_pan;?></th>
            <th>EMPLOYEE CODE: </th>
            <th><?php echo $empd->emp_code;?></th>
        </tr>
        <tr>
            <th>MOBILE: </th>
            <th><?php echo $empd->emp_mob;?></th>
            <th>EMAIL: </th>
            <th><?php echo $empd->emp_email;?></th>
        </tr>
    </table>
</div>

<div class="section-title">Monthly Salary Breakdown</div>
<table class="salary-table" border="1">
    <thead>
        <tr>
            <th>Month</th>
            <th>BASIC</th>
            <th>DA</th>
            <th>HRA</th>
            <th>WASH. ALW.</th>
            <th>MED. ALW.</th>
            <th>FIX TA</th>
            <th>OTHER 1</th>
            <th>TOTAL</th>
            <th>GPF SUB</th>
            <th>GIS</th>
            <th>FEST ADV.</th>
            <th>HOUSE RENT</th>
            <th>WATER CHAR.</th>
            <th>INCOME TAX</th>
            <th>TOTAL DED</th>
            <th>NET</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $this->db->select("*");
            $this->db->from("emp_data");
            $this->db->where("emp_data.dt_emp_id",$empd->emp_id);
            $this->db->where("emp_data.dt_fnyr",$fnyr);
            if($this->session->userdata("userid")!=$empd->emp_client){
                $this->db->where("emp_data.dt_sal_ddo",$this->session->userdata("userid")); 
            }
            $this->db->where("emp_data.dt_type","Salary");
            $this->db->order_by("emp_data.dt_month2","asc");
            $empdata=$this->db->get()->result();
            $dt_basic=$dt_da=$dt_house=$dt_city=$dt_wash=$dt_medical=$dt_fest=$dt_fix_ta=$dt_other=$dt_dues=$dt_gpf=$dt_gpf_recv=$dt_gis=$dt_fest=$dt_hre_recv=$dt_water=$dt_tax=0;
            $dt_ded=$dt_net_salary=0;$i=0;
            foreach($empdata as $c){
        ?>
        <tr <?php if($c->dt_exclude!=""){echo "bgcolor='#f59191'";}?>>                    
            <td>Salary-<?php echo str_replace("20","",$c->dt_month);?></td>
            <td><?php echo $c->dt_basic;$dt_basic=$dt_basic+$c->dt_basic;?></td>
            <td><?php echo $c->dt_da;$dt_da=$dt_da+$c->dt_da;?></td>
            <td><?php echo $c->dt_house;$dt_house=$dt_house+$c->dt_house;?></td>
            <td><?php echo $c->dt_wash;$dt_wash=$dt_wash+$c->dt_wash;?></td>
            <td><?php echo $c->dt_medical;$dt_medical=$dt_medical+$c->dt_medical;?></td>
            <td><?php echo $c->dt_fix_ta;$dt_fix_ta=$dt_fix_ta+$c->dt_fix_ta;?></td>
            <td><?php echo $c->dt_other;$dt_other=$dt_other+$c->dt_other;?></td>
            <td><?php echo $c->dt_dues;$dt_dues=$dt_dues+$c->dt_dues;?></td>
            <td><?php echo $c->dt_gpf;$dt_gpf=$dt_gpf+$c->dt_gpf;?></td>
            <td><?php echo $c->dt_gis;$dt_gis=$dt_gis+$c->dt_gis;?></td>
            <td><?php echo $c->dt_fest;$dt_fest=$dt_fest+$c->dt_fest;?></td>
            <td><?php echo $c->dt_hre_recv;$dt_hre_recv=$dt_hre_recv+$c->dt_hre_recv;?></td>
            <td><?php echo $c->dt_water;$dt_water=$dt_water+$c->dt_water;?></td>
            <td><?php echo $c->dt_tax;$dt_tax=$dt_tax+$c->dt_tax;?></td>
            <td><?php echo $c->dt_ded;$dt_ded=$dt_ded+$c->dt_ded;?></td>
            <td><?php echo $c->dt_net_salary;$dt_net_salary=$dt_net_salary+$c->dt_net_salary;?></td>
        </tr>
        <?php 
            $i++;
            }
            
            $this->db->select("*");
            $this->db->from("emp_data");
            $this->db->where("emp_data.dt_emp_id",$empd->emp_id);
            $this->db->where("emp_data.dt_fnyr",$fnyr);
            if($this->session->userdata("userid")!=$empd->emp_client){
                $this->db->where("emp_data.dt_sal_ddo",$this->session->userdata("userid"));  
            }
            $this->db->where("emp_data.dt_type","Arear");
            $this->db->order_by("emp_data.dt_month2","asc");
            $empdata=$this->db->get()->result();
            foreach($empdata as $c){
        ?>
        <tr <?php if($c->dt_exclude!=""){echo "bgcolor='#f59191'";}?>>                    
            <td>Arear-<?php echo str_replace("20","",$c->dt_month);?></td>
            <td><?php echo $c->dt_basic;$dt_basic=$dt_basic+$c->dt_basic;?></td>
            <td><?php echo $c->dt_da;$dt_da=$dt_da+$c->dt_da;?></td>
            <td><?php echo $c->dt_house;$dt_house=$dt_house+$c->dt_house;?></td>
            <td><?php echo $c->dt_wash;$dt_wash=$dt_wash+$c->dt_wash;?></td>
            <td><?php echo $c->dt_medical;$dt_medical=$dt_medical+$c->dt_medical;?></td>
            <td><?php echo $c->dt_fix_ta;$dt_fix_ta=$dt_fix_ta+$c->dt_fix_ta;?></td>
            <td><?php echo $c->dt_other;$dt_other=$dt_other+$c->dt_other;?></td>
            <td><?php echo $c->dt_dues;$dt_dues=$dt_dues+$c->dt_dues;?></td>
            <td><?php echo $c->dt_gpf;$dt_gpf=$dt_gpf+$c->dt_gpf;?></td>
            <td><?php echo $c->dt_gis;$dt_gis=$dt_gis+$c->dt_gis;?></td>
            <td><?php echo $c->dt_fest;$dt_fest=$dt_fest+$c->dt_fest;?></td>
            <td><?php echo $c->dt_hre_recv;$dt_hre_recv=$dt_hre_recv+$c->dt_hre_recv;?></td>
            <td><?php echo $c->dt_water;$dt_water=$dt_water+$c->dt_water;?></td>
            <td><?php echo $c->dt_tax;$dt_tax=$dt_tax+$c->dt_tax;?></td>
            <td><?php echo $c->dt_ded;$dt_ded=$dt_ded+$c->dt_ded;?></td>
            <td><?php echo $c->dt_net_salary;$dt_net_salary=$dt_net_salary+$c->dt_net_salary;?></td>
        </tr>
        <?php 
            $i++;
            }
        ?>
        <tr style="font-weight:bold;background-color:#e8e8e8;">
            <td><strong>TOTAL</strong></td>
            <td><strong><?php echo $dt_basic;?></strong></td>
            <td><strong><?php echo $dt_da;?></strong></td>
            <td><strong><?php echo $dt_house;?></strong></td>
            <td><strong><?php echo $dt_wash;?></strong></td>
            <td><strong><?php echo $dt_medical;?></strong></td>
            <td><strong><?php echo $dt_fix_ta;?></strong></td>
            <td><strong><?php echo $dt_other;?></strong></td>
            <td><strong><?php echo $dt_dues;?></strong></td>
            <td><strong><?php echo $dt_gpf;?></strong></td>
            <td><strong><?php echo $dt_gis;?></strong></td>
            <td><strong><?php echo $dt_fest;?></strong></td>
            <td><strong><?php echo $dt_hre_recv;?></strong></td>
            <td><strong><?php echo $dt_water;?></strong></td>
            <td><strong><?php echo $dt_tax;?></strong></td>
            <td><strong><?php echo $dt_ded;?></strong></td>
            <td><strong><?php echo $dt_net_salary;?></strong></td>
        </tr>
    </tbody>
</table>

<!-- ============================================================ -->
<!-- SIGNATURE SECTION WITH SPACE (PAGE 2) -->
<!-- ============================================================ -->
<div class="signature-section" style="width:100%; background:#fff; margin:0; padding:0; border:none;">
    <table style="width:100%; background:#fff; border:none; border-collapse:collapse; table-layout:fixed;">
        <tbody>
            <tr style="background:#fff; border:none;">
                <!-- LEFT CELL: Employee signature (left aligned) -->
                <td style="background:#fff; text-align:left; padding:30px 20px 30px 20px; border:none; width:50%; vertical-align:bottom;">
                    <div style="min-height:120px; display:flex; flex-direction:column; justify-content:flex-end; align-items:flex-start; text-align:left;">
                        <img style="width:100px; height:auto; margin:0 0 10px 0; display:block;" 
                             src="<?php echo base_url().'assets/images/signs/user_sign.png';?>" 
                             alt="Employee Signature" />
                        <p style="margin:0; padding:0; text-align:left; font-size:9px; color:#666; width:100%;">Signature Of Employee</p>
                    </div>
                </td>

                <!-- RIGHT CELL: Authority Officer signature (right aligned) -->
                <td style="background:#fff; text-align:right; padding:30px 20px 30px 20px; border:none; width:50%; vertical-align:bottom;">
                    <div style="min-height:120px; display:flex; flex-direction:column; justify-content:flex-end; align-items:flex-end; text-align:right;">
                        <?php if($ddo->ddo_sign!=''){?>
                            <img style="width:100px; height:auto; margin:0 0 10px 0; display:block;" 
                                 src="<?php echo base_url().'assets/images/signs/'.$ddo->ddo_sign;?>" 
                                 alt="Authority Signature" />
                        <?php }else{?>
                            <img style="width:100px; height:auto; margin:0 0 10px 0; display:block;" 
                                 src="<?php echo base_url().'assets/images/signs/user_sign.png';?>" 
                                 alt="Default Signature" />
                        <?php }?>
                        <p style="margin:0; padding:0; text-align:right; font-size:10px; font-weight:600; color:#333; width:100%;">
                            Signature Of Authority Officer<br/>
                            <b><?php echo ucfirst($this->session->userdata("loggeduser")) . ' (DDO-' . $this->session->userdata("ddo_num"); ?>)</b>
                        </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- ============================================================ -->
<!-- FOOTER -->
<!-- ============================================================ -->
<div class="footer" style="margin-top:150px;padding-top:80px;">
    <table style="margin-top:100px;width:100%;background:#fff;border:none;">
        <tr>
            <td style="border:none;text-align:left;font-size:11px;">E-Kosh TDS Software</td>
            <td style="border:none;text-align:center;font-size:11px;">Contact : 8770163693</td>
            <td style="border:none;text-align:right;font-size:11px;">Email : info@ekoshtds.com</td>
        </tr>
    </table>
</div>