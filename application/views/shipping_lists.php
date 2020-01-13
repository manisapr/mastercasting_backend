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
                                    <a href="#">Projects</a>
                                </li>
                               
                            </ul>
                            <div class="page-toolbar">
                               
                            </div>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(2))); ?>
                            <small>managed datatable samples</small>
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
                                            <span class="caption-subject bold uppercase"> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(2))); ?> Table</span>
                                        </div>
                                      <!-- <div class="actions">
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
                                                <!-- <div class="col-md-6">
                                                    <form action="<?php echo base_url('projects/shipping_list/') ?>" method="GET">
                                                    <div class="btn-group">
                                                            <select name="sort_by" id="" class="form-control" onchange="this.form.submit()">
                                                                <option value="">Sort by</option>
                                                                <option value="indi" <?php echo $this->input->get('sort_by') == 'indi' ? 'selected' : '' ?>>Individual</option>
                                                                <option value="comp" <?php echo $this->input->get('sort_by') == 'comp' ? 'selected' : '' ?>>Company</option>
                                                            </select>
                                                    </div>
                                                    <div class="btn-group">
                                                        <?php if (isset($indi_list)): ?>
                                                        <select name="indi" id="" class="form-control user_list_options" onchange="this.form.submit()">
                                                            <option value="">Select Individual</option>
                                                            <?php foreach ($indi_list as $key): ?>
                                                            <option value="<?php echo $key->id ?>" <?php echo $this->input->get('indi') == $key->id ? 'selected' : '' ?>><?php echo $key->name ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?php elseif (isset($comp_list)): ?>
                                                        <select name="comp" id="" class="form-control user_list_options" onchange="this.form.submit()">
                                                            <option value="">Select Company</option>
                                                            <?php foreach ($comp_list as $key): ?>
                                                            <option value="<?php echo $key->company_id ?>" <?php echo $this->input->get('comp') == $key->company_id ? 'selected' : '' ?>><?php echo $key->company_name ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?php endif; ?>
                                                    </div>
                                                    </form>
                                                </div> -->
                                                <div class="col-md-8">
                                                </div>
                                                <div class="col-md-4" style="text-align: end;">
                                                    <div class="btn-group total_rate">
                                                    </div>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-circle green get_total_rate_btn" type="submit" form="shipping_frm">Get Total Rate</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="" id="shipping_frm" method="POST">
                                        <table class="table table-condensed table-bordered table-hover table-checkable order-column" id="example">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                    <th> Job </th>
                                                    <th> Po </th>
                                                    <th> Client </th>
                                                    <th> Ship Address </th>
                                                    <th> Country </th>
                                                    <th> Tracking Id </th>
                                                    <th> Ship Type </th>
                                                    <th> Ship Method </th>
                                                    <th> Shipped </th>
                                                    <th> Rate </th>
                                                    <th> Details </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($projects as $key): ?>
                                                <tr>
                                                    <td>
                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                            <input type="checkbox" name="project_id[]" class="checkboxes" value="<?php echo $key->project_id ?>"
                                                            <?php echo $key->is_shipped == 0 ? 'disabled' : '' ?> />
                                                            <span></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <?php echo $key->title ?> 
                                                        <?php if($key->is_api_injected == 1): ?>
                                                        <i class="fas fa-cogs font-purple-studio"></i>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo $key->po ?></td>
                                                    <td><?php echo $key->name ?>  (<?php echo $key->company_name ?>)</td>
                                                    <td>
                                                        <?php if($key->address != ''): ?>
                                                        <?php echo $key->address ?>, <br>
                                                        <?php echo $key->city ?>, 
                                                        <?php echo $key->region ?> - 
                                                        <?php echo $key->postal_code ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo $key->country ?></td>
                                                    <td>
                                                        <?php if($key->is_shipped == 1): ?>
                                                        <?php echo $key->tracking ?> <a href="https://www.fedex.com/apps/fedextrack/index.html?action=track&tracknumbers=<?php echo $key->tracking ?>" class="fas fa-external-link-alt font-blue" style="text-decoration: none" target="_blank"></a></td>
                                                        <?php endif; ?>
                                                    <td><?php echo $key->shipping_type ?></td>
                                                    <td><?php echo $key->shipping_method ?></td>
                                                    <td style="text-align: center;">
                                                        <?php if($key->is_shipped == 1): ?>
                                                        <span class="badge badge-success">Yes</span>
                                                        <?php else: ?>
                                                        <span class="badge badge-danger">No</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($key->is_shipped == 1): ?>
                                                        $<?php echo $key->rate ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <a href="<?php echo base_url('projects/project_details/'.$key->project_id) ?>" class="badge badge-info">J <?php echo $key->project_id ?></a>
                                                        <?php if($key->is_shipped == 1): ?>
                                                        <?php if($key->manual == 0): ?>
                                                        <br>
                                                        <a class="fas fa-print font-blue-hoki" class="fancybox" data-fancybox-type="iframe" href="<?php echo base_url('uploads/fedex/shipping_label/'.$key->file)?>" target="_blank"></a>
                                                        <?php endif; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        </form>
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

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" integrity="sha256-nbyata2PJRjImhByQzik2ot6gSHSU4Cqdz5bNYL2zcU=" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
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
            $('.user_list_options').select2({
                theme: "bootstrap"
            });
        </script>

        <script>
            $(document).on('submit', '#shipping_frm', function(e){
                e.preventDefault();
                var form = $(this).serialize();
                $.ajax({
                    url: "<?php echo base_url('Project_controller/get_total_rate/') ?>",
                    data: form,
                    type: 'post',
                    success:function(data){
                        if(data == 'empty'){
                            swal("Please select projects");
                        } else{
                            $('.total_rate').html('<span class="badge badge-info pull-right"><b>Total Rate = $'+data+'</b></span>');
                        }
                    }
                });
            });
        </script>
    </body>

</html>