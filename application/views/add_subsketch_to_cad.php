            <!-- BEGIN HEADER -->
            <?php include 'inc/header.php'; ?>
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
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="index.html">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Dashboard</span>
                                </li>
                            </ul>
                            <div class="page-toolbar">
                                <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                                    <i class="icon-calendar"></i>&nbsp;
                                    <span class="thin uppercase hidden-xs"></span>&nbsp;
                                    <i class="fa fa-angle-down"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> Master Showcase
                            <!-- <small>statistics, charts, recent events and reports</small> -->
                        </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <!-- BEGIN DASHBOARD STATS 1-->
                        
                        <?php  $designation_id=$this->session->userdata('type');
                               $id = $this->session->userdata('user_id');
                                        //echo  $designation_id ;
                                            //echo $id; 
                                                ?>
                        
                        
                        
                        <div class="row">
                             <?php
                                $d=0;
                                  foreach($details as $row)
                                  {
                                    if($row->resource=="4")
                                    {
                                ?>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            
                                <div class="cbp-item graphic">
                                    <div class="cbp-caption">
                                        <div class="cbp-caption-defaultWrap">
                                            <a href="<?php echo site_url(); ?>/Master_controllers/addsubmaster?id=<?php echo $row->id; ?>">
                                            <img src="<?php echo base_url(); ?>/uploads/showcase/<?php echo $row->image; ?>" alt="">
                                            </a> </div>
                                             <div class="cbp-l-grid-projects-desc uppercase text-center uppercase text-center"><?php echo $row->name; ?></div>
                                       <!--  <div class="cbp-caption-activeWrap">
                                            <div class="cbp-l-caption-alignCenter">
                                                <div class="cbp-l-caption-body">
                                                    <a href="<?php echo site_url(); ?>/Master_controllers/edit_showcase?id=<?php echo $row->id; ?>" class="cbp-singlePage cbp-l-caption-buttonLeft btn red uppercase btn red uppercase" rel="nofollow">Edit</a>
                                                    <a class="cbp-lightbox cbp-l-caption-buttonRight btn red uppercase btn red uppercase" data-title="Dashboard<br>by Paul Flavius Nechita" id="del<?php echo $d; ?>">Delete</a>
                                                    <input type="hidden" id="id<?php echo $d; ?>" value="<?php echo $row->id; ?>">
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                  
                                   
                                </div>
                                 
                            </div>
                              <?php
                                 }
                                 
                                 ?>
            <script type="text/javascript">
            $(document).ready(function()
            {
                $('#del<?php echo $d;?>').click(function()
                {
                     var id=$('#id<?php echo $d; ?>').val();
                    swal({
                      title: "Are you sure?",
                      text: "Once deleted, you will not be able to recover this imaginary file!",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                    })
                    .then((willDelete) => {
                      if (willDelete) {
                         var url ='<?php echo site_url(); ?>/Master_controllers/delete_showcase';
                            $.ajax({
                                type: 'POST',
                                url:url,
                                data:{id:id} ,
                                dataType:'json',
                                success: function(data){
                                    swal("Poof! Your imaginary file has been deleted!", {
                                      icon: "success",
                                    });
                                     window.setTimeout(function(){window.location.reload()}, 2000);
                                   
                                }
                            });
                       
                      } else {
                        swal("Your imaginary file is safe!");
                      }
                    });

                });
            })

          
  
    
        </script>

                                 <?php
                                 $d++;
                                 }

                                ?> 
                            
                            
                           
                        </div>
                        
                        
                        
                        
                        
                        
                        
                        
                </div>
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <?php include 'inc/footer.php'; ?>
            <!-- END FOOTER -->
            </div>
        </div>

        <div class="modal fade signup_pop" id="exampleModalLong2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Name of the Project</h4>
                        <form>
                            <div class="pro_url">
                                <input type="text" placeholder="Name">
                            </div>
                            <div class="tabgroup">
                                <input class="tabgroup__item tabgroup__item--1" type="radio" id="tab1" name="tabgroup_a" checked />
                                <label class="tab tab--1" for="tab1">Our Team</label>
                                
                                <input class="tabgroup__item tabgroup__item--2" type="radio" id="tab2" name="tabgroup_a" />
                                <label class="tab tab--2" for="tab2">The Client</label>
                                <div class="panel panel--1">
                                    <h5>Invite People to you team</h5>
                                    <div class="inv_ppl">
                                        <input type="text" placeholder="">
                                    </div>
                                    <div class="inv_ppl">
                                        <input type="text" placeholder="">
                                    </div>
                                    <div class="inv_ppl">
                                        <input type="text" placeholder="">
                                    </div>
                                    <div class="price_pro">
                                        <label>Price</label> <input type="text">
                                    </div>
                                    <div class="pop_btn">
                                        <input type="submit" value="Start the project">
                                        <input type="Reset" value="Cancel">
                                    </div>
                                </div>
                                    
                                <div class="panel panel--2">
                                    <h5>Invite People to you team</h5>
                                    <div class="inv_ppl">
                                        <input type="text" placeholder="">
                                    </div>
                                    <div class="inv_ppl">
                                        <input type="text" placeholder="">
                                    </div>
                                    <div class="inv_ppl">
                                        <input type="text" placeholder="">
                                    </div>
                                    <!-- <div class="price_pro"> -->
                                        <!-- <label>Price</label> <input type="text"> -->
                                    <!-- </div> -->
                                    <div class="pop_btn">
                                        <input type="submit" value="Start the project">
                                        <input type="Reset" value="Cancel">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


        <div class="modal fade signup_pop" id="exampleModalLong3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Add Showcase</h4>
                        <form action="<?php echo site_url(); ?>/Master_controllers/addshowcase" method="post" enctype="multipart/form-data">
                            <div class="pro_url">
                                <input type="text" placeholder="Name" name="show_name">
                            </div>
                            <div class="tabgroup">
                                <input class="tabgroup__item tabgroup__item--1" type="radio" id="tab1" name="tabgroup_a" checked />
                              <!--   <label class="tab tab--1" for="tab1">Our Team</label> -->
                                
                                <input class="tabgroup__item tabgroup__item--2" type="radio" id="tab2" name="tabgroup_a" />
                              <!--   <label class="tab tab--2" for="tab2">The Client</label> -->
                                <div class="panel panel--1">
                                    <h5>Invite People to you team</h5>
                                    <div class="inv_ppl">
                                        <input type="file" name="image">
                                    </div>
                                    <div class="inv_ppl">
                                        <select name="resource">
                                            <option value="1">Master Showcase</option>
                                            <option value="2">Member Showcase</option>
                                            <option value="3">Ready-To-Print Models</option>
                                            <option value="4">Sketch to CAD</option>
                                        </select>
                                        
                                    </div>
                                  
                                   
                                    <div class="pop_btn">
                                        <input type="submit">
                                        <input type="Reset">
                                    </div>
                                </div>
                                    
                                <div class="panel panel--2">
                                 
                                    
                                    <!-- <div class="price_pro"> -->
                                        <!-- <label>Price</label> <input type="text"> -->
                                    <!-- </div> -->
                                    <div class="pop_btn">
                                        <input type="submit" value="Start the project">
                                        <input type="Reset" value="Cancel">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
       <!--  <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.min.js" type="text/javascript"></script> -->
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
    </body>

</html>