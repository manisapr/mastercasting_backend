
        <!-- BEGIN HEADER -->
        <?php include 'inc/header.php'; ?>
        <?php $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id; ?>

        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <?php include 'inc/sidebar.php'; ?>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN THEME PANEL -->
                    <div class="theme-panel hidden-xs hidden-sm">
                    </div>
                    <!-- END THEME PANEL -->
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="<?php echo base_url() ?>">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                          
                            <li>
                                <a href="#">Company Detail</a>
                            </li>
                        </ul>
                        <div class="page-toolbar">
                            
                        </div>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h1 class="page-title"> Company Detail
                    </h1>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject bold uppercase"> Managed Table</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                        <thead>
                                            <tr>
                                              <!--   <th>
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                                        <span></span>
                                                    </label>
                                                </th> -->
                                                <th> # </th>
                                                <th> Name </th>
                                                <th style="text-align: center;"> Role </th>
                                                <th style="text-align: center;"> Comp Designation </th>
                                                <th> Contact No </th>
                                                <th> Mail id </th>
                                                <?php if(!in_array($designation_id, [5,7])): ?>
                                                <th style="text-align: center;"> Action </th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; foreach ($members as $key): ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <?php echo ucwords(strtolower($key->name)); ?>
                                                </td>
                                                <td style="text-align: center;"> <span class="badge badge-info"><?php echo ucwords(strtolower($key->designation_name)) ?></span> </td>
                                                <td style="text-align: center;"> 
                                                    <span class="badge badge-info">
                                                        <?php if($key->comp_des == 1){
                                                                echo 'Admin';
                                                              }else{
                                                                echo 'Associate';
                                                              }
                                                         ?>
                                                    </span> 
                                                </td>
                                                <td> <a href="tel:<?php echo $key->phone;?>"><?php echo $key->phone;?></a> </td>
                                                <td> <a href="mailto:<?php echo $key->email;?>"><?php echo $key->email;?></a> </td>
                                                <?php if(!in_array($designation_id, [5,7])): ?>
                                                <td style="text-align: center;"><a href="<?= site_url('details/trade/'.$key->id)?>" class="badge badge-success">Details</a></td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php $i++; endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                        <div class="col-md-12">
                             <!-- job -->
                            <div class="panel panel-default" id="message_panel">
                                <div class="panel-heading">
                                    <button id="messaging_id" class="btn" type="button" data-toggle="collapse" data-target="#messaging" aria-expanded="false" aria-controls="multiCollapseExample2">Jobs</button>
                                </div>
                                <div class="collapse multi-collapse" id="create_msg">
                                    
                                </div>
                                
                                <div class="collapse multi-collapse" id="messaging">
                                    <div style="padding: 20px">
                                       <!--  <a class="btn btn-sm">Show live & proposal</a>
                                        <a class="btn btn-sm">Complete</a>
                                        <a class="btn btn-sm">Cancelled</a> -->

                                        <hr style="border-top: 1px solid #bdbdbd;">

                                        <table class="table table-condensed" style="margin-top: 20px">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Jobs Name</th>
                                                    <th>Po</th>
                                                    <th>Deadline</th>
                                                    <th>Status</th>
                                                    <th>Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($jobs as $key): ?>
                                                <tr style="cursor: pointer;" onclick="window.location='<?php echo base_url('projects/project_details/'.$key->project_id);?>'">
                                                    <td>
                                                        <a class="badge badge-success" href="">J<?php echo $key->project_id ?></a>
                                                    </td>
                                                    <td><?php echo $key->project_name ?></td>
                                                    <td><?php echo $key->po ?></td>
                                                    <td><?= $key->deadline == '0000-00-00' ? 'No deadline' : $key->deadline  ?></td>
                                                    <?php 
                                                    switch ($key->type) {
                                                        case 'live':
                                                            $state = 'info';
                                                            break;
                                                        case 'cancelled':
                                                            $state = 'danger';
                                                            break;
                                                        case 'proposal':
                                                            $state = 'secondary';
                                                            break;
                                                        case 'completed':
                                                            $state = 'success';
                                                            break;
                                                    }
                                                     ?>
                                                    <td><span class="badge badge-<?php echo $state ?>"><?php echo ucwords($key->type) ?></span></td>
                                                    <td><?php echo date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'm/d/Y H:i:s');  ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end job -->
                        </div>
                    </div>
                   

            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
            <!-- empty -->
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php include 'inc/footer.php'; ?>
        <!-- END FOOTER -->
    </div>
    <!-- BEGIN QUICK NAV -->
    <div class="quick-nav-overlay"></div>
    <!-- END QUICK NAV -->
    <!--[if lt IE 9]>       <script src="../assets/global/plugins/respond.min.js"></script><script src="../assets/global/plugins/excanvas.min.js"></script> <script src="../assets/global/plugins/ie8.fix.min.js"></script> <![endif]-->
    <!-- BEGIN CORE PLUGINS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="<?php echo base_url();?>assets/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="<?php echo base_url();?>assets/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="<?php echo base_url();?>assets/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="<?php echo base_url();?>assets/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->
    <script>
        $(document).ready(function() {
            $('#clickmewow').click(function() {
                $('#radio1003').attr('checked', 'checked');
            });
        })
    </script>
    
</body>

</html>