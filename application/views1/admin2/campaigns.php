  <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Create Campaign</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                            <li class="breadcrumb-item active">Campaign</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
						<style>.card-title{color:#F90;}</style>
                        <div class="row">
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">Create/Edit Campaign</h4>
                                        
                                        <form action="" method="post">
                                        	<div class="form-group">
                                            	<label>Campaign Title</label>
                                                <input type="text" class="form-control" required name="camp_title" />
                                            </div>
                                            <div class="form-group">
                                            	<label>Campaign Description</label>
                                                <textarea rows="4"  class="form-control" required name="camp_title"></textarea>
                                            </div><br/>
                                            <button type="submit" class="btn btn-dark">Create</button>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">Listed Campaigns</h4>
                                        
                                        <table class="table table-bordered">
                                        	<thead><tr><th>S.No.</th><th>Title</th><th>Create Date</th><th>Description</th><th>Action</th></tr></thead>
                                            <tbody>
                                            
                                            </tbody>
                                        	
                                        </table>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Skote.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by Themesbrand
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="<?php echo base_url();?>adminsite/libs/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url();?>adminsite/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url();?>adminsite/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?php echo base_url();?>adminsite/libs/simplebar/simplebar.min.js"></script>
        <script src="<?php echo base_url();?>adminsite/libs/node-waves/waves.min.js"></script>

        <script src="<?php echo base_url();?>adminsite/js/app.js"></script>

    </body>


</html>
