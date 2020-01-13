<!-- BEGIN HEADER -->
<?php $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id; ?>
<?php include 'inc/header.php'; ?>
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
                        <a href="#">Trade Clients</a>
                    </li>
                </ul>
                <div class="page-toolbar">
                    
                </div>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <!-- <h1 class="page-title">Trade Clients</h1> -->
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">Trade Clients Table</span>
                            </div>
                        </div>
                        
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-2">
                                        <select name="" class="form-control" id="user_action">
                                            <option value="" selected="">Select Option</option>
                                            <option value="approve">Approve</option>
                                            <option value="hold">On Hold</option>
                                            <?php if(!in_array($designation_id, [6,8])): ?>
                                            <option value="delete">Delete</option>
                                            <option value="deny_not_enough_info">Deny not enough info</option>
                                            <option value="deny_try_again">Deny try again</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <div class="btn-group">
                                            <a href="<?php echo site_url('create/trade')?>" class="btn btn-circle green"> Add Trade Client </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form id="user_action_form" action="<?php echo base_url('User_controller/user_action')?>">
                            <table id="example" class="table table-striped table-bordered table-hover table-checkable order-column">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th> Name </th>
                                        <th> Company Name </th>
                                        <th> Contact No </th>
                                        <th> Mail id </th>
                                        <th> Representative </th>
                                        <th style="text-align: center;"> Status </th>
                                        <th style="text-align: center;"> Client Id </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; foreach ($user as $key): ?>
                                    <?php $i++; ?>
                                    <tr>
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="checkboxes" name="user_id[]" value="<?php echo $key->id ?>" require/>
                                                <span></span>
                                            </label>
                                        </td>
                                        <td onclick="window.location='<?= site_url('details/trade/'.$key->id)?>';" style='cursor:pointer'><?php echo $key->company_name.' ('.$key->name.')' ?></td>
                                        <td onclick="window.location='<?= site_url('details/trade/'.$key->id)?>';" style='cursor:pointer'><?php echo $key->company_name ?></td>
                                        <td><a href="tel:<?php echo $key->phone ?>"><?php echo $key->phone ?></a></td>
                                        <td><a href="mailto:<?php echo $key->email ?>"><?php echo $key->email ?></a></td>
                                        <td><?php echo $key->representative != '' ? $this->db->get_where('user', ['id' => $key->representative])->row()->name : '' ?></td>
                                        <td style="text-align: center;">
                                            <?php if($key->permission == 1): ?>
                                            <span class="badge badge-primary">Approved</span>
                                            <?php else: ?>
                                            <span class="badge badge-secondary">On Hold</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <a class="badge badge-success" href="<?php echo site_url('details/trade/'.$key->id)?>">C<?php echo $key->dynamic_id?></a>
                                            <!-- <a href="<?php echo site_url('details/trade/'.$key->id)?>" class="btn btn-link">Edit</a> <button class="btn btn-link delete_user" value="<?php echo $key->id?>">Delete</button> -->
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
            $('#example').DataTable();
        } );
    </script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).on('click' ,'.delete_user', function(e){
            e.preventDefault();
            var user_id = $(this).val();
            swal({
              title: "Are you sure?",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                window.location.href = "<?php echo base_url('User_controller/delete_trade_client/') ?>"+user_id;
              }
            });
        })
    </script>

    <script>
        $(document).on('change', '#user_action', function(){
            var action = $(this).val();
            var chkArray = [];

            $(".checkboxes:checked").each(function() {
                chkArray.push($(this).val());
            });
            var selected;
            selected = chkArray.join(',') ;

            if(selected.length > 0){
                swal({
                  title: "Are you sure?",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    var form = $("#user_action_form").serialize();
                    var action = $(this).val();
                    if(action == "hold"){
                        $.ajax({
                            url: "<?php echo base_url('User_controller/user_hold_action')?>",
                            data: form,
                            type: 'post',
                            success:function(data){
                                swal('User updated');
                            }
                        });
                    }
                    else if(action == "delete"){
                        $.ajax({
                            url: "<?php echo base_url('User_controller/user_delete_action')?>",
                            data: form,
                            type: 'post',
                            success:function(data){
                                swal({
                                  title: "User deleted",
                                })
                                .then((willDelete) => {
                                  if (willDelete) {
                                        location.reload();
                                    }
                                });
                            }
                        });
                    }
                    else if(action == "approve"){
                        $.ajax({
                            url: "<?php echo base_url('User_controller/user_approve_action')?>",
                            data: form,
                            type: 'post',
                            success:function(data){
                                swal({
                                  title: "User approved",
                                })
                                .then((willDelete) => {
                                  if (willDelete) {
                                        location.reload();
                                    }
                                });
                            }
                        });
                    }
                    else if(action == "deny_not_enough_info"){
                        $.ajax({
                            url: "<?php echo base_url('User_controller/user_deny_not_enough_info_action')?>",
                            data: form,
                            type: 'post',
                            success:function(data){
                                swal({
                                  title: "User deleted",
                                })
                                .then((willDelete) => {
                                  if (willDelete) {
                                        location.reload();
                                    }
                                });
                            }
                        });
                    }
                    else if(action == "deny_try_again"){
                        $.ajax({
                            url: "<?php echo base_url('User_controller/user_deny_try_again_action')?>",
                            data: form,
                            type: 'post',
                            success:function(data){
                                swal({
                                  title: "User deleted",
                                })
                                .then((willDelete) => {
                                  if (willDelete) {
                                        location.reload();
                                    }
                                });
                            }
                        });
                    }
                  }
                });
            }else{
                swal("You havn't selected any user"); 
                $('#user_action option:selected').removeAttr('selected');
            }
        });
    </script>
    
</body>
</html>