        <!-- BEGIN HEADER -->
        <?php include 'inc/header.php'; ?>
        <?php $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id; ?>
        <style>
            .list-group-item{
                border: 1px solid rgba(0,0,0,.125) !important;
            }
        </style>
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
                            <li> <a href="<?php echo base_url() ?>">Home</a> <i class="fa fa-circle"></i> </li>
                            <li> <span>Member Details</span> </li>
                        </ul>
                    </div>
                    <!-- END PAGE BAR -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-dark"> 
                                        <i class="icon-briefcase font-dark"></i> 
                                        <span class="caption-subject bold uppercase">Member Details</span> 
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="control-label col-md-2">Name</label>
                                            <div class="col-md-8">
                                                <input type="text" name="name" data-required="1" class="form-control" value="<?= $member_details->name ?>" disabled=""> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2">Email</label>
                                            <input type="hidden" name="id" class="form-control" value="1">
                                            <div class="col-md-8">
                                                <input type="text" name="name" data-required="1" class="form-control" value="<?= $member_details->email ?>" disabled=""> 
                                            </div>
                                        </div>
                                        <?php if(in_array($designation_id, [1])): ?>
                                        <form method="POST" action="<?php echo base_url('User_controller/update_designation/'.$member_details->id) ?>">
                                        <div class="form-group">
                                            <label class="control-label col-md-2">Designation</label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="designation_id" id="designation_select">
                                                    <?php foreach ($designations as $key): ?>
                                                    <option value="<?php echo $key->designation_id ?>" <?php echo $member_details->designation_id == $key->designation_id ? 'selected' : '' ?>><?php echo $key->designation_name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-2"></div>
                                            <dib class="col-md-8"><button class="btn btn-circle green-meadow" id="save_des_btn">Save</button></dib>
                                        </div>
                                        
                                        <?php if(in_array($designation_id, [1])): ?>
                                        <div class="form-group">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <a href="<?php echo base_url('resend_cred/'.$member_details->id.'/1') ?>" class="btn btn-circle green">Resend Credential</a>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        </form>
                                        <?php endif; ?>
                                            
                                        <!-- <div class="form-group">
                                            <form id="add_permission" action="">
                                                <label class="control-label col-md-2">Permissions</label>
                                                <div class="col-md-6">
                                                    <select class="form-control" name="permission[permission_id]" id="" required>
                                                        <option value="">Choose Permission Key</option>
                                                        <?php foreach ($permissions as $key) : ?>
                                                        <option value="<?= $key->permission_id?>"><?= $key->name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control" name="permission[level]" id="" required>
                                                        <option value="">Set Permission</option>
                                                        <option value="1">Allow</option>
                                                        <option value="0">Disallow</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-default">Add Permission</button>
                                                </div>
                                            </form>
                                        </div> -->
                                    </div>
                                </div>
                            </div> 

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

                                        <table class="table table-condensed" style="margin-top: 20px" id="example">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Jobs Name</th>
                                                    <th>Po</th>
                                                    <th style="text-align: center;">Cad Status</th>
                                                    <th>Deadline</th>
                                                    <th>Status</th>
                                                    <th>Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($jobs as $key): ?>
                                                <?php 
                                                switch ($key->cad_progress) {
                                                    case 'On Hold':
                                                        $cad_progress_color = '';
                                                        # code...
                                                        break;
                                                    case 'Ready':
                                                        $cad_progress_color = 'badge-success';
                                                        break;
                                                    case 'In Progress':
                                                        $cad_progress_color = 'badge-primary';
                                                        break;
                                                    case '3D Printing Only':
                                                        $cad_progress_color = 'badge-primary';
                                                        break;
                                                    
                                                }
                                                ?>
                                                <tr style="cursor: pointer;" onclick="window.location='<?php echo base_url('projects/project_details/'.$key->project_id);?>'">
                                                    <td>
                                                        <a class="badge badge-success" href="">J<?php echo $key->project_id ?></a>
                                                    </td>
                                                    <td><?php echo $key->project_name ?></td>
                                                    <td><?php echo $key->po ?></td>
                                                    <td style="text-align: center"><span class="badge <?php echo $cad_progress_color ?>"><?php echo $key->cad_progress ?></span></td>
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
                            <!-- <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-dark"> 
                                        <i class="icon-briefcase font-dark"></i> 
                                        <span class="caption-subject bold uppercase">Permissions</span> 
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <ul class="list-group permission_list">
                                        <?php foreach ($user_permissions as $key) : ?>
                                        <li class="list-group-item <?= $key->level == '1' ? 'list-group-item-success' : 'list-group-item-danger' ?>"><?= $key->name ?><a href="<?= base_url('Master_controllers/delete_permission/'. $key->user_permission_id) ?>" class="badge badge-pill delete_permission">&times;</a> <span class="badge <?= $key->level == '1' ? 'badge-success' : 'badge-danger' ?> badge-pill"><?= $key->level == '1' ? 'Allowed' : 'Disallowed' ?></span></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div> -->
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php include 'inc/footer.php'; ?>
        <!-- END FOOTER -->
    </div>

    <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url();?>assets/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript"></script>
        <!-- <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js" type="text/javascript"></script> -->
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/vendor/load-image.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-audio.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-video.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url();?>/assets/assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/pages/scripts/form-fileupload.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        
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

        <!-- add permissions -->
        <script>
            $(function(){
                $(document).on('submit','#add_permission',function(e){
                    e.preventDefault();
                    var form = $(this).serialize();

                    $.ajax({
                        url: "<?= site_url('Master_controllers/add_permission') ?>",
                        data: form,
                        type: 'post',
                        success:function(data){
                            $('.permission_list').html(data);
                            // $("#msg_tbody").html(data);
                            // $("input[name='msg']").val('');
                            // $("[name='msg_to']").val('');
                        }
                    });
                });
                $(document).on('click', '.delete_permission', function(e){
                    e.preventDefault();
                    var url = $(this).attr("href");
                    $.ajax({
                        url: url,
                        success:function(data){
                            $('.permission_list').html(data);
                        }
                    });

                });

                $('#save_des_btn').hide();
                $(document).on('click', '#designation_select', function(data){
                    $('#save_des_btn').show();
                });
            });
        </script>

        <?php if($this->session->flashdata('resend_cred')): ?>
        <script>
            swal("Credentails sent");
        </script>
        <?php $this->session->unset_userdata('resend_cred'); endif; ?>

        <!-- <?php if ($this->session->flashdata('update_des')): ?>
        <script>
            swal('User designation updated');
        </script>
        <?php $this->session->unset_userdata('update_des'); endif;  ?> -->

</body>

</html>