
            <!-- BEGIN HEADER -->
            <?php include 'inc/header.php'; ?>

            <link href='<?php echo base_url('assets/fullcalendar/packages/core/main.css')?>' rel='stylesheet' />
            <link href='<?php echo base_url('assets/fullcalendar/packages/daygrid/main.css')?>' rel='stylesheet' />
            <?php  
            $designation_id=$this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id; 
            $designation_name = $this->db->get_where('designation', ['designation_id' => $designation_id])->row()->designation_name;
            ?>
            <?php date_default_timezone_set('America/Chicago'); ?>
            <!-- END HEADER -->

            <style>
                
                .portlet-body{
                    position: relative;
                }

            </style>

            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container" id="dashboard-content">
                <!-- BEGIN SIDEBAR -->
                <?php include 'inc/sidebar.php'; ?>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="<?php echo base_url()?>">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Dashboard</span>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"><?php echo ucwords(strtolower($designation_name)) ?> Dashboard
                            <small>statistics, charts, recent events and reports</small>
                        </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <!-- BEGIN DASHBOARD STATS 1-->
                        
                       
                        
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url('projects/all_projects'); ?>">
                                    <div class="visual">
                                        <i class="fa fa-comments"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="<?php echo $all_project_cnt ?>"><?php echo $all_project_cnt ?></span>
                                        </div>
                                        <div class="desc"> All Projects </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 red" href="<?php echo site_url('projects/live_projects'); ?>">
                                    <div class="visual">
                                        <i class="fa fa-bar-chart-o"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="<?php echo $live_project_cnt ?>"><?php echo $live_project_cnt ?></span> </div>
                                        <div class="desc"> Live Projects </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 green" href="<?php echo site_url('projects/complete_projects'); ?>">
                                    <div class="visual">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="<?php echo $completed_project_cnt ?>"><?php echo $completed_project_cnt ?></span>
                                        </div>
                                        <div class="desc"> Complete Projects </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url('projects/cancel_projects'); ?>">
                                    <div class="visual">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number"> 
                                            <span data-counter="counterup" data-value="<?php echo $cancelled_project_cnt ?>"><?php echo $cancelled_project_cnt ?></span></div>
                                        <div class="desc"> Cancel Projects </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        
                       
                        
                        
                        <div class="clearfix"></div>
                        <!-- END DASHBOARD STATS 1-->
                        
                        <div class="row">

                            <!-- projects section -->
                            <?php if ($client_approval) : ?>
                            <div class="col-lg-6 col-xs-12 col-sm-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption">
                                            <i class="icon-bubbles font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase">Projects</span>
                                        </div>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#portlet_comments_1" data-toggle="tab" aria-expanded="true"> Proposal </a>
                                            </li>
                                            <?php if(in_array($designation_id, [1,6,8])): ?>
                                            <li class="">
                                                <a id="a_inactive_project" href="#portlet_comments_2" data-toggle="tab" aria-expanded="false"> Inactive </a>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                    <div class="portlet-body" style="height: 600px;">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="portlet_comments_1" >
                                               <div class="loader_container"><div class="loader"></div></div>
                                            </div>
                                            <?php if(in_array($designation_id, [1,6,8])): ?>
                                            <div class="tab-pane" id="portlet_comments_2">
                                                
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <!-- end projects section -->

                            
                            <!-- message section --> <!-- deadline section -->
                            <div class="col-lg-6 col-xs-12 col-sm-12">
                                <!-- message section --> 
                                <div class="portlet light bordered">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption">
                                            <i class="icon-bubbles font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase">Messages</span>
                                        </div>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#message_tab" data-toggle="tab" aria-expanded="true"> Messages </a>
                                            </li>
                                            <li class="">
                                                <a href="#reply_tab" data-toggle="tab" aria-expanded="false"> Replies </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="portlet-body" style="height: 250px;">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="message_tab">
                                                <div class="loader_container"><div class="loader"></div></div>
                                            </div>
                                            <div class="tab-pane" id="reply_tab">
                                                <div class="loader_container"><div class="loader"></div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end message section -->

                                <!-- deadline section -->
                                <div class="portlet light bordered">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption">
                                            <i class="icon-bubbles font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase">Deadline</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body" style="height: 250px; overflow-y: scroll;">
                                        <div class="tab-content" id="deadline_projects_comments">
                                            <div class="loader_container"><div class="loader"></div></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end message section --> 
                            </div>
                            <!-- end message section --> <!-- end deadline section -->

                            <?php if(in_array($designation_id, [5,7])): ?>
                            <div class="col-lg-6 col-xs-12 col-sm-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption">
                                            <i class="icon-bubbles font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase">Estimate Price</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body" style="height: 250px; overflow-y: scroll;">
                                        <div class="tab-content" id="estimate_price_div">
                                            <!-- BEGIN: Comments -->
                                            <div class="mt-comments">
                                                <?php foreach ($estimate_price_notification as $key): ?>
                                                <div class="mt-comment">
                                                    <div class="mt-comment-body">
                                                        <div class="mt-comment-info">
                                                            <a href="<?= site_url('projects/project_details/'.$key->project_id)?>">
                                                                <span class="mt-comment-author"><?= 'J'.$key->project_id.' '.$key->title?></span>
                                                            </a>
                                                            <span class="mt-comment-date">Added at <?= date_convert(date('d-m-Y H:i:s', strtotime($key->track_added)), 'd M, Y h:i A');  ?></span>
                                                        </div>
                                                        <div class="mt-comment-text">  </div>
                                                        <div class="mt-comment-details">
                                                            <span class="mt-comment-status mt-comment-status-pending">
                                                                <span class="text-success">
                                                                    <b>Estimate price - <?php echo $key->estimated_price ?></b>
                                                                </span>
                                                            </span>
                                                            <ul class="mt-comment-actions">
                                                                <li>
                                                                    <a class="seen_estimate_price_btn" data-id="<?php echo $key->project_tracking_history_id ?>">Seen</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end message section --> 
                            </div>
                            <?php endif; ?>


                            <?php if ($client_approval) : ?>
                            <!-- description history section -->
                            <div class="col-lg-6 col-xs-12 col-sm-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption">
                                            <i class="icon-bubbles font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase">Projects Description History</span>
                                        </div>
                                        <!-- <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#portlet_comments_1" data-toggle="tab"> Pending </a>
                                            </li>
                                            <li>
                                                <a href="#portlet_comments_2" data-toggle="tab"> Approved </a>
                                            </li>
                                        </ul> -->
                                    </div>
                                    <div class="portlet-body" style="height: 300px; overflow-y: scroll;">
                                        <div class="tab-content" id="description_history_div">
                                            <div class="loader_container"><div class="loader"></div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end description history section -->
                            <?php endif; ?>

                            <!-- estimate project -->
                            <?php if(in_array($designation_id, [1,6])): ?>
                            <div class="col-lg-6 col-xs-12 col-sm-12">
                                <div class="portlet light bordered estimate_div">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption">
                                            <i class="icon-bubbles font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase">Estimated Project</span>
                                        </div>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#estimate_requests" data-toggle="tab" aria-expanded="true"> Estimate Requests </a>
                                            </li>
                                            <li class="">
                                                <a href="#estimate_status" id="estimate_status_btn" data-toggle="tab" aria-expanded="false"> Estimate status </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="portlet-body" style="height: 300px;">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="estimate_requests">
                                                <div class="loader_container"><div class="loader"></div></div>
                                            </div>
                                            <div class="tab-pane" id="estimate_status">
                                                <div class="loader_container"><div class="loader"></div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end estimate project -->
                            <?php endif; ?>
                            
                            <!-- cad status section -->
                            <?php if(in_array($designation_id, [1,6,8])): ?>
                            <div class="col-lg-6 col-xs-12 col-sm-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption">
                                            <i class="icon-bubbles font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase">Cad status</span>
                                        </div>
                                        <!-- <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#portlet_comments_1" data-toggle="tab"> Pending </a>
                                            </li>
                                            <li>
                                                <a href="#portlet_comments_2" data-toggle="tab"> Approved </a>
                                            </li>
                                        </ul> -->
                                    </div>
                                    <div class="portlet-body" style="height: 300px; overflow-y: scroll;">
                                        <div class="tab-content" id="cad_progression_div">
                                            <div class="loader_container"><div class="loader"></div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption">
                                            <i class="icon-bubbles font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase">Alerted Projects</span>
                                        </div>
                                        <!-- <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#portlet_comments_1" data-toggle="tab"> Pending </a>
                                            </li>
                                            <li>
                                                <a href="#portlet_comments_2" data-toggle="tab"> Approved </a>
                                            </li>
                                        </ul> -->
                                    </div>
                                    <div class="portlet-body" style="height: 300px; overflow-y: scroll;">
                                        <div class="tab-content" id="alerted_projects_div">
                                            <div class="loader_container"><div class="loader"></div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <!-- cad status section -->

                            <!-- cad calender section -->
                            <?php if (in_array($designation_id, [9])) : ?>
                            <div class="col-lg-12 col-xs-12 col-sm-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption">
                                            <i class="icon-bubbles font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase">Cad dates & 3d print dates</span>
                                        </div>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#cad_dates_tab" data-toggle="tab" aria-expanded="true"> Cad dates </a>
                                            </li>
                                            <li class="">
                                                <a href="#cad_3d_print_date_tab" data-toggle="tab" aria-expanded="false"> Printing dates </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="portlet-body" style="overflow: auto">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="cad_dates_tab" >
                                               <div id="cad_dates_calendar"></div>
                                            </div>
                                            <div class="tab-pane" id="cad_3d_print_date_tab">
                                               <div id="cad_3d_print_dates_calendar"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <!-- end cad calender section -->

                        </div>
                        
                       
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <?php include 'inc/footer.php'; ?>
            <!-- END FOOTER -->
        </div>

        
        
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url();?>assets/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/horizontal-timeline/horizontal-timeline.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>

     

        <?php if (in_array($designation_id, [9])) : ?>
        <script src='<?php echo base_url('assets/fullcalendar/packages/core/main.js')?>'></script>
        <script src='<?php echo base_url('assets/fullcalendar/packages/interaction/main.js')?>'></script>
        <script src='<?php echo base_url('assets/fullcalendar/packages/daygrid/main.js')?>'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.26/moment-timezone-with-data.min.js" integrity="sha256-6EFCRhQs5e10gzbTAKzcFFWcpDGNAzJjkQR3i1lvqYE=" crossorigin="anonymous"></script>
        <script src='<?php echo base_url('assets/fullcalendar/packages/moment-timezone/main.min.js')?>'></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('cad_dates_calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                  height: 320,
                  plugins: [ 'interaction', 'dayGrid', 'momentTimezone'],
                  timeZone: 'America/New_York',
                  header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                  },
                  defaultDate: '<?php echo date('Y-m-d') ?>',
                  defaultView: 'dayGridWeek',
                  navLinks: true, // can click day/week names to navigate views
                  eventLimit: true, // allow "more" link when too many events
                  events: [
                   <?php foreach ($cad_slots as $key): ?>
                    <?php 
                      switch ($key->cad_progress) {
                        case 'In Progress':
                          $cad_progress_color = '#327ad5';
                          break;
                        case 'On Hold':
                          $cad_progress_color = '#e73d4a';
                          break;
                        case '3D Printing Only':
                          $cad_progress_color = '#327ad5';
                          break;
                        case 'Ready':
                          $cad_progress_color = '#27a4b0';
                          break;
                        case 'Waiting For Approval':
                          $cad_progress_color = '#f7d759';
                          break;
                      }

                    ?>
                    {
                      id: '<?php echo $key->cad_slot_id ?>',
                      title: '<?php echo ($key->slot_order == NULL ? '0' : $key->slot_order) . ' - J' . $key->project_id?>',
                      url: '<?php echo $key->project_id ?>',
                      start: '<?php echo $key->date ?>',
                      color: '<?php echo $cad_progress_color ?>'
                    },
                    <?php endforeach; ?>
                    <?php foreach ($vacations as $key): ?>
                    {
                      id: '<?php echo $key->vacation_id ?>',
                      title: 'Vacation',
                      start: '<?php echo $key->start_date ?>',
                      end: '<?php echo date('Y-m-d', strtotime($key->end_date. ' +1 day')) ?>'
                    },
                    <?php endforeach; ?>
                  ],
                  eventClick: function(info) {
                      info.jsEvent.preventDefault(); 
                      // if (info.event.reason) {
                      //   alert(info.event.reason);
                      // }
                      if(info.event.title == 'Vacation'){
                        info.jsEvent.preventDefault(); // don't let the browser navigate
                        var vacation_id = info.event.id;
                        $.ajax({
                          url: "<?php echo base_url('User_controller/vacation_details/') ?>"+vacation_id,
                          success:function(data){
                            alert(data);
                          }
                        });
                      } else{

                        var project_id = info.event.url;
                        $.ajax({
                          url: "<?php echo base_url('User_controller/cad_priority_check/') ?>"+project_id,
                          // dataType: 'json',
                          success:function(data){
                            if(data === 'zero'){
                                window.open("<?php echo base_url('projects/project_details/') ?>"+project_id, '_blank');
                            } else if(data == 'You can start working this job.') {
                                swal({
                                  text: data,
                                  buttons: true,
                                  buttons: ["Ok", "Go to project"],
                                })
                                .then((willDelete) => {
                                  if (willDelete) {
                                        window.open("<?php echo base_url('projects/project_details/') ?>"+project_id, '_blank');
                                  } else {
                                  }
                                });
                            } else{
                                swal(data);
                            }
                          }
                        });
                      }
                  }
                });

                calendar.render();
              });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('cad_3d_print_dates_calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                  height: 320,
                  plugins: [ 'interaction', 'dayGrid' ],
                  header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                  },
                  defaultDate: '<?php echo date('Y-m-d') ?>',
                  defaultView: 'dayGridWeek',
                  navLinks: true, // can click day/week names to navigate views
                  eventLimit: true, // allow "more" link when too many events
                  events: [
                   <?php foreach ($cad_3d_print_date as $key): ?>
                    {
                      id: '<?php echo $key->cad_3d_print_date_id ?>',
                      title: '<?php echo 'J'.$key->project_id ?>',
                      url: '<?php echo base_url('projects/project_details/'.$key->project_id) ?>',
                      start: '<?php echo $key->date ?>'
                    },
                    <?php endforeach; ?>
                  ]
                });

                calendar.render();
              });
        </script>
        <?php endif; ?>


        <?php if(in_array($designation_id, [1])): ?>
        <?php if(!empty($estimate_status) && !get_cookie('remind_me_later')): ?>
        <script>
            swal("You have estimate status", {
              buttons: {
                cancel: "Ok!",
                catch: {
                  text: "Remind me later",
                  value: "later",
                }
              },
            })
            .then((value) => {
              switch (value) {
                case "later":
                  remind_me_later();
                  break;
                default:
                  scroll_to_estimate();
                  break;
              }
            });

            function remind_me_later(){
                $.ajax({
                    url: "<?php echo base_url('Project_controller/remind_me_later') ?>",
                    success:function(data){
                        // alert(data);
                    }
                });
            }


            function scroll_to_estimate(){
                $('.estimate_div').css({"box-shadow": "0 4px 8px 0 rgba(0,0,0,0.2)"});
                $('#estimate_status_btn').trigger('click');
                $('html, body').animate({
                    scrollTop: $(".estimate_div").offset().top - 120
                }, 2000);

            }
        
        </script>
        <?php endif; ?>
        <?php endif; ?>


        <?php if (in_array($designation_id, [5,7])) : ?>
        <script>
            $(document).ready(function () {
                setTimeout(function(){
                    $.ajax({
                        url: "<?php echo base_url('Project_controller/get_alerted_projects') ?>",
                        dataType: 'json',
                        success:function(data){
                            if(data.length != 0){
                                var i;
                                var strAr = [];
                                for (i = 0; i < data.length; i++) {
                                    strAr[i] = "J"+data[i];
                                }

                                var str = strAr.join(', ');

                                swal("This job is needed attention - "+str, {
                                    buttons: {
                                        go: {
                                          text: "Go to project",
                                          value: "go",
                                        },
                                        ignore: {
                                          text: "Ignore",
                                          value: "ignore",
                                        }
                                    },
                                })
                                .then((value) => {

                                    switch (value) {
                                        case "go":
                                            for (i = 0; i < data.length; i++) {
                                                window.open('<?php echo base_url('projects/project_details/') ?>'+data[i]);
                                            }
                                          break;
                                        case "ignore":
                                          break;
                                    }
                                });
                            }
                        }
                    });
                }, 3000);
            });
        </script>
        <?php endif; ?>


        <!-- seen script -->
        <script>
            $(document).on('click', '.seen_msg', function(e){
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: "<?php echo base_url('Project_controller/seen_project_msg/')?>"+"/"+id,
                    success:function(data){
                        msg_load();
                        // $("#message_tab").load(location.href + ' #message_tab');
                    }
                });
            });
            $(document).on('click', '.seen_reply', function(e){
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: "<?php echo base_url('Project_controller/seen_project_reply/')?>"+"/"+id,
                    success:function(data){
                        // $("#reply_tab").load(location.href + ' #reply_tab');
                        replies_load();
                    }
                });
            });
       

            $(document).on('click', '.estimate_requests_seen_btn', function(e){
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: "<?php echo base_url('Project_controller/estimate_requests_seen/')?>"+"/"+id,
                    success:function(data){
                        // $("#estimate_requests").load(location.href + ' #estimate_requests');
                        estimate_request_load();
                    }
                });
            });

            $(document).on('click', '.estimate_status_seen_btn', function(e){
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: "<?php echo base_url('Project_controller/estimate_status_seen/')?>"+"/"+id,
                    success:function(data){
                        // $("#estimate_status").load(location.href + ' #estimate_status');
                        estimate_status_load();
                    }
                });
            });

            $(document).on('click', '.seen_estimate_price_btn', function(e){
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: "<?php echo base_url('Project_controller/seen_estimate_price_track/')?>"+"/"+id,
                    success:function(data){
                        $("#estimate_price_div").load(location.href + ' #estimate_price_div');
                    }
                });
            });

            $(document).on('click', '.seen_cad_progession', function(e){
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: "<?php echo base_url('Project_controller/seen_cad_progession/')?>"+"/"+id,
                    success:function(data){
                        cad_status_load();
                        // $("#cad_progression_div").load(location.href + ' #cad_progression_div');
                    }
                });
            });
        </script>
        <!-- end seen script -->

        
        <!-- fast loading srcipt -->
        <script>
			$(document).on('click', '.nav-tabs #a_inactive_project', function(e){
				inactive_projects_load();
			});
          
            function deadline_projects_load(){
                $.ajax({
                    url: "<?php echo base_url('Project_controller/get_all_dealine_projects/') ?>",
                    success:function(data){
                        $("#deadline_projects_comments").html(data);
                        $("#deadline_projects_comments .loader_container").remove();

                    }
                })
            }


            function msg_load(){
                $.ajax({
                    url: "<?php echo base_url('Project_controller/get_all_message/') ?>",
                    success:function(data){
                        $("#message_tab").html(data);
                        $("#message_tab .loader_container").remove();
                        replies_load();
                    }
                })
            }


            function replies_load(){
                $.ajax({
                    url: "<?php echo base_url('Project_controller/get_all_replies/') ?>",
                    success:function(data){
                        $("#reply_tab").html(data);
                        $("#reply_tab .loader_container").remove();
						deadline_projects_load();
						description_history_load();
                    }
                })
            }


            function description_history_load(){
                $.ajax({
                    url: "<?php echo base_url('Project_controller/get_all_description_history/') ?>",
                    success:function(data){
                        $("#description_history_div").html(data);
                        $("#description_history_div .loader_container").remove();
    
                        <?php if(in_array($designation_id,[1,6,8])): ?>

                        estimate_status_load();
                        estimate_request_load();
                        cad_status_load();
                        alerted_projects_load();
                        
                        <?php endif; ?>
                    }
                })
            }


            function estimate_request_load(){
                $.ajax({
                    url: "<?php echo base_url('Project_controller/get_estimate_requests/') ?>",
                    success:function(data){
                        $("#estimate_requests").html(data);
                        $("#estimate_requests .loader_container").remove();
                    }
                })
            }


            function estimate_status_load(){
                $.ajax({
                    url: "<?php echo base_url('Project_controller/get_estimate_status/') ?>",
                    success:function(data){
                        $("#estimate_status").html(data);
                        $("#estimate_status .loader_container").remove();
                    }
                })
            }


            function cad_status_load(){
                $.ajax({
                    url: "<?php echo base_url('Project_controller/get_cad_status/') ?>",
                    success:function(data){
                        $("#cad_progression_div").html(data);
                        $("#cad_progression_div .loader_container").remove();
                    }
                })
            }


            function alerted_projects_load(){
                $.ajax({
                    url: "<?php echo base_url('Project_controller/get_alerted_projects_by_ajax/') ?>",
                    success:function(data){
                        $("#alerted_projects_div").html(data);
                        $("#alerted_projects_div .loader_container").remove();
                    }
                })
            }


            <?php if(in_array($designation_id, [1,6,8])): ?>

            function inactive_projects_load(){
                $.ajax({
                    beforeSend:function(){
                        $("#portlet_comments_2").
                        append('<div class="loader_container"><div class="loader"></div></div>');
                    },
                    url: "<?php echo base_url('Project_controller/get_all_inactiveprojects/') ?>",
                    success:function(data){
                        $("#portlet_comments_2").html(data);
                        $("#portlet_comments_2 .loader_container").remove();

                        // deadline_projects_load();
                        // description_history_load();
                        // msg_load();
                    }
                })
            }
            <?php elseif(in_array($designation_id, [9,10])): ?>

            deadline_projects_load();
            description_history_load();


            <?php endif; ?> 


            <?php if ($client_approval) : ?>
            $(window).on('load', function() {
                $.ajax({
                    url: "<?php echo base_url('Project_controller/get_all_proposal_projects/') ?>",
                    success:function(data){
                        $("#portlet_comments_1").html(data);
                        $("#portlet_comments_1 .loader_container").remove();
                        msg_load();

                        // inactive_projects_load();
                    }
                })
            });

            <?php else: ?>
            msg_load();
            // deadline_projects_load();

            <?php endif; ?>        
        </script>
        <!-- end fast loading srcipt -->

    </body>

</html>