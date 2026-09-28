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
        .total-row {
            background-color: #ff9800 !important;
            font-weight: bold;
        }
        .total-row td {
            background-color: #ff9800 !important;
            color: #000;
        }
        /* Hide the total row from DataTables processing */
        .dataTables_processing {
            display: none !important;
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
                        <tr class="first_row">
                            <th>S.No.</th>
                            <th>Employee Code</th>
                            <th>Employee Name</th>
                            <th>PAN</th>
                            <th>Credit Type</th>
                            <?php 
                            $columnCount = 5; // S.No., Employee Code, Employee Name, PAN, Credit Type
                            foreach($months as $mon){
                                echo '<th>'.$mon->dt_month.' Credit Amount</th><th>'.$mon->dt_month.' Tax Amount</th>';
                                $columnCount += 2;
                            }
                            $columnCount += 2; // Total and Total Tax
                            ?>
                            <th bgcolor="orange">Total</th>
                            <th>Total Tax</th>
                        </tr>
                    </thead>
                    <tbody id="leads_list">
                        <?php
                        $i=1;
                        $grand_totals = array();
                        $grand_tax_totals = array();
                        $overall_total = 0;
                        $overall_tax = 0;
                        
                        foreach($list as $c){
                            $tot=0;
                            $tax_tot=0;
                            $month_index = 0;
                        ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $c->dt_emp_code;?></td>
                            <td><?php echo $c->emp_name;?></td>
                            <td><?php echo $c->emp_pan;?></td>
                            <td><?php echo $c->dt_type;?></td>
                            
                            <?php foreach($months as $mon){
                                if($c->dt_type=="Salary"){
                                    $sal=$this->db->get_where("emp_data",array("dt_emp_code"=>$c->dt_emp_code,"dt_month"=>$mon->dt_month,"dt_type"=>"Salary","dt_bill_no!="=>""));
                                }else{
                                    $sal=$this->db->get_where("emp_data",array("dt_emp_code"=>$c->dt_emp_code,"dt_month"=>$mon->dt_month,"dt_type"=>$c->dt_type));
                                }
                                if($sal->num_rows()>0){
                                    $sal=$sal->row();
                                    $credit = $sal->dt_dues;
                                    $tax = $sal->dt_tax;
                                    echo '<td>'.$credit.'</td>';
                                    echo '<td>'.$tax.'</td>';
                                    $tot = $tot + $credit;
                                    $tax_tot = $tax_tot + $tax;
                                    
                                    // Accumulate monthly totals
                                    if(!isset($grand_totals[$month_index])) {
                                        $grand_totals[$month_index] = 0;
                                        $grand_tax_totals[$month_index] = 0;
                                    }
                                    $grand_totals[$month_index] += $credit;
                                    $grand_tax_totals[$month_index] += $tax;
                                }else{
                                    echo '<td></td><td></td>';
                                }
                                $month_index++;
                            } ?>
                            <td bgcolor="orange"><?php echo $tot;?></td>
                            <td bgcolor="orange"><?php echo $tax_tot;?></td>
                        </tr>
                        <?php 
                        $overall_total += $tot;
                        $overall_tax += $tax_tot;
                        $i++;
                        } 
                        ?>
                    </tbody>
                    <tfoot>
                        <tr class="total-row"><td></td><td></td><td></td><td></td>
                            <td style="text-align:right; font-weight:bold; background-color:#ff9800;">TOTAL</td>
                            <?php 
                            $month_index = 0;
                            foreach($months as $mon){
                                $month_credit = isset($grand_totals[$month_index]) ? $grand_totals[$month_index] : 0;
                                $month_tax = isset($grand_tax_totals[$month_index]) ? $grand_tax_totals[$month_index] : 0;
                                echo '<td style="font-weight:bold; background-color:#ff9800;">'.$month_credit.'</td>';
                                echo '<td style="font-weight:bold; background-color:#ff9800;">'.$month_tax.'</td>';
                                $month_index++;
                            }
                            ?>
                            <td style="font-weight:bold; background-color:#ff9800;"><?php echo $overall_total;?></td>
                            <td style="font-weight:bold; background-color:#ff9800;"><?php echo $overall_tax;?></td>
                        </tr>
                    </tfoot>
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
    
    <!-- JSZip for CSV export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    
    <!-- pdfmake for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    
    <!-- Buttons HTML5 -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'csvHtml5',
                        text: 'Export CSV',
                        className: 'btn btn-success',
                        footer: true, // Include footer in export
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Export PDF',
                        className: 'btn btn-success',
                        orientation: 'landscape',
                        footer: true, // Include footer in export
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 10;
                            doc.styles.tableHeader.fontSize = 10;
                        }
                    }
                ],
                responsive: true,
                paging: true,
                pageLength: 10,
                ordering: true,
                // Keep footer visible even when scrolling
                scrollX: false,
                // Fix: Don't process the footer as data
                footerCallback: function(row, data, start, end, display) {
                    // The footer is already populated, no need to modify
                }
            });

            // Ensure footer is included in exports
            table.on('buttons-csv-export', function(e, data) {
                // Footer is automatically included with footer: true
            });
        });
    </script>
</body>
</html>