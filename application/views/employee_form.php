<!DOCTYPE html>
<html>
<head>
    <title>Import Employee Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .debug-link { margin-top: 15px; }
        .table-container { max-height: 500px; overflow: auto; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h3 class="text-primary">DDO Wise Employee Details</h3>
        
        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-<?php echo $this->session->flashdata('type'); ?> alert-dismissible fade show">
                <?php echo $this->session->flashdata('msg'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo base_url('employee/fetch'); ?>" class="border p-3">
            <div class="row">
                <div class="col-md-3">
                    <label><strong>DDO Code</strong></label>
                    <input type="text" name="txtDDOCode" class="form-control" value="0820007">
                </div>
                <div class="col-md-3">
                    <label><strong>PayRoll Type</strong></label>
                    <select name="ddlPayrollTypeId" class="form-control">
                        <option value="Select...">Select...</option>
                        <option value="1">PAYROLL_GEN</option>
                        <option value="2" selected>PAYROLL_CPS_CGPF</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label><strong>Month/Year</strong></label>
                    <input type="text" name="txtMon_Year" class="form-control" value="03/2026">
                </div>
                <div class="col-md-3">
                    <label><strong>Financial Year</strong></label>
                    <select name="ddlFin_Year" class="form-control">
                        <option value="Select...">Select...</option>
                        <option value="2026_27" selected>2026_27</option>
                        <option value="2025_26">2025_26</option>
                        <option value="2024_25">2024_25</option>
                        <option value="2023_24">2023_24</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-3">
                    <label><strong>Stop Salary</strong></label>
                    <select name="ddlStopSalary" class="form-control">
                        <option value="All" selected>All</option>
                        <option value="N">No</option>
                        <option value="Y">Yes</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="btnShow1" class="btn btn-primary mt-4">Import Data</button>
                </div>
                <div class="col-md-3">
                    <a href="<?php echo base_url('employee/view_response'); ?>" class="btn btn-info mt-4" target="_blank">View Debug Files</a>
                </div>
            </div>
        </form>

        <div class="mt-4">
            <h4>Imported Records (<?php echo count($records ?? []); ?>)</h4>
            <div class="table-container">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee Code</th>
                            <th>Name</th>
                            <th>PRAN</th>
                            <th>Basic</th>
                            <th>Total Deductions</th>
                            <th>Total Dues</th>
                            <th>Financial Year</th>
                            <th>Imported At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($records) && !empty($records)): ?>
                            <?php foreach($records as $key => $row): ?>
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo $row->employee_code; ?></td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->pran; ?></td>
                                <td><?php echo number_format($row->basic); ?></td>
                                <td><?php echo number_format($row->total_deductions); ?></td>
                                <td><?php echo number_format($row->total_dues); ?></td>
                                <td><?php echo $row->fin_year; ?></td>
                                <td><?php echo date('d-m-Y H:i', strtotime($row->imported_at)); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="9" class="text-center">No records imported yet</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>