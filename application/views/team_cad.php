
        <!-- BEGIN HEADER -->
        <?php include 'inc/header.php'; ?>
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <style>
            .toggle-group .btn{
                margin-right: 0;

            }
        </style>
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
                                Team Cad
                            </li>
                        </ul>
                        <div class="page-toolbar">
                            
                        </div>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h1 class="page-title"> Team Members     
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
                                        <span class="caption-subject bold uppercase"> Cad Table</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided">
                                            <a class="btn btn-transparent blue btn-outline btn-circle btn-sm" href="<?php echo site_url('Master_controllers/all_team_members');?>">All</a>
                                            <a class="btn btn-transparent blue btn-outline btn-circle btn-sm" href="<?php echo site_url('Master_controllers/all_manager');?>">Manager</a>
                                            <a class="btn btn-transparent blue btn-outline btn-circle btn-sm" href="<?php echo site_url('all_sales_rep');?>">Sales Rep</a>
                                            <a class="btn btn-transparent blue btn-outline btn-circle btn-sm active" href="<?php echo site_url('all_cad');?>">Cad Team</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th> # </th>
                                                <th> Name </th>
                                                <th style="text-align: center;"> Role </th>
                                                <th> Contact No </th>
                                                <th> Mail id </th>
                                                <th style="text-align: center;"> Permission </th>
                                                <th style="text-align: center;"> Cad Slots </th>
                                                <th style="text-align: center;"> Action </th>
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
                                                <td> <a href="tel:<?php echo $key->phone;?>"><?php echo $key->phone;?></a> </td>
                                                <td> <a href="mailto:<?php echo $key->email;?>"><?php echo $key->email;?></a> </td>
                                                <td style="text-align: center;">
                                                    <?php //echo $key->permission == 1 ? 'On' : 'Off' ?>
                                                    <!-- Default checked -->
                                                    <input class="prm_check" value="<?php echo $key->id ?>" <?php echo $key->permission == 1 ? 'checked' : '' ?> type="checkbox" data-toggle="toggle" data-size="mini">
                                                </td>
                                                <td style="text-align: center;"><a href="<?= site_url('cad_slots/'.$key->id)?>" class="badge badge-info">Slots</a></td>
                                                <td style="text-align: center;"><a href="<?= site_url('member_details/'.$key->id)?>" class="badge badge-success">Details</a></td>
                                            </tr>
                                            <?php $i++; endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
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

    
   <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $(function() {
            $('.prm_check').change(function() {
                var id = $(this).val();
                $.ajax({
                    url: "<?php echo base_url('User_controller/member_permission_invoke/')?>"+id,
                    success:function(data){
                        swal('Permission invoked');
                    }
                });
            })
        });
        
    </script>
    
</body>

</html>