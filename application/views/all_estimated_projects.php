<?php //print_r($projects);die; ?>
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
                <?php include 'inc/sidebar.php'; ?>
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
                                    <a href="<?php echo base_url()?>">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <a href="#">Estimated Projects</a>
                                </li>
                               
                            </ul>
                            <div class="page-toolbar">
                               
                            </div>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> 
                            Estimated projects
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
                                            <span class="caption-subject bold uppercase"> Estimated projects Table</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <table class="table table-condensed table-bordered table-hover table-checkable order-column" id="example">
                                            <thead>
                                                <tr>
                                                    <th> # </th>
                                                    <th> Job </th>
                                                    <th> Po </th>
                                                    <th> Client </th>
                                                    <th style="text-align: center;"> Estimate status </th>
                                                    <th style="text-align: center;"> Type </th>
                                                    <!-- <th> Action </th> -->
                                                    <th style="text-align: center;"> Queue </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $odd = 'odd';
                                                $i = 1;
                                                foreach ($estimated_projects as $key) :
                                                    $odd = $odd == 'odd' ? 'even' : 'odd';
                                                 ?>
                                                <tr class="<?= $odd ?> gradeX" onclick="window.location='<?= site_url('projects/project_details/'.$key->project_id)?>';" style='cursor:pointer'>
                                                   <td><?php echo $i ?></td>
                                                   <td><?php echo $key->title ?></td>
                                                   <td><?php echo $key->po ?></td>
                                                   <td>
                                                       <?php
                                                        if($key->asign_user == 0) 
                                                            echo '';
                                                        else{
                                                            $client = $this->db->get_where('user',['id' => $key->asign_user])->row();  
                                                            if($client->designation_id == 7)
                                                                echo $client->company_name.' ('.$client->name.')';
                                                            else
                                                                echo $client->name;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php 
                                                        switch ($key->estimated_approve) {
                                                            case 1:
                                                                $estimated_status_class = 'success';
                                                                $estimated_status = 'Approve';
                                                                break;
                                                            case 0:
                                                                $estimated_status_class = 'secondary';
                                                                $estimated_status = 'No action yet';
                                                                break;
                                                            case 2:
                                                                $estimated_status_class = 'warning';
                                                                $estimated_status = 'Revise';
                                                                break;
                                                            case 3:
                                                                $estimated_status_class = 'danger';
                                                                $estimated_status = 'Decline';
                                                                break;
                                                            
                                                            default:
                                                                # code...
                                                                break;
                                                        }
                                                         ?>
                                                         <span class="badge badge-<?php echo $estimated_status_class ?>"><?php echo $estimated_status ?></span>
                                                    </td>
                                                    <td style="text-align: center;">
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
                                                        <span class="badge badge-<?php echo $state ?>"><?= ucwords($key->type) ?></span>
                                                    </td>
                                                    <!-- <td><?php //echo $key->po ?></td> -->
                                                    <td style="text-align: center;">
                                                        <span class="badge badge-success"><?php echo $key->project_id ?></span>
                                                    </td>
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
                
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
          
            <!-- END FOOTER -->
        </div>
            </div>
        </div>
        <!--[if lt IE 9]>
        <script src="../assets/global/plugins/respond.min.js"></script>
        <script src="../assets/global/plugins/excanvas.min.js"></script> 
        <script src="../assets/global/plugins/ie8.fix.min.js"></script> 
        <![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url();?>/assets/assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url();?>/assets/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url();?>/assets/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url();?>/assets/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });

                $(document).ready(function() {
                    $('#example').DataTable();
                } );
            })
        </script>
    </body>

</html>