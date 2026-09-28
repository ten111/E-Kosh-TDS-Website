<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title;?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <!-- Buttons CSS (for export) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    
    <style>
        .dataTables_wrapper .dataTables_info {
            padding-top: 1em !important;
        }
        .dt-buttons {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-5">
        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?php echo str_replace("_"," ",$title);?></h5>
            </div>
            <div class="card-body">
                <table id="example" class="table table-bordered table-striped" style="width:100%">
                     <thead>
                                    <tr><th>S.No.</th>
                                        <th>Employee Name</th>
                                        <th>Employee Code</th>
                                        <th>PAN</th>
                                        <th>Type</th>
                                        <th>From</th><th>To</th>
                                        <th>Income From Prev Employer</th>
                                        <th>Income From Current Employer</th>
                                        <th>Total Income From Salary Head</th>
                                        <th>Less-Standard Deduction</th>
                                        <th>Net Income From Salary Head</th>
                                        <th>House Property Type</th>
                                        <th>Net Income From Home Property Head</th>
                                        <th>Net Income From Other Sources</th>
                                        <th>Gross Total Income</th>
                                        <th>Deduction u/s 80CCD(2)</th>
                                        <th>Deduction u/s 80CCH(2)</th>
                                        <th>Taxable Income</th>
                                        <th>Tax On Total Income</th>
                                        <th>Relief U/S 87A</th>
                                        <th>Tax After Marginal Relief</th>
                                        <th>Surcharge(0%)</th>
                                        <th>Tax With Surcharge</th>
                                        <th>Education Cess (4%)</th>
                                        <th>Tax With Cess</th>
                                        <td>Less: Advance Tax Paid</th>
                                        <th>Tax After Advance Tax Paid</th>
                                        <th>Tax Liability</th>
                                        <th>Total Tax Amt</th>
                                    </tr>


                                </thead>
                                <tbody>
                                    <?php $i=1;foreach($itrs as $itr){?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $itr->emp_name;?></td>
                                        <td><?php echo $itr->emp_code;?></td>
                                        <td><?php echo $itr->emp_pan;?></td>
                                        <td><?php echo $itr->emp_gpf;?></td>
                                        <td>
                                            <?php 
                                            $this->db->order_by("dt_month2","asc");
                                            $mon=$this->db->get_where("emp_data",array("dt_fnyr"=>$this->uri->segment(3),"dt_emp_id"=>$itr->itr_emp))->row();
                                            echo $mon->dt_month;?></td><td><?php 
                                            $this->db->order_by("dt_month2","desc");
                                            $mon=$this->db->get_where("emp_data",array("dt_fnyr"=>$this->uri->segment(3),"dt_emp_id"=>$itr->itr_emp))->row();
                                            echo $mon->dt_month;?>
                                        </td>
                                         <td><?php 
       if($this->db->get_where("emp_history",array("emp_hddo2"=>$this->session->userdata("userid"),"emp_code"=>$itr->emp_code))->num_rows()>0){
                    $this->db->select_sum('dt_dues');
					$this->db->where("dt_emp_id",$itr->itr_emp); 
					$this->db->where("dt_fnyr",str_replace("-","_",$itr->itr_yr));  
                    $this->db->where("dt_type!=",'PayArear'); 
                    $this->db->where("dt_sal_ddo!=",$this->session->userdata("userid")); 
                    $this->db->where("dt_sal_ddo!=",""); 
					$lll=$this->db->get('emp_data')->row();
					//print_r($lll);
					$total_dues=$lll->dt_dues;                                         
                                        echo $total_dues;
                                        }else{
                                     
                    $this->db->select_sum('dt_dues');
					$this->db->where("dt_emp_id",$itr->itr_emp); 
					$this->db->where("dt_fnyr",str_replace("-","_",$itr->itr_yr));  
                    $this->db->where("dt_type!=",'PayArear'); 
                    $this->db->where("dt_sal_ddo",""); 
					$lll=$this->db->get('emp_data')->row();
					//print_r($lll);
					$total_dues=$lll->dt_dues;                                         
                                        echo $total_dues;     
                                        }?></td>
                                        <td><?php echo $itr->sal_head-$total_dues;?></td>
                                        <td><?php echo $itr->sal_head;?></td>
                                        <td><?php echo $itr->less;?></td>
                                        <td><?php echo $itr->netincome;?></td>
                                        <td><?php echo $itr->house_status;?></td>
                                        <td><?php echo $itr->net_hincome;?></td>
                                        <td><?php echo $itr->other_sources;?></td>
                                        <td><?php echo $itr->gross_total;?></td>
                                        <td><?php echo $itr->nps_80ccd2;?></td>
                                        <td><?php echo $itr->agniveer_80cch2;?></td>
                                        <td><?php echo $itr->taxable;?></td>
                                        <td><?php echo $itr->totalTax;?></td>
                                        
                                        <td><?php echo $itr->rebate87A;?></td>
                                        <td><?php echo $tot=$itr->totalTax-$itr->rebate87A;?></td>
                                        <td><?php echo $itr->surcharge;?></td>
                                        <td><?php echo $tot+$itr->surcharge;?></td>
                                        <td><?php echo $itr->cess;?></td>
                                        <td><?php echo $tot=$tot+$itr->surcharge+$itr->cess;?></td>
                                        <td><?php echo $itr->advanceTax;?></td>
                                        <td><?php echo $tot=$tot-$itr->advanceTax;?></td>
                                        <td><?php echo $itr->paytype;?></td>
                                        <td><?php echo $itr->finalTaxLiability;?></td>
                                    </tr>
                                    <?php $i++; }?>
                                </tbody>
                        </table>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    
    <!-- JSZip for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    
    <!-- pdfmake for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    
    <!-- Buttons HTML5 -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'csvHtml5',
                        text: 'Export CSV',
                        className: 'btn btn-primary'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Export PDF',
                        className: 'btn btn-danger',
                        orientation: 'landscape', // Set PDF orientation to landscape
            customize: function (doc) {
                // You can add additional PDF customization here if needed
                doc.defaultStyle.fontSize = 10;
                doc.styles.tableHeader.fontSize = 10;
            }
                    }
                ],
                responsive: true
            });
        });
    </script>
</body>
</html>