
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
                                <a href="#">Members</a>
                            </li>
                        </ul>
                        <div class="page-toolbar">
                            
                        </div>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h1 class="page-title"> Team Members     
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
                                        <span class="caption-subject bold uppercase"> Managed Table
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided">
                                            <a class="btn btn-transparent blue btn-outline btn-circle btn-sm active" href="<?php echo site_url('all_team_members');?>">All</a>
                                            <a class="btn btn-transparent blue btn-outline btn-circle btn-sm" href="<?php echo site_url('all_manager');?>">Manager</a>
                                            <a class="btn btn-transparent blue btn-outline btn-circle btn-sm" href="<?php echo site_url('all_sales_rep');?>">Sales Rep</a>
                                            <a class="btn btn-transparent blue btn-outline btn-circle btn-sm" href="<?php echo site_url('all_cad');?>">Cad Team</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="btn-group">
                                                    <button id="sample_editable_1_new" class="btn btn-circle sbold green" data-toggle="modal" data-target="#exampleModalLong3"> Add Member <i class="fa fa-plus"></i> </button>
                                                    <?php if(!in_array($designation_id, [6,8])): ?>
                                                    <button style="margin-left: 10px" class="btn btn-circle sbold green" form="delete_member"> Delete Member </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form id="delete_member" method="POST">
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                            <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                                            <span></span>
                                                        </label>
                                                    </th>
                                                    <th> Name </th>
                                                    <th style="text-align: center;"> Role </th>
                                                    <th> Contact No </th>
                                                    <th> Mail id </th>
                                                    <th style="text-align: center;"> Permission </th>
                                                    <th style="text-align: center;"> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; foreach($members as $key): ?>
                                                <tr>
                                                    <td>
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox"  name="user_id[]" class="checkboxes" value="<?php echo $key->id?>" /> <span></span> </label>
                                                    </td>
                                                    <td>
                                                        <?php echo $key->name;?>
                                                    </td>
                                                    <td style="text-align: center;"> <span class="badge badge-info"><?php echo $key->designation_name?></span> </td>
                                                    <td> <a href="tel:<?php echo $key->phone;?>"><?php echo $key->phone;?></a> </td>
                                                    <td> <a href="mailto:<?php echo $key->email;?>"><?php echo $key->email;?></a> </td>
                                                    <td style="text-align: center;">
                                                        <?php //echo $key->permission == 1 ? 'On' : 'Off' ?>
                                                        <!-- Default checked -->
                                                        <input class="prm_check" value="<?php echo $key->id ?>" <?php echo $key->permission == 1 ? 'checked' : '' ?> type="checkbox" data-toggle="toggle" data-size="mini">
                                                    </td>
                                                    <!-- Edit and delete user-->
                                                    <td style="text-align: center;"><a href="<?= site_url('member_details/'.$key->id)?>" class="badge badge-success">Details</a></td>
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
  
    <div class="modal fade signup_pop" id="exampleModalLong3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> </button>
                    <h4 class="modal-title">Add Member</h4>
                </div>
                <div class="modal-body">
                    <form  method="post" action="<?php echo site_url('Master_controllers/insert_user');?>" >
                    
                        <?php $rand_pass = substr(base64_encode(mt_rand()), 0, 10); //Rand password Code Gen ?>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Name</label>
                            <input class="form-control" type="text" placeholder="Name" id="name" name="user_name" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Username</label>
                            <input class="form-control" type="text" placeholder="Username" id="name" name="user_username" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Email</label>
                            <input class="form-control" type="email" placeholder="Email Id" id="email"  name="email" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Phone</label>
                            <input class="form-control" type="phone" placeholder="Phone No." id="phone" name="phone" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Designation</label>
                            <select class="form-control" name="sample_1_length" aria-controls="sample_1" class="form-control input-sm input-xsmall input-inline">
                                <option selected disabled="">Select Designation</option>
                                <option value="1">Admin</option>
                                <!-- <option value="2">Designing</option> -->
                                <!-- <option value="3">Casting</option> -->
                                <!-- <option value="4">Packing</option> -->
                                <option value="6">Manager</option>
                                <option value="8">Sales Rep</option>
                                <option value="9">Cad Team</option>
                                <option value="10">Clerk</option>
                            </select>
                        </div>
                        <div class="inv_ppl">
                            <input type="hidden" placeholder="Password" name="password" value="<?php echo $rand_pass;?>">
                        </div>
                        <div class="tabgroup">
                            <div class="pop_btn">
                                <input type="submit" class="btn blue" value="Submit"  onclick='Javascript:validedData();'>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
 
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).on('submit', '#delete_member', function(e){
            e.preventDefault();

             var action = $(this).val();
            var chkArray = [];

            $(".checkboxes:checked").each(function() {
            chkArray.push($(this).val());
            });
            var selected;
            selected = chkArray.join(',') ;

            if(selected.length > 0){
                swal({
                  title: "Are you sure want to delete?",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    $.ajax({
                        url: '<?php echo base_url('User_controller/delete_member')?>',
                        data: form,
                        type: "POST",
                        success:function(data){
                            // alert(data);
                            swal(data+" member Deleted")
                            .then((value) => {
                             location.reload();
                            });
                        }
                    })
                  }
                });
            }else{
                swal("Please at least check one of the checkbox"); 
            }

            var form = $(this).serialize();


            

        });

        $(document).on('click', '.prm_check', function(){
            var id = $(this).val();
            alert(id);
            alert('dasd');
        });
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