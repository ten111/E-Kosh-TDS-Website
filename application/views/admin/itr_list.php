<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">COMPUTATION LISTING (<?php echo $total_rows;?>)</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>
                            <li class="breadcrumb-item active">Employees</li>                            
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <style>
        .table-container {
            width: 100%;
            max-height: 700px; /* Adjust based on your needs */
            overflow: auto;
            position: relative;
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        th, td {
            white-space: nowrap;
            padding: 8px 16px;
        }

        /* Fix header */
        thead th {
            position: sticky;
            top: 0;
            background:rgb(250, 250, 248);
            z-index: 3;
        }
        .first_row th {
            position: sticky;
            top: 0;
            background: #f8f9fa;
            z-index: 3;
        }

        /* Fix the first 4 columns */
        th:nth-child(-n+3),
        td:nth-child(-n+3) {
            position: sticky;
            left: 0;
            background: white;
            z-index: 2;
        }

        /* Fix first 4 header columns above other elements */
        thead th:nth-child(-n+3) {
            z-index: 4;
        }
       
        /* Adjust the left positioning for each fixed column */
        th:nth-child(1), td:nth-child(1) { left: 0; }
        th:nth-child(2), td:nth-child(2) { left: 40px; }
        th:nth-child(3), td:nth-child(3) { left: 120px; }
        </style>
        <div class="row">          
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <a href="<?php echo base_url().'admin/auto_itr/'.$this->uri->segment(3);?>" class="btn btn-info btn-sm">CALCULATE INCOME TAX</a>
            <a href="<?php echo base_url().'admin/reset_itr/'.$this->uri->segment(3);?>" class="btn btn-danger end float-end float-right btn-sm" onclick="return confirm('This will Delete all ITR? This action cannot be undone.');">RESET ITR</a>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search by Name, Emp Code or PAN...">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="searchButton">
                    <i class="bi bi-search"></i>
                </button>
                <button class="btn btn-outline-secondary btn-sm" type="button" id="clearSearch" style="display:none;">
                    <i class="bi bi-times"></i>
                </button>
            </div>
        </div>
    </div>
</div>
                    <div class="card-body">
                        <!-- Search Bar -->
                        <form action="<?php echo base_url().'admin/bulk_itr/'.$this->uri->segment(3);?>" method="post">
                      
                        <button type="submit" class="btn text-dark btn-warning btn-sm">DOWNLOAD COMPUTATION PDFs</button>
                           <br/>
     <a target="_blank" href="<?php echo base_url().'admin/export_ann_itr/'.$this->uri->segment(3).'/'.$this->uri->segment(4);?>" class="btn-sm mt-2 btn btn-dark">DOWNLOAD REPORTS <i class="fa fa-download"></i></a>
                      
                        <div class="table-responsive" id="tablediv">
                          
                            <table id="itrTable" class="table table-bordered align-middle table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>Name of Employee</th>
                                        <th>Employee Code</th>
                                        <th>PAN</th>
                                        <th>Type</th>
                                        <th>From</th>
                                        <th>To</th>
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
                                        <th>Less: Advance Tax Paid</th>
                                        <th>Tax After Advance Tax Paid</th>
                                        <th>Rebate u/s 89(1)</th>
                                        <th>Tax Liability</th>
                                        <th>Total Tax Amt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>
                                       
                        </div>  
                        <div class="d-flex justify-content-between align-items-center mt-3">
    <!-- <div class="text-muted">
        Showing <span id="currentCount">0</span> of <span id="totalCount">0</span> records
    </div> -->
    <div class="pagination-container">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0" id="paginationControls">
                <li class="page-item disabled" id="prevPage">
                    <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                        <span aria-hidden="true">&laquo; Previous</span>
                    </a>
                </li>
                <li class="page-item" id="nextPage">
                    <a class="page-link" href="javascript:void(0)" aria-label="Next">
                        <span aria-hidden="true">Next &raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="page-info">
        <div class="input-group input-group-sm" style="width: 150px;">
            <input type="number" class="form-control" id="jumpToPage" min="1" value="1" placeholder="Page">
            <button class="btn btn-outline-secondary" type="button" id="goToPage">Go to Page</button>
        </div>
    </div>
    </div>
    
</div> 
                        </div> <!-- End of table-responsive -->
    
<!-- Pagination Controls -->


</form>
                        
        <div id="load_itr_box" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">


  <div class="modal-content">

  <div class="modal-header">
                                                      <h5 class="modal-title">DATA DETAILS</h5>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>

    <div class="modal-body itr_box">
    <tr><td><h2 class="text-warning text-center"><i class="mdi mdi-spin mdi-loading"></i> Loading Data...</h2></td></tr>

        

    </div>

   

  </div>

</div>

  </div>
                    </div>
                    
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

    </div> <!-- container-fluid -->
</div><!-- End Page-content -->

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © Ekosh TDS.
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
<script>
$(document).ready(function(){
    let currentOffset = 0;
    let limit = 50;
    let totalRows = <?php echo $total_rows;?>;
    let searchTerm = '';
    let isLoading = false;
    
    // Function to load data
    function loadData(offset = 0, search = '') {
        if (isLoading) return;
        
        isLoading = true;
        $('#tablediv').addClass('loading');
        
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>admin/ajax_itr1',
            data: {
                offset: offset,
                yr: "<?php echo $this->uri->segment(3);?>",
                search: search
            },
            success: function(response){
                $('#tablediv tbody').html(response);
                currentOffset = offset;
                updatePaginationControls();
                attachRowHandlers();
                $('#tablediv').removeClass('loading');
                isLoading = false;
            },
            error: function() {
                $('#tablediv').removeClass('loading');
                isLoading = false;
                alert('Error loading data. Please try again.');
            }
        });
    }
    
    // Function to update pagination controls
    function updatePaginationControls() {
        // Update counts
        const currentCount = $('#tablediv tbody tr').length;
        $('#currentCount').text(currentCount);
        
        // Enable/disable previous button
        if (currentOffset <= 0) {
            $('#prevPage').addClass('disabled');
        } else {
            $('#prevPage').removeClass('disabled');
        }
        
        // Enable/disable next button
        if (currentOffset + limit >= totalRows) {
            $('#nextPage').addClass('disabled');
        } else {
            $('#nextPage').removeClass('disabled');
        }
        
        // Update page number display
        const currentPage = Math.floor(currentOffset / limit) + 1;
        $('#jumpToPage').val(currentPage);
    }
    
    // Function to attach handlers to dynamically loaded rows
    function attachRowHandlers() {
        // Delete button handler
        $(".itr_delete").click(function(e){
            e.preventDefault();
            if (!confirm("Sure you want to delete?")){
                return false;
            }
            var id = $(this).attr("id");
            var row = $(this).closest("tr");
            
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>admin/ajax_itr_delete',
                data: {id: id},
                success: function(response){
                    row.remove();
                    loadData(currentOffset, searchTerm); // Reload current page
                }
            });
        });
        
        // Modal button handler
      
        // Checkbox handlers
        $('#selectAll').click(function() {
            $('.rowCheckbox').prop('checked', this.checked);
        });
        
        $('tbody').on('click', '.rowCheckbox', function() {
            var allChecked = $('.rowCheckbox:checked').length === $('.rowCheckbox').length;
            $('#selectAll').prop('checked', allChecked);
        });
    }
    
    // Pagination event handlers
    $('#prevPage').click(function(e) {
        e.preventDefault();
        if (currentOffset > 0 && !$(this).hasClass('disabled')) {
            loadData(currentOffset - limit, searchTerm);
        }
    });
    
    $('#nextPage').click(function(e) {
        e.preventDefault();
        if (!$(this).hasClass('disabled')) {
            loadData(currentOffset + limit, searchTerm);
        }
    });
    
    // Go to specific page
    $('#goToPage').click(function() {
        const page = parseInt($('#jumpToPage').val());
        if (page > 0) {
            const newOffset = (page - 1) * limit;
            loadData(newOffset, searchTerm);
        }
    });
    
    $('#jumpToPage').keypress(function(e) {
        if (e.which === 13) {
            $('#goToPage').click();
        }
    });
    
    // Search functionality
    $('#searchButton').click(function() {
        searchTerm = $('#searchInput').val().trim();
        if (searchTerm !== '') {
            $('#clearSearch').show();
            loadData(0, searchTerm);
        }
    });
    
    $('#searchInput').keypress(function(e) {
        if (e.which === 13) {
            $('#searchButton').click();
        }
    });
    
    // Clear search
    $('#clearSearch').click(function() {
        $('#searchInput').val('');
        searchTerm = '';
        $(this).hide();
        loadData(0, '');
    });
    
    // Form submission validation
    $("form").on("submit", function(e) {
        var checked = $(".rowCheckbox:checked").length;
        if (checked === 0) {
            alert("⚠️ Please select at least one employee before generating computation PDFs!");
            e.preventDefault();
            return false;
        }
    });
    
    // Load initial data
    loadData(0, '');
    
    // Add loading styles
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .loading {
                opacity: 0.7;
                pointer-events: none;
                position: relative;
            }
            .loading:after {
                content: 'Loading...';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: white;
                padding: 10px 20px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
        `)
        .appendTo('head');
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