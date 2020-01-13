<?php //print_r($projects);die; ?>
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
                                    <a href="#">Dispositions</a>
                                </li>
                               
                            </ul>
                            <div class="page-toolbar">
                               
                            </div>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                       <!--  <h1 class="page-title"> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(2))); ?>
                            <small>managed datatable samples</small>
                        </h1> -->
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject bold uppercase">Disposition Table</span>
                                        </div>
                                       <!--  <div class="actions">
                                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                                                <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                                    <input type="radio" name="options" class="toggle" id="option1">My Clients</label>
                                                <label class="btn btn-transparent dark btn-outline btn-circle btn-sm  active">
                                                    <input type="radio" name="options" class="toggle" id="option2">All</label>
                                                <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                                    <input type="radio" name="options" class="toggle" id="option2">My Jobs</label>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-toolbar">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-circle sbold green" data-toggle="modal" data-target="#myModal">Add Disposition</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-condensed table-bordered table-hover table-checkable order-column" id="example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th> Name </th>
                                                    <th style="text-align: center;"> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; foreach ($disposition as $key) : ?>
                                                <tr>
                                                    <td><?php echo $i ?></td>
                                                    <td><?php echo $key->name ?></td>
                                                    <td style="text-align: center;"><a class="badge badge-danger delete_disposition" data-id='<?php echo $key->disposition_id ?>'>delete</a></td>
                                                </tr>
                                                <?php $i++; endforeach;  ?>
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

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
              </div>
              <div class="modal-body">
                <form method="POST" action="<?php echo base_url('Project_controller/add_disposition_indi') ?>">
                    <div class="form-group">
                        <input type="text" name="disposition[name]" class="form-control">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-circle btn-derfault">Add</button>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

        <script>
            $(document).on('click', '.delete_disposition', function(e){
                e.preventDefault();
                var id = $(this).data('id');
                swal({
                  title: "Are you sure?",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    $.ajax({
                        url: "<?php echo base_url('Project_controller/delete_disposition_indi')?>"+"/"+id,
                        success:function(data){
                            swal("One disposition deleted.")
                            .then((value) => {
                                location.reload();
                            });
                        }
                    });
                  }
                });
            });
        </script>

        <?php if($this->session->flashdata('disposition')): ?>
        <script>
            swal('Disposition Added');
        </script>
        <?php endif; ?>
    </body>

</html>